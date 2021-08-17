@extends('layout.main', ['title' => 'Businesses'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">Businesses</li>
@endsection

@section('content')
	<table class="table table-bordered table-condensed">
		<tbody>
			<tr class="info">
				<td>ID</td>
				<td>Owner</td>
				<td>Price</td>
				<td>Biz fee</td>
				<td>Map</td>
			</tr>
		<tbody>
			@foreach($data as $biz)
			<tr>
				<td>{{ $biz->id }}</td>
				<td>
					@if($biz->biz_owner == 'The State')
						The State
					@else
						<a href="{{ url('/profile/' . $biz->name) }}">{{ $biz->name }}</a>
					@endif
				</td>
				<td>{{ $biz->biz_price == 0 ? 'not for sale' : $biz->biz_price }}</td>
				<td>{{ $biz->biz_fee }}</td>
				<td><a href="{{url('/map/' . $biz->biz_exterior_posX . '/' . $biz->biz_exterior_posY)}}"><i class="icon-map-marker"></i> display on map</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
@endsection