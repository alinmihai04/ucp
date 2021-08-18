<?php $__env->startSection('content'); ?>
<h1>Edit Faction History line</h1>
<p>Modificarile vor aparea pe profilul jucatorului si pe pagina principala.<br></p>

<?php echo Form::open(array('url' => '/admin/editfh/'.$user.'/'.$fh)); ?>


<?php echo Form::label('fh', 'Current text:'); ?>

<?php echo Form::text('fh', $text, ['class' => 'span6']); ?>

<br>
<?php echo Form::submit('Edit FH', ['class' => 'btn btn-purple btn-small']); ?>

<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>