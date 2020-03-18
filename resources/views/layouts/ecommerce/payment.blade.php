@extends('layouts.dashboard')

@section('title')
    Konfirmasi Pembayaran
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
<section class="login_box_area p_120">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					@include('layouts.ecommerce.module.sidebar')
				</div>
				<div class="col-md-9">
                    <div class="row">
						<div class="col-md-12">
							<div class="card">
                <div class="card-header">
                    <h4 class="card-title">Konfirmasi Pembayaran</h4>
                </div>
<div class="card-body">
                    <form action="{{ route('customer.savePayment') }}" enctype="multipart/form-data" method="post">
                        @csrf

                        @if (session('success')) 
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error')) 
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="form-group">
                            <label for="">Invoice ID</label>
                            <input type="text" name="invoice" class="form-control" value="{{ request()->invoice }}" required>
                            <p class="text-danger">{{ $errors->first('invoice') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Pengirim</label>
                            <input type="text" name="nama" class="form-control" required>
                            <p class="text-danger">{{ $errors->first('nama') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Transfer Ke</label>
                            <select name="transfer_ke" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="BCA - 1234567">BCA: 1234567 a.n Anugrah Sandi</option>
                                <option value="Mandiri - 2345678">Mandiri: 2345678 a.n Anugrah Sandi</option>
                                <option value="BRI - 9876543">BCA: 9876543 a.n Anugrah Sandi</option>
                                <option value="BNI - 6789456">BCA: 6789456 a.n Anugrah Sandi</option>
                            </select>
                            <p class="text-danger">{{ $errors->first('transfer_ke') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Jumlah Transfer</label>
                            <input type="number" name="jumlah" class="form-control" required>
                            <div class="alert alert-info">
                                Jumlah yang harus ditransfer {{ formatRupiah($prices->subtotal) }}
                            </div>
                            <p class="text-danger">{{ $errors->first('jumlah') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Transfer</label>
                            <input type="text" name="tgl_transfer" id="transfer_date" class="form-control" required>
                            <p class="text-danger">{{ $errors->first('tgl_transfer') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="">Bukti Transfer</label>
                            <input type="file" name="bukti" class="form-control" required>
                            <p class="text-danger">{{ $errors->first('bukti') }}</p>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm">Konfirmasi</button>
                        </div>
                    </form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $('#transfer_date').datepicker({
            "todayHighlight": true,
            "setDate": new Date(),
            "autoclose": true
        });
    </script>
@endsection