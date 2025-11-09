<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\ItemTransaksi;
use App\Models\JenisProduk;
use App\Models\Produk;
use App\Models\RiwayatStokProduk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display shopping cart page
     */
    public function index()
    {
        return view('shop-cart');
    }

    /**
     * Display checkout page
     */
    public function checkout()
    {
        // Get customer data if authenticated
        $customer = Auth::check() ? Auth::user() : null;

        return view('checkout', compact('customer'));
    }

    /**
     * Process checkout and create invoice
     */
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'cart_data' => 'required|json',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Decode cart data
            $cartData = json_decode($validated['cart_data'], true);

            if (empty($cartData)) {
                return redirect()->back()->with('error', 'Keranjang belanja kosong');
            }

            // Calculate total
            $totalBayar = 0;
            foreach ($cartData as $item) {
                $totalBayar += $item['harga'] * $item['quantity'];
            }

            // Generate invoice code
            $kodeInvoice = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Handle bukti transfer upload
            $buktiPembayaran = null;
            if ($request->hasFile('bukti_transfer')) {
                $file = $request->file('bukti_transfer');
                $filename = 'payment-' . $kodeInvoice . '-' . time() . '.' . $file->getClientOriginalExtension();

                // Create directory if not exists
                $uploadPath = public_path('uploads/payments');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Move file to public/uploads/payments
                $file->move($uploadPath, $filename);

                // Save relative path
                $buktiPembayaran = 'uploads/payments/' . $filename;
            }

            // Create invoice
            $invoice = Invoice::create([
                'kode_invoice' => $kodeInvoice,
                'tanggal' => now(),
                'customer_id' => Auth::id() ?? 1, // Use logged in user or guest ID
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
                'total_bayar' => $totalBayar,
                'status_pembayaran' => $buktiPembayaran ? 'pending' : 'pending',
                'status_pengiriman' => false,
                'bukti_pembayaran' => $buktiPembayaran,
            ]);

            // Create invoice items and update stock
            foreach ($cartData as $item) {
                $produk = Produk::find($item['id']);

                if (!$produk) {
                    throw new \Exception("Produk dengan ID {$item['id']} tidak ditemukan");
                }

                // Check if item has variant/jenis
                if (isset($item['jenis_id']) && $item['jenis_id']) {
                    // Check stock from jenis_produk
                    $jenisProduk = JenisProduk::find($item['jenis_id']);

                    if (!$jenisProduk) {
                        throw new \Exception("Varian produk tidak ditemukan");
                    }

                    if ($jenisProduk->jumlah_produk < $item['quantity']) {
                        throw new \Exception("Stok varian {$jenisProduk->nama} dari produk {$produk->nama} tidak mencukupi");
                    }

                    // Save stock before update
                    $stokAwal = $jenisProduk->jumlah_produk;

                    // Create item transaction
                    ItemTransaksi::create([
                        'invoice_id' => $invoice->id_invoice,
                        'produk_id' => $item['id'],
                        'jenis_produk_id' => $item['jenis_id'],
                        'jumlah' => $item['quantity'],
                        'subtotal' => $item['harga'] * $item['quantity'],
                    ]);

                    // Update jenis produk stock
                    $jenisProduk->decrement('jumlah_produk', $item['quantity']);

                    // Record stock history for variant
                    RiwayatStokProduk::create([
                        'produk_id' => $item['id'],
                        'jenis_produk_id' => $item['jenis_id'],
                        'tanggal' => now()->toDateString(),
                        'stok_awal' => $stokAwal,
                        'stok_masuk' => 0,
                        'stok_keluar' => $item['quantity'],
                        'stok_akhir' => $stokAwal - $item['quantity'],
                    ]);
                } else {
                    // Check stock from produk (no variant)
                    if ($produk->stok < $item['quantity']) {
                        throw new \Exception("Stok produk {$produk->nama} tidak mencukupi");
                    }

                    // Save stock before update
                    $stokAwal = $produk->stok;

                    // Create item transaction
                    ItemTransaksi::create([
                        'invoice_id' => $invoice->id_invoice,
                        'produk_id' => $item['id'],
                        'jenis_produk_id' => null,
                        'jumlah' => $item['quantity'],
                        'subtotal' => $item['harga'] * $item['quantity'],
                    ]);

                    // Update product stock
                    $produk->decrement('stok', $item['quantity']);

                    // Record stock history for main product
                    RiwayatStokProduk::create([
                        'produk_id' => $item['id'],
                        'jenis_produk_id' => null,
                        'tanggal' => now()->toDateString(),
                        'stok_awal' => $stokAwal,
                        'stok_masuk' => 0,
                        'stok_keluar' => $item['quantity'],
                        'stok_akhir' => $stokAwal - $item['quantity'],
                    ]);
                }
            }

            DB::commit();

            // Return success with invoice ID
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'invoice_id' => $invoice->id_invoice,
                'kode_invoice' => $kodeInvoice,
                'redirect_url' => route('order.confirmation', $invoice->id_invoice)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display order confirmation page
     */
    public function orderConfirmation($id)
    {
        $invoice = Invoice::with(['customer'])->findOrFail($id);
        $items = ItemTransaksi::where('invoice_id', $id)
            ->with(['produk', 'jenisProduk'])
            ->get();

        return view('order-confirmation', compact('invoice', 'items'));
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $invoice = Invoice::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = 'payment-' . $invoice->kode_invoice . '-' . time() . '.' . $file->getClientOriginalExtension();

            // Create directory if not exists
            $uploadPath = public_path('uploads/payments');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Move file to public/uploads/payments
            $file->move($uploadPath, $filename);

            // Save relative path to database
            $relativePath = 'uploads/payments/' . $filename;

            $invoice->update([
                'bukti_pembayaran' => $relativePath
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah bukti pembayaran');
    }
}
