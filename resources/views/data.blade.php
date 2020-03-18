@foreach($products as $product)
  <div class="col-md-3">
    <div class="card mb-4 shadow-sm" style="width: 15rem;">
      <a href="/produk/{{ $product->slug }}"><img src="{{ asset('storage/products/' . $product->image) }}" width="80px" height="250px" class="card-img-top" alt="{{ $product->nama }}"></a>
      <div class="card-body">
        <a href="/produk/{{ $product->slug }}" class="card-title">{{ $product->nama }}</a>
        <p class="card-text">{{ formatRupiah($product->harga_jual_3) }}</p>
      </div>
    </div>
  </div>
@endforeach