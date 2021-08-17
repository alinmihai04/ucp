<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>View map</h1>
</div>
<img src="<?php echo e(url('/viewmap/'.$x.'/'.$y)); ?>">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'View Map'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>