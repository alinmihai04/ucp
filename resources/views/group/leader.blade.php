@extends('layout.main', ['title' => 'Leader Panel: ' . $data->group_name])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">
		Leader Panel: {{ $data->group_name }}
	</li>
@endsection

@section('content')

<div class="page-header">
	<h1>{{ $data->group_name }}</h1>
</div>
<span class="text-error">APPLICATIONS ARE NOT IMPLEMENTED!!!</span><br>
<ul>
	<li>

		@if($data->group_application == 1)
			<a href="{{ url('/group/app/' . $data->group_id) }}" onclick="return confirm('Esti sigur ca vrei sa inchizi aplicatiile?');">Inchide aplicatii</a>
		@else
			<a href="{{ url('/group/app/' . $data->group_id) }}" onclick="return confirm('Esti sigur ca vrei sa deschizi aplicatiile?');">Deschide aplicatii</a>
		@endif
	</li>
	@if($me->user_grouprank >= 7)
		<li>
			<a href="{{ url('/group/quest/' . $data->group_id) }}">Modifica intrebari aplicatie</a>
		</li>
	@endif
</ul>
<hr>

Faction complaints: <a href="{{ url('/group/complaints/' . $data->group_id) }}">{{ $complaints }} complaints pending</a><br />
Faction applications: <a href="{{ url('/group/applications/' . $data->group_id) }}">{{ $applications }} applications pending</a>

@endsection
