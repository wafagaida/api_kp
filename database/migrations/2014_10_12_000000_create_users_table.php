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
            // $table->id();
            $table->string('nis', 45)->primary();
            $table->string('nik', 45)->nullable();
            $table->string('username', 45)->unique();
            $table->mediumText('password', 45);
            $table->string('nama', 100);
            $table->string('jenis_kelamin', 45);
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('kelas', ['X', 'XI', 'XII']);
            $table->string('jurusan', 45);
            $table->string('kd_kelas', 45);
            $table->string('no_tlp', 45)->nullable();
            $table->string('tahun_masuk', 5);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
