<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UKK KASIR</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="http://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <style>
        /* Pastikan sidebar mengikuti tinggi layar */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            overflow-y: auto;
            /* Sidebar bisa discroll jika terlalu panjang */
        }
    </style>
</head>

<body>
    @if (Auth::check() && Auth::user()->role == 'admin')
        <div class="d-flex">
            <!-- Sidebar Admin -->
            <div class="d-flex flex-column justify-content-between bg-light text-dark p-3 border-end shadow sidebar">
                <div>
                    <img src="{{ asset('img/logo.png') }}" style="width: 200px">
                    <a href="{{ route('dashboard') }}" class="d-block text-dark text-decoration-none p-3 rounded">
                        <i class="fa-solid fa-house text-dark"></i> Dashboard
                    </a>
                    <a href="{{ route('index.produk') }}" class="d-block text-dark text-decoration-none p-3 rounded">
                        <i class="fa-solid fa-shop text-dark"></i> Produk
                    </a>
                    <a href="{{ route('index.pembelian') }}" class="d-block text-dark text-decoration-none p-3 rounded">
                        <i class="fa-solid fa-cart-shopping text-dark"></i> Pembelian
                    </a>
                    <a href="{{ route('index.user') }}" class="d-block text-dark text-decoration-none p-3 rounded">
                        <i class="fa-solid fa-user text-dark"></i> User
                    </a>
                    <form action="{{ route('logout.user') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Logout</button>
                    </form>
                </div>
            </div>

            <div class="p-5 flex-grow-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none text-secondary">
                                <i class="fa-solid fa-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">Dashboard</a>
                        </li>
                    </ol>
                </nav>
    @endif
    @if (Auth::check() && Auth::user()->role == 'petugas')
        <div class="d-flex">
            <!-- Sidebar Admin -->
            <div class="d-flex flex-column justify-content-between bg-light text-dark p-3 border-end shadow sidebar">
                <div>
                    <img src="{{ asset('img/logo.png') }}" style="width: 200px">
                    <a href="{{ route('dashboard') }}" class="d-block text-dark text-decoration-none p-3 rounded">
                        <i class="fa-solid fa-house text-dark"></i> Dashboard
                    </a>
                    <a href="{{ route('index.produk') }}" class="d-block text-dark text-decoration-none p-3 rounded">
                        <i class="fa-solid fa-shop text-dark"></i> Produk
                    </a>
                    <a href="{{ route('index.pembelian') }}" class="d-block text-dark text-decoration-none p-3 rounded">
                        <i class="fa-solid fa-cart-shopping text-dark"></i> Pembelian
                    </a>
                    <form action="{{ route('logout.user') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Logout</button>
                    </form>
                </div>
            </div>

            <div class="p-5 flex-grow-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none text-secondary">
                                <i class="fa-solid fa-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a href="" class="text-decoration-none text-secondary">Dashboard</a>
                        </li>
                    </ol>
                </nav>
    @endif

    @yield('content')
    <script>
        $(document).ready(function(){
            $('#myTable').DataTable();
        });
    </script>
    @yield('scripts')

    </div>
    </div>
