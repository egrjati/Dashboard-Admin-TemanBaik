<?php

namespace Database\Seeders;

use App\Models\HomeCta;
use Illuminate\Database\Seeder;

class HomeCtaSeeder extends Seeder
{
    public function run(): void
    {
        if (HomeCta::count() === 0) {
            HomeCta::create([
                'heading_before'    => 'Jadi Bagian dari',
                'heading_highlight' => 'Kehebatan Mereka Berkontribusi',
                'heading_after'     => 'untuk Masyarakat',
                'body'              => 'Tidak harus menunggu kaya untuk berkontribusi, mulai sekarang kamu bisa ikut serta memberi manfaat untuk mereka dengan gabung ke Relawan Kemandirian.',
                'button_label'      => 'Gabung Sekarang',
                'button_href'       => '/kemitraan/volunteer',
                'bg_image'          => null,
                'cartoon_image'     => null,
            ]);
        }
    }
}
