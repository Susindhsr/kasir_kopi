@extends('layouts.main')

@section('content')
<h4>Tambah Produk</h4>

<form action="{{ route('produk.store') }}" method="POST">
    @csrf
    <div class="mb-2">
        <label>Nama Produk</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
   <div class="form-group">
    <label for="satuan">Satuan</label>
    <select name="satuan" class="form-control" required>
        <option value="kg">kg</option>
        <option value="pcs">pcs</option>
        <option value="liter">liter</option>
    </select>
</div>


    <div class="mb-2">
        <label>Harga</label>
        <input type="number" name="harga" class="form-control" required>
    </div>
    <div class="mb-2">
        <label>Stok</label>
        <input type="number" name="stok" class="form-control" required>
    </div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
