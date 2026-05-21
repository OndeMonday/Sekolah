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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();

            $table->string('pelapor');
            $table->string('terlapor');

            $table->unsignedBigInteger('pelanggaran_id');

            $table->foreign('pelanggaran_id')
                ->references('id')
                ->on('pelanggaran')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('bukti')->nullable();

            $table->text('keterangan')->nullable();

            $table->enum('status', ['terkirim', 'diterima', 'ditolak'])->default('terkirim');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};