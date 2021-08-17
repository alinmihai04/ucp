@extends('layout.main', ['title' => 'Login'])

@section('breadcrumb')
    <i class="icon-angle-right"></i>
    <li class="active">Login</li>
@endsection


@section('content')
<center>
    <h3>{{ config('app.title') }} login</h3>

    {!! Form::open(['url' => route('login')]) !!}
    {!! Form::label('name', 'Username:') !!}
    {!! Form::text('name') !!}
    {!! Form::label('password', 'Password:') !!}
    {!! Form::password('password') !!}
    <br>
    {!! Form::submit('login', ['class' => 'btn btn-inverse']) !!}
    {!! Form::close() !!}

    <br><br>
    Forgot your password? Click <a href="{{ url('/recover') }}">here</a>!
</center>
@endsection
