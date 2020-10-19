@extends('layouts.slug')

@section ('content')
	@if ($products->stok <= 0)
	<div class="container-fluid-stok empty-stok">
		<div class="content-wrapper">
			<div class="container">
				<div class="col-md-12">
					<div class="col-md-5 float-left">
						<img id="paren" src="/storage/products/{{ $products->gambar }}" width="150px" height="400px" class="card-img-top" alt="{{ $products->nama }}">
						<input type="hidden" id="namagambar" name="namagambar" value="{{ $products->gambar }}" src="/storage/products/{{ $products->gambar }}">
					</div>
					<div class="col-md-7 float-right">
					<div class="product-title">
						<h3>{{ $products->nama }}</h3>
						<label id="berat" value="{{ $products->berat }}">berat : {{ $products->berat}}gram</label>
						<input type="hidden" id="beratproduk" name="beratproduk" value="{{ $products->berat }}">
						<label>|</label>
						<label>Stok : {{$products->stok}}</label><br>
						<input type="hidden" id="stok" value="{{$products->stok}}">
					</div>
					<div class="product-price">
						<h5>Harga : {{ formatRupiah($products->harga) }}</h5>
					</div>
						<div class="product-quantity">
							<h6>Deskripsi</h6>
							<label>{{ $products->deskripsi }}</label><br>
							<label for="jumlah">Jumlah : </label>
							<button class="reduced items-count" type="button">
									<i class="lnr lnr-chevron-down">-</i>
							</button>
							<input type="text" id="jumlah" name="jumlah"  id="sst" maxlength="12" value="1" title="Jumlah:" disabled="">
							<input type="hidden" id="produk_id" name="produk_id" value="{{ $products->id }}" class="form-control">
							<button type="button">
								<i class="lnr lnr-chevron-up">+</i>
							</button>
							<button class="main_btn">Tambah Ke Keranjang</button>
							@if (session('success'))
							<div class="alert alert-success mt-2">{{ session('success') }}</div>
							@endif
						</div>
					<hr>
					<div>
						<h5>Cek Ongkir<span id="popoverOngkir"><img src="/dist/img/info-16.png" class="pl-1"></span></h5>
					</div>
					<form id="formOngkir" method="POST" action="/produk/{{ $products->slug }}">
						@csrf
						<div class="row">
							<div class="col-sm-5">
								<label>Pilih Provinsi<span>*</span></label>
								<select name="province_destination" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih..." style="width: 100%" disabled="">
								</select>
							</div>
							<div class="col-sm-4">
								<label>Pilih Kota<span>*</span></label>
								<select name="city_destination"  id="city_destination" class="form-control select2 select2-hidden-accessible" style="width: 100%" disabled>
									<option>Pilih...</option>
								</select>
								<input type="hidden" name="kota_tujuan" id="kota_tujuan" nama="nama_kota" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Pilih Ekspedisi<span>*</span></label>
								<select name="kurir" id="kurir" class="form-control select2 select2-hidden-accessible" style="width: 100%" disabled>
										<option>Pilih...</option>
								</select>
								<input type="hidden" name="namakurir" id="namakurir"class="form-control">
							</div>
						</div>
						<hr>
						<div id="card-layanan"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@else
	<div class="container-fluid">
		<div class="content-wrapper">
			<div class="container">
				<div class="col-md-12" id="col_produk">
					<div class="col-md-5 float-left">
						<img id="paren" src="/storage/products/{{ $products->gambar }}" width="150px" height="400px" class="card-img-top" alt="{{ $products->nama }}">
						<input type="hidden" id="namagambar" name="namagambar" value="{{ $products->gambar }}" src="/storage/products/{{ $products->gambar }}">
					</div>
					<div class="col-md-7 float-right">
					<div class="product-title">
						<h3>{{ $products->nama }}</h3>
						<input type="hidden" id="namaproduk" name="namaproduk" value="{{ $products->nama }}">
						<label id="berat" value="{{ $products->berat }}">berat : {{ $products->berat}}gram</label>
						<input type="hidden" id="beratproduk" name="beratproduk" value="{{ $products->berat }}">
						<label>|</label>
						<label>Stok : {{$products->stok}}</label><br>
						<input type="hidden" id="stok" value="{{$products->stok}}">
					</div>
					<div class="product-price">
						<h5>Harga : {{ formatRupiah($products->harga) }}</h5>
						<input type="hidden" id="hargaproduk" name="hargaproduk" value="{{ $products->harga }}">
					</div>

					{{-- <form action="{{ route('front.cart') }}" method="POST"> --}}
						{{-- @csrf --}}
						<div class="product-quantity">
							<h6>Deskripsi</h6>
							<label>{{ $products->deskripsi }}</label><br>
							<label for="jumlah">Jumlah : </label>
							<button onClick="decrease_qty({{$products->id}})" class="reduced items-count" type="button">
									<i class="lnr lnr-chevron-down">-</i>
							</button>

							<input type="text" id="jumlah" name="jumlah" maxlength="12" value="1" title="Jumlah:">

							<input type="hidden" id="produk_id" name="produk_id" value="{{ $products->id }}" class="form-control">

							<button onClick="increase_qty({{$products->id}})" class="increase items-count" type="button">
								<i class="lnr lnr-chevron-up">+</i>
							</button>
							<button id="tambahcart" class="main_btn">Tambah Ke Keranjang</button>
							@if (session('success'))
							<div class="alert alert-success mt-2">{{ session('success') }}</div>
							@endif
						</div>
					{{-- </form> --}}
					<hr>
					<div>
						<h5>Cek Ongkir<span id="popoverOngkir" rel="popover" data-placement="bottom" data-original-title="Ongkir" data-trigger="hover" class="pl-1"><img src="/dist/img/info-16.png"></span></h5>
					</div>
					<form id="formOngkir" method="POST" action="/produk/{{ $products->slug }}">
						@csrf
						<div class="row">
							<div class="col-sm-5">
								<label>Pilih Provinsi<span>*</span></label>
								<select name="province_destination" id="province_destination" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih..." style="width: 100%">
									@foreach ($provinces as $province => $value)
										<option></option>
	                                    <option value="{{ $province }}">{{ $value }}</option>
	                                @endforeach
								</select>
							</div>
							<div class="col-sm-4">
								<label>Pilih Kota<span>*</span></label>
								<select name="city_destination"  id="city_destination" class="form-control select2 select2-hidden-accessible" style="width: 100%" disabled>
									<option>Pilih...</option>
								</select>
								<input type="hidden" name="kota_tujuan" id="kota_tujuan" nama="nama_kota" class="form-control">
							</div>
							<div class="col-sm-3">
								<label>Pilih Ekspedisi<span>*</span></label>
								<select name="kurir" id="kurir" class="form-control select2 select2-hidden-accessible" style="width: 100%" disabled>
										<option>Pilih...</option>
								</select>
								<input type="hidden" name="namakurir" id="namakurir"class="form-control">
							</div>
						</div>
						<hr>
						<div id="card-layanan"></div>
					</form>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="popoverOngkir_content_ongkir" style="display: none">
				<div id="popoverInfo">
					<center><h3>Silahkan pilih kurir</h3><center>
				</div>
			</div>
		</div>
	</div>
	@endif
	<input type="hidden" id="slug" value="{{ $products->slug}}">
@endsection

@section('js')
	@include('layouts.produk.js')
@endsection