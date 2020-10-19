<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;

use App\Http\Requests;
use App\Product;
use App\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = Product::All();
        $products = Product::with(['category'])->get();
        $categories = Category::All();

        // return $products;
        return view('admin.pages.produk.produk', compact('products', 'categories'));
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
        $this->validate($request, [
            'nama' => 'required|string|max:30',
            'category_id' => 'required',
            'deskripsi' => 'required|string',
            // 'harga_beli' => 'required|integer',
            // 'harga_jual_1' => 'required|integer',
            // 'harga_jual_2' => 'required|integer',
            'harga_jual_3' => 'required|integer',
            'stok' => 'required|integer',
            'berat' => 'required|numeric',
            'image' => 'image|mimes:png,jpeg,jpg',
            'dibeli' => 'required|integer'
        ]);

        if ($request->hasFile('image')) {
            
            $file = $request->file('image');

            $filename = Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();

            // $file->storeAs('storage/products', $filename);
            $file->move('storage/products', $filename);

            $product = Product::create([
                'nama' => $request->nama,
                'category_id' => $request->category_id,
                'slug' => $request->nama,
                'deskripsi' => $request->deskripsi,
                // 'harga_beli' => $request->harga_beli,
                // 'harga_jual_1' => $request->harga_jual_1,
                // 'harga_jual_2' => $request->harga_jual_2,
                'harga_jual_3' => $request->harga_jual_3,
                'stok' => $request->stok,
                'berat' => $request->berat,
                'gambar' => $filename,
                'dibeli' => $request->dibeli
            ]);

            return redirect(route('produk.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:30',
            'category_id' => 'required',
            'deskripsi' => 'required',
            // 'harga_beli' => 'required|integer',
            // 'harga_jual_1' => 'required|integer',
            // 'harga_jual_2' => 'required|integer',
            'harga_jual_3' => 'required|integer',
            'stok' => 'required|integer',
            'berat' => 'required|numeric',
            'image' => 'nullable|image|mimes:png,jpeg,jpg',
            'dibeli' => 'required|integer'
        ]);

        $products = Product::findOrFail($request->id);
        $filename = $products->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();

            // $file->storeAs('storage/products', $filename);
            $file->move('storage/products', $filename);

            File::delete(storage_path('app/storage/products' . $products->image));
        }

        $products->update([
            'nama' => $request->nama,
            'category_id' => $request->category_id,
            'slug' => $request->nama,
            'deskripsi' => $request->deskripsi,
            // 'harga_beli' => $request->harga_beli,
            // 'harga_jual_1' => $request->harga_jual_1,
            // 'harga_jual_2' => $request->harga_jual_2,
            'harga_jual_3' => $request->harga_jual_3,
            'stok' => 50,//$request->stok,
            'berat' => 1000,//$request->berat,
            'gambar' => $filename,
            'dibeli' => 0//$request->dibeli
        ]);
        return redirect(route('produk.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $products = Product::findOrFail($request->id);  

        File::delete('storage/products/' . $products->image);

        $hapus = $products->delete();

        return back();
    }
}
