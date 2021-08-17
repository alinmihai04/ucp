@extends('layout.main', ['title' => 'Houses'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">Houses</li>
@endsection

@section('content')
	<table class="table table-bordered table-condensed">
		<tbody>
			<tr class="info">
				<td>ID</td>
				<td>Owner</td>
				<td>Price</td>
				<td>Type</td>
				<td>Map</td>
			</tr>
		<tbody>
			@foreach($data as $house)
			<tr>
				<td>{{ $house->id }}</td>
				<td>
					@if($house->house_ownerid == 0)
						The State
					@else
						<a href="{{ url('/profile/' . $house->name) }}">{{ $house->name }}</a>
					@endif
				</td>
				<td>{{ $house->house_price == 0 ? 'not for sale' : $house->house_price }}</td>
				<td>
					@if($house->house_size == 1)
						Small
					@elseif($house->house_size == 2)
						Medium
					@elseif($house->house_size == 3)
						Large
					@endif
				</td>
				<td><a href="{{url('/map/' . $house->house_exterior_posX . '/' . $house->house_exterior_posY)}}"><i class="icon-map-marker"></i> display on map</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
@endsection