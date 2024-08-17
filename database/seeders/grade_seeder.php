<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class grade_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grade=[600,300,600,200,200,200];
        $typ=[0.2,0.2,0.2,0.2,0.4];
        $at=[40,30,20,10,1];
        for($j=0;$j<6;$j++){
            for($i=0;$i<5;$i++){
                for($s=1;$s<6;$s++){
                    $grades=[
                        [
                            'student_id'=>$s,
                            'test_id'=>$i+$j+1,
                            'grade'=>random_int(0,$grade[$j]*$typ[$i]),
                            'created_at' => now()->subDays($at[$i]),
                            'updated_at' => now()->subDays($at[$i]),
                        ]
                    ];
                    DB::table('grades')->insert($grades);    

                }

            }

            

        }

    }
}
