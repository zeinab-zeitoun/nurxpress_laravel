<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\NurseEducationController;
use App\Http\Controllers\NurseExperienceController;
use App\Http\Controllers\NursePricesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RegularUserController;
use App\Http\Controllers\UserController;
use App\Models\Rating;

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

Route::group(['middleware' => 'auth:api'], function () {

    Route::group(['middleware' => 'nurse:api'], function () {

        //nurse
        Route::get('/nurse', [NurseController::class, 'profile']);
        Route::post('/nurse', [NurseController::class, 'store']);
        Route::put('/nurse', [NurseController::class, 'update']);
        Route::put('/changeLocation', [NurseController::class, 'changeLocation']);

        //nurse education
        Route::get('/nurseEducation', [NurseEducationController::class, 'index']);
        Route::get('/nurseEducation/{id}', [NurseEducationController::class, 'show']);
        Route::post('/nurseEducation', [NurseEducationController::class, 'store']);
        Route::put('/nurseEducation/{id}', [NurseEducationController::class, 'update']);
        Route::delete('/nurseEducation/{id}', [NurseEducationController::class, 'destroy']);

        //nurse experience
        Route::get('/nurseExperience', [NurseExperienceController::class, 'index']);
        Route::get('/nurseExperience/{id}', [NurseExperienceController::class, 'show']);
        Route::post('/nurseExperience', [NurseExperienceController::class, 'store']);
        Route::put('/nurseExperience/{id}', [NurseExperienceController::class, 'update']);
        Route::delete('/nurseExperience/{id}', [NurseExperienceController::class, 'destroy']);

        //posts
        Route::post('/posts', [PostController::class, 'store']);
        Route::put('/posts/{id}', [PostController::class, 'update']);
        Route::delete('/posts/{id}', [PostController::class, 'destroy']);
        Route::get('/posts', [PostController::class, 'index']);
        Route::get('/posts/{id}', [PostController::class, 'show']);

        //comments
        Route::post('/comments/{post_id}', [CommentController::class, 'store']);
        Route::put('/comments/{id}', [CommentController::class, 'update']);
        Route::put('/readComment/{id}', [CommentController::class, 'markRead']);
        Route::get('/comments/{post_id}', [CommentController::class, 'show']);
        Route::get('/comments', [CommentController::class, 'index']);
        Route::get('/commentsTwo/{post_id}', [CommentController::class, 'showTwoComments']);
        Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
        Route::get('/unreadComments', [CommentController::class, 'unreadComments']);

        //set and delete unavailable days
        Route::post('/availability', [AvailabilityController::class, 'store']);
        Route::delete('/availability/{date}', [AvailabilityController::class, 'destroy']);
        Route::get('/availability', [AvailabilityController::class, 'index']);

        //set and delete some additional details
        Route::post('/details', [DetailsController::class, 'store']);
        Route::delete('/details/{id}', [DetailsController::class, 'destroy']);
        Route::get('/details', [DetailsController::class, 'index']);
    });

    Route::group(['middleware' => 'regular:api'], function () {
        //get all nurses
        Route::get('/nurses', [NurseController::class, 'index']);

        // info for specific nurse
        Route::get('/nurse/{id}', [NurseController::class, 'show']);
        Route::get('/thisNurse/{user_id}', [NurseController::class, 'getNurseGivenUserId']);
        Route::get('/education/{nurse_id}', [NurseEducationController::class, 'getEducation']);
        Route::get('/experience/{nurse_id}', [NurseExperienceController::class, 'getExperience']);

        //info of user
        Route::get('/regularUser', [RegularUserController::class, 'index']);
        Route::post('/regularUser', [RegularUserController::class, 'store']);
        Route::put('/regularUser', [RegularUserController::class, 'update']);
        Route::put('/changeLocation', [RegularUserController::class, 'changeLocation']);

        //rating
        Route::post('/rating/{nurse_id}', [RatingController::class, 'store']);
        Route::get('/rated/{nurse_id}', [RatingController::class, 'rated']);
        Route::get('/rating/{nurse_id}', [RatingController::class, 'averageRating']);
        Route::get('/rating', [RatingController::class, 'averageRatingAuth']);
    });

    //nurse info
    Route::get('/authUser', [UserController::class, 'authUser']);

    //getting nurses according to a certain budget
    Route::get('/nurses8/{pricePer8Hour}', [NursePricesController::class, 'NursePricePer8Hours']);
    Route::get('/nurses12/{pricePer12Hour}', [NursePricesController::class, 'NursePricePer12Hours']);
    Route::get('/nurses24/{pricePer24Hour}', [NursePricesController::class, 'NursePricePer24Hours']);

    Route::get('/authUser/{pricePer12Hour}', [NursePricesController::class, 'NursePricePer12Hours']);
    Route::get('/authUser/{pricePer24Hour}', [NursePricesController::class, 'NursePricePer24Hours']);

    //get unavailable days
    Route::get('/availability/{nurse_id}', [AvailabilityController::class, 'show']);

    //get nurse's details
    Route::get('/details/{nurse_id}', [DetailsController::class, 'show']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/emails', [UserController::class, 'emails']);
