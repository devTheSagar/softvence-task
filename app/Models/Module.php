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

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function contents(){
        return $this->hasMany(Content::class);
    }
}
