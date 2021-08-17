@extends('layout.main', ['title' => 'View Map'])

@section('content')
<div class="page-header">
	<h1>View map</h1>
</div>
<img src="{{url('/viewmap/'.$x.'/'.$y)}}">
@endsection