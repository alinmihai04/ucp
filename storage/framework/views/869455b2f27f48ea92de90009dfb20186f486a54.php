<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>
		Set Player Money
	</h1>
</div>

<p>Current - cash: <b>$<?php echo e(number_format($cash)); ?></b>, bank: <b>$<?php echo e(number_format($bank)); ?></b>
<p>Pentru a-i lua banii unui jucator, se introduce valoarea negativa.</p>

<?php echo Form::open(['url' => url('/admin/money/' . $user)]); ?>

<?php echo Form::label('money', 'Value:'); ?>

<?php echo Form::text('money', ''); ?>

<br>
<?php echo Form::submit('Edit money', ['class' => 'btn btn-inverse']); ?>

<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => "Admin Control Panel"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>