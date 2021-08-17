@extends('layout.main', ['title' => 'Notifications'])

@section('content')

	<div id="feed" class="tab-pane">
		<div class="profile-feed row-fluid">
			<div class="span12">
	
				@foreach($data as $e)

					<div class="profile-activity clearfix">
						<div>
							<i class="icon-bell pull-left icon-3x"></i>
							{{ $e->message }} 
							{!! $e->link != '#' ? "<a href=". url($e->link) . " class='btn btn-success pull-right'>Click to view</a>" : '' !!}
							<div class="time">
								<i class="icon-time bigger-110"></i>
								{{ $e->time }}
							</div>
						</div>
					</div>	

				@endforeach

		</div>
	</div>
</div>

@endsection
