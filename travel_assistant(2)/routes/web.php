<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class , 'show'] )->name('home');

Route::get('/search', [SearchController::class , 'show'] )->name('search');
Route::post('/search', [SearchController::class , 'submit'])->name('search.post');

Route::get('/profile', [ProfileController::class , 'show']  )->name('profile')->middleware('auth');;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/registration', [AuthController::class, 'showRegistration'])->name('registration');
Route::post('/login', [AuthController::class , 'login'])->name('login.post');
Route::post('/registration', [AuthController::class , 'registration'])->name('registration.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/history', [HistoryController::class , 'show'] )->name('history')->middleware('auth');
Route::get('/history/{id}', [HistoryController::class , 'show_search'] )->name('history.search')->middleware('auth');
Route::get('/results', function () {
    return view('search-results');
});