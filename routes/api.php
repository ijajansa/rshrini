<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\API\V1\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('standards', [AuthController::class, 'getStandardData']);
Route::post('mediums', [AuthController::class, 'getMediumData']);
	
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::group(['middleware' => ['jwt.verify']], function(){
	Route::post('dashboard', [AuthController::class, 'dashboard']);
	Route::post('subjects', [AuthController::class, 'getSubjectData']);
	Route::get('pdf-types', [AuthController::class, 'getChapterTypeData']);
	Route::post('chapters', [AuthController::class, 'getChapterData']);
	Route::post('chapter-formats', [AuthController::class, 'getChapterFormatData']);
	Route::post('update-profile', [AuthController::class, 'updateProfile']);
	Route::post('get-profile', [AuthController::class, 'getProfile']);
	Route::post('update-password', [AuthController::class, 'updateProfilePassword']);
	Route::post('get-questions', [AuthController::class, 'getQuestions']);
	Route::post('submit-answers', [AuthController::class, 'submitAnswers']);
	Route::post('add-bookmark', [AuthController::class, 'bookmarkOperation']);
	Route::post('get-bookmark', [AuthController::class, 'bookmarkList']);
	Route::post('add-answer', [AuthController::class, 'addAnswer']);
	Route::post('get-summary', [AuthController::class, 'getSummary']);
	Route::post('get-history', [AuthController::class, 'getQuizHistory']);
	Route::post('get-subject-records', [AuthController::class, 'getSubjectRecord']);

});
