{{-- Loading Page --}}
<script>
    var myVar;

    function myFunction() {
        myVar = setTimeout(showPage, 500);
    }

    function showPage() {
        document.getElementById("loader").style.display = "none";
        document.getElementById("myDiv").style.display = "block";
    }
</script>
{{-- Loading Page --}}

{{-- Popover Cart--}}
<script>
	$(document).ready(function() {
	    $('#shoppingcart').popover({
	    	html : true,
            container: 'body',
            content:function(){
            	return $('#popover_content_cart').html();
            }
        })
	})

    load_product();

    function load_product()
    {
        $.ajax({
        url:"/api/getPopover",
        method:"GET",
        success:function(data)
        {
            $('#cart_details').html(data.cart_data);
        }
        })
    }
</script>
{{-- Popover Cart--}}

{{-- Popover Ongkir--}}
<script>
	$(document).ready(function() {
	    $('#popoverOngkir').popover({
	    	html : true,
            container: 'body',
            content:function(){
            	return $('#popoverOngkir_content_ongkir').html();
        	}
        })
	})
</script>
{{-- Popover Ongkir--}}

{{-- QTY --}}
	<script>
		function decrease_qty(id_produk){
			let inputQuantityElement = $("#jumlah")
			if($(inputQuantityElement).val()>1){
	            let newQuantity = parseInt($(inputQuantityElement).val())-1
	            update_input_qty(id_produk, newQuantity)
            }
		}

		function increase_qty(id_produk){
			let inputQuantityElement = $("#jumlah")
            let stok = $("#stok").val()
            if ($(inputQuantityElement).val()==stok) {
            	return
            }
            let newQuantity = parseInt($(inputQuantityElement).val())+1
            update_input_qty(id_produk, newQuantity)
		}

		function update_input_qty(id_produk, newQuantity){
			let inputQuantityElement = $("#jumlah")
			$(inputQuantityElement).val(newQuantity)
		}
	</script>
{{-- QTY --}}

{{-- AddtoCart --}}
<script>
	$(document).ready(function(){
		let imgsrc = $('#namagambar').attr('src')
		let imgpos = $('#namagambar').position()
		let imgsrcstyle = " width:420px;height:400px;position:absolute;opacity:0.8;display:none;left:"+imgpos.left+"px;top:"+imgpos.top+"px;z-index:99999;"
		let this_parent = $('#paren').parent()
		$('#tambahcart').on('click', function(){
			$('#tambahcart').attr('disabled', 'true')
			if (parseInt($('#jumlah').val())>parseInt($('#stok').val())) {
				alert('Mohon memasukkan jumlah sesuai dengan stok yang tersedia')
				location.reload()
			}else{
				$.ajax({
					url: "/addcart",
					type: "POST",
					data: {"_token": "{{ csrf_token() }}",
							"produk_id": $('#produk_id').val(),
							"produk_nama": $('#namaproduk').val(),
							"harga_produk": $('#hargaproduk').val(),
							"gambar_produk": $('#namagambar').val(),
							"berat": $('#beratproduk').val(),
							"jumlah": $('#jumlah').val(),
							"stok" : $('#stok').val(),
					},
					success: function(data){
						this_parent.append('<img src="'+imgsrc+'" style="'+imgsrcstyle+'" class="cloned" />')
						fly(data)
					},
					error: function (data) {
			            alert('Gagal menambah produk ke keranjang belanja!')
		            }
				})
			}
		})
		function fly(data){
			let box = $('#shoppingcart').position()
			$(".cloned").show().animate({
				"opacity": 0.2,"top":(box.top - 50),"left":(box.left - 140),"width":10, "height":10 
			} ,1000,function(){
					// $('.angkacart').append('<img src="/dist/img/ajax-loader.gif" id="ajax-loader">')
					// $( "#shoppingcart" ).remove()
					// $( "#angkacart" ).load(window.location.href + " #shoppingcart")
					// $( "#popover_content_wrapper" ).load(window.location.href + " #cart_details")
		        	$(this).remove()
					$('#tambahcart').removeAttr('disabled')
					load_product()
					function load_product()
				    {
				        $.ajax({
				        url:"/api/getPopover",
				        method:"GET",
				        success:function(data)
				        {
							let spanangka = parseInt($('#spanangka').text())
							let jumlah = parseInt($('#jumlah').val())
							let jum = parseInt(jumlah)
							let qtybaru = spanangka+jum
							$('#spanangka').text(qtybaru)
				            $('#cart_details').html(data.cart_data)
				        }
				        })
				    }
		        })
		}
	})
</script>
{{-- AddtoCart --}}

{{-- Ongkir --}}
<script>
    $(document).ready(function() {
        $('#province_destination').on('change', function() {
        	$('#city_destination').attr('disabled', 'true')
        	$('#city_destination').empty()
        	$('#city_destination').append('<option value="">Memuat...</option>')
        	$('#kurir').empty()
        	$('#kurir').attr('disabled', 'true')
        	$('#kurir').append('<option value="">Pilih Ekspedisi</option>')
        	$('#popoverOngkir_content_wrapper').empty()
        	$('#popoverOngkir_content_wrapper').append('<center><h3>Silahkan pilih kurir</h3><center>')

        	$.ajax({
                url: "{{ url('/api/cityF') }}",
                type: "GET",
                data: { province_id: $(this).val() },
                success: function(html){
                    //SETELAH DATA DITERIMA, SELEBOX DENGAN ID CITY_ID DI KOSONGKAN
                    $('#city_destination').empty()
                    //KEMUDIAN APPEND DATA BARU YANG DIDAPATKAN DARI HASIL REQUEST VIA AJAX
                    //UNTUK MENAMPILKAN DATA KABUPATEN / KOTA
		        	$('#city_destination').removeAttr('disabled')
                    $('#city_destination').append('<option value="">Pilih Kabupaten/Kota</option>')
                    $.each(html.data, function(key, item) {
                        $('#city_destination').append('<option value="'+item.id+'" namakota="' +item.id+ '">'+item.title+'</option>')
                    })
                }
            })
        })
        $('#city_destination').on('change', function() {
        	$('#kurir').empty()
		    $('#kurir').append('<option value="">Memuat...</option>')
		    $('#kurir').attr('disabled', 'true')
        	$('#popoverOngkir_content_wrapper').empty()
        	$('#popoverOngkir_content_wrapper').append('<center><h3>Silahkan pilih kurir</h3><center>')

        	$.ajax({
        		url: "{{ url('/api/costF') }}",
                type: "GET",
                // data: { },
                success: function(html){
                	$('#kurir').empty()
		        	$('#kurir').removeAttr('disabled')
		            $('#kurir').append('<option value="">Pilih Ekspedisi</option>')
		            $.each(html, function(key, item) {
                        $('#kurir').append('<option value="'+item.title+'" namakurir="'+item.code+'">'+item.title+'</option>')
                    })
                }
        	})
        	let namakotaku = $("#city_destination option:selected").attr("namakota")
        	$("#kota_tujuan").val(namakotaku)
        })
		$('#kurir').on('change', function(){
			let namakurirku = $("#kurir option:selected").attr("namakurir")
			let berat = $('#berat').attr("value")
			$("#namakurir").val(namakurirku)
			$('#popoverOngkir').append('<img src="/dist/img/ajax-loader.gif" id="ajax-loader">')
        	$('#popoverOngkir_content_ongkir').empty()
        	$('#popoverOngkir_content_ongkir').append('<center><h3>Silahkan pilih kurir</h3><center>')

			let origin = 196
			let destination = $("input[name=kota_tujuan]").val()
			let courier = $("input[name=namakurir]").val()
			let weight = berat

			if(courier){
				jQuery.ajax({
					url:"/origin="+origin+"&destination="+destination+"&weight="+weight+"&courier="+courier,
					type:'post',
					dataType:'json',
					data: {"_token": "{{ csrf_token() }}"},
					success:function(data){
						let img = document.getElementById("ajax-loader")
						popoverOngkir.removeChild(img)
						$('#popoverOngkir_content_ongkir').empty()
						$('#popoverOngkir_content_ongkir').append('<div id="popoverInfo">')
							$('#popoverInfo').append('<center><h3>'+$("#kurir option:selected").val()+'</h3><center>')
							$('#popoverInfo').append('<table id="popoverTable" class="table table-sm">')
								$('#popoverTable').append('<thead id="popover-head-tr">')
									$('#popover-head-tr').append('<tr id="popover-head-th">')
										$('#popover-head-th').append('<th scope="col">Servis')
										$('#popover-head-th').append('<th scope="col">Harga')
								$('#popoverTable').append('<tbody id="popover-body-tr">')
						// $('#card-layanan').append('<div id="card-h1" class="card w-auto shadow-sm">')
						// 	$('#card-h1').append('<center><h1>'+$("#kurir option:selected").val()+'</h1><center>')
						// 	$('#card-h1').append('<table id="card-table" class="table table-sm">')
						// 		$('#card-table').append('<thead id="card-head-tr">')
						// 			$('#card-head-tr').append('<tr id="card-head-th">')
						// 				$('#card-head-th').append('<th scope="col">Servis')
						// 				$('#card-head-th').append('<th scope="col">Harga')
						// 		$('#card-table').append('<tbody id="card-body-tr">')

						$.each(data, function(key, value){
							$.each(value.costs, function(key1, value1){
								$.each(value1.cost, function(key2, value2){
									$('#popover-body-tr').append('<tr><th id="popover-body-td">'+value1.service+'</th><td>Rp. '+value2.value+'</th>')
								})
							})
						})
					},
				})
			}
		})
    })
</script>
{{-- Ongkir --}}