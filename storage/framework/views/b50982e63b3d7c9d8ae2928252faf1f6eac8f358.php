<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li>
		<a href="<?php echo e(url('/admin')); ?>">Admin panel</a>
	</li>
	<i class="icon-angle-right"></i>
	<li class="active">
		Edit goal
	</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>Editing raport activity</h1> 
</div>

<?php echo Form::open(['url' => '/goal/edit/' . $goal . '/' . $goals->group_id]); ?>

	<?php echo Form::label('amount', ucfirst(trans('goals.' . $goals->type))); ?>

	<?php echo Form::text('amount', $goals->goal); ?>				
	<br>
	<?php echo Form::submit('Submit', ['class' => 'btn btn-small btn-success']); ?>

<?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>