@extends('layout.main', ['title' => 'Clan: '.$data->clan_name])

@section('content')
<div class="page-header">
	<h1>Clan {{$data->clan_name}}</h1>
</div>

<div class="row-fluid">
	<div class="span3">
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-info"></i>
					Clan info
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					Name: {{$data->clan_name}}<br>
					Tag: {{$data->clan_tag}}<br>
					Members: {{ $members->count() }}/{{$data->clan_slots}}<br><br>
					Created at: <b>{{$data->clan_created}}</b><br>
					Expires at: <b>{{date('Y-m-d H:i:s', $data->clan_expire)}}</b>
				</div>
			</div>
		</div>
		<br>
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-info"></i>
					Clan forum
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<a href="#" class="btn btn-inverse btn-block">View clan forum</a>
				</div>
			</div>
		</div>
		<br>
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-info"></i>
					Clan ranks
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					1 - {{$data->clan_rankname1}}<br>
					2 - {{$data->clan_rankname2}}<br>
					3 - {{$data->clan_rankname3}}<br>
					4 - {{$data->clan_rankname4}}<br>
					5 - {{$data->clan_rankname5}}<br>
					6 - {{$data->clan_rankname6}}<br>
					7 - {{$data->clan_rankname7}}<br>
				</div>
			</div>
		</div>				
	</div>
	<div class="span6">
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-user green"></i>
					Clan members
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<ul>
						@foreach($members as $m)
							<li><a href="{{url('/profile/'.$m->name)}}">{{$m->name}}</a> - rank {{$m->rank}} - joined on {{$m->joined}} ({{ $m->days }} days in clan)</li>
						@endforeach	
					</ul>
				</div>
			</div>
		</div>			
	</div>
	<div class="span3">
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-comments red"></i>
					Clan MOTD
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					{{$data->clan_motd}}
				</div>
			</div>
		</div>		
		<br>	
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-ticket red"></i>
					Clan description
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<span class="claninfo">
						{!! $data->clan_desc !!}
						<br><br>
						@if($auth && ($me->user_admin > 0 || ($me->user_clanrank == 7 && $me->user_clan == $data->id)))
							<c class="btn btn-info btn-small" onclick="startediting(); ">Edit</a>						
						@endif
					</span>

				<form class="clanedit" action="http://blackpanel.bugged.ro/clan/view/2" method="POST" style="display: none;">
				<textarea name="cinfo" class="span12" rows="20">????Edited by Admin Ap9llo</textarea>
				<input type="submit" value="Save" class="btn btn-success btn-small">
				<input type="hidden" name="_token" value="l631UUbk7XbbHbvxl2a7hzghkIueVqipsEXSpA7f">
				</form>									
				</div>
			</div>
		</div>
		<br>
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-ticket red"></i>
					<a href="{{url('/logs/clan/'.$data->id)}}">Clan logs</a>
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<ul>
						@foreach($logs as $l)
							<li>
								{{ $l->time }} <br>
								{{ $l->log }}
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>	
		@if($auth && ($me->user_admin >= 5 || ($me->user_clanrank == 7 && $me->user_clan == $data->id)))
		<br>
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-legal red"></i>
					Admin tools
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<a href="{{ url('/clan/delete/' . $data->id) }}" class="btn btn-primary" onclick="return confirm('Esti sigur ca vrei sa stergi clanul? Actiunea nu poate fi remediata. Nu iti vei primi inapoi punctele premium pe care le-ai folosit pentru a crea acest clan.');"><i class="icon-trash"></i>Delete clan</a>
				</div>
			</div>
		</div>				
		@endif				
	</div>	
</div>

<script>
	$('.clanedit').hide();
	$('.startediting').click(function(){
		$('.clanedit').show();
		$('.textareaishidden').hide();
		$('.claninfo').hide();
	});
</script>

@endsection
