<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class task_grade_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grade=[15,15,15,15,60,60,60,60,60];

        for($i=0;$i<6;$i++){
            for($j=1;$j<21;$j++){
                $grades=[
                    'student_id'=>$j,
                    'task_id'=>$i+1,
                    'grade'=>random_int(0,$grade[$i]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                DB::table('task_grades')->insert($grades);    

            }

        }
    }
}
