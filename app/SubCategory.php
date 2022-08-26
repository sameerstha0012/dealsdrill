<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use Sluggable;

	public function products()
	{
		return $this->hasMany(Product::class);
	}
	
	public function category()
	{
		return $this->belongsTo(Category::class);
	}
    
}
