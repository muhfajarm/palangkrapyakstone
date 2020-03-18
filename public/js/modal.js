// Modal User
$('#ModalEditUser').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var nama = button.data('btn_nama')
  var email = button.data('btn_email')
  var alamat = button.data('btn_alamat')
  var no_hp = button.data('btn_no_hp')
  var admin = button.data('btn_admin')
  var province = button.data('btn_province')
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #nama').val(nama)
  modal.find('.modal-body #email').val(email)
  modal.find('.modal-body #alamat').val(alamat)
  modal.find('.modal-body #no_hp').val(no_hp)
  modal.find('.modal-body #admin').val(admin)
  modal.find('.modal-body #province_id').val(province)
  modal.find('.modal-body #id').val(id)
})

$('#ModalHapusUser').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #id').val(id)
})

// Modal Kategori
$('#ModalEditKategori').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var nama = button.data('btn_nama')
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #nama').val(nama)
  modal.find('.modal-body #id').val(id)
})

$('#ModalHapusKategori').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #id').val(id)
})

// Modal Produk
$('#ModalEditProduk').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('input_id')
  var nama = button.data('btn_nama')
  var id_kategori = button.data('btn_id_kategori')
  var deskripsi = button.data('btn_deskripsi')
  var harga_beli = button.data('btn_harga_beli')
  var harga_jual_1 = button.data('btn_harga_jual_1')
  var harga_jual_2 = button.data('btn_harga_jual_2')
  var harga_jual_3 = button.data('btn_harga_jual_3')
  var stok = button.data('btn_stok')
  var berat = button.data('btn_berat')
  var gambar = button.data('btn_gambar')
  var dibeli = button.data('btn_dibeli')
  

  var modal = $(this)

  modal.find('.modal-body #id').val(id)
  modal.find('.modal-body #nama').val(nama)
  modal.find('.modal-body #category_id').val(id_kategori)
  modal.find('.modal-body #deskripsi').val(deskripsi)
  modal.find('.modal-body #harga_beli').val(harga_beli)
  modal.find('.modal-body #harga_jual_1').val(harga_jual_1)
  modal.find('.modal-body #harga_jual_2').val(harga_jual_2)
  modal.find('.modal-body #harga_jual_3').val(harga_jual_3)
  modal.find('.modal-body #stok').val(stok)
  modal.find('.modal-body #berat').val(berat)
  modal.find('.modal-body #pict').attr("src", "/storage/products/"+gambar)
  modal.find('.modal-body #dibeli').val(dibeli)
})

$('#ModalHapusProduk').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #id').val(id)
})

// Modal Kurir
$('#ModalEditKurir').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var nama = button.data('btn_nama')
  var kode = button.data('btn_kode')
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #nama').val(nama)
  modal.find('.modal-body #kode').val(kode)
  modal.find('.modal-body #id').val(id)
})

$('#ModalHapusKurir').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #id').val(id)
})

// Modal Order
$('#ModalEditOrder').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var nama_pelanggan = button.data('btn_nama_pelanggan')
  var provinsi_id = button.data('btn_provinsi_id')
  var kota_id = button.data('btn_kota_id')
  var kecamatan_id = button.data('btn_kecamatan_id')
  var alamat = button.data('btn_alamat')
  var jasa_pengiriman_id = button.data('btn_jasa_pengiriman_id')
  var no_hp = button.data('btn_no_hp')
  var email = button.data('btn_email')
  var status_order = button.data('btn_status_order')
  var tanggal_order = button.data('btn_tanggal_order')
  var jam_order = button.data('btn_jam_order')
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #nama_pelanggan').val(nama_pelanggan)
  modal.find('.modal-body #provinsi_id').val(provinsi_id)
  modal.find('.modal-body #kota_id').val(kota_id)
  modal.find('.modal-body #kecamatan_id').val(kecamatan_id)
  modal.find('.modal-body #alamat').val(alamat)
  modal.find('.modal-body #jasa_pengiriman_id').val(jasa_pengiriman_id)
  modal.find('.modal-body #no_hp').val(no_hp)
  modal.find('.modal-body #email').val(email)
  modal.find('.modal-body #status_order').val(status_order)
  modal.find('.modal-body #tanggal_order').val(tanggal_order)
  modal.find('.modal-body #jam_order').val(jam_order)
  modal.find('.modal-body #id').val(id)
})

$('#ModalHapusOrder').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #id').val(id)
})

// Modal Order Detail
$('#ModalEditOrderDetail').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var order_id = button.data('btn_order_id')
  var id_produk = button.data('btn_id_produk')
  var jumlah = button.data('btn_jumlah')
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #order_id').val(order_id)
  modal.find('.modal-body #produk_id').val(id_produk)
  modal.find('.modal-body #jumlah').val(jumlah)
  modal.find('.modal-body #id').val(id)
})

$('#ModalHapusOrderDetail').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var id = button.data('input_id')

  var modal = $(this)

  modal.find('.modal-body #id').val(id)
})