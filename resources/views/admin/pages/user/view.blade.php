@extends('admin.dashboard')

@section('title', 'Detail User')

@section('header')
	<h1>Detail User</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{ url('/admin') }}">
				<i class="fa fa-dashboard"></i>Admin
			</a>
		</li>
		<li>
			<a href="{{ url('/admin/user') }}">
				<i></i>User
			</a>
		</li>
	    <li class="active">Detail User</li>
	</ol>
@stop

@section ('content')
<main>
	<div class="card">
	  <div class="card-body">
	    <h5 class="card-title">Special title treatment</h5>
	  	<form action="{{ route('user.update','edit') }}" method="post">
	  		{{method_field('patch')}}
	  		@csrf
	  		<input type="hidden" name="id" value="{{ $users->id }}">
	  		<div class="form-group">
			    <label>Nama</label>
			    <input type="text" name="nama" id="nama" class="form-control" required value="{{ $users->nama }}">
			    <p class="text-danger">{{ $errors->first('nama') }}</p>
			</div>
			<div class="form-group">
			    <label>Email</label>
				<input type="text" name="email" id="email" class="form-control" required value="{{ $users->email }}">
				<p class="text-danger">{{ $errors->first('email') }}</p>
			</div>
		    <div class="form-group">
			    <label>Password</label>
				<input type="password" name="password" id="password" class="form-control" placeholder="******">
				<p class="text-danger">{{ $errors->first('password') }}</p>
				<p>Biarkan kosong jika tidak ingin mengganti password</p>
			</div>
		    <div class="form-group">
			    <label>No Hp</label>
				<input type="text" name="no_hp" id="no_hp" class="form-control" required value="{{ $users->no_hp }}">
				<p class="text-danger">{{ $errors->first('no_hp') }}</p>
			</div>
		    <div class="form-group">
			    <label>Alamat</label>
				<input type="text" name="alamat" id="alamat" class="form-control" required value="{{ $users->alamat }}">
				<p class="text-danger">{{ $errors->first('alamat') }}</p>
			</div>
		    <div class="form-group">
			    <label>Provinsi</label>
				<select class="form-control select2 select2-hidden-accessible" name="province_id" id="province_id" data-placeholder="Pilih..." style="width: 100%" required>
                    <option value="">Pilih Propinsi</option>
                    @foreach ($provinces as $row)
                    <option value="{{ $row->id }}" {{ $users->city && $users->city->province_id == $row->id ? 'selected':'' }}>{{ $row->title }}</option>
                    @endforeach
                </select>
                <p class="text-danger">{{ $errors->first('province_id') }}</p>
			</div>
		    <div class="form-group">
			    <label>Kota</label>
				<select class="form-control select2 select2-hidden-accessible" name="city_id" id="city_id" data-placeholder="Pilih..." style="width: 100%" required>
                    <option value="">Pilih Kabupaten/Kota</option>
                </select>
                <p class="text-danger">{{ $errors->first('city_id') }}</p>
			</div>
		    <div class="form-group">
			    <label>Admin</label>
				<select name="admin" id="admin" required>
					<option value="0">Bukan</option>
					<option value="1">Admin</option>
				</select>
				<p class="text-danger">{{ $errors->first('admin') }}</p>
			</div>
		    <button class="btn btn-primary btn-sm">Simpan</button>
	  	</form>
	  </div>
	</div>
</main>
@endsection

@section('js')
    <script>
    	$('#province_id').on('change', function() {
            //MAKA AKAN MELAKUKAN REQUEST KE URL /API/CITY
            //DAN MENGIRIMKAN DATA PROVINCE_ID
            $.ajax({
                url: "{{ url('/api/city') }}",
                type: "GET",
                data: { province_id: $(this).val() },
                success: function(html){
                    //SETELAH DATA DITERIMA, SELEBOX DENGAN ID CITY_ID DI KOSONGKAN
                    $('#city_id').empty()
                    //KEMUDIAN APPEND DATA BARU YANG DIDAPATKAN DARI HASIL REQUEST VIA AJAX
                    //UNTUK MENAMPILKAN DATA KABUPATEN / KOTA
                    $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>')
                    $.each(html.data, function(key, item) {
                        $('#city_id').append('<option value="'+item.id+'">'+item.title+'</option>')
                    })
                }
            });
        })
    </script>
    <script>
        //JADI KETIKA HALAMAN DI-LOAD
        $(document).ready(function(){
            //MAKA KITA MEMANGGIL FUNGSI LOADCITY() DAN LOADDISTRICT()
            //AGAR SECARA OTOMATIS MENGISI SELECT BOX YANG TERSEDIA
            loadCity($('#province_id').val(), 'bySelect');
        })

        $('#province_id').on('change', function() {
            loadCity($(this).val(), '');
        })

        function loadCity(province_id, type) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "{{ url('/api/city') }}",
                    type: "GET",
                    data: { province_id: province_id },
                    success: function(html){
                        $('#city_id').empty()
                        $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>')
                        $.each(html.data, function(key, item) {
                            
                            // KITA TAMPUNG VALUE CITY_ID SAAT INI
                            let city_selected = {{ $users->city_id }};
                           //KEMUDIAN DICEK, JIKA CITY_SELECTED SAMA DENGAN ID CITY YANG DOLOOPING MAKA 'SELECTED' AKAN DIAPPEND KE TAG OPTION
                            let selected = type == 'bySelect' && city_selected == item.id ? 'selected':'';
                            //KEMUDIAN KITA MASUKKAN VALUE SELECTED DI ATAS KE DALAM TAG OPTION
                            $('#city_id').append('<option value="'+item.id+'" '+ selected +'>'+item.title+'</option>')
                            resolve()
                        })
                    }
                });
            })
        }
    </script>
@endsection