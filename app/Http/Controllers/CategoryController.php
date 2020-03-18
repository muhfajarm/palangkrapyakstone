<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.pages.kategori.kategori', compact('categories'));
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
            'nama' => 'required|string|max:15'
        ]);

        $request->request->add(['slug' => $request->nama]);

        Category::create($request->except('_token'));

        return redirect(route('kategori.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // $categories = Category::All();

        // return view('layouts.kategori.kategori', compact('categories'));
        // // $categories = Category::All();
        // // $categoriess = Category::where('nama', $slug)->get();

        // // return view('layouts.kategori.kategori', compact('categories', 'categoriess'));
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
        // $categories = Category::findOrFail($request->id_kategori);

        // $categories->update($request->all());

        // return back();

        $this->validate($request, [
            'nama' => 'required|string|max:15' . $id
        ]);

        $category = Category::findOrFail($request->id);

        $category->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        return redirect(route('kategori.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $categories = Category::findOrFail($request->id);

        $categories->delete();

        return back();
    }
}
