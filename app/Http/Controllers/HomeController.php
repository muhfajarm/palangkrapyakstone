<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Product;
use App\Category;

class HomeController extends Controller
{
    private function getCarts()
    {
        $carts = json_decode(request()->cookie('dw-carts'), true);
        $carts = $carts != '' ? $carts:[];
        return $carts;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth', 'verified']);
        $this->middleware(['auth']);
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

        $carts = $this->getCarts();
        $totalcart = collect($carts)->sum(function($q) {
            return $q['jumlah'];
            });

        if (Auth::user()->admin == 1) {
            return view('admin.dashboard');
        } elseif (Auth::user()->admin == 0) {
            return view('welcome', compact('products', 'carts', 'categories', 'totalcart'));
        }
    }
}
