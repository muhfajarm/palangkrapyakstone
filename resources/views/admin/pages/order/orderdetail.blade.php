@extends('admin.dashboard')

@section('title', 'Order Detail')

@section('header')
	<h1>Order Detail</h1>
@stop

@section ('content')
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Semua Order Detail</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="tabellte">
					<thead>
						<tr>
							<th>Nama Pelanggan</th>
							<th>Produk</th>
							<th>Jumlah</th>
				            <th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($orderdetails as $orderdetail)
						<tr>
							<td>{{ $orderdetail->order['nama_pelanggan'] }}</td>
							<td>{{ $orderdetail->product['nama'] }}</td>
							<td>{{ $orderdetail->jumlah }}</td>
							<td>
								<button type="button" class="btn btn-xs btn-success glyphicon glyphicon-pencil" data-btn_order_id="{{ $orderdetail->order_id }}" data-btn_id_produk="{{ $orderdetail->produk_id }}" data-btn_jumlah="{{ $orderdetail->jumlah }}" data-input_id="{{ $orderdetail->id}}" data-toggle="modal" data-target="#ModalEditOrderDetail"></button>

								|

								<button type="button" class="btn btn-xs btn-danger glyphicon glyphicon-trash" data-input_id="{{ $orderdetail->id}}" data-toggle="modal" data-target="#ModalHapusOrderDetail"></button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#ModalTambahOrderDetail">
		+ Tambah Order Detail Baru
	</button>

	{{-- Modal Tambah --}}
	<div class="modal fade" id="ModalTambahOrderDetail" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="LabelJudul">Tambah Order Detail Baru</h4>
				</div>
				<form action="{{ route('orderdetail.store') }}" method="post">
					{{ csrf_field() }}
					<div class="modal-body">
						@include('admin.pages.order.orderdetailform')
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- Modal Edit --}}
	<div class="modal fade" id="ModalEditOrderDetail" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="LabelJudul">Edit Order Detail</h4>
				</div>
				<form action="{{ route('orderdetail.update','edit') }}" method="post">
					{{method_field('patch')}}
					{{ csrf_field() }}
					<div class="modal-body">
						<input type="hidden" name="id" id="id" value="">
						@include('admin.pages.order.orderdetailform')
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- Modal Hapus --}}
	<div class="modal modal-danger fade" id="ModalHapusOrderDetail" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center" id="LabelJudul">Konfirmasi Hapus Order Detail</h4>
				</div>
				<form action="{{ route('orderdetail.destroy','hapus') }}" method="post">
					{{method_field('delete')}}
					{{ csrf_field() }}
					<div class="modal-body">
						<p class="text-center">
							Yakin mau hapus ini?
						</p>
						<input type="hidden" name="id" id="id" value="">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success pull-left" data-dismiss="modal">Tidak</button>
						<button type="submit" class="btn btn-warning">Ya, Hapus</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection