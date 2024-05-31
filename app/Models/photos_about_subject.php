<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\subject;


class photos_about_subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'subject_id',
        'photo_path'
    ];
    public function subject(){
        return $this->belongsTo(subject::class);
    }
}
