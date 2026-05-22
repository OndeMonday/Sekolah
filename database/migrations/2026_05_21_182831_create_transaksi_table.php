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
        Schema::create('transaksi', function (Blueprint $table) {
    $table->id();
    $table->string('user_id');
    

    $table->foreign('user_id')
        ->references('nisn_nip')
        ->on('users')
        ->cascadeOnDelete()
        ->cascadeOnUpdate();

    $table->integer('total_harga')->default(0);

    $table->enum('status', [
        'pending',
        'sukses',
        'gagal'
    ])->default('pending');

    $table->string('kode_pembayaran')->nullable();

    $table->string('metode_pembayaran')
        ->default('qris');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
