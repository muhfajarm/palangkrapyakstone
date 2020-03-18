@extends('admin.dashboard')

@section('title', 'Kota/Kabupaten')

@section('header')
	<h1>Kota/Kabupaten</h1>
	<ol class="breadcrumb">
		<li>
			<a href="{{ url('/admin') }}">
				<i class="fa fa-dashboard"></i>Admin
			</a>
		</li>
	    <li class="active">Kota/Kabupaten</li>
	</ol>
@stop

@section ('content')
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Semua Kota/Kabupaten</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="tabellte">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Kota/Kabupaten</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 0;?>
						@foreach ($cities as $city)
						<?php $no++ ;?>
							<tr>
								<td>{{ $no }}</td>
								<td>{{ $city->title }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection