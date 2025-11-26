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
        Schema::create('detailpembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rental');
            $table->decimal('denda', 15,2)->default(0);
            $table->date('tanggal_pengembalian_aktual')->nullable();
            $table->timestamps();

            $table->foreign('id_rental')->references('id')->on('rental')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailpembayaran');
    }
};
