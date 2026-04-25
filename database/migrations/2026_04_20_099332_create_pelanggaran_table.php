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
Schema::create('pelanggaran', function (Blueprint $table) {
    $table->id();
    $table->string('Pelapor');
    $table->string('Terlapor');
    $table->integer('Pelanggaran_id');

    $table->foreign('Pelapor')->references('nisn_nip')->on('users')->cascadeOnDelete();
    $table->foreign('Terlapor')->references('nisn_nip')->on('users')->cascadeOnDelete();

    $table->foreignId('tipe_pelanggaran_id')
          ->constrained('tipe_pelanggaran')
          ->cascadeOnDelete();
    $table->text('catatan');

    $table->string('foto')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};
