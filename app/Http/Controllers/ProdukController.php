<?php

namespace App\Http\Controllers;

use App\Models\Produks;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // public function index() {
    //     $produk = Produks::all();
    //     return view('produk.index', compact('produk'));
    // }

    public function index(Request $request) {
        $query = Produks::query();
        if($request->has('search') && $request->search != '') {
           $search = $request->search;
           $query->where('nama_produk', 'like', "%{$search}%")
           ->orWhere('harga', 'like', "%{$search}%");
        }
   
        $produk = $query->get();
   
        return view('produk.index', compact('produk'));
       }

    
    public function create (){
        return view('produk.create');
    }

    public function store(Request $request) {

        $request->validate([
            'nama_produk' => 'required',
            'harga'       => 'required',
            'stok'        => 'required',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $produk = new Produks();
        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
    
        if ($request->hasFile('gambar')) {
            $filename = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('img'), $filename);
            $produk->gambar = $filename;
        }
    
        $produk->save();
        return redirect()->route('index.produk');
    }
    
    public function edit($id){
        $produk = Produks::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id){

        $request->validate([
            'nama_produk' => 'required',
            'harga'       => 'required',
            'stok'        => 'required',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $produk = Produks::findOrFail($id);
        
        if ($request->hasFile('gambar')) {
            $filename = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('img'), $filename);
            $produk->gambar = $filename;
        }
    
        $produk->update([
            'nama_produk' => $request->input('nama_produk'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
            'gambar' => $produk->gambar,
            // 'password' => $request->input('password'),
        ]);

        $produk->save();

        return redirect()->route('index.produk');
    }

    public function destroy($id){
        $produk = Produks::find($id);

        $produk->delete();
    
        return redirect()->back()->with('deleted', 'Berhasil menghapus user!');

    }

    public function updateStok($id) {
        $produk = Produks::find($id);
        return view('produk.updateStok', compact('produk'));
    }

    public function updateStokProduk(Request $request, $id){
        
        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $produk = Produks::find($id);

        if(!$produk){
            return redirect()->back()->with('error', 'produk tidka ditemukan');
        }

        $produk->stok = $request->stok;

        $produk->save();

        return redirect()->route('index.produk')->with('success', 'Berhasil update stok');
    }
}
