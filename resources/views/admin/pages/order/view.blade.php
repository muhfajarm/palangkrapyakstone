@extends('admin.dashboard')

@section('title', 'Detail pesanan')

@section('header')
	<h1>Detail pesanan</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('/admin') }}">
                <i class="fa fa-dashboard"></i>Admin
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/order') }}">Orders</a>
        </li>
        <li class="active">View Order</li>
    </ol>
@stop

@section ('content')
<main>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Detail Pelanggan</h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Nama Pelanggan</th>
                                            <td>{{ $order->pelanggan_nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>No HP</th>
                                            <td>{{ $order->pelanggan_no_hp }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $order->pelanggan_alamat }} - {{  $order->pelanggan->city->title}}, {{ $order->pelanggan->city->province->title }}</td>
                                        </tr>
                                        <tr>
                                            <th>Order Status</th>
                                            <td>
                                                {!! $order->status_label !!}
                                                <!-- TOMBOL UNTUK MENERIMA PEMBAYARAN -->
                                                <!-- TOMBOL INI HANYA TAMPIL JIKA STATUSNYA 1 DARI ORDER DAN 0 DARI PEMBAYARAN -->
                                                @if ($order->status == 'success')
                                                <a href="{{ route('orders.approve_payment', $order->invoice) }}" class="btn btn-primary btn-sm" onsubmit="return confirm('Kamu Yakin?');">Proses Orderan</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($order->status == 'proses' || $order->status == 'dikirim')
                                        <tr>
                                            <th>Nomor Resi</th>
                                            <td>
                                                @if ($order->status == 'proses')
                                                <form action="{{ route('orders.shipping') }}" method="post">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <input type="text" name="tracking_number" placeholder="Masukkan Nomor Resi" class="form-control" required>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-secondary" type="submit">Kirim</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                @else
                                                {{ $order->tracking_number }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                                {{-- <div class="col-md-6">
                                    <h4>Detail Pembayaran</h4>
                                    @if ($order->status != 0)
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Nama Pengirim</th>
                                            <td>{{ $order->payment->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bank Tujuan</th>
                                            <td>{{ $order->payment->transfer_ke }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Transfer</th>
                                            <td>{{ $order->payment->tgl_transfer }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bukti Pembayaran</th>
                                            <td><a target="_blank" href="{{ asset('storage/payment/' . $order->payment->bukti) }}">Lihat</a></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{!! $order->payment->status_label !!}</td>
                                        </tr>
                                    </table>
                                    @else
                                    <h5 class="text-center">Belum Konfirmasi Pembayaran</h5>
                                    @endif
                                </div> --}}
                                <div class="col-md-12">
                                    <h4>Detail Produk</h4>
                                    <table class="table table-borderd table-hover">
                                        <tr>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Berat</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        @foreach ($order->details as $row)
                                        <tr>
                                            <td>{{ $row->produk->nama }}</td>
                                            <td>{{ $row->jumlah }}</td>
                                            <td>{{ formatRupiah($row->harga) }}</td>
                                            <td>{{ $row->berat }} gram</td>
                                            <td>{{ formatRupiah($row->jumlah * $row->harga) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3"></td>
                                            <th>Total</th>
                                            <td>{{ formatRupiah($order->subtotal) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection