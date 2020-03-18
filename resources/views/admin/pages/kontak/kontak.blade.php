@extends('admin.dashboard')

@section('title', 'Kontak')

@section('header')
	<h1>Kontak</h1>
@stop

@section ('content')
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Semua Kontak</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover"  id="tabellte">
					<thead>
						<tr>
							<th>Nama</th>
							<th>Email</th>
							<th>Subjek</th>
							<th>Pesan</th>
							<th>Tanggal</th>
				            <th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($kontaks as $ktk)
						<tr>
							<td>{{ $ktk->nama }}</td>
							<td>{{ $ktk->email }}</td>
							<td>{{ $ktk->subjek }}</td>
							<td>{{ $ktk->pesan }}</td>
							<td>{{ $ktk->tanggal }}</td>
							<td>
								<button type="button" class="btn btn-xs btn-success glyphicon glyphicon-pencil" data-input_id_kontak="{{ $ktk->id_kontak }}" data-btn_nama="{{ $ktk->nama }}" data-btn_email="{{ $ktk->email }}" data-btn_subjek="{{ $ktk->subjek }}" data-btn_pesan="{{ $ktk->pesan }}"  data-btn_tgl="{{ $ktk->tanggal }}"  data-toggle="modal" data-target="#ModalEditKontak"></button>

								|

								<button type="button" class="btn btn-xs btn-danger glyphicon glyphicon-trash" data-input_id_kontak="{{ $ktk->id_kontak}}" data-toggle="modal" data-target="#ModalHapusKontak"></button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#ModalTambahKontak">
		+ Tambah Kontak Baru
	</button>

	{{-- Modal Tambah --}}
	<div class="modal fade" id="ModalTambahKontak" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="LabelJudul">Tambah Kontak Baru</h4>
				</div>
				<form action="{{ route('kontak.store') }}" method="post">
					{{ csrf_field() }}
					<div class="modal-body">
						@include('admin.pages.kontak.kontakform')
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
	<div class="modal fade" id="ModalEditKontak" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="LabelJudul">Edit Kontak</h4>
				</div>
				<form action="{{ route('kontak.update','edit') }}" method="post">
					{{method_field('patch')}}
					{{ csrf_field() }}
					<div class="modal-body">
						<input type="hidden" name="id_kontak" id="id_kontak" value="">
						@include('admin.pages.kontak.kontakform')
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
	<div class="modal modal-danger fade" id="ModalHapusKontak" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center" id="LabelJudul">Konfirmasi Hapus Kontak</h4>
				</div>
				<form action="{{ route('kontak.destroy','hapus') }}" method="post">
					{{method_field('delete')}}
					{{ csrf_field() }}
					<div class="modal-body">
						<p class="text-center">
							Yakin mau hapus ini?
						</p>
						<input type="hidden" name="id_kontak" id="id_kontak" value="">
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