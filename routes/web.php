<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/', 'Ecommerce\FrontController@index')->name('front.index');
Route::post('/finish', function(){
    return redirect()->route('customer.orders');
})->name('checkout.finish');
Route::post('/notification/handler', 'Ecommerce\CartController@notificationHandler')->name('notification.handler');
// Route::get('/cari/', 'Ecommerce\FrontController@cari')->name('front.cari');
Route::get('/p/{slug}', 'Ecommerce\FrontController@show')->name('front.show');
Route::get('/k/{slug}', 'Ecommerce\FrontController@categoryProduct')->name('front.category');
Route::get('/api/getPopover', 'Ecommerce\FrontController@getPopover');
Route::get('/api/cityF', 'Ecommerce\FrontController@getCity');
Route::get('/api/costF', 'Ecommerce\FrontController@getCourier');
Route::post('/origin={city_origin}&destination={city_destination}&weight={weight}&courier={courier}','Ecommerce\FrontController@getOngkir');
Route::get('/api/cityC', 'Ecommerce\CartController@getCity');
Route::get('/api/costC', 'Ecommerce\CartController@getCourier');
// Route::get('/kategori/{id}', 'Ecommerce\FrontController@categoryProduct')->name('front.category');
Route::post('/addcart', 'Ecommerce\CartController@addToCart')->name('front.cart');
Route::get('/lcart', 'Ecommerce\CartController@getListcart')->name('front.get_listcart');
Route::get('/c', 'Ecommerce\CartController@listCart')->name('front.list_cart');
Route::post('/cart/update/{produk_id}', 'Ecommerce\CartController@decreaseqty')->name('front.decreaseqty');
Route::post('/c/qty', 'Ecommerce\CartController@updateqty');
Route::post('/c/update', 'Ecommerce\CartController@updateCart')->name('front.update_cart');
Route::post('/c/remove', 'Ecommerce\CartController@removeCart')->name('front.remove_cart');

Auth::routes(['verify' => true]);
Route::group(['middleware' => 'auth'], function() {
	// Route::post('/produk/cart', 'Ecommerce\CartController@addToCart');
	Route::get('/checkout', 'Ecommerce\CartController@checkout')->name('front.checkout');
	Route::post('/checkout/origin={city_origin}&destination={city_destination}&weight={weight}&courier={courier}','Ecommerce\CartController@getOngkir');
	// Route::get('/api/city', 'Ecommerce\CartController@getCity');
	// Route::get('/api/district', 'Ecommerce\CartController@getDistrict');
	Route::post('/checkout', 'Ecommerce\CartController@processCheckout')->name('front.store_checkout');
	Route::get('/checkout/{invoice}', 'Ecommerce\CartController@checkoutFinish')->name('front.finish_checkout');
});

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::group(['prefix' => 'member', 'namespace' => 'Ecommerce'], function() {
	Route::group(['middleware' => 'auth'], function() {
		Route::get('dashboard', 'DashBoardController@index')->name('pelanggan.dashboard');
		Route::get('orders', 'OrderController@index')->name('customer.orders');
		Route::get('orders/{invoice}', 'OrderController@view')->name('customer.view_order');
		Route::get('orders/pdf/{invoice}', 'OrderController@pdf')->name('customer.order_pdf');
		Route::post('orders/accept', 'OrderController@acceptOrder')->name('customer.order_accept');
		Route::get('orders/return/{invoice}', 'OrderController@returnForm')->name('customer.order_return');
		Route::put('orders/return/{invoice}', 'OrderController@processReturn')->name('customer.return');
		Route::post('orders/return/accept', 'OrderController@acceptReturn')->name('customer.return_accept');
		Route::get('payment/{invoice}', 'OrderController@paymentForm')->name('customer.paymentForm');
		Route::post('payment', 'OrderController@storePayment')->name('customer.savePayment');
		Route::get('setting', 'FrontController@customerSettingForm')->name('customer.settingForm');
		Route::post('setting', 'FrontController@customerUpdateProfile')->name('customer.setting');
		// Route::get('setting/email/verifikasi', 'VerifikasiController@verifikasiEmail')->name('customer.verifikasiEmail');
	});
});

Route::group(['prefix' => 'admin'], function() {
	Route::group(['middleware' => ['auth','cekadmin:1','verified']], function() {
	    Route::get('/', 'KontenController@index');
	    Route::resource('user','UserController');
		Route::resource('kategori','CategoryController');
		Route::resource('produk','ProductController');
		Route::resource('kurir','CourierController');
		Route::resource('provinsi','ProvinceController');
		Route::resource('kota','CityController');
		Route::resource('kecamatan','DistrictController');
		// Route::resource('order','OrderController');
		// Route::resource('orderdetail','OrderDetailController');
		Route::group(['prefix' => 'order'], function() {
		    Route::get('/', 'OrderController@index')->name('orders.index');
		    Route::delete('/{id}', 'OrderController@destroy')->name('orders.destroy');
		    Route::get('/{invoice}', 'OrderController@view')->name('orders.view');
		    Route::get('/payment/{invoice}', 'OrderController@acceptPayment')->name('orders.approve_payment');
		    Route::post('/shipping', 'OrderController@shippingOrder')->name('orders.shipping');
		    Route::get('/return/{invoice}', 'OrderController@return')->name('orders.return');
			Route::post('/return', 'OrderController@approveReturn')->name('orders.approve_return');
			Route::post('/return/shipping', 'OrderController@shippingReturn')->name('orders.shipping_return');
		});
		Route::group(['prefix' => 'reports'], function() {
		    Route::get('/order', 'ReportController@orderReport')->name('report.order');
		    Route::get('/order/pdf/{daterange}', 'ReportController@orderReportPdf')->name('report.order_pdf');
		    Route::get('/return', 'ReportController@returnReport')->name('report.return');
			Route::get('/return/pdf/{daterange}', 'ReportController@returnReportPdf')->name('report.return_pdf');
		});
	});
});