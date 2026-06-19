<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id');
            $table->longText('question_list');   // JSON array of question IDs
            $table->longText('answers')->nullable(); // JSON: {q_id: answer}
            $table->integer('correct_count')->default(0);
            $table->decimal('score', 8, 2)->default(0);
            $table->decimal('weighted_score', 8, 2)->default(0);
            $table->datetime('started_at')->nullable();
            $table->datetime('finished_at')->nullable();
            $table->enum('status', ['ongoing', 'done', 'cheating'])->default('ongoing');
            $table->timestamps();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
