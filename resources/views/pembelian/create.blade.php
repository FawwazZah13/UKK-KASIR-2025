@extends('layout.template')

@section('content')
<div class="container my-4">
    <h4>Produk yang dipilih</h4>

    @foreach ($cart as $item)
    <div class="d-flex justify-content-between border-bottom py-2">
        <div>
            {{ $item['nama_produk'] }} <br>
            <small>Rp. {{ number_format($item['harga'], 0, ',', '.') }} x {{ $item['qty'] }}</small>
        </div>
        <div>
            <strong>Rp. {{ number_format($item['sub_total'], 0, ',', '.') }}</strong>
        </div>
    </div>
    @endforeach

    <div class="d-flex justify-content-between mt-3">
        <strong>Total</strong>
        <strong>Rp. {{ number_format($total, 0, ',', '.') }}</strong>
    </div>

    <form action="{{ route('post.pembelian') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="total_harga" value="{{ $total }}">

        <div class="mb-3">
            <label for="status_customer" class="form-label">Member Status</label>
            <select name="status_customer" class="form-select" id="status_customer">
                <option value="non-member">Bukan Member</option>
                <option value="member">Member</option>
            </select>
            <small class="text-danger">Dapat juga membuat member</small>
        </div>

        {{-- ⬇️ Input nomor telepon, hanya muncul saat "Member" dipilih --}}
        <div class="mb-3 d-none" id="no_tlp_wrapper">
            <label for="no_tlp" class="form-label">Nomor Telepon</label>
            <input type="text" name="no_tlp" id="no_tlp" class="form-control" placeholder="08xxxxxxxxxx">
        </div>

        <div class="mb-3">
            <label for="total_bayar" class="form-label">Total Bayar</label>
            <input type="text" id="total_bayar_display" class="form-control" required>
            <input type="hidden" name="total_bayar" id="total_bayar">
        
            @error('total_bayar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <script>
            const displayInput = document.getElementById('total_bayar_display');
            const hiddenInput = document.getElementById('total_bayar');
        
            displayInput.addEventListener('input', function () {
                let raw = displayInput.value.replace(/\D/g, ''); // Hanya angka
                if (raw === '') {
                    displayInput.value = '';
                    hiddenInput.value = '';
                    return;
                }
        
                let formatted = new Intl.NumberFormat('id-ID').format(raw);
                displayInput.value = 'Rp. ' + formatted;
                hiddenInput.value = raw; // Simpan value asli ke hidden input
            });
        </script>
        
        

        <button type="submit" class="btn btn-primary">Pesan</button>
    </form>
</div>

{{-- ⬇️ Script untuk menampilkan input no_tlp jika pilih member --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectStatus = document.getElementById('status_customer');
        const noTlpWrapper = document.getElementById('no_tlp_wrapper');

        selectStatus.addEventListener('change', function () {
            if (this.value === 'member') {
                noTlpWrapper.classList.remove('d-none');
            } else {
                noTlpWrapper.classList.add('d-none');
            }
        });
    });
</script>
@endsection
