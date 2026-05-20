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
Schema::create('tasks', function (Blueprint $table) {
    $table->uuid('id')->primary();

    $table->string('classes_class');

    $table->string('teacher_nip');

    $table->foreign('classes_class')
        ->references('name')
        ->on('classes')
        ->cascadeOnDelete();

    $table->foreign('teacher_nip')
        ->references('nisn_nip')
        ->on('users')
        ->cascadeOnDelete();

    $table->string('title');
    $table->text('description')->nullable();
    $table->string('image_path')->nullable();
    $table->dateTime('deadline');
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
