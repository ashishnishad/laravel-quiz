<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id','question_id','priorty'];

    public function question_q(){
        return $this->belongsTo(Question::class, 'question_id','id')->where(['status' => 'enabled']);
    }

    public function options(){
        return $this->hasMany(Answer::class, 'question_id','question_id');
    }
}