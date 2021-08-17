<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li class="active">Businesses</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<table class="table table-bordered table-condensed">
		<tbody>
			<tr class="info">
				<td>ID</td>
				<td>Owner</td>
				<td>Price</td>
				<td>Biz fee</td>
				<td>Map</td>
			</tr>
		<tbody>
			<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $biz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td><?php echo e($biz->id); ?></td>
				<td>
					<?php if($biz->biz_owner == 'The State'): ?>
						The State
					<?php else: ?>
						<a href="<?php echo e(url('/profile/' . $biz->name)); ?>"><?php echo e($biz->name); ?></a>
					<?php endif; ?>
				</td>
				<td><?php echo e($biz->biz_price == 0 ? 'not for sale' : $biz->biz_price); ?></td>
				<td><?php echo e($biz->biz_fee); ?></td>
				<td><a href="<?php echo e(url('/map/' . $biz->biz_exterior_posX . '/' . $biz->biz_exterior_posY)); ?>"><i class="icon-map-marker"></i> display on map</a></td>
			</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Businesses'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>