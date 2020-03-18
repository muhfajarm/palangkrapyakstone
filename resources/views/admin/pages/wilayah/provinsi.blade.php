@extends('admin.dashboard')

@section('title', 'Provinsi')

@section('header')
	<h1>Provinsi</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{ url('/admin') }}">
				<i class="fa fa-dashboard"></i>Admin
			</a>
		</li>
	    <li class="active">Provinsi</li>
	</ol>
@stop

@section ('content')
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Semua Provinsi</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="tabellte">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Provinsi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 0;?>
						@foreach ($provinces as $province)
						<?php $no++ ;?>
							<tr>
								<td>{{ $no }}</td>
								<td>{{ $province->title }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection