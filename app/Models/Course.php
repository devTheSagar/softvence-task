<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Course extends Model
{
    private static $course;

    public static function storeCourse($request){
        self::$course = new Course();
        self::$course->courseTitle = $request->courseTitle;
        self::$course->featureVideo = $request->featureVideo;
        self::$course->save();

        $modules = $request->modules;

        foreach ($modules as $module) {
            $modRequest = new Request($module);
            Module::storeModule($modRequest, self::$course->id);
        }

        return self::$course;
        
    }

    public static function updateCourse($request, $id){
        self::$course = Course::find($id);
        self::$course->courseTitle = $request->courseTitle;
        self::$course->featureVideo = $request->featureVideo;
        self::$course->save();

        $modules = $request->modules ?? [];

        foreach ($modules as $module) {
            $modRequest = new \Illuminate\Http\Request($module);
            if (!empty($module['id'])) {
                Module::updateModule($modRequest, self::$course->id);
            } else {
                Module::storeModule($modRequest, self::$course->id);
            }
        }

        return self::$course;
    }

    public static function destroy($id){
        self::$course = Course::find($id);
        self::$course->delete();
    }


    public function modules(){
        return $this->hasMany(Module::class);
    }
}
