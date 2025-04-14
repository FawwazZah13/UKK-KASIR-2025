<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(){

        // $jumlah_pembelian = Pembelian::count();
        $jumlah_pembelian = Pembelian::whereDate('tanggal_pembelian', Carbon::today())->count();


        return view('dashboard', compact('jumlah_pembelian'));
    }
}
