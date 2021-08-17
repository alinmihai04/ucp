@extends('layout.main', ['title' => 'Account security'])

@section('content')
<div class="page-header">
	<h1>Autentificare in doi pasi</h1>
</div>
<div class="span12 center">
	<p>
		Contul tau are activata optiunea de Autentificare in doi pasi.<br>
		Nu vei putea folosi nicio functie a site-ului pana nu introduci codul de autentificare.<br>
		Introdu codul oferit de aplicatia 'Google Authenticator' mai jos:<br>
	</p>

	{!! Form::open(['url' => url('/2fa/login')]) !!}
	{!! Form::label('2fa_code', 'Codul din 6 cifre oferit de aplicatie (ex: 545654)') !!}
	{!! Form::text('2fa_code', '') !!}
	<br>
	{!! Form::submit('Login', ['class' => 'btn btn-small btn-success']) !!}
	{!! Form::close() !!}
</div>

@endsection