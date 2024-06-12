<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectsController;
use App\Http\Controllers\TeachersListController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TaskController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PHPUnit\Event\Code\Test;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Auth Api's
Route::post('registerStudent', [AuthController::class, 'AddAccountStudent']);
Route::post('registerteacher', [AuthController::class, 'AddAccountTeacher']);
Route::post('registerAdmin', [AuthController::class, 'AddAccounAdmin']);
Route::post('login', [AuthController::class, 'login']);
Route::post('loginAdmin', [AuthController::class, 'loginAdmin']);
Route::post('generate_code', [AuthController::class, 'generate_code']);
Route::delete('deleteAccount/{id}', [AuthController::class, 'DeleteAccount']);
Route::post('passwordforget', [AuthController::class, 'userforgetpassword']);
Route::post('checkcodepassword', [AuthController::class, 'usercheckcode']);
Route::post('resetpassword', [AuthController::class, 'userresetpassword']);

Route::group(["middleware" => "auth:api"], function () {

    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('profilestudent/{id}', [AuthController::class, 'profileStudent']);
    Route::get('profileteacher/{id}', [AuthController::class, 'profileteacher']);
    Route::post('EditProfile', [AuthController::class, 'EditProfilestudent']);
    Route::post('EditProfileteacher/{id}', [AuthController::class, 'EditProfileteacher']);
    Route::post('EditprofileAdmin/{id}', [AuthController::class, 'EditprofileAdmin'])->middleware('admin');
    Route::get('profileAdmin', [AuthController::class, 'profileAdmin'])->Middleware('admin');

});

    
//advertisements api's
Route::post('StoreAdvertisements', [AdvertisementController::class, 'store']);
Route::get('Advertisements', [AdvertisementController::class, 'index']);
Route::post('Advertisement', [AdvertisementController::class, 'show']);
Route::post('show_all_by_class', [AdvertisementController::class, 'show_all_by_class']);
Route::delete('destroy/{id}', [AdvertisementController::class, 'destroy']);
Route::get('search/{title}', [AdvertisementController::class, 'SearchAdvertisement']);


//Book api's
Route::group(["middleware" => "auth:api"], function () {
    Route::get('show_educational_book', [LibraryController::class, 'show_educational']);
    Route::get('show_entertainment_book', [LibraryController::class, 'show_entertainment']);
});

Route::post('store_book', [LibraryController::class, 'store']);

//favorite api's
Route::group(["middleware" => "auth:api"], function () {
    Route::get('add_to_fav/{id}', [LibraryController::class, 'add_to_favorite']);
    Route::get('show_fav_books', [LibraryController::class, 'show_favorite_books']);
    Route::delete('remove_from_fav/{id}', [LibraryController::class, 'remove_from_favorite']);
    Route::get('add_to_favorite/{id}', [TeachersListController::class, 'add_to_favorite']);
    Route::delete('remove_from_favorite/{id}', [TeachersListController::class, 'remove_from_favorite']);
    Route::get('show_favorite_teachers', [TeachersListController::class, 'show_favorite_teachers']);

});

//class and subject api's
Route::get('show_class', [ClassController::class, 'show_all_classes']);
Route::delete('class/{id}', [ClassController::class, 'detete_class']);
Route::get('showStudentsByClass/{id}', [ClassController::class, 'showStudentsByClass']);
Route::post('show_subjects_of_the_class', [SubjectsController::class, 'show_subjects_of_the_class']);
Route::post('show_subject', [SubjectsController::class, 'show_subject']);
Route::post('store', [ClassController::class, 'store']);
Route::post('store_subject', [SubjectsController::class, 'store_subject']);
Route::post('store_class_subject', [SubjectsController::class, 'store_class_subject']);
Route::post('EditClass/{id}', [ClassController::class, 'EditClass']);



//test api's

Route::post('show_test_by_class_level', [TestController::class, 'show_test_by_class_level']);
Route::get('show', [TestController::class, 'index']);

Route::group(["middleware" => "auth:api"], function () {
    
    Route::post('show_grade_by_type', [TestController::class, 'show_grade_by_type']);
    Route::get('show_the_total_grade', [TestController::class, 'show_the_total_grade']);

});

Route::post('storeTest', [TestController::class, 'store_test']);
Route::post('store_grade_test', [TestController::class, 'store_grade_test']);
Route::delete('delete_test/{id}', [TestController::class, 'delete_test']);
Route::delete('delete_grade/{student_id}', [TestController::class, 'delete_grade']);



//teacher list Api's
Route::post('show_teachers_by_class', [TeachersListController::class, 'show_teachers_by_class']);
Route::post('show_about_teacher', [TeachersListController::class, 'show_about_teacher']);

//task api's
Route::post('store_task',[TaskController::class,'store_task']);
Route::get('show_task/{id}',[TaskController::class,'show_task']);
Route::post('solve_task/{id}',[TaskController::class,'solve_task']);


Route::group(["middleware" => "auth:api"], function () {});
