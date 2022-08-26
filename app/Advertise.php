<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertise extends Model{

	use Sluggable;
    	
    protected $table = 'advertise';

    protected $fillable = [
    	'title', 'link', 'pic', 'type', 'status', 'order', 'created_at', 'updated_at'
    ];


}
