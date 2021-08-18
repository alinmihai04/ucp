<?php $__env->startSection('content'); ?>
<h1>Force player to change his nickname</h1>
<p>Jucatorul va fii obligat sa isi schimbe numele la urmatoare logare pe server</p>

<?php echo Form::open(array('url' => '/admin/fnc/'.$user.'')); ?>


<?php echo Form::label('reason', 'Reason for /fnc:'); ?>

<?php echo Form::text('reason', '', ['class' => 'form-control']); ?>

<br>
<?php echo Form::submit('Force Nickname Change', ['class' => 'btn btn-purple btn-small']); ?>

<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>