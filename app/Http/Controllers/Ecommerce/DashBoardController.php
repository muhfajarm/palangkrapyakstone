<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Order;

class DashBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        // $orders = Order::selectRaw('COALESCE(sum(CASE WHEN status = 0 THEN subtotal END), 0) as pending, 
        // COALESCE(count(CASE WHEN status = 3 THEN subtotal END), 0) as shipping,
        // COALESCE(count(CASE WHEN status = 4 THEN subtotal END), 0) as completeOrder')
        // ->where('pelanggan_id', auth()->user()->id)->get();
        $orders = Order::selectRaw('COALESCE(sum(CASE WHEN status = "pending" THEN subtotal END), 0) as pending, 
        COALESCE(count(CASE WHEN status = "dikirim" THEN subtotal END), 0) as shipping,
        COALESCE(count(CASE WHEN status = "diterima" THEN subtotal END), 0) as completeOrder')
        ->where('pelanggan_id', auth()->user()->id)->get();

        return view('layouts.ecommerce.dashboard', compact('orders'));
    }
}
