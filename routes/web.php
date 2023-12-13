<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\RespondentController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyInitiateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Auth::routes();

Route::get('/clear-session', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'postLogin']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Admin login controller

// Route::group(['middleware' => 'guest' , 'prefix' => 'admin'], function () {
//     Route::get('/login', [AdminAuthController ::class ,'index'])->name('admin.login');
//     Route::post('/login', [AdminAuthController::class , 'adminLogin']);
//     Route::post('logout', [AdminAuthController::class , 'logout'])->name('admin.logout');
//     });
//Home Controller
Route::group(['middleware' => 'auth:admin'], function () {

    Route::get('', [WelcomeController::class, 'index']);
    /*if(Auth::user()->role()==1)
    {*/
    //Testimonial Route
    Route::get('surveys', [SurveyController::class, 'index']);
    Route::post('survey/partner/store', [SurveyController::class, 'store']);
    Route::post('survey/partner/edit/{id}', [SurveyController::class, 'partnerEdit']);
    Route::post('survey/partner/update', [SurveyController::class, 'updatePartnerSurvey']);
    Route::post('survey/partner/show/{id}', [SurveyController::class, 'partner']);
    Route::post('survey/partner/projects/{pid}', [SurveyController::class, 'partnerProjectList']);
    Route::post('survey/partner/status', [SurveyController::class, 'surveyStatus']);
    Route::post('survey/partner/remove/{id}', [SurveyController::class, 'destroy']);
    Route::get('survey/export/{pid}/{ptid}', [SurveyController::class, 'export']);


    /*Project Controller*/
    Route::get('projects', [ProjectController::class, 'index']);
    Route::get('project/create', [ProjectController::class, 'create']);
    Route::post('project/store', [ProjectController::class, 'store']);
    Route::get('project/{id}/edit', [ProjectController::class, 'edit']);
    Route::get('project/{id}', [ProjectController::class, 'show']);
    Route::post('project/update', [ProjectController::class, 'update']);
    Route::post('project/new-link', [ProjectController::class, 'addLinks']);
    Route::post('project/update-link', [ProjectController::class, 'updateLinks']);
    //Route::post('projects/status/{status}','ProjectController::class,'@projectStatus');
    Route::post('project/update/status/{id}', [ProjectController::class, 'updateStatus']);
    Route::post('project/remove/{id}', [ProjectController::class, 'destroy']);

    //Partner Controller
    Route::get('partners', [PartnerController::class, 'index']);
    Route::get('partner/create', [PartnerController::class, 'create']);
    Route::post('partner/store', [PartnerController::class, 'store']);
    Route::get('partner/{id}', [PartnerController::class, 'show']);
    Route::post('partner/{id}', [PartnerController::class, 'update']);
    Route::post('partner/remove/{id}', [PartnerController::class, 'destroy']);

    /*Industry Controller*/
    Route::get('industries', [IndustryController::class, 'index']);
    Route::get('industry/create', [IndustryController::class, 'create']);
    Route::post('industry/create', [IndustryController::class, 'store']);
    Route::get('industry/edit/{id}', [IndustryController::class, 'edit']);
    Route::post('industry/update', [IndustryController::class, 'update']);
    Route::post('industry/delete/{id}', [IndustryController::class, 'delete']);


    /*Address Controller*/
    Route::get('address/create/{partner}', [AddressController::class, 'create']);
    Route::post('address/store', [AddressController::class, 'store']);
    Route::get('address/{id}', [AddressController::class, 'show']);
    Route::post('address/{id}', [AddressController::class, 'update']);

    Route::get('vendors', [VendorController::class, 'index']);
    Route::post('vendor/partner/projects/{pid}', [VendorController::class, 'partnerProjectList']);

    /* User Controller */

    Route::get('users', [UserController::class, 'index']);
    Route::get('user/create', [UserController::class, 'create']);
    Route::post('user/create', [UserController::class, 'store']);
    Route::get('user/edit/{id}', [UserController::class, 'edit']);
    Route::post('user/update', [UserController::class, 'update']);
    Route::post('user/delete/{id}', [UserController::class, 'delete']);
    //}
});
Route::get('surveyInitiate', [SurveyInitiateController::class, 'start']);
Route::get('redirect', [RedirectController::class, 'surveyEnd']);
