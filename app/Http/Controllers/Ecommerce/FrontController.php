<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;

use App\Product;
use App\Category;
use App\Province;
use App\Courier;
use App\City;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('nama', 'ASC')->get();
        $products = Product::paginate(12);

        if (request()->cari != '') {
            $products = Product::where('nama','LIKE','%'.request()->cari.'%')->paginate(12);
        }

        // if ($request->ajax()) {
        //     $view = view('data',compact('products'))->render();
        //     return response()->json(['html'=>$view]);
        // }

        return view('welcome', compact('products', 'categories'));
    }

    public function categoryProduct($slug)
    {
        $categories = Category::orderBy('nama', 'ASC')->get();
        $products = Category::where('slug', $slug)->first()->produk()->paginate(12);

        if (request('urut') == 'desc') {
            $products = Category::where('slug', $slug)->first()->produk()->orderBy('nama', 'desc')->paginate(12);
        } else if (request('urut') == 'asc') {
            $products = Category::where('slug', $slug)->first()->produk()->orderBy('nama', 'asc')->paginate(12);
        }
        
        return view('layouts.kategori.kategori', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $categories = Category::orderBy('nama', 'ASC')->get();
        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::pluck('title', 'id');
        $products = Product::where('slug', $slug)->first();

        return view('layouts.produk.produk', compact(['products', 'categories', 'couriers', 'provinces']));
    }

    public function getCity()
    {
        //QUERY UNTUK MENGAMBIL DATA KOTA / KABUPATEN BERDASARKAN PROVINCE_ID
        $city = City::where('province_id', request()->province_id)->get();
        //KEMBALIKAN DATANYA DALAM BENTUK JSON
        return respone()->json(['status' => 'success', 'data' => $cities]);
    }

    public function submit(Request $request, $slug)
    {
        $products = Product::where('slug', $slug)->first();

        $costs = RajaOngkir::ongkosKirim([
            'origin'        => 196,// ID kota/kabupaten asal
            'destination'   => $request->city_destination,// ID kota/kabupaten tujuan
            'weight'        => 10000,//$request->weight,// berat barang dalam gram
            'courier'       => $request->courier,// kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        // $couriers = $costs[0]['costs'][0];
        $couriers = $costs;

        // return $couriers;
        // dd($couriers);

        // return view('test', compact('couriers'));
        return json_encode($couriers);
        // return view('layouts.produk.test', compact(['products', 'couriers']));
    }

    public function customerSettingForm()
    {
        //MENGAMBIL DATA CUSTOMER YANG SEDANG LOGIN
        $customer = auth()->user()->load('city');
        //GET DATA PROPINSI UNTUK DITAMPILKAN PADA SELECT BOX
        $provinces = Province::orderBy('title', 'ASC')->get();
        //LOAD VIEW setting.blade.php DAN PASSING DATA CUSTOMER - PROVINCES
        // return $customer;
        return view('layouts.ecommerce.setting', compact(['customer'], 'provinces'));
    }

    public function customerUpdateProfile(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:100',
            'password' => 'nullable|string|min:8',
            'no_hp' => 'required|max:15',
            'alamat' => 'required|string',
            'city_id' => 'required|exists:cities,id'
        ]);

        //AMBIL DATA CUSTOMER YANG SEDANG LOGIN
        $user = auth()->user();
        //AMBIL DATA YANG DIKIRIM DARI FORM
        $data = $request->only('nama', 'no_hp', 'alamat', 'city_id');
        //ADAPUN PASSWORD KITA CEK DULU, JIKA TIDAK KOSONG
        if ($request->password != '') {
            //MAKA TAMBAHKAN KE DALAM ARRAY
            $data['password'] = Hash::make($request->password);
        }
        //TERUS UPDATE DATANYA
        $user->update($data);
        // return $data;
        return redirect()->back()->with(['success' => 'Profil berhasil diperbaharui']);
    }
}
