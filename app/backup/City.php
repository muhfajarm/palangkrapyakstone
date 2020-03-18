<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];

    protected $table = 'cities';

    public function orders(){
    	return $this->hasMany(Order::class);
    }

    public function orderdetail(){
    	return $this->hasMany(OrderDetail::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
