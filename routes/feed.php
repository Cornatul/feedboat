<?php

Route::group(['prefix' => 'feeds', 'as' => 'feeds.'], function () {
    Route::get('/', '\Cornatul\Feeds\Http\Controllers\FeedsController@index')->name('index');
    Route::get('search/{topic}', '\Cornatul\Feeds\Http\Controllers\FeedsController@search')->name('search');
    Route::get('imported', '\Cornatul\Feeds\Http\Controllers\FeedsController@imported')->name('imported');

    Route::post('subscribe', '\Cornatul\Feeds\Http\Controllers\FeedsController@subscribe')->name('subscribe');
});
