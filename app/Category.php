<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
	public $timestamps = false;

	protected $guarded = [];

    protected $table = 'categories';
	
    protected $fillable = ['nama', 'slug'];

    public function produk(){
    	return $this->hasMany(Product::class);
    }

    //MUTATOR
	public function setSlugAttribute($value)
	{
	    $this->attributes['slug'] = Str::slug($value);
	}

	//ACCESSOR
	public function getNameAttribute($value)
	{
	    return ucfirst($value);
	}
}
