@extends('layouts.cart')

@section ('content')
	<section id="loadcart" class="cart_area">
		<div class="container">
			<div class="cart_inner">
                    @csrf
                    <div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="col" class="text-center">Produk</th>
								<th scope="col" class="text-center" style="width: 110px;">Harga</th>
								<th scope="col" class="text-center" style="width: 185px;">Jumlah</th>
								<th scope="col" class="text-center" style="width: 135px;">Subtotal</th>
								<th scope="col" style="width: 5px;"></th>
							</tr>
						</thead>
						<tbody id="tbody">
				            <!-- LOOPING DATA DARI VARIABLE CARTS -->
                            @forelse ($carts as $row)
							<tr id="tr-{{ $row['produk_id'] }}">
								<td>
									<div class="media">
										<div class="d-flex">
                                            <img src="{{ asset('storage/products/' . $row['gambar_produk']) }}" width="100px" height="100px" class="mr-2" alt="{{ $row['produk_nama'] }}">
										</div>
										<div class="media-body">
                                            <p>{{ $row['produk_nama'] }}</p>
										</div>
										<input type="hidden" id="tes_produk_id" name="tes_produk_id" value="{{ $row['produk_id'] }}">
									</div>
								</td>
								<td align="right">
                                    <h5>{{ formatRupiah($row['harga_produk']) }}</h5>
                                    <input type="hidden" id="harga-{{ $row['produk_id'] }}" value="{{ $row['harga_produk'] }}">
								</td>
								<td>
									<div class="product_count">
										{{-- <button onclick="var result = document.getElementById('sst{{ $row['produk_id'] }}'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
										 class="reduced items-count" id="kurang" type="button">
											<i class="lnr lnr-chevron-down">-</i>
										</button> --}}
										<button onclick="decrement_quantity({{ $row['produk_id'] }})"
										 class="increase items-count" id="tambah" type="button">
											<i class="lnr lnr-chevron-up">-</i>
										</button>
                    
                    <!-- PERHATIKAN BAGIAN INI, NAMENYA KITA GUNAKAN ARRAY AGAR BISA MENYIMPAN LEBIH DARI 1 DATA -->
                                        <input type="text" name="jumlah[]" maxlength="12" value="{{ $row['jumlah'] }}" title="Jumlah:" class="input-text qty" id="sst{{ $row['produk_id'] }}" disabled>
                                        <input type="hidden" id="sst{{ $row['produk_id'] }}" name="produk_id[]" value="{{ $row['produk_id'] }}" class="form-control">
                                        <input type="hidden" id="product_id" value="{{ $row['produk_id']}}">
                    <!-- PERHATIKAN BAGIAN INI, NAMENYA KITA GUNAKAN ARRAY AGAR BISA MENYIMPAN LEBIH DARI 1 DATA -->

                    					<button onclick="increment_quantity({{ $row['produk_id'] }})"
										 class="increase items-count" id="tambah" type="button">
											<i class="lnr lnr-chevron-up">+</i>
										</button>
										{{-- <button onclick="var result = document.getElementById('sst{{ $row['produk_id'] }}'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
										 class="increase items-count" id="tambah" type="button">
											<i class="lnr lnr-chevron-up">+</i>
										</button> --}}
									</div>
								</td>
								<td align="right">
                                    <h5 id="h5-subtotal-{{$row['produk_id']}}">{{ formatRupiah($row['harga_produk'] * $row['jumlah']) }}</h5>
                                    <input type="hidden" id="subtotal-{{$row['produk_id']}}" value="{{ $row['harga_produk'] * $row['jumlah'] }}">
								</td>
								<td>
									<i id="hapus" onclick="hapus_produk({{ $row['produk_id'] }})">Hapus</i>
								</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                	<center>Tidak ada belanjaan</center>
                                </td>
                            </tr>
                            @endforelse
						</tbody>
						<tfoot>
							<tr class="bottom_button">
								<td align="center">
									<button onclick="hapusCart()" class="gray_btn">Hapus Cart</button>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
                            </tr>
							<tr>
								<td>

								</td>
								<td>

								</td>
								<td align="right">
									<h5>Total</h5>
								</td>
								<td align="right">
                                    <h5 id="total" class="h5">{{ formatRupiah($total) }}</h5>
                                    <input type="hidden" id="tot" value="{{ $total }}">
								</td>
								<td></td>
							</tr>
						</tfoot>
					</table>
					<div class="out_button_area">
						<td>
							<div class="checkout_btn_inner float-left">
								<a class="gray_btn" href="{{ route('front.index') }}">Kembali Berbelanja</a>
							</div>
						</td>
						<td></td>
						<td></td>
						<td>
							<div class="checkout_btn_inner float-right">
								<a class="main_btn" href="{{ route('front.checkout') }}">Lanjutkan Pembayaran</a>
							</div>
						</td>
						<td></td>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section ('js')
	<script>
		function hapus_produk(produk_id){
			$.ajax({
				url: "/c/update",
				type: "post",
				data: { _token: '{{ csrf_token() }}',
                		produk_id: produk_id },
        		success: function(html){
        			$('#tr-'+produk_id).fadeOut("slow")
        			setTimeout(hapus_pro, 2000)
        			function hapus_pro() {
        				$('#tr-'+produk_id).remove()
        			}
        			$(".h5").fadeOut("slow")
        			setTimeout(h5, 500)
        			function h5() {
	        			let unitPrice 	= $("#subtotal-"+produk_id).val()
	        			let tot 		= $("#tot").val()
	        			let price 		= tot - unitPrice
					    $("#tot").val(price)
					    let	number_string = price.toString(),
							sisa 	= number_string.length % 3,
							rupiah 	= number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						$(".h5").text("Rp. "+rupiah)
						$(".h5").fadeIn("slow")

						let to = $("#tot").val()
						if (parseInt(to) == 0) {
							$('#tbody').remove()
							$('.table').append('<tbody id="tbody"></tbody>')
							$('#tbody').fadeOut('slow')
							setTimeout(tbodyAppend, 500)
							function tbodyAppend() {
								$('#tbody').append('<tr><td colspan="5"><center>Tidak ada belanjaan</center></td></tr>')
								$('#tbody').fadeIn('slow')
							}
						}
					}
                }
			})
		}

		function increment_quantity(produk_id) {
			let inputQuantityElement = $("#sst"+produk_id)
			let newQuantity = parseInt($(inputQuantityElement).val())+1
			let unitPrice = $("#harga-"+produk_id).val()
			let to = parseInt($("#tot").val())
			let inputTotal = parseInt(unitPrice)+to
			update_to_cart(produk_id, newQuantity, inputTotal)
		}

		function decrement_quantity(produk_id) {
		    let inputQuantityElement = $("#sst"+produk_id)
		    if($(inputQuantityElement).val() > 1) 
		    {
			    let newQuantity = parseInt($(inputQuantityElement).val()) - 1
			    let unitPrice = $("#harga-"+produk_id).val()
				let to = parseInt($("#tot").val())
				let inputTotal = to-parseInt(unitPrice)
			    update_to_cart(produk_id, newQuantity, inputTotal)
		    }
		}

		function update_to_cart(produk_id, new_quantity, inputTotal) {
			$("#h5-subtotal-"+produk_id).fadeOut("slow")
			$("#total").fadeOut("slow")
			let inputQuantityElement = $("#sst"+produk_id)
			let unitPrice = $("#harga-"+produk_id).val()
		    let price = unitPrice * new_quantity
		    let	number_string = price.toString(),
				sisa 	= number_string.length % 3,
				rupiah 	= number_string.substr(0, sisa),
				ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
			
			$("#tot").val(inputTotal)
			if (ribuan) {
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

		    $.ajax({
				url : "/c/qty",
				data : { _token: '{{ csrf_token() }}',
						id_produk: produk_id,
	                	new_quantity: new_quantity },
				type : 'post',
				success : function(response) {
					$(inputQuantityElement).val(new_quantity)
		            $("#h5-subtotal-"+produk_id).text("Rp. "+rupiah)
		            $("#h5-subtotal-"+produk_id).fadeIn("slow")
		            $("#subtotal-"+produk_id).val(price)
		            let totalItemPrice = 0;
		            $("input[id*='subtotal-']").each(function() {
		                let cart_price = $(this).val()
		                total = parseInt(totalItemPrice) + parseInt(cart_price)
		                let t = [cart_price]

		                let	number_string = inputTotal.toString(),
							sisa 	= number_string.length % 3,
							rupiah 	= number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.')
						}
		            $("#total").text("Rp. "+rupiah)
		            $("#total").fadeIn("slow")
		            })
				}
			})
		}

		function hapusCart() {
			$.ajax({
				url : "/c/remove",
				data : { _token: '{{ csrf_token() }}'},
				type : 'post',
				success : function(response) {
					$('#tbody').fadeOut('slow')
					$(".h5").fadeOut("slow")
					setTimeout(tbody, 500)
        			function tbody() {
	        			let price 		= 0
					    $("#tot").val(price)
					    let	number_string = price.toString(),
							sisa 	= number_string.length % 3,
							rupiah 	= number_string.substr(0, sisa),
							ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
								
						if (ribuan) {
							separator = sisa ? '.' : '';
							rupiah += separator + ribuan.join('.');
						}
						$(".h5").text("Rp. "+rupiah)
						$(".h5").fadeIn("slow")

						let to = $("#tot").val()
						$('#tbody').remove()
						$('.table').append('<tbody id="tbody"></tbody>')
						$('#tbody').fadeOut('slow')
						setTimeout(tbodyAppend, 500)
						function tbodyAppend() {
							$('#tbody').append('<tr><td colspan="5"><center>Tidak ada belanjaan</center></td></tr>')
							$('#tbody').fadeIn('slow')
						}
        			}
				}
			})
		}
	</script>
@endsection