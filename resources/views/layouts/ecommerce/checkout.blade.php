@extends('layouts.checkfin')

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
		                            <input type="text" class="form-control" id="nama" name="nama" {{-- value="{{ auth()->user()->nama }}"--}} required>
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
		                        <div class="col-md-3 form-group p_star">
		                            <label for="province_id">Provinsi</label>
		                            <select class="form-control select2 select2-hidden-accessible" name="province_id" id="province_id" data-placeholder="Pilih Provinsi" style="width: 100%" required>
		                            	@foreach ($provinces as $province)
		                                <option></option>
		                                <option value="{{ $province->id }}">{{ $province->title }}</option>
		                                @endforeach
		                            </select>
		                            {{-- <p class="text-danger">{{ $errors->first('province_id') }}</p> --}}
		                            <div class="invalid-tooltip">
		                            	Harap isi Provinsi
		                            </div>
		                        </div>
		                        <div class="col-md-3 form-group p_star">
		                            <label for="">Kabupaten / Kota</label>
		                            <select class="form-control select2 select2-hidden-accessible" name="city_id" id="city_id" style="width: 100%" disabled="true" required>
		                                <option value="">Pilih Kabupaten/Kota</option>
		                            </select>
		                            {{-- <p class="text-danger">{{ $errors->first('city_id') }}</p> --}}
		                            <div class="invalid-tooltip">
		                            	Harap isi Kabupaten / Kota
		                            </div>
		            				<input type="hidden" name="kota_tujuan" id="kota_tujuan" nama="nama_kota" class="form-control">
		                        </div>
		                        <div class="col-md-2 form-group p_star">
		                        	<label for="">Ekspedisi</label>
		                        	<select name="kurir" id="kurir" class="form-control select2 select2-hidden-accessible" style="width: 100%" disabled="true" required>
											<option>Pilih Ekspedisi</option>
									</select>
		            				<input type="hidden" name="namakurir" id="namakurir" class="form-control">
		                        </div>
		                        <div class="col-md-4 form-group p_star" id="testO">
									<label>Pilih Layanan</label>
									<select name="layanan" id="layanan" class="form-control select2 select2-hidden-accessible" style="width: 100%" disabled="true">
										<option value="">Pilih Layanan</option>
									</select>
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
										<a href="#">Produk
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
					                {{-- <li>
										<a href="#">Total Berat
											<span id="berat" value="{{ $weight }}">{{ $weight }}gram</span>
										</a>
					                </li> --}}
									<li>
										<a href="#">Subtotal
	                    					<span>{{ formatRupiah($subtotal) }}</span>
										</a>
										<input type="hidden" id="subtotal" name="subtotal" class="form-control" value="{{ $subtotal }}">
									</li>
									<li id="liongkir">
										<a href="#">Pengiriman
											<span id="testOngkir">Rp. 0</span>
										</a>
									</li>
									<li id="litotal">
										<a href="#">Total
											<span id="total">{{ formatRupiah($subtotal) }}</span>
										</a>
										<input type="hidden" id="amount" name="amount" class="form-control">
									</li>
								</ul>
								<input type="hidden" id="berat" value="{{ $weight }}">
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
	{{-- Loading Page --}}
	<script>
	    var myVar;

	    function myFunction() {
	        myVar = setTimeout(showPage, 500);
	    }

	    function showPage() {
	        document.getElementById("loader").style.display = "none";
	        document.getElementById("myDiv").style.display = "block";
	    }
	</script>
	{{-- Loading Page --}}
	
    <script>
    	//KETIKA SELECT BOX DENGAN ID province_id DIPILIH
        $('#province_id').on('change', function() {
        	$('#city_id').empty()
            $('#city_id').attr('disabled', 'true')
        	$('#city_id').append('<option value="">Memuat...</option>')
        	$('#kurir').empty()
        	$('#kurir').attr('disabled', 'true')
        	$('#kurir').append('<option value="">Pilih Ekspedisi</option>')
        	$('#layanan').empty()
        	$('#layanan').attr('disabled', 'true')
        	$('#layanan').append('<option value="">Pilih Layanan</option>')
			$('#hargalayanan').remove();
            //MAKA AKAN MELAKUKAN REQUEST KE URL /API/CITY
            //DAN MENGIRIMKAN DATA PROVINCE_ID
            $.ajax({
                url: "{{ url('/api/cityC') }}",
                type: "GET",
                data: { province_id: $(this).val() },
                success: function(html){
                    //SETELAH DATA DITERIMA, SELECBOX DENGAN ID CITY_ID DI KOSONGKAN
                    $('#city_id').empty()
                    //KEMUDIAN APPEND DATA BARU YANG DIDAPATKAN DARI HASIL REQUEST VIA AJAX
                    //UNTUK MENAMPILKAN DATA KABUPATEN / KOTA
                    $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>')
                    $.each(html.data, function(key, item) {
                        $('#city_id').append('<option value="'+item.id+'" namakota="' +item.id+ '">'+item.title+'</option>')
			        	$('#city_id').removeAttr('disabled');
                    })
                }
            });
        });
        $('#city_id').on('change', function() {
        	$('#kurir').empty()
        	$('#kurir').attr('disabled', 'true')
		    $('#kurir').append('<option value="">Memuat...</option>')
        	$('#layanan').empty()
        	$('#layanan').attr('disabled', 'true')
        	$('#layanan').append('<option value="">Pilih Layanan</option>')
			$('#hargalayanan').remove();
        	$.ajax({
        		url: "{{ url('/api/costC') }}",
                type: "GET",
                // data: { },
                success: function(html){
                	$('#kurir').empty()
		            $('#kurir').append('<option value="">Pilih Ekspedisi</option>')
		            $.each(html, function(key, item) {
                        $('#kurir').append('<option value="'+item.code+'" namaekpedisi="'+item.title+'" namakurir="'+item.code+'">'+item.title+'</option>')
			        	$('#kurir').removeAttr('disabled');
                    })
                }
        	});
        	let namakotaku = $("#city_id option:selected").attr("namakota");
        	$("#kota_tujuan").val(namakotaku);
        });

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
    	$('#kurir').on('change', function(){
			let namakurirku = $("#kurir option:selected").attr("namakurir")
			let namaekpedisi = $("#kurir option:selected").attr("namaekpedisi")
			let berat = $('#berat').attr("value")
			$("#namakurir").val(namakurirku)
	    	$('#layanan').empty()
		    $('#layanan').append('<option value="">Memuat...</option>')
			$('#pilihlayanan').remove()
			$('#layanankurir').remove()
			$('#hargalayanan').remove()
			$('#amount').remove()

			let origin = 196
			let destination = $("input[name=kota_tujuan]").val()
			let courier = $("input[name=namakurir]").val()
			let weight = berat

			if(courier){
				jQuery.ajax({
					url:"/checkout/origin="+origin+"&destination="+destination+"&weight="+weight+"&courier="+courier,
					type:'post',
					dataType:'json',
					data: {"_token": "{{ csrf_token() }}"},
					success:function(data){
						$('#testOngkir').html('');
						$('#layanan').empty();
						$.each(data, function(key, value){
							$.each(value.costs, function(key1, value1){
								$.each(value1.cost, function(key2, value2){
									$('#layanan').append('<option value="'+ value2.value +'" layanankurir="' +value1.service+'" hargaKurir="' +value2.value+ '">' + value1.service + '-' +value2.value+ '</option>')

									$('#layanan').removeAttr('disabled')

								});
							});
						});

						$('#testO').append('<input type="hidden" name="pilihlayanan" id="pilihlayanan" class="form-control" value="'+namaekpedisi+'">')

						let layanankurir = $("#layanan option:selected, this").attr("layanankurir")
						$('#testO').append('<input type="hidden" name="layanankurir" id="layanankurir" class="form-control" value="'+layanankurir+'">')

						let pilihKurir = $("#layanan option:selected, this").attr("hargaKurir")
						$('#testO').append('<input type="hidden" name="hargalayanan" id="hargalayanan" class="form-control" value="'+pilihKurir+'">')
						let testO = $('#hargalayanan').attr('value')
						let intOngkir = parseInt(testO)
						let format_ongkir = intOngkir.toLocaleString(
							undefined,
							{ minimumFractionDigits: 0 }
						);
						$('#cost').remove()
						$('#liongkir').append('<input type="hidden" id="cost" name="cost" class="form-control" value="'+intOngkir+'">')
						$('#testOngkir').append('Rp. '+format_ongkir);

						let subtotal = "{{ $subtotal }}"
						let total = parseInt(subtotal) + parseInt(testO)
						let format_total = total.toLocaleString(
							undefined,
							{ minimumFractionDigits: 0 }
						);
						$('#litotal').append('<input type="hidden" id="amount" name="amount" class="form-control" value="'+total+'">')
						$('#total').empty()
						$('#total').append('Rp. '+format_total);
					},
				});
			}
		});
		$('#layanan').on('change', function(){
			let namaekpedisi = $("#kurir option:selected").attr("namaekpedisi")
			$('#testOngkir').empty()
			$('#pilihlayanan').remove()
			$('#layanankurir').remove()
			$('#hargalayanan').remove()
			$('#cost').remove()
			$('#amount').remove()
			$('#total').empty()

			$('#testO').append('<input type="hidden" name="pilihlayanan" id="pilihlayanan" class="form-control" value="'+namaekpedisi+'">')

			let layanankurir = $("#layanan option:selected, this").attr("layanankurir")
			$('#testO').append('<input type="hidden" name="layanankurir" id="layanankurir" class="form-control" value="'+layanankurir+'">')

			let pilihKurir = $("#layanan option:selected").attr("hargaKurir");
			$('#testO').append('<input type="hidden" name="hargalayanan" id="hargalayanan" class="form-control" value="'+pilihKurir+'">')
			let testO = $('#hargalayanan').attr('value')
			let intOngkir = parseInt(testO)
			let format_ongkir = intOngkir.toLocaleString(
				undefined,
				{ minimumFractionDigits: 0 }
			);
			$('#liongkir').append('<input type="hidden" id="cost" name="cost" class="form-control" value="'+intOngkir+'">')
			$('#testOngkir').append('Rp. '+format_ongkir);

			let subtotal = "{{ $subtotal }}"
			let total = parseInt(subtotal) + parseInt(testO)
			let format_total = total.toLocaleString(
				undefined,
				{ minimumFractionDigits: 0 }
			);
			$('#litotal').append('<input type="hidden" id="amount" name="amount" class="form-control" value="'+total+'">')
			$('#total').append('Rp. '+format_total);
		});
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
	    function submitForm() {
	        // Kirim request ajax
	        $.post("{{ route('front.store_checkout') }}",
	        {
	            _method: 'POST',
	            _token: '{{ csrf_token() }}',
	            nama: $('#nama').val(),
	            no_hp: $('#no_hp').val(),
	            email: $('#email').val(),
	            province_id: $('#province_id').val(),
	            city_id: $('#city_id').val(),
	            jasa_ekspedisi: $('#namakurir').val(),
	            ongkir: $('#cost').val(),
	            alamat: $('#alamat').val(),
	            total: $('#amount').val(),
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