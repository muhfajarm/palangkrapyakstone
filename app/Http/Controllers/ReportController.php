<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

use App\Http\Requests;
use App\Order;

class ReportController extends Controller
{
    public function orderReport()
    {
        //INISIASI 30 HARI RANGE SAAT INI JIKA HALAMAN PERTAMA KALI DI-LOAD
        //KITA GUNAKAN STARTOFMONTH UNTUK MENGAMBIL TANGGAL 1
        $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
        //DAN ENDOFMONTH UNTUK MENGAMBIL TANGGAL TERAKHIR DIBULAN YANG BERLAKU SAAT INI
        $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

        //JIKA USER MELAKUKAN FILTER MANUAL, MAKA PARAMETER DATE AKAN TERISI
        if (request()->date != '') {
            //MAKA FORMATTING TANGGALNYA BERDASARKAN FILTER USER
            $date = explode(' - ' ,request()->date);
            $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
            $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
        }

        //BUAT QUERY KE DB MENGGUNAKAN WHEREBETWEEN DARI TANGGAL FILTER
        $orders = Order::with(['pelanggan.city.province'])
                ->whereBetween('created_at', [$start, $end])
                ->where('status', '=', 'success')
                ->orWhere('status', 'proses')
                ->orWhere('status', 'dikirim')
                ->orWhere('status', 'diterima')
                ->get();
        // return $orders;
        //KEMUDIAN LOAD VIEW
        return view('admin.pages.report.order', compact('orders'));
    }

    public function orderReportPdf($daterange)
    {
        $date = explode('+', $daterange); //EXPLODE TANGGALNYA UNTUK MEMISAHKAN START & END
        //DEFINISIKAN VARIABLENYA DENGAN FORMAT TIMESTAMPS
        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';

        //KEMUDIAN BUAT QUERY BERDASARKAN RANGE CREATED_AT YANG TELAH DITETAPKAN RANGENYA DARI $START KE $END
        $orders = Order::with(['pelanggan.city.province'])
                ->whereBetween('created_at', [$start, $end])
                ->where('status', '=', 'success')
                ->orWhere('status', 'proses')
                ->orWhere('status', 'dikirim')
                ->orWhere('status', 'diterima')
                ->get();
        //LOAD VIEW UNTUK PDFNYA DENGAN MENGIRIMKAN DATA DARI HASIL QUERY
        $pdf = PDF::loadView('admin.pages.report.order_pdf', compact('orders', 'date'));
        //GENERATE PDF-NYA
        return $pdf->stream();
    }

    public function returnReport()
	{
	    $start = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
	    $end = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');

	    if (request()->date != '') {
	        $date = explode(' - ' ,request()->date);
	        $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
	        $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';
	    }

	    $orders = Order::with(['pelanggan.city.province'])
                ->has('return')
                ->whereBetween('created_at', [$start, $end])
                // ->where('status', '=', 1)
                // ->orWhere('status', 4)
                // ->orWhere('status', 5)
                ->get();
	    return view('admin.pages.report.return', compact('orders'));
	}

	public function returnReportPdf($daterange)
	{
	    $date = explode('+', $daterange);
	    $start = Carbon::parse($date[0])->format('Y-m-d') . ' 00:00:01';
	    $end = Carbon::parse($date[1])->format('Y-m-d') . ' 23:59:59';

	    $orders = Order::with(['pelanggan.city.province'])
                ->has('return')
                ->whereBetween('created_at', [$start, $end])
                ->get();
	    $pdf = PDF::loadView('admin.pages.report.return_pdf', compact('orders', 'date'));
	    return $pdf->stream();
	}
}
