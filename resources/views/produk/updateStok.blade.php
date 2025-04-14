@extends('layout.template')
@section('content')

<form action="{{ route('updateStokProduk.produk', ['id' => $produk->id]) }}" method="POST"  class="border p-4 rounded shadow bg-white">
    @csrf
    @method('PUT')
    <div class="row">
          <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" class="form-control" name="nama_produk" id="nama_produk" value="{{ $produk->nama_produk }}" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" class="form-control" name="stok" id="stok" placeholder="Masukan stok" value="{{ $produk->stok }}">
    </div>
    <button type="submit" class="btn btn-primary">Update Stok</button>
</form>

@endsection