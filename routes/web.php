<?php

use App\Http\Controllers\AnswersController;
use App\Http\Controllers\QuestionsController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/questions', QuestionsController::class)->except('show');
//Route::get('questions/{question}', [QuestionsController::class, 'show'])->name('questions.show');
Route::get('questions/{slug}', [QuestionsController::class, 'show'])->name('questions.show');
Route::resource('questions.answers', AnswersController::class)->except(['create', 'show',]);
Route::put('/questions/{question}/answers/{answer}/mark-as-best', [AnswersController::class, 'markAsBest'])->name('questions.answers.markAsBest');
