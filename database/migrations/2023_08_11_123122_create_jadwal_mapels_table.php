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
        Schema::create('jadwal__mapels', function (Blueprint $table) {
            $table->id();
            $table->string('kd_mapel', 10);
            $table->string('hari', 10);
            $table->string('jam', 25);
            $table->string('kd_kelas', 25);
            $table->enum('tingkat', ['X', 'XI', 'XII']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal__mapels');
    }
};
