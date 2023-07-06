<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','status'];

    public function getCreatedAtAttribute($value)
    {
        //return Carbon::parse($this->attributes['created_at'])->diffForHumans();
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d g:i A');
    }

    public function quizzes(){
        return $this->hasMany(Quiz::class,'category_id','id');
    }
}
