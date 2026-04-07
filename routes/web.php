<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ChapterFormatController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StandardController;
use App\Http\Controllers\MediumController;


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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'users', 'middleware'=> ['auth']], function(){
	Route::get('all',[UsersController::class, 'getAllUsers']);
	Route::get('add',[UsersController::class, 'getAddUser']);
	Route::get('delete/{id}',[UsersController::class, 'deleteUser']);
	Route::post('add',[UsersController::class, 'addUser']);
	Route::get('edit/{id}',[UsersController::class, 'getEditUser']);
	Route::post('edit/{id}',[UsersController::class, 'updateUser']);
});

Route::group(['prefix' => 'students', 'middleware'=> ['auth','prevent-back-history']], function(){
	Route::get('all',[StudentController::class, 'getAllStudents']);
	Route::get('add',[StudentController::class, 'getAddStudent']);
	Route::get('delete/{id}',[StudentController::class, 'deleteStudent']);
	Route::post('add',[StudentController::class, 'addStudent']);
	Route::get('edit/{id}',[StudentController::class, 'editStudentPage']);
	Route::post('edit/{id}',[StudentController::class, 'postUpdateStudent']);
	Route::post('change-password/{id}',[StudentController::class, 'changePassword']);
	Route::get('status/{id}',[StudentController::class, 'changeStatus']);
});


Route::group(['prefix' => 'subjects', 'middleware'=> ['auth']], function(){
	Route::get('all',[SubjectController::class, 'getAllSubjects']);
	Route::get('add',[SubjectController::class, 'getAddSubject']);
	Route::get('delete/{id}',[SubjectController::class, 'deleteSubject']);
	Route::post('add',[SubjectController::class, 'addSubject']);
	Route::get('edit/{id}',[SubjectController::class, 'editSubjectPage']);
	Route::post('edit/{id}',[SubjectController::class, 'postUpdateSubject']);
	Route::get('status/{id}',[SubjectController::class, 'changeStatus']);
});

Route::group(['prefix' => 'standards', 'middleware'=> ['auth']], function(){
	Route::get('all',[StandardController::class, 'getAllStandards']);
	Route::get('add',[StandardController::class, 'getAddStandard']);
	Route::get('delete/{id}',[StandardController::class, 'deleteStandard']);
	Route::post('add',[StandardController::class, 'addStandard']);
	Route::get('edit/{id}',[StandardController::class, 'editStandardPage']);
	Route::post('edit/{id}',[StandardController::class, 'postUpdateStandard']);
	Route::get('status/{id}',[StandardController::class, 'changeStatus']);
});

Route::group(['prefix' => 'mediums', 'middleware'=> ['auth']], function(){
	Route::get('all',[MediumController::class, 'getAllMediums']);
	Route::get('add',[MediumController::class, 'getAddMedium']);
	Route::get('delete/{id}',[MediumController::class, 'deleteMedium']);
	Route::post('add',[MediumController::class, 'addMedium']);
	Route::get('edit/{id}',[MediumController::class, 'editMediumPage']);
	Route::post('edit/{id}',[MediumController::class, 'postUpdateMedium']);
	Route::get('status/{id}',[MediumController::class, 'changeStatus']);
});

Route::group(['prefix' => 'chapters', 'middleware'=> ['auth']], function(){
	Route::get('all',[ChapterController::class, 'getAllChapters']);
	Route::get('add',[ChapterController::class, 'getAddChapter']);
	Route::get('delete/{id}',[ChapterController::class, 'deleteChapter']);
	Route::post('add',[ChapterController::class, 'addChapter']);
	Route::get('edit/{id}',[ChapterController::class, 'editChapterPage']);
	Route::post('edit/{id}',[ChapterController::class, 'postUpdateChapter']);
	Route::get('status/{id}',[ChapterController::class, 'changeStatus']);
	
	Route::group(['prefix' => 'format', 'middleware'=> ['auth']], function(){
	Route::get('all',[ChapterController::class, 'getAllChapterFormats']);
	Route::get('add',[ChapterController::class, 'getAddChapterFormat']);
	Route::get('delete/{id}',[ChapterController::class, 'deleteChapterFormat']);
	Route::post('add',[ChapterController::class, 'addChapterFormat']);
	Route::get('edit/{id}',[ChapterController::class, 'editChapterFormatPage']);
	Route::post('edit/{id}',[ChapterController::class, 'postUpdateChapterFormat']);
	Route::get('status/{id}',[ChapterController::class, 'changeStatus']);
});

});

// Route::group(['prefix' => 'pdf/chapters', 'middleware'=> ['auth']], function(){
// 	Route::get('all',[ChapterController::class, 'getAllChapters']);
// 	Route::get('add',[ChapterController::class, 'getAddChapter']);
// 	Route::get('delete/{id}',[ChapterController::class, 'deleteChapter']);
// 	Route::post('add',[ChapterController::class, 'addChapter']);
// 	Route::get('edit/{id}',[ChapterController::class, 'editChapterPage']);
// 	Route::post('edit/{id}',[ChapterController::class, 'postUpdateChapter']);
// 	Route::get('status/{id}',[ChapterController::class, 'changeStatus']);
// });

Route::group(['prefix' => 'subject-types', 'middleware'=> ['auth']], function(){
	Route::get('all',[ChapterFormatController::class, 'getAllChapters']);
	Route::get('add',[ChapterFormatController::class, 'getAddChapter']);
	Route::get('delete/{id}',[ChapterFormatController::class, 'deleteChapter']);
	Route::post('add',[ChapterFormatController::class, 'addChapter']);
	Route::get('edit/{id}',[ChapterFormatController::class, 'editChapterPage']);
	Route::post('edit/{id}',[ChapterFormatController::class, 'postUpdateChapter']);
	Route::get('status/{id}',[ChapterFormatController::class, 'changeStatus']);
});


Route::group(['prefix' => 'mcq-questions', 'middleware'=> ['auth']], function(){
	Route::get('all',[QuestionController::class, 'getAllQuestions']);
	Route::get('add',[QuestionController::class, 'getAddQuestion']);
	Route::get('delete/{id}',[QuestionController::class, 'deleteQuestion']);
	Route::post('add',[QuestionController::class, 'addQuestion']);
	Route::get('edit/{id}',[QuestionController::class, 'editQuestionPage']);
	Route::get('view/{id}',[QuestionController::class, 'viewQuestionPage']);
	Route::post('edit/{id}',[QuestionController::class, 'postUpdateQuestion']);
	Route::get('status/{id}',[QuestionController::class, 'changeStatus']);
});