<?php $__env->startSection('content'); ?>

<table class="table">
	<tbody>
		<tr class="info">
			<td>Player</td>
			<td>Ban Date</td>
			<td>Ban Reason</td>
			<td>Banned by</td>
			<td>Ban Expire at</td>
			<td>IP Ban</td>
		</tr>

		<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td><a href="<?php echo e(url('/profile/' . App\User::getName($d->ban_playerid))); ?>"><?php echo e(App\User::getName($d->ban_playerid)); ?></a></td>
				<td><?php echo e($d->ban_currenttime); ?></td>
				<td><?php echo e($d->ban_reason); ?></td>
				<td><?php echo e($d->ban_adminname); ?></td>
				<td>
					<?php if($d->ban_permanent == 1): ?>
						permanent
					<?php elseif($d->ban_expiretimestamp == 0): ?>
						ban expired / unbanned  
					<?php else: ?>
						<?php echo date('j M Y, H:i', $d->ban_expiretimestamp); ?>

					<?php endif; ?>
				</td>
				<td><?php echo e($d->ban_ipban == 1 ? 'yes' : 'no'); ?></td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</tbody>
</table>
<div class="pagination pagination-centered">
	<ul class="pagination">
		<?php echo e($data->render()); ?>

	</ul>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Ban list'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>