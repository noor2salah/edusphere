<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\teacher;


class description_about_the_teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'teacher_id',
        'the_description',
        'photo_path'
    ];
    public function teacher(){
        return $this->belongsTo(teacher::class);
    }
}
