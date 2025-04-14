@extends('layout.template')
@section('content')

@if (Auth::check() && Auth::user()->role == 'petugas')
<a href="{{ route('showProduk.pembelian') }}" class="btn btn-primary m-3">
    Tambah Penjulaan
</a>
@endif  

<a href="{{ route('excel.pembelian') }}" class="btn btn-success m-3">
    Export Excel
</a>

<div class="container border p-3 rounded shadow bg-white">
    <table id="myTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Penjualan</th>
                <th>Total Harga</th>
                <th>Dibuat Oleh</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembelian as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->customer->name }}</td>
                <td>{{ $item->tanggal_pembelian }}</td>
                <td>Rp. {{ number_format($item->total_harga) }}</td>
                <td>{{ $item->user->name }}</td>
                <td>
                    <div class="d-flex justify-content-around">
                        <!-- Tombol lihat -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#lihat-{{ $item->id }}">
                            Lihat
                        </button>

                        <!-- Tombol unduh -->
                        <a href="{{ route('unduhPdf.pembelian', $item->id) }}" class="btn btn-info">
                            Unduh Bukti
                        </a>
                    </div>
                </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="lihat-{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel{{ $item->id }}">Detail Penjualan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Member Status:</strong> {{ $item->customer->status_customer }}</p>
                            <p><strong>No HP:</strong> {{ $item->customer->no_tlp }}</p>
                            <p><strong>Poin Member:</strong> {{ $item->customer->poin }}</p>
                            <p><strong>Bergabung Sejak:</strong> 
                            @if ($item->customer->status_customer === 'member')
                            {{ \Carbon\Carbon::parse($item->customer->created_at)->format('d F Y') }}
                            @endif
                            -
                            </p>

                            {{-- <p><strong>Dibuat Oleh:</strong> {{ $item->user->name }}</p> --}}

                            <hr>

                            <h6>Daftar Produk:</h6>
                            <ul>
                                @foreach ($item->details as $detail)
                                    <li>Nama Produk : {{ $detail->produk->nama_produk }}</li>
                                    <li>Qty : {{ $detail->qty }}</li>
                                    <li>Harga : Rp. {{ number_format($detail->produk->harga) }}</li>
                                    <li>Sub Total : Rp. {{ number_format($detail->sub_total) }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pastikan Bootstrap JS dimuat -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
