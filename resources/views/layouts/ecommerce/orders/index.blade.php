@extends('layouts.dashboard')

@section('title')
    List Pesanan
@endsection

@section ('content')
	<section class="login_box_area p_120">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					@include('layouts.ecommerce.module.sidebar')
				</div>
				<div class="col-md-9">
                    <div class="row">
						<div class="col-md-12">
							<div class="card">
				                <div class="card-header">
				                    <h4 class="card-title">List Pesanan</h4>
				                </div>
								<div class="card-body">
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
                      								<th>Invoice</th>
                      								<th>Penerima</th>
				                                	<th>Total</th>
				                                	<th>Status</th>
				                                	<th>Tanggal</th>
				                                	<th>Aksi</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            	@forelse ($orders as $row) 
					                            <tr>
					                                <td>
					                                	<strong>{{ $row->invoice }}</strong><br>
													    @if ($row->return_count == 1)
													    <small>Return: {!! $row->return->status_label !!}</small>
													    @endif
					                                </td>
					                                <td>
					                                	{{ $row->pelanggan_nama }}<br>
					                                	<span class="badge badge-secondary">{{ $row->pelanggan_no_hp }}</span>
					                                </td>
					                                <td>{{ formatRupiah($row->subtotal) }}</td>
					                               	<td>{!! $row->status_label !!}</td>
					                                <td>{{ $row->created_at }}</td>
					                                <td>
					                                	@if ($row->status != 5)
						                                	<a href="{{ route('customer.view_order', $row->invoice) }}" class="btn btn-primary btn-sm">Detail</a>
						                                @else
						                                	<span class="badge badge-danger">Orderan dibatalkan oleh sistem!</span>
					                                	@endif
                            	<form action="{{ route('customer.order_accept') }}" 
								    class="form-inline"
								    onsubmit="return confirm('Kamu Yakin?');" method="post">
								    @csrf
								    <input type="hidden" name="order_id" value="{{ $row->id }}"><br>

								    @if ($row->status == 3 && $row->return_count == 0)
								        <button class="btn btn-success btn-sm">Terima</button>
								        <!-- TOMBOL UNTUK MENGARAH KE HALAMAN RETURN -->
								        <a href="{{ route('customer.order_return', $row->invoice) }}" class="btn btn-danger btn-sm mt-1">Return</a>
								    @endif
								</form>
					                                </td>
					                            </tr>
					                            @empty
					                            <tr>
					                            	<td colspan="7" class="text-center">Tidak ada pesanan</td>
					                            </tr>
					                            @endforelse
					                        </tbody>
					                    </table>
					                </div>
					                <div class="float-right">
					                	{!! $orders->links() !!}
					                </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection