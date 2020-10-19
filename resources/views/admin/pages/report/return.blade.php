@extends('admin.dashboard')

@section('title', 'Laporan Return')

@section('header')
	<h1>Laporan Return</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{ url('/admin') }}">
				<i class="fa fa-dashboard"></i>Admin
			</a>
		</li>
	    <li class="active">Laporan Return</li>
	</ol>
@stop

@section ('content')
<main>
	<div class="box">
		<div class="row">
			<div class="col-md-7">
				<div class="box-header">
					<h3 class="box-title">Laporan Return</h3>
				</div>
			</div>
			<div class="col-md-5 float-right">
				<form action="{{ route('report.return') }}" class="mt-2" method="get" style="float: right;">
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
                <!-- TAMPILKAN DATA YANG BERHASIL DIFILTER -->
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
                            <td><a href="{{ route('orders.view', $row->invoice) }}"><strong>{{ $row->invoice }}</strong></td>
                            <td>
                                <strong>{{ $row->pelanggan_nama }}</strong><br>
                                <label><strong>Telp:</strong> {{ $row->pelanggan_no_hp }}</label><br>
                                <label><strong>Alamat:</strong> {{ $row->pelanggan_alamat }}, {{  $row->pelanggan->city->title}}, {{ $row->pelanggan->city->province->title }}</label>
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
        $(document).ready(function() {
            let start = moment().startOf('month')
            let end = moment().endOf('month')

            $('#exportpdf').attr('href', '/admin/reports/return/pdf/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'))

            $('#created_at').daterangepicker({
                startDate: start,
                endDate: end
            }, function(first, last) {
                $('#exportpdf').attr('href', '/admin/reports/return/pdf/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'))
            })
        })
    </script>
@endsection()