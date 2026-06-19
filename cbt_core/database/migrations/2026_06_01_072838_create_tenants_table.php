<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah', 150);
            $table->string('slug', 80)->unique();
            $table->string('email', 150)->unique();
            $table->string('phone', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['trial', 'free', 'premium'])->default('trial');
            $table->date('trial_ends_at')->nullable();
            $table->date('expired_at')->nullable();
            $table->integer('max_students')->default(30);
            $table->integer('max_teachers')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
