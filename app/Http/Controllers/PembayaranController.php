<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PembayaranController extends Controller
{
    public function bayar(Request $request)
    {
        $request->validate([
           'id_invoice' => 'required|exists:invoice,id_invoice',
            'total_bayar' => 'required|numeric'
        ]);

        // cek jika snap token sudah ada pada invoice tertentu
        $invoice = Invoice::where('id_invoice', $request->id_invoice)->first();
        if ($invoice && $invoice->snap_token) {
            return response()->json([
                'status'     => 'success',
                'snap_token' => $invoice->snap_token,
            ]);
        } else {
            \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
            \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
            \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

            try {
                $snapToken = null;
                DB::transaction(function () use ($request, &$snapToken, $invoice) {
                    $params = [
                        'transaction_details' => [
                            'order_id' => $invoice->kode_invoice,
                            'gross_amount' => (int) $request->total_bayar,
                        ],
                        'customer_details' => [
                            'first_name' => Auth::user()->nama,
                            'last_name' => Auth::user()->username,
                            'email' => Auth::user()->email,
                            'phone' => Auth::user()->no_hp,
                        ],
                    ];

                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    $invoice->snap_token = $snapToken;
                    $invoice->save();
                });

                return response()->json([
                    'status'     => 'success',
                    'snap_token' => $snapToken,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => 'error',
                    'message' => $e->getMessage(),
                ], 500);
            }
        }
    }

    public function updateStatus(Request $request)
    {
        $invoice = Invoice::where('kode_invoice', $request->kode_invoice)->first();
        if (!$invoice) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        $serverKey = config('services.midtrans.serverKey');
        $authString = base64_encode($serverKey . ':');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $authString
        ])->get("https://api.sandbox.midtrans.com/v2/{$request->kode_invoice}/status");
        if ($response->successful()) {
            $data = $response->json();
            Log::info('Response Cek Status Midtrans: ' . json_encode($data));
            if ($data['transaction_status'] ?? '' === 'settlement') {
                $invoice->status_pembayaran = 'terima';
                $invoice->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Status pembayaran berhasil diperbarui menjadi lunas.',
                    'status' => 'lunas'
                ]);
            } else {
                $invoice->status_pembayaran = 'pending';
                $invoice->save();

                return response()->json([
                    'success' => true,
                    'message' => 'pembayaran belum di terima, tunggu atau cek secara berkala.',
                    'status' => 'belum_bayar'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal memeriksa status transaksi'
        ], 500);
    }
}
