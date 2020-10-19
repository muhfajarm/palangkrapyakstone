<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;
use PDF;
use Telegram\Bot\Laravel\Facades\Telegram;

use App\Payment;
use App\Order;
use App\OrderDetail;
use App\OrderReturn;

class OrderController extends Controller
{
	public function index()
	{
		$orders = Order::withCount(['return'])
			->with(['return'])
			->where('pelanggan_id', auth()->user()->id)
        	->orderBy('created_at', 'DESC')->paginate(10);
	    return view('layouts.ecommerce.orders.index', compact('orders'));
	}

	public function view($invoice)
	{
		$order = Order::with(['city.province', 'details', 'details.produk', 'payment'])
	        ->where('invoice', $invoice)->first();

	    if (\Gate::forUser(auth()->user())->allows('order-view', $order)) {
	    	// return $order;
	        return view('layouts.ecommerce.orders.view', compact('order'));
	    }
	    return redirect(route('customer.orders'))->with(['error' => 'Anda Tidak Diizinkan Untuk Mengakses Order Orang Lain']);
	}

	public function paymentForm($invoice)
	{
		$prices = Order::where('invoice', $invoice)->first();
		// return $prices;
		return view('layouts.ecommerce.payment', compact('prices'));
	}

	public function storePayment(Request $request)
	{
		//VALIDASI DATANYA
	    $this->validate($request, [
	        'invoice' => 'required|exists:orders,invoice',
	        'nama' => 'required|string',
	        'transfer_ke' => 'required|string',
	        'tgl_transfer' => 'required',
	        'jumlah' => 'required|integer',
	        'bukti' => 'required|image|mimes:jpg,png,jpeg'
	    ]);

	    //DEFINE DATABASE TRANSACTION UNTUK MENGHINDARI KESALAHAN SINKRONISASI DATA JIKA TERJADI ERROR DITENGAH PROSES QUERY
	    DB::beginTransaction();
	    try {
	        //AMBIL DATA ORDER BERDASARKAN INVOICE ID
	        $order = Order::where('invoice', $request->invoice)->first();
	        if ($order->subtotal != $request->jumlah) return redirect()->back()->with(['error' => 'Error, Pembayaran Harus Sama Dengan Tagihan']);
	        //JIKA STATUSNYA MASIH 0 DAN ADA FILE BUKTI TRANSFER YANG DI KIRIM
	        if ($order->status == 0 && $request->hasFile('bukti')) {
	            //MAKA UPLOAD FILE GAMBAR TERSEBUT
	            $file = $request->file('bukti');
	            $filename = time() . '.' . $file->getClientOriginalExtension();
	            // $file->storeAs('public/payment', $filename);
	            $file->move('storage/payment', $filename);

	            //KEMUDIAN SIMPAN INFORMASI PEMBAYARANNYA
	            Payment::create([
	                'order_id' => $order->id,
	                'nama' => $request->nama,
	                'transfer_ke' => $request->transfer_ke,
	                'tgl_transfer' => Carbon::parse($request->tgl_transfer)->format('Y-m-d'),
	                'jumlah' => $request->jumlah,
	                'bukti' => $filename,
	                'status' => false
	            ]);
	            //DAN GANTI STATUS ORDER MENJADI 1
	            $order->update(['status' => 1]);
	            //JIKA TIDAK ADA ERROR, MAKA COMMIT UNTUK MENANDAKAN BAHWA TRANSAKSI BERHASIL
	            DB::commit();
	            // $orderBot = Order::find($id); //AMBIL DATA ORDER BERDASARKAN ID
		        //KIRIM PESAN MELALUI BOT
		        $this->sendMessageOrder('#' . $order->invoice);
		        // return $orderBot;
	            //REDIRECT DAN KIRIMKAN PESAN
	            return redirect()->back()->with(['success' => 'Pesanan Dikonfirmasi']);
	        }
	        //REDIRECT DENGAN ERROR MESSAGE
	        return redirect()->back()->with(['error' => 'Error, Upload Bukti Transfer']);
	    } catch(\Exception $e) {
	        //JIKA TERJADI ERROR, MAKA ROLLBACK SELURUH PROSES QUERY
	        DB::rollback();
	        //DAN KIRIMKAN PESAN ERROR
	        return redirect()->back()->with(['error' => $e->getMessage()]);
	    }
	}

	private function sendMessageOrder($order_id)
	{
		$text = 'Hai PalangKrapyakStone, OrderID ' . $order_id . ' Sudah Melakukan Pembayaran, Segera Dicek Ya!';
 
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', '360510294'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
	}

	public function pdf($invoice)
	{
		//GET DATA ORDER BERDASRKAN INVOICE
	    $order = Order::with(['city.province', 'details', 'details.produk', 'payment'])
	        ->where('invoice', $invoice)->first();
	    //MENCEGAH DIRECT AKSES OLEH USER, SEHINGGA HANYA PEMILIKINYA YANG BISA MELIHAT FAKTURNYA
	    if (!\Gate::forUser(auth()->user())->allows('order-view', $order)) {
	        return redirect(route('layouts.customer.view_order', $order->invoice));
	    }

	    //JIKA DIA ADALAH PEMILIKNYA, MAKA LOAD VIEW BERIKUT DAN PASSING DATA ORDERS
	    $pdf = PDF::loadView('layouts.ecommerce.orders.pdf', compact('order'));
	    //KEMUDIAN BUKA FILE PDFNYA DI BROWSER
	    return $pdf->stream();
	}

	public function acceptOrder(Request $request)
	{
		//CARI DATA ORDER BERDASARKAN ID
	    $order = Order::find($request->order_id);
	    //VALIDASI KEPEMILIKAN
	    if (!\Gate::forUser(auth()->user())->allows('order-view', $order)) {
	        return redirect()->back()->with(['error' => 'Bukan Pesanan Kamu']);
	    }

	    //UBAH STATUSNYA MENJADI 4
	    $order->update(['status' => 'selesai']);
	    //REDIRECT KEMBALI DENGAN MENAMPILKAN ALERT SUCCESS
	    return redirect()->back()->with(['success' => 'Pesanan Dikonfirmasi']);
	}

	public function returnForm($invoice)
	{
		//LOAD DATA BERDASARKAN INVOICE
	    $order = Order::where('invoice', $invoice)->first();
	    //LOAD VIEW RETURN.BLADE.PHP DAN PASSING DATA ORDER
	    return view('layouts.ecommerce.orders.return', compact('order'));
	}

	public function processReturn(Request $request, $id)
	{
		//LAKUKAN VALIDASI DATA
	    $this->validate($request, [
	        'reason' => 'required|string',
	        // 'refund_transfer' => 'required|string',
	        'photo' => 'required|image|mimes:jpg,png,jpeg'
	    ]);

	    //CARI DATA RETURN BERDASARKAN order_id YANG ADA DITABLE ORDER_RETURNS NANTINYA
	    $return = OrderReturn::where('order_id', $id)->first();
	    //JIKA DITEMUKAN, MAKA TAMPILKAN NOTIFIKASI ERROR
	    if ($return) return redirect()->back()->with(['error' => 'Permintaan Refund Dalam Proses']);

	    //JIKA TIDAK, LAKUKAN PENGECEKAN UNTUK MEMASTIKAN FILE FOTO DIKIRIMKAN
	    if ($request->hasFile('photo')) {
	        //GET FILE
	        $file = $request->file('photo');
	        //GENERATE NAMA FILE BERDASARKAN TIME DAN STRING RANDOM
	        $filename = time() . Str::random(5) . '.' . $file->getClientOriginalExtension();
	        //KEMUDIAN UPLOAD KE DALAM FOLDER STORAGE/APP/PUBLIC/RETURN
	        // $file->storeAs('public/return', $filename);
	        $file->move('storage/return', $filename);

	        //DAN SIMPAN INFORMASINYA KE DALAM TABLE ORDER_RETURNS
	        OrderReturn::create([
	            'order_id' => $id,
	            'photo' => $filename,
	            'reason' => $request->reason,
	            // 'refund_transfer' => $request->refund_transfer,
	            'status' => 0
	        ]);

	        $order = Order::find($id); //AMBIL DATA ORDER BERDASARKAN ID
	        //KIRIM PESAN MELALUI BOT
	        $this->sendMessageReturn('#' . $order->invoice, $request->reason);

	        //LALU TAMPILKAN NOTIFIKASI SUKSES
	        return redirect()->back()->with(['success' => 'Permintaan Refund Dikirim']);
	    }
	}

	private function sendMessageReturn($order_id, $reason)
	{
		$text = 'Hai PalangKrapyakStone, OrderID ' . $order_id . ' Melakukan Permintaan Refund Dengan Alasan "'. $reason .'", Segera Dicek Ya!';
 
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID', '360510294'),
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
	}

	public function acceptReturn(Request $request)
	{
	    $return = OrderReturn::where('order_id', $request->order_id);

	    $return->update(['status' => 4]);

	    return redirect()->back()->with(['success' => 'Return Dikonfirmasi']);
	}
}