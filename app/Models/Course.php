<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    private static $course;

    public static function storeCourse($request){
        self::$course = new Course();
        self::$course->courseTitle = $request->courseTitle;
        self::$course->featureVideo = $request->featureVideo;
        self::$course->save();

        // Now we can safely use self::$course->id
        // $modules = json_decode($request->modules, true);
        $modules = $request->modules;

        foreach ($modules as $mod) {
            $modRequest = new \Illuminate\Http\Request($mod);
            Module::storeModule($modRequest, self::$course->id);
        }

        return self::$course;
        
    }

    public function modules(){
        return $this->hasMany(Module::class);
    }
}
