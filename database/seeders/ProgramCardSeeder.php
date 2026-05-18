<?php

namespace Database\Seeders;

use App\Models\ProgramCard;
use Illuminate\Database\Seeder;

class ProgramCardSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [
            [
                'name'        => 'Kemanusiaan',
                'slug'        => 'kemanusiaan',
                'description' => 'Program sosial kemanusiaan wujud kepedulian dalam menghadirkan bantuan dan harapan bagi.',
                'icon'        => 'heart-handshake',
                'order'       => 1,
            ],
            [
                'name'        => 'Pendidikan',
                'slug'        => 'pendidikan',
                'description' => 'Program Pendidikan wujud komitmen dalam menghadirkan akses pendidikan berkualitas bagi anak yatim.',
                'icon'        => 'graduation-cap',
                'order'       => 2,
            ],
            [
                'name'        => 'Ekonomi',
                'slug'        => 'ekonomi',
                'description' => 'Program Ekonomi upaya pemberdayaan yang dirancang untuk meningkatkan kemandirian ekonomi masyarakat.',
                'icon'        => 'chart-no-axes-combined',
                'order'       => 3,
            ],
            [
                'name'        => 'Kesehatan',
                'slug'        => 'kesehatan',
                'description' => 'Program Kesehatan hadir memastikan anak yatim dan masyarakat dhuafa mendapatkan layanan kesehatan.',
                'icon'        => 'accessibility',
                'order'       => 4,
            ],
            [
                'name'        => 'Sosial',
                'slug'        => 'sosial',
                'description' => 'Program Sosial bertujuan meningkatkan kesadaran dan partisipasi masyarakat dalam menjaga lingkungan hidup.',
                'icon'        => 'users-round',
                'order'       => 5,
            ],
            [
                'name'        => 'Dakwah',
                'slug'        => 'dakwah',
                'description' => 'Program Dakwah bertujuan memperluas syiar Islam dan meningkatkan kualitas kehidupan umat.',
                'icon'        => 'moon-star',
                'order'       => 6,
            ],
        ];

        foreach ($cards as $card) {
            ProgramCard::firstOrCreate(['slug' => $card['slug']], $card);
        }
    }
}
