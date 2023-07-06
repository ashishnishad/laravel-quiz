<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['name','category_id'];

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function getCreatedAtAttribute($value){
        //return Carbon::parse($this->attributes['created_at'])->diffForHumans();
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d g:i A');
    }
}
