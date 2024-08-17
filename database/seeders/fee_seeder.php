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
            'fee_name'=> 'bus fee',
            'benefits'=>20000,
            'type'=>'bus',
            'due_date'=>now()->subDays(30),
            'created_at'=>now()->subDays(30),
            'updated_at'=>now()->subDays(30),

            ],
            [
            'fee_name'=> 'bus fee',
            'benefits'=>25000,
            'type'=>'bus',
            'due_date'=>now()->subDays(10),
            'created_at'=>now()->subDays(10),
            'updated_at'=>now()->subDays(10),

            ],
              [
            'fee_name'=> 'school fee',
            'benefits'=>250000,
            'type'=>'school',
            'due_date'=>now()->subDays(15),
            'created_at'=>now()->subDays(15),
            'updated_at'=>now()->subDays(15),

            ],
             [
            'fee_name'=> 'school fee',
            'benefits'=>200000,
            'type'=>'school',
            'due_date'=>now()->subDays(30),
            'created_at'=>now()->subDays(10),
            'updated_at'=>now()->subDays(10),

            ],
            [
            'fee_name'=> 'party fee',
            'benefits'=>22000,
            'type'=>'other',
            'due_date'=>now()->subDays(18),
            'created_at'=>now()->subDays(18),
            'updated_at'=>now()->subDays(18),

            ],
            [
            'fee_name'=> 'party fee',
            'benefits'=>22000,
            'type'=>'other',
            'due_date'=>now()->subDays(20),
            'created_at'=>now()->subDays(20),
            'updated_at'=>now()->subDays(20),
    
            ],

            [
            'fee_name'=> 'trip fee',
            'benefits'=>21000,
            'type'=>'other',
            'due_date'=>now()->subDays(25),
            'created_at'=>now()->subDays(25),
            'updated_at'=>now()->subDays(25),

            ],
        ]);
    }
}
