<?php

use App\Livewire\Docs\Show as DocsShow;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

Route::get('/docs', fn () => redirect()->route('docs.show', ['version' => '2.x', 'page' => 'installation']))
    ->name('docs');

Route::get('/docs/{version}/{page:slug}', DocsShow::class)
    ->name('docs.show');

Route::get('/docs/{page:slug}', fn (string $page) => redirect()->route('docs.show', ['version' => '2.x', 'page' => $page]))
    ->name('docs.redirect');

Route::get('/discord', fn () => redirect('https://discord.gg/sAgPrRSUZg'))
    ->name('discord');

Route::get('/sitemap.xml', 'App\Http\Controllers\SitemapController@index');
