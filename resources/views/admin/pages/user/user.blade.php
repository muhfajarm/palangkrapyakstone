@extends('admin.dashboard')

@section('title', 'Daftar User')

@section('header')
	<h1>Daftar User</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{ url('/admin') }}">
				<i class="fa fa-dashboard"></i>Admin
			</a>
		</li>
	    <li class="active">User</li>
	</ol>
@stop

@section ('content')
<main>
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Semua User</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="tabellte">
					<thead>
						<tr>
							<th>Nama User</th>
							<th>Kontak</th>
							<th>Alamat</th>
							<th>Admin</th>
				            <th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
						<tr>
							<td>{{ $user->nama }}</td>
							<td>
								<label>Email : <span class="badge badge-info">{{ $user->email }}</span></label><br>
								<label>No HP : <span class="badge badge-primary">{{ $user->no_hp }}</span></label>
							</td>
							<td>{{ $user->alamat }}<br>
								{{ $user->city ? $user->city->title:'(Kota Belum Diisi)' }}, {{ $user->city ? $user->city->province->title:'(Provinsi Belum Diisi)' }}
							</td>
							<td><center>{!! $user->status_label !!}</center></td>
							<td>
								<a href="{{ route('user.edit', $user->id) }}" class="btn btn-xs btn-success glyphicon glyphicon-eye-open"></a> 
								|
								<button type="button" class="btn btn-xs btn-danger glyphicon glyphicon-trash" data-input_id="{{ $user->id}}" data-toggle="modal" data-target="#ModalHapusUser"></button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#ModalTambahUser">
		+ Tambah User Baru
	</button>

	{{-- Modal Tambah --}}
	<div class="modal fade" id="ModalTambahUser" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="LabelJudul">Tambah User Baru</h4>
				</div>
				<form action="{{ route('user.store') }}" method="post">
					@csrf
					<div class="modal-body">
						@include('admin.pages.user.userform')
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	{{-- Modal Hapus --}}
	<div class="modal modal-danger fade" id="ModalHapusUser" tabindex="-1" role="dialog" aria-labelledby="LabelJudul" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center" id="LabelJudul">Konfirmasi Hapus User</h4>
				</div>
				<form action="{{ route('user.destroy','hapus') }}" method="post">
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
</main>
@endsection

@section('js')
    <script>
        $('#province_id').on('change', function() {
            $.ajax({
                url: "{{ url('/api/city') }}",
                type: "GET",
                data: { province_id: $(this).val() },
                success: function(html){
                    $('#city_id').empty()
                    $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>')
                    $.each(html.data, function(key, item) {
                        $('#city_id').append('<option value="'+item.id+'">'+item.title+'</option>')
                    })
                }
            });
        })
    </script>
@endsection