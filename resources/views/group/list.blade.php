@extends('layout.main', ['title' => 'Faction List'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">Faction List</li>
@endsection

@section('content')
<div class="page-header">
	<h1>Lista Factiuni</h1>
</div>
<h4><a href="{{url('/logs/raport')}}">Raport processing history </a></h4>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th class="center">ID</th>
			<th>Nume</th>
			<th class="hidden-480">Membri</th>
			<th class="hidden-100">Optiuni</th>
			<th class="hidden-100">Status Aplicatie</th>
			<th class="center">Level Necesar</th>
		</tr>
	</thead>
	<tbody>
		@foreach($groupdata as $g)
			<tr>
				<td class="center">
					{{ $g->group_id }}
				</td>
				<td>
					{{$g->group_name}}
				</td>
				<td class="hidden-480">
					{{ $g->group_members }}/{{ $g->group_slots }}
				</td>
				<td class="hidden-100">
					<a href="{{url('/group/members/' . $g->group_id)}}">members</a> / <a href="{{ url('/group/logs/'.$g->group_id) }}">logs</a> / <a href="{{ url('/group/applications/' . $g->group_id) }}">applications</a> / <a href="{{ url('/group/complaints/' . $g->group_id) }}">complaints</a>
				</td>
				<td class="hidden-100">
					@if($g->group_application == 0)
						<span class='text-error'>Aplicatii inchise</span>
					@else
						@if(is_object($me) && $me->user_group >= 1)
							Aplicatii deschise
						@else
							<a class='btn btn-small btn-success' href='{{ url('/group/apply/' . $g->group_id) }}'>Aplica!</a>
						@endif
					@endif
				</td>
				<td class="center">{{ $g->group_level }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@endsection
