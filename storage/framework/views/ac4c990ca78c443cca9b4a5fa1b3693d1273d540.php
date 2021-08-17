<?php $__env->startSection('content'); ?>

<div class="page-header">
	<h1>
		Editing group <?php echo e($group); ?> skins
	</h1>
</div>

<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<ul style="display: inline-block;">
	<li>
		Skin <?php echo e($d->skin_id); ?> 
		<a href="<?php echo e(url('/group/skins/remove/' . $group . '/' . $d->skin_id)); ?>" onclick="return confirm('Esti sigur ca vrei sa stergi acest skin?');">
			<i class="icon-trash red"></i>
		</a>
		<br>
		<img src="<?php echo e(url('/images/userbar_skins/Skin_' . $d->skin_id . '.png')); ?>" alt="<?php echo e($d->skin_id); ?>">
	</li>
</ul>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<hr>

<?php echo Form::open(['url' => '/group/skins/add/' . $group]); ?>

	<?php echo Form::label('skin', 'Add a new skin'); ?>

	<?php echo Form::number('skin', '', ['placeholder' => 'Skin id (ex: 103)']); ?>				
	<br>
	<?php echo Form::submit('Add skin', ['class' => 'btn btn-small btn-success']); ?>

<?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Group skins'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>