@extends('layout.main', ['title' => 'Top Players'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">Top Players</li>
@endsection

@section('content')
	<table class="table table-hover">
		<tbody>
			<tr class="info table-bordered">
				<td>#</td>
				<td>Name</td>
				<td></td>
				<td>Level</td>
				<td>Playing hours</td>
				<td>Respect points</td>
			</tr>
		<tbody>
			<?php $c = 1 ?>
			@foreach($data->sortByDesc('user_hours') as $user)
			<tr>
				<td>{{ $c++ }}</td>
				<td><i class="icon-circle light-{{$user->user_status == 0 ? 'red' : 'green'}}"></i> &nbsp; <a href="{{url('/profile/' . $user->name)}}">{{ $user->name }}</a></td>
				<td>
					@if($user->id == 1)
						<span class="label label-pink arrowed-in-right"><i class="icon-gear white"></i> scripter</span>					
					@endif
					@if($user->user_admin > 5)
						<span class="label label-success arrowed-in-right"><i class="icon-shield white"></i> owner</span>	
					@elseif($user->user_admin > 0)
						<span class="label label-success arrowed-in-right"><i class="icon-shield white"></i> admin</span>											
					@endif	
					@if($user->user_helper > 0)
						<span class="label label-purple arrowed-in-right"><i class="icon-question-sign white"></i> helper</span>											
					@endif
					@if($user->user_grouprank == 7)
						<span class="label label-purple arrowed-in-right"><i class="icon-group white"></i> faction leader</span>										
					@endif																			
				</td>
				<td>{{ $user->user_level }}</td>
				<td>{{ round($user->user_hours , 0, PHP_ROUND_HALF_UP) }}</td>
				<td>{{ $user->user_rp }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@endsection