<div class="form-group">
	<label for="nama" class="col-form-label">Nama User :</label>
	<input type="text" class="form-control" name="nama" id="nama" required="required">
</div>
<div class="form-group">
	<label for="email" class="col-form-label">Email :</label>
	<input type="email" class="form-control" name="email" id="email" required="required">
</div>
<div class="form-group">
	<label for="password" class="col-form-label">Password :</label>
	<input type="password" class="form-control" name="password" id="password" placeholder="********">
	<label>Biarkan kosong apabila tidak ingin mengganti Password</label>
</div>
<div class="form-group">
	<label for="alamat" class="col-form-label">Alamat :</label>
	<input type="text" class="form-control" name="alamat" id="alamat">
</div>
<div class="form-group">
	<label for="no_hp" class="col-form-label">No HP :</label>
	<input type="text" class="form-control" name="no_hp" id="no_hp">
</div>
<div class="form-group">
	<label for="admin" class="col-form-label">Admin :</label>
	<select name="admin" id="admin" required>
		<option value="0">Bukan</option>
		<option value="1">Admin</option>
	</select>
</div>
<div class="form-group">
	<label for="province_id" class="col-form-label">Provinsi :</label>
	<select class="form-control select2 select2-hidden-accessible" name="province_id" id="province_id" data-placeholder="Pilih..." style="width: 100%">
    	@foreach ($provinces as $row)
	        <option></option>
	        <option value="{{ $row->id }}">{{ $row->title }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="">Kabupaten / Kota</label>
    <select class="form-control select2 select2-hidden-accessible" name="city_id" id="city_id" data-placeholder="Pilih..." style="width: 100%">
        <option value="">Pilih Kabupaten/Kota</option>
    </select>
</div>