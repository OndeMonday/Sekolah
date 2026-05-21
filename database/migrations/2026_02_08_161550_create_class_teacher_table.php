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
Schema::create('class_teacher', function (Blueprint $table) {
    $table->string('classes_class');

    $table->string('teacher_nip');

    $table->foreign('classes_class')
    ->references('name')
    ->on('classes')
    ->onDelete('cascade')
    ->onUpdate('cascade');

    $table->foreign('teacher_nip')
        ->references('nisn_nip')
        ->on('users')
        ->cascadeOnDelete()
        ->cascadeOnUpdate();

    $table->enum('mapel', ['matematika','sejarah','ipa','ips'])->nullable();
    $table->boolean('walikelas')->default(false);

    $table->unique(['classes_class', 'teacher_nip']);
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_teacher');
    }
};
