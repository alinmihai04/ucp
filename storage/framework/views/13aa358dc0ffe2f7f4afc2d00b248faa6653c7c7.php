<?php $__env->startSection('content'); ?>
<?php if($data->status == 1): ?>
	<div class="alert alert-warning">This topic is closed. Only admins can reply to it!</div>
<?php elseif($data->status == 2): ?>
	<div class="alert alert-info">This topic was marked as an owner+ topic!</div>
<?php elseif($data->status == 3): ?>
	<div class="alert alert-danger">This topic was deleted. Only admin can see it!</div>
<?php endif; ?>

<div class="row-fluid">
	<div class="span4">
		<h4>Complaint against</h4>
		<hr>
		<img class="nav-user-photo img-circle pull-left" src="<?php echo e(URL::asset('/images/100/' . $against->user_skin)); ?>.png" alt="<?php echo e($against->name); ?> Avatar">
		<p class="pull-left">
			<a href="<?php echo e(url('/profile/' . $against->name)); ?>"><?php echo e($against->name); ?></a><br>
			Level: <?php echo e($against->user_level); ?><br>
			Faction: <?php echo e($against->user_group); ?><br>
			Hours played: <?php echo e($against->user_hours); ?><br>
			Warns: <?php echo e($against->user_warns); ?><br>
			<?php if($data->faction != 0): ?>
				Faction Warns: <?php echo e($against->user_fw); ?>/3
			<?php endif; ?>
		</p>
		<span class="clearfix"></span>
		<hr>
		<h4>Complaint status</h4>
		Status:
		<b>
			<?php if($data->status == 0): ?>
				Open
			<?php elseif($data->status == 1): ?>
				Closed
			<?php elseif($data->status == 2): ?>
				Waiting for owner reply
			<?php elseif($data->status == 3): ?>
				Deleted
			<?php endif; ?>
		</b><br>
		Admin replies: <b><abbr title="Optiunea aceasta va fi implementata in viitor.">N/A</abbr></b><br>
		Views: <b><abbr title="Optiunea aceasta va fi implementata in viitor.">N/A</abbr></b><br>
		Creat pe: <b><?php echo e($data->time); ?></b>
		<?php if(is_object($me) && $me->user_admin > 0): ?>
		<br> Posted from IP: <b><a href="<?php echo e(url('/logs/ip/invalid_nohash')); ?>"><?php echo e($data->ip); ?></a></b>
		<?php endif; ?>
		<span class="clearfix"></span>
		<hr>

		<?php if(is_object($me)): ?>
			<?php if($data->faction == 0 && $me->user_admin > 0): ?>

				<?php echo Form::open(['url' => url('/complaint/respond/' . $data->id) ]); ?>

				<?php if($data->reason == 1): ?>
			        <?php echo Form::submit('Jail pentru DM', ['class' => 'btn btn-small btn-purple', 'name' => 'dm', 'onclick' => 'return confirm("Esti sigur ca vrei sa-i dai acestui jucator jail pentru DM CU ARMA? Timpul de jail este calculat automat.");']); ?>

		        	<?php echo Form::submit('Jail pentru DM cu pumnii', ['class' => 'btn btn-small btn-purple', 'name' => 'dmp', 'onclick' => 'return confirm("Esti sigur ca vrei sa-i dai acestui jucator jail pentru DM CU PUMNII? Timpul de jail este calculat automat.");']); ?>

					<hr>
				<?php endif; ?>
				<?php echo Form::label('reason', 'Reason:'); ?>

				<?php echo Form::text('reason', ''); ?>

				<?php echo Form::label('time', 'Time:'); ?>

				<?php echo Form::text('time', ''); ?>


				<br>
				<p>Time = 999 pentru ban permanent</p>
		        <?php echo Form::submit('warn', ['class' => 'btn btn-small btn-purple', 'name' => 'warn', 'onclick' => 'return confirm("Esti sigur ca vrei sa-i dai acestui jucator un WARN? Acesta o sa fie banat automat daca acumuleaza 3/3 warns.");']); ?>

		        <?php echo Form::submit('ban', ['class' => 'btn btn-small btn-danger', 'name' => 'ban', 'onclick' => 'return confirm("Esti sigur?");']); ?>

		        <?php echo Form::submit('mute', ['class' => 'btn btn-small btn-grey', 'name' => 'mute', 'onclick' => 'return confirm("Esti sigur?");']); ?>

		        <?php echo Form::submit('jail', ['class' => 'btn btn-small btn-pink', 'name' => 'jail', 'onclick' => 'return confirm("Esti sigur?");']); ?>

		        <?php echo Form::submit('owner+', ['class' => 'btn btn-small btn-danger', 'name' => 'owner', 'onclick' => 'return confirm("Esti sigur?");']); ?>

				<?php echo Form::close(); ?>

				<hr>
				<?php if($data->reason == 4): ?>
					<h4>
						Last 20 transactions
					</h4>
					<hr>
					<ul>
						<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li>[<?php echo e($l->time); ?>] <?php echo e($l->text); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
					<?php echo Form::open(['url' => '/complaint/money/' . $data->id]); ?>

					<?php echo Form::label('money', 'Money:'); ?>

					<?php echo Form::text('money', '', ['placeholder' => 'ex: 100, -2000']); ?>

					<br>
					<select name="player">
						<option value="<?php echo e($data->user_id); ?>"><?php echo e(App\User::getName($data->user_id)); ?> - $<?php echo e(number_format(App\User::getMoney($data->user_id))); ?></option>
						<option value="<?php echo e($data->creator_id); ?>"><?php echo e(App\User::getName($data->creator_id)); ?> - $<?php echo e(number_format(App\User::getMoney($data->creator_id))); ?></option>
					</select>
					<br>

					<?php echo Form::submit('take/give money', ['class' => 'btn btn-small btn-success']); ?>

					<?php echo Form::close(); ?>

				<?php else: ?>
					<h4>
						Player punish logs
					</h4>
					<hr>
					<ul>
						<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li>[<?php echo e($l->time); ?>] <?php echo e($l->text); ?></li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				<?php endif; ?>
			<?php elseif($me->user_grouprank >= 6 && $me->user_group == $data->faction): ?>
				<?php if($against->user_fw == 2): ?>
					<b><span class="red">Acest player are deja 2/3 FW's.</span></b>
				<?php else: ?>
					<?php echo Form::open(['url' => url('/complaint/fw/' . $data->id) ]); ?>

					<?php echo Form::label('fw_reason', 'Give FW'); ?>

					<?php echo Form::text('fw_reason', '', ['placeholder' => 'FW reason']); ?>

					<br>
					<?php echo Form::submit('FW', ['name' => 'fw', 'class' => 'btn btn-small btn-danger', 'onclick' => 'return confirm("Esti sigur?");']); ?>

					<?php echo Form::close(); ?>

				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<div class="span8">
		<h4>Complaint details</h4>
		<hr>
		<b>Nickname: </b><a href="<?php echo e(url('/profile/' . $creator->name)); ?>"><?php echo e($creator->name); ?></a><br>
		<b>Level: </b><?php echo e($creator->user_level); ?><br>
		<b>Detalii: </b><?php echo nl2br(makeLinks($data->details)); ?><br>
		<b>Motiv reclamatie: </b><?php echo e(App\Complaint::$reason_text[$data->reason]); ?>

			<a href="<?php echo e(url('/complaint/reason/' . $data->id)); ?>">
				<?php if(is_object($me) && $me->user_admin > 0): ?>
					<i class="icon-edit"></i>
				<?php endif; ?>
			</a>
			<br>
		<b>Dovezi (screenshot-uri, video-uri): </b><?php echo nl2br(makeLinks($data->evidence)); ?><br>
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
						<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if($p->hidden == 1): ?>
								<?php if(!is_object($me) || $me->user_admin == 0): ?>
									<?php continue; ?>
								<?php endif; ?>
							<?php endif; ?>

							<div class="itemdiv dialogdiv">
								<div class="user">
									<img alt="<?php echo e($p->name); ?>'s Avatar" src="<?php echo e(URL::asset('/images/avatars/' . $p->user_skin)); ?>.png">
								</div>
								<div class="body <?php echo e($p->hidden == 1 ? 'alert-danger' : ''); ?>">
									<div class="time">
										<i class="icon-time"></i>
										<span class="green">
											<?php echo e(transdate(strtotime($p->time))); ?>

										</span>
									</div>
									<div class="text">
										<p>
											<a href="<?php echo e(url('/profile/' . $p->name )); ?>" title=""><?php echo e($p->name); ?></a>
											<?php if($p->user_id == $data->creator_id): ?>
												<span class="badge badge-info">complaint creator</span>
											<?php elseif($p->user_id == $data->user_id): ?>
												<span class="badge badge-important">reported player</span>
											<?php endif; ?>

											<?php if($p->user_admin > 5): ?>
												<span class="label label-purple arrowed arrowed-in-right">owner</span>
											<?php elseif($p->user_admin > 0): ?>
												<span class="label label-purple arrowed arrowed-in-right">admin</span>
											<?php endif; ?>

											<?php if($p->user_helper > 0): ?>
												<span class="label label-blabla arrowed arrowed-in-right">helper</span>
											<?php endif; ?>
											<?php if($p->user_grouprank == 7): ?>
												<span class="label label-blabla arrowed arrowed-in-right">faction leader</span>
											<?php endif; ?>
											<br>
											<span class="comment">
												<?php echo nl2br(makeLinks($p->text)); ?>

											</span>
											<span class="pull-right">
												<?php if(is_object($me) && ($me->id == $p->user_id || $me->user_admin >= 3)): ?>

													<?php if($me->user_admin >= 3): ?>
														<?php if($p->hidden == 0): ?>
															<a href="<?php echo e(url('/post/delete/' . $p->id)); ?>" onclick="return confirm('Esti sigur ca vrei sa ascunzi acest comentariu?');"><i class="icon-trash red"></i></a>
														<?php else: ?>
															<a href="<?php echo e(url('/post/delete/' . $p->id)); ?>" onclick="return confirm('Esti sigur ca vrei sa restaurezi acest comentariu?');"><i class="icon-check red"></i></a>
														<?php endif; ?>
													<?php endif; ?>
												<?php endif; ?>
											</span>
										</p>
									</div>
								</div>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php echo Form::open(['class' => 'form-horizontal', 'style' =>'margin: 0 15px 20px 60px;', 'url' => '/post/reply/' . $data->id]); ?>

						<h5>Leave a reply</h5>
					<?php if(!is_object($me)): ?>
						<?php echo Form::textarea('reply', '', ['class' => 'input-block-level', 'placeholder' => "You can't reply to this topic: You are not logged in.", 'cols' => '', 'rows' => '', 'disabled']); ?>

						<br><br>
						<?php echo Form::submit('Post', ['class' => 'btn btn-small btn-danger', 'disabled']); ?>

					<?php elseif($data->status != 0 && (($data->faction == 0 && $me->user_admin == 0) || ($data->faction >= 1 && ($me->user_grouprank < 6 || $me->user_group != $data->faction)))): ?>
						<?php echo Form::textarea('reply', '', ['class' => 'input-block-level', 'placeholder' => "You can't reply to this topic: This topic is closed.", 'cols' => '', 'rows' => '', 'disabled']); ?>

						<br><br>
						<?php echo Form::submit('Post', ['class' => 'btn btn-small btn-danger', 'disabled']); ?>

					<?php elseif(time() - session('post_delay') < 120): ?>
						<?php echo Form::textarea('reply', '', ['class' => 'input-block-level', 'placeholder' => "Poti adauga un comentariu o data la 2 minute. Mai poti adauga un comentariu peste: " . (120 - (time() - session('post_delay'))) . " secunde", 'cols' => '', 'rows' => '', 'disabled']); ?>

						<br><br>
						<?php echo Form::submit('Post', ['class' => 'btn btn-small btn-danger', 'disabled']); ?>

					<?php else: ?>
						<?php echo Form::textarea('reply', '', ['class' => 'input-block-level', 'placeholder' => 'reply text...', 'cols' => '', 'rows' => '']); ?>

						<br><br>
						<?php echo Form::submit('Post', ['class' => 'btn btn-small btn-danger']); ?>

					<?php endif; ?>

					<?php if(is_object($me) && (($me->user_group == $data->faction && $me->user_grouprank >= 6) || $me->user_admin > 0)): ?>
						<?php if($data->status == 0 || $data->status == 2): ?>
							<?php echo Form::submit('Post and close', ['class' => 'btn btn-small btn-danger', 'name' => 'postclose', 'onclick' => 'return confirm("Esti sigur ca vrei sa inchizi aceasta reclamatie?");']); ?>

						<?php elseif($data->status == 1): ?>
							<?php echo Form::submit('Re-open', ['class' => 'btn btn-small btn-danger', 'name' => 'postclose', 'onclick' => 'return confirm("Esti sigur ca vrei sa redeschizi aceasta reclamatie?");']); ?>

						<?php endif; ?>
						<?php if($me->user_admin >= 3): ?>
							<?php if($data->status != 3): ?>

								<?php echo Form::submit('Delete', ['class' => 'btn btn-small btn-danger', 'name' => 'delete', 'onclick' => 'return confirm("Esti sigur ca vrei sa stergi aceasta reclamatie?");']); ?>

							<?php else: ?>
								<?php echo Form::submit('Undo delete', ['class' => 'btn btn-small btn-danger', 'name' => 'delete', 'onclick' => 'return confirm("Esti sigur ca vrei sa restaurezi aceasta reclamatie?");']); ?>

							<?php endif; ?>
						<?php endif; ?>
						<br><br>
					<?php endif; ?>

					<?php echo Form::close(); ?>

				</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Complaint against ' . $against->name], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>