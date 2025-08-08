<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


Route::post('login',[AuthController::class, 'login'])->name('login');
Route::post('signup',[AuthController::class, 'signup'])->name("regiser");


Route::middleware('auth:sanctum')->get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::middleware('auth:sanctum')->get('/categories',[ArticleController::class, 'getCategory'])->name('articles.categories');
Route::middleware('auth:sanctum')->post('/set-preferences',[UserController::class, 'setPreferences'])->name('set=preference');
Route::middleware('auth:sanctum')->get('getPersonalizedNews',[ArticleController::class,'getPersonalizedNews'])->name('getPersonalizedNews');
