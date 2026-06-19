<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->string('nisn', 30)->nullable();
            $table->string('name', 100);
            $table->string('email', 150)->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->timestamps();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('set null');
            $table->unique(['tenant_id', 'nisn']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
