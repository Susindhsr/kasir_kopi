<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;

// Beranda
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Produk: CRUD otomatis
Route::resource('produk', ProdukController::class);

// Transaksi: CRUD otomatis
Route::resource('transaksi', TransaksiController::class);

//Cetak struk
// Route::get('/transaksi/{id}/struk', [TransaksiController::class, 'cetakStruk'])->name('transaksi.struk');
// Route::get('/struk/{id}', [TransaksiController::class, 'showStruk']);
Route::get('/transaksi/{id}/struk', [TransaksiController::class, 'showStruk'])->name('transaksi.struk');
