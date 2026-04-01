<?php

namespace App\Services;

class ExpertSystemService
{
    public static array $activityMultipliers = [
        'sedenter' => 1.2,
        'ringan' => 1.375,
        'sedang' => 1.55,
        'berat' => 1.725,
        'atlet' => 1.9,
    ];

    public static array $calorieAdjustments = [
        'maintain' => 0,
        'lose' => -500,
        'gain' => 500,
    ];

    public static function calculateBMI(float $weight, float $height): float
    {
        $heightInMeters = $height / 100;
        return $weight / ($heightInMeters * $heightInMeters);
    }

    public static function classifyBMI(float $bmi): string
    {
        if ($bmi < 18.5) {
            return 'Kurus';
        } elseif ($bmi < 25) {
            return 'Normal';
        } elseif ($bmi < 30) {
            return 'Berat Badan Berlebih';
        } else {
            return 'Obesitas';
        }
    }

    public static function getBMIColor(string $classification): string
    {
        return match ($classification) {
            'Kurus' => 'blue',
            'Normal' => 'green',
            'Berat Badan Berlebih' => 'yellow',
            'Obesitas' => 'red',
            default => 'gray',
        };
    }

    public static function calculateBMR(float $weight, float $height, int $age, string $gender): float
    {
        // Mifflin-St Jeor Equation
        // Male: BMR = 10 × Weight(kg) + 6.25 × Height(cm) - 5 × Age + 5
        // Female: BMR = 10 × Weight(kg) + 6.25 × Height(cm) - 5 × Age - 161

        $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age);

        if ($gender === 'laki') {
            $bmr += 5;
        } else {
            $bmr -= 161;
        }

        return $bmr;
    }

    public static function calculateTDEE(float $bmr, string $activityLevel): float
    {
        $multiplier = self::$activityMultipliers[$activityLevel] ?? 1.2;
        return $bmr * $multiplier;
    }

    public static function calculateRecommendedCalories(float $tdee, string $goal): float
    {
        $adjustment = self::$calorieAdjustments[$goal] ?? 0;
        return $tdee + $adjustment;
    }

    public static function generateRecommendations(array $data): string
    {
        $recommendations = [];

        // BMI-based recommendations
        $bmiRec = self::getBMIRecommendation($data['klasifikasi_bmi'], $data['berat_badan'], $data['tujuan']);
        $recommendations[] = $bmiRec;

        // Activity-based recommendations
        $activityRec = self::getActivityRecommendation($data['tingkat_aktivitas']);
        $recommendations[] = $activityRec;

        // Goal-based recommendations
        $goalRec = self::getGoalRecommendation($data['tujuan'], $data['kalori_rekomendasi']);
        $recommendations[] = $goalRec;

        // General health recommendations
        $generalRec = self::getGeneralRecommendations($data['jenis_kelamin'], $data['umur']);
        $recommendations[] = $generalRec;

        return implode("\n\n", $recommendations);
    }

    private static function getBMIRecommendation(string $classification, float $weight, string $goal): string
    {
        return match ($classification) {
            'Kurus' => "Berdasarkan BMI Anda, Anda termasuk dalam kategori *Kurus* (BMI < 18.5) dengan berat badan {$weight} kg. " .
                "Disarankan untuk meningkatkan asupan kalori secara sehat dengan makanan bergizi dan olahraga teratur untuk membentuk massa otot.",

            'Normal' => "BMI Anda berada dalam kategori *Normal* ({$weight} kg), ini adalah tanda bahwa berat badan Anda sudah ideal. " .
                "Pertahankan pola makan seimbang dan gaya hidup aktif untuk menjaga kesehatan Anda.",

            'Berat Badan Berlebih' => "BMI Anda termasuk kategori *Berat Badan Berlebih* ({$weight} kg). " .
                "Disarankan untuk mengurangi asupan kalori berlebih dan meningkatkan aktivitas fisik untuk mencapai berat badan ideal.",

            'Obesitas' => "BMI Anda termasuk kategori *Obesitas* ({$weight} kg). " .
                "Sangat disarankan untuk berkonsultasi dengan dokter atau ahli gizi untuk membuat rencana penurunan berat badan yang aman dan efektif.",

            default => "Tidak dapat memberikan rekomendasi berdasarkan data yang diberikan.",
        };
    }

    private static function getActivityRecommendation(string $activityLevel): string
    {
        return match ($activityLevel) {
            'sedenter' => "Tingkat aktivitas *Sedenter* menunjukkan Anda jarang melakukan olahraga. " .
                "Disarankan untuk mulai menambah aktivitas fisik ringan seperti jalan kaki 30 menit setiap hari dan secara bertahap meningkatkan intensitasnya.",

            'ringan' => "Tingkat aktivitas *Ringan* cukup baik. Anda berolahraga 1-3 hari per minggu. " .
                "Coba tambahkan 1-2 sesi olahraga lagi per minggu untuk hasil yang lebih optimal.",

            'sedang' => "Tingkat aktivitas *Sedang* sudah bagus dengan olahraga 3-5 hari per minggu. " .
                "Pertahankan rutinitas ini dan fokus pada kualitas latihan serta pola makan yang seimbang.",

            'berat' => "Tingkat aktivitas *Berat* menunjukkan Anda sangat aktif dengan olahraga 6-7 hari per minggu. " .
                "Pastikan Anda mendapatkan cukup istirahat dan nutrisi untuk memulihkan tubuh setelah latihan intensif.",

            'atlet' => "Sebagai *Atlet*, Anda memiliki tingkat aktivitas sangat tinggi. " .
                "Pastikan kebutuhan kalori dan protein Anda terpenuhi untuk mendukung performa dan pemulihan optimal.",

            default => "Tidak dapat memberikan rekomendasi aktivitas.",
        };
    }

    private static function getGoalRecommendation(string $goal, float $calories): string
    {
        return match ($goal) {
            'maintain' => "Tujuan Anda adalah *Menjaga berat badan*. " .
                "Konsumsi sekitar " . round($calories) . " kkal per hari untuk mempertahankan berat badan saat ini. " .
                "Pastikan makanan Anda mengandung nutrisi seimbang.",

            'lose' => "Tujuan Anda adalah *Menurunkan berat badan*. " .
                "Konsumsi sekitar " . round($calories) . " kkal per hari (defisit 500 kkal dari TDEE). " .
                "Fokus pada makanan tinggi protein dan rendah lemak untuk mempertahankan massa otot saat membakar lemak.",

            'gain' => "Tujuan Anda adalah *Menambah berat badan*. " .
                "Konsumsi sekitar " . round($calories) . " kkal per hari (surplus 500 kkal dari TDEE). " .
                "Prioritaskan makanan kaya protein dan karbohidrat kompleks untuk membangun massa otot, bukan lemak.",

            default => "Tidak dapat memberikan rekomendasi tujuan.",
        };
    }

    private static function getGeneralRecommendations(string $gender, int $age): string
    {
        $genderText = ($gender === 'laki') ? 'Laki-laki' : 'Perempuan';

        $ageRecommendation = match (true) {
            $age < 18 => "Sebagai remaja, kebutuhan kalori dan nutrisi masih tinggi untuk pertumbuhan. " .
                "Pastikan asupan kalsium dan vitamin D cukup untuk perkembangan tulang.",
            $age < 30 => "Pada usia muda ini, metabolisme Anda masih sangat aktif. " .
                "Manfaatkan kesempatan ini untuk membangun kebiasaan hidup sehat.",
            $age < 50 => "Di usia ini, metabolisme mulai melambat. " .
                "Perhatikan asupan kalori dan tingkatkan aktivitas fisik untuk menjaga berat badan ideal.",
            default => "Untuk usia {$age} tahun, penting untuk menjaga massa otot dan kepadatan tulang. " .
                "Konsumsi cukup protein dan kalsium, serta lakukan olahraga beban ringan secara teratur.",
        };

        return "Sebagai {$genderText} berusia {$age} tahun, {$ageRecommendation}";
    }

    public static function processCalculation(array $input): array
    {
        $bmi = self::calculateBMI($input['berat_badan'], $input['tinggi_badan']);
        $klasifikasi = self::classifyBMI($bmi);
        $bmr = self::calculateBMR($input['berat_badan'], $input['tinggi_badan'], $input['umur'], $input['jenis_kelamin']);
        $tdee = self::calculateTDEE($bmr, $input['tingkat_aktivitas']);
        $kaloriRekomendasi = self::calculateRecommendedCalories($tdee, $input['tujuan']);

        $data = [
            'nama' => $input['nama'],
            'umur' => $input['umur'],
            'jenis_kelamin' => $input['jenis_kelamin'],
            'berat_badan' => $input['berat_badan'],
            'tinggi_badan' => $input['tinggi_badan'],
            'tingkat_aktivitas' => $input['tingkat_aktivitas'],
            'tujuan' => $input['tujuan'],
            'bmi' => round($bmi, 2),
            'klasifikasi_bmi' => $klasifikasi,
            'bmr' => round($bmr, 2),
            'tdee' => round($tdee, 2),
            'kalori_rekomendasi' => round($kaloriRekomendasi, 2),
        ];

        $data['rekomendasi'] = self::generateRecommendations($data);

        return $data;
    }
}
