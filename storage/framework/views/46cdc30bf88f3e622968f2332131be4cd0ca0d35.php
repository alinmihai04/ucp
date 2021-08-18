<?php $__env->startSection('content'); ?>

<div class="span8">
	<div class="page-header">
		<h1>Admin Control Panel (for admin <?php echo e($me->user_admin); ?>)</h1>
	</div>
	<?php if($me->user_admin >= 6): ?>
		<ul>
			<li><a href="<?php echo e(url('/admin/clearcache')); ?>" onclick="return confirm('Esti sigur ca vrei sa stergi cache-ul? Aceasta actiune va solicita baza de date.')">clear panel cache</a></li>
			<li><a href="<?php echo e(url('/admin/resetraport')); ?>">RESETEAZA RAPOARTELE DE ACTIVITATE (DEBUG) - in mod normal se executa task in fiecare zi la ora 20:00</a></li>
		</ul>
	<?php endif; ?>

	<br>
	<h3>Manage Factions</h3>
	<hr>
	<?php if($me->user_admin >= 6): ?>
		<?php echo Form::open(['url' => url('/raport/hours')]); ?>


		<?php echo Form::label('hours', 'Seteaza orele minime pentru raportul de activitate (se aplica pentru toate factiunile):'); ?>

		<?php echo Form::text('hours', '', ['placeholder' => 'ex: 5']); ?>

		<br>
		<?php echo Form::submit('Seteaza ore', ['class' => 'btn btn-danger btn-small']); ?>

		<?php echo Form::close(); ?>

	<?php endif; ?>
	<?php $__currentLoopData = $groupdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<h4>
			<?php if($g->group_type == 1): ?>
				<i class="icon-legal blue"></i>
			<?php elseif($g->group_type == 2): ?>
				<i class="icon-bullseye red"></i>
			<?php elseif($g->group_type == 3): ?>
				<i class="icon-dollar orange"></i>
			<?php elseif($g->group_type == 4): ?>
				<i class="icon-camera pink"></i>
			<?php elseif($g->group_type == 5): ?>
				<i class="icon-suitcase green"></i>
			<?php elseif($g->group_type == 6): ?>
				<i class="icon-bullseye purple"></i>
			<?php elseif($g->group_type == 7): ?>
				<i class="icon-ambulance red"></i>
			<?php endif; ?>
			<?php echo e($g->group_name); ?>

		</h4>
		<ul>
			<li>
				<?php if($g->group_application == 1): ?>
					<a href="<?php echo e(url('/group/app/' . $g->group_id)); ?>">close applications</a>
				<?php else: ?>
					<a href="<?php echo e(url('/group/app/' . $g->group_id)); ?>" onclick="return confirm('Are you sure?');">open applications</a>
				<?php endif; ?>
			</li>
			<?php if($me->user_admin >= 3): ?>
				<li>
					<a href="<?php echo e(url('/admin/grouplevel/' . $g->group_id)); ?>">set minimum level (<?php echo e($g->group_level); ?>)</a>
				</li>
				<li>
					<a href="<?php echo e(url('/admin/groupslots/' . $g->group_id)); ?>">set group slots (<?php echo e($g->group_slots); ?>)</a>
				</li>
			<?php endif; ?>
			<?php if($me->user_admin >= 6): ?>
				<li>
					<a href="<?php echo e(url('/raport/' . $g->group_id)); ?>">edit raport</a>
				</li>
				<li>
					<a href="<?php echo e(url('/group/skins/' . $g->group_id)); ?>">edit group skins</a>
				</li>
			<?php endif; ?>
		</ul>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="span4">
	<div class="page-header">
		<h1>Server Statistics</h1>
	</div>

	<h4>Logs Statistics - <?php echo e(number_format($total)); ?> logs</h4>
	<hr>

	<ul>
		<li>Player Logs - <b><?php echo e(number_format($player_logs)); ?></b> logs, <b><?php echo e(number_format((($player_logs/$total) * 100))); ?>%</b> from total</li>
		<li>Chat Logs - <b><?php echo e(number_format($chat_logs)); ?></b> logs, <b><?php echo e(number_format((($chat_logs/$total) * 100))); ?>%</b> from total</li>
		<li>Kill Logs - <b><?php echo e(number_format($kill_logs)); ?></b> logs, <b><?php echo e(number_format((($kill_logs/$total) * 100))); ?>%</b> from total</li>
		<li>IP Logs - <b><?php echo e(number_format($ip_logs)); ?></b> logs, <b><?php echo e(number_format((($ip_logs/$total) * 100))); ?>%</b> from total</li>
		<li>Punish Logs - <b><?php echo e(number_format($punish_logs)); ?></b> logs, <b><?php echo e(number_format((($punish_logs/$total) * 100))); ?>%</b> from total</li>
	</ul>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Admin Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>