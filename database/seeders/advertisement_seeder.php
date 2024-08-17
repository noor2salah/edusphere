<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class advertisement_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('advertisements')->insert([
            [
                'class_id' => 1,

                'type'=>'exam',
                'photo_path' => "/storage/images/Black & Yellow Modern Exclusive Furniture Poster.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 2,

                'type'=>'other',
                'photo_path' => "/storage/images/Business Webinar Poster.png",
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'class_id' => 1,

                'type'=>'trip',
                'photo_path' => "/storage/images/Blue Simple Modern Time To Travel Poster.png",
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'class_id' => 3,

                'type'=>'results',
                'photo_path' => "/storage/images/Green and Orange Back to School Worksheet 1st Grade.jpg",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 2,

                'type'=>'other',
                'photo_path' => "/storage/images/Blue Creative Time To Travel Instagram Post.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 1,

                'type'=>'instuctions',
                'photo_path' => "/storage/images/White Minimalist Exclusive Bedroom Instagram Post.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 2,

                'type'=>'wallet',
                'photo_path' => "/storage/images/Green Minimalist Exclusive Hotel Instagram Story.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 3,

                'type'=>'exam',
                'photo_path' => "/storage/images/Time To Travel (Flyer).png",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 1,

                'type'=>'exam',
                'photo_path' => "/storage/images/Modern Business Conference Announcement Instagram Post.png",
                'created_at' => now(),
                'updated_at' => now(),
            ],



        ]);
    }
}
