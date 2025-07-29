<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public static function updateCourse($request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $course = Course::findOrFail($id);
            $course->courseTitle = $request->courseTitle;
            $course->featureVideo = $request->featureVideo;
            $course->save();

            // Delete removed modules and their contents
            if ($request->filled('deletedModules')) {
                $deletedModuleIds = explode(',', $request->deletedModules);
                Content::whereIn('module_id', $deletedModuleIds)->delete();
                Module::whereIn('id', $deletedModuleIds)->delete();
            }

            // Delete removed contents only
            if ($request->filled('deletedContents')) {
                $deletedContentIds = explode(',', $request->deletedContents);
                Content::whereIn('id', $deletedContentIds)->delete();
            }

            foreach ($request->modules ?? [] as $modData) {
                $module = !empty($modData['id']) 
                    ? Module::find($modData['id']) 
                    : new Module();

                $module->moduleTitle = $modData['moduleTitle'];
                $module->course_id = $course->id;
                $module->save();

                foreach ($modData['contents'] ?? [] as $contData) {
                    $content = !empty($contData['id']) 
                        ? Content::find($contData['id']) 
                        : new Content();

                    $content->contentTitle = $contData['contentTitle'];
                    $content->videoSourceType = $contData['videoSourceType'];
                    $content->videoUrl = $contData['videoUrl'];
                    $content->videoLength = $contData['videoLength'];
                    $content->module_id = $module->id;
                    $content->save();
                }
            }
        });
    }

    public static function destroy($id){
        self::$course = Course::find($id);
        self::$course->delete();
    }


    public function modules(){
        return $this->hasMany(Module::class);
    }
}
