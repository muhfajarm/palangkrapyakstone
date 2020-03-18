<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Courier;

class CourierController extends Controller
{
    public function index()
    {
        $couriers = Courier::all();

        return view('admin.pages.kurir.kurir', compact('couriers'));
    }

    public function store(Request $request)
    {
        $couriers = Courier::create($request->all());

        $couriers->save();

        return back();
    }

    public function update(Request $request, $id)
    {
        $couriers = Courier::findOrFail($request->id);

        $couriers->update($request->all());

        return back();
    }

    public function destroy(Request $request)
    {
        $couriers = Courier::findOrFail($request->id);

        $couriers->delete();

        return back();
    }
}
