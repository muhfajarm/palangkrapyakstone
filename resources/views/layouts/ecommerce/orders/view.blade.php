@extends('layouts.dashboard')

@section('title')
    Order {{ $order->invoice }}
@endsection

@section ('content')
	<section class="login_box_area p_120">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">
					@include('layouts.ecommerce.module.sidebar')
				</div>
				<div class="col-md-9">
          <div class="row">
						<div class="col-md-12">
							<div class="card">
                <div class="card-header">
                    <h4 class="card-title float-left">Data Pelanggan</h4>
                    @if ($order->status == 'pending')
                      <button class="btn btn-success btn-sm float-right" onclick="snap.pay('{{ $order->snap_token }}')">Selesaikan Pembayaran</button>
                    @endif
                </div>
								<div class="card-body">
									<table>
                    <tr>
                        <td width="30%">InvoiceID</td>
                        <td width="5%">:</td>
                        <th>
                          @if ($order->status != 'pending')
                            <a href="{{ route('customer.order_pdf', $order->invoice) }}" target="_blank"><strong>{{ $order->invoice }}</strong></a>
                          @else
                            <strong>{{ $order->invoice }}</strong>
                          @endif
                        </th>
                    </tr>
                    <tr>
                        <td width="30%">Nama Lengkap</td>
                        <td width="5%">:</td>
                        <th>{{ $order->pelanggan_nama }}</th>
                    </tr>
                    <tr>
                        <td>No Telp</td>
                        <td>:</td>
                        <th>{{ $order->pelanggan_no_hp }}</th>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <th>{{ $order->pelanggan_alamat }}, {{ $order->city->title }}, {{ $order->city->province->title }}</th>
                    </tr>
                  </table>
								</div>
							</div>
						</div>
						{{-- <div class="col-md-6">
							<div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Pembayaran

                        @if ($order->status == 0)
                        <a href="{{ route('customer.paymentForm', $order->invoice) }}" class="btn btn-primary btn-sm float-right">Konfirmasi</a>
                        @endif
                    </h4>
                </div>
								<div class="card-body">
                  @if ($order->payment)
									<table>
                      <tr>
                          <td width="30%">Nama Pengirim</td>
                          <td width="5%"></td>
                          <td>{{ $order->payment->nama }}</td>
                      </tr>
                      <tr>
                          <td>Tanggal Transfer</td>
                          <td></td>
                          <td>{{ $order->payment->tgl_transfer }}</td>
                      </tr>
                      <tr>
                          <td>Jumlah Transfer</td>
                          <td></td>
                          <td>{{ formatRupiah($order->payment->jumlah) }}</td>
                      </tr>
                      <tr>
                          <td>Tujuan Transfer</td>
                          <td></td>
                          <td>{{ $order->payment->transfer_ke }}</td>
                      </tr>
                      <tr>
                          <td>Bukti Transfer</td>
                          <td></td>
                          <td>
                              <img src="{{ asset('storage/payment/' . $order->payment->bukti) }}" width="50px" height="50px" alt="">
                              <a href="{{ asset('storage/payment/' . $order->payment->bukti) }}" target="_blank">Lihat Detail</a>
                          </td>
                      </tr>
                  </table>
                  @else
                  <h4 class="text-center">Belum ada data pembayaran</h4>
                  @endif
								</div>
							</div>
              </div> --}}
              <div class="col-md-12 mt-4">
                  <div class="card">
                      <div class="card-header">
                          <h4 class="card-title">Detail</h4>
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th>Nama Produk</th>
                                          <th>Harga</th>
                                          <th>Jumlah</th>
                                          <th>Berat</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @forelse ($order->details as $row)
                                      <tr>
                                          <td>{{ $row->produk->nama }}</td>
                                          <td>{{ formatRupiah($row->harga) }}</td>
                                          <td>{{ $row->jumlah }} Item</td>
                                          <td>{{ $row->berat }} Kg</td>
                                      </tr>
                                      @empty
                                      <tr>
                                          <td colspan="4" class="text-center">Tidak ada data</td>
                                      </tr>
                                      @endforelse
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('snap')
  <script src="{{ !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
  <script>
    function (data, status) {
            snap.pay(data.snap_token, {
                // Optional
                onSuccess: function (result) {
                    location.reload();
                },
                // Optional
                onPending: function (result) {
                    location.reload();
                },
                // Optional
                onError: function (result) {
                    location.reload();
                }
            });
        };
        return false;
  </script>
@endsection