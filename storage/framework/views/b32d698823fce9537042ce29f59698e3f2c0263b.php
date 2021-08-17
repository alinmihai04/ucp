<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li class="active"><?php echo e($data->name); ?>'s profile</li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<?php if(is_object($banstats)): ?>
<div class="alert alert-danger">
	<b>This account is banned.</b>
	<br>
	<br>
	Banat de: <b><?php echo e($banstats->ban_adminname); ?></b> pe data de <b><?php echo e($banstats->ban_currenttime); ?></b>, motivul banului: <b><?php echo e($banstats->ban_reason); ?></b><br>
	<?php if($banstats->ban_permanent == 1): ?>
		Contul este banat permanent (banul nu va expira automat).
	<?php else: ?>
		Banul expira pe data de  <b><?php echo e(date('d M Y, H:i', $banstats->ban_expiretimestamp)); ?></b>
		<?php if($auth && $me->user_admin >= 5): ?>
			 <a href="<?php echo e(url('admin/unban/' . $data->id )); ?>" onclick="return confirm('Esti sigur ca vrei sa debanezi acest jucator?');">unban</a> / cost unban: <?php echo e(!$banstats->ban_ppunban ? "50 puncte premium" : "nu poate cumpara"); ?>

		<?php endif; ?>
	<?php endif; ?>
</div>
<?php endif; ?>


<?php if($auth && $me->user_admin >= 5 && !is_null($data->user_admnote)): ?>
	<div class="alert alert-info"><b></b><?php echo nl2br($data->user_admnote); ?> <br><br><b>/ <a href="<?php echo e(url('/admin/note/' . $data->id)); ?>">edit</a></b></div>
<?php endif; ?>

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
	<?php if($auth && $me->user_admin > 0): ?>
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
		<span class="badge badge-info"><?php echo e($complaints->count()); ?></span>
		</a>
	</li>
	<?php endif; ?>
</ul>
<div class="tab-content no-border padding-24">
	<div id="feed" class="tab-pane">
		<div class="profile-feed row-fluid">
			<div class="span6">
				<?php $__currentLoopData = $flog->where('hidden', '=', 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="profile-activity clearfix">
						<div>
							<img class="pull-left" alt="<?php echo e($data->name); ?>'s avatar" src="<?php echo e(URL::asset('images/avatars/' . $data->user_skin)); ?>.png"/>
							<?php echo e($f->text); ?>

							<div class="time">
								<i class="icon-time bigger-110"></i>
								<?php echo e($f->time); ?>

								<?php if($auth && $me->user_admin >= 5): ?>
									<a href="<?php echo e(url('/admin/editfh/' . $data->id . '/' . $f->id)); ?>"> <i class="icon-edit"></i></a>
									<a href="<?php echo e(url('/admin/hidefh/' . $data->id . '/' . $f->id)); ?>" onclick="return confirm('Esti sigur?'); "> <i class="icon-remove-circle red"></i></a>

									<?php if($f->edited == 1): ?>
										<a href="<?php echo e(url('/admin/historyfh/' . $f->id)); ?>" style="color: grey; text-decoration: none;">[edited]</a>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php if($auth && $me->user_admin > 0): ?>
					<?php $__currentLoopData = $flog->where('hidden', '=', 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="profile-activity clearfix alert-danger">
							<div>
								<img class="pull-left" alt="<?php echo e($data->name); ?>'s avatar" src="<?php echo e(URL::asset('images/avatars/'.$data->user_skin.'')); ?>.png"/>
								<?php echo e($f->text); ?>

								<div class="time">
									<i class="icon-time bigger-110"></i>
									<?php echo e($f->time); ?>

									<?php if($auth && $me->user_admin >= 5): ?>
										<a href="<?php echo e(url('/admin/editfh/'.$data->id.'/'.$f->id)); ?>"> <i class="icon-edit"></i></a>
										<a href="<?php echo e(url('/admin/hidefh/'.$data->id.'/'.$f->id)); ?>" onclick="return confirm('Esti sigur?'); "> <i class="icon-remove-circle green"></i></a>

										<?php if($f->edited == 1): ?>
											<a href="<?php echo e(url('/admin/historyfh/'.$f->id)); ?>" style="color: grey; text-decoration: none;">[edited]</a>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if($auth && $me->user_admin > 0): ?>
	<div id="admtools" class="tab-pane">
		<div class="profile-feed row-fluid">
			<div class="span8">
				<h4>Player punish logs</h4>
				<div class="hr hr8 hr-double"></div>

				<?php $__currentLoopData = $lpdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="profile-activity clearfix">
						<div>
							<img class="pull-left" alt="<?php echo e($data->name); ?>'s avatar" src="<?php echo e(URL::asset('images/avatars/'.$data->user_skin)); ?>.png"/>
							<?php echo e($l->text); ?>

							<div class="time">
								<i class="icon-time bigger-110"></i>
								<?php echo e($l->time); ?>

							</div>
						</div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
			<div class="span4">
				<h4>Admin+ Tools</h4>
				<div class="hr hr8 hr-double"></div>
				<ul>
					<li><a href="<?php echo e(url('/admin/refresh/'.$data->id)); ?>" onclick="return confirm('Esti sigur ca vrei sa stergi cache-ul pentru acest jucator? Asta poate cauza incarcarea lenta a unor pagini.');">refresh player profile</a></li>
					<?php if($me->user_admin > 5): ?>
						<li><a href="<?php echo e(url('/admin/note/' . $data->id)); ?>">add/edit note</a></li>
						<li><a href="<?php echo e(url('/admin/func/' . $data->id)); ?>">add/edit admin function</a></li>
						<li><a href="<?php echo e(url('/admin/givepp/' . $data->id)); ?>">give/take premium points</a></li>
					<?php endif; ?>
				</ul>
				<h4>Admin Tools</h4>
				<div class="hr hr8 hr-double"></div>
				<ul>
					<li><a href="<?php echo e(url('/logs/admin/' . $data->id)); ?>">admin logs</a></li>
					<li><a href="<?php echo e(url('/logs/important/'.$data->id)); ?>">player important logs</a></li>
					<li><a href="<?php echo e(url('/logs/player/'.$data->id)); ?>">player logs</a></li>
					<li><a href="<?php echo e(url('/logs/chat/'.$data->id)); ?>">chat logs</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div id="complaints" class="tab-pane">
		<div class="profile-feed row-fluid">
			<h4>Complaints against (<?php echo e($complaints->where('user_id', '=', $data->id )->count()); ?>)</h4>
			<div class="hr hr8 hr-double"></div>

			<ul>
				<?php $__currentLoopData = $complaints->where('user_id', '=', $data->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li>[<?php echo e($complaint->time); ?>] <a href="<?php echo e(url('/complaint/view/' . $complaint->id)); ?>">By <?php echo e($complaint->creator_name); ?>, reason: <?php echo e(App\Complaint::$reason_text[$complaint->reason]); ?></a></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>

			<h4>Complaints by (<?php echo e($complaints->where('creator_id', '=', $data->id )->count()); ?>)</h4>
			<div class="hr hr8 hr-double"></div>

			<ul>
				<?php $__currentLoopData = $complaints->where('creator_id', '=', $data->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li>[<?php echo e($complaint->time); ?>] <a href="<?php echo e(url('/complaint/view/' . $complaint->id)); ?>">Against <?php echo e($complaint->user_name); ?>, reason: <?php echo e(App\Complaint::$reason_text[$complaint->reason]); ?></a></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	</div>
	<?php endif; ?>
	<div id="userbar" class="tab-pane">
		<div class="profile-feed row-fluid">
			<div class="span12 center">
				<h4 class="blue">Userbar</h4>
				<img src="<?php echo e(url('/userbar/'.$data->name)); ?>" alt="userbar"></br></br>
				<b>Cod pentru forum <?php echo e(config('app.title')); ?>:</b><br /><input type="text" style="width:250px" disabled value="[rpg=<?php echo e($data->name); ?>]" />
				<br/><br/>
				<b>Cod HTML pentru alte site-uri:</b><br /><input type="text" style="width:250px" disabled value="[url=&quot;<?php echo e(url('')); ?>&quot;][img]<?php echo e(url('/userbar/'.$data->name)); ?>[/img][/url]" />
			</div>
		</div>
	</div>
	<div id="home" class="tab-pane active">
		<div class="row-fluid">
			<div class="span2 center">
				<span class="profile-picture">
					<img class="pull-left" alt="<?php echo e($data->name); ?>'s avatar" src="<?php echo e(URL::asset('images/skins/'.$data->user_skin.'.png')); ?>" style="height:300px;"/>
				</span>
				<div class="space-4"></div>
				<div class="width-80 label label-inverse arrowed-in arrowed-in-right">
					<div class="inline position-relative">
						<?php echo !$data->user_status ? "<i class='icon-circle light-red middle'></i>" : "<i class='icon-circle light-green middle'></i>"; ?>

						&nbsp;
						<span class="white"><?php echo e(!$data->user_status ? "offline" : "online"); ?></span>
					</div>
				</div>
				<div class="space-4"></div>
				<?php if($auth && $data->id == $me->id): ?>
					<a class="btn btn-warning btn-small" href="<?php echo e(url('/pm')); ?>"><i class="icon-envelope"></i> Mesajele mele</a>
				<?php else: ?>
					<a class="btn btn-danger btn-small" href="<?php echo e(url('/complaint/create/' . $data->id)); ?>"><i class="icon-legal"></i> Reclama player</a>
				<?php endif; ?>
				<div class="space-4"></div>
				<?php if($auth): ?>
					<?php if($data->id != $me->id): ?>
						<a class="btn btn-warning btn-small" href="<?php echo e(url('/pm')); ?>"><i class="icon-envelope"></i> Trimite mesaj</a>
						<div class="space-4"></div>
						<?php if($friends->where('friendof', '=', $me->id)->count() >= 1): ?>
							<a class="btn btn-danger btn-small" href="<?php echo e(url('/friends/remove/' . $data->id)); ?>"><i class="icon-user"></i> Sterge prieten</a>
						<?php else: ?>
							<a class="btn btn-success btn-small" href="<?php echo e(url('/friends/add/' . $data->id)); ?>"><i class="icon-plus"></i> Adauga prieten</a>
						<?php endif; ?>
					<?php endif; ?>
					<?php if($me->id == $data->id && $data->user_group != 0): ?>
						<hr>
						<?php if($data->user_shownskin == 0): ?>
							<a class="btn btn-info btn-small" href="<?php echo e(url('/shownskin/1')); ?>">Afiseaza skin-ul normal</a>
						<?php else: ?>
							<a class="btn btn-info btn-small" href="<?php echo e(url('/shownskin/0')); ?>">Afiseaza skin-ul factiunii</a>
						<?php endif; ?>

					<?php endif; ?>
				<?php endif; ?>
				<div class="space-4"></div>
			</div>
			<div class="span10">
				<h4 class="blue">
					<span class="middle">
						<?php echo e($data->name); ?>

						<?php if($auth && $me->user_admin > 4): ?>
							<?php if($data->user_fnc == 0): ?>
								<a href="<?php echo e(url('/admin/fnc/' . $data->id)); ?>"><i class="icon-edit"></i></a>
							<?php endif; ?>
						<?php endif; ?>
					</span>
				</h4>
				<?php if($data->user_admin >= 6): ?>
					<span class="label label-success arrowed-in-right"><i class="icon-shield white"></i> owner </span><br>
				<?php elseif($data->user_admin < 6 && $data->user_admin > 0): ?>
					<span class="label label-success arrowed-in-right"><i class="icon-shield white"></i> admin </span><br>
				<?php endif; ?>
				<?php if($data->id == 1): ?>
					<span class="label label-pink arrowed-in-right"><i class="icon-gear white"></i> scripter </span><br>
				<?php endif; ?>
				<?php if($data->user_clanrank == 7): ?>
					<span class="label label-blue arrowed-in-right"><i class="icon-group white"></i> <a href="<?php echo e(url('/clan/view/'.$data->user_clan.'')); ?>" style='color: #FFF'>clan owner</a> </span><br>
				<?php endif; ?>
				<?php if($data->user_helper > 0): ?>
					<span class="label label-purple arrowed-in-right"><i class="icon-question-sign white"></i> helper </span><br>
				<?php endif; ?>
				<?php if($data->user_grouprank == 7): ?>
					<span class="label label-purple arrowed-in-right"><i class="icon-group white"></i> faction leader </span><br>
				<?php endif; ?>
				<?php if($data->user_premium == 1): ?>
					<span class="label label-yellow arrowed-in-right"><i class="icon-star grey"></i> premium user </span><br>
				<?php elseif($data->user_premium == 2): ?>
					<span class="label label-yellow arrowed-in-right"><i class="icon-star grey"></i> Legend </span><br>
				<?php endif; ?>
				<?php if($data->user_support > 0): ?>
					<span class="label label-purple arrowed-in-right"><i class="icon-ticket white"></i> support </span><br>
				<?php endif; ?>
				<?php if(!is_null($data->user_admfunc) && $data->user_admin > 0): ?>
					<?php if($auth && $me->user_admin > 5): ?>
						<a href="<?php echo e(url('/admin/func/'.$data->id.'')); ?>"><span class="label label-purple arrowed-in-right"><i class="icon-gear white"></i> <?php echo e($data->user_admfunc); ?> </span></a><br>
					<?php else: ?>
						<span class="label label-purple arrowed-in-right"><i class="icon-gear white"></i> <?php echo e($data->user_admfunc); ?> </span><br>
					<?php endif; ?>
				<?php endif; ?>
				<?php if($data->user_beta > 0): ?>
					<span class="label label-pink arrowed-in-right"><i class="icon-bug white"></i> beta tester </span><br>
				<?php endif; ?>

				<?php if($auth && $me->user_admin > 5): ?>
					<?php if($data->user_admin > 0): ?>
						<?php if(is_null($data->user_admfunc)): ?>
							<a href="<?php echo e(url('/admin/func/'.$data->id.'')); ?>">add admin function</a><br>
						<?php endif; ?>
					<?php endif; ?>
					<?php if($data->user_beta == 0): ?>
						<a href="<?php echo e(url('/admin/makebeta/'.$data->id.'')); ?>" onclick="return confirm('Esti sigur ca vrei sa ii oferi acestui utilizator gradul de Beta Tester?');">make beta tester</a><br>
					<?php elseif($data->user_beta > 0): ?>
						<a href="<?php echo e(url('/admin/makebeta/'.$data->id.'')); ?>" onclick="return confirm('Esti sigur ca vrei sa ii SCOTI gradul de Beta Tester acestui utilizator?');">remove beta tester</a><br>
					<?php endif; ?>
				<?php endif; ?>
				<br>
	  	 		<div class="profile-user-info">
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Faction
                		</div>
                		<div class="profile-info-value">
                			<?php if($data->user_group > 0): ?>
                				<?php echo e(App\Group::getGroupName($data->user_group)); ?> <a href="<?php echo e(url('/group/members/'.$data->user_group)); ?>"><i class="icon-external-link"></i></a>, rank <?php echo e($data->user_grouprank); ?>

                			<?php else: ?>
                				Civilian
                			<?php endif; ?>
                		</div>
            		</div>
            		<?php if($data->user_clan > 0): ?>
              		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Clan
                		</div>
                		<div class="profile-info-value">
                			<?php echo e(App\Clan::getClanName($data->user_clan)); ?> <a href="<?php echo e(url('/clan/view/'.$data->user_clan.'')); ?>"><i class="icon-external-link"></i></a>, rank <?php echo e($data->user_clanrank); ?>

                		</div>
            		</div>
            		<?php endif; ?>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Level
                		</div>
                		<div class="profile-info-value">
                			<?php echo e($data->user_level); ?>

                		</div>
            		</div>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Playing hours
                		</div>
                		<div class="profile-info-value">
                			<?php echo e(round($data->user_hours, 0, PHP_ROUND_HALF_UP)); ?>

                		</div>
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Phone
                		</div>
                		<div class="profile-info-value">
                			<?php echo e($data->user_phonenr); ?>

                		</div>
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Joined
                		</div>
                		<div class="profile-info-value">
                			<?php echo e($data->user_registered); ?>

                		</div>
            		</div>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Last Online
                		</div>
                		<div class="profile-info-value">
                			<?php echo e($data->last_login); ?>

                		</div>
            		</div>
            		<?php if($auth && (Auth::id() == $data->id || $me->user_admin > 0)): ?>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Money
                		</div>
                		<?php if($me->user_admin >= 6): ?>
           		 			<div class="profile-info-value"><a href="<?php echo e(url('/admin/money/' . $data->id)); ?>" style="color: inherit;">$<?php echo e(number_format($data->user_money)); ?> / $<?php echo e(number_format($data->user_bankmoney)); ?></a></div>
                		<?php else: ?>
	           				<div class="profile-info-value">
	                			$<?php echo e(number_format($data->user_money)); ?> / $<?php echo e(number_format($data->user_bankmoney)); ?>

	                		</div>
                		<?php endif; ?>
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Materials
                		</div>
                		<div class="profile-info-value">
                			<?php echo e($data->user_mats); ?>

                		</div>
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Reward Points
                		</div>
                		<div class="profile-info-value">
                			<?php echo e($data->user_rewardpoints); ?>

                		</div>
            		</div>
             		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Premium
                		</div>
                		<div class="profile-info-value">
                			<?php echo e($data->user_premium > 0 ? "Yes" : "No"); ?> (<?php echo e($data->user_premiumpoints); ?> premium points)
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
                			<?php echo e($data->user_email); ?> <a href="<?php echo e(url('/changemail/'.$data->id)); ?>"><i class="icon-edit"></i></a>
                		</div>
            		</div>
            		<?php endif; ?>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Warnings
                		</div>
                		<div class="profile-info-value">
                			<?php echo e($data->user_warns); ?>/3
                		</div>
            		</div>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Faction Warns
                		</div>
                		<div class="profile-info-value">
                			<?php if($data->user_group == 0): ?>
                				0/3
                			<?php else: ?>
                				<?php echo e($data->user_fw); ?>/3
                			<?php endif; ?>
                		</div>
            		</div>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Faction Punish
                		</div>
                		<div class="profile-info-value">
                			<?php echo e($data->user_fp); ?>/40
                		</div>
            		</div>
            		<div class="profile-info-row">
                		<div class="profile-info-name">
                			Job
                		</div>
                		<div class="profile-info-value">
                			<?php if($data->user_job == 0): ?>
                				Unemployed
                			<?php else: ?>
                				<?php echo e(App\Job::getJobName($data->user_job)); ?>

                			<?php endif; ?>
                		</div>
            		</div>
            		<?php if($data->user_jailtime >= 1): ?>
	            		<div class="profile-info-row">
	                		<div class="profile-info-name">
	                			Jailed
	                		</div>
	                		<div class="profile-info-value">
	                			<?php echo e(intval($data->user_jailtime / 60)); ?> minutes
	                		</div>
	            		</div>
            		<?php endif; ?>
            		<?php if($auth && ($me->user_admin >= 1 || $me->id == $data->id)): ?>
	             		<div class="profile-info-row">
	                		<div class="profile-info-name">
	                			Online last 7 days
	                		</div>
	                		<div class="profile-info-value">
	                			<?php if($me->user_admin >= 1): ?>
	                				<?php echo e(App\User::last7($data->id)); ?>

	                				<a href="<?php echo e(url('/user/hours/' . $data->id)); ?>"><i class="icon-plus"></i></a>
	                			<?php else: ?>
	                				<?php echo e(App\User::last7($data->id)); ?>

	                			<?php endif; ?>
	                		</div>
	            		</div>
            		<?php endif; ?>
            		<?php if($auth && $me->user_admin > 4 && $data->user_fnc == 1): ?>
	            		<div class="profile-info-row">
	            			<div class="profile-info-name">
	            				<span class="text-error">Panel FNC</span>
	            			</div>
	                		<div class="profile-info-value">
	                			<span class="text-error">
	                				Acest player este fortat sa isi schimbe nickaname-ul la urmatoare logare pe server. <br>Motiv: <b><?php echo e($data->user_fncreason); ?></b>
	                			</span>
	                		</div>
	            		</div>
            		<?php endif; ?>
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
								<?php if($vehicles->isEmpty()): ?>
									<p>This player has no vehicles.</p>
								<?php else: ?>
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
										<?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php if($v->vehicle_vip): ?>
												<tr class='warning'>
											<?php else: ?>
												<tr>
											<?php endif; ?>
											<td class='center'>
												<img src="<?php echo e(URL::asset('images/vehicles/Vehicle_'.$v->vehicle_model.'')); ?>.jpg" alt="<?php echo e($v->vehicle_model); ?>" style="height: 65px"/>
											</td>
											<td>
												<?php echo e(App\Vehicle::$namevehicles[$v->vehicle_model]); ?>

												<?php if($v->vehicle_vip == 1): ?>
													<p><br><b class='text-error'>VIP Vehicle</b><br>Text: <span style="color: #<?php echo e($v->vehicle_vipcolor); ?>; -webkit-text-stroke-width: 0.001px;
   														-webkit-text-stroke-color: black;"><b><?php echo e($v->vehicle_vipname); ?></b></span>
												<?php endif; ?>
											</td>
											<td>
												Odometter: <b><?php echo e($v->vehicle_km); ?> km</b><br>
												Colors: <span style="color: <?php echo App\Vehicle::$vehColors[$v->vehicle_color1]; ?>; font-weight: bold;"><?php echo e($v->vehicle_color1); ?></span>,
												<span style="color: <?php echo e(App\Vehicle::$vehColors[$v->vehicle_color2]); ?>; font-weight: bold;"><?php echo e($v->vehicle_color2); ?></span><br>
												Age: <b><?php echo e($v->vehicle_days); ?> days</b><br>
											</td>
											<td>
												<a href="<?php echo e(url('/map/'.$v->vehicle_posX.'/'.$v->vehicle_posY)); ?>"><i class="icon-map-marker"></i> display on map</a>
												<?php if($auth && $me->user_admin > 0): ?>
													<br>
													<a href="<?php echo e(url('/logs/vehicle/'.$v->id.'')); ?>"><i class="icon-archive"></i> view logs - id: <?php echo e($v->id); ?></a>
												<?php endif; ?>
											</td>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
								<?php endif; ?>
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
								<?php if(!$house): ?>
									<p>This player doesn't own a house.</p>
								<?php else: ?>
									House ID: <b><?php echo e($house->id); ?></b><br />
									Rent: <b>$<?php echo e(number_format($house->house_rent)); ?></b><br>
									Price: <b><?php echo $house->house_price == 0 ? "Not for sale" : "$" . number_format($house->house_price); ?></b><br>
									Interior size:
									<b>
									<?php if($house->house_size == 1): ?>
										Small
									<?php elseif($house->house_size == 2): ?>
										Medium
									<?php else: ?>
										Large
									<?php endif; ?>
									</b><br>
									<a href='<?php echo e(url('/map/'.$house->house_exterior_posX.'/'.$house->house_exterior_posY)); ?>'><i class='icon-map-marker'></i> display on map</a>
									<?php if($auth && $me->user_admin > 0): ?>
										<br>
										<a href="<?php echo e(url('/logs/house/' . $house->id)); ?>"><i class="icon-archive"></i> view logs</a>
									<?php endif; ?>
								<?php endif; ?>
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
								<?php if(!$biz): ?>
									<p>This player doesn't own a business.</p>
								<?php else: ?>
									Business ID: <b><?php echo e($biz->id); ?></b><br />
									Business Fee: <b>$<?php echo e(number_format($biz->biz_fee)); ?></b><br>
									Price: <b><?php echo $biz->biz_price == 0 ? "Not for sale" : "$" . number_format($biz->biz_price); ?></b><br>
									<a href='<?php echo e(url('/map/' . $biz->biz_exterior_posX . '/' . $biz->biz_exterior_posY)); ?>'><i class='icon-map-marker'></i> display on map</a>
									<?php if($auth && $me->user_admin > 0): ?>
										<br>
										<a href="<?php echo e(url('/logs/biz/' . $house->id)); ?>"><i class="icon-archive"></i> view logs</a>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => "".$data->name."'s profile"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>