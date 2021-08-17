<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li><a href="<?php echo e(url('/profile/' . $name)); ?>"><?php echo e($name); ?></a></li>
	<i class="icon-angle-right"></i>
	<li class="active">Hours played</li>	
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>
		<?php echo e($name); ?>'s played hours for last 30 days
	</h1>
</div>
<h3>
	Ore jucate in ultimele 7 zile
</h3>
<div class="profile-activity clearfix">
	<div>
		<i class="icon-time pull-left icon-3x"></i>
		<?php echo e(secondsformat($last7_avg)); ?> / day
	</div>
</div>

<h3>
	Ore jucate in ultimele 30 zile
</h3>
<div class="profile-activity clearfix">
	<div>
		<i class="icon-time pull-left icon-3x"></i>
		<?php echo e(secondsformat($last30_avg)); ?> / day
	</div>
</div>
<div class="space-12"></div>
<?php $__currentLoopData = $last30; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div class="profile-activity clearfix">
		<div>
			<i class="icon-time pull-left icon-3x"></i>
			<?php echo e(secondsformat($l->seconds)); ?>

			<div class="time">
				<i class="icon-time bigger-110"></i>
				<?php echo e($l->time); ?>

			</div>
		</div>
	</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Hours'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>