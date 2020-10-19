@foreach($products as $product)
	@if ($product->stok <= 0)
		<div class="col-md-3">
			<div class="card mb-4 shadow-sm" style="width: 15rem;filter: blur(2px);-webkit-filter: blur(2px);">
				<a><img src="{{ asset('storage/products/' . $product->gambar) }}" width="80px" height="250px" class="card-img-top" alt="{{ $product->nama }}"></a>
				<div class="card-body">
					<a href="" class="card-title">{{ $product->nama }}</a>
					<p class="card-text">{{ formatRupiah($product->harga_jual_3) }}</p>
				</div>
    		</div>
		</div>
	@else
		<div class="col-md-3">
			<div class="card mb-4 shadow-sm" style="width: 15rem;">
				<a href="{{ route('front.show', $product->slug) }}"><img src="{{ asset('storage/products/' . $product->gambar) }}" width="80px" height="250px" class="card-img-top" alt="{{ $product->nama }}"></a>
				<div class="card-body">
					<a href="{{ route('front.show', $product->slug) }}" class="card-title">{{ $product->nama }}</a>
					<p class="card-text">{{ formatRupiah($product->harga) }}</p>
				</div>
    		</div>
		</div>
	@endif
@endforeach