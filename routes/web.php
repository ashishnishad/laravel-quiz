<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('quiz/cat/{slug}', [QuizController::class, 'index'])->name('quiz');
Route::get('bucket/{quiz_id}', [QuizController::class, 'bucket'])->name('bucket');
Route::middleware('auth')->group(function () {
  	Route::get('quiz_start/{quiz_id}/{bucket_id}', [QuizController::class, 'quiz_start'])->name('quiz_start');
	Route::get('quiz_questions', [QuizController::class, 'quiz_questions'])->name('quiz_questions');
	Route::get('quiz_result/{quiz_id}', [QuizController::class, 'quiz_result'])->name('quiz_result');
});


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';