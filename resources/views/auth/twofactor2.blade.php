@extends('layout.main', ['title' => 'Account security'])

@section('content')
<div class="page-header">
	<h1>Autentificare in doi pasi</h1>
</div>

<div class="span12 center">
	Scaneaza codul QR de mai jos pentru a activa autentificarea in 2 pasi<br>
	<img src="{{ $QR_Image }}"><br>
	Dupa ce ai scanat codul QR, introdu mai jos codul de securitate oferit de aplicatie pentru a finaliza activarea
	{!! Form::open(['url' => url('/2fa')]) !!}
	<br>
	{!! Form::label('verify-code', 'Codul de securitate:') !!}
	{!! Form::text('verify-code', '') !!}
	<br>
	{!! Form::submit('Valideaza codul', ['class' => 'btn btn-success btn-small']) !!}
	{!! Form::close() !!}
</div>
<h3>
	Cum se foloseste aplicatia?
</h3>
<hr>
<h4>
	<b>1. Apasa pe butonul '+' aflat in coltul din dreapta jos</b><br><br>
	<img src="{{ URL::asset('images/2fa.png') }}"><br><br>
	<b>2. Alege prima optiune (Scanati un cod de bare), apoi plasati camera pe codul QR de mai sus</b><br><br>
	<img src="{{ URL::asset('images/2fa1.png') }}"><br><br>
	<b>3. Daca totul a mers bine, contul tau va fi integrat in aplicatie</b><br><br>
	<img src="{{ URL::asset('images/2fa2.png') }}">		
</h4>
@endsection