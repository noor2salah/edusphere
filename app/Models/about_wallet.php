<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\student;


class about_wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'student_id',
        'amount',
        'description'
    ];
    public function student(){
        return $this->belongsTo(student::class);
    }
}
