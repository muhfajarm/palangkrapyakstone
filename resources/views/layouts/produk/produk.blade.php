@extends('layouts.slug')

@section ('content')
	<div class="container-fluid">
		<div class="content-wrapper">
			<div class="container">
				<div class="col-md-12">
					<div class="col-md-5 float-left">
						<img src="/storage/products/{{ $products->image }}" width="150px" height="400px" class="card-img-top" alt="{{ $products->nama }}">
					</div>
					<div class="col-md-7 float-right">
					<div class="product-title">
						<h3>{{ $products->nama }}</h3>
					</div>
					<div class="product-price">
						<h5>Harga : {{ formatRupiah($products->harga_jual_3) }}</h5>
					</div>

					<form action="{{ route('front.cart') }}" method="POST">
						@csrf
						<div class="product-quantity">
							<label for="jumlah">Jumlah : </label>
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;" class="reduced items-count" type="button">
									<i class="lnr lnr-chevron-down">-</i>
							</button>

							<input type="text" name="jumlah"  id="sst" maxlength="12" value="1" title="Jumlah:" >

							<input type="hidden" name="produk_id" value="{{ $products->id }}" class="form-control">

							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button">
								<i class="lnr lnr-chevron-up">+</i>
							</button>
						</div>
						<div>
							<button class="main_btn">Tambah Ke Keranjang</button>
						</div>
					</form>
					<hr>
					<div>
						<h5>Cek Ongkir</h5>
					</div>
					<form id="formOngkir" method="POST" action="/produk/{{ $products->slug }}">
						@csrf
						<div class="row">
							<div class="col">
								<select name="province_destination" id="province_destination" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih..." style="width: 100%">
									@foreach ($provinces as $province => $value)
										<option></option>
	                                    <option value="{{ $province }}">{{ $value }}</option>
	                                @endforeach
								</select>
							</div>
							<div class="col">
								<select name="city_destination"  id="city_destination" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih..." style="width: 100%">
									<option></option>
								</select>
							</div>
						</div><br>
						<div class="row">
							<div class="col">
								<select name="courier" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih..." style="width: 100%">
									@foreach ($couriers as $courier => $value)
										<option></option>
	                                    <option value="{{ $courier }}">{{ $value }}</option>
	                                @endforeach
								</select>
							</div>
							<div class="col">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#province_destination').on('change', function() {
        	$.ajax({
                url: "{{ url('/api/city') }}",
                type: "GET",
                data: { province_id: $(this).val() },
                success: function(html){
                    //SETELAH DATA DITERIMA, SELEBOX DENGAN ID CITY_ID DI KOSONGKAN
                    $('#city_destination').empty()
                    //KEMUDIAN APPEND DATA BARU YANG DIDAPATKAN DARI HASIL REQUEST VIA AJAX
                    //UNTUK MENAMPILKAN DATA KABUPATEN / KOTA
                    $('#city_destination').append('<option value="">Pilih Kabupaten/Kota</option>')
                    $.each(html.data, function(key, item) {
                        $('#city_destination').append('<option value="'+item.id+'">'+item.title+'</option>')
                    })
                }
            });
        });
    });
</script>
{{-- <script>
	$(document).ready(function() {
		$('#formOngkir')on('submit', function(){

        });
    });
</script> --}}
@endsection