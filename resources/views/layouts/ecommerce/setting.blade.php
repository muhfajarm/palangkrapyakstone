@extends('layouts.dashboard')

@section('title')
    Pengaturan
@endsection

@section('content')
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
                    <h4 class="card-title">Informasi Pribadi</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('customer.setting') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control" required value="{{ $customer->nama }}">
                            <p class="text-danger">{{ $errors->first('nama') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required value="{{ $customer->email }}" readonly>
                            <p class="text-danger">{{ $errors->first('email') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="******">
                            <p class="text-danger">{{ $errors->first('password') }}</p>
                            <p>Biarkan kosong jika tidak ingin mengganti password</p>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No Telp</label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control" required value="{{ $customer->no_hp }}">
                            <p class="text-danger">{{ $errors->first('no_hp') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" id="alamat" class="form-control" required value="{{ $customer->alamat }}">
                            <p class="text-danger">{{ $errors->first('alamat') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="province_id">Provinsi</label>
                            <select class="form-control select2 select2-hidden-accessible" name="province_id" id="province_id" data-placeholder="Pilih..." style="width: 100%" required>
                                <option value="">Pilih Propinsi</option>
                                @foreach ($provinces as $row)
                                <option value="{{ $row->id }}" {{ $customer->city && $customer->city->province_id == $row->id ? 'selected':'' }}>{{ $row->title }}</option>
                                {{-- <option value="{{ $row->id }}" {{ $customer->city->province_id == $row->id ? 'selected':'' }}>{{ $row->title }}</option> --}}
                                @endforeach
                            </select>
                            <p class="text-danger">{{ $errors->first('province_id') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="city_id">Kabupaten / Kota</label>
                            <select class="form-control select2 select2-hidden-accessible" name="city_id" id="city_id" data-placeholder="Pilih..." style="width: 100%" required>
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                            <p class="text-danger">{{ $errors->first('city_id') }}</p>
                        </div>
                        {{-- <div class="form-group">
                            <label for="district_id">Kecamatan</label>
                            <select class="form-control select2 select2-hidden-accessible" name="district_id" id="district_id" data-placeholder="Pilih..." style="width: 100%" required>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            <p class="text-danger">{{ $errors->first('district_id') }}</p>
                        </div> --}}
                        <button class="btn btn-primary btn-sm">Simpan</button>
                    </form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
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
                            let city_selected = {{ $customer->city_id }};
                            //console.log(city_selected);
                           //KEMUDIAN DICEK, JIKA CITY_SELECTED SAMA DENGAN ID CITY YANG DOLOOPING MAKA 'SELECTED' AKAN DIAPPEND KE TAG OPTION
                            let selected = type == 'bySelect' && city_selected == item.id ? 'selected':'';
                            // console.log(selected);
                            //KEMUDIAN KITA MASUKKAN VALUE SELECTED DI ATAS KE DALAM TAG OPTION
                            $('#city_id').append('<option value="'+item.id+'" '+ selected +'>'+item.title+'</option>')
                            resolve()
                        })
                    }
                });
            })
        }

        //CARA KERJANYA SAMA SAJA DENGAN FUNGSI DI ATAS
        // function loadDistrict(city_id, type) {
        //     $.ajax({
        //         url: "{{-- url('/api/district') --}}",
        //         type: "GET",
        //         data: { city_id: city_id },
        //         success: function(html){
        //             $('#district_id').empty()
        //             $('#district_id').append('<option value="">Pilih Kecamatan</option>')
        //             $.each(html.data, function(key, item) {
        //                 let district_selected = {{-- $customer->district->id --}};
        //                 console.log(district_selected);
        //                 let selected = type == 'bySelect' && district_selected == item.id ? 'selected':'';
        //                 console.log(selected);
        //                 $('#district_id').append('<option value="'+item.id+'" '+ selected +'>'+item.nama+'</option>')
        //             })
        //         }
        //     });
        // }
    </script>
@endsection