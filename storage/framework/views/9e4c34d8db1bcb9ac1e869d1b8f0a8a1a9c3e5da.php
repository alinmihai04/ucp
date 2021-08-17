<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>Autentificare in doi pasi</h1>
</div>

<div class="span12 center">
	Scaneaza codul QR de mai jos pentru a activa autentificarea in 2 pasi<br>
	<img src="<?php echo e($QR_Image); ?>"><br>
	Dupa ce ai scanat codul QR, introdu mai jos codul de securitate oferit de aplicatie pentru a finaliza activarea
	<?php echo Form::open(['url' => url('/2fa')]); ?>

	<br>
	<?php echo Form::label('verify-code', 'Codul de securitate:'); ?>

	<?php echo Form::text('verify-code', ''); ?>

	<br>
	<?php echo Form::submit('Valideaza codul', ['class' => 'btn btn-success btn-small']); ?>

	<?php echo Form::close(); ?>

</div>
<h3>
	Cum se foloseste aplicatia?
</h3>
<hr>
<h4>
	<b>1. Apasa pe butonul '+' aflat in coltul din dreapta jos</b><br><br>
	<img src="<?php echo e(URL::asset('images/2fa.png')); ?>"><br><br>
	<b>2. Alege prima optiune (Scanati un cod de bare), apoi plasati camera pe codul QR de mai sus</b><br><br>
	<img src="<?php echo e(URL::asset('images/2fa1.png')); ?>"><br><br>
	<b>3. Daca totul a mers bine, contul tau va fi integrat in aplicatie</b><br><br>
	<img src="<?php echo e(URL::asset('images/2fa2.png')); ?>">		
</h4>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Account security'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>