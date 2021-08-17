<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>View Faction Log History</h1>
</div>

<div class="profile-feed row-fluid">
	<div class="span6">
		<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="profile-activity clearfix">
				<div>
					Versiune anterioara: <?php echo e($f->text); ?>

					<div class="time">
						<i class="icon-time bigger-110"></i>
						<?php echo e($f->time); ?> - edited by <?php echo e($f->user_name); ?>[admin:<?php echo e($f->user); ?>]
					</div>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>