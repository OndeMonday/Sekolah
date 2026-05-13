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
Schema::create('class_student', function (Blueprint $table) {

    $table->string('class_name'); 
    $table->string('student_nisn');

    $table->foreign('class_name')
        ->references('name')
        ->on('classes')
        ->onDelete('cascade')
        ->onUpdate('cascade');

    $table->foreign('student_nisn')
        ->references('nisn_nip')
        ->on('users')
        ->cascadeOnDelete();

    $table->unique(['class_name', 'student_nisn']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_student');
    }
};
