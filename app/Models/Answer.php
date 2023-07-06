<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use Carbon\Carbon;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['answer_option', 'question_id', 'is_correct'];

    public function question(){
        return $this->belongsTo(Question::class,'question_id','id');
    }

    public function getCreatedAtAttribute($value){
        //return Carbon::parse($this->attributes['created_at'])->diffForHumans();
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d g:i A');
    }
}
