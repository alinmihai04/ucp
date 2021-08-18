<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li><a href="<?php echo e(url('/vehicle/'.$id.'')); ?>"><?php echo e($name); ?></a></li>
	<i class="icon-angle-right"></i>
	<li class="active">Vehicle logs</li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<table class="table">
	<tbody>
		<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td><?php echo e($d->text); ?></td>
				<td><?php echo e($d->time); ?></td>
				<td><?php echo e($d->type); ?></td>
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
<?php echo $__env->make('layout.main', ['title' => $name.' logs'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>