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
        Schema::create('submissions', function (Blueprint $table) {
    $table->uuid('id')->primary();

    $table->string('task_id');

    $table->foreign('task_id')->references('id')->on('tasks')->cascadeOnDelete();

    $table->string('student_id');
    $table->foreign('student_id')->references('nisn_nip')->on('users')->cascadeOnDelete();

    $table->string('image_path');
    $table->text('description')->nullable();

    $table->enum('status', ['submitted','late','approved','rejected'])->default('submitted');

    $table->decimal('nilai',5,2)->nullable();

    $table->timestamp('approved_at')->nullable();
    $table->timestamp('submitted_at')->useCurrent(); 

    $table->text('teacher_note')->nullable();

    $table->timestamps();

    $table->unique(['task_id', 'student_id']);
    $table->index(['task_id','status']);
});
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
