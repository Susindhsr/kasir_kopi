@extends('layouts.main')

@section('content')
<div class="container">
    <h4 class="mb-4">Riwayat Transaksi</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">+ Transaksi Baru</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $index => $transaksi)
                @php $rowspan = $transaksi->detailTransaksis->count(); @endphp
                @foreach($transaksi->detailTransaksis as $key => $detail)
                    <tr>
                        @if ($key == 0)
                            <td rowspan="{{ $rowspan }}">{{ $index + 1 }}</td>
                            <td rowspan="{{ $rowspan }}">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y H:i') }}</td>
                            <td rowspan="{{ $rowspan }}">{{ $transaksi->nama_pelanggan ?? '-' }}</td>
                        @endif
                        <td>{{ $detail->produk->nama }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        @if ($key == 0)
                            <td rowspan="{{ $rowspan }}">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        @endif
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
