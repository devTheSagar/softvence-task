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

    public function modules(){
        return $this->hasMany(Module::class);
    }
}
