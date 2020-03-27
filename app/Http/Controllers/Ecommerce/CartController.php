<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Veritrans_Config;
use Veritrans_Snap;
use Veritrans_Notification;
use Telegram\Bot\Laravel\Facades\Telegram;

use App\Product;
use App\Category;
use App\Province;
use App\City;
// use App\District;
use App\Customer;
use App\User;
use App\Order;
use App\OrderDetail;

class CartController extends Controller
{
	protected $request;

	public function __construct(Request $request)
    {
        $this->request = $request;
 
        // Set midtrans configuration
        Veritrans_Config::$serverKey = config('services.midtrans.serverKey');
        Veritrans_Config::$isProduction = config('services.midtrans.isProduction');
        Veritrans_Config::$isSanitized = config('services.midtrans.isSanitized');
        Veritrans_Config::$is3ds = config('services.midtrans.is3ds');
    }

	private function getCarts()
	{
		$carts = json_decode(request()->cookie('dw-carts'), true);
	    $carts = $carts != '' ? $carts:[];
	    return $carts;
	}

    public function addToCart(Request $request)
	{
		$this->validate($request, [
	        'produk_id' => 'required', //PASTIKAN PRODUCT_IDNYA ADA DI DB
	        'jumlah' => 'required|integer' //PASTIKAN QTY YANG DIKIRIM INTEGER
	    ]);

	    //AMBIL DATA CART DARI COOKIE, KARENA BENTUKNYA JSON MAKA KITA GUNAKAN JSON_DECODE UNTUK MENGUBAHNYA MENJADI ARRAY
	    $carts = $this->getCarts();

	    //CEK JIKA CARTS TIDAK NULL DAN PRODUCT_ID ADA DIDALAM ARRAY CARTS
	    if ($carts && array_key_exists($request->produk_id, $carts)) {
	        //MAKA UPDATE QTY-NYA BERDASARKAN PRODUCT_ID YANG DIJADIKAN KEY ARRAY
	        $carts[$request->produk_id]['jumlah'] += $request->jumlah;
	    } else {
	        //SELAIN ITU, BUAT QUERY UNTUK MENGAMBIL PRODUK BERDASARKAN PRODUCT_ID
	        $products = Product::find($request->produk_id);
	        //TAMBAHKAN DATA BARU DENGAN MENJADIKAN PRODUCT_ID SEBAGAI KEY DARI ARRAY CARTS
	        $carts[$request->produk_id] = [
	            'jumlah' => $request->jumlah,
	            'produk_id' => $products->id,
	            'produk_nama' => $products->nama,
	            'harga_produk' => $products->harga_jual_3,
	            'gambar_produk' => $products->image
	        ];
	    }

	    //BUAT COOKIE-NYA DENGAN NAME DW-CARTS
	    //JANGAN LUPA UNTUK DI-ENCODE KEMBALI, DAN LIMITNYA 2800 MENIT ATAU 48 JAM
	    $cookie = cookie('dw-carts', json_encode($carts), 2880);
	    //STORE KE BROWSER UNTUK DISIMPAN
	    return redirect()->back()->cookie($cookie);
	}

	public function listCart()
	{
		$categories = Category::All();

	    //MENGAMBIL DATA DARI COOKIE
	    $carts = $this->getCarts();
	    //UBAH ARRAY MENJADI COLLECTION, KEMUDIAN GUNAKAN METHOD SUM UNTUK MENGHITUNG SUBTOTAL
	    $subtotal = collect($carts)->sum(function($q) {
	        return $q['jumlah'] * $q['harga_produk']; //SUBTOTAL TERDIRI DARI QTY * PRICE
	    });
	    //LOAD VIEW CART.BLADE.PHP DAN PASSING DATA CARTS DAN SUBTOTAL
	    return view('layouts.ecommerce.cart', compact('categories', 'carts', 'subtotal'));
	}

	public function updateCart(Request $request)
	{
		//AMBIL DATA DARI COOKIE
	    $carts = $this->getCarts();
	    //KEMUDIAN LOOPING DATA PRODUCT_ID, KARENA NAMENYA ARRAY PADA VIEW SEBELUMNYA
	    //MAKA DATA YANG DITERIMA ADALAH ARRAY SEHINGGA BISA DI-LOOPING
	    foreach ($request->produk_id as $key => $row) {
	        //DI CHECK, JIKA QTY DENGAN KEY YANG SAMA DENGAN PRODUCT_ID = 0
	        if ($request->jumlah[$key] == 0) {
	            //MAKA DATA TERSEBUT DIHAPUS DARI ARRAY
	            unset($carts[$row]);
	        } else {
	            //SELAIN ITU MAKA AKAN DIPERBAHARUI
	            $carts[$row]['jumlah'] = $request->jumlah[$key];
	        }
	    }
	    //SET KEMBALI COOKIE-NYA SEPERTI SEBELUMNYA
	    $cookie = cookie('dw-carts', json_encode($carts), 2880);
	    //DAN STORE KE BROWSER.
	    return redirect()->back()->cookie($cookie);
	}

	public function checkout()
	{
		$categories = Category::All();

		$customer = auth()->user()->load('city');
	    //QUERY UNTUK MENGAMBIL SEMUA DATA PROPINSI
	    $provinces = Province::orderBy('title', 'ASC')->get();
	    $carts = $this->getCarts(); //MENGAMBIL DATA CART
	    //MENGHITUNG SUBTOTAL DARI KERANJANG BELANJA (CART)
	    $subtotal = collect($carts)->sum(function($q) {
	        return $q['jumlah'] * $q['harga_produk'];
	    });
	    //ME-LOAD VIEW CHECKOUT.BLADE.PHP DAN PASSING DATA PROVINCES, CARTS DAN SUBTOTAL
	    // return $provinces;
	    if ($carts == null)
	    	return redirect()->route('front.index')->with(['error' => 'Keranjang Belanja Kosong! Harap Belanja Terlebih Dahulu']);
	    else
		    return view('layouts.ecommerce.checkout', compact('categories', 'customer', 'provinces', 'carts', 'subtotal'));
	   
	}

	public function getCity()
	{
	    //QUERY UNTUK MENGAMBIL DATA KOTA / KABUPATEN BERDASARKAN PROVINCE_ID
	    $cities = City::where('province_id', request()->province_id)->get();
	    //KEMBALIKAN DATANYA DALAM BENTUK JSON
	    return response()->json(['status' => 'success', 'data' => $cities]);
	}

	// public function getDistrict()
	// {
	//     //QUERY UNTUK MENGAMBIL DATA KECAMATAN BERDASARKAN CITY_ID
	//     $districts = District::where('city_id', request()->city_id)->get();
	//     //KEMUDIAN KEMBALIKAN DATANYA DALAM BENTUK JSON
	//     return response()->json(['status' => 'success', 'data' => $districts]);
	// }

	public function processCheckout(Request $request)
	{
		// VALIDASI DATANYA
	    $this->validate($request, [
	        'nama' => 'required|string|max:30',
	        'no_hp' => 'required',
	        'email' => 'required|email',
	        'province_id' => 'required|exists:provinces,id',
	        'city_id' => 'required|exists:cities,id',
	        // 'district_id' => 'required|exists:districts,id',
	        'alamat' => 'required|string'
	    ]);

	    //INISIASI DATABASE TRANSACTION
	    //DATABASE TRANSACTION BERFUNGSI UNTUK MEMASTIKAN SEMUA PROSES SUKSES UNTUK KEMUDIAN DI COMMIT AGAR DATA BENAR BENAR DISIMPAN, JIKA TERJADI ERROR MAKA KITA ROLLBACK AGAR DATANYA SELARAS
	    DB::beginTransaction();
	    try {
	        //CHECK DATA CUSTOMER BERDASARKAN EMAIL
	        // $customer = Customer::where('email', $request->email)->first();
	        //JIKA DIA TIDAK LOGIN DAN DATA CUSTOMERNYA ADA
	        // if (!auth()->check() && $customer) {
	        // if (!auth()->check()) {
	            //MAKA REDIRECT DAN TAMPILKAN INSTRUKSI UNTUK LOGIN 
	            // return redirect()->back()->with(['error' => 'Silahkan Login Terlebih Dahulu']);
	            // return redirect()->back();
	        // }

	        //AMBIL DATA KERANJANG
	        $carts = $this->getCarts();
	        //HITUNG SUBTOTAL BELANJAAN
	        $subtotal = collect($carts)->sum(function($q) {
	            return $q['jumlah'] * $q['harga_produk'];
	        });

	        $user = auth()->user();
	        $data = $request->only(['no_hp', 'alamat', 'city_id']);
	        $user->update($data);
	        // return $data;

	        //SIMPAN DATA CUSTOMER
	        $customer = Customer::create([
	            'nama' => $this->request->nama,
	            'email' => $this->request->email,
	            'no_hp' => $this->request->no_hp,
	            'alamat' => $this->request->alamat,
	            'city_id' => $this->request->city_id,
	            'status' => false
	        ]);

	        //SIMPAN DATA ORDER
	        $pelangganid = auth()->user()->id;
	        $order = Order::create([
	            'invoice' => Str::random(4) . '-' . time(), //INVOICENYA KITA BUAT DARI STRING RANDOM DAN WAKTU
	            'pelanggan_id' => $pelangganid,
	            'pelanggan_nama' => $this->request->nama,
	            'pelanggan_no_hp' => $this->request->no_hp,
	            'pelanggan_alamat' => $this->request->alamat,
	            'city_id' => $this->request->city_id,
	            'subtotal' => $subtotal
	        ]);

	        //LOOPING DATA DI CARTS
	        foreach ($carts as $row) {
	            //AMBIL DATA PRODUK BERDASARKAN PRODUCT_ID
	            $product = Product::find($row['produk_id']);
	            //SIMPAN DETAIL ORDER
	            OrderDetail::create([
	                'order_id' => $order->id,
	                'produk_id' => $row['produk_id'],
	                'harga' => $row['harga_produk'],
	                'jumlah' => $row['jumlah'],
	                'berat' => $product->berat
	            ]);
	        }

	        // Buat transaksi ke midtrans kemudian save snap tokennya.
	        $transaction_details = [
		        'order_id'      => $order->invoice,
                'gross_amount'  => $subtotal,
	        ];
	        $customer_details = [
		        'first_name'    => $this->request->nama,
                'email'         => $this->request->email,
            ];
            $item_details = [];

	        $payload = [
	            'transaction_details' => $transaction_details,
	            'customer_details' => $customer_details,
	            'item_details' => $item_details,
	        ];

            foreach ($carts as $cart) {
            	$payload['item_details'][] = [
            		'id'       => $cart['produk_id'],
            		'price'    => $cart['harga_produk'],
            		'quantity' => $cart['jumlah'],
            		'name'     => $cart['produk_nama'],
            	];
            }
	        $snapToken = Veritrans_Snap::getSnapToken($payload);
	        $order->snap_token = $snapToken;
	        $order->save();

	        // Beri response snap token
	        $this->response['snap_token'] = $snapToken;

	        //TIDAK TERJADI ERROR, MAKA COMMIT DATANYA UNTUK MENINFORMASIKAN BAHWA DATA SUDAH FIX UNTUK DISIMPAN
	        DB::commit();

	        $carts = [];
	        //KOSONGKAN DATA KERANJANG DI COOKIE
	        $cookie = cookie('dw-carts', json_encode($carts), 2880);
	        //REDIRECT KE HALAMAN FINISH TRANSAKSI
	        return response()->json($this->response)->cookie($cookie);
	        // return redirect(route('front.finish_checkout', $order->invoice))->cookie($cookie);
	    } catch (\Exception $e) {
	        //JIKA TERJADI ERROR, MAKA ROLLBACK DATANYA
	        DB::rollback();
	        //DAN KEMBALI KE FORM TRANSAKSI SERTA MENAMPILKAN ERROR
	        return redirect()->back()->with(['error' => $e->getMessage()]);
	    }
	}

	public function checkoutFinish($invoice)
	{
		$categories = Category::All();
		
	    //AMBIL DATA PESANAN BERDASARKAN INVOICE
	    $order = Order::with(['city'])->where('invoice', $invoice)->first();
	    //LOAD VIEW checkout_finish.blade.php DAN PASSING DATA ORDER
	    return view('layouts.ecommerce.checkout_finish', compact('categories', 'order'));
	}

	public function notificationHandler(Request $request)
    {
        $notif = new Veritrans_Notification();
        \DB::transaction(function() use($notif) {
 
          $transaction = $notif->transaction_status;
          $type = $notif->payment_type;
          $orderId = $notif->order_id;
          $fraud = $notif->fraud_status;
          // $order = Order::findOrFail($orderId);
          $order = Order::where('invoice', $orderId)->first();

          if ($transaction == 'capture') {
 
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
 
              if($fraud == 'challenge') {
                // TODO set payment status in merchant's database to 'Challenge by FDS'
                // TODO merchant should decide whether this transaction is authorized or not in MAP
                // $donation->addUpdate("Transaction order_id: " . $orderId ." is challenged by FDS");
                $order->setPending();
              } else {
                // TODO set payment status in merchant's database to 'Success'
                // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully captured using " . $type);
                $order->setSuccess();
              }
 
            }
 
          } elseif ($transaction == 'settlement') {
 
            // TODO set payment status in merchant's database to 'Settlement'
            // $donation->addUpdate("Transaction order_id: " . $orderId ." successfully transfered using " . $type);
            $order->setSuccess();

            $this->sendMessageOrder('#' . $order->invoice);
 
          } elseif($transaction == 'pending'){
 
            // TODO set payment status in merchant's database to 'Pending'
            // $donation->addUpdate("Waiting customer to finish transaction order_id: " . $orderId . " using " . $type);
            $order->setPending();
 
          } elseif ($transaction == 'deny') {
 
            // TODO set payment status in merchant's database to 'Failed'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is Failed.");
            $order->setFailed();
 
          } elseif ($transaction == 'expire') {
 
            // TODO set payment status in merchant's database to 'expire'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is expired.");
            $order->setExpired();
 
          } elseif ($transaction == 'cancel') {
 
            // TODO set payment status in merchant's database to 'Failed'
            // $donation->addUpdate("Payment using " . $type . " for transaction order_id: " . $orderId . " is canceled.");
            $order->setFailed();
 
          }
 
        });
 
        return;
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
}
