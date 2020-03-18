<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Product;
use App\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::paginate(12);
        $categories = Category::All();

        if (request()->cari != '') {
            $products = $products->where('nama', 'LIKE', '%' . request()->q . '%')->paginate(12);
            return view('test', compact('products', 'categories'));
        }

        if (Auth::user()->admin == 1) {
            return view('admin.dashboard');
        } elseif (Auth::user()->admin == 0) {
            return view('welcome', compact('products', 'categories'));
        }
    }
}
