<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home.index');
// });


// Route::view('/', 'home.index')->name('home');

Route::get('/', [CourseController::class, 'add'])->name('course.add');
Route::post('/add-course', [CourseController::class, 'store'])->name('course.store');
Route::get('/all-course', [CourseController::class, 'index'])->name('course.all');
Route::get('/edit-course/{id}', [CourseController::class, 'edit'])->name('course.edit');
Route::post('/update-course/{id}', [CourseController::class, 'update'])->name('course.update');
Route::delete('/delete-course/{id}', [CourseController::class, 'delete'])->name('course.delete');