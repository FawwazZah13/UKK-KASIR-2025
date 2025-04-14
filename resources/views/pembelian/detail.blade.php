@extends('layout.template')

@section('content')
    <div class="p-5 bg-white rounded-lg shadow">
        <div class="flex justify-between mb-4">
            <a href="{{ route('index.pembelian') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('unduhPdf.pembelian', $pembelian->id) }}" class="btn btn-primary">Unduh</a>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
            <!-- Kiri -->
            <div>
                <p>
                    @if ($pembelian->customer->status_customer == "member")
                <strong>{{ $pembelian->customer->no_tlp }}</strong><br>
                MEMBER SEJAK :
                {{ \Carbon\Carbon::parse($pembelian->customer->created_at)->format('d F Y') }}<br>
                {{-- MEMBER POIN : {{ $pembelian->poin }}</p> --}}
                MEMBER POIN : {{ $pembelian->poin}}</p>
                @endif
            </div>
            <!-- Kanan -->
            <div style="text-align: right;">
                <p style="margin: 0;">Invoice - #{{ $pembelian->id }}</p>
                <p style="margin: 0;">{{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d F Y') }}</p>
            </div>
        </div>

        <p>
</p>


        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembelian->details as $detail)
                    <tr>
                        <td>{{ $detail->produk->nama_produk }}</td>
                        <td>Rp. {{ number_format($detail->produk->harga) }}</td>
                        <td>{{ $detail->qty }}</td>
                        <td>Rp. {{ number_format($detail->sub_total) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
            <!-- Kiri -->
            <p>
                    Poin digunakan : 
                    <strong>
                        {{ $pembelian->total_poin -  $pembelian->customer->poin }}
                    </strong><br>
                    
                          
                Kasir : 
                <strong style="margin-left: 10px;">
                    {{ $pembelian->user->name }}
                </strong><br>
            
                <strong>
                    Kembalian : Rp. {{ number_format($pembelian->total_kembalian) }}
                </strong>
            </p>
            
            
            <!-- Kanan -->
            <div style="text-align: right;">
                <h3 style="margin: 0;">Total :
                <strong>Rp. {{ number_format($pembelian->total_harga) }}</strong>
                </h3>
            </div>
        </div>
    </div>
@endsection
