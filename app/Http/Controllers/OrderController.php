<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['pelanggan.city.province'])
            ->withCount('return')
            ->orderBy('created_at', 'DESC')->get();

        // $orders = $orders->paginate();
        // return $orders;
        return view('admin.pages.order.order', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Order::create($request->all());

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $orders = Order::findOrFail($request->id);

        $orders->update($request->all());

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $order = Order::findOrFail($request->id);

        $order->details()->delete();
        $order->payment()->delete();
        $order->delete();
        // $orders->delete();

        return back();
    }

    public function view($invoice)
    {
        $order = Order::with(['pelanggan.city.province', 'payment', 'details.produk'])->where('invoice', $invoice)->first();
        // return $order;
        return view('admin.pages.order.view', compact('order'));
    }

    public function acceptPayment($invoice)
    {
        //MENGAMBIL DATA CUSTOMER BERDASARKAN INVOICE
        $order = Order::with(['payment'])->where('invoice', $invoice)->first();
        //UBAH STATUS DI TABLE PAYMENTS MELALUI ORDER YANG TERKAIT
        // $order->payment()->update(['status' => 1]);
        //UBAH STATUS ORDER MENJADI PROSES
        $order->update(['status' => 'proses']);
        //REDIRECT KE HALAMAN YANG SAMA.
        return redirect(route('orders.view', $order->invoice));
    }

    public function shippingOrder(Request $request)
    {
        //MENGAMBIL DATA ORDER BERDASARKAN ID
        $order = Order::with(['pelanggan'])->find($request->order_id);
        //UPDATE DATA ORDER DENGAN MEMASUKKAN NOMOR RESI DAN MENGUBAH STATUS MENJADI DIKIRIM
        $order->update(['tracking_number' => $request->tracking_number, 'status' => 'dikirim']);
        //KIRIM EMAIL KE PELANGGAN TERKAIT
        // Mail::to($order->customer->email)->send(new OrderMail($order));
        //REDIRECT KEMBALI
        return redirect()->back();
    }

    public function return($invoice)
    {
        $order = Order::with(['return', 'pelanggan'])->where('invoice', $invoice)->first();
        return view('admin.pages.order.return', compact('order'));
    }

    public function approveReturn(Request $request)
    {
        $this->validate($request, ['status' => 'required']); //validasi status
        $order = Order::find($request->order_id); //query berdasarkan order_id
        $order->return()->update(['status' => $request->status]); //update status yang ada di table order_returns melalui order
        $order->update(['status' => 'diterima']); //update status yang ada di table orders
        return redirect()->back();
    }
}
