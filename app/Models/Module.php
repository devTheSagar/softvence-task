<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    private static $module;

    public static function storeModule($request, $courseId){
        self::$module = new Module();
        self::$module->moduleTitle = $request->moduleTitle;
        self::$module->course_id = $courseId;
        self::$module->save();

        // Make sure contents are passed correctly
        $contents = $request->contents;
        foreach ($contents as $content) {
            $contentRequest = new \Illuminate\Http\Request($content);
            Content::storeContent($contentRequest, self::$module->id);
        }

        // return self::$module;
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function content(){
        return $this->hasMany(Content::class);
    }
}
