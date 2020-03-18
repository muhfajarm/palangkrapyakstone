@extends('admin.dashboard')

@section('title', 'Daftar Produk')

@section('header')
	<h1>Daftar Produk</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{ url('/admin') }}">
				<i class="fa fa-dashboard"></i>Admin
			</a>
		</li>
	    <li class="active">Produk</li>
	</ol>
@stop

@section ('content')
<main>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Semua Produk</h3>
			<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#ModalTambahProduk">
		+ Tambah Produk Baru
	</button>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="tabellte">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Nama Produk</th>
							<th class="text-center">Keterangan</th>
							<th class="text-center">Deskripsi</th>
							<th class="text-center">Stok</th>
							<th class="text-center">Berat</th>
							<th class="text-center">Dibeli</th>
				            <th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($products as $product)
						<tr>
							<td>
								<img class="float-left" src="{{ asset('storage/products/' . $product->image) }}" height="170px" width="170px" alt="{{ $product->nama }}">
							</td>
							<td>{{ $product->nama }}</td>
							<td>
								<label class="mt-2 ml-2">
									Kategori : <span class="badge badge-light">{{ $product->category->nama }}</span>
								</label>
								<br>
								<label class="mt-2 ml-2">
									Harga Beli : <span class="badge badge-warning">{{ formatRupiah($product->harga_beli) }}</span>
								</label>
								<br>
								<label class="mt-2 ml-2">
									Harga Jual 1 : <span class="badge badge-secondary">{{ formatRupiah($product->harga_jual_1) }}</span>
								</label>
								<br>
								<label class="mt-2 ml-2">
									Harga Jual 2 : <span class="badge badge-secondary">{{ formatRupiah($product->harga_jual_2) }}</span>
								</label>
								<br>
								<label class="mt-2 ml-2">
									Harga Jual 3 : <span class="badge badge-secondary">{{ formatRupiah($product->harga_jual_3) }}</span>
								</label>

							</td>
							<td>{{ $product->deskripsi }}</td>
							<td><center>{!! $product->status_label !!}<br>{{ $product->stok }}</center></td>
							<td>{{ $product->berat }}Kg</td>
							<td>{{ $product->dibeli }}</td>
							<td><center>
								<button type="button" class="btn btn-xs btn-success glyphicon glyphicon-pencil" data-input_id="{{ $product->id }}" data-btn_nama="{{ $product->nama }}" data-btn_id_kategori="{{ $product->category_id }}" data-btn_slug="{{ $product->slug }}" data-btn_deskripsi="{{ $product->deskripsi }}" data-btn_harga_beli="{{ $product->harga_beli }}"
								data-btn_harga_jual_1="{{ $product->harga_jual_1 }}"
								data-btn_harga_jual_2="{{ $product->harga_jual_2 }}"
								data-btn_harga_jual_3="{{ $product->harga_jual_3 }}" data-btn_stok="{{ $product->stok }}" data-btn_berat="{{ $product->berat }}" data-btn_gambar="{{ $product->image }}" data-btn_dibeli="{{ $product->dibeli }}" data-toggle="modal" data-target="#ModalEditProduk"></button>

								<br><br>

								<button type="button" class="btn btn-xs btn-danger glyphicon glyphicon-trash" data-input_id="{{ $product->id}}" data-toggle="modal" data-target="#ModalHapusProduk"></button></center>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#ModalTambahProduk">
		+ Tambah Produk Baru
	</button>

	{{-- Modal Tambah --}}
	<div class="modal fade" id="ModalTambahProduk" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="LabelJudul">Tambah Produk Baru</h4>
				</div>
				<form action="{{ route('produk.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="modal-body">
						@include('admin.pages.produk.produkform')
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Tutup</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- Modal Edit --}}
	<div class="modal fade" id="ModalEditProduk" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="LabelJudul">Edit Produk</h4>
				</div>
				<form action="{{ route('produk.update','edit') }}" method="post" enctype="multipart/form-data">
					{{method_field('patch')}}
					@csrf
					<div class="modal-body">
						<input type="hidden" name="id" id="id" value="">
						@include('admin.pages.produk.produkform')
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
	<div class="modal modal-danger fade" id="ModalHapusProduk" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center" id="LabelJudul">Konfirmasi Hapus Produk</h4>
				</div>
				<form action="{{ route('produk.destroy','hapus') }}" method="post">
					@method('DELETE')
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
</main>
@endsection