<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li>
		<a href="<?php echo e(url('/raport/' . $group)); ?>">View raport</a>
	</li>
	<i class="icon-angle-right"></i>
	<li class="active">
		Edit raport
	</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>Editing raport activity for rank <?php echo e($rank); ?></h1> 
</div>

<ul>
<?php $__currentLoopData = $goals->where('rank', '=', $rank); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<li>
		<?php echo e(ucfirst(trans('goals.' . $g->type))); ?>: 
		<?php echo e($g->goal); ?> 
		<a href="<?php echo e(url('/goal/edit/' . $g->id)); ?>"><i class="icon-edit red"></i></a> 
		<a href="<?php echo e(url('/goal/delete/' . $g->id)); ?>" onclick="return confirm('Esti sigur?');"><i class="icon-remove red"></i></a>
	</li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<h4>Add goal</h4>

<?php echo Form::open(['url' => '/goal/add/' . $group . '/' . $rank]); ?>

	<select name="goaltype">
		<?php for($i = 1; $i <= 13; $i++): ?>
			<option value="<?php echo e($i); ?>"><?php echo e(ucfirst(trans('goals.' . $i))); ?></option>
		<?php endfor; ?>
	</select> 
	<br>
	<?php echo Form::label('amount', 'Goal amount:'); ?>

	<?php echo Form::text('amount', ''); ?>				
	<br>
	<?php echo Form::submit('Add goal', ['class' => 'btn btn-small btn-primary']); ?>

<?php echo Form::close(); ?>


</ul>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>