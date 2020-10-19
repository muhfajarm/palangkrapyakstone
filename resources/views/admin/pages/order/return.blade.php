@extends('admin.dashboard')

@section('title', 'Detail Pesanan')

@section('header')
    <h1>Detail Return</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ url('/admin') }}">
                <i class="fa fa-dashboard"></i>Admin
            </a>
        </li>
        <li>
            <a href="{{ url('/admin/order') }}">Orders</a>
        </li>
        <li class="active">Return</li>
    </ol>
@stop

@section ('content')
<main>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Detail Return
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Detail Pelanggan</h4>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Nama Pelanggan</th>
                                            <td>{{ $order->pelanggan_nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telp</th>
                                            <td>{{ $order->pelanggan_no_hp }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $order->pelanggan_alamat }}, {{  $order->pelanggan->city->title}}, {{ $order->pelanggan->city->province->title }}</td>
                                            {{-- <td>{{ $order->return->refund_transfer }}</td> --}}
                                        </tr>
                                        <tr>
                                            <th>Alasan Return</th>
                                            <td>{{ $order->return->reason }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{!! $order->return->status_label !!}</td>
                                        </tr>
                                    </table>
                                    @if ($order->return->status == 0)
                                    <form action="{{ route('orders.approve_return') }}" onsubmit="return confirm('Kamu Yakin?');" method="post">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <select name="status" class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option value="1">Terima</option>
                                                <option value="2">Tolak</option>
                                            </select>
                                            <div class="input-group-prepend">
                                                <button class="btn btn-primary btn-sm">Proses Return</button>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                    @if ($order->return->status == 1)
                                    <form action="{{ route('orders.shipping_return') }}" method="post">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <input type="text" name="tracking_number" placeholder="Masukkan Nomor Resi" class="form-control" required>
                                            <div class="input-group-prepend">
                                                <button class="btn btn-primary btn-sm">Kirim Return</button>
                                            </div>
                                        </div>
                                    </form>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h4>Foto Barang Return</h4>
                                    <img src="{{ asset('storage/return/' . $order->return->photo) }}" class="img-responsive" height="200" alt="">
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