@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li>
		<a href="{{ url('/admin') }}">Admin panel</a>
	</li>
	<i class="icon-angle-right"></i>
	<li class="active">
		View group raport
	</li>
@endsection

@section('content')
<div class="page-header">
	<h1>Editing raport for {{ $name }} (<span class="red">{{ $grouptypename }}</span>)</h1> 
</div>

<p>Current raport: </p>

@if($grouptype == 6)
	<ul>
		<li>
			{{ ucfirst(trans('goals.0')) }}
			@if($goals->isEmpty())
				- none 
			@else		
				({{ date('H:i', mktime($goals->where('type', '=', '0')->first()->goal, 0)) }} hours)
			@endif
		</li>

		<li>
			Materials Member <a href="{{ url('/raport/edit/' . $group . '/11') }}"><i class="icon-edit"></i></a>
		</li>

		@foreach($goals->where('rank', '=', 11) as $g)
			- {{ ucfirst(trans('goals.' . $g->type)) }}: {{ $g->goal }}<br>
		@endforeach

		<li>
			Drugs Member <a href="{{ url('/raport/edit/' . $group . '/12') }}"><i class="icon-edit"></i></a>
		</li>

		@foreach($goals->where('rank', '=', 12) as $g)
			- {{ ucfirst(trans('goals.' . $g->type)) }}: {{ $g->goal }}<br>
		@endforeach		

		<li>
			Tester / Helper <a href="{{ url('/raport/edit/' . $group . '/10') }}"><i class="icon-edit"></i></a>
		</li>

		@foreach($goals->where('rank', '=', 10) as $g)
			- {{ ucfirst(trans('goals.' . $g->type)) }}: {{ $g->goal }}<br>
		@endforeach				
	</ul>
@else

	<ul>
		<li>
			{{ ucfirst(trans('goals.0')) }}
			@if($goals->isEmpty())
				- none 
			@else		
				({{ date('H:i', mktime($goals->where('type', '=', '0')->first()->goal, 0)) }} hours)
			@endif
		</li>

		@for($i = 6; $i >= 1; $i--)
			<li>
				Rank {{ $i }} <a href="{{ url('/raport/edit/' . $group . '/' . $i) }}"><i class="icon-edit"></i></a>
			</li>

			@foreach($goals->where('rank', '=', $i) as $g)
				- {{ ucfirst(trans('goals.' . $g->type)) }}: {{ $g->goal }}<br>
			@endforeach
		@endfor

		<li>
			Tester / Helper <a href="{{ url('/raport/edit/' . $group . '/10') }}"><i class="icon-edit"></i></a>
		</li>

		@foreach($goals->where('rank', '=', 10) as $g)
			- {{ ucfirst(trans('goals.' . $g->type)) }}: {{ $g->goal }}<br>
		@endforeach		
	</ul>

@endif
@endsection