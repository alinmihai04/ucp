@extends('layout.main', ['title' => 'Login'])

@section('breadcrumb')
    <i class="icon-angle-right"></i>
    <li class="active">Login</li>
@endsection


@section('content')
    <div class="span12 center">
    <h3>{{ config('app.title') }} login</h3>

    {!! Form::open(['url' => route('login')]) !!}
    {!! Form::label('name', 'Username:') !!}
    {!! Form::text('name') !!}
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password') !!}

    <div class="checkbox">
        <label>
            {!! Form::checkbox('force_2fa', 'enabled', false, ['class'=>'ace ace-checkbox-2']) !!}
            <span class="lbl"> Check to force 2 factor auth (if enabled) </span>
        </label>
    </div>
    <br>

    {!! Form::submit('login', ['class' => 'btn btn-inverse']) !!}
    {!! Form::close() !!}
    </div>

@endsection
