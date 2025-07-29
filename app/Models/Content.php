<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    private static $content;

    public static function storeContent($request, $moduleId){
        self::$content = new Content();
        self::$content->contentTitle = $request->contentTitle;
        self::$content->videoSourceType = $request->videoSourceType;
        self::$content->videoUrl = $request->videoUrl;
        self::$content->videoLength = $request->videoLength;
        self::$content->module_id = $moduleId;;
        self::$content->save();
    }

    public static function updateContent($request, $contentId)
    {
        self::$content = Content::find($contentId);
        if (!self::$content) {
            self::$content = new Content();
        }

        self::$content->contentTitle     = $request->contentTitle;
        self::$content->videoSourceType  = $request->videoSourceType;
        self::$content->videoUrl         = $request->videoUrl;
        self::$content->videoLength      = $request->videoLength;
        self::$content->module_id        = $request->module_id ?? self::$content->module_id; // keep existing if null

        self::$content->save();
    }




    public function module(){
        return $this->belongsTo(Module::class);
    }

}
