<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = ['product_id','description'];
    
    public function products(){
        return $this->belongsTo(Product::class, "product_id");
    }
}
