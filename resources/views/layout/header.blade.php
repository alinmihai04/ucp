<?php

$me = me();
$header_staff = App\Header::countHeaderStaff();
$header_complaints = App\Header::countHeaderComplaints();
$header_factions = App\Header::countHeaderFactions();
$header_bids = App\Header::countHeaderBids();
///
?>

<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">

			<a href="{{url('/')}}" class="brand">
				<small>
					<i class="icon-bug"></i>
					{{config('app.title')}} Panel
				</small>
			</a>
			<ul class="nav ace-nav pull-right">
				@if(is_object($me))
					<li class="purple">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#" id="loadnotifications">
							<?php $emails = App\Header::headerLoadEmails(Auth::id()); ?>
							@if($emails > 0)
								<i class="icon-bell-alt icon-animated-bell"></i>
								<span class='badge badge-important'>{{ $emails }}</span>
							@else
								<i class="icon-bell-alt"></i>
								<span class='badge badge-grey'>0</span>
							@endif
						</a>

						<ul class="pull-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close" id="notifications">
							<li>
								<center>
									Loading...<br>
									Please wait...
								</center>
							</li>
						</ul>
					</li>
				@endif
				<li class="light-blue">
					@if(!is_object($me))
						<a href="{{url('/login')}}">Login</a>
					@else
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img class="nav-user-photo" src="{{URL::asset('images/avatars/' . $me->user_skin)}}.png" astyle="height: 36px;" alt="Avatar" />
							<span class="user-info">
								<small>Welcome,</small>
								{{$me->name}}
							</span>

							<i class="icon-caret-down"></i>
						</a>
						<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
							<li>
								<a href="{{url('/profile/'.$me->name.'')}}">
									<i class="icon-user"></i>
									Profilul meu
								</a>
							</li>
							<li>
								<a href="{{url('/changemail')}}">
								<i class="icon-envelope"></i>
									Schimba e-mail
								</a>
							</li>
							<li>
								<a href="{{url('/account/security')}}">
								<i class="icon-lock"></i>
									Autentificare in doi pasi
								</a>
							</li>
							<li>
								<a href="{{url('/mycomplaints')}}">
								<i class="icon-legal"></i>
									Reclamatii create de mine
								</a>
							</li>
							<li class="divider"></li>
							<li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <i class="icon-off"></i>Deconectare
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
							</li>
						</ul>
					@endif
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="main-container container-fluid">
	<a class="menu-toggler" id="menu-toggler" href="#" data-target="#sidebar">
		<span class="menu-text"></span>
	</a>
	<div id="sidebar" class="sidebar">
		<ul class="nav nav-list">
			<li>
				<a href="{{url('/')}}">
					<i class="icon-dashboard"></i>
					<span class="menu-text"> Home </span>
				</a>
			</li>
			@if(is_object($me))
				@if($me->user_group > 0)
					<li>
						<a href="{{url('/raport')}}">
							<i class="icon-bullseye"></i>
							<span class="menu-text"> Raport activitate </span>
						</a>
					</li>
					@if($me->user_grouprank >= 6)
						<li>
							<a href="{{url('/leader')}}">
								<i class="icon-double-angle-right"></i>
								<span class="menu-text"> Leader Panel </span>
							</a>
						</li>
					@endif
				@endif
				@if($me->user_admin > 0)
					<li>
						<a href="{{url('/admin')}}">
							<i class="icon-sitemap red"></i>
							<span class="menu-text"> Admin Panel </span>
						</a>
					</li>
				@endif
				<li>
					<a href="{{url('/profile/'.$me->name)}}">
						<i class="icon-smile"></i>
						<span class="menu-text"> Profilul meu </span>
					</a>
				</li>
			@endif
			<li>
				<a href="{{url('/online')}}">
					<i class="icon-user"></i>
					<span class="menu-text"> Playeri conectati </span>
				</a>
			</li>
			<li>
				<a href="{{url('/staff')}}">
					<i class="icon-android"></i>
					<span class="menu-text"> Staff </span>
					<span class="badge badge-yellow">{{ $header_staff }}</span>
				</a>
			</li>
			<li>
				<a href="{{url('/beta')}}">
					<i class="icon-bug"></i>
					<span class="menu-text"> Beta testers </span>
				</a>
			</li>
			<li>
				<a href="{{url('/search')}}">
					<i class="icon-search"></i>
					<span class="menu-text"> Cauta un jucator </span>
				</a>
			</li>
			<li>
				<a href="{{url('/complaints')}}">
					<i class="icon-legal"></i>
					<span class="menu-text"> Reclamatii </span>
					<span class="badge badge-yellow">{{ $header_complaints }}</span>
				</a>
			</li>
			<li>
				<a href="{{url('/ban')}}">
					<i class="icon-frown"></i>
					<span class="menu-text"> Ban-uri </span>
				</a>
			</li>
			<li>
				<a href="{{url('/group/list')}}">
					<i class="icon-group"></i>
					<span class="menu-text"> Factiuni </span>
					<span class="badge badge-yellow">{{ $header_factions }}</span>
				</a>
			</li>
			<li>
				<a href="{{url('/clan')}}">
					<i class="icon-sitemap"></i>
					<span class="menu-text"> Clanuri </span>
				</a>
			</li>
			<li>
				<a href="#" class="dropdown-toggle">
					<i class="icon-signal"></i>
					<span class="menu-text"> Statistici </span>
					<b class="arrow icon-angle-down"></b>
				</a>
				<ul class="submenu">
					<li>
						<a href="{{url('/topplayers')}}">
							<i class="icon-double-angle-right"></i>
							Top jucatori
						</a>
					</li>
					<li>
						<a href="{{url('/houses')}}">
							<i class="icon-double-angle-right"></i>
							Case
						</a>
					</li>
					<li>
						<a href="{{url('/businesses')}}">
							<i class="icon-double-angle-right"></i>
							Afaceri
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="{{url('/bids')}}">
					<i class="icon-sitemap"></i>
					<span class="menu-text"> Licitatii </span>
					<span class="badge badge-yellow">{{ $header_bids }}</span>
				</a>
			</li>
			@if(is_object($me) && $me->user_admin > 0)
				<li>
					<a href="{{url('/logs')}}">
						<i class="icon-keyboard"></i>
						<span class="menu-text"> Logs </span>
					</a>
				</li>
			@endif
		</ul>
		<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
			<i id="sidebar-toggle-icon" class="ace-save-state ace-icon icon-double-angle-left" data-icon1="ace-icon icon-double-angle-left" data-icon2="ace-icon icon-double-angle-right"></i>
		</div>
	</div>

