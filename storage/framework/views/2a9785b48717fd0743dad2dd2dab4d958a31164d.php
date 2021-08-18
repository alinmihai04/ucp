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

			<a href="<?php echo e(url('/')); ?>" class="brand">
				<small>
					<i class="icon-bug"></i>
					<?php echo e(config('app.title')); ?> Panel
				</small>
			</a>
			<ul class="nav ace-nav pull-right">
				<?php if(is_object($me)): ?>
					<li class="purple">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#" id="loadnotifications">
							<?php $emails = App\Header::headerLoadEmails(Auth::id()); ?>
							<?php if($emails > 0): ?>
								<i class="icon-bell-alt icon-animated-bell"></i>
								<span class='badge badge-important'><?php echo e($emails); ?></span>
							<?php else: ?>
								<i class="icon-bell-alt"></i>
								<span class='badge badge-grey'>0</span>
							<?php endif; ?>
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
				<?php endif; ?>
				<li class="light-blue">
					<?php if(!is_object($me)): ?>
						<a href="<?php echo e(url('/login')); ?>">Login</a>
					<?php else: ?>
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img class="nav-user-photo" src="<?php echo e(URL::asset('images/avatars/' . $me->user_skin)); ?>.png" astyle="height: 36px;" alt="Avatar" />
							<span class="user-info">
								<small>Welcome,</small>
								<?php echo e($me->name); ?>

							</span>

							<i class="icon-caret-down"></i>
						</a>
						<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
							<li>
								<a href="<?php echo e(url('/profile/'.$me->name.'')); ?>">
									<i class="icon-user"></i>
									Profilul meu
								</a>
							</li>
							<li>
								<a href="<?php echo e(url('/user/changemail/' . $me->id)); ?>">
								<i class="icon-envelope"></i>
									Schimba e-mail
								</a>
							</li>
							<li>
								<a href="<?php echo e(url('/account/security')); ?>">
								<i class="icon-lock"></i>
									Autentificare in doi pasi
								</a>
							</li>
							<li>
								<a href="<?php echo e(url('/mycomplaints')); ?>">
								<i class="icon-legal"></i>
									Reclamatii create de mine
								</a>
							</li>
							<li class="divider"></li>
							<li>
                                <a href="<?php echo e(route('logout')); ?>"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <i class="icon-off"></i>Deconectare
                                </a>

                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo e(csrf_field()); ?>

                                </form>
							</li>
						</ul>
					<?php endif; ?>
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
				<a href="<?php echo e(url('/')); ?>">
					<i class="icon-dashboard"></i>
					<span class="menu-text"> Home </span>
				</a>
			</li>
			<?php if(is_object($me)): ?>
				<?php if($me->user_group > 0): ?>
					<li>
						<a href="<?php echo e(url('/raport')); ?>">
							<i class="icon-bullseye"></i>
							<span class="menu-text"> Raport activitate </span>
						</a>
					</li>
					<?php if($me->user_grouprank >= 6): ?>
						<li>
							<a href="<?php echo e(url('/leader')); ?>">
								<i class="icon-double-angle-right"></i>
								<span class="menu-text"> Leader Panel </span>
							</a>
						</li>
					<?php endif; ?>
				<?php endif; ?>
				<?php if($me->user_admin > 0): ?>
					<li>
						<a href="<?php echo e(url('/admin')); ?>">
							<i class="icon-sitemap red"></i>
							<span class="menu-text"> Admin Panel </span>
						</a>
					</li>
				<?php endif; ?>
				<li>
					<a href="<?php echo e(url('/profile/'.$me->name)); ?>">
						<i class="icon-smile"></i>
						<span class="menu-text"> Profilul meu </span>
					</a>
				</li>
			<?php endif; ?>
			<li>
				<a href="<?php echo e(url('/online')); ?>">
					<i class="icon-user"></i>
					<span class="menu-text"> Playeri conectati </span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('/staff')); ?>">
					<i class="icon-android"></i>
					<span class="menu-text"> Staff </span>
					<span class="badge badge-yellow"><?php echo e($header_staff); ?></span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('/beta')); ?>">
					<i class="icon-bug"></i>
					<span class="menu-text"> Beta testers </span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('/search')); ?>">
					<i class="icon-search"></i>
					<span class="menu-text"> Cauta un jucator </span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('/complaints')); ?>">
					<i class="icon-legal"></i>
					<span class="menu-text"> Reclamatii </span>
					<span class="badge badge-yellow"><?php echo e($header_complaints); ?></span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('/ban')); ?>">
					<i class="icon-frown"></i>
					<span class="menu-text"> Ban-uri </span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('/group/list')); ?>">
					<i class="icon-group"></i>
					<span class="menu-text"> Factiuni </span>
					<span class="badge badge-yellow"><?php echo e($header_factions); ?></span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('/clan')); ?>">
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
						<a href="<?php echo e(url('/topplayers')); ?>">
							<i class="icon-double-angle-right"></i>
							Top jucatori
						</a>
					</li>
					<li>
						<a href="<?php echo e(url('/houses')); ?>">
							<i class="icon-double-angle-right"></i>
							Case
						</a>
					</li>
					<li>
						<a href="<?php echo e(url('/businesses')); ?>">
							<i class="icon-double-angle-right"></i>
							Afaceri
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="<?php echo e(url('/bids')); ?>">
					<i class="icon-sitemap"></i>
					<span class="menu-text"> Licitatii </span>
					<span class="badge badge-yellow"><?php echo e($header_bids); ?></span>
				</a>
			</li>
		</ul>
		<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
			<i id="sidebar-toggle-icon" class="ace-save-state ace-icon icon-double-angle-left" data-icon1="ace-icon icon-double-angle-left" data-icon2="ace-icon icon-double-angle-right"></i>
		</div>
	</div>

