@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li>
		<a href="{{ url('/admin') }}">Admin panel</a>
	</li>
	<i class="icon-angle-right"></i>
	<li class="active">
		Edit goal
	</li>
@endsection

@section('content')
<div class="page-header">
	<h1>Editing raport activity</h1> 
</div>

{!! Form::open(['url' => '/goal/edit/' . $goal . '/' . $goals->group_id]) !!}
	{!! Form::label('amount', ucfirst(trans('goals.' . $goals->type))) !!}
	{!! Form::text('amount', $goals->goal) !!}				
	<br>
	{!! Form::submit('Submit', ['class' => 'btn btn-small btn-success']) !!}
{!! Form::close() !!}

@endsection