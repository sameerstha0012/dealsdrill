<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model{

    protected $table = "blogs";

    protected $fillable = [
            "name", "permalink", "pics", "description", "status", "seo_title", "seo_keywords", 
            "seo_description", "created_at", "updated_at"
        ];
    
}
