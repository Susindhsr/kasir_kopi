@extends('layouts.main')

@section('content')
<h4>Edit Produk</h4>

<form action="{{ route('produk.update', $produk->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-2">
        <label>Nama Produk</label>
        <input type="text" name="nama" class="form-control" value="{{ $produk->nama }}" required>
    </div>
    <div class="mb-2">
    <label>Satuan</label>
    <select name="satuan" class="form-control" required>
        <option value="kg" {{ $produk->satuan === 'kg' ? 'selected' : '' }}>kg</option>
        <option value="pcs" {{ $produk->satuan === 'pcs' ? 'selected' : '' }}>pcs</option>
        <option value="liter" {{ $produk->satuan === 'liter' ? 'selected' : '' }}>liter</option>
    </select>
</div>
    <div class="mb-2">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control" value="{{ $produk->harga }}" required>
    </div>
    <div class="mb-2">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" required>
    </div>
    <button class="btn btn-success">Update</button>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
