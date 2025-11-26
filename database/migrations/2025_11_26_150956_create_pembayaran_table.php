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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rental');
            $table->enum('metode_bayar', ['transfer', 'cash']);
            $table->decimal('jumlah_bayar', 15,2);
            $table->date('tanggal_bayar');
            $table->timestamps();

            $table->foreign('id_rental')->references('id')->on('rental')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
