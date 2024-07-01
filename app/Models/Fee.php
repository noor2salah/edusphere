<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $fillable = [
        'fee_name',
        'benifats',
        'student_id',

        'due_date'
    ];


    public function student(){
        return $this->belongsTo(student::class);
    }

}
