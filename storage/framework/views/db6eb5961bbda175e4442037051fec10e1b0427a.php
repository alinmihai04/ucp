<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li class="active">Bids</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<p>
	Proprietatiile playerilor inactivi (ce au sub 10 ore jucate in ultimele 60 zile) vor fi afisate pe aceasta pagina.<br>
	In fiecare luni, serverul va verifica activitatea playerilor de pe server, iar proprietatiile celor inactivi vor fi transferate catre AdmBot<br>
	In weekend (sambata si duminica) intre orele 20:00 - 00:00, proprietatiile detinute de AdmBot vor fi scoase la licitatie, iar playerii vor putea licita pentru ele in joc (folosind /bid).	
	</p>
	<hr>

	Businesses:
	<ul>
		<?php $__currentLoopData = $biz; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li><?php echo e($b->id); ?> - <a href="<?php echo e(url('map/'.$b->biz_exterior_posX.'/'.$b->biz_exterior_posY)); ?>"><i class="icon-map-marker"></i> display on map</a></li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</ul>

	Houses:
	<ul>
		<?php $__currentLoopData = $houses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li><?php echo e($h->id); ?> - <a href="<?php echo e(url('map/'.$h->house_exterior_posX.'/'.$h->house_exterior_posY)); ?>"><i class="icon-map-marker"></i> display on map</a></li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</ul>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Bids'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>