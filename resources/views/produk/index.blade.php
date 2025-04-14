@extends('layout.template')

@section('content')

<!-- Form pencarian produk -->
<form method="GET" action="{{ route('index.produk') }}" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request()->search }}">
        <button class="btn btn-outline-secondary" type="submit">Cari</button>
    </div>
</form>

@if (Auth::check() && Auth::user()->role == "admin")
    <a href="{{ route('create.produk') }}" class="btn btn-primary m-3">
        Create Produk</a>

    <div class="container border p-3 rounded shadow bg-white">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td class="text-secondary">
                            @if ($item->gambar)
                                <img src="{{ asset('img/' . $item->gambar) }}" alt="{{ $item->nama_produk }}"
                                    style="width: 80px;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td class="text-secondary">{{ $item->nama_produk }}</td>
                        <td class="text-secondary">{{ $item->harga }}</td>
                        <td class="text-secondary">{{ $item->stok }}</td>
                        <td>
                            <a href="{{ route('updateStok.produk', $item->id) }}" class="btn btn-primary">Update Stok</a>
                            <a href="{{ route('edit.produk', $item->id) }}" class="btn btn-warning">Update</a>

                            <form action="{{ route('delete.produk', $item->id) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endif

@if (Auth::check() && Auth::user()->role == "petugas")
    <div class="container border p-3 rounded shadow bg-white">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td class="text-secondary">
                            @if ($item->gambar)
                                <img src="{{ asset('img/' . $item->gambar) }}" alt="{{ $item->nama_produk }}"
                                    style="width: 80px;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td class="text-secondary">{{ $item->nama_produk }}</td>
                        <td class="text-secondary">{{ $item->harga }}</td>
                        <td class="text-secondary">{{ $item->stok }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
@endif

    </div>
@endsection
