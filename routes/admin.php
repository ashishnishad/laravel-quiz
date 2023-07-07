<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\AnswerController;
use App\Http\Controllers\Admin\QuizController;

/***************** Admin Routes **************************/
Route::get('/admin', function () {
    if(Auth::check())
	return redirect('admin/dashboard');
	else
    return view('auth/login-admin');
})->name('admin');


Route::group(['namespace'=>'Admin','prefix' => 'admin'], function () {
	Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('adminlogin');

	Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest')
                ->name('admin.login');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('admin.logout');

});

Route::get('admin/dashboard', [DashboardController::class,'index'])->middleware(['auth','isadmin'])->name('dashboard');

Route::prefix('admin')->middleware(['auth','isadmin'])->group(function() {

	Route::resource('user', UserController::class)->except(['show']);
	Route::get('/user-data', [UserController::class, 'datatable'])->name('user.datatable');
	Route::get('user/delete/{id}', [UserController::class, 'destroy'])->name('user.remove');
	
	Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');

	Route::resource('category', CategoryController::class);
	Route::post('category-data', [CategoryController::class, 'datatable'])->name('category.datatable');
	Route::get('category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.remove');

	Route::resource('question', QuestionController::class);
	Route::post('question-data', [QuestionController::class, 'datatable'])->name('question.datatable');
	Route::post('question-ajax', [QuestionController::class, 'question_ajax'])->name('question.ajax');
	Route::post('question-by-ids', [QuestionController::class, 'question_by_ids'])->name('question.ids');
	Route::get('question/delete/{id}', [QuestionController::class, 'destroy'])->name('question.remove');

	Route::resource('answer', AnswerController::class);
	Route::post('answer-data', [AnswerController::class, 'datatable'])->name('answer.datatable');
	Route::get('answer/delete/{id}', [AnswerController::class, 'destroy'])->name('answer.remove');

	Route::resource('quiz', QuizController::class);
	Route::post('quiz-data', [QuizController::class, 'datatable'])->name('quiz.datatable');
	Route::get('quiz/delete/{id}', [QuizController::class, 'destroy'])->name('quiz.remove');
	Route::post('save-quiz-ajax', [QuizController::class, 'store'])->name('quiz.save');
});

