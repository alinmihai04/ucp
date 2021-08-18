@extends('layout.main', ['title' => App\Group::getGroupName($group)])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li><a href="{{ url('/group/view/' . $group) }}">{{ App\Group::getGroupName($group) }}</a></li>
	<i class="icon-angle-right"></i>
	<li class="active">Members</li>
@endsection

@section('content')
	<div class="page-header">
		<h1>{{ App\Group::getGroupName($group) }}</h1>
	</div>
	<table class="table">
		<tbody>
			<tr>
				<td>Name</td>
				<td>Rank</td>
				<td>FW</td>
				<td>Days in faction</td>
				<td>Last Online</td>
				@if($grouptype == 6)
					<td>War Stats</td>
				@endif
				<td>Faction Raport</td>
				<td>Raport Process Date</td>
				<td>Options</td>
			</tr>
			@foreach($data as $m)
				<tr>
					<td><img src="{{ URL::asset('images/avatars/' . $m->user_groupskin) }}.png" style="width: 15px"> <a href="{{ url('/profile/' . $m->name) }}">{{ $m->name }}</a></td>
					<td>
						{{ $m->rank }}
						@if($m->fgroup == 11)
							<span class="label label-success arrowed-in-right"><i class="icon-certificate white"></i> tester</span>
						@endif
					</td>
					<td>{{ $m->fw }}</td>
					<td>{{ $m->days }}</td>
					<td>{{ $m->last_login }}</td>
					@if($grouptype == 6)
						<td>{{ $m->war_kills }} kills / {{ $m->war_deaths }} deaths</td>
					@endif
					<td>
						@foreach($goals as $g)

							@if (($g->rank == $m->rank && !$m->fgroup) || $m->fgroup == $g->rank || ($m->fgroup == 14 && $g->rank == 11) || (!$g->rank))
								<?php $shown = false; ?>


								@foreach($points as $p)

									@if($p->type == $g->type && $p->user_id == $m->user)
										<?php $shown = true; ?>

										{{ ucfirst(trans('goals.' . $g->type)) }}:
										@if($g->type == 0)
											{{ gmdate('H:i', $p->current) }}/{{ gmdate('H:i', $g->goal) }}<br>
										@else
											{{ $p->current }}/{{ $g->goal }}<br>
										@endif
									@endif

								@endforeach

								@if(!$shown)
									<?php $shown = true; ?>

									{{ ucfirst(trans('goals.' . $g->type)) }}:
									@if($g->type == 0)
										{{ gmdate('H:i', 0) }}/{{ gmdate('H:i', $g->goal) }}<br>
									@else
										{{ 0 }}/{{ $g->goal }}<br>
									@endif
								@endif
							@endif

						@endforeach
					</td>
					<td>{{ $m->raport_process }}</td>
					<td><a class="btn btn-danger btn-small" href="{{ url('complaint/create/' . $m->id) }}">Reclama player</a></td>
				</tr>
			@endforeach
		</tbody>
	</table>
@endsection
