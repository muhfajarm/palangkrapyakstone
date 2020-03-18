@extends('layouts.slug')

@section ('content')
	<div class="container-fluid">
        <div class="sidenav mt-lg-5">
            <div class="card bg-light border-light">
                <div class="card-body">
                    <h3>Kategori</h3>
                    <ul class="menu-sidebar-area">
                        @foreach($categories as $category)
                            <li class="icon-dashboard"><a class="dropdown-item" href="{{ route('front.category', $category->slug) }}">{{ $category->nama }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="main">
            <div class="row flex-row-reverse">
                <div class="col-md-3">
                    <form class="form-inline float-right">
                        <div class="form-group pr-1">
                            <div>
                                <select name="urut" class="custom-select custom-select-sm">
                                    @if(request('urut'))
                                        @if(request('urut') == "desc")
                                            <option value="desc">Descending</option>
                                            <option value="asc">Ascending</option>
                                        @else
                                            <option value="asc">Ascending</option>
                                            <option value="desc">Descending</option>
                                        @endif
                                        @else
                                            <option value="" disabled selected>Urutkan</option>
                                            <option value="asc">Ascending</option>
                                            <option value="desc">Descending</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    </form>
                </div>
            </div>
            <div class="row">
                @forelse($products as $product)
                <div class="mt-1 col-md-3">
                    <div class="card mb-2 shadow-sm" style="width: 16rem;">
                        <div class="card-body">
                            <img src="{{ asset('storage/products/' . $product->image) }}"
                            width="80px" height="250px" class="card-img-top" alt="{{ $product->nama }}">
                            <a href="/produk/{{ $product->slug }}" class="card-title">{{ $product->nama }}</a>
                            <p class="card-text">{{ formatRupiah($product->harga_jual_3) }}</p>
                        </div>
                    </div>
                </div>
                @empty

                <div class="col-md-12">
                    <h3 class="text-center">Tidak ada produk</h3>
                </div>

                @endforelse
                  
                    <!-- PROSES LOOPING DATA PRODUK, SAMA DENGAN CODE YANG ADDA DIHALAMAN HOME -->
                    {{-- @forelse ($products as $row)
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="f_p_item">
                            <div class="f_p_img">
                                <img class="img-fluid" src="{{ asset('storage/products/' . $row->image) }}" alt="{{ $row->name }}">
                                <div class="p_icon">
                                    <a href="{{ url('/product/' . $row->slug) }}">
                                        <i class="lnr lnr-cart"></i>
                                    </a>
                                </div>
                            </div>
                            <a href="{{ url('/product/' . $row->slug) }}">
                                <h4>{{ $row->name }}</h4>
                            </a>
                            <h5>Rp {{ number_format($row->price) }}</h5>
                        </div>
                    </div>
                    @empty
                    @endforelse --}}
                  <!-- PROSES LOOPING DATA PRODUK, SAMA DENGAN CODE YANG ADDA DIHALAMAN HOME -->
            </div>
            <div class="float-right">
              {{ $products->appends(['urut'=>request('urut')])->links() }}
            </div>
        </div>
    </div>
@endsection