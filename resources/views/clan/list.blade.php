@extends('layout.main', ['title' => 'Clan list'])


@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">Clan List</li>
@endsection

@section('content')
<div class="page-header">
	<h1>Clan List</h1>
</div>

@if(Auth::check())
	@if($me->user_clan > 0)
		<a href="{{url('/clan/view/'.$me->user_clan.'')}}" class="btn btn-inverse">View my clan</a>
	@endif
	@if($me->user_clanrank < 7)
		<a href="{{url('/clan/register')}}" class="btn btn-danger">Create a clan</a>
	@endif
@endif
<div class="space-12"></div>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th class="center">ID</th>
			<th>Name</th>
			<th class="hidden-100">Tag</th>
			<th class="hidden-480">Members</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $d)
		<tr>
			<td class="center">{{$d->id}}</td>
			<td><a href="{{url('/clan/view/'.$d->id.'')}}">{{$d->clan_name}}</a></td>
			<td class="hidden-100">{{$d->clan_tag}}</td>
			<td class="hidden-480">{{$d->clan_members}}/{{$d->clan_slots}}</td>
		</tr>
		@endforeach
	</tbody>
</table>

<div class="pagination pagination-centered">
	<ul class="pagination">
		{{$data->render()}}
	</ul>
</div>

@endsection