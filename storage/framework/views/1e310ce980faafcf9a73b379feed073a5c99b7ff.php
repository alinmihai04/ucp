<?php $__env->startSection('content'); ?>
<h4>Beta testers (<?php echo e($data->count()); ?>)</h4>

<table class="table table-hover">
	<tbody>
		<tr class="warning table-bordered">
			<td>SQL ID</td>
			<td>Name</td>
			<td>Level</td>
		</tr>
		<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td>
					<?php echo e($d->id); ?>

				</td>
				<td>
					<?php echo $d->user_status == 0 ? "<i class='icon-circle light-red'></i>" : "<i class='icon-circle light-green'></i>"; ?>

					<a href="<?php echo e(url('/profile/' . $d->name)); ?>"><?php echo e($d->name); ?></a>
				</td>
				<td>
					<?php echo e($d->user_level); ?>

				</td>	
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
<?php echo $__env->make('layout.main', ['title' => 'Beta testers'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>