@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('content')
<div class="page-header">
	<h1>Adding raport activity for {{ $g->group_name }}</h1> 
</div>

{!! Form::open(['url' => url('/raport/add/' . $g->group_id)]) !!}
{!! Form::label('text', 'Activity text:') !!}
{!! Form::text('text', '', ['placeholder' => 'ex: Pacienti vindecati']) !!}
{!! Form::label('label', 'Activity type:') !!}
<select name="label">
	@for($i = 0; $i < sizeof(App\Group::$raport_labels); $i++)
		<option value="{{ $i }}">
			{{ App\Group::$raport_labels[$i] }}
		</option>
	@endfor
</select> 
<h4>
	Activity goal for every rank
</h4>
<br>

@for($i = 1; $i < 7; $i++)
	{!! Form::label('goal' . $i, 'Goal for rank ' . $i) !!}
	{!! Form::text('goal' . $i, '', ['placeholder' => 'rank ' . $i]) !!} <br>
@endfor

{!! Form::submit('Add activity', ['class' => 'btn btn-success btn-small']) !!}

{!! Form::close() !!}		

@endsection