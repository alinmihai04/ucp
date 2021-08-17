@if($data != null)
	@foreach($data as $d)
		<li>
			<a href="{{ url($d->link) }}">
				@if($d->seen == 0)
					<i class="btn btn-xs no-hover btn-pink icon-comment"></i>
				@else
					<i class="btn btn-xs no-hover btn-grey icon-comment"></i>
				@endif
				<span class="msg-body">
					<span class="msg-title">	
						{{ $d->message }}
					</span>
				</span>
			</a>
		</li>
	@endforeach	
@endif

<li><a href="{{url('/notifications')}}">See all notifications <i class="icon-arrow-right"></i></a></li>