<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getStatusLabelAttribute()
    {
        //ADAPUN VALUENYA AKAN MENCETAK HTML BERDASARKAN VALUE DARI FIELD STATUS
        if ($this->stok == 0) {
            return '<span class="badge badge-danger">Habis</span>';
        }
        return '<span class="badge badge-success">Masih</span>';
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
