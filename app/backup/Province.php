<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $guarded = [];

    protected $table = 'provinces';

    public $timestamps = false;

    public function orders(){
    	return $this->hasMany(Order::class);
    }

    public function orderdetail(){
    	return $this->hasMany(OrderDetail::class);
    }
}
