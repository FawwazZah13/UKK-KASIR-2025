<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Produks;
use App\Models\Pembelian;
use App\Models\Pembelians;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // public function dashboard () {
    //     return view('dashboard');
    // }

    public function dashboard()
    {
        $user = Auth::user();
        $data = [];

        if ($user->role === 'petugas') {
            $data = [
                'dailyPembelians' => Pembelian::whereDate('created_at', Carbon::today())->count(),
                'lastUpdated' => Pembelian::whereDate('created_at', Carbon::today())->latest('updated_at')
                    ->first()?->updated_at?->format('d-m-Y H:i') ?? now()->format('d-m-Y H:i'),
            ];
        } 
        elseif ($user->role === 'admin') {
            $totalPembelians = Pembelian::count();
        
            $data = [
                'salesData' => $this->getPembeliansData(), // <--- ubah nama variabel biar cocok dengan @json($salesData)
                'productSales' => Produks::withCount(['details']) // <--- relasi harus sesuai
                    ->get()
                    ->map(fn($product) => [
                        'name' => $product->name,
                        'percentage' => $totalPembelians > 0 ? ($product->details_count / $totalPembelians) * 100 : 0,
                    ]),
            ];
        }
        
        else {
            $data = [
                'totalProducts' => Produks::count(),
                'totalPembelians' => Pembelian::count(),
                'totalUsers' => User::count(),
            ];
        }

        return view('dashboard', $data);
    }

    private function getPembeliansData()
    {
        return Pembelian::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::today()->subDays(13))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn($item) => [
                'date' => Carbon::parse($item->date)->format('d-M-Y'),
                'total' => $item->total,
       ]);
}
}
