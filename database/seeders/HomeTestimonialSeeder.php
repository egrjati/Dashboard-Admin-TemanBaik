<?php

namespace Database\Seeders;

use App\Models\HomeTestimonial;
use Illuminate\Database\Seeder;

class HomeTestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Andini Pratama',  'role' => 'Donatur',          'location' => 'Jakarta',       'quote' => 'Laporannya jelas dan saya bisa memilih program sesuai kepedulian saya. Sudah jadi rutinitas bulanan yang menenangkan.',                                    'order' => 1],
            ['name' => 'Bu Maryam',       'role' => 'Penerima Manfaat', 'location' => 'Aceh Tamiang',  'quote' => 'Setelah banjir, bantuan huntara dari TemanBaik sangat berarti. Keluarga kami bisa tinggal dengan layak sambil menata ulang.',                           'order' => 2],
            ['name' => 'PT Sinar Berkah', 'role' => 'Mitra',            'location' => 'Surabaya',      'quote' => 'Kolaborasi program CSR berjalan transparan dan terukur. Tim TemanBaik responsif dan profesional dari awal hingga laporan akhir.',                       'order' => 3],
            ['name' => 'Rizky Hartono',   'role' => 'Donatur',          'location' => 'Bandung',       'quote' => 'Proses donasi cepat, dan saya suka bisa melihat update foto serta laporan penyaluran. Beneran kerasa amanahnya sampai.',                                 'order' => 4],
            ['name' => 'Ustadz Hamid',    'role' => 'Penerima Manfaat', 'location' => 'Medan',         'quote' => 'Program pendidikan untuk santri sangat membantu. Anak-anak jadi punya kesempatan belajar yang dulu sulit kami jangkau.',                                 'order' => 5],
            ['name' => 'Komunitas Peduli','role' => 'Mitra',            'location' => 'Yogyakarta',    'quote' => 'Sinergi distribusi qurban berjalan rapi sampai pelosok. Sistem TemanBaik memudahkan pelaporan ke seluruh anggota komunitas.',                           'order' => 6],
            ['name' => 'Sari Wulandari',  'role' => 'Donatur',          'location' => 'Semarang',      'quote' => 'Saya tetap mempercayakan zakat profesi saya di sini karena kredibilitas dan kemudahan platformnya. Highly recommended.',                                 'order' => 7],
            ['name' => 'Pak Sugeng',      'role' => 'Penerima Manfaat', 'location' => 'Lombok',        'quote' => 'Bantuan modal usaha mengubah hidup keluarga kami. Sekarang warung kecil saya bisa menopang biaya sekolah anak.',                                         'order' => 8],
        ];

        foreach ($testimonials as $data) {
            HomeTestimonial::firstOrCreate(
                ['name' => $data['name'], 'location' => $data['location']],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
