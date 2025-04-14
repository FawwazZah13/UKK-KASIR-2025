@extends('layout.template')

@section('content')
    @if (Auth::check() && Auth::user()->role == 'admin')
        <div class="container border p-3 rounded shadow bg-white">
            <h4>Selamat Datang, Administrator!</h4>
            <div class="d-flex justify-content-center align-items-start">
                <div class="me-5">
                    <canvas id="chartjs-bar" width="750" height="370"></canvas>
                </div>
                <div class="align-self-end">
                    <canvas id="chartjs-pie" width="200" height="179"></canvas>
                </div>
            </div>
        </div>
    
    @elseif (Auth::check() && Auth::user()->role == 'petugas')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Selamat Datang, Petugas!</h3>
                        <div class="card d-block m-auto text-center">
                            <div class="card-header">Total Penjualan Hari Ini</div>
                            <div class="card-body">
                                <h3 class="card-title">{{ $jumlah_pembelian }}</h3>
                                <p class="card-text">Jumlah total penjualan yang terjadi hari ini.</p>
                            </div>
                            <div class="card-footer text-muted">
                                Terakhir diperbarui: 24 Feb 2025 05:33
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctxBar = document.getElementById('chartjs-bar')?.getContext('2d');
        if (ctxBar) {
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Merah', 'Biru', 'Kuning', 'Hijau'],
                    datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5],
                        backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                        borderColor: ['rgba(54, 162, 235, 1)'],
                        borderWidth: 1
                    }]
                },
                options: { responsive: false, scales: { y: { beginAtZero: true } } }
            });
        }

        var ctxPie = document.getElementById('chartjs-pie')?.getContext('2d');
        if (ctxPie) {
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Merah', 'Biru', 'Kuning', 'Hijau'],
                    datasets: [{
                        data: [12, 19, 3, 5],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: { responsive: false }
            });
        }
    });
</script>
@endsection