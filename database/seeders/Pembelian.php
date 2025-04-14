<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Pembelian extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pembelians')->insert([
            'total_harga' => '1000',
            'total_bayar' => '1000',
            'total_kembalian' => '1000',
            'poin' => '50',
            'total_poin' => '100',
            'tanggal_pembelian' => now(),
            'user_id' => '1',
            'customer_id' => '1',
            'produk_id' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
