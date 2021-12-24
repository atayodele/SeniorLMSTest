<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');



Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@HandleLogin');

Route::group(['middleware' => ['auth', 'prevent-back-history']], function() {
    Route::get('/', 'HomeController@index');
    Route::post('admin/student/course_registration', 'Admin\StudentController@AddUserToCourse')->name('add_to_course');
    Route::post('admin/lecturer/lecturer_courses', 'Admin\LecturerController@AddLecturerToCourse')->name('add_courses_to_lecturer');
    Route::get('student', 'Admin\StudentController@MyCourses');
    Route::get('author', 'Admin\LecturerController@MyCourses');
});
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware(['prevent-back-history','auth', 'can:manage'])->group(function(){
    Route::resource('/session', 'SessionController', ['except' => ['create', 'show']]);
    Route::resource('/semester', 'SemesterController', ['except' => ['create', 'show']]);
    Route::resource('/level', 'LevelController', ['except' => ['create', 'show']]);
    Route::resource('/dept', 'DepartmentController', ['except' => ['create', 'show']]);
    Route::resource('/course', 'CourseController', ['except' => ['create', 'show']]);
    Route::resource('/student', 'StudentController', ['except' => ['create']]);
    Route::resource('/lecturer', 'LecturerController', ['except' => ['create']]);
});
