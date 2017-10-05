<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $table = 'orders';
    protected $fillable = ['order_number', 'transaction_date', 'customer_id', 'total_amount', 'status',];
}
