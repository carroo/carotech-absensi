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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa'); // 0: Superadmin, 1: Guru, 2: Siswa
            $table->string('alamat')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('foto')->nullable()->default('avatar-1.png');
            $table->string('nomor_induk')->nullable();
            $table->unsignedBigInteger('kelas_id')->nullable(); // Kolom kelas_id untuk kelas siswa
            $table->timestamps();
        });
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
