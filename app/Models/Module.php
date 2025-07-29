<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Module extends Model
{
    private static $module;

    public static function storeModule($request, $courseId){
        self::$module = new Module();
        self::$module->moduleTitle = $request->moduleTitle;
        self::$module->course_id = $courseId;
        self::$module->save();

        $contents = $request->contents;
        
        foreach ($contents as $content) {
            $contentRequest = new Request($content);
            Content::storeContent($contentRequest, self::$module->id);
        }
    }

    public static function updateModule($request, $courseId){
        if (!empty($request->id)) {
            self::$module = Module::find($request->id);
            if (!self::$module) {
                self::$module = new Module();
            }
        } else {
            self::$module = new Module();
        }
        self::$module->moduleTitle = $request->moduleTitle;
        self::$module->course_id = $courseId;
        self::$module->save();

        $contents = $request->contents ?? [];

        foreach ($contents as $content) {
            $contentRequest = new \Illuminate\Http\Request($content);
            $contentRequest->merge(['module_id' => self::$module->id]);

            Content::updateContent($contentRequest, $content['id']);

        }

        return self::$module;
    }


    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function contents(){
        return $this->hasMany(Content::class);
    }
}
