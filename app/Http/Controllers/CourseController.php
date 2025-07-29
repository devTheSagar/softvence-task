<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function add(){
        return view('course.add');
    }

    public function store(Request $request){
        Course::storeCourse($request);
        return back();
    }
}
