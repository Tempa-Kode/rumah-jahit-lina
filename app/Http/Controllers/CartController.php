<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\ItemTransaksi;
use App\Models\JenisProduk;
use App\Models\Produk;
use App\Models\RiwayatStokProduk;
use App\Models\UlasanRating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // RajaOngkir Configuration
    private $rajaOngkirApiKey = 'Ez5B5zBi075316d84865ccd9nV4SQITj';
    private $rajaOngkirBaseUrl = 'https://rajaongkir.komerce.id/api/v1';
    private $originDistrict = '41140'; // Your origin district

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
            'ongkir' => 'required|numeric|min:0',
            'kurir' => 'required|string',
            'layanan_ongkir' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // Decode cart data
            $cartData = json_decode($validated['cart_data'], true);

            if (empty($cartData)) {
                return redirect()->back()->with('error', 'Keranjang belanja kosong');
            }

            // Debug log
            Log::info('Cart data received:', $cartData);

            // Calculate subtotal from cart
            $subtotal = 0;
            foreach ($cartData as $item) {
                $subtotal += $item['harga'] * $item['quantity'];
            }

            // Add shipping cost to total
            $ongkir = floatval($validated['ongkir']);
            $totalBayar = $subtotal + $ongkir;

            // Generate invoice code
            $kodeInvoice = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Handle bukti transfer upload
            $buktiPembayaran = null;

            // Create invoice with shipping information
            $invoice = Invoice::create([
                'kode_invoice' => $kodeInvoice,
                'tanggal' => now(),
                'customer_id' => Auth::id() ?? 1, // Use logged in user or guest ID
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
                'total_bayar' => $totalBayar,
                'ongkir' => $ongkir,
                'kurir' => $validated['kurir'],
                'layanan_pengiriman' => $validated['layanan_ongkir'],
            ]);

            // Create invoice items and update stock
            foreach ($cartData as $item) {
                $produk = Produk::find($item['id']);

                if (!$produk) {
                    throw new \Exception("Produk dengan ID {$item['id']} tidak ditemukan");
                }

                // Check if item has variant/jenis
                if (isset($item['jenis_id']) && $item['jenis_id'] && $item['jenis_id'] !== 'null') {
                    // Check stock from jenis_produk
                    $jenisProduk = JenisProduk::find($item['jenis_id']);

                    if (!$jenisProduk) {
                        throw new \Exception("Varian produk tidak ditemukan (Jenis ID: {$item['jenis_id']})");
                    }

                    if ($jenisProduk->jumlah_produk < $item['quantity']) {
                        throw new \Exception("Stok varian '{$jenisProduk->nama}' dari produk '{$produk->nama}' tidak mencukupi (Tersedia: {$jenisProduk->jumlah_produk}, Diminta: {$item['quantity']})");
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
                    // Check stock from produk (no variant selected)
                    // Use main product stock (jumlah_produk)
                    $stokProduk = $produk->jumlah_produk ?? 0;

                    if ($stokProduk < $item['quantity']) {
                        throw new \Exception("Stok produk '{$produk->nama}' tidak mencukupi (Tersedia: {$stokProduk}, Diminta: {$item['quantity']})");
                    }

                    // Save stock before update
                    $stokAwal = $stokProduk;

                    // Create item transaction
                    ItemTransaksi::create([
                        'invoice_id' => $invoice->id_invoice,
                        'produk_id' => $item['id'],
                        'jenis_produk_id' => null,
                        'jumlah' => $item['quantity'],
                        'subtotal' => $item['harga'] * $item['quantity'],
                    ]);

                    // Update product stock
                    $produk->decrement('jumlah_produk', $item['quantity']);                    // Record stock history for main product
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

        // Cek apakah user sudah memberikan ulasan untuk setiap produk
        $userReviews = [];
        if (Auth::check()) {
            foreach ($items as $item) {
                $review = UlasanRating::where('user_id', Auth::id())
                    ->where('produk_id', $item->produk_id)
                    ->first();
                $userReviews[$item->produk_id] = $review;
            }
        }

        return view('order-confirmation', compact('invoice', 'items', 'userReviews'));
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

    /**
     * Get districts from RajaOngkir API for Select2
     */
    public function getDistricts(Request $request)
    {
        try {
            $search = $request->get('q', '');
            $page = $request->get('page', 1);

            $response = Http::withHeaders([
                'key' => $this->rajaOngkirApiKey
            ])->get($this->rajaOngkirBaseUrl . '/destination/domestic-destination', [
                'search' => $search
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['data']) && is_array($data['data'])) {
                    // Format for Select2
                    $results = array_map(function($district) {
                        return [
                            'id' => $district['id'],
                            'text' => $district['label']
                        ];
                    }, $data['data']);

                    return response()->json([
                        'results' => $results,
                        'pagination' => ['more' => false]
                    ]);
                }
            }

            return response()->json([
                'results' => [],
                'pagination' => ['more' => false]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'results' => [],
                'pagination' => ['more' => false],
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate shipping cost from RajaOngkir API
     */
    public function calculateShippingCost(Request $request)
    {
        $request->validate([
            'destination' => 'required',
            'weight' => 'required|integer|min:1',
        ]);

        try {
            $response = Http::withHeaders([
                'key' => $this->rajaOngkirApiKey,
                'Content-Type' => 'application/x-www-form-urlencoded'
            ])->asForm()->post($this->rajaOngkirBaseUrl . '/calculate/domestic-cost', [
                'origin' => $this->originDistrict,
                'destination' => $request->destination,
                'weight' => $request->weight,
                'courier' => 'jnt', // J&T Express
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['data']) && is_array($data['data']) && count($data['data']) > 0) {
                    // Format services from response
                    $services = array_map(function($service) {
                        return [
                            'service' => $service['service'],
                            'description' => $service['description'],
                            'cost' => $service['cost'],
                            'etd' => $service['etd'] ?: 'Estimasi 2-3 hari',
                        ];
                    }, $data['data']);

                    // Get courier info from first service
                    $firstService = $data['data'][0];

                    return response()->json([
                        'success' => true,
                        'courier' => strtoupper($firstService['code']),
                        'courier_name' => $firstService['name'],
                        'services' => $services
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada layanan pengiriman yang tersedia untuk tujuan ini'
                ], 404);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghubungi server ongkir'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
