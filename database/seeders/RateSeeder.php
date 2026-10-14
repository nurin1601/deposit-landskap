<?php

namespace Database\Seeders;

use App\Models\GreenAreaRate;
use App\Models\HardItem;
use App\Models\SoftRate;
use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    public function run(): void
    {
        $a = fn ($group, $category, $tier, $amount) => [
            'group' => $group, 'category' => $category, 'tier' => $tier, 'amount' => $amount,
        ];

        $kediaman = 'Tujuan Kediaman';
        $bukan = 'Bukan Tujuan Kediaman';
        $industri = 'Perindustrian';
        $rekreasi = 'Kawasan Rekreasi / Taman Rekreasi';
        $campur = 'Pembangunan Bercampur';
        $lain = 'Lain-lain';

        // A) Kawasan Hijau
        GreenAreaRate::insert([
            $a($kediaman, 'Perumahan', '50 unit dan ke bawah', 3000),
            $a($kediaman, 'Perumahan', '51 hingga 100 unit', 5000),
            $a($kediaman, 'Perumahan', '101 hingga 200 unit', 8000),
            $a($kediaman, 'Perumahan', '201 unit dan ke atas', 10000),
            $a($kediaman, 'Pangsapuri / Kondominium', 'Di bawah 2 ekar', 3000),
            $a($kediaman, 'Pangsapuri / Kondominium', '2.01 ekar hingga 5 ekar', 5000),
            $a($kediaman, 'Pangsapuri / Kondominium', '5.01 ekar hingga 10 ekar', 8000),
            $a($kediaman, 'Pangsapuri / Kondominium', '10.01 ekar ke atas', 10000),

            $a($bukan, 'Kompleks membeli-belah', null, 8000),
            $a($bukan, 'Pasar raya', null, 5000),
            $a($bukan, 'Hotel', null, 8000),
            $a($bukan, 'Resort/Chalet/Rumah penginapan', null, 5000),
            $a($bukan, 'Institusi swasta', null, 5000),
            $a($bukan, 'Pusat perubatan swasta', null, 8000),
            $a($bukan, 'Dewan swasta', null, 3000),
            $a($bukan, 'Kompleks sukan', null, 10000),
            $a($bukan, 'Restoran (binaan sesebuah)', null, 3000),
            $a($bukan, 'Stesen minyak', null, 8000),
            $a($bukan, 'Lot kedai pejabat / rumah kedai', 'Kurang 4 unit', 3000),
            $a($bukan, 'Lot kedai pejabat / rumah kedai', '5 - 10 unit', 5000),
            $a($bukan, 'Lot kedai pejabat / rumah kedai', '11 hingga 20 unit', 8000),
            $a($bukan, 'Lot kedai pejabat / rumah kedai', '21 unit dan ke atas', 10000),
            $a($bukan, 'Dewan pameran', null, 5000),

            $a($industri, 'Pembangunan plot perindustrian', 'Di bawah 2 ekar', 10000),
            $a($industri, 'Pembangunan plot perindustrian', '2.01 ekar hingga 5 ekar', 12000),
            $a($industri, 'Pembangunan plot perindustrian', '5.01 ekar hingga 10 ekar', 15000),
            $a($industri, 'Pembangunan plot perindustrian', '10.01 ekar dan ke atas', 18000),

            $a($rekreasi, 'Taman Tema / Padang Golf (Swasta)', 'Di bawah 2 ekar', 10000),
            $a($rekreasi, 'Taman Tema / Padang Golf (Swasta)', '2.01 ekar hingga 5 ekar', 12000),
            $a($rekreasi, 'Taman Tema / Padang Golf (Swasta)', '5.01 ekar hingga 10 ekar', 15000),
            $a($rekreasi, 'Taman Tema / Padang Golf (Swasta)', '10.01 ekar dan ke atas', 18000),

            $a($campur, 'Projek pembangunan bercampur', 'Kurang 50 unit', 8000),
            $a($campur, 'Projek pembangunan bercampur', '51 unit hingga 100 unit', 10000),
            $a($campur, 'Projek pembangunan bercampur', '101 unit dan ke atas', 12000),

            $a($lain, 'Lebuh raya', null, 8000),
            $a($lain, 'Stadium', null, 5000),
            $a($lain, 'IPTA', null, 5000),
            $a($lain, 'Agensi/Institusi kerajaan', null, 5000),
            $a($lain, 'Rumah Penginapan Kerajaan', null, 3000),
            $a($lain, 'Jalan awam', null, 5000),
            $a($lain, 'Bangunan tadika / pusat asuhan / pusat jagaan orang tua dan lain-lain', null, 3000),
            $a($lain, 'Institusi keagamaan', null, 3000),
            $a($lain, 'Lain-lain pembangunan', null, 10000),
        ]);

        // B) Landskap Lembut
        SoftRate::insert([
            ['name' => 'Pokok Utama', 'rate' => 5.00, 'unit' => 'pokok'],
            ['name' => 'Palma', 'rate' => 5.00, 'unit' => 'pokok'],
            ['name' => 'Renek Individu', 'rate' => 2.50, 'unit' => 'pokok'],
            ['name' => 'Renek Kelompok', 'rate' => 1.50, 'unit' => 'm2'],
            ['name' => 'Penutup Bumi', 'rate' => 1.00, 'unit' => 'm2'],
            ['name' => 'Rumput', 'rate' => 0.50, 'unit' => 'm2'],
        ]);

        // C) Landskap Kejur
        HardItem::insert([
            ['group' => null, 'name' => 'Par Course/Fitness Station', 'rate' => 500, 'unit' => 'unit'],
            ['group' => null, 'name' => 'Outdoor Gym', 'rate' => 500, 'unit' => 'unit'],
            ['group' => null, 'name' => 'Gelanggang Serbaguna', 'rate' => 200, 'unit' => 'm2'],
            ['group' => null, 'name' => 'Wakaf', 'rate' => 200, 'unit' => 'unit'],

            ['group' => 'Perabot Landskap', 'name' => 'Bangku Taman', 'rate' => 200, 'unit' => 'unit'],
            ['group' => 'Perabot Landskap', 'name' => 'Tong Sampah', 'rate' => 200, 'unit' => 'unit'],
            ['group' => 'Perabot Landskap', 'name' => 'Laluan Pejalan Kaki', 'rate' => 50, 'unit' => 'm2'],
            ['group' => 'Perabot Landskap', 'name' => 'Papan Tanda Peringatan', 'rate' => 50, 'unit' => 'unit'],

            ['group' => 'Alatan Permainan', 'name' => 'Integrated Structure', 'rate' => 5000, 'unit' => 'unit'],
            ['group' => 'Alatan Permainan', 'name' => 'Swing', 'rate' => 200, 'unit' => 'unit'],
            ['group' => 'Alatan Permainan', 'name' => '2 Seater See Saw', 'rate' => 200, 'unit' => 'unit'],
            ['group' => 'Alatan Permainan', 'name' => 'Lain-lain (nyatakan)', 'rate' => 1000, 'unit' => 'l/s'],
        ]);
    }
}