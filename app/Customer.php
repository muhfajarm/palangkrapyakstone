<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	public $timestamps = false;
	
    protected $guarded = [];

    public function city(){
        return $this->belongsTo(City::class);
    }
}
