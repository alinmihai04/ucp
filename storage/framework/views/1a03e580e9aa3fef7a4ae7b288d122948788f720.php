<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li class="active">Houses</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<table class="table table-bordered table-condensed">
		<tbody>
			<tr class="info">
				<td>ID</td>
				<td>Owner</td>
				<td>Price</td>
				<td>Type</td>
				<td>Map</td>
			</tr>
		<tbody>
			<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td><?php echo e($house->id); ?></td>
				<td>
					<?php if($house->house_ownerid == 0): ?>
						The State
					<?php else: ?>
						<a href="<?php echo e(url('/profile/' . $house->name)); ?>"><?php echo e($house->name); ?></a>
					<?php endif; ?>
				</td>
				<td><?php echo e($house->house_price == 0 ? 'not for sale' : $house->house_price); ?></td>
				<td>
					<?php if($house->house_size == 1): ?>
						Small
					<?php elseif($house->house_size == 2): ?>
						Medium
					<?php elseif($house->house_size == 3): ?>
						Large
					<?php endif; ?>
				</td>
				<td><a href="<?php echo e(url('/map/' . $house->house_exterior_posX . '/' . $house->house_exterior_posY)); ?>"><i class="icon-map-marker"></i> display on map</a></td>
			</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Houses'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>