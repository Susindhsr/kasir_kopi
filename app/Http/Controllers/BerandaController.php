<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class BerandaController extends Controller

{
    public function index()
    {
        $totalProduk = Produk::count();
        $totalTransaksiHariIni = Transaksi::whereDate('created_at', now())->count();
        $pendapatanHariIni = Transaksi::whereDate('created_at', now())->sum('total');

        // Ambil transaksi hari ini (misal terbaru 10 transaksi)
        $transaksiHariIni = Transaksi::with('details.produk')
            ->whereDate('created_at', now())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('beranda', compact(
            'totalProduk',
            'totalTransaksiHariIni',
            'pendapatanHariIni',
            'transaksiHariIni'
        ));
    }

}
