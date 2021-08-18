<?php $__env->startSection('content'); ?>
<h1>Set admin function</h1>
<p>Modificarile vor aparea pe profilul jucatorului si pe pagina 'Staff'.<br>
Scrie '<b>(null)</b>' pentru a sterge functia jucatorului.</p>

<?php echo Form::open(array('url' => '/admin/func/'.$user.'')); ?>


<?php echo Form::label('func', 'Current admin function:'); ?>

<?php echo Form::text('func', $text, ['class' => 'form-control']); ?>

<br>
<?php echo Form::submit('Edit function', ['class' => 'btn btn-purple btn-small']); ?>

<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>