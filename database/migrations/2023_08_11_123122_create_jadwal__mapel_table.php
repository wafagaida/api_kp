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
        Schema::create('jadwal__mapel', function (Blueprint $table) {
            $table->id();
            $table->string('kd_mapel', 10);
            $table->string('hari', 10);
            $table->string('ruang', 45);
            $table->string('jam', 25);
            $table->enum('jurusan', ['Farmasi', 'Teknik Sepeda Motor', 'Desain Komunikasi Visual 1', 'Desain Komunikasi Visual 2']);
            $table->enum('kelas', ['X', 'XI', 'XII']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal__mapel');
    }
};
