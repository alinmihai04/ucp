<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li class="active">Online Players</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<div class="span12">
		<h4><?php echo e($g->group_name); ?> (<?php echo e($usersdata->where('user_group', '=', $g->group_id)->count()); ?> online)</h4>
			<?php $__currentLoopData = $usersdata->where('user_group', '=', $g->group_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="span2 center">
					<a href="<?php echo e(url('/profile/'.$u->name.'')); ?>"><img src="<?php echo e(URL::asset('images/avatars/'.$u->user_skin.'')); ?>.png" alt="<?php echo e($u->name); ?> - level <?php echo e($u->user_level); ?>" 
						title="<?php echo e($u->name); ?> - level <?php echo e($u->user_level); ?>"></a><br>
					<?php echo e($u->name); ?>

				</div>				
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
		<span class="clearfix"/>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<br>
	<b>Civilian (<?php echo e($usersdata->where('user_group', '=', 0)->count()); ?> online):</b>
	<table class="table">
		<tbody>
			<tr>
				<td>Name</td>
				<td>Level</td>
				<td>Hours played</td>
				<td>Respect points</td>
			</tr>
			<?php $__currentLoopData = $usersdata->where('user_group', '=', 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td><a href="<?php echo e(url('/profile/'.$u->name.'')); ?>"><?php echo e($u->name); ?></a></td>
					<td><?php echo e($u->user_level); ?></td>
					<td><?php echo e($u->user_hours); ?></td>
					<td><?php echo e($u->user_rp); ?></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => "".$usersdata->count()." Players Online"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>