<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CourseController extends Controller
{
    public function add(){
        return view('course.add');
    }

    public function store(Request $request){
        Course::storeCourse($request);
        Alert::success('Course Added', 'Course added successfully.');

        return back();
    }

    public function index(){
        $courses = Course::with('modules.contents')->get();
        return view('course.index', [
            'courses' => $courses
        ]);
    }
}
