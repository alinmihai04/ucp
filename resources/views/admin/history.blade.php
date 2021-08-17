@extends('layout.main', ['title' => 'Admin Control Panel'])

@section('content')
<div class="page-header">
	<h1>View Faction Log History</h1>
</div>

<div class="profile-feed row-fluid">
	<div class="span6">
		@foreach($data as $f)
			<div class="profile-activity clearfix">
				<div>
					Versiune anterioara: {{$f->text}}
					<div class="time">
						<i class="icon-time bigger-110"></i>
						{{$f->time}} - edited by {{$f->user_name}}[admin:{{$f->user}}]
					</div>
				</div>
			</div>
		@endforeach
	</div>
</div>

@endsection