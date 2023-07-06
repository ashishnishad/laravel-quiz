<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResultOption extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_result_id', 'option_id'];

    public function question(){
        return $this->belongsTo(QuizResult::class, 'quiz_result_id','id');
    }
}