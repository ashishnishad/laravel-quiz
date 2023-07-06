<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'category_id', 'status', 'complexity'];

    public function getCreatedAtAttribute($value){
        //return Carbon::parse($this->attributes['created_at'])->diffForHumans();
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d g:i A');
    }
}
