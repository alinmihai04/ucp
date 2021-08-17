@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('content')
<h1>Set user note</h1>
<p>Notitele pentru un jucator pot fi vizualizate doar de catre un admin 5+. <br>
Scrie '<b>(null)</b>' pentru a sterge notitele de pe profilul jucatorului.</p>

{!! Form::open(array('url' => '/admin/note/'.$user.'')) !!}

{!! Form::label('note', 'Current user note:') !!}
{!! Form::textarea('note', $text, ['rows' => 7, 'style="width: 500px; resize: none;"']) !!}
<br>
{!! Form::submit('Edit note', ['class' => 'btn btn-info btn-small']) !!}
{!! Form::close() !!}
@endsection