<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukDetailController extends Controller
{
    public function show($id)
    {
        // Ambil produk berdasarkan ID dengan relasi
        $produk = Produk::with(['kategori', 'gambarProduk', 'jenisProduk', 'itemTransaksi.invoice'])
            ->findOrFail($id);

        // Set jenis produk terpilih default (jenis pertama yang ada stok)
        if ($produk->jenisProduk->count() > 0) {
            $jenisTerpilih = $produk->jenisProduk->where('jumlah_produk', '>', 0)->first();
            $produk->jenisProdukTerpilih = $jenisTerpilih ? $jenisTerpilih->id_jenis_produk : $produk->jenisProduk->first()->id_jenis_produk;
        } else {
            $produk->jenisProdukTerpilih = null;
        }

        // Ambil produk terkait (dari kategori yang sama, kecuali produk ini)
        $produkTerkait = Produk::with(['kategori', 'gambarProduk', 'jenisProduk'])
            ->where('kategori_id', $produk->kategori_id)
            ->where('id_produk', '!=', $id)
            ->where('jumlah_produk', '>', 0)
            ->limit(6)
            ->get();

        // Ambil produk serupa (random dari kategori lain atau semua produk)
        $produkSerupa = Produk::with(['kategori', 'gambarProduk', 'jenisProduk'])
            ->where('id_produk', '!=', $id)
            ->where('jumlah_produk', '>', 0)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        // Ambil semua kategori untuk sidebar
        $kategori = Kategori::all();

        // Ambil ulasan rating dengan user
        $ulasanRatings = $produk->ulasanRating()->with('user')->latest()->paginate(10);
        
        // Hitung rata-rata rating
        $averageRating = $produk->ulasanRating()->avg('rating') ?? 0;
        $totalReviews = $produk->ulasanRating()->count();
        
        // Hitung distribusi rating (5, 4, 3, 2, 1)
        $ratingDistribution = [
            5 => $produk->ulasanRating()->where('rating', 5)->count(),
            4 => $produk->ulasanRating()->where('rating', 4)->count(),
            3 => $produk->ulasanRating()->where('rating', 3)->count(),
            2 => $produk->ulasanRating()->where('rating', 2)->count(),
            1 => $produk->ulasanRating()->where('rating', 1)->count(),
        ];
        
        // Hitung persentase untuk setiap rating
        $ratingPercentages = [];
        foreach ($ratingDistribution as $rating => $count) {
            $ratingPercentages[$rating] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }
        
        // Cek apakah user sudah memberikan ulasan
        $userReview = null;
        if (auth()->check()) {
            $userReview = $produk->ulasanRating()
                ->where('user_id', auth()->id())
                ->first();
        }

        return view('produk-detail', compact('produk', 'produkTerkait', 'produkSerupa', 'kategori', 'ulasanRatings', 'averageRating', 'totalReviews', 'userReview', 'ratingDistribution', 'ratingPercentages'));
    }
}
