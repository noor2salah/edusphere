<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Subject_photos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('photos_about_subjects')->insert([
            [
                'subject_id' => 1,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_id' => 1,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_id' => 2,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_id' => 2,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_id' => 3,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'subject_id' => 3,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_id' => 4,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'subject_id' => 4,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_id' => 5,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'subject_id' => 5,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'subject_id' => 6,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'subject_id' => 6,  // Replace with actual subject_id from 'subjects' table
                'photo_path' => 'photos/photo3.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more photos as needed
        ]);
    }
}
