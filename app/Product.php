<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends BaseModel
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $fillable = ['product_code', 'product_name', 'description', 'price', 'brand_id', 'category_id'];

    /**
     * Get the brand that the product belongs to.
     */
    public function brand(){
        return $this->belongsTo('App\Brand','brand_id');
    }

    /**
     * Get the category that the product belongs to.
     */
    public function category(){
        return $this->belongsTo('App\Category','category_id');
    }

}
