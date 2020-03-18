<div class="form-group">
	<label for="nama_pelanggan" class="col-form-label">Nama Pelanggan :</label>
	<input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" required="required">
</div>
{{-- <div class="form-group col-md-4">
	<label for="provinsi_id" class="col-form-label">Provinsi :</label>
	<br>
	<select name="provinsi_id" id="provinsi_id" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih Provinsi" style="width: 100%;">
		@foreach ($provinces as $province)
			<option></option>
			<option value="{{ $province->id }}">{{ $province->nama }}</option>
		@endforeach
	</select>
</div>
<div class="form-group col-md-4">
	<label for="kota_id" class="col-form-label">Kota / Kabupaten :</label>
	<br>
	<select name="kota_id" id="kota_id" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih Kota/Kabupaten" style="width: 100%;">
		@foreach ($cities as $city)
			<option></option>
			<option value="{{ $city->id }}">{{ $city->nama }}</option>
		@endforeach
	</select>
</div>
<div class="form-group col-md-4">
	<label for="kecamatan_id" class="col-form-label">Kecamatan :</label>
	<br>
	<select name="kecamatan_id" id="kecamatan_id" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih Kecamatan" style="width: 100%;">
		@foreach ($districts as $district)
			<option></option>
			<option value="{{ $district->id }}">{{ $district->nama }}</option>
		@endforeach
	</select>
</div> --}}
<div class="form-group">
	<label for="alamat" class="col-form-label">Alamat :</label>
	<textarea class="form-control" style="resize:none;width:570px;" rows="3" name="alamat" id="alamat" required="required"></textarea>
</div>
{{-- <div class="form-group col-md-4">
	<label for="jasa_pengiriman_id" class="col-form-label">Jasa Pengiriman :</label>
	<br>
	<select name="jasa_pengiriman_id" id="jasa_pengiriman_id" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih Jasa Pengiriman" style="width: 100%;">
		@foreach ($shippings as $shipping)
			<option></option>
			<option value="{{ $shipping->id }}">{{ $shipping->nama }}</option>
		@endforeach
	</select>
</div> --}}
<div class="form-group col-xs-4">
	<label for="no_hp" class="col-form-label">No HP :</label>
	<input type="text" class="form-control" name="no_hp" id="no_hp" required="required">
</div>
<div class="form-group col-xs-8">
	<label for="email" class="col-form-label">Email :</label>
	<input type="email" class="form-control" name="email" id="email" required="required">
</div>
<div class="form-group col-xs-5">
	<label for="status_order" class="col-form-label">Status Order :</label>
	<input type="text" class="form-control" name="status_order" id="status_order" required="required">
</div>
<div class="form-group col-xs-4">
	<label for="tanggal_order" class="col-form-label">Tanggal Order :</label>
	<input type="date" class="form-control" name="tanggal_order" id="tanggal_order" required="required">
</div>
<div class="form-group col-xs-3">
	<label for="jam_order" class="col-form-label">Jam Order :</label>
	<input type="time" class="form-control" name="jam_order" id="jam_order" required="required">
</div>

<br><br><br><br><br><br><br>