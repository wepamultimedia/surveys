<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('blog.route_prefix', 'blog'))->middleware(['web', 'core.locale'])->group(function () {
//    Route::get('/{start_at?}', [PostController::class, 'index'])->name('blog');
});
