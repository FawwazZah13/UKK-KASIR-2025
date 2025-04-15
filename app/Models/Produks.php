<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produks extends Model
{
    protected $fillable = [
        'nama_produk',
        'harga',
        'stok',
        'gambar'
    ];
    public function details()
{
    return $this->hasMany(Detail::class, 'produk_id'); // atau relasi sesuai nama model dan tabel kamu
}

}
