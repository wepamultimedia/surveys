<?php

use Illuminate\Support\Facades\Route;
use Wepa\Surveys\Http\Controllers\Api\AnswerController;
use Wepa\Surveys\Http\Controllers\Api\QuestionController;

Route::prefix('api/v1/surveys')->middleware(['api'])->group(function () {
    Route::post('/answers/vote/{answer}', [AnswerController::class, 'vote'])->name('api.surveys.answers.vote');
    Route::get('/question/whith-tag/{tag}', [QuestionController::class, 'withTag'])->name('api.surveys.question.withtag');
});

Route::prefix('api/v1/blog')->middleware(['api', 'auth:sanctum'])->group(function () {
});
