@extends('layout.template')

@section('content')

<form action="{{ route('update.produk', ['id' => $produk->id]) }}" method="POST" class="border p-4 rounded shadow bg-white" style="width: 1000px" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <h4>Produk</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Nama Produk</label>
          <input type="text" class="form-control" name="nama_produk" id="nama_produk" placeholder="Masukan nama produk" value="{{ $produk->nama_produk }}">
        </div>
        <div class="mb-3">
          <label class="form-label">Harga</label>
          <input type="number" class="form-control" name="harga" id="harga" placeholder="Masukan harga" value="{{ $produk->harga }}">
        </div>
      </div>
      <div class="col-md-6">
      <div class="mb-3">
        <label class="form-label">Stok</label>
        <input type="number" class="form-control" name="stok" id="stok" placeholder="Masukan stok" value="{{ $produk->stok }}" readonly>
      </div>
        <div class="mb-3">
          <label class="form-label">Foto Produk</label>
          <input type="file" class="form-control" name="gambar" id="gambar" placeholder="Masukan gambar">
        </div>
      </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </div>
  </form>
</div>
@endsection