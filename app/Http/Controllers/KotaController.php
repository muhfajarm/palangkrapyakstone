<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kota;

class KotaController extends Controller
{
    public function index()
    {
        $kotas = Kota::All();

        return view('admin.pages.wilayah.kota', compact('kotas'));
    }
}
