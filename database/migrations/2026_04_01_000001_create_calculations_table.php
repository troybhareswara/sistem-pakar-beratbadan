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
        Schema::create('calculations', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('umur');
            $table->enum('jenis_kelamin', ['laki', 'perempuan']);
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('tinggi_badan', 5, 2);
            $table->enum('tingkat_aktivitas', ['sedenter', 'ringan', 'sedang', 'berat', 'atlet']);
            $table->enum('tujuan', ['maintain', 'lose', 'gain']);
            $table->decimal('bmi', 5, 2);
            $table->string('klasifikasi_bmi', 50);
            $table->decimal('bmr', 7, 2);
            $table->decimal('tdee', 7, 2);
            $table->decimal('kalori_rekomendasi', 7, 2);
            $table->text('rekomendasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculations');
    }
};
