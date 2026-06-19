<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('name', 200);
            $table->enum('type', ['multiple_choice', 'essay'])->default('multiple_choice');
            $table->enum('question_order', ['random', 'sequential'])->default('random');
            $table->integer('total_questions');
            $table->integer('duration'); // in minutes
            $table->string('token', 10);
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
