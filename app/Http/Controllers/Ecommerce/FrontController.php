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
    private function getCarts()
    {
        $carts = json_decode(request()->cookie('mbs-carts'), true);
        $carts = $carts != '' ? $carts:[];
        return $carts;
    }

    public function index(Request $request)
    {
        $categories = Category::orderBy('nama', 'ASC')->get();
        $products = Product::paginate(12);

        if (request()->cari != '') {
            $products = Product::where('nama','LIKE','%'.request()->cari.'%')->paginate(12);
        }

        $carts = $this->getCarts();
        $totalcart = collect($carts)->sum(function($q) {
            return $q['jumlah'];
            });

        // if ($request->ajax()) {
        //     $view = view('data',compact('products'))->render();
        //     return response()->json(['html'=>$view]);
        // }

        return view('welcome', compact('products', 'carts', 'categories', 'totalcart'));
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

        $carts = $this->getCarts();
        $totalcart = collect($carts)->sum(function($q) {
            return $q['jumlah'];
            });
        
        return view('layouts.kategori.kategori', compact('products', 'carts', 'categories', 'totalcart'));
    }

    public function getPopover()
    {
        $carts = $this->getCarts();
        $totalcart = collect($carts)->sum(function($q) {
            return $q['jumlah'];
            });
        $output = '';
        if ($totalcart > 0) {
            foreach ($carts as $row){
                $output .= '    <div>
                        <div class="media">
                            <div class="d-flex">
                                <img width="60px" height="60px" class="mr-2" src="/storage/products/' .$row['gambar_produk'].'">
                            </div>
                            <div class="media-body">
                                <p>'.$row['produk_nama'].'</p>
                                <label style="color:#17a2b8">'.formatRupiah($row['harga_produk']).'</label>
                                <label> | '. $row['jumlah'] .' item</label>
                            </div>
                        </div>
                    </div>
                ';
            }
        }else{
            $output = "<center><h5>Tidak ada belanjaan</h5></center>";
        }

        $data = array(
           'cart_data'  => $output
        );

        return response()->json($data);
    }

    public function show($slug)
    {
        $categories = Category::orderBy('nama', 'ASC')->get();
        $couriers = Courier::pluck('title', 'code');
        $provinces = Province::pluck('title', 'id');
        $products = Product::where('slug', $slug)->first();

        $carts = $this->getCarts();
        $totalcart = collect($carts)->sum(function($q) {
            return $q['jumlah'];
            });

        return view('layouts.produk.produk', compact(['products', 'carts', 'categories', 'couriers', 'provinces', 'totalcart']));
    }

    public function getCity()
    {
        //QUERY UNTUK MENGAMBIL DATA KOTA / KABUPATEN BERDASARKAN PROVINCE_ID
        $cities = City::where('province_id', request()->province_id)->get();
        //KEMBALIKAN DATANYA DALAM BENTUK JSON
        return response()->json(['status' => 'success', 'data' => $cities]);
    }

    public function getCourier()
    {
        $courier = Courier::orderBy('title', 'ASC')->get();
        return response()->json($courier);
    }

    public function getOngkir($origin, $destination, $weight, $courier)
    {
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
        //     CURLOPT_POSTFIELDS => "origin=196&destination=$destination&weight=1000&courier=$courier",
        //     CURLOPT_HTTPHEADER => array(
        //         "content-type: application/x-www-form-urlencoded",
        //         "key: c303b661422c4c17520e27d56767a46e"
        //     ),
        // ));
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);
        // if ($err) {
        // echo "cURL Error #:" . $err;
        // } else {
        //     $response=json_decode($response,true);
        //     $data_ongkir = $response['rajaongkir']['results'];
        //     return json_encode($data_ongkir);
        // }
        $costs = RajaOngkir::ongkosKirim([
            'origin'        => 196,// ID kota/kabupaten asal
            'destination'   => $destination,// ID kota/kabupaten tujuan
            'weight'        => $weight,//$request->weight,// berat barang dalam gram
            'courier'       => $courier,// kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        return json_encode($costs);
    }

    // public function submit(Request $request, $slug)
    // {
    //     $products = Product::where('slug', $slug)->first();

    //     $costs = RajaOngkir::ongkosKirim([
    //         'origin'        => 196,// ID kota/kabupaten asal
    //         'destination'   => $request->city_destination,// ID kota/kabupaten tujuan
    //         'weight'        => 10000,//$request->weight,// berat barang dalam gram
    //         'courier'       => $request->courier,// kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
    //     ])->get();

    //     // $couriers = $costs[0]['costs'][0];
    //     $couriers = $costs[0];

    //     // return $couriers;
    //     // dd($couriers);

    //     // return view('test', compact('couriers'));
    //     // return json_encode($couriers);
    //     return $couriers;
    //     // return view('layouts.produk.test', compact(['products', 'couriers']));
    // }

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
