@extends('layout.template')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('post.pembelian') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Kiri: Tabel Produk -->
                        <div class="col-lg-6 col-md-12 mb-4">
                            <div class="table-responsive table-bordered">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse (session('cart') as $item)
                                            <tr>
                                                <td>{{ $item['nama_produk'] }}</td>
                                                <td>{{ $item['qty'] }}</td>
                                                <td>Rp. {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                                <td>Rp. {{ number_format($item['sub_total'], 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Keranjang kosong.</td>
                                            </tr>
                                        @endforelse
                                        <tr class="table-light">
                                            <td colspan="2"></td>
                                            <td><strong>Total Harga</strong></td>
                                            <td><strong>Rp. {{ number_format($total_harga, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr class="table-light">
                                            <td colspan="2"></td>
                                            <td><strong>Total Bayar</strong></td>
                                            <td><strong>Rp. {{ number_format($total_bayar, 0, ',', '.') }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Kanan: Form Member -->
                        <div class="col-lg-6 col-md-12">
                            <!-- Input Hidden -->
                            <input type="hidden" name="no_tlp" value="{{ $no_tlp }}">
                            <input type="hidden" name="total_harga" value="{{ $total_harga }}">
                            <input type="hidden" name="status_customer" value="{{ $status_customer }}">
                            <input type="hidden" name="total_bayar" value="{{ $total_bayar }}">

                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Nama Member (identitas)</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $customer->name ?? '') }}"
                                    class="form-control"
                                    @if (!empty($customer->name)) readonly @endif required>
                            </div>
                            <input type="text" class="form-control"
                            value="{{ $customer->poin ?? 0 }}"
                            disabled>
                        
                        <div class="form-check mb-3">
                            <input type="checkbox" name="gunakan_poin" value="1"
                                class="form-check-input" id="gunakanPoin"
                                {{ $transaksi_pertama ? 'disabled' : '' }}>
                            <label class="form-check-label" for="gunakanPoin">
                                Gunakan poin untuk potongan harga
                            </label>
                        </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Selanjutnya</button>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
