@extends('layout.main', ['title' => 'Complaint against ' . $against->name])

@section('content')
@if($data->status == 1)
	<div class="alert alert-warning">This topic is closed. Only admins can reply to it!</div>
@elseif($data->status == 2)
	<div class="alert alert-info">This topic was marked as an owner+ topic!</div>
@elseif($data->status == 3)
	<div class="alert alert-danger">This topic was deleted. Only admin can see it!</div>
@endif

<div class="row-fluid">
	<div class="span4">
		<h4>Complaint against</h4>
		<hr>
		<img class="nav-user-photo img-circle pull-left" src="{{ URL::asset('/images/100/' . $against->user_skin) }}.png" alt="{{ $against->name }} Avatar">
		<p class="pull-left">
			<a href="{{ url('/profile/' . $against->name) }}">{{ $against->name }}</a><br>
			Level: {{ $against->user_level }}<br>
			Faction: {{ $against->user_group }}<br>
			Hours played: {{ $against->user_hours }}<br>
			Warns: {{ $against->user_warns }}<br>
			@if($data->faction != 0)
				Faction Warns: {{ $against->user_fw }}/3
			@endif
		</p>
		<span class="clearfix"></span>
		<hr>
		<h4>Complaint status</h4>
		Status:
		<b>
			@if($data->status == 0)
				Open
			@elseif($data->status == 1)
				Closed
			@elseif($data->status == 2)
				Waiting for owner reply
			@elseif($data->status == 3)
				Deleted
			@endif
		</b><br>
		Admin replies: <b><abbr title="Optiunea aceasta va fi implementata in viitor.">N/A</abbr></b><br>
		Views: <b><abbr title="Optiunea aceasta va fi implementata in viitor.">N/A</abbr></b><br>
		Creat pe: <b>{{ $data->time }}</b>
		@if(is_object($me) && $me->user_admin > 0)
		<br> Posted from IP: <b><a href="{{ url('/logs/ip/invalid_nohash') }}">{{ $data->ip }}</a></b>
		@endif
		<span class="clearfix"></span>
		<hr>

		@if(is_object($me))
			@if($data->faction == 0 && $me->user_admin > 0)

				{!! Form::open(['url' => url('/complaint/respond/' . $data->id) ]) !!}
				@if($data->reason == 1)
			        {!! Form::submit('Jail pentru DM', ['class' => 'btn btn-small btn-purple', 'name' => 'dm', 'onclick' => 'return confirm("Esti sigur ca vrei sa-i dai acestui jucator jail pentru DM CU ARMA? Timpul de jail este calculat automat.");']) !!}
		        	{!! Form::submit('Jail pentru DM cu pumnii', ['class' => 'btn btn-small btn-purple', 'name' => 'dmp', 'onclick' => 'return confirm("Esti sigur ca vrei sa-i dai acestui jucator jail pentru DM CU PUMNII? Timpul de jail este calculat automat.");']) !!}
					<hr>
				@endif
				{!! Form::label('reason', 'Reason:') !!}
				{!! Form::text('reason', '') !!}
				{!! Form::label('time', 'Time:') !!}
				{!! Form::text('time', '') !!}

				<br>
				<p>Time = 999 pentru ban permanent</p>
		        {!! Form::submit('warn', ['class' => 'btn btn-small btn-purple', 'name' => 'warn', 'onclick' => 'return confirm("Esti sigur ca vrei sa-i dai acestui jucator un WARN? Acesta o sa fie banat automat daca acumuleaza 3/3 warns.");']) !!}
		        {!! Form::submit('ban', ['class' => 'btn btn-small btn-danger', 'name' => 'ban', 'onclick' => 'return confirm("Esti sigur?");']) !!}
		        {!! Form::submit('mute', ['class' => 'btn btn-small btn-grey', 'name' => 'mute', 'onclick' => 'return confirm("Esti sigur?");']) !!}
		        {!! Form::submit('jail', ['class' => 'btn btn-small btn-pink', 'name' => 'jail', 'onclick' => 'return confirm("Esti sigur?");']) !!}
		        {!! Form::submit('owner+', ['class' => 'btn btn-small btn-danger', 'name' => 'owner', 'onclick' => 'return confirm("Esti sigur?");']) !!}
				{!! Form::close() !!}
				<hr>
				@if($data->reason == 4)
					<h4>
						Last 20 transactions
					</h4>
					<hr>
					<ul>
						@foreach($logs as $l)
							<li>[{{ $l->time }}] {{ $l->text }}</li>
						@endforeach
					</ul>
					{!! Form::open(['url' => '/complaint/money/' . $data->id]) !!}
					{!! Form::label('money', 'Money:') !!}
					{!! Form::text('money', '', ['placeholder' => 'ex: 100, -2000']) !!}
					<br>
					<select name="player">
						<option value="{{ $data->user_id }}">{{ App\User::getName($data->user_id) }} - ${{ number_format(App\User::getMoney($data->user_id)) }}</option>
						<option value="{{ $data->creator_id }}">{{ App\User::getName($data->creator_id) }} - ${{ number_format(App\User::getMoney($data->creator_id)) }}</option>
					</select>
					<br>

					{!! Form::submit('take/give money', ['class' => 'btn btn-small btn-success']) !!}
					{!! Form::close() !!}
				@else
					<h4>
						Player punish logs
					</h4>
					<hr>
					<ul>
						@foreach($logs as $l)
							<li>[{{ $l->time }}] {{ $l->text }}</li>
						@endforeach
					</ul>
				@endif
			@elseif($me->user_grouprank >= 6 && $me->user_group == $data->faction)
				@if($against->user_fw == 2)
					<b><span class="red">Acest player are deja 2/3 FW's.</span></b>
				@else
					{!! Form::open(['url' => url('/complaint/fw/' . $data->id) ]) !!}
					{!! Form::label('fw_reason', 'Give FW') !!}
					{!! Form::text('fw_reason', '', ['placeholder' => 'FW reason']) !!}
					<br>
					{!! Form::submit('FW', ['name' => 'fw', 'class' => 'btn btn-small btn-danger', 'onclick' => 'return confirm("Esti sigur?");']) !!}
					{!! Form::close() !!}
				@endif
			@endif
		@endif
	</div>
	<div class="span8">
		<h4>Complaint details</h4>
		<hr>
		<b>Nickname: </b><a href="{{ url('/profile/' . $creator->name) }}">{{ $creator->name }}</a><br>
		<b>Level: </b>{{ $creator->user_level }}<br>
		<b>Detalii: </b>{!! nl2br(makeLinks($data->details)) !!}<br>
		<b>Motiv reclamatie: </b>{{ App\Complaint::$reason_text[$data->reason] }}
			<a href="{{ url('/complaint/reason/' . $data->id) }}">
				@if(is_object($me) && $me->user_admin > 0)
					<i class="icon-edit"></i>
				@endif
			</a>
			<br>
		<b>Dovezi (screenshot-uri, video-uri): </b>{!! nl2br(makeLinks($data->evidence)) !!}<br>
		<br>
		<div class="widget-box ">
			<div class="widget-header widget-header-flat widget-header-small">
				<h4 class="lighter smaller">
				<i class="icon-rss red"></i>
					Comments
				</h4>
			</div>
			<div class="widget-body">
				<div class="widget-main no-padding">
					<div class="dialogs">
						@foreach($posts as $p)
							@if($p->hidden == 1)
								@if(!is_object($me) || $me->user_admin == 0)
									@continue
								@endif
							@endif

							<div class="itemdiv dialogdiv">
								<div class="user">
									<img alt="{{ $p->name }}'s Avatar" src="{{ URL::asset('/images/avatars/' . $p->user_skin) }}.png">
								</div>
								<div class="body {{ $p->hidden == 1 ? 'alert-danger' : '' }}">
									<div class="time">
										<i class="icon-time"></i>
										<span class="green">
											{{ transdate(strtotime($p->time)) }}
										</span>
									</div>
									<div class="text">
										<p>
											<a href="{{ url('/profile/' . $p->name )}}" title="">{{ $p->name }}</a>
											@if($p->user_id == $data->creator_id)
												<span class="badge badge-info">complaint creator</span>
											@elseif($p->user_id == $data->user_id)
												<span class="badge badge-important">reported player</span>
											@endif

											@if($p->user_admin > 5)
												<span class="label label-purple arrowed arrowed-in-right">owner</span>
											@elseif($p->user_admin > 0)
												<span class="label label-purple arrowed arrowed-in-right">admin</span>
											@endif

											@if($p->user_helper > 0)
												<span class="label label-blabla arrowed arrowed-in-right">helper</span>
											@endif
											@if($p->user_grouprank == 7)
												<span class="label label-blabla arrowed arrowed-in-right">faction leader</span>
											@endif
											<br>
											<span class="comment">
												{!! nl2br(makeLinks($p->text)) !!}
											</span>
											<span class="pull-right">
												@if(is_object($me) && ($me->id == $p->user_id || $me->user_admin >= 3))
														<a href="{{ url('/post/edit/' . $p->id) }}"><i class="icon-edit red"></i></a>
													@if($me->user_admin >= 3)
														@if($p->hidden == 0)
															<a href="{{ url('/post/delete/' . $p->id) }}" onclick="return confirm('Esti sigur ca vrei sa ascunzi acest comentariu?');"><i class="icon-trash red"></i></a>
														@else
															<a href="{{ url('/post/delete/' . $p->id) }}" onclick="return confirm('Esti sigur ca vrei sa restaurezi acest comentariu?');"><i class="icon-check red"></i></a>
														@endif
													@endif
												@endif
											</span>
										</p>
									</div>
								</div>
							</div>
						@endforeach
					</div>
					{!! Form::open(['class' => 'form-horizontal', 'style' =>'margin: 0 15px 20px 60px;', 'url' => '/post/reply/' . $data->id]) !!}
						<h5>Leave a reply</h5>
					@if(!is_object($me))
						{!! Form::textarea('reply', '', ['class' => 'input-block-level', 'placeholder' => "You can't reply to this topic: You are not logged in.", 'cols' => '', 'rows' => '', 'disabled']) !!}
						<br><br>
						{!! Form::submit('Post', ['class' => 'btn btn-small btn-danger', 'disabled']) !!}
					@elseif($data->status != 0 && (($data->faction == 0 && $me->user_admin == 0) || ($data->faction >= 1 && ($me->user_grouprank < 6 || $me->user_group != $data->faction))))
						{!! Form::textarea('reply', '', ['class' => 'input-block-level', 'placeholder' => "You can't reply to this topic: This topic is closed.", 'cols' => '', 'rows' => '', 'disabled']) !!}
						<br><br>
						{!! Form::submit('Post', ['class' => 'btn btn-small btn-danger', 'disabled']) !!}
					@elseif(time() - session('post_delay') < 120)
						{!! Form::textarea('reply', '', ['class' => 'input-block-level', 'placeholder' => "Poti adauga un comentariu o data la 2 minute. Mai poti adauga un comentariu peste: " . (120 - (time() - session('post_delay'))) . " secunde", 'cols' => '', 'rows' => '', 'disabled']) !!}
						<br><br>
						{!! Form::submit('Post', ['class' => 'btn btn-small btn-danger', 'disabled']) !!}
					@else
						{!! Form::textarea('reply', '', ['class' => 'input-block-level', 'placeholder' => 'reply text...', 'cols' => '', 'rows' => '']) !!}
						<br><br>
						{!! Form::submit('Post', ['class' => 'btn btn-small btn-danger']) !!}
					@endif

					@if(is_object($me) && (($me->user_group == $data->faction && $me->user_grouprank >= 6) || $me->user_admin > 0))
						@if($data->status == 0 || $data->status == 2)
							{!! Form::submit('Post and close', ['class' => 'btn btn-small btn-danger', 'name' => 'postclose', 'onclick' => 'return confirm("Esti sigur ca vrei sa inchizi aceasta reclamatie?");']) !!}
						@elseif($data->status == 1)
							{!! Form::submit('Re-open', ['class' => 'btn btn-small btn-danger', 'name' => 'postclose', 'onclick' => 'return confirm("Esti sigur ca vrei sa redeschizi aceasta reclamatie?");']) !!}
						@endif
						@if($me->user_admin >= 3)
							@if($data->status != 3)

								{!! Form::submit('Delete', ['class' => 'btn btn-small btn-danger', 'name' => 'delete', 'onclick' => 'return confirm("Esti sigur ca vrei sa stergi aceasta reclamatie?");']) !!}
							@else
								{!! Form::submit('Undo delete', ['class' => 'btn btn-small btn-danger', 'name' => 'delete', 'onclick' => 'return confirm("Esti sigur ca vrei sa restaurezi aceasta reclamatie?");']) !!}
							@endif
						@endif
						<br><br>
						@if($me->user_admin > 0 && $data->status == 0 && $data->faction == 0)
							{!! Form::submit('Dovezi insuficiente', ['class' => 'btn btn-small btn-success', 'name' => 'dovezi', 'onclick' => 'return confirm("Esti sigur ca vrei sa trimiti un raspuns automat pentru dovezi insuficiente la aceasta reclamatie?");']) !!}
						@endif
					@endif

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
