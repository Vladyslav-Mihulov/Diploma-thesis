<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class , 'show'] )->name('home');

Route::get('/search', [SearchController::class , 'show'] )->name('search');
Route::post('/search', [SearchController::class , 'submit'])->name('search.post');

Route::get('/profile', [ProfileController::class , 'show']  )->name('profile');

Route::get('/contact', [ContactController::class , 'show'] )->name('contact');

Route::get('/results', function () {
    return view('search-results');
});