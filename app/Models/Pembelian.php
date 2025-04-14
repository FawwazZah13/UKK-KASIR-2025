<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = [
        'total_harga',
        'total_bayar',
        'total_kembalian',
        'poin',
        'total_poin',
        'tanggal_pembelian',
        'user_id',
        'customer_id',
    ];

    public function details(){
        return $this->hasMany(Detail::class);
    }
    public function user(){
       return $this->belongsTo(User::class, 'user_id');
    }
    public function customer(){
       return $this->belongsTo(Customer::class, 'customer_id');
    }
}

