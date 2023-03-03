<?php

use Cornatul\Feeds\Http\Controllers\ArticlesController;
use Cornatul\Feeds\Http\Controllers\FeedsApiController;
use Cornatul\Feeds\Http\Controllers\FeedsController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['web','auth'],'prefix' => 'feeds', 'as' => 'feeds.'], static function ()
{
    Route::get('/', [FeedsController::class, 'index'])->name('index');
    Route::get('/destroy/{id}', [FeedsController::class, 'destroy'])->name('destroy');
    Route::get('search', [FeedsController::class, 'search'])->name('search');
    Route::get('import', [FeedsController::class, 'import'])->name('import');
    Route::post('import/store', [FeedsController::class, 'store'])->name('import.store');

    Route::get('/articles/{feedID}', [ArticlesController::class, 'articles'])->name('articles');
    Route::get('/article/{articleID}', [ArticlesController::class, 'article'])->name('article');
    Route::post('/article/update/{articleID}', [ArticlesController::class, 'update'])->name('article.update');
    Route::get('/article/publish/{articleID}', [ArticlesController::class, 'publish'])->name('article.publish');
    Route::post('/publish', [ArticlesController::class, 'publish'])->name('article.publish.process');
    // Api routes

    Route::get('search/{topic}', [FeedsApiController::class, 'searchAction'])->name('searchAction');
    Route::post('subscribe', [FeedsApiController::class, 'subscribeAction'])->name('subscribeAction');
})->middleware('web');
