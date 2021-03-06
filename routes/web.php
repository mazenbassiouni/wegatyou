<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileInformationController;
use App\Http\Controllers\ProfilePictureController;
use App\Http\Controllers\AdditionalInformationController;
use App\Http\Controllers\TendenciesController;
use App\Http\Controllers\AppAjaxController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\SubscribtionController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
    return view('home.index');
})->middleware('guest');


Route::group(['middleware'=> ['auth','is.admin']],function (){

    Route::resource('profile',ProfileInformationController::class);
    Route::resource('profilePicture',ProfilePictureController::class);
    Route::get('set',[TendenciesController::class, 'create']);
    Route::post('set',[TendenciesController::class, 'store']);
    
});



Route::group(['middleware' => ['auth','is.admin','check.profile']],function(){  

    Route::get('dashboard',[DashboardController::class,'index']); 
    Route::post('like',[AppAjaxController::class, 'like']);
    Route::post('dislike',[AppAjaxController::class, 'dislike']);

    Route::post('foodpreferences',[AppAjaxController::class,'setFoodPref']);
    Route::post('removefoodpreference',[AppAjaxController::class,'deleteFoodPref']);

    Route::post('favoritefoods',[AppAjaxController::class,'setFavoriteFoods']);
    Route::post('removefavoritefood',[AppAjaxController::class,'deleteFavoriteFood']);

    Route::post('favoritedrinks',[AppAjaxController::class,'setFavoriteDrinks']);
    Route::post('removefavoritedrink',[AppAjaxController::class,'deleteFavoriteDrink']);

    Route::post('sendmessage', [MessageController::class, 'store']);
    Route::post('seen', [MessageController::class, 'seen']);

    Route::get('subscribtion',[SubscribtionController::class, 'index']);

});

Route::get('privacypolicy', [LegalController::class, 'privacyPolicy']);
Route::get('termsandconditions', [LegalController::class, 'termsAndConditions']);
Route::get('useragreement', [LegalController::class, 'userAgreement']);


Route::get('/sign-in/github', [SocialiteController::class, 'github']);
Route::get('/sign-in/github/redirect', [SocialiteController::class, 'githubRedirect']);


Route::group(['middleware' => ['auth','not.admin']], function(){

    Route::get('/adminPanel', [AdminController::class, 'index']);
    Route::get('/userdashboard/{id}', [AdminController::class, 'userDashboard']);
    Route::get('/profileadminview/{user}/{id}', [ProfileInformationController::class, 'adminView']);

});