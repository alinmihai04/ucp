@extends('layout.main', ['title' => "".$data->name."'s profile"])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">{{$data->name}}'s profile</li>
@endsection


@section('content')

@if(is_object($banstats))
<div class="alert alert-danger">
	<b>This account is banned.</b>
	<br>
	<br>
	Banat de: <b>{{$banstats->ban_adminname}}</b> pe data de <b>{{$banstats->ban_currenttime}}</b>, motivul banului: <b>{{$banstats->ban_reason}}</b><br>
	@if($banstats->ban_permanent == 1)
		Contul este banat permanent (banul nu va expira automat).
	@else
		Banul expira pe data de  <b>{{date('d M Y, H:i', $banstats->ban_expiretimestamp)}}</b>
		@if($auth && $me->user_admin >= 5)
			 <a href="{{ url('admin/unban/' . $data->id )}}" onclick="return confirm('Esti sigur ca vrei sa debanezi acest jucator?');">unban</a> / cost unban: {{ !$banstats->ban_ppunban ? "50 puncte premium" : "nu poate cumpara" }}
		@endif
	@endif
</div>
@endif


@if($auth && $me->user_admin >= 5 && !is_null($data->user_admnote))
	<div class="alert alert-info"><b></b>{!! nl2br($data->user_admnote) !!} <br><br><b>/ <a href="{{ url('/admin/note/' . $data->id) }}">edit</a></b></div>
@endif

<ul class="nav nav-tabs padding-18" id="recent-tab">
	<li class="active">
		<a data-toggle="tab" href="#home">
		<i class="green icon-user bigger-120"></i>
		Profile
		</a>
	</li>
	<li>
		<a data-toggle="tab" href="#feed">
			<i class="orange icon-rss bigger-120"></i>
			Faction History
		</a>
	</li>
	<li>
		<a data-toggle="tab" href="#userbar">
		<i class="red icon-user bigger-120"></i>
		Userbar
		</a>
	</li>
	@if($auth && $me->user_admin > 0)
	<li>
		<a data-toggle="tab" href="#admtools">
		<i class="blue icon-group bigger-120"></i>
		Admin Tools
		</a>
	</li>
	<li>
		<a data-toggle="tab" href="#complaints">
		<i class="blue icon-legal bigger-120"></i>
		Complaints
		<span class="badge badge-info">{{ $complaints->count() }}</span>
		</a>
	</li>
	@endif
</ul>
<div class="tab-content no-border padding-24">
	<div id="feed" class="tab-pane">
		<div class="profile-feed row-fluid">
			<div class="span6">
				@foreach($flog->where('hidden', '=', 0) as $f)
					<div class="profile-activity clearfix">
						<div>
							<img class="pull-left" alt="{{ $data->name }}'s avatar" src="{{ URL::asset('images/avatars/' . $data->user_skin) }}.png"/>
							{{ $f->text }}
							<div class="time">
								<i class="icon-time bigger-110"></i>
								{{ $f->time }}
								@if($auth && $me->user_admin >= 5)
									<a href="{{ url('/admin/editfh/' . $data->id . '/' . $f->id) }}"> <i class="icon-edit"></i></a>
									<a href="{{ url('/admin/hidefh/' . $data->id . '/' . $f->id) }}" onclick="return confirm('Esti sigur?'); "> <i class="icon-remove-circle red"></i></a>

									@if($f->edited == 1)
										<a href="{{ url('/admin/historyfh/' . $f->id) }}" style="color: grey; text-decoration: none;">[edited]</a>
									@endif
								@endif
							</div>
						</div>
					</div>
				@endforeach
				@if($auth && $me->user_admin > 0)
					@foreach($flog->where('hidden', '=', 1) as $f)
						<div class="profile-activity clearfix alert-danger">
							<div>
								<img class="pull-left" alt="{{$data->name}}'s avatar" src="{{URL::asset('images/avatars/'.$data->user_skin.'')}}.png"/>
								{{$f->text}}
								<div class="time">
									<i class="icon-time bigger-110"></i>
									{{$f->time}}
									@if($auth && $me->user_admin >= 5)
										<a href="{{url('/admin/editfh/'.$data->id.'/'.$f->id)}}"> <i class="icon-edit"></i></a>
										<a href="{{url('/admin/hidefh/'.$data->id.'/'.$f->id)}}" onclick="return confirm('Esti sigur?'); "> <i class="icon-remove-circle green"></i></a>

										@if($f->edited == 1)
											<a href="{{url('/admin/historyfh/'.$f->id)}}" style="color: grey; text-decoration: none;">[edited]</a>
										@endif
									@endif
								</div>
							</div>
						</div>
					@endforeach
				@endif
			</div>
		</div>
	</div>
	@if($auth && $me->user_admin > 0)
	<div id="admtools" class="tab-pane">
		<div class="profile-feed row-fluid">
			<div class="span8">
				<h4>Player punish logs</h4>
				<div class="hr hr8 hr-double"></div>

				@foreach($lpdata as $l)
					<div class="profile-activity clearfix">
						<div>
							<img class="pull-left" alt="{{$data->name}}'s avatar" src="{{URL::asset('images/avatars/'.$data->user_skin)}}.png"/>
							{{$l->text}}
							<div class="time">
								<i class="icon-time bigger-110"></i>
								{{$l->time}}
							</div>
						</div>
					</div>
				@endforeach
			</div>
			<div class="span4">
				<h4>Admin+ Tools</h4>
				<div class="hr hr8 hr-double"></div>
				<ul>
					<li><a href="{{url('/admin/refresh/'.$data->id)}}" onclick="return confirm('Esti sigur ca vrei sa stergi cache-ul pentru acest jucator? Asta poate cauza incarcarea lenta a unor pagini.');">refresh player profile</a></li>
					@if($me->user_admin > 5)
						<li><a href="{{url('/admin/note/' . $data->id)}}">add/edit note</a></li>
						<li><a href="{{url('/admin/func/' . $data->id)}}">add/edit admin function</a></li>
						<li><a href="{{url('/admin/givepp/' . $data->id)}}">give/take premium points</a></li>
					@endif
				</ul>
				<h4>Admin Tools</h4>
				<div class="hr hr8 hr-double"></div>
				<ul>
					<li><a href="{{url('/logs/important/'.$data->id)}}">player important logs</a></li>
					<li><a href="{{url('/logs/player/'.$data->id)}}">player logs</a></li>
					<li><a href="{{url('/logs/chat/'.$data->id)}}">chat logs</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id="complaints" class="tab-pane">
		<div class="profile-feed row-fluid">
			<h4>Complaints against ({{ $complaints->where('user_id', '=', $data->id )->count() }})</h4>
			<div class="hr hr8 hr-double"></div>

			<ul>
				@foreach($complaints->where('user_id', '=', $data->id) as $complaint)
					<li>[{{ $complaint->time }}] <a href="{{ url('/complaint/view/' . $complaint->id) }}">By {{ $complaint->creator_name }}, reason: {{ App\Complaint::$reason_text[$complaint->reason] }}</a></li>
				@endforeach
			</ul>

			<h4>Complaints by ({{ $complaints->where('creator_id', '=', $data->id )->count() }})</h4>
			<div class="hr hr8 hr-double"></div>

			<ul>
				@foreach($complaints->where('creator_id', '=', $data->id) as $complaint)
					<li>[{{ $complaint->time }}] <a href="{{ url('/complaint/view/' . $complaint->id) }}">Against {{ $complaint->user_name }}, reason: {{ App\Complaint::$reason_text[$complaint->reason] }}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
	@endif
	<div id="userbar" class="tab-pane">
		<div class="profile-feed row-fluid">
			<div class="span12 center">
				<h4 class="blue">Userbar</h4>
				<img src="{{url('/userbar/'.$data->name)}}" alt="userbar"></br></br>
				<b>Cod pentru forum {{ config('app.title') }}:</b><br /><input type="text" style="width:250px" disabled value="[rpg={{$data->name}}]" />
				<br/><br/>
				<b>Cod HTML pentru alte site-uri:</b><br /><input type="text" style="width:250px" disabled value="[url=&quot;{{ url('') }}&quot;][img]{{url('/userbar/'.$data->name)}}[/img][/url]" />
			</div>
		</div>
	</div>
	<div id="home" class="tab-pane active">
		<div class="row-fluid">
			<div class="span2 center">
				<span class="profile-picture">
					<img class="pull-left" alt="{{$data->name}}'s avatar" src="{{URL::asset('images/skins/'.$data->user_skin.'.png')}}" style="height:300px;"/>
				</span>
				<div class="space-4"></div>
				<div class="width-80 label label-inverse arrowed-in arrowed-in-right">
					<div class="inline position-relative">
						{!! !$data->user_status ? "<i class='icon-circle light-red middle'></i>" : "<i class='icon-circle light-green middle'></i>" !!}
						&nbsp;
						<span class="white">{{ !$data->user_status ? "offline" : "online"}}</span>
					</div>
				</div>
				<div class="space-4"></div>
				@if(!$auth || $data->id != $me->id)
					<a class="btn btn-danger btn-small" href="{{ url('/complaint/create/' . $data->id) }}"><i class="icon-legal"></i> Reclama player</a>
				@endif
				<div class="space-4"></div>
				@if($auth)
					@if($me->id == $data->id && $data->user_group != 0)
						<hr>
						@if($data->user_shownskin == 0)
							<a class="btn btn-info btn-small" href="{{ url('/shownskin/1') }}">Afiseaza skin-ul normal</a>
						@else
							<a class="btn btn-info btn-small" href="{{ url('/shownskin/0') }}">Afiseaza skin-ul factiunii</a>
						@endif

					@endif
				@endif
				<div class="space-4"></div>
			</div>
			<div class="span10">
				<h4 class="blue">
					<span class="middle">
						{{ $data->name }}
						@if($auth && $me->user_admin > 4)
							@if($data->user_fnc == 0)
								<a href="{{url('/admin/fnc/' . $data->id)}}"><i class="icon-edit"></i></a>
							@endif
						@endif
					</span>
				</h4>
				@if($data->user_admin >= 6)
					<span class="label label-success arrowed-in-right"><i class="icon-shield white"></i> owner </span><br>
				@elseif($data->user_admin < 6 && $data->user_admin > 0)
					<span class="label label-success arrowed-in-right"><i class="icon-shield white"></i> admin </span><br>
				@endif
				@if($data->id == 1)
					<span class="label label-pink arrowed-in-right"><i class="icon-gear white"></i> scripter </span><br>
				@endif
				@if($data->user_clanrank == 7)
					<span class="label label-blue arrowed-in-right"><i class="icon-group white"></i> <a href="{{url('/clan/view/'.$data->user_clan.'')}}" style='color: #FFF'>clan owner</a> </span><br>
				@endif
				@if($data->user_helper > 0)
					<span class="label label-purple arrowed-in-right"><i class="icon-question-sign white"></i> helper </span><br>
				@endif
				@if($data->user_grouprank == 7)
					<span class="label label-purple arrowed-in-right"><i class="icon-group white"></i> faction leader </span><br>
				@endif
				@if($data->user_premium == 1)
					<span class="label label-yellow arrowed-in-right"><i class="icon-star grey"></i> premium user </span><br>
				@elseif($data->user_premium == 2)
					<span class="label label-yellow arrowed-in-right"><i class="icon-star grey"></i> Legend </span><br>
				@endif
				@if($data->user_support > 0)
					<span class="label label-purple arrowed-in-right"><i class="icon-ticket white"></i> support </span><br>
				@endif
				@if(!is_null($data->user_admfunc) && $data->user_admin > 0)
					@if($auth && $me->user_admin > 5)
						<a href="{{url('/admin/func/'.$data->id.'')}}"><span class="label label-purple arrowed-in-right"><i class="icon-gear white"></i> {{$data->user_admfunc}} </span></a><br>
					@else
						<span class="label label-purple arrowed-in-right"><i class="icon-gear white"></i> {{$data->user_admfunc}} </span><br>
					@endif
				@endif
				@if($data->user_beta > 0)
					<span class="label label-pink arrowed-in-right"><i class="icon-bug white"></i> beta tester </span><br>
				@endif

				@if($auth && $me->user_admin > 5)
					@if($data->user_admin > 0)
						@if(is_null($data->user_admfunc))
							<a href="{{url('/admin/func/'.$data->id.'')}}">add admin function</a><br>
						@endif
					@endif
					@if($data->user_beta == 0)
						<a href="{{url('/admin/makebeta/'.$data->id.'')}}" onclick="return confirm('Esti sigur ca vrei sa ii oferi acestui utilizator gradul de Beta Tester?');">make beta tester</a><br>
					@elseif($data->user_beta > 0)
						<a href="{{url('/admin/makebeta/'.$data->id.'')}}" onclick="return confirm('Esti sigur ca vrei sa ii SCOTI gradul de Beta Tester acestui utilizator?');">remove beta tester</a><br>
					@endif
				@endif
				<br>
	  	 		<div class="profile-user-info">
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Faction
                		</div>
                		<div class="profile-info-value">
                			@if($data->user_group > 0)
                				{{ App\Group::getGroupName($data->user_group) }} <a href="{{ url('/group/members/'.$data->user_group) }}"><i class="icon-external-link"></i></a>, rank {{$data->user_grouprank}}
                			@else
                				Civilian
                			@endif
                		</div>
            		</div>
            		@if($data->user_clan > 0)
              		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Clan
                		</div>
                		<div class="profile-info-value">
                			{{App\Clan::getClanName($data->user_clan)}} <a href="{{url('/clan/view/'.$data->user_clan.'')}}"><i class="icon-external-link"></i></a>, rank {{$data->user_clanrank}}
                		</div>
            		</div>
            		@endif
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Level
                		</div>
                		<div class="profile-info-value">
                			{{$data->user_level}}
                		</div>
            		</div>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Playing hours
                		</div>
                		<div class="profile-info-value">
                			{{ round($data->user_hours, 0, PHP_ROUND_HALF_UP) }}
                		</div>
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Phone
                		</div>
                		<div class="profile-info-value">
                			{{$data->user_phonenr}}
                		</div>
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Joined
                		</div>
                		<div class="profile-info-value">
                			{{$data->user_registered}}
                		</div>
            		</div>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Last Online
                		</div>
                		<div class="profile-info-value">
                			{{$data->last_login}}
                		</div>
            		</div>
            		@if($auth && (Auth::id() == $data->id || $me->user_admin > 0))
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Money
                		</div>
                		@if($me->user_admin >= 6)
           		 			<div class="profile-info-value"><a href="{{ url('/admin/money/' . $data->id) }}" style="color: inherit;">${{number_format($data->user_money)}} / ${{number_format($data->user_bankmoney)}}</a></div>
                		@else
	           				<div class="profile-info-value">
	                			${{number_format($data->user_money)}} / ${{number_format($data->user_bankmoney)}}
	                		</div>
                		@endif
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Materials
                		</div>
                		<div class="profile-info-value">
                			{{$data->user_mats}}
                		</div>
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Reward Points
                		</div>
                		<div class="profile-info-value">
                			{{$data->user_rewardpoints}}
                		</div>
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Premium
                		</div>
                		<div class="profile-info-value">
                			{{ $data->user_premium > 0 ? "Yes" : "No" }} ({{ $data->user_premiumpoints }} premium points)
                			<a href="http://blackpanel.bugged.ro/premium">
								<span class="-right">
									<i class="btn btn-xs no-hover btn-success icon-plus"></i>
								</span>
							</a>
                		</div>
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Email
                		</div>
                		<div class="profile-info-value">
                			{{ $data->user_email }} <a href="{{ url('/user/changemail/'.$data->id) }}"><i class="icon-edit"></i></a>
                		</div>
            		</div>
            		@endif
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Warnings
                		</div>
                		<div class="profile-info-value">
                			{{$data->user_warns}}/3
                		</div>
            		</div>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Faction Warns
                		</div>
                		<div class="profile-info-value">
                			@if($data->user_group == 0)
                				0/3
                			@else
                				{{ $data->user_fw }}/3
                			@endif
                		</div>
            		</div>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Faction Punish
                		</div>
                		<div class="profile-info-value">
                			{{$data->user_fp}}/40
                		</div>
            		</div>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Job
                		</div>
                		<div class="profile-info-value">
                			@if($data->user_job == 0)
                				Unemployed
                			@else
                				{{ App\Job::getJobName($data->user_job) }}
                			@endif
                		</div>
            		</div>
            		@if($data->user_jailtime >= 1)
	            		<div class="profile-info-row">
	                		<div class="profile-info-name">
	                			Jailed
	                		</div>
	                		<div class="profile-info-value">
	                			{{ intval($data->user_jailtime / 60) }} minutes
	                		</div>
	            		</div>
            		@endif
            		@if($auth && ($me->user_admin >= 1 || $me->id == $data->id))
	             		<div class="profile-info-row">
	                		<div class="profile-info-name">
	                			Online last 7 days
	                		</div>
	                		<div class="profile-info-value">
	                			@if($me->user_admin >= 1)
	                				{{ App\User::last7($data->id) }}
	                				<a href="{{ url('/user/hours/' . $data->id) }}"><i class="icon-plus"></i></a>
	                			@else
	                				{{ App\User::last7($data->id) }}
	                			@endif
	                		</div>
	            		</div>
            		@endif
            		@if($auth && $me->user_admin > 4 && $data->user_fnc == 1)
	            		<div class="profile-info-row">
	            			<div class="profile-info-name">
	            				<span class="text-error">Panel FNC</span>
	            			</div>
	                		<div class="profile-info-value">
	                			<span class="text-error">
	                				Acest player este fortat sa isi schimbe nickaname-ul la urmatoare logare pe server. <br>Motiv: <b>{{ $data->user_fncreason }}</b>
	                			</span>
	                		</div>
	            		</div>
            		@endif
            	</div>
			</div>
			<div class="clear"></div>
			<div class="space-20"></div>

			<div class="row-fluid">
				<div class="span8">
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h4 class="smaller">
								<i class="icon-truck bigger-110"></i>
								Personal vehicles
							</h4>
						</div>
						<div class="widget-body">
							<div class="widget-main">
								@if($vehicles->isEmpty())
									<p>This player has no vehicles.</p>
								@else
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Image</th>
											<th class="hidden-480">Vehicle Name</th>
											<th class="hidden-100">Info</th>
											<th class="center">GPS</th>
										</tr>
									</thead>
									<tbody>
										@foreach($vehicles as $v)
											@if($v->vehicle_vip)
												<tr class='warning'>
											@else
												<tr>
											@endif
											<td class='center'>
												<img src="{{URL::asset('images/vehicles/Vehicle_'.$v->vehicle_model.'')}}.jpg" alt="{{$v->vehicle_model}}" style="height: 65px"/>
											</td>
											<td>
												{{App\Vehicle::$namevehicles[$v->vehicle_model]}}
												@if($v->vehicle_vip == 1)
													<p><br><b class='text-error'>VIP Vehicle</b><br>Text: <span style="color: #{{$v->vehicle_vipcolor}}; -webkit-text-stroke-width: 0.001px;
   														-webkit-text-stroke-color: black;"><b>{{$v->vehicle_vipname}}</b></span>
												@endif
											</td>
											<td>
												Odometter: <b>{{$v->vehicle_km}} km</b><br>
												Colors: <span style="color: {!! App\Vehicle::$vehColors[$v->vehicle_color1] !!}; font-weight: bold;">{{$v->vehicle_color1}}</span>,
												<span style="color: {{App\Vehicle::$vehColors[$v->vehicle_color2]}}; font-weight: bold;">{{$v->vehicle_color2}}</span><br>
												Age: <b>{{$v->vehicle_days}} days</b><br>
											</td>
											<td>
												<a href="{{url('/map/'.$v->vehicle_posX.'/'.$v->vehicle_posY)}}"><i class="icon-map-marker"></i> display on map</a>
												@if($auth && $me->user_admin > 0)
													<br>
													<a href="{{url('/logs/vehicle/'.$v->id.'')}}"><i class="icon-archive"></i> view logs - id: {{$v->id}}</a>
												@endif
											</td>
										@endforeach
									</tbody>
								</table>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="span2">
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h4 class="smaller">
								<i class="icon-home bigger-110"></i>
								House
							</h4>
						</div>
						<div class="widget-body">
							<div class="widget-main">
								@if(!$house)
									<p>This player doesn't own a house.</p>
								@else
									House ID: <b>{{ $house->id }}</b><br />
									Rent: <b>${{ number_format($house->house_rent) }}</b><br>
									Price: <b>{!! $house->house_price == 0 ? "Not for sale" : "$" . number_format($house->house_price) !!}</b><br>
									Interior size:
									<b>
									@if($house->house_size == 1)
										Small
									@elseif($house->house_size == 2)
										Medium
									@else
										Large
									@endif
									</b><br>
									<a href='{{ url('/map/'.$house->house_exterior_posX.'/'.$house->house_exterior_posY) }}'><i class='icon-map-marker'></i> display on map</a>
									@if($auth && $me->user_admin > 0)
										<br>
										<a href="{{ url('/logs/house/' . $house->id) }}"><i class="icon-archive"></i> view logs (not implemented)</a>
									@endif
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="span2">
					<div class="widget-box transparent">
						<div class="widget-header widget-header-small">
							<h4 class="smaller">
								<i class="icon-glass bigger-110"></i>
								Business
							</h4>
						</div>
						<div class="widget-body">
							<div class="widget-main">
								@if(!$biz)
									<p>This player doesn't own a business.</p>
								@else
									Business ID: <b>{{ $biz->id }}</b><br />
									Business Fee: <b>${{ number_format($biz->biz_fee) }}</b><br>
									Price: <b>{!! $biz->biz_price == 0 ? "Not for sale" : "$" . number_format($biz->biz_price) !!}</b><br>
									<a href='{{ url('/map/' . $biz->biz_exterior_posX . '/' . $biz->biz_exterior_posY) }}'><i class='icon-map-marker'></i> display on map</a>
									@if($auth && $me->user_admin > 0)
										<br>
										<a href="{{ url('/logs/biz/' . $biz->id) }}"><i class="icon-archive"></i> view logs (not implemented)</a>
									@endif
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
