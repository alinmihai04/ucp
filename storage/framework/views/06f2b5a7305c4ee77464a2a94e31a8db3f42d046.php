<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>Autentificare in doi pasi</h1>
</div>
<ul>
	<li>Pentru a activa autentificarea in doi pasi, ai nevoie de o aplicatie numita <b>'Google Authenticator'</b>, necesita minim <b>Android 2.3.3</b> si minim <b>iOS 7.0</b></li>
	<li>Dupa ce o sa activezi autentificarea in doi pasi, la fiecare logare de pe un IP / PC diferit, fie pe panel sau pe server, va fi nevoie sa introduci un cod generat de aplicatia pe care urmeaza sa o configurezi</li>
	<li>Pentru a dezactiva autentificarea in doi pasi, vei avea nevoie de asemenea de un cod generat de aceasta aplicatie</li>
	<li>Pentru a descarca aplicatia, cauta <b>'Google Authenticator'</b> pe App Store / Play Store, daca ai deschis aceasta pagina de pe telefon, apasa pe una dintre imaginile de mai jos, in functie de sistemul de operare de pe telefonul tau</li>
</ul>
<br>
<p>
	<a href="https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8"><img src="<?php echo e(URL::asset('images/appstore.png')); ?>" style="height: 55px; width: 200px;"></a>
</p>
<p>
	<a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ro"><img src="<?php echo e(URL::asset('images/googleplay.png')); ?>" style="height: 55px; width: 200px;"></a>
</p>
<br>

<a href="<?php echo e(url('/account/security/code')); ?>" class="btn btn-purple">Configureaza aplicatia</a>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Account security'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>