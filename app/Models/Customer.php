<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'no_tlp',
        'poin',
        'status_customer',
    ];

    public function pembelian(){
        return $this->hasMany(Pembelian::class, 'customer_id');
    }
}
