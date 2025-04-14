<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Customer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            'name' => 'Fawwaz',
            'no_tlp' => '123',
            'poin' => '10',
            'status_customer' => 'non-member', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
