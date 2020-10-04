<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['desc', 'parent_id'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function parentCategory()
    {
        return $this->belongsTo(Self::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Self::class, 'parent_id');
    }

    public function allSubcategories()
    {
        return $this->subcategories()->with('allSubcategories');
    }

    public function tree()
    {
        return $this->parentCategory
            ? $this->parentCategory->tree()
            : $this;
    }
}
