<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\classs;

class advertisement extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'id',
        'class_id',
        'title',
        'advertisement',
        'photo_path'
    ];
    public function class(){
        return $this->belongsTo(classs::class);
    }
}
