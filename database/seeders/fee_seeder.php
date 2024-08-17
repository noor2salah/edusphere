<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class fee_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fees')->insert([
            [
                'fee_name'=> 'fee1',
            'benefits'=>20000,
            'type'=>'bus',
            'due_date'=>now(),
            'created_at'=>now(),
            'updated_at'=>now(),

            ],
            [
            'fee_name'=> 'fee2',
            'benefits'=>25000,
            'type'=>'bus',
            'due_date'=>now(),
            'created_at'=>now(),
            'updated_at'=>now(),

            ],
              [
            'fee_name'=> 'fee3',
            'benefits'=>250000,
            'type'=>'school',
            'due_date'=>now(),
            'created_at'=>now(),
            'updated_at'=>now(),

            ],
             [
            'fee_name'=> 'fee4',
            'benefits'=>200000,
            'type'=>'school',
            'due_date'=>now(),
            'created_at'=>now(),
            'updated_at'=>now(),

            ],
            [
                'fee_name'=> 'fee5',
            'benefits'=>22000,
            'type'=>'other',
            'due_date'=>now(),
            'created_at'=>now(),
            'updated_at'=>now(),


            ],  [
                'fee_name'=> 'fee6',
            'benefits'=>21000,
            'type'=>'other',
            'due_date'=>now(),
            'created_at'=>now(),
            'updated_at'=>now(),

            ],
        ]);
    }
}
