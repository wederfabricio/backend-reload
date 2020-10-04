<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['ref', 'quantity', 'resume', 'price_ht', 'price_ttc','desc', 'active', 'category_id'];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }
}
