@extends('layout.main', ['title' => "".$usersdata->count()." Players Online"])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">Online Players</li>
@endsection

@section('content')
	@foreach($groups as $g)
		<div class="span12">
		<h4>{{$g->group_name}} ({{$usersdata->where('user_group', '=', $g->group_id)->count()}} online)</h4>
			@foreach($usersdata->where('user_group', '=', $g->group_id) as $u)
				<div class="span2 center">
					<a href="{{url('/profile/'.$u->name.'')}}"><img src="{{URL::asset('images/avatars/'.$u->user_skin.'')}}.png" alt="{{$u->name}} - level {{$u->user_level}}" 
						title="{{$u->name}} - level {{$u->user_level}}"></a><br>
					{{$u->name}}
				</div>				
			@endforeach
		</div>
		<span class="clearfix"/>
	@endforeach
	<br>
	<b>Civilian ({{$usersdata->where('user_group', '=', 0)->count()}} online):</b>
	<table class="table">
		<tbody>
			<tr>
				<td>Name</td>
				<td>Level</td>
				<td>Hours played</td>
				<td>Respect points</td>
			</tr>
			@foreach($usersdata->where('user_group', '=', 0) as $u)
				<tr>
					<td><a href="{{url('/profile/'.$u->name.'')}}">{{$u->name}}</a></td>
					<td>{{$u->user_level}}</td>
					<td>{{$u->user_hours}}</td>
					<td>{{$u->user_rp}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection