@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('content')
    <div class="page-header">
        <h1>Changing user {{ $userdata->name }}'s mail</h1>
    </div>
    <p class="text-error">(demo) Mail sending feature is not yet implemented, this is not a safe approach for changing the email.</p>

    <p>
        Adresa curenta de email: <b>{{ $userdata->user_email  }}</b>
    </p>
    {!! Form::open(array('url' => '/user/changemail/done/'.$userdata->id.'')) !!}

    {!! Form::label('new_email', 'Noua adresa de email:') !!}
    {!! Form::email('new_email', '', ['class' => 'form-control']) !!}
    {!! Form::label('c_password', 'Parola curenta:') !!}
    {!! Form::password('c_password', ['class' => 'form-control']) !!}
    <br>
    {!! Form::submit('Schimba mail', ['class' => 'btn btn-grey btn-small']) !!}
    {!! Form::close() !!}
@endsection
