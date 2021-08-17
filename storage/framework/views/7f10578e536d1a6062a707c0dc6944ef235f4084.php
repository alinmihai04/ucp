<?php $__env->startSection('content'); ?>
<center>
	<h4>Give PP to player</h4>
	<p>Pentru a se retrage pp-urile de pe cont, se introduce valoarea negativa</p>
	<?php echo Form::open(['url' => '/admin/givepp/' . $user]); ?>

	<?php echo Form::label('amount', 'Amount:'); ?>

	<?php echo Form::text('amount'); ?>

	<br>
	<?php echo Form::submit('Give PP', ['class' => 'btn btn-inverse']); ?>

	<?php echo Form::close(); ?>

</center>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>