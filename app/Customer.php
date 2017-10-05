<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'customers';
    protected $fillable = ['first_name', 'last_name', 'email', 'postal_address', 'physical_address'];
}
