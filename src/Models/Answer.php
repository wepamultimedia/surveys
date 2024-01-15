<?php

namespace Wepa\Surveys\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Answer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['answer'];

    protected $table = 'surveys_answers';

    public function questionAnswer(): HasOne
    {
        return $this->hasOne(QuestionAnswer::class, 'answer_id', 'id');
    }

    public function question(): HasOneThrough
    {
        return $this->hasOneThrough(
            Question::class,
            QuestionAnswer::class,
            'answer_id',
            'id',
            'id',
            'question_id'
        );
    }
}
