@extends('layout.main', ['title' => 'Hours'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li><a href="{{ url('/profile/' . $name) }}">{{ $name }}</a></li>
	<i class="icon-angle-right"></i>
	<li class="active">Hours played</li>	
@endsection

@section('content')
<div class="page-header">
	<h1>
		{{ $name }}'s played hours for last 30 days
	</h1>
</div>
<h3>
	Ore jucate in ultimele 7 zile
</h3>
<div class="profile-activity clearfix">
	<div>
		<i class="icon-time pull-left icon-3x"></i>
		{{ secondsformat($last7_avg) }} / day
	</div>
</div>

<h3>
	Ore jucate in ultimele 30 zile
</h3>
<div class="profile-activity clearfix">
	<div>
		<i class="icon-time pull-left icon-3x"></i>
		{{ secondsformat($last30_avg) }} / day
	</div>
</div>
<div class="space-12"></div>
@foreach($last30 as $l)
	<div class="profile-activity clearfix">
		<div>
			<i class="icon-time pull-left icon-3x"></i>
			{{ secondsformat($l->seconds) }}
			<div class="time">
				<i class="icon-time bigger-110"></i>
				{{ $l->time }}
			</div>
		</div>
	</div>
@endforeach

@endsection