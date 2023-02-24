<?php

use Cornatul\Feeds\Http\Controllers\FeedsApiController;
use Cornatul\Feeds\Http\Controllers\FeedsController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'feeds', 'as' => 'feeds.'], static function ()
{
    Route::get('/', [FeedsController::class, 'index'])->name('index');
    Route::get('search', [FeedsController::class, 'search'])->name('search');
    // Api routes

    Route::get('search/{topic}', [FeedsApiController::class, 'searchAction'])->name('searchAction');
    Route::post('subscribe', [FeedsApiController::class, 'subscribeAction'])->name('subscribeAction');
});
