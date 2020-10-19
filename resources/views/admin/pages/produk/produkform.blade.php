<div class="form-group col-xs-6">
	<label for="nama" class="col-form-label">Nama Produk :</label>
	<input type="text" class="form-control" name="nama" id="nama" required="required">
</div>
<div class="form-group col-xs-6">
	<label for="category_id" class="col-form-label">Kategori :</label>
	<select name="category_id" id="category_id" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih Kategori" style="width: 100%">
		@foreach ($categories as $category)
			<option></option>
			<option value="{{ $category->id }}">{{ $category->nama }}</option>
		@endforeach
	</select>
</div>
<div class="form-group col-xs-12">
	<label for="deskripsi" class="col-form-label">Deskripsi :</label>
	<textarea class="form-control" style="resize:none;width:540px;" rows="5" name="deskripsi" id="deskripsi" required="required"></textarea>
</div>
{{-- <div class="form-group col-xs-3">
	<label for="harga_beli" class="col-form-label">Harga Beli :</label>
	<input type="number" class="form-control" name="harga_beli" id="harga_beli">
</div>
<div class="form-group col-xs-3">
	<label for="harga_jual_1" class="col-form-label">Harga Jual 1 :</label>
	<input type="number" class="form-control" name="harga_jual_1" id="harga_jual_1">
</div>
<div class="form-group col-xs-3">
	<label for="harga_jual_2" class="col-form-label">Harga Jual 2:</label>
	<input type="number" class="form-control" name="harga_jual_2" id="harga_jual_2">
</div> --}}
<div class="form-group col-xs-3">
	<label for="harga_jual_3" class="col-form-label">Harga Jual :</label>
	<input type="number" class="form-control" name="harga_jual_3" id="harga_jual_3">
</div>
<div class="form-group col-xs-4">
	<label for="stok" class="col-form-label">Stok :</label>
	<input type="number" class="form-control" name="stok" id="stok" >
</div>
<div class="form-group col-xs-3">
	<label for="berat" class="col-form-label">Berat(gram) :</label>
	<input type="text" class="form-control" name="berat" id="berat" >
</div>
<div class="form-group col-xs-2">
	<label for="dibeli" class="col-form-label">Dibeli :</label>
	<input type="number" class="form-control" name="dibeli" id="dibeli" >
</div>
<div class="form-group col-xs-12">
	<label for="image" class="col-form-label">Gambar :</label>
	<div>
		<img src="" width="80px" height="80px" id="pict">
	</div>
	<input type="file" class="form-control" name="image" id="image">
</div>