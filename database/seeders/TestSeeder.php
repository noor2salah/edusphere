<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\StudentSeeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $photos=[
            "/storage/images/Screenshot 2024-08-17 060445.png",
            "/storage/images/Screenshot 2024-08-17 060546.png",
            "/storage/images/french.jpg",
            "/storage/images/Screenshot 2024-08-17 060427.png",
            "/storage/images/Screenshot 2024-08-17 060519.png",
            "/storage/images/geography.jpg",
            "/storage/images/science.jpg"  ,
            "/storage/images/history.jpg" ,
            "/storage/image/religious.jpg" ,
            "/storage/images/it.jpg",
            "/storage/images/Screenshot 2024-08-17 060354.png"
        ];
       
        for($j=1;$j<13;$j += 11){
            for($i=0;$i<5;$i++){
                $tests =[

                    [
                        'class_subject_id'=>$i+$j,

                        'exam_paper_path' => null,
                        'type' => 'homework',
                        'created_at' => now()->subDays(40),
                        'updated_at' => now()->subDays(40),
                    ],
                    [
                        'class_subject_id'=>$i+$j,

                        'exam_paper_path' => $photos[$i],
                        'type' => 'quiz',
                        'created_at' => now()->subDays(30),
                        'updated_at' => now()->subDays(30),

                    ],
                    [

                        'class_subject_id'=>$i+$j,

                        'exam_paper_path' => null,
                        'type' => 'homework',
                        'created_at' => now()->subDays(20),
                        'updated_at' => now()->subDays(20),

                    ],
                    [
                        'class_subject_id'=>$i+$j,

                        'exam_paper_path' => null,
                        'type' => 'oral_exam',
                        'created_at' => now()->subDays(10),
                        'updated_at' => now()->subDays(10),

                    ],
                    [

                        'class_subject_id'=>$i+$j,

                        'exam_paper_path' => $photos[$i],
                        'type' => 'exam',
                        'created_at' => now()->subDays(1),
                        'updated_at' => now()->subDays(1),

                    ],
                ];
                DB::table('tests')->insert($tests);

            }
        }
    }
}
