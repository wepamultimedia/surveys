<?php

use Illuminate\Support\Facades\Route;
use Wepa\Surveys\Http\Controllers\Backend\AnswerController;
use Wepa\Surveys\Http\Controllers\Backend\QuestionController;

Route::prefix('admin/surveys')
    ->middleware(['web', 'auth:sanctum', 'core.backend'])
    ->group(function () {
        Route::put('questions/status/{question}', [QuestionController::class, 'status'])->name('admin.surveys.questions.status');
        Route::resource('questions', QuestionController::class)->names('admin.surveys.questions');
        Route::resource('answers', AnswerController::class)->names('admin.surveys.answers');
    });
