<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Produks;
use App\Models\Customer;
use App\Models\Pembelian;
use App\Exports\PembelianExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelian = Pembelian::all();
        return view('pembelian.index', compact('pembelian'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pembelian.create');
    }

    public function cart(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($request->id as $index => $produk_id) {
            $qty = (int) $request->jumlah[$index];
            $produk = Produks::find($produk_id);

            if ($qty > 0 && $produk) {
                if ($qty <= $produk->stok) {
                    $cart[] = [
                        'produk_id' => $produk_id,
                        'nama_produk' => $request->nama_produk[$index],
                        'harga' => $request->harga[$index],
                        'qty' => $qty,
                        'sub_total' => $qty * $request->harga[$index],
                    ];
                } else {
                    return back()->with('error', 'Jumlah produk "' . $produk->nama_produk . '" melebihi stok!');
                }
            }
        }

        session(['cart' => $cart]);

        return redirect()->route('checkout.pembelian')->with('success', 'Produk ditambahkan ke keranjang.');
    }



    public function checkout()
    {
        $cart = session('cart', []);
        $total = collect($cart)->sum('sub_total');
        return view('pembelian.create', compact('cart', 'total'));
    }
    public function store(Request $request)
    {

        if ($request->total_bayar < $request->total_harga) {
            return back()->withInput()->withErrors([
                'total_bayar' => 'Uang Anda belum cukup untuk membayar total harga.'
            ]);
        }
        
        // Cek jika customer member tapi belum mengisi nama
        if ($request->status_customer === 'member' && !$request->filled('name')) {
            $customer = Customer::where('no_tlp', $request->no_tlp)->first();
            $last_pembelian = $customer ? Pembelian::where('customer_id', $customer->id)->latest('tanggal_pembelian')->first() : null;

            return view('pembelian.viewMember', [
                'no_tlp' => $request->no_tlp,
                'status_customer' => 'member',
                'total_harga' => $request->total_harga,
                'total_bayar' => $request->total_bayar,
                'poin' => $request->gunakan_poin ?? false,
                'customer' => $customer,
                'total_poin' => $customer ? $customer->poin : 0,
                'transaksi_pertama' => !$customer || !$customer->name,
                'request' => $request,
            ]);
        }

        $pembelian = null;

        DB::transaction(function () use ($request, &$pembelian) {
            $cart = session('cart');
            $original_total = $request->total_harga;
            // $gunakanPoin = $request->has('gunakan_poin');
            $gunakanPoin = $request->has('gunakan_poin') && $request->input('gunakan_poin') == 1;
            $poin_baru = floor($original_total / 100); // 1 poin = 100
            $customer_id = null;
            $total_setelah_diskon = $original_total;
            $poin_digunakan = 0;
            $total_poin_saat_ini = 0;
            $total_poin_untuk_pembelian = 0;

            // Penanganan customer baru atau member
            if ($request->status_customer === 'non-member') {
                $customer = Customer::create([
                    'name' => 'NON-MEMBER',
                    'status_customer' => 'non-member',
                    'no_tlp' => null,
                    'poin' => 0,
                ]);
                $customer_id = $customer->id;
            } elseif ($request->status_customer === 'member') {
                $customer = Customer::firstOrCreate(
                    ['no_tlp' => $request->no_tlp],
                    [
                        'name' => $request->name,
                        'status_customer' => 'member',
                        'poin' => floor($request->total_harga / 100),
                    ]
                );

                $customer_id = $customer->id;
                $transaksi_pertama = !$customer->name;
                $poin_awal = $customer->poin;

                if (!$transaksi_pertama) {
                    $customer->poin = $customer->poin - $poin_digunakan + $poin_baru;
                } else {
                    // transaksi pertama sudah diset poin saat create
                    $customer->poin = $customer->poin - $poin_digunakan;
                }


                // Cek apakah poin digunakan
                if ($gunakanPoin && $poin_awal > 0) {
                    if ($poin_awal >= $original_total) {
                        // Jika poin lebih besar atau sama dengan total harga, pakai semua poin dan total setelah diskon 0
                        $poin_digunakan = $original_total;
                        $total_setelah_diskon = 0;
                        // Poin customer jadi 0
                        $customer->poin = 0;
                    } else {
                        // Gunakan poin yang ada
                        $poin_digunakan = $poin_awal;
                        $total_setelah_diskon = $original_total - $poin_awal;
                    }
                } else {
                    // Jika tidak menggunakan poin, total tetap harga aslinya
                    $total_setelah_diskon = $original_total;
                }

                // Hitung total poin (sebelum dipakai)
                $total_poin_untuk_pembelian = $poin_awal + $poin_baru;

                // Update poin customer (kurangi poin yang digunakan dan tambah poin baru)
                $customer->poin = $customer->poin - $poin_digunakan;
                $customer->save();
                $total_poin_saat_ini = $customer->poin;
            }

            $total_bayar = $request->total_bayar;
            $total_kembalian = 0;

            // Cek apakah uang lebih dan menggunakan poin
            // Menghitung kembalian
            $total_kembalian = 0;
            if ($total_bayar > $total_setelah_diskon) {
                if ($gunakanPoin) {
                    // Jika menggunakan poin, kembalian ditambah poin yang digunakan
                    $total_kembalian = $total_bayar - $total_setelah_diskon;
                } else {
                    // Jika tidak menggunakan poin, hanya dikurangi harga
                    $total_kembalian = $total_bayar - $original_total;
                }
            } elseif ($total_bayar == $total_setelah_diskon) {
                // Jika uang pas, total bayar akan dikurangi dengan total poin
                $total_kembalian = 0;
            }



            // Buat data pembelian
            $pembelian = Pembelian::create([
                'user_id' => auth()->id(),
                'customer_id' => $customer_id,
                // 'total_harga' => $original_total,
                'total_harga' => $gunakanPoin ? ($original_total - $poin_digunakan) : $original_total,
                'total_bayar' => $total_bayar,
                'total_kembalian' => $total_kembalian,
                'poin' => $poin_baru, // Poin transaksi yang diterima
                'total_poin' => $total_poin_untuk_pembelian, // poin awal + poin baru
                'tanggal_pembelian' => now(),
            ]);

            // Simpan detail produk dalam pembelian
            foreach ($cart as $item) {
                Detail::create([
                    'pembelian_id' => $pembelian->id,
                    'produk_id' => $item['produk_id'],
                    'qty' => $item['qty'],
                    'sub_total' => $item['sub_total'],
                ]);

                // Update stok produk
                $produk = Produks::find($item['produk_id']);
                if ($produk) {
                    $produk->stok -= $item['qty'];
                    $produk->save();
                }
            }

            // Hapus keranjang setelah transaksi
            session()->forget('cart');
        });

        return redirect()->route('detail.pembelian', $pembelian->id);
    }

    public function detail($id)
    {
        $pembelian = Pembelian::with(['details.produk', 'user', 'customer'])->findOrFail($id);

        return view('pembelian.detail', compact('pembelian'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Pembelian $pembelian)
    {
        $pembelian = Produks::all();
        return view('pembelian.showProduk', compact('pembelian'));
    }

    public function unduhPdf($id)
{
    $pembelian = Pembelian::with(['details.produk', 'customer', 'user'])->findOrFail($id);
    
    $pdf = Pdf::loadView('pembelian.invoice-pdf', compact('pembelian'));
    
    return $pdf->stream('invoice-pembelian-'.$id.'.pdf');
}

public function export()
{
    return Excel::download(new PembelianExport, 'data-pembelian.xlsx');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        //
    }


}
