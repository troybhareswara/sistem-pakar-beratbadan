<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    use HasFactory;

    protected $table = 'calculations';

    protected $fillable = [
        'nama',
        'umur',
        'jenis_kelamin',
        'berat_badan',
        'tinggi_badan',
        'tingkat_aktivitas',
        'tujuan',
        'bmi',
        'klasifikasi_bmi',
        'bmr',
        'tdee',
        'kalori_rekomendasi',
        'rekomendasi',
    ];

    public static array $activityLabels = [
        'sedenter' => 'Sedenter (Jarang olahraga)',
        'ringan' => 'Ringan (Olahraga 1-3 hari/minggu)',
        'sedang' => 'Sedang (Olahraga 3-5 hari/minggu)',
        'berat' => 'Berat (Olahraga 6-7 hari/minggu)',
        'atlet' => 'Atlet (Olahraga 2x/hari)',
    ];

    public static array $goalLabels = [
        'maintain' => 'Menjaga berat badan',
        'lose' => 'Menurunkan berat badan',
        'gain' => 'Menambah berat badan',
    ];

    public static array $genderLabels = [
        'laki' => 'Laki-laki',
        'perempuan' => 'Perempuan',
    ];

    public function getActivityLabelAttribute(): string
    {
        return self::$activityLabels[$this->tingkat_aktivitas] ?? $this->tingkat_aktivitas;
    }

    public function getGoalLabelAttribute(): string
    {
        return self::$goalLabels[$this->tujuan] ?? $this->tujuan;
    }

    public function getGenderLabelAttribute(): string
    {
        return self::$genderLabels[$this->jenis_kelamin] ?? $this->jenis_kelamin;
    }
}
