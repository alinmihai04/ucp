<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>Autentificare in doi pasi</h1>
</div>
<div class="span12 center">
	<p>
		Contul tau are activata optiunea de Autentificare in doi pasi.<br>
		Nu vei putea folosi nicio functie a site-ului pana nu introduci codul de autentificare.<br>
		Introdu codul oferit de aplicatia 'Google Authenticator' mai jos:<br>
	</p>

	<?php echo Form::open(['url' => url('/2fa/login')]); ?>

	<?php echo Form::label('2fa_code', 'Codul din 6 cifre oferit de aplicatie (ex: 545654)'); ?>

	<?php echo Form::text('2fa_code', ''); ?>

	<br>
	<?php echo Form::submit('Login', ['class' => 'btn btn-small btn-success']); ?>

	<?php echo Form::close(); ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Account security'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>