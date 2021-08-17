@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('content')
<h1>Set admin function</h1>
<p>Modificarile vor aparea pe profilul jucatorului si pe pagina 'Staff'.<br>
Scrie '<b>(null)</b>' pentru a sterge functia jucatorului.</p>

{!! Form::open(array('url' => '/admin/func/'.$user.'')) !!}

{!! Form::label('func', 'Current admin function:') !!}
{!! Form::text('func', $text, ['class' => 'form-control']) !!}
<br>
{!! Form::submit('Edit function', ['class' => 'btn btn-purple btn-small']) !!}
{!! Form::close() !!}
@endsection