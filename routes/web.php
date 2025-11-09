<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [App\Http\Controllers\HomeController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.store');
Route::get('/dashboard-admin', [App\Http\Controllers\HomeController::class, 'dashboard'])->middleware('auth')->name('dashboard.admin');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Cart & Checkout Routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::get('/checkout', [App\Http\Controllers\CartController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [App\Http\Controllers\CartController::class, 'processCheckout'])->name('checkout.process');
Route::get('/order/confirmation/{id}', [App\Http\Controllers\CartController::class, 'orderConfirmation'])->name('order.confirmation');
Route::post('/order/payment-proof/{id}', [App\Http\Controllers\CartController::class, 'uploadPaymentProof'])->name('order.payment.proof');

// Akun Routes (Customer)
Route::middleware('auth')->prefix('akun')->name('akun.')->group(function () {
    Route::get('/', [App\Http\Controllers\AkunController::class, 'index'])->name('saya');
    Route::get('/pesanan', [App\Http\Controllers\AkunController::class, 'pesanan'])->name('pesanan');
    Route::get('/pesanan/{id}', [App\Http\Controllers\AkunController::class, 'pesananDetail'])->name('pesanan.detail');
    Route::get('/alamat', [App\Http\Controllers\AkunController::class, 'alamat'])->name('alamat');
    Route::post('/alamat', [App\Http\Controllers\AkunController::class, 'updateAlamat'])->name('alamat.update');
    Route::get('/edit', [App\Http\Controllers\AkunController::class, 'edit'])->name('edit');
    Route::post('/edit', [App\Http\Controllers\AkunController::class, 'update'])->name('update');
});

// Admin Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::resource('admin', App\Http\Controllers\AdminController::class);
    Route::resource('karyawan', App\Http\Controllers\KaryawanController::class);
    Route::resource('customer', App\Http\Controllers\CustomerController::class);
    Route::resource('kategori', App\Http\Controllers\KategoriController::class);

    // Custom routes HARUS sebelum resource route
    Route::delete('produk/gambar/{id}', [App\Http\Controllers\ProdukController::class, 'deleteGambar'])->name('produk.gambar.delete');
    Route::delete('produk/jenis/{id}', [App\Http\Controllers\ProdukController::class, 'deleteJenis'])->name('produk.jenis.delete');
    Route::post('produk/{id}/stok/tambah', [App\Http\Controllers\ProdukController::class, 'tambahStok'])->name('produk.stok.tambah');
    Route::get('produk/{id}/riwayat-stok/print', [App\Http\Controllers\ProdukController::class, 'printRiwayatStok'])->name('produk.riwayat-stok.print');

    Route::prefix('produk')->group(function () {
        Route::get('/', [App\Http\Controllers\ProdukController::class, 'index'])->name('produk.index');
        Route::get('/tambah', [App\Http\Controllers\ProdukController::class, 'create'])->name('produk.create');
        Route::post('/', [App\Http\Controllers\ProdukController::class, 'store'])->name('produk.store');

        // Product Detail Routes
        Route::get('/detail/{id}', [App\Http\Controllers\ProdukDetailController::class, 'show'])->name('produk.detail');

        Route::get('/{id}/edit', [App\Http\Controllers\ProdukController::class, 'edit'])->name('produk.edit');
        Route::put('/{id}', [App\Http\Controllers\ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/{id}', [App\Http\Controllers\ProdukController::class, 'destroy'])->name('produk.destroy');
    });
    Route::get('produk-detail/{id}', [App\Http\Controllers\ProdukController::class, 'show'])->name('detail-produk');
    // Route::resource('produk', App\Http\Controllers\ProdukController::class);

    // Transaksi Routes
    Route::get('transaksi/{id}/invoice', [App\Http\Controllers\TransaksiController::class, 'invoice'])->name('transaksi.invoice');
    Route::put('transaksi/{id}/validate-payment', [App\Http\Controllers\TransaksiController::class, 'validatePayment'])->name('transaksi.validate-payment');
    Route::put('transaksi/{id}/update-shipping', [App\Http\Controllers\TransaksiController::class, 'updateShipping'])->name('transaksi.update-shipping');
    Route::resource('transaksi', App\Http\Controllers\TransaksiController::class)->only(['index', 'show']);

    // Laporan Routes
    Route::get('laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::post('laporan/generate', [App\Http\Controllers\LaporanController::class, 'generate'])->name('laporan.generate');
    Route::post('laporan/print', [App\Http\Controllers\LaporanController::class, 'print'])->name('laporan.print');
    Route::post('laporan/pdf', [App\Http\Controllers\LaporanController::class, 'downloadPdf'])->name('laporan.pdf');
});
