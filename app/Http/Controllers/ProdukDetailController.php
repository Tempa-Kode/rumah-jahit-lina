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

        return view('produk-detail', compact('produk', 'produkTerkait', 'produkSerupa', 'kategori'));
    }
}
