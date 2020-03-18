@extends('admin.dashboard')

@section('title', 'Laporan Order')

@section('header')
	<h1>Laporan Order</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{ url('/admin') }}">
				<i class="fa fa-dashboard"></i>Admin
			</a>
		</li>
	    <li class="active">Laporan Order</li>
	</ol>
@stop

@section ('content')
<main>
	<div class="box">
		<div class="row">
			<div class="col-md-7">
				<div class="box-header">
					<h3 class="box-title">Laporan Order</h3>
				</div>
			</div>
			<div class="col-md-5 float-right">
				<form action="{{ route('report.order') }}" class="mt-2" method="get" style="float: right;">
	                <div class="form-group mb-3 col-md-6 float-right">
	                    <input type="text" id="created_at" name="date" class="form-control">
	                </div>
                    <button class="btn btn-secondary" type="submit">Filter</button>
                    <a target="_blank" class="btn btn-primary ml-2" id="exportpdf">Export PDF</a>
	            </form>
			</div>
		</div>
		
		<div class="box-body">
			@if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>InvoiceID</th>
                            <th>Pelanggan</th>
                            <th>Subtotal</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $row)
                        <tr>
                            <td><strong>{{ $row->invoice }}</strong></td>
                            <td>
                                <strong>{{ $row->pelanggan_nama }}</strong><br>
                                <label><strong>Telp:</strong> {{ $row->pelanggan_no_hp }}</label><br>
                                <label><strong>Alamat:</strong> {{ $row->pelanggan_alamat }} - {{  $row->pelanggan->city->nama}}, {{ $row->pelanggan->city->province->nama }}</label>
                            </td>
                            <td>{{ formatRupiah($row->subtotal) }}</td>
                            <td>{{ $row->created_at->format('d-m-Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        //KETIKA PERTAMA KALI DI-LOAD MAKA TANGGAL NYA DI-SET TANGGAL SAAT PERTAMA DAN TERAKHIR DARI BULAN SAAT INI
        $(document).ready(function() {
            let start = moment().startOf('month')
            let end = moment().endOf('month')

            //KEMUDIAN TOMBOL EXPORT PDF DI-SET URLNYA BERDASARKAN TGL TERSEBUT
            $('#exportpdf').attr('href', '/admin/reports/order/pdf/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

            //INISIASI DATERANGEPICKER
            $('#created_at').daterangepicker({
                startDate: start,
                endDate: end
            }, function(first, last) {
                //JIKA USER MENGUBAH VALUE, MANIPULASI LINK DARI EXPORT PDF
                $('#exportpdf').attr('href', '/admin/reports/order/pdf/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
            })
        })
    </script>
@endsection()