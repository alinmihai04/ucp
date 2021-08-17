@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('content')
<h1>Edit Faction History line</h1>
<p>Modificarile vor aparea pe profilul jucatorului si pe pagina principala.<br></p>

{!! Form::open(array('url' => '/admin/editfh/'.$user.'/'.$fh)) !!}

{!! Form::label('fh', 'Current text:') !!}
{!! Form::text('fh', $text, ['class' => 'span6']) !!}
<br>
{!! Form::submit('Edit FH', ['class' => 'btn btn-purple btn-small']) !!}
{!! Form::close() !!}
@endsection