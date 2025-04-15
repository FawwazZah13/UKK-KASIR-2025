@extends('layout.template')

@section('content')
    @if (Auth::check() && Auth::user()->role == 'admin')
        <div class="container border p-3 rounded shadow bg-white">
            <h4>Selamat Datang, Administrator!</h4>
            <div class="d-flex justify-content-center align-items-start">
                <div class="me-5">
                    {{-- <canvas id="chartjs-bar" width="750" height="370"></canvas> --}}
        <canvas id="salesChart" width="750" height="370"></canvas> <!-- bar chart -->

                </div>
                <div class="align-self-end">
                    {{-- <canvas id="chartjs-pie" width="200" height="179"></canvas> --}}
<canvas id="productChart" width="200" height="179"></canvas> <!-- pie chart -->

                </div>
            </div>
        </div>

        {{-- <canvas id="salesChart" width="750" height="370"></canvas> <!-- bar chart -->
<canvas id="productChart" width="200" height="179"></canvas> <!-- pie chart --> --}}

    
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
    @if (auth()->user()->role === 'admin')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data
        const sales = @json($salesData ?? []);
        const products = @json($productSales ?? []);
        
        // Bar Chart
        new Chart(document.getElementById('salesChart'), {
            type: 'bar',
            data: {
                labels: sales.map(item => item.date),
                datasets: [{
                    label: 'Penjualan',
                    data: sales.map(item => item.total),
                    backgroundColor: 'rgba(34, 197, 94, 0.5)',
                    borderColor: 'rgba(34, 197, 94, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });

        // Pie Chart
        new Chart(document.getElementById('productChart'), {
            type: 'pie',
            data: {
                labels: products.map(item => item.name),
                datasets: [{
                    data: products.map(item => item.percentage),
                    backgroundColor: [
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(250, 204, 21, 0.7)',
                        'rgba(20, 184, 166, 0.7)',
                        'rgba(139, 92, 246, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
    @endif
@endsection
