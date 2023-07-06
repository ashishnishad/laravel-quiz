<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id','bucket_id','user_id','question_id'];

    public function question(){
        return $this->belongsTo(Question::class, 'question_id','id');
    }

    public function options(){
        return $this->hasMany(QuizResultOption::class, 'quiz_result_id', 'id');
    }

    public function answers(){
        return $this->hasMany(Answer::class, 'question_id', 'question_id')->where('is_correct','yes');
    }
}