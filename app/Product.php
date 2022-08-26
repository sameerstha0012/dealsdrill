<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Sluggable;

	public function seller()
	{
		return $this->belongsTo(User::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function subcategory()
	{
		return $this->belongsTo(SubCategory::class);
	}

	public function galleries()
	{
		return $this->hasMany(Gallery::class);
    }

    public function scopeOfCategory($query, $category)
    {   
        if($category != '') {
            return $query->where('products.category_id', $category);
        } else {
            return $query;
        }
    }

    public function scopeOfSubCategory($query, $subcategory)
    {   
        if($subcategory != '') {
            return $query->where('products.sub_category_id', $subcategory);
        } else {
            return $query;
        }
    }

	public function scopeOfCondition($query, $condition)
    {   
        if($condition != '') {
            return $query->where('products.condition', $condition);
        } else {
            return $query;
        }
	}

	public function scopeOfPrice($query, $start, $end)
    {   
        if($start != '' || $end != '') {
            return $query->whereBetween('products.price', [$start, $end]);
        } else {
            return $query;
        }
	}

	public function scopeOfLocation($query, $location)
    {   
        if($location != '') {
            // return $query->where('users.address', $location);
            return $query->where('users.address', 'like', '%'.$location.'%');
        } else {
            return $query;
        }
    }

    public function scopeOfOrder($query, $sort, $order)
    {   
        if($sort != '' || $order != '') {
            return $query->orderBy('products.'.$sort, $order);
        } else {
            return $query->orderBy('products.created_at', 'DESC');
        }
    }

    public function scopeOfSearch($query, $keyword)
    {   
        if($keyword != '') {
            $query->where('products.name', 'like', '%'.$keyword.'%')
                ->orWhere('products.features', 'like', '%'.$keyword.'%')
                ->orWhere('categories.name', 'like', '%'.$keyword.'%')
                ->orWhere('sub_categories.name', 'like', '%'.$keyword.'%');
            return $query;
        } else {
            return $query;
        }
    }

}
