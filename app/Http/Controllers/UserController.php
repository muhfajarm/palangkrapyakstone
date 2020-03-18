<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Requests;
use DB;
use App\User;
use App\Province;
use App\City;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['city.province'])->get();
        $provinces = Province::orderBy('title', 'ASC')->get();

        return view('admin.pages.user.user', compact('users', 'provinces'));
    }

    public function getCity()
    {
        //QUERY UNTUK MENGAMBIL DATA KOTA / KABUPATEN BERDASARKAN PROVINCE_ID
        $cities = City::where('province_id', request()->province_id)->get();
        //KEMBALIKAN DATANYA DALAM BENTUK JSON
        return response()->json(['status' => 'success', 'data' => $cities]);
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
        // DB::table('users')
        //     ->insert([
        //         'admin' => $request->admin,
        //         'nama' => $request->nama,
        //         'email' => $request->email,
        //         'password' => Hash::make($request->password),
        //         'alamat' => $request->alamat,
        //         'no_hp' => $request->no_hp,
        //     ]);

        // return redirect('/admin/user');
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
        $users = User::with(['city.province'])->where('id', $id)->first();
        
        $provinces = Province::orderBy('title', 'ASC')->get();

        return view('admin.pages.user.view', compact('users', 'provinces'));
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
            'nama' => 'required|string|max:100',
            'email' => 'required|string',
            'password' => 'nullable|string|min:8',
            'no_hp' => 'required|max:15',
            'alamat' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'admin' => 'required'
        ]);

        $data = $request->only('nama', 'email', 'no_hp', 'alamat', 'city_id', 'admin');
        
        if ($request->password != '') {
            $data['password'] = Hash::make($request->password);
        }

        $users = User::findOrFail($request->id);

        $users->update($data);

        return redirect('/admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $users = User::findOrFail($request->id);

        $users->delete();

        return back();
    }
}
