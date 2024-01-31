<?php

use App\Livewire\Docs\Show as DocsShow;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Home::class)->name('home');

Route::get('/docs', fn () => redirect()->route('docs.show', 'installation'))
    ->name('docs');

Route::get('/docs/{page:slug}', DocsShow::class)
    ->name('docs.show');

Route::get('/sitemap.xml', 'App\Http\Controllers\SitemapController@index');
