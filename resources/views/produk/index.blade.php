@extends('layouts.main')

@section('content')
<h4>Data Produk</h4>

<div class="row mb-2">
    <div class="col-md-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari produk...">
    </div>
    <div class="col-md-8 text-end">
        <a href="{{ route('produk.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    </div>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered" id="produkTable">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produks as $produk)
        <tr>
            <td>{{ $produk->nama }}</td>
            <td>{{ $produk->satuan }}</td>
            <td>{{ number_format($produk->harga) }}</td>
            <td>{{ $produk->stok }}</td>
            <td>
                <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display:inline-block;">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin?')" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Script pencarian lokal --}}
<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll('#produkTable tbody tr');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
</script>
@endsection
