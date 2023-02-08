<?php

Route::get("feeds", "Cornatul\Feeds\Http\Controllers\FeedsController@index")->name("feeds.index");
Route::post("feeds/search", "Cornatul\Feeds\Http\Controllers\FeedsController@search")->name("feeds.search");
Route::get("feeds/import", "Cornatul\Feeds\Http\Controllers\FeedsController@import")->name("feeds.import");
