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
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\GradesController;
use Database\Seeders\Class_subject;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PHPUnit\Event\Code\Test;
use Illuminate\Support\Facades\Artisan;

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



Route::get('/symlink', function () {
    Artisan::call('storage:link');
});
Route::group(["middleware" => "translate"], function () {

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
    Route::get('profileteacher/{id}', [AuthController::class, 'profileteacher']);

});
//----------

Route::group(["middleware" => ["auth:api", "translate"]], function () {

    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('profilestudent/{id}', [AuthController::class, 'profileStudent']);
    Route::post('EditProfile', [AuthController::class, 'EditProfilestudent']);
    Route::post('EditProfileteacher', [AuthController::class, 'EditProfileteacher']);
    Route::post('EditprofileAdmin', [AuthController::class, 'EditprofileAdmin'])->middleware('admin');
    Route::get('profileAdmin', [AuthController::class, 'profileAdmin'])->Middleware('admin');
});



//advertisements api's


Route::group(["middleware" => "translate"], function () {


    Route::post('StoreAdvertisements', [AdvertisementController::class, 'store']);
    Route::get('Advertisements', [AdvertisementController::class, 'index']);
    Route::post('Advertisement', [AdvertisementController::class, 'show']);
    Route::delete('destroy/{id}', [AdvertisementController::class, 'destroy']);
    Route::get('search/{title}', [AdvertisementController::class, 'SearchAdvertisement']);
});

Route::group(["middleware" => ["auth:api", "translate"]], function () {
    Route::get('show_all_by_class', [AdvertisementController::class, 'show_all_by_class']);
});


//Book api's
Route::group(["middleware" => ["auth:api", "translate"]], function () {
    Route::get('show_educational_book', [LibraryController::class, 'show_educational']);
    Route::get('show_entertainment_book', [LibraryController::class, 'show_entertainment']);
});



//favorite api's
Route::group(["middleware" => ["auth:api", "translate"]], function () {
    Route::post('store_book', [LibraryController::class, 'store'])->middleware('admin');
    Route::get('get_all_teacher', [TeachersListController::class, 'get_all_teacher'])->middleware('admin');
    Route::post('add_to_fav', [LibraryController::class, 'add_to_favorite']);
    Route::get('show_fav_books', [LibraryController::class, 'show_favorite_books']);
    Route::delete('remove_from_fav/{id}', [LibraryController::class, 'remove_from_favorite']);
    Route::post('add_to_favorite', [TeachersListController::class, 'add_to_favorite']);
    Route::delete('remove_from_favorite/{id}', [TeachersListController::class, 'remove_from_favorite']);
    Route::get('show_favorite_teachers', [TeachersListController::class, 'show_favorite_teachers']);
});

//class and subject api's
Route::get('show_all_class_levels', [ClassController::class, 'show_all_class_levels']);
Route::post('show_all_class_numbers', [ClassController::class, 'show_all_class_numbers']);

Route::post('store_class_subject', [SubjectsController::class, 'store_class_subject']);
Route::delete('class/{id}', [ClassController::class, 'detete_class']);
Route::post('show_subjects_of_the_class', [SubjectsController::class, 'show_subjects_of_the_class']);

Route::group(["middleware" => "auth:api"],function() {


Route::get('showStudentsByClass/{id}', [ClassController::class, 'showStudentsByClass']);
Route::post('show_subject', [SubjectsController::class, 'show_subject']);
Route::post('store', [ClassController::class, 'store']);
Route::post('store_subject', [SubjectsController::class, 'store_subject']);
Route::post('store_photo_about_subject', [SubjectsController::class, 'store_photo_about_subject']);
Route::post('store_subject_units', [SubjectsController::class, 'store_subject_units']);
Route::post('EditClass/{id}', [ClassController::class, 'EditClass']);
});
Route::group(["middleware" => "auth:api"], function () {
});


//test api's
Route::group(["middleware" => "translate"], function () {
    Route::post('store_test', [TestController::class, 'store_test']);
    Route::post('show_test_by_class_level', [TestController::class, 'show_test_by_class_level']);
    Route::get('show', [TestController::class, 'index']);
});


//teacher list Api's
Route::group(["middleware" => "translate"], function () {

    Route::post('show_teachers_by_class', [TeachersListController::class, 'show_teachers_by_class']);
    Route::post('show_about_teacher', [TeachersListController::class, 'show_about_teacher']);
});
//task api's

Route::group(["middleware" => ["auth:api", "translate"]], function () {

    Route::post('store_task', [TaskController::class, 'store_task']);
    Route::post('solve_task', [TaskController::class, 'solve_task']);
    Route::get('show_task/{id}', [TaskController::class, 'show_task']);
    Route::get('show_all_tasks_for_student', [TaskController::class, 'show_all_tasks_for_student']);
    Route::get('show_all_tasks_for_teacher', [TaskController::class, 'show_all_tasks_for_teacher']);
});
Route::group(["middleware"=>"translate"],function() {
    Route::post('show_question',[TaskController::class,'show_question']);
    Route::get('show_task/{id}',[TaskController::class,'show_task']);
    Route::post('solve_task/{id}',[TaskController::class,'solve_task']);

    Route::get('show_task/{id}', [TaskController::class, 'show_task']);
    Route::post('solve_task/{id}', [TaskController::class, 'solve_task']);
});
//this Api's for wallet
Route::post('deposit_wallet', [WalletController::class, 'deposit_wallet']);
Route::group(["middleware" => "auth:api"], function () {
    Route::post('create_fee', [WalletController::class, 'create_fee']);
    Route::post('paid_fee', [WalletController::class, 'paid_fees']);
    Route::get('show', [WalletController::class, 'show']);
    Route::get('show_fees', [WalletController::class, 'show_fees']);
});

//activity
Route::group(["middleware" => "auth:api"], function () {
    Route::get('activity', [ActivityController::class, 'activity']);
});


//schedule
Route::group(["middleware" => "auth:api"], function () {
    Route::get('show_the_schedule_for_student', [SubjectsController::class, 'show_the_schedule_for_student']);
    Route::get('show_the_schedule_for_teacher', [SubjectsController::class, 'show_the_schedule_for_teacher']);
});


//grades
Route::post('store_grade_test', [GradesController::class, 'store_grade_test']);
Route::post('delete_grade', [GradesController::class, 'delete_grade']);


Route::group(["middleware" => ["auth:api", "translate"]], function () {

    Route::post('show_grade_by_type', [GradesController::class, 'show_grade_by_type']);
    Route::get('show_the_total_grade', [GradesController::class, 'show_the_total_grade']);
    Route::get('rank', [GradesController::class, 'rank']);
});

//students for addmin

Route::get('number_of_total_school_students_for_admin', [StudentController::class, 'number_of_total_school_students_for_admin']);
Route::post('number_of_total_class_level_students', [StudentController::class, 'number_of_total_class_level_students']);
Route::post('number_of_total_class_students', [StudentController::class, 'number_of_total_class_students']);
Route::post('show_students_in_class', [StudentController::class, 'show_students_in_class']);
Route::post('show_student_profile', [StudentController::class, 'show_student_profile']);
