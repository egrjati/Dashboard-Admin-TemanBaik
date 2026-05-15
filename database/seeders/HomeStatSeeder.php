<?php

namespace Database\Seeders;

use App\Models\HomeStat;
use Illuminate\Database\Seeder;

class HomeStatSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            [
                'key'         => 'penerima_manfaat',
                'value'       => '1,2 Jt+',
                'label'       => 'PENERIMA MANFAAT',
                'icon'        => 'users',
                'description' => 'Total individu yang telah menerima manfaat langsung dari seluruh program Teman Baik sejak berdiri.',
                'order'       => 1,
            ],
            [
                'key'         => 'donasi_tersalurkan',
                'value'       => 'Rp 98 M+',
                'label'       => 'DONASI TERSALURKAN',
                'icon'        => 'heart',
                'description' => 'Total donasi yang telah berhasil disalurkan secara nyata ke lapangan, diaudit dan dilaporkan secara transparan.',
                'order'       => 2,
            ],
            [
                'key'         => 'wilayah_jangkauan',
                'value'       => '34+',
                'label'       => 'WILAYAH JANGKAUAN',
                'icon'        => 'location',
                'description' => 'Jumlah provinsi dan kabupaten/kota di seluruh Indonesia yang telah dijangkau oleh program-program Teman Baik.',
                'order'       => 3,
            ],
        ];

        foreach ($stats as $stat) {
            HomeStat::updateOrCreate(['key' => $stat['key']], $stat);
        }
    }
}
