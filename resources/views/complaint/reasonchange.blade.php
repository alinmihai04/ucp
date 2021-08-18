@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('content')
    <h1>Change complaint reason</h1>

    {!! Form::open(array('url' => '/complaint/reason/change/'.$topicID.'')) !!}

    <select name="reason">
        @if($user->user_group > 0)
            <option value="2">Factiune</option>
        @endif
        <option value="1">DM</option>
        <option value="3">Jigniri, injurii, limbaj vulgar</option>
        <option value="4">Inselatorie</option>
        <option value="5">Altceva (abuz, comportament non RP)</option>
        @if($user->user_admin > 0 || $user->user_helper > 0)
            <option value="6">Abuz admin/helper</option>
        @endif
        @if($user->user_grouprank == 7)
            <option value="7">Greseli ca lider</option>
        @endif
    </select>
    <br>
    {!! Form::submit('Change reason', ['class' => 'btn btn-purple btn-small']) !!}
    {!! Form::close() !!}
@endsection
