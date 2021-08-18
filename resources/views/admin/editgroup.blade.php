@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('content')
    @if($editAttr == 'slots')
        <div class="page-header">
            <h1>Editing group {{ $group->group_name }} slots (current: {{ $group->group_slots }})</h1>
        </div>

        {!! Form::open(array('url' => '/admin/groupslots/'.$group->group_id.'')) !!}

        {!! Form::label('slots', 'New group slots:') !!}
        {!! Form::number('slots', '', ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit('Change slots', ['class' => 'btn btn-purple btn-small']) !!}
        {!! Form::close() !!}
    @else
        <div class="page-header">
            <h1>Editing group {{ $group->group_name }} level (current: {{ $group->group_level }})</h1>
        </div>

        {!! Form::open(array('url' => '/admin/grouplevel/'.$group->group_id.'')) !!}

        {!! Form::label('level', 'New group level:') !!}
        {!! Form::number('level', '', ['class' => 'form-control']) !!}
        <br>
        {!! Form::submit('Change level', ['class' => 'btn btn-purple btn-small']) !!}
        {!! Form::close() !!}
    @endif
@endsection
