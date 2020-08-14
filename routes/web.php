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
