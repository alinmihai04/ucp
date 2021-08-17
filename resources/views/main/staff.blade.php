@extends('layout.main', ['title' => 'Staff'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">Staff</li>
@endsection

@section('content')

@if($auth && $me->user_helper >= 1)
	Raspunsuri pe /n in ultimele 7 zile: <b>{{ $my_nre }}</b><br>
	<span style='color:grey'>// datele sunt actualizate o data la 60 de minute</span><br>
	<span style='color:grey'>// ultima actualizare: {{ $my_nre_time }}</span><br>
	<hr>
@endif

<h4>Admins ({{$data->where('user_status', '>', 0)->where('user_admin', '>', 0)->count()}}/{{$data->where('user_admin', '>', 0)->count()}})</h4>

<table class="table table-condensed">
	<tbody>
		<tr class="success">
			<td>Status</td>
			<td>Name</td>
			<td>Admin level</td>
			<td>Info</td>
			<td>Last online</td>
			@if($auth && $me->user_admin >= 1)
				<td>online 7d</td>
				<td>last rank change</td>
			@endif			
		</tr>
		@foreach($data->where('user_admin', '>', 0)->sortByDesc('user_admin') as $d)
		<tr>
			<td>{!! $d->user_status == 0 ? "<span class='badge badge-grey'>offline</span>" : "<span class='badge badge-success'>online</span>" !!}</td>
			<td><a href="{{url('/profile/'.$d->name.'')}}">{{$d->name}}</a></td>
			<td>{{$d->user_admin}}</td>
			<td>
				@if($d->user_admin == 6 && $d->id != 1)
					<span class="label label-inverse arrowed-in-right"><i class="icon-sitemap white"></i> owner </span>
				@elseif($d->id == 1)
					<span class="label label-inverse arrowed-in-right"><i class="icon-sitemap white"></i> owner & scripter </span>
				@endif

				@if(!is_null($d->user_admfunc))
					<span class="label label-purple arrowed-in-right"><i class="icon-gear white"></i> {{$d->user_admfunc}} </span>
				@endif
				@if($d->user_support == 1)
					<span class="label label-purple arrowed-in-right"><i class="icon-comments white"></i> support </span>
				@elseif($d->user_support == 2)
					<span class="label label-yellow arrowed-in-right"><i class="icon-shield grey"></i> support, account moderator</span>
				@endif
				@if($d->user_beta == 1)
					<span class="label label-pink arrowed-in-right"><i class="icon-bug white"></i> beta tester </span>
				@endif			

				@if($auth && $me->user_admin >= 6)
					<a href="{{url('/admin/remove/'.$d->id)}}" onclick="return confirm('Esti sigur ca vrei sa il scoti pe acest jucator din staff?');"><i class="icon-remove-circle red"></i></a>

					@if($d->user_support >= 1)
						- <a href="{{url('/admin/support/0/' . $d->id)}}" onclick="return confirm('Esti sigur ca vrei sa ii scoti functia de SUPPORT acestui admin?');"><i class="icon-ticket red"></i></a>
					@endif

					- <a href="{{url('/admin/support/1/' . $d->id)}}" onclick="return confirm('Esti sigur ca vrei sa il promovezi pe acest admin la SUPPORT LEVEL 1?');"><i class="icon-ticket green"></i></a>
					- <a href="{{url('/admin/support/2/' . $d->id)}}" onclick="return confirm('Esti sigur ca vrei sa il promovezi pe acest admin la SUPPORT LEVEL 2?');"><i class="icon-ticket blue"></i><i class="icon-ticket blue"></i></a>
				@endif				
			</td>
			<td>{{$d->last_login}}</td>
			@if($auth && $me->user_admin >= 1)
				<td>
					@if($d->last7 < 10)
						<b><span class="red"> {{ $d->last7 }}</span></b>
					@else
						{{ $d->last7 }}
					@endif
				</td>
				<td>
					{{ $d->staffchange }} days ago
				</td>
			@endif			
		</tr>
		@endforeach
	</tbody>
</table>

<h4>Helpers ({{$data->where('user_status', '>', 0)->where('user_helper', '>', 0)->count()}}/{{$data->where('user_helper', '>', 0)->count()}})</h4>

<table class="table table-condensed">
	<tbody>
		<tr class="success">
			<td>Status</td>
			<td>Name</td>
			<td>Helper level</td>
			<td>Last online</td>
			@if($auth && $me->user_admin >= 1)
				<td>/n - last 7 days</td>
				<td>online last 7 days</td>
				<td>last rank change</td>
			@endif			
		</tr>
		@foreach($data->where('user_helper', '>', 0)->sortByDesc('user_helper') as $d)
		<tr>
			<td>{!! $d->user_status == 0 ? "<span class='badge badge-grey'>offline</span>" : "<span class='badge badge-success'>online</span>" !!}</td>
			<td><a href="{{url('/profile/' . $d->name)}}">{{ $d->name }}</a></td>
			<td>{{ $d->user_helper }}</td>
			<td>{{ $d->last_login }}</td>
			@if($auth && $me->user_admin >= 1)
				<td>
					@if($d->last_nre < 20)
						<b><span class="red"> {{ $d->last_nre }}</span></b>
					@else
						{{ $d->last_nre }}
					@endif
				</td>				
				<td>
					@if($d->last7 < 10)
						<b><span class="red"> {{ $d->last7 }}</span></b>
					@else
						{{ $d->last7 }}
					@endif
				</td>			
				<td>
					{{ $d->staffchange }} days ago
				</td>				
			@endif			
		</tr>
		@endforeach
	</tbody>
</table>

<h4>Leaders ({{$data->where('user_status', '>', 0)->where('user_grouprank', '=', 7)->count()}}/{{$data->where('user_grouprank', '=', 7)->count()}})</h4>

<table class="table table-condensed">
	<tbody>
		<tr class="success">
			<td>Status</td>
			<td>Name</td>
			<td>Faction</td>
			<td>Faction members</td>		
			<td>Last online</td>
			@if($auth && $me->user_admin >= 1)
				<td>online last 7 days</td>
			@endif				
		</tr>
		@foreach($data->where('user_grouprank', '=', 7)->sortBy('user_group') as $d)
		<tr>
			<td>{!! $d->user_status == 0 ? "<span class='badge badge-grey'>offline</span>" : "<span class='badge badge-success'>online</span>" !!}</td>
			<td><a href="{{url('/profile/'.$d->name.'')}}">{{$d->name}}</a></td>
			<td><a href="{{url('/group/members/'.$d->user_group.'')}}">{{$groups->where('group_id', '=', $d->user_group)->first()->group_name}}</td>
			<td>{{$groups->where('group_id', '=', $d->user_group)->first()->group_members}}/{{$groups->where('group_id', '=', $d->user_group)->first()->group_slots}}</td>	
			<td>{{$d->last_login}}</td>
			@if($auth && $me->user_admin >= 1)
				<td>
					@if($d->last7 < 10)
						<b><span class="red"> {{ $d->last7 }}</span></b>
					@else
						{{ $d->last7 }}
					@endif
				</td>			
			@endif					
		</tr>
		@endforeach
	</tbody>
</table>

Complaints created last 7 days: <b>{{ $complaints_7d }}</b><br/>
Complaints created last 24h: <b>{{ $complaints_24h }}</b><br>
Newbie questions asked in the last 7 days: <b>{{ $newbie }}</b>
@endsection