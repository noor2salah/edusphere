<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher;
use App\Models\Classs;
use App\Models\Subject;


class Class_subject extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classSubjects = [
            [
                'teacher_id' => 1,
                'class_id' => 1,
                'subject_id' =>1,
                'time_on_sun' => '08:00:00',
                'time_on_mon' => '09:00:00',
                'time_on_tue' => '00:00:00',
                'time_on_wed' => '00:00:00',
                'time_on_thu' => '00:00:00',
                'exam_date_and_time' => now()->addDays(30)->setHour(14)->setMinute(0)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' =>2,
                'class_id' => 1,
                'subject_id' =>2 ,
                'time_on_sun' => '00:00:00',
                'time_on_mon' => '08:00:00',
                'time_on_tue' => '09:00:00',
                'time_on_wed' => '09:00:00',
                'time_on_thu' => '00:00:00',
                'exam_date_and_time' => now()->addDays(45)->setHour(15)->setMinute(30)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' => 1,
                'class_id' => 2,
                'subject_id' =>1,
                'time_on_sun' => '00:00:00',
                'time_on_mon' => '00:00:00',
                'time_on_tue' => '08:00:00',
                'time_on_wed' => '09:00:00',
                'time_on_thu' => '00:00:00',
                'exam_date_and_time' => now()->addDays(30)->setHour(14)->setMinute(0)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' =>2,
                'class_id' => 2,
                'subject_id' =>2 ,
                'time_on_sun' => '00:00:00',
                'time_on_mon' => '00:00:00',
                'time_on_tue' => '00:00:00',
                'time_on_wed' => '08:00:00',
                'time_on_thu' => '09:00:00',
                'exam_date_and_time' => now()->addDays(45)->setHour(15)->setMinute(30)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'teacher_id' => 3,
                'class_id' => 3,
                'subject_id' =>3,
                'time_on_sun' => '10:00:00',
                'time_on_mon' => '11:00:00',
                'time_on_tue' => '00:00:00',
                'time_on_wed' => '00:00:00',
                'time_on_thu' => '00:00:00',
                'exam_date_and_time' => now()->addDays(30)->setHour(14)->setMinute(0)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' =>2,
                'class_id' => 3,
                'subject_id' =>4 ,
                'time_on_sun' => '00:00:00',
                'time_on_mon' => '10:00:00',
                'time_on_tue' => '11:00:00',
                'time_on_wed' => '00:00:00',
                'time_on_thu' => '00:00:00',
                'exam_date_and_time' => now()->addDays(45)->setHour(15)->setMinute(30)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' => 3,
                'class_id' => 4,
                'subject_id' =>3,
                'time_on_sun' => '00:00:00',
                'time_on_mon' => '00:00:00',
                'time_on_tue' => '10:00:00',
                'time_on_wed' => '11:00:00',
                'time_on_thu' => '00:00:00',
                'exam_date_and_time' => now()->addDays(30)->setHour(14)->setMinute(0)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' =>2,
                'class_id' => 4,
                'subject_id' =>4 ,
                'time_on_sun' => '00:00:00',
                'time_on_mon' => '00:00:00',
                'time_on_tue' => '00:00:00',
                'time_on_wed' => '10:00:00',
                'time_on_thu' => '11:00:00',
                'exam_date_and_time' => now()->addDays(45)->setHour(15)->setMinute(30)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' => 1,
                'class_id' => 5,
                'subject_id' =>5,
                'time_on_sun' => '10:00:00',
                'time_on_mon' => '11:00:00',
                'time_on_tue' => '00:00:00',
                'time_on_wed' => '00:00:00',
                'time_on_thu' => '00:00:00',
                'exam_date_and_time' => now()->addDays(30)->setHour(14)->setMinute(0)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' =>2,
                'class_id' => 5,
                'subject_id' =>6 ,
                'time_on_sun' => '00:00:00',
                'time_on_mon' => '10:00:00',
                'time_on_tue' => '11:00:00',
                'time_on_wed' => '00:00:00',
                'time_on_thu' => '00:00:00',
                'exam_date_and_time' => now()->addDays(45)->setHour(15)->setMinute(30)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' => 1,
                'class_id' => 6,
                'subject_id' =>5,
                'time_on_sun' => '00:00:00',
                'time_on_mon' => '00:00:00',
                'time_on_tue' => '10:00:00',
                'time_on_wed' => '11:00:00',
                'time_on_thu' => '00:00:00',
                'exam_date_and_time' => now()->addDays(30)->setHour(14)->setMinute(0)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'teacher_id' =>2,
                'class_id' => 6,
                'subject_id' =>6 ,
                'time_on_sun' => '00:00:00',
                'time_on_mon' => '00:00:00',
                'time_on_tue' => '00:00:00',
                'time_on_wed' => '10:00:00',
                'time_on_thu' => '11:00:00',
                'exam_date_and_time' => now()->addDays(45)->setHour(15)->setMinute(30)->setSecond(0),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Add more class_subjects as needed
        ];

        // Insert class_subjects into 'class_subjects' table
        DB::table('class_subjects')->insert($classSubjects);

    }
}
