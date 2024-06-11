<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Subject extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('subjects')->insert([
            [
                'name' => 'Mathematics',
                'the_class' => '7',
                'total_grade' => 600,
                'about_subject' => 'Introduction to basic mathematics concepts.',
                'book_path' => 'books/math.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Science',
                'the_class' => '7',
                'total_grade' => 300,
                'about_subject' => 'Introduction to basic science concepts.',
                'book_path' => 'books/science.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mathematics',
                'the_class' => '8',
                'total_grade' => 600,
                'about_subject' => 'Introduction to basic mathematics concepts.',
                'book_path' => 'books/math.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Science',
                'the_class' => '8',
                'total_grade' => 300,
                'about_subject' => 'Introduction to basic science concepts.',
                'book_path' => 'books/science.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mathematics',
                'the_class' => '9',
                'total_grade' => 600,
                'about_subject' => 'Introduction to basic mathematics concepts.',
                'book_path' => 'books/math.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Science',
                'the_class' => '9',
                'total_grade' => 300,
                'about_subject' => 'Introduction to basic science concepts.',
                'book_path' => 'books/science.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}