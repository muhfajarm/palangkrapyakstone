@extends('admin.dashboard')

@section('title', 'Daftar Pesanan')

@section('header')
	<h1>Daftar Pesanan</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{ url('/admin') }}">
				<i class="fa fa-dashboard"></i>Admin
			</a>
		</li>
	    <li class="active">Orders</li>
	</ol>
@stop

@section ('content')
<main>
	
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Daftar Pesanan</h3>
		</div>
		<div class="box-body">
			@if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
			
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="tabellte">
					<thead>
						<tr>
							<th>Invoice</th>
							<th>Nama Pelanggan</th>
							<th>Total</th>
							<th>Tanggal</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@forelse($orders as $order)
						<tr>
							<td>
								<a href="{{ route('orders.view', $order->invoice) }}"><strong>{{ $order->invoice }}</strong></a>
							</td>
							<td>
								<strong>{{ $order->pelanggan_nama }}</strong><br>
								<label><strong>No HP:</strong> {{ $order->pelanggan_no_hp }}</label><br>
								<label><strong>Alamat:</strong> {{ $order->pelanggan_alamat }},</label>
								<label>{{  $order->pelanggan->city->title}}, {{ $order->pelanggan->city->province->title }}</label>
							</td>
							<td>{{ formatRupiah($order->subtotal) }}</td>
							<td>{{ $order->created_at->format('d-m-Y') }}</td>
							<td>
								{!! $order->status_label !!} <br>
							    @if ($order->return_count > 0)
							        <a href="{{ route('orders.return', $order->invoice) }}">Permintaan Return</a>
							    @endif
							</td>
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
@stop