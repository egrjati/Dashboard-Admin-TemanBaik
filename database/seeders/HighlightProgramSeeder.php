<?php

namespace Database\Seeders;

use App\Models\HighlightProgram;
use Illuminate\Database\Seeder;

class HighlightProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            ['label' => 'Bidang Kemanusiaan', 'desc' => 'Memberikan bantuan darurat bagi korban bencana dan masyarakat yang membutuhkan pertolongan segera.',                        'href' => '/program/kemanusiaan', 'order' => 1],
            ['label' => 'Bidang Pendidikan',  'desc' => 'Memastikan setiap anak mendapat akses pendidikan berkualitas melalui beasiswa dan fasilitas belajar.',                     'href' => '/program/pendidikan',  'order' => 2],
            ['label' => 'Bidang Ekonomi',     'desc' => 'Memberdayakan keluarga prasejahtera dengan pelatihan usaha dan modal kerja yang tepat sasaran.',                           'href' => '/program/ekonomi',     'order' => 3],
            ['label' => 'Bidang Kesehatan',   'desc' => 'Menghadirkan layanan kesehatan gratis dan edukasi hidup sehat di daerah terpencil.',                                       'href' => '/program/kesehatan',   'order' => 4],
            ['label' => 'Bidang Sosial',      'desc' => 'Membangun komunitas yang saling peduli dan mendukung antar sesama warga masyarakat.',                                      'href' => '/program/sosial',      'order' => 5],
            ['label' => 'Bidang Dakwah',      'desc' => 'Menyebarkan nilai-nilai kebaikan dan membina akhlak masyarakat melalui kegiatan dakwah.',                                  'href' => '/program/dakwah',      'order' => 6],
        ];

        foreach ($programs as $data) {
            HighlightProgram::firstOrCreate(
                ['label' => $data['label']],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
