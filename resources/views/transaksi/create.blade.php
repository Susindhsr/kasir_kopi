@extends('layouts.main')

@section('content')
<h4>Buat Transaksi Baru</h4>

<form action="{{ route('transaksi.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nama Pembeli</label>
        <input type="text" name="nama_pembeli" class="form-control" required>
    </div>

    <div id="produkContainer">
        <div class="produk-row mb-2 d-flex gap-2 align-items-center">
            <select name="produk_id[]" class="form-select" required>
                <option value="" disabled selected>Pilih Produk</option>
                @foreach ($produks as $produk)
                    <option value="{{ $produk->id }}">{{ $produk->nama }} - Rp {{ number_format($produk->harga,0,',','.') }}</option>
                @endforeach
            </select>
            <input type="number" name="jumlah[]" class="form-control" min="1" value="1" required style="width: 80px;">
            <button type="button" class="btn btn-danger btn-sm btn-remove">Hapus</button>
        </div>
    </div>

    <button type="button" id="btnAddProduk" class="btn btn-secondary btn-sm mb-3">+ Tambah Produk</button>
    <br>
    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
</form>

<script>
    document.getElementById('btnAddProduk').addEventListener('click', function() {
        const container = document.getElementById('produkContainer');
        const newRow = document.querySelector('.produk-row').cloneNode(true);

        // Reset nilai input di clone
        newRow.querySelector('select').value = '';
        newRow.querySelector('input[type=number]').value = 1;

        container.appendChild(newRow);

        // Add event listener for remove button on new row
        newRow.querySelector('.btn-remove').addEventListener('click', function() {
            newRow.remove();
        });
    });

    // Remove button for first row
    document.querySelectorAll('.btn-remove').forEach(btn => {
        btn.addEventListener('click', function() {
            btn.closest('.produk-row').remove();
        });
    });
</script>
@endsection
