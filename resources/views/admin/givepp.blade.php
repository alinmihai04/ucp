@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('content')
<center>
	<h4>Give PP to player</h4>
	<p>Pentru a se retrage pp-urile de pe cont, se introduce valoarea negativa</p>
	{!! Form::open(['url' => '/admin/givepp/' . $user]) !!}
	{!! Form::label('amount', 'Amount:') !!}
	{!! Form::text('amount') !!}
	<br>
	{!! Form::submit('Give PP', ['class' => 'btn btn-inverse']) !!}
	{!! Form::close() !!}
</center>
@endsection