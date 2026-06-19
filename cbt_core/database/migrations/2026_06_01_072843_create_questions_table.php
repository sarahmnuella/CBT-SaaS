<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('subject_id');
            $table->enum('type', ['multiple_choice', 'essay'])->default('multiple_choice');
            $table->longText('question');
            $table->string('image')->nullable();
            $table->longText('option_a')->nullable();
            $table->longText('option_b')->nullable();
            $table->longText('option_c')->nullable();
            $table->longText('option_d')->nullable();
            $table->longText('option_e')->nullable();
            $table->string('answer', 5)->nullable(); // A, B, C, D, or E
            $table->integer('weight')->default(1);
            $table->timestamps();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
