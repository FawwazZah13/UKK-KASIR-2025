@extends('layout.template')

@section('content')
<div class="container my-4">
    <h4>Pilih Produk</h4>

    <form action="{{ route('cart.pembelian') }}" method="POST">
        @csrf

        <div class="row">
            @foreach ($pembelian as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100 p-3">
                    <img src="{{ asset('img/' . $item->gambar) }}" class="card-img-top" alt="...">
                    <h5>{{ $item->nama_produk }}</h5>
                    <p>Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                
                    <!-- Stok tersedia -->
                    <small class="text-muted">Stok tersedia: {{ $item->stok }}</small>
                
                    <input type="hidden" name="id[]" value="{{ $item->id }}">
                    <input type="hidden" name="nama_produk[]" value="{{ $item->nama_produk }}">
                    <input type="hidden" name="harga[]" value="{{ $item->harga }}">
                
                    <div class="input-group mt-2">
                        <button type="button" class="btn btn-outline-secondary minus-btn">-</button>
                        <input type="number" name="jumlah[]" class="form-control text-center qty-input" value="0" min="0" data-stok="{{ $item->stok }}">
                        <button type="button" class="btn btn-outline-secondary plus-btn">+</button>
                    </div>
                </div>
                
            </div>
            @endforeach
        </div>

        <div class="fixed-bottom d-flex justify-content-end p-3 bg-white border-top">
            <button type="submit" class="btn btn-primary btn-lg shadow">Selanjutnya</button>
        </div>
        
    </form>
</div>

<script>
    document.querySelectorAll('.plus-btn').forEach((btn, index) => {
        btn.addEventListener('click', () => {
            const qtyInput = document.querySelectorAll('.qty-input')[index];
            const stok = parseInt(qtyInput.getAttribute('data-stok'));
            let currentQty = parseInt(qtyInput.value);

            if (currentQty < stok) {
                qtyInput.value = currentQty + 1;
            } else {
                alert('Jumlah melebihi stok tersedia!');
            }
        });
    });

    document.querySelectorAll('.minus-btn').forEach((btn, index) => {
        btn.addEventListener('click', () => {
            const qtyInput = document.querySelectorAll('.qty-input')[index];
            let currentQty = parseInt(qtyInput.value);
            if (currentQty > 0) {
                qtyInput.value = currentQty - 1;
            }
        });
    });
</script>

@endsection
