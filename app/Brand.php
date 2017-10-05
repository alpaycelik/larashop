<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends BaseModel
{

    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'brands';
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'description'];

    public function products(){
        return $this->hasMany('App\Product','brand_id','id');
    }
}
