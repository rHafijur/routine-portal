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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/users/students', 'StudentController@index')->name('all_students');
Route::get('/users/teachers', 'TeacherController@index')->name('all_teachers');
Route::get('/user/{id}/set_stat/{status}', 'UserController@setStat');
Route::get('/add/teacher', 'TeacherController@add');
Route::post('/add/teacher', 'TeacherController@register')->name('register_teacher');

Route::get('/semesters', 'SemesterController@index')->name('semesters');
Route::get('/add/semester', 'SemesterController@add');
Route::post('/add/semester', 'SemesterController@save')->name('save_semester');
Route::get('/semester/{id}/edit', 'SemesterController@edit');
Route::post('/update/semester', 'SemesterController@update')->name('update_semester');
Route::get('/semester/{id}', 'SemesterController@details');

Route::get('/courses', 'CourseController@index')->name('courses');
Route::get('/add/course', 'CourseController@add');
Route::post('/add/course', 'CourseController@save')->name('save_course');
Route::get('/course/{id}/edit', 'CourseController@edit');
Route::post('/update/course', 'CourseController@update')->name('update_course');

//public
Route::get('/notices', 'NoticeController@index')->name('notices');
Route::get('/notice/{id}', 'NoticeController@details');

Route::get('/add/notice', 'NoticeController@add');
Route::post('/add/notice', 'NoticeController@save')->name('save_notice');
Route::get('/notice/{id}/edit', 'NoticeController@edit');
Route::post('/update/notice', 'NoticeController@update')->name('update_notice');
Route::get('/notice/{id}/delete', 'NoticeController@delete');

Route::post('/add/course-teacher', 'CourseTeacherController@save')->name('add_course_teacher');
Route::post('/update/course-teacher', 'CourseTeacherController@update')->name('update_course_teacher');
Route::get('/delete/course-teacher/{id}', 'CourseTeacherController@delete')->name('delete_course_teacher');

Route::get('/generate_routine', 'RoutineController@generate')->name('generate_routine');
Route::get('/edit_routine/', 'RoutineController@edit');
Route::post('/save_routine', 'RoutineController@save')->name('save_routine');
Route::post('/update_routine', 'RoutineController@update')->name('update_routine');


Route::get('/routine', 'RoutineController@view');
