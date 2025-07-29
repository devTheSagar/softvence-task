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
        $request->validate([
            'courseTitle'       => 'required|string',
            'featureVideo'      => 'required|url',

            'modules'                   => 'required|array',
            'modules.*.moduleTitle'     => 'required|string',

            'modules.*.contents'                    => 'required|array',
            'modules.*.contents.*.contentTitle'     => 'required|string',
            'modules.*.contents.*.videoSourceType'  => 'required|string',
            'modules.*.contents.*.videoUrl'         => 'required|url',
            'modules.*.contents.*.videoLength'      => 'required',
        ], [
            'courseTitle.required'          => 'Please give a course title',
            'featureVideo.required'         => 'Please give a url',
            'featureVideo.url'              => 'Please give a valid feature video url',

            'modules.required'                          => 'Please add a module',
            'modules.*.moduleTitle.required'            => 'Please give a module title',

            'modules.*.contents.required'                       => 'Please add a module content',
            'modules.*.contents.*.contentTitle.required'        => 'Please give a module content title',
            'modules.*.contents.*.videoSourceType.required'     => 'Please select a video source type',
            'modules.*.contents.*.videoUrl.required'            => 'Please give a video url',
            'modules.*.contents.*.videoUrl.url'                 => 'Please give a valid url',
            'modules.*.contents.*.videoLength.required'         => 'Please select the video length',
        ]);


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

    public function edit($id){
        $course = Course::with('modules.contents')->findOrFail($id);
        return view('course.edit', [
            'course' => $course
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'courseTitle'       => 'required|string',
            'featureVideo'      => 'required|url',

            'modules'                   => 'required|array',
            'modules.*.moduleTitle'     => 'required|string',

            'modules.*.contents'                    => 'required|array',
            'modules.*.contents.*.contentTitle'     => 'required|string',
            'modules.*.contents.*.videoSourceType'  => 'required|string',
            'modules.*.contents.*.videoUrl'         => 'required|url',
            'modules.*.contents.*.videoLength'      => 'required',
        ], [
            'courseTitle.required'          => 'Please give a course title',
            'featureVideo.required'         => 'Please give a url',
            'featureVideo.url'              => 'Please give a valid feature video url',

            'modules.required'                          => 'Please add a module',
            'modules.*.moduleTitle.required'            => 'Please give a module title',

            'modules.*.contents.required'                       => 'Please add a module content',
            'modules.*.contents.*.contentTitle.required'        => 'Please give a module content title',
            'modules.*.contents.*.videoSourceType.required'     => 'Please select a video source type',
            'modules.*.contents.*.videoUrl.required'            => 'Please give a video url',
            'modules.*.contents.*.videoUrl.url'                 => 'Please give a valid url',
            'modules.*.contents.*.videoLength.required'         => 'Please select the video length',
        ]);
        Course::updateCourse($request, $id);
        Alert::success('Course Updated', 'Course updated successfully.');
        return redirect()->route('course.all');
    }

    public function delete($id){
        Course::destroy($id);
        Alert::success('Course Deleted', 'Course deleted successfully.');
        return redirect()->route('course.all');
    }
}
