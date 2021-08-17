@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li>
		<a href="{{ url('/raport/' . $group) }}">View raport</a>
	</li>
	<i class="icon-angle-right"></i>
	<li class="active">
		Edit raport
	</li>
@endsection

@section('content')
<div class="page-header">
	<h1>Editing raport activity for rank {{ $rank }}</h1> 
</div>

<ul>
@foreach($goals->where('rank', '=', $rank) as $g)
	<li>
		{{ ucfirst(trans('goals.' . $g->type)) }}: 
		{{ $g->goal }} 
		<a href="{{ url('/goal/edit/' . $g->id) }}"><i class="icon-edit red"></i></a> 
		<a href="{{ url('/goal/delete/' . $g->id) }}" onclick="return confirm('Esti sigur?');"><i class="icon-remove red"></i></a>
	</li>
@endforeach
</ul>
<h4>Add goal</h4>

{!! Form::open(['url' => '/goal/add/' . $group . '/' . $rank]) !!}
	<select name="goaltype">
		@for($i = 1; $i <= 13; $i++)
			<option value="{{ $i }}">{{ ucfirst(trans('goals.' . $i)) }}</option>
		@endfor
	</select> 
	<br>
	{!! Form::label('amount', 'Goal amount:') !!}
	{!! Form::text('amount', '') !!}				
	<br>
	{!! Form::submit('Add goal', ['class' => 'btn btn-small btn-primary']) !!}
{!! Form::close() !!}

</ul>

@endsection