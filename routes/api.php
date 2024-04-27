<?php

use Illuminate\Support\Facades\Route;

Route::get('/docs/search', 'App\Http\Controllers\ApiController@searchDocs')
    ->name('api.docs.search');
