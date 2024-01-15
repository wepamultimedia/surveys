<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('surveys.route_prefix', 'surveys'))->middleware(['web', 'core.locale'])->group(function () {
    //    Route::get('/{start_at?}', [PostController::class, 'index'])->name('blog');
});
