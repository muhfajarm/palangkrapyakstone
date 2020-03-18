<div class="form-group">
	<label for="order_id" class="col-form-label">Nama Pelanggan :</label>
	<select name="order_id" id="order_id" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih Nama" style="width: 100%;">
		@foreach ($orders as $order)
			<option></option>
			<option value="{{ $order->id }}">{{ $order->nama_pelanggan }}</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	<label for="produk_id" class="col-form-label">Produk :</label>
	<select name="produk_id" id="produk_id" class="form-control select2 select2-hidden-accessible" data-placeholder="Pilih Produk" style="width: 100%;">
		@foreach ($products as $product)
			<option></option>
			<option value="{{ $product->id }}">{{ $product->nama }}</option>
		@endforeach
	</select>
</div>
<div class="form-group">
	<label for="jumlah" class="col-form-label">Jumlah :</label>
	<input type="text" class="form-control" name="jumlah" id="jumlah" required="required">
</div>