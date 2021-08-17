<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li class="active">Top Players</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<table class="table table-hover">
		<tbody>
			<tr class="info table-bordered">
				<td>#</td>
				<td>Name</td>
				<td></td>
				<td>Level</td>
				<td>Playing hours</td>
				<td>Respect points</td>
			</tr>
		<tbody>
			<?php $c = 1 ?>
			<?php $__currentLoopData = $data->sortByDesc('user_hours'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td><?php echo e($c++); ?></td>
				<td><i class="icon-circle light-<?php echo e($user->user_status == 0 ? 'red' : 'green'); ?>"></i> &nbsp; <a href="<?php echo e(url('/profile/' . $user->name)); ?>"><?php echo e($user->name); ?></a></td>
				<td>
					<?php if($user->id == 1): ?>
						<span class="label label-pink arrowed-in-right"><i class="icon-gear white"></i> scripter</span>					
					<?php endif; ?>
					<?php if($user->user_admin > 5): ?>
						<span class="label label-success arrowed-in-right"><i class="icon-shield white"></i> owner</span>	
					<?php elseif($user->user_admin > 0): ?>
						<span class="label label-success arrowed-in-right"><i class="icon-shield white"></i> admin</span>											
					<?php endif; ?>	
					<?php if($user->user_helper > 0): ?>
						<span class="label label-purple arrowed-in-right"><i class="icon-question-sign white"></i> helper</span>											
					<?php endif; ?>
					<?php if($user->user_grouprank == 7): ?>
						<span class="label label-purple arrowed-in-right"><i class="icon-group white"></i> faction leader</span>										
					<?php endif; ?>																			
				</td>
				<td><?php echo e($user->user_level); ?></td>
				<td><?php echo e(round($user->user_hours , 0, PHP_ROUND_HALF_UP)); ?></td>
				<td><?php echo e($user->user_rp); ?></td>
			</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Top Players'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>