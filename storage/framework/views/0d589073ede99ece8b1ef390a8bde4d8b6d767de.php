<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li class="active">
		Leader Panel: <?php echo e($data->group_name); ?>

	</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header">
	<h1><?php echo e($data->group_name); ?></h1>
</div>
<span class="text-error">APPLICATIONS ARE NOT IMPLEMENTED!!!</span><br>
<ul>
	<li>

		<?php if($data->group_application == 1): ?>
			<a href="<?php echo e(url('/group/app/' . $data->group_id)); ?>" onclick="return confirm('Esti sigur ca vrei sa inchizi aplicatiile?');">Inchide aplicatii</a>
		<?php else: ?>
			<a href="<?php echo e(url('/group/app/' . $data->group_id)); ?>" onclick="return confirm('Esti sigur ca vrei sa deschizi aplicatiile?');">Deschide aplicatii</a>
		<?php endif; ?>
	</li>
	<?php if($me->user_grouprank >= 7): ?>
		<li>
			<a href="<?php echo e(url('/group/quest/' . $data->group_id)); ?>">Modifica intrebari aplicatie</a>
		</li>
	<?php endif; ?>
</ul>
<hr>

Faction complaints: <a href="<?php echo e(url('/group/complaints/' . $data->group_id)); ?>"><?php echo e($complaints); ?> complaints pending</a><br />
Faction applications: <a href="<?php echo e(url('/group/applications/' . $data->group_id)); ?>"><?php echo e($applications); ?> applications pending</a>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Leader Panel: ' . $data->group_name], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>