<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li><a href="<?php echo e(url('/clan/view/'.$clan.'')); ?>"><?php echo e('Clan ' . $clan); ?></a></li>
	<i class="icon-angle-right"></i>
	<li class="active">Clan logs: <?php echo e($clan); ?></li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<table class="table">
	<tbody>
		<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td><?php echo e($d->log); ?></td>
				<td><?php echo e($d->time); ?></td>
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
<?php echo $__env->make('layout.main', ['title' => 'Clan Logs: ' . $clan], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>