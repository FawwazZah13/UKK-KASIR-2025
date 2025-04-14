<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'pembelian_id',
        'qty',
        'sub_total',
        'produk_id'
    ];

    public function pembelian() { return $this->belongsTo(Pembelian::class); }
    public function produk() { return $this->belongsTo(Produks::class); }
}

