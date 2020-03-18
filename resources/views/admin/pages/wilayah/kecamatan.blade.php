@extends('admin.dashboard')

@section('title', 'Kecamatan')

@section('header')
	<h1>Kecamatan</h1>
@stop

@section ('content')
	<div class="box">
		<div class="box-header">
			<h3 class="box-title">Semua Kecamatan</h3>
		</div>
		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="tabellte">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Kecamatan</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 0;?>
						@foreach ($districts as $district)
						<?php $no++ ;?>
							<tr>
								<td>{{ $no }}</td>
								<td>{{ $district->nama }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection