@extends('layout.main', ['title' => 'Homepage'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">Homepage</li>
@endsection

@section('content')
<div class="span8">
	@if($auth && $me->user_status >= 1 && $me->last_ip != \Request::ip())
		<div class="alert alert-error">
			<b><i class="icon-warning-sign"></i> E posibil ca altcineva sa fie logat pe contul tau</b>
			<br><br>
			Cineva este logat pe contul tau de pe un IP diferit de IP-ul pe care il folosesti acum.<br>
			IP-ul tau: <b>{{ \Request::ip() }}</b><br>
			IP-ul folosit in joc: <b>{{ $me->last_ip }}</b><br>
			<br>
			Poti da click pe link-ul de mai jos pentru a deconecta playerul ce este acum conectat pe cont.<br>
			Nu pot fi logati 2 playeri pe acelasi cont.<br>
			Daca esti tu conectat pe cont, nu da click pe butonul de mai jos.<br>
			Daca folosesti un proxy in browser, opera turbo sau esti logat de pe telefon, e posibil ca IP-ul de pe panel sa difere tot timpul de IP-ul din joc.<br><br>
			<a href="{{ url('/decon/' . $me->id) }}" class="btn btn-info" onclick="return confirm('Esti sigur ca vrei sa fii deconectat din joc?');">Vreau sa fiu deconectat din joc</a>
			<br><br>
		</div>
	@endif
	@if($auth && $me->user_2fa == 0)
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert">
			<i class="icon-remove"></i>
		</button>
		<h3>Autentificare in doi pasi</h3>
		<hr>
		<p>
			Pentru o securitate sporita a contului tau, poti activa autentificarea in doi pasi.<br>
			Ai nevoie doar de un telefon mobil cu sistem de operare Android sau iOS.<br>
		</p>
		<p>
			<a href="{{ url('/account/security') }}" class="btn btn-sm btn-success">Activeaza acum</a>
		</p>
	</div>
	@endif
	<div class="infobox-container">
		<div class="infobox infobox-green">
			<div class="infobox-icon">
				<i class="icon-user"></i>
			</div>
			<div class="infobox-data">
				<span class="infobox-data-number">{{$onlineusers}}</span>
				<div class="infobox-content">
					<a href="{{url('/online')}}">jucatori online</a>
				</div>
			</div>
		</div>
		<div class="infobox infobox-blue">
			<div class="infobox-icon">
				<i class="icon-user"></i>
			</div>
			<div class="infobox-data">
				<span class="infobox-data-number">{{number_format($onlinetoday)}}</span>
				<div class="infobox-content">
					conectati astazi
				</div>
			</div>
		</div>
		<div class="infobox infobox-blue">
			<div class="infobox-icon">
				<i class="icon-user"></i>
			</div>
			<div class="infobox-data">
				<span class="infobox-data-number">{{number_format($onlineweek)}}</span>
				<div class="infobox-content">
					conectati sapt. trecuta
				</div>
			</div>
		</div>
		<div class="infobox infobox-pink">
			<div class="infobox-icon">
				<i class="icon-user"></i>
			</div>
			<div class="infobox-data">
				<span class="infobox-data-number">{{number_format($registered)}}</span>
				<div class="infobox-content">
					jucatori inregistrati
				</div>
			</div>
		</div>
		<div class="infobox infobox-red">
			<div class="infobox-icon">
				<i class="icon-truck"></i>
			</div>
			<div class="infobox-data">
				<span class="infobox-data-number">{{number_format($cars)}}</span>
				<div class="infobox-content">
					vehicule personale
				</div>
			</div>
		</div>
		<div class="infobox infobox-orange">
			<div class="infobox-icon">
				<i class="icon-home"></i>
			</div>
			<div class="infobox-data">
				<span class="infobox-data-number">{{number_format($houses)}}</span>
				<div class="infobox-content">
					case
				</div>
			</div>
		</div>
		<div class="infobox infobox-purple">
			<div class="infobox-icon">
				<i class="icon-glass"></i>
			</div>
			<div class="infobox-data">
				<span class="infobox-data-number">{{number_format($biz)}}</span>
				<div class="infobox-content">
					afaceri
				</div>
			</div>
		</div>
	</div>
	<br>
	@if(!is_null($complaintsdata))
	<h4>
		<i class="icon-legal red"></i>
		Complaints against you
	</h4>
	<div class="col-xs-12 center">
		<div class="table-responsive">
			<table id="sample-table-1" class="table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>Title</th>
						<th><i class="icon-time bigger-110 hidden-480"></i>Date</th>
						<th class="hidden-480">Status</th>
					</tr>
				</thead>
				<tbody>
					@foreach($complaintsdata as $complaint)
					<tr>
						<td><a href="{{ url('/complaint/view/' . $complaint->id) }}"> {{ App\Complaint::$reason_text[$complaint->reason] }} </a></td>
						<td>{{ $complaint->time }}</td>
						<td>Open</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	@endif
	@if($auth && $me->user_admin > 0)
		<div class="row-fluid">
			<div class="span6">
				<div class="widget-box">
					<div class="widget-header widget-header-flat widget-header-small">
						<h5>
							<i class="icon-legal"></i> Status Reclamatii
						</h5>
					</div>

					<div class="widget-body">
						<div class="widget-main">
							<div class="hr hr8 hr-double"></div><br />
							<span class="clearfix"></span>
							<ul>
								<li>Reclamatii normale: <b><a href="{{ url('/complaints/normal') }}">{{$complaints->where('reason', '!=', '2')->where('reason', '!=', '4')->where('reason', '!=', '6')->where('reason', '!=', '7')->where('status', '=', '0')->count()}} </b></a>  </li>
								<li>Reclamatii staff: <b><a href="{{ url('/complaints/staff') }}">{{$complaints->where('reason', '=', '6')->where('status', '=', '0')->count()}} </b></a></li>
								<li>Reclamatii lideri: <b><a href="{{ url('/complaints/leader') }}">{{$complaints->where('reason', '=', '7')->where('status', '=', '0')->count()}} </b></a></li>
								<li>Reclamatii inselatorii: <b><a href="{{ url('/complaints/scam') }}">{{$complaints->where('reason', '=', '4')->where('status', '=', '0')->count()}} </b></a></li>
								<li>Owner+: <b><a href="{{ url('/complaints/owner') }}">{{$complaints->where('status', '=', '2')->count()}} </b></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="widget-box">
					<div class="widget-header widget-header-flat widget-header-small">
						<h5>
							<i class="icon-ticket"></i> Status Tickete
						</h5>
					</div>

					<div class="widget-body">
						<div class="widget-main">
							<div class="hr hr8 hr-double"></div><br />
							<span class="clearfix"></span>
							<ul>
								<li>null</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
	@endif
	<div class="widget-box ">
		<div class="widget-header widget-header-flat widget-header-small">
			<h4 class="lighter smaller">
				<i class="icon-rss red"></i>
				Ultimele actiuni
			</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main no-padding">
				<div class="dialogs">
					@foreach($flog as $f)
						<div class="itemdiv dialogdiv">
							<div class="user">
								<img src="{{ URL::asset("images/avatars/".$f->user_skin.".png") }}"/>
							</div>
							<div class="body">
								<div class="time">
									<i class="icon-time"></i>
										<span class="green">{{$f->time}}</span>
								</div>
								<div class="text">
									<?php $tokens = explode(" ", $f->text) ?>
									<p>{!! str_replace($tokens[0], "<a href=".url('/profile/'.$f->name.'').">".$f->name."</a>", $f->text) !!}</p>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>

<div class="span4">
	<div class="widget-box">
		<div class="widget-header widget-header-flat widget-header-small">
			<h5>
				<i class="icon-play green"></i> Joaca SA:MP pe serverul nostru
			</h5>
		</div>

		<div class="widget-body">
			<div class="widget-main">
				<div class="hr hr8 hr-double"></div><br />
				<span class="clearfix"></span>
				<ul>
					<a href="samp://{{ config('app.ip') }}" class="btn btn-block btn-primary">Deschide SA:MP si conecteaza-te la serverul nostru</a>
				</ul>
			</div>
		</div>
	</div>
	<br>
	@if($auth && $me->user_admin > 0)
	<div class="widget-box">
		<div class="widget-header widget-header-flat widget-header-small">
			<h5>
				<i class="icon-rss orange"></i> Leaders needed
			</h5>
		</div>

		<div class="widget-body">
			<div class="widget-main">
				<div class="hr hr8 hr-double"></div><br />
				<span class="clearfix"></span>
				<ul>
					@foreach($nlgroups as $g)
						<li>{{$g->group_name}}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	<br>
	@endif
	<div class="widget-box">
		<div class="widget-header widget-header-flat widget-header-small">
			<h5>
				<i class="icon-rss orange"></i> Staff logs
			</h5>
		</div>

		<div class="widget-body">
			<div class="widget-main">
				<div class="hr hr8 hr-double"></div><br />
				<span class="clearfix"></span>
				<ul>
					@foreach($slog as $s)
						<li>{{$s->text}}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	<br>
	<div class="widget-box">
		<div class="widget-header widget-header-flat widget-header-small">
			<h5>
				<i class="icon-rss orange"></i> <a href="#">Informatii Server</a>
			</h5>
		</div>

		<div class="widget-body">
			<div class="widget-main">
				<div class="hr hr8 hr-double"></div><br />
				<span class="clearfix"></span>
					<p>n-avem</p>
			</div>
		</div>
	</div>
	<br>
	<div class="widget-box">
		<div class="widget-header widget-header-flat widget-header-small">
			<h5>
				<i class="icon-rss orange"></i> <a href="#">Server Updates</a>
			</h5>
		</div>

		<div class="widget-body">
			<div class="widget-main">
				<div class="hr hr8 hr-double"></div><br />
				<span class="clearfix"></span>
					<p>nu se pune problema</p>
			</div>
		</div>
	</div>
</div>
@endsection
