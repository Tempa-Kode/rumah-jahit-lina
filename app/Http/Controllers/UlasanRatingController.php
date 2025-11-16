<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class UlasanRatingController extends Controller
{
    public function formTambahUlasan($produk_id)
    {
        $produk = Produk::find($produk_id);
        return view('form-ulasan', compact('produk'));
    }
}
