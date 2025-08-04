@extends('layouts.main')

@section('content')
<h4>Riwayat Transaksi</h4>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between mb-3">
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary">+ Transaksi Baru</a>

    <input id="searchInput" type="text" class="form-control w-auto" placeholder="Cari pelanggan...">
</div>

<div id="transaksiContainer">
    @foreach ($transaksis as $transaksi)
        <div class="mb-4 card p-3 transaksi-item" data-transaksi-id="{{ $transaksi->id }}">
            <strong class="nama-pelanggan">Nama Pelanggan:</strong> {{ $transaksi->nama_pembeli ?? '-' }}<br>
            <strong>Tanggal:</strong>
{{ $transaksi->created_at->setTimezone('Asia/Jakarta')->format('j') }}
{{ $transaksi->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('MMMM YYYY') }}
- {{ $transaksi->created_at->setTimezone('Asia/Jakarta')->format('H.i') }} WIB


            {{-- Tabel Produk --}}
            <table class="table table-bordered mt-2">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->produk->nama }}</td>
                            <td>{{ $detail->jumlah }}</td>
                            <td class="{{ $detail->is_deduction ? 'text-danger' : '' }}">
                                @if($detail->is_deduction)
                                    - Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
    <tr>
        <td colspan="3" class="text-end"><strong>Total:</strong></td>
        <td>
            @php
                $subtotalKopi = 0;
                $subtotalSelip = 0;

                foreach ($transaksi->details as $detail) {
                    $namaProduk = strtolower($detail->produk->nama);
                    if ($namaProduk === 'kopi') {
                        $subtotalKopi += $detail->subtotal;
                    } elseif ($namaProduk === 'selip') {
                        $subtotalSelip += $detail->subtotal;
                    }
                }

                if ($subtotalKopi > 0 && $subtotalSelip > 0) {
                    $total = $subtotalKopi - $subtotalSelip;
                } elseif ($subtotalKopi > 0) {
                    $total = $subtotalKopi;
                } elseif ($subtotalSelip > 0) {
                    $total = $subtotalSelip;
                } else {
                    $total = $transaksi->total ?? 0;
                }
            @endphp

            @if ($total < 0)
                - Rp {{ number_format(abs($total), 0, ',', '.') }}
            @else
                Rp {{ number_format($total, 0, ',', '.') }}
            @endif
        </td>
    </tr>
</tfoot>
            </table>

            {{-- Tombol Aksi --}}
            <div class="mt-3">
                <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </form>
                <a href="{{ route('transaksi.struk', $transaksi->id) }}" class="btn btn-success btn-sm" target="_blank">🧾 Cetak Struk</a>
            </div>
        </div>
    @endforeach
</div>

<script>
    // Search pelanggan
    document.getElementById('searchInput').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const transaksiItems = document.querySelectorAll('.transaksi-item');

        transaksiItems.forEach(item => {
            const namaElem = item.querySelector('.nama-pelanggan');
            let namaPelanggan = '';

            if (namaElem && namaElem.nextSibling) {
                namaPelanggan = namaElem.nextSibling.textContent.trim().toLowerCase();
            }

            item.style.display = namaPelanggan.includes(filter) ? '' : 'none';
        });
    });
</script>

@endsection
