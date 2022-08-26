<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Sluggable;

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	public function subcategories()
	{
		return $this->hasMany(SubCategory::class);
    }
    
}
