@extends('layouts.slug')

@section ('content')
	<section class="checkout_area section_gap">
		<div class="container">
			<div class="billing_details">
				<div class="row">
					<div class="col-lg-8">
						<h3>Informasi Pengiriman</h3>
						@if (session('error'))
						<div class="alert alert-danger">{{ session('error') }}</div>
						@endif

			            <form class="needs-validation"  id="checkout" onsubmit="return submitForm();" novalidate="novalidate">
                        	@csrf
                        	<div class="form-row">
	                        	<div class="col-md-12 form-group p_star">
		                            <label for="">Nama Lengkap</label>
		                            <input type="text" class="form-control" id="nama" name="nama" {{-- value="{{ auth()->user()->nama }}"--}} required="required">
		                            {{-- <p class="text-danger">{{ $errors->first('nama_pelanggan') }}</p> --}}
		                            <div class="invalid-tooltip">
		                            	Harap isi Nama Lengkap
		                            </div>
		                        </div>
                    		</div>
	                        <div class="form-row">
		                        <div class="col-md-6 form-group p_star">
		                            <label for="">No HP</label>
		                            <input type="text" class="form-control" id="no_hp" name="no_hp" {{-- value="{{ auth()->user()->no_hp }}"--}} required>
		                            {{-- <p class="text-danger">{{ $errors->first('no_hp') }}</p> --}}
		                            <div class="invalid-tooltip">
		                            	Harap isi No HP
		                            </div>
		                        </div>
		                        <div class="col-md-6 form-group p_star">
		                            <label for="">Email</label>
		                            <div class="input-group">
			                            <div class="input-group-prepend">
								          <div class="input-group-text">@</div>
								        </div>
			                            <input type="email" class="form-control" id="email" name="email" {{-- value="{{ auth()->user()->email }}"--}} required>
			                            {{-- <p class="text-danger">{{ $errors->first('email') }}</p> --}}
			                            <div class="invalid-tooltip">
			                            	Harap isi Email
			                            </div>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="form-row">
		                        <div class="col-md-6 form-group p_star">
		                            <label for="province_id">Provinsi</label>
		                            <select class="form-control select2 select2-hidden-accessible" name="province_id" id="province_id" data-placeholder="Pilih..." style="width: 100%" required>
		                            	@foreach ($provinces as $row)
		                                <option></option>
		                                <option value="{{ $row->id }}">{{ $row->title }}</option>
		                                @endforeach
		                            </select>
		                            {{-- <p class="text-danger">{{ $errors->first('province_id') }}</p> --}}
		                            <div class="invalid-tooltip">
		                            	Harap isi Provinsi
		                            </div>
		                        </div>
		                        <div class="col-md-6 form-group p_star">
		                            <label for="">Kabupaten / Kota</label>
		                            <select class="form-control select2 select2-hidden-accessible" name="city_id" id="city_id" data-placeholder="Pilih..." style="width: 100%" required>
		                                <option value="">Pilih Kabupaten/Kota</option>
		                            </select>
		                            {{-- <p class="text-danger">{{ $errors->first('city_id') }}</p> --}}
		                            <div class="invalid-tooltip">
		                            	Harap isi Kabupaten / Kota
		                            </div>
		                        </div>
	            			</div>
	            			<div class="form-row">
		                        <div class="col-md-9 form-group p_star">
		                            <label for="">Alamat Lengkap</label>
		                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat tanpa kabupaten/kota dan provinsi..." value="" required>
		                            {{-- <p class="text-danger">{{ $errors->first('alamat') }}</p> --}}
		                            <div class="invalid-tooltip">
		                            	Harap isi Alamat Lengkap
		                            </div>
		                        </div>
		                        <div class="col-md-3 form-group p_star">
		                        	<label for="">Kode Pos</label>
		                        	<input class="form-control" type="text" name="kode_pos" required>
		                        	<div class="invalid-tooltip">
		                            	Harap isi Kode Pos
		                            </div>
		                            {{-- <label for="">Kecamatan</label>
		                            <select class="form-control select2 select2-hidden-accessible" name="district_id" id="district_id" data-placeholder="Pilih..." style="width: 100%" required>
		                                <option value="">Pilih Kecamatan</option>
		                            </select>
		                            <p class="text-danger">{{ $errors->first('district_id') }}</p> --}}
		                        </div>
		                    </div>
		                </div>
						<div class="col-lg-4">
							<div class="order_box">
								<h2>Ringkasan Pesanan</h2>
								<ul class="list">
									<li>
										<a href="#">Product
											<span>Total</span>
										</a>
					                </li>
					                @foreach ($carts as $cart)
									<li>
										<a href="#">{{ \Str::limit($cart['produk_nama'], 10) }}
						                    <span class="middle">x {{ $cart['jumlah'] }}</span>
						                    <span class="last">{{ formatRupiah($cart['harga_produk']) }}</span>
										</a>
					                </li>
					                @endforeach
								</ul>
								<ul class="list list_2">
									<li>
										<a href="#">Subtotal
	                    					<span>{{ formatRupiah($subtotal) }}</span>
										</a>
									</li>
									<li>
										<a href="#">Pengiriman
											<span>Rp 0</span>
										</a>
									</li>
									<li>
										<a href="#">Total
											<span>{{ formatRupiah($subtotal) }}</span>
										</a>
										<input type="hidden" id="amount" name="amount" class="form-control" value="{{ $subtotal }}">
									</li>
								</ul>
	              				<button id="submit" class="main_btn">Bayar Pesanan</button>
	              			</div>
	              		</div>
	              		</form>
	              	</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('js')
    <script>
    	//KETIKA SELECT BOX DENGAN ID province_id DIPILIH
        $('#province_id').on('change', function() {
            //MAKA AKAN MELAKUKAN REQUEST KE URL /API/CITY
            //DAN MENGIRIMKAN DATA PROVINCE_ID
            $.ajax({
                url: "{{ url('/api/city') }}",
                type: "GET",
                data: { province_id: $(this).val() },
                success: function(html){
                    //SETELAH DATA DITERIMA, SELECBOX DENGAN ID CITY_ID DI KOSONGKAN
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

        //LOGICNYA SAMA DENGAN CODE DIATAS HANYA BERBEDA OBJEKNYA SAJA
        // $('#city_id').on('change', function() {
        //     $.ajax({
                // url: "{{-- url('/api/district') --}}",
        //         type: "GET",
        //         data: { city_id: $(this).val() },
        //         success: function(html){
        //             $('#district_id').empty()
        //             $('#district_id').append('<option value="">Pilih Kecamatan</option>')
        //             $.each(html.data, function(key, item) {
        //                 $('#district_id').append('<option value="'+item.id+'">'+item.name+'</option>')
        //             })
        //         }
        //     });
        // })
    </script>
    <script>
	// Example starter JavaScript for disabling form submissions if there are invalid fields
	(function() {
	  'use strict';
	  window.addEventListener('load', function() {
	    // Fetch all the forms we want to apply custom Bootstrap validation styles to
	    var forms = document.getElementsByClassName('needs-validation');
	    // Loop over them and prevent submission
	    var validation = Array.prototype.filter.call(forms, function(form) {
	      form.addEventListener('submit', function(event) {
	        if (form.checkValidity() === false) {
	          event.preventDefault();
	          event.stopPropagation();
	        }
	        form.classList.add('was-validated');
	      }, false);
	    });
	  }, false);
	})();
	</script>
@endsection

@section('snap')
	<script src="{{ !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script>
		// let amount = $('#amount').val();
		// let nama = $('#nama').val();
		// let no_hp = $('#no_hp').val();
		// let email = $('#email').val();
		// let province_id = $('#province_id').val();
		// let city_id = $('#city_id').val();
		// let alamat = $('#alamat').val();
	    function submitForm() {
	        // Kirim request ajax
	        $.post("{{ route('front.store_checkout') }}",
	        {
	            _method: 'POST',
	            _token: '{{ csrf_token() }}',
	            subtotal: $('#amount').val(),
	            nama: $('#nama').val(),
	            no_hp: $('#no_hp').val(),
	            email: $('#email').val(),
	            province_id: $('#province_id').val(),
	            city_id: $('#city_id').val(),
	            alamat: $('#alamat').val(),
	        },
	        function (data, status) {
	            snap.pay(data.snap_token, {
	                // Optional
	                onSuccess: function (result) {
	                    location.reload();
	                },
	                // Optional
	                onPending: function (result) {
	                    location.reload();
	                },
	                // Optional
	                onError: function (result) {
	                    location.reload();
	                }
	            });
	        });
	        return false;
	    }
    </script>
@endsection