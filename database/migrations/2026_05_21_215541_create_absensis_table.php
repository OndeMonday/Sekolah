<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');

            $table->foreign('user_id')
                ->references('nisn_nip')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('foto');
            $table->text('keterangan')->nullable();

            $table->enum('status', ['masuk', 'pulang','terlambat','izin','sakit','bolos']);

            // lokasi (opsional tapi bagus)
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // waktu otomatis
            $table->timestamps();
    
            $table->index('user_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};