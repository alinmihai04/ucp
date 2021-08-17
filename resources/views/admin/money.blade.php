@extends('layout.main', ['title' => "Admin Control Panel"])

@section('content')
<div class="page-header">
	<h1>
		Set Player Money
	</h1>
</div>

<p>Current - cash: <b>${{ number_format($cash) }}</b>, bank: <b>${{ number_format($bank) }}</b>
<p>Pentru a-i lua banii unui jucator, se introduce valoarea negativa.</p>

{!! Form::open(['url' => url('/admin/money/' . $user)]) !!}
{!! Form::label('money', 'Value:') !!}
{!! Form::text('money', '') !!}
<br>
{!! Form::submit('Edit money', ['class' => 'btn btn-inverse']) !!}
{!! Form::close() !!}
@endsection