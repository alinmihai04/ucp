@extends('layout.main', ['title' => 'Vehicle '.$data->id])

@section('content')
<div class="page-header">
	<h1>Manage vehicle {{$data->id}}</h1>
</div>
<div class="row-fluid">
	<div class="span1">
		<img src="{{url('/images/vehicles/Vehicle_'.$data->vehicle_model)}}.jpg">
	</div>
	<div class="span4">
		<ul>
			<li>Vehicle ID: {{$data->id}}</li>
			<li>Vehicle model: {{App\Vehicle::$namevehicles[$data->vehicle_model]}} ({{$data->vehicle_model}})
			<li>Vehicle current owner: <a href="{{url('/profile/'.$data->vehicle_owner)}}">{{$data->vehicle_owner}}</a></li>
			<li>Age: {{$data->vehicle_days}} days</li>
			<li>Distance: {{$data->vehicle_km}} KM</li>
			<li>Mods: {{$data->vehicle_mods}}</li>
		</ul>
	</div>
	<h4>Links</h4>
	<ul>
		<li><a href="{{url('/logs/vehicle/'.$data->id)}}">vehicle logs</a></li>
	</ul>
</div>
@endsection