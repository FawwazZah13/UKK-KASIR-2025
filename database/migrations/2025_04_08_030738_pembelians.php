<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('total_harga');
            $table->bigInteger('total_bayar');
            $table->bigInteger('total_kembalian');
            $table->bigInteger('poin');
            $table->bigInteger('total_poin');
            $table->date('tanggal_pembelian');
            $table->bigInteger('user_id');
            $table->bigInteger('customer_id');
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
