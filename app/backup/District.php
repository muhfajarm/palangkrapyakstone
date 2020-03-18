<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [];

    // public function orders(){
    // 	return $this->hasMany(Order::class);
    // }

    // public function orderdetail(){
    // 	return $this->hasMany(OrderDetail::class);
    // }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
