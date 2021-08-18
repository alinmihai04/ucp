<?php $__env->startSection('content'); ?>
<?php if(!$queried): ?>
	<center>
		<?php echo Form::open(['url' => '/search']); ?>

		<?php echo Form::label('sname', 'Player name:'); ?>

		<?php echo Form::text('sname', '', ['class' => 'form-control']); ?><br>
		<?php echo Form::submit('Search', ['class' => 'btn btn-inverse']); ?>

		<?php echo Form::close(); ?>

	</center>
<?php else: ?>
	<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		(<?php echo e($p->id); ?>) <a href="<?php echo e(url('/profile/'.$p->name.'')); ?>"><?php echo e($p->name); ?></a> - level <?php echo e($p->user_level); ?><br>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Search Player'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>