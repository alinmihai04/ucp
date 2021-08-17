@extends('layout.main', ['title' => 'Search Player'])


@section('content')
@if(!$queried)
	<center>
		{!! Form::open(['url' => '/search']) !!}
		{!! Form::label('sname', 'Player name:') !!}
		{!! Form::text('sname', '', ['class' => 'form-control']) !!}<br>
		{!! Form::submit('Search', ['class' => 'btn btn-inverse']) !!}
		{!! Form::close() !!}
	</center>
@else
	@foreach($data as $p)
		({{$p->id}}) <a href="{{url('/profile/'.$p->name.'')}}">{{$p->name}}</a> - level {{$p->user_level}}<br>
	@endforeach
@endif
@endsection