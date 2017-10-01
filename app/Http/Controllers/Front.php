<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Cart;
use App\Brand;
use App\Category;
use App\Product;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Auth;

class Front extends Controller {

    var $brands;
    var $categories;
    var $products;
    var $title;
    var $description;

    public function __construct() {
        $this->brands = Brand::all(['name']);
        $this->categories = Category::all(['name']);
        $this->products = Product::all(['id','name','price']);
    }

    public function index() {
        return view('home', ['title' => 'Welcome','description' => '','page' => 'home', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products]);
    }

    public function products() {
        return view('products', ['title' => 'Products Listing','description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products]);
    }

    public function product_details($id) {
        $product = Product::find($id);
        return view('product_details', ['product' => $product, 'title' => $product->name,'description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products]);
    }

    public function product_categories($name) {
        return view('products', ['title' => 'Welcome','description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products]);
    }

    public function product_brands($name, $category = null) {
        return view('products', ['title' => 'Welcome','description' => '','page' => 'products', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products]);
    }

    public function blog() {
        $posts = Post::where('id', '>', 0)->paginate(3);
        $posts->setPath('blog');

        $data['posts'] = $posts;

        return view('blog', ['data' => $data, 'title' => 'Latest Blog Posts', 'description' => '', 'page' => 'blog', 'brands' => $this->brands, 'categories' => $this->categories, 'products' => $this->products]);
    }

    public function blog_post($url) {
        $post = Post::whereUrl($url)->first();

        $tags = $post->tags;
        $prev_url = Post::prevBlogPostUrl($post->id);
        $next_url = Post::nextBlogPostUrl($post->id);
        $title = $post->title;
        $description = $post->description;
        $page = 'blog';
        $brands = $this->brands;
        $categories = $this->categories;
        $products = $this->products;

        $data = compact('prev_url', 'next_url', 'tags', 'post', 'title', 'description', 'page', 'brands', 'categories', 'products');

        return view('blog_post', $data);
    }

    public function contact_us() {
        return view('contact_us', ['title' => 'Welcome','description' => '','page' => 'contact_us']);
    }

    public function login() {
        return view('login', ['title' => 'Welcome','description' => '','page' => 'home']);
    }

    /* public function logout() {
        return view('login', ['title' => 'Welcome','description' => '','page' => 'home']);
    } */

    public function cart() {
        //update/ add new item to cart
        if (Request::isMethod('post')) {
            $product_id = Request::get('product_id');
            $product = Product::find($product_id);
            Cart::add(['id' => $product_id, 'name' => $product->name, 'qty' => 1, 'price' => $product->price]);
        }

        //increment the quantity
        if (Request::get('product_id') && (Request::get('increment')) == 1) {
            $rowId = Cart::search(['id' => Request::get('product_id')]);
            $item = Cart::get($rowId[0]);

            Cart::update($rowId[0], $item->qty + 1);
        }

        //decrease the quantity
        if (Request::get('product_id') && (Request::get('decrease')) == 1) {
            $rowId = Cart::search(['id' => Request::get('product_id')]);
            $item = Cart::get($rowId[0]);

            Cart::update($rowId[0], $item->qty - 1);
        }

        $cart = Cart::content();

        return view('cart', array('cart' => $cart, 'title' => 'Welcome', 'description' => '', 'page' => 'home'));
    }

    public function checkout() {
        return view('checkout', ['title' => 'Welcome','description' => '','page' => 'home']);
    }

    public function search($query) {
        return view('products', ['title' => 'Welcome','description' => '','page' => 'products']);
    }

    public function register() {
        if (Request::isMethod('post')) {
            User::create([
                'name' => Request::get('name'),
                'email' => Request::get('email'),
                'password' => bcrypt(Request::get('password')),
            ]);
        }

        return Redirect::away('login');
    }

    public function authenticate() {
        if (Auth::attempt(['email' => Request::get('email'), 'password' => Request::get('password')])) {
            return redirect()->intended('checkout');
        } else {
            return view('login', ['title' => 'Welcome', 'description' => '', 'page' => 'home']);
        }
    }

    public function logout() {
        Auth::logout();

        return Redirect::away('login');
    }

}