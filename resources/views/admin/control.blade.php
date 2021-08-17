@extends('layout.main', ['title' => 'Admin Panel'])

@section('content')

<div class="span8">
	<div class="page-header">
		<h1>Admin Control Panel (for admin {{$me->user_admin}})</h1>
	</div>
	@if($me->user_admin >= 6)
		<ul>
			<li><a href="{{url('/admin/clearcache')}}" onclick="return confirm('Esti sigur ca vrei sa stergi cache-ul? Aceasta actiune va solicita baza de date.')">clear panel cache</a></li>
			<li><a href="{{ url('/admin/resetraport') }}">RESETEAZA RAPOARTELE DE ACTIVITATE (DEBUG)</a></li>
		</ul>
	@endif

	<br>
	<h3>Manage Factions</h3>
	<hr>
	@if($me->user_admin >= 6)	
		{!! Form::open(['url' => url('/raport/hours')]) !!}

		{!! Form::label('hours', 'Seteaza orele minime pentru raportul de activitate (se aplica pentru toate factiunile):') !!}
		{!! Form::text('hours', '', ['placeholder' => 'ex: 5']) !!}
		<br>
		{!! Form::submit('Seteaza ore', ['class' => 'btn btn-danger btn-small']) !!}
		{!! Form::close() !!}
	@endif
	@foreach($groupdata as $g)
		<h4> 
			@if($g->group_type == 1)
				<i class="icon-legal blue"></i>
			@elseif($g->group_type == 2)
				<i class="icon-bullseye red"></i>
			@elseif($g->group_type == 3)
				<i class="icon-dollar orange"></i>	
			@elseif($g->group_type == 4)
				<i class="icon-camera pink"></i>
			@elseif($g->group_type == 5)
				<i class="icon-suitcase green"></i>
			@elseif($g->group_type == 6)
				<i class="icon-bullseye purple"></i>	
			@elseif($g->group_type == 7)
				<i class="icon-ambulance red"></i>																									
			@endif
			{{ $g->group_name }} 
		</h4>
		<ul>
			<li>
				@if($g->group_application == 1)
					<a href="{{ url('/group/app/' . $g->group_id) }}">close applications</a>
				@else
					<a href="{{ url('/group/app/' . $g->group_id) }}">open applications</a>
				@endif
			</li>	
			@if($me->user_admin >= 3)			
				<li>
					<a href="{{ url('/admin/grouplevel/' . $g->group_id) }}">set minimum level ({{ $g->group_level }})</a>
				</li>				
				<li>
					<a href="{{ url('/admin/groupslots/' . $g->group_id) }}">set group slots ({{ $g->group_slots }})</a>
				</li>	
			@endif
			@if($me->user_admin >= 6)	
				<li>
					<a href="{{ url('/raport/' . $g->group_id) }}">edit raport</a>
				</li>
				<li>
					<a href="{{ url('/group/skins/' . $g->group_id) }}">edit group skins</a>
				</li>										
			@endif
		</ul>
	@endforeach
</div>

<div class="span4">
	<div class="page-header">
		<h1>Server Statistics</h1>		
	</div>	

	<h4>Logs Statistics - {{number_format($total)}} logs</h4>
	<hr>

	<ul>
		<li>Player Logs - <b>{{number_format($player_logs)}}</b> logs, <b>{{ number_format((($player_logs/$total) * 100)) }}%</b> from total</li>
		<li>Chat Logs - <b>{{number_format($chat_logs)}}</b> logs, <b>{{ number_format((($chat_logs/$total) * 100)) }}%</b> from total</li>
		<li>Kill Logs - <b>{{number_format($kill_logs)}}</b> logs, <b>{{ number_format((($kill_logs/$total) * 100)) }}%</b> from total</li>
		<li>IP Logs - <b>{{number_format($ip_logs)}}</b> logs, <b>{{ number_format((($ip_logs/$total) * 100)) }}%</b> from total</li>
		<li>Punish Logs - <b>{{number_format($punish_logs)}}</b> logs, <b>{{ number_format((($punish_logs/$total) * 100)) }}%</b> from total</li>
	</ul>	
</div>

@endsection