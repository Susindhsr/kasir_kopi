@extends('layouts.main')

@section('content')
    <h4 class="mb-3">Selamat Datang di Aplikasi Kasir</h4>
    <p>Gunakan menu di atas untuk mengelola produk dan transaksi.</p>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Produk</h5>
                    <p class="card-text display-6">{{ $totalProduk }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Transaksi Hari Ini</h5>
                    <p class="card-text display-6">{{ $totalTransaksiHariIni }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-bg-warning h-100">
                <div class="card-body">
                    <h5 class="card-title">Pendapatan Hari Ini</h5>
                    <p class="card-text display-6">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <h5>Daftar Transaksi Hari Ini ({{ $transaksiHariIni->count() }})</h5>
    @if($transaksiHariIni->isEmpty())
        <p>Tidak ada transaksi hari ini.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th>Waktu</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksiHariIni as $index => $transaksi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $transaksi->nama_pembeli ?? '-' }}</td>
                            <td>{{ $transaksi->created_at->format('H:i:s') }}</td>
                            <td>{{ $transaksi->details->sum('jumlah') }}</td>
                            <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
