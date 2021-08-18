<?php $__env->startSection('content'); ?>
<h1>Set user note</h1>
<p>Notitele pentru un jucator pot fi vizualizate doar de catre un admin 5+. <br>
Scrie '<b>(null)</b>' pentru a sterge notitele de pe profilul jucatorului.</p>

<?php echo Form::open(array('url' => '/admin/note/'.$user.'')); ?>


<?php echo Form::label('note', 'Current user note:'); ?>

<?php echo Form::textarea('note', $text, ['rows' => 7, 'style="width: 500px; resize: none;"']); ?>

<br>
<?php echo Form::submit('Edit note', ['class' => 'btn btn-info btn-small']); ?>

<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>