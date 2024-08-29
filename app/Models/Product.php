<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image'];
    
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function features(){
        return $this->hasMany(Feature::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $product->features()->delete();
        });
    }
}
