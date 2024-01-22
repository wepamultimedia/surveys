<?php

use Illuminate\Support\Facades\Route;
use Wepa\Surveys\Http\Controllers\Api\AnswerController;
use Wepa\Surveys\Http\Controllers\Api\QuestionController;

Route::prefix('api/v1/surveys')->middleware(['api'])->group(function () {
    Route::post('/answers/vote/{answer}', [AnswerController::class, 'vote'])->name('api.surveys.answers.vote');
    Route::get('/surveys/questions/by-tag/{tag}', [QuestionController::class, 'byTag'])->name('api.surveys.questions.byTag');
    Route::get('/surveys/questions/{question}', [QuestionController::class, 'byId'])->name('api.surveys.questions.byId');
    Route::get('/surveys/index', [QuestionController::class, 'index'])->name('api.surveys.questions.index');
});

Route::prefix('api/v1/blog')->middleware(['api', 'auth:sanctum'])->group(function () {
});
