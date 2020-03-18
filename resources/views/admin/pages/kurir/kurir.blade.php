@extends('admin.dashboard')

@section('title', 'Kurir')

@section('header')
	<h1>Kurir</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{ url('/admin') }}">
				<i class="fa fa-dashboard"></i>Admin
			</a>
		</li>
	    <li class="active">Kurir</li>
	</ol>
@stop

@section ('content')
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Semua Kurir</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="tabellte">
					<thead>
						<tr>
							<th>Nama Kurir</th>
							<th>Kode</th>
				            <th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($couriers as $courier)
						<tr>
							<td>{{ $courier->title }}</td>
							<td>{{ $courier->code }}</td>
							<td>
								<button type="button" class="btn btn-xs btn-success glyphicon glyphicon-pencil" data-btn_nama="{{ $courier->title }}" data-btn_kode="{{ $courier->code }}" data-input_id="{{ $courier->id}}" data-toggle="modal" data-target="#ModalEditKurir"></button>

								|

								<button type="button" class="btn btn-xs btn-danger glyphicon glyphicon-trash" data-input_id="{{ $courier->id}}" data-toggle="modal" data-target="#ModalHapusKurir"></button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#ModalTambahKurir">
		+ Tambah Kurir Baru
	</button>

	{{-- Modal Tambah --}}
	<div class="modal fade" id="ModalTambahKurir" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="LabelJudul">Tambah Kurir Baru</h4>
				</div>
				<form action="{{ route('kurir.store') }}" method="post">
					@csrf
					<div class="modal-body">
						@include('admin.pages.kurir.kurirform')
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
	<div class="modal fade" id="ModalEditKurir" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="LabelJudul">Edit Kurir</h4>
				</div>
				<form action="{{ route('kurir.update','edit') }}" method="post">
					{{method_field('patch')}}
					@csrf
					<div class="modal-body">
						<input type="hidden" name="id" id="id" value="">
						@include('admin.pages.kurir.kurirform')
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
	<div class="modal modal-danger fade" id="ModalHapusKurir" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center" id="LabelJudul">Konfirmasi Hapus Kurir</h4>
				</div>
				<form action="{{ route('kurir.destroy','hapus') }}" method="post">
					{{method_field('delete')}}
					@csrf
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