<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembelianController;

Route::get('/', function () {
    return view('login');
})->name('login');


Route::post('/login', [UserController::class, 'login'])->name('login.auth');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout.user');
    Route::get('/produk', [ProdukController::class, 'index'])->name('index.produk');
    // Route::get('/produk/search', [ProdukController::class, 'search'])->name('search.produk');

    Route::get('/show/produk', [PembelianController::class, 'show'])->name('showProduk.pembelian');
    Route::get('/pembelian', [PembelianController::class, 'index'])->name('index.pembelian');
    Route::get('/pembelian/{id}/unduh-pdf', [PembelianController::class, 'unduhPdf'])->name('unduhPdf.pembelian');
    Route::get('/export/pembelian', [PembelianController::class, 'export'])->name('excel.pembelian');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    // ROUTE DATA USER
    Route::get('/users', [UserController::class, 'index'])->name('index.user');
    Route::get('/create/users', [UserController::class, 'create'])->name('create.user');
    Route::post('/create/users/new', [UserController::class, 'store'])->name('new.user');
    Route::get('/edit/users/{id}', [UserController::class, 'edit'])->name('edit.user');
    Route::put('/update/users/{id}', [UserController::class, 'update'])->name('update.user');
    Route::delete('/delete/users/{id}', [UserController::class, 'destroy'])->name('delete.user');

    // ROUTE PRODUK
// Route::get('/produk', [ProdukController::class, 'index'])->name('index.produk');
    Route::get('/create/produk', [ProdukController::class, 'create'])->name('create.produk');
    Route::post('/create/produk/new', [ProdukController::class, 'store'])->name('new.produk');
    Route::get('/edit/produk/{id}', [ProdukController::class, 'edit'])->name('edit.produk');
    Route::put('/update/produk/{id}', [ProdukController::class, 'update'])->name('update.produk');
    Route::get('/updateStok/{id}', [ProdukController::class, 'updateStok'])->name('updateStok.produk');
    Route::put('/updateStok/produk/{id}', [ProdukController::class, 'updateStokProduk'])->name('updateStokProduk.produk');
    Route::delete('/delete/produk/{id}', [ProdukController::class, 'destroy'])->name('delete.produk');

});

Route::middleware(['auth', 'role:petugas'])->group(function () {

    //ROUTE PEMBELIAN
Route::get('/create/pembelian', [PembelianController::class, 'create'])->name('create.pembelian');
Route::post('/cart/pembelian', [PembelianController::class, 'cart'])->name('cart.pembelian');
Route::get('/cart/pembelian/checkout', [PembelianController::class, 'checkout'])->name('checkout.pembelian');

//NON MEMBER
Route::post('/post', [PembelianController::class, 'store'])->name('post.pembelian');

//MEMBER
Route::get('/post/view/member', [PembelianController::class, 'member'])->name('member.pembelian');
Route::get('/detail/{id}', [PembelianController::class, 'detail'])->name('detail.pembelian');



});
