<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home.index');
// });


// Route::view('/', 'home.index')->name('home');

Route::get('/', [CourseController::class, 'add'])->name('course.add');
Route::post('/add-course', [CourseController::class, 'store'])->name('course.store');