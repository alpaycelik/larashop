<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $orders = Order::all();
        $params = [
            'title' => 'Order Listing',
            'orders' => $orders
        ];
        return view('admin.orders.orders_list')->with($params);
    }
}
