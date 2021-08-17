@extends('layout.main', ['title' => 'Group skins'])

@section('content')

<div class="page-header">
	<h1>
		Editing group {{ $group }} skins
	</h1>
</div>

@foreach($data as $d)
<ul style="display: inline-block;">
	<li>
		Skin {{ $d->skin_id }} 
		<a href="{{ url('/group/skins/remove/' . $group . '/' . $d->skin_id) }}" onclick="return confirm('Esti sigur ca vrei sa stergi acest skin?');">
			<i class="icon-trash red"></i>
		</a>
		<br>
		<img src="{{url('/images/userbar_skins/Skin_' . $d->skin_id . '.png')}}" alt="{{ $d->skin_id }}">
	</li>
</ul>
@endforeach

<hr>

{!! Form::open(['url' => '/group/skins/add/' . $group]) !!}
	{!! Form::label('skin', 'Add a new skin') !!}
	{!! Form::number('skin', '', ['placeholder' => 'Skin id (ex: 103)']) !!}				
	<br>
	{!! Form::submit('Add skin', ['class' => 'btn btn-small btn-success']) !!}
{!! Form::close() !!}

@endsection