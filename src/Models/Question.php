<?php

namespace Wepa\Surveys\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'question', 'tag', 'status'];

    protected $table = 'surveys_questions';

    public function questionsAnswers(): HasMany
    {
        return $this->hasMany(QuestionAnswer::class, 'question_id');
    }

    public function answers(): HasManyThrough
    {
        return $this->hasManyThrough(
            Answer::class,
            QuestionAnswer::class,
            'question_id',
            'id',
            'id',
            'answer_id'
        );
    }
}
