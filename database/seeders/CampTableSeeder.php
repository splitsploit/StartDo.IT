<?php

namespace Database\Seeders;

use App\Models\Camp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CampTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $camps = [
            [
                'title' => 'Intermediate Class',
                'slug' => Str::slug('Intermediate Class'),
                'price' => 140,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ],
            [
                'title' => 'Beginner Class',
                'slug' => Str::slug('Beginner Class'),
                'price' => 280,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time())
            ]
            ];

        // first method ( not mandatory define created_at & updated_at )
        // foreach ($camps as $key => $camp) {
        //     Camp::create($camp);
        // };

        Camp::insert($camps);
    }
}