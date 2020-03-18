<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function produk(){
        return $this->belongsTo(Product::class);
    }
}
