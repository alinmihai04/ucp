@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('content')
<h1>Force player to change his nickname</h1>
<p>Jucatorul va fii obligat sa isi schimbe numele la urmatoare logare pe server</p>

{!! Form::open(array('url' => '/admin/fnc/'.$user.'')) !!}

{!! Form::label('reason', 'Reason for /fnc:') !!}
{!! Form::text('reason', '', ['class' => 'form-control']) !!}
<br>
{!! Form::submit('Force Nickname Change', ['class' => 'btn btn-purple btn-small']) !!}
{!! Form::close() !!}
@endsection