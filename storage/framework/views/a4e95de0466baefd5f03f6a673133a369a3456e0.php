<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li class="active">Faction List</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>Lista Factiuni</h1>
</div>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th class="center">ID</th>
			<th>Nume</th>
			<th class="hidden-480">Membri</th>
			<th class="hidden-100">Optiuni</th>
			<th class="hidden-100">Status Aplicatie</th>
			<th class="center">Level Necesar</th>
		</tr>
	</thead>
	<tbody>
		<?php $__currentLoopData = $groupdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<tr>
				<td class="center">
					<?php echo e($g->group_id); ?>

				</td>
				<td>
					<?php echo e($g->group_name); ?>

				</td>
				<td class="hidden-480">
					<?php echo e($g->group_members); ?>/<?php echo e($g->group_slots); ?>

				</td>
				<td class="hidden-100">
					<a href="<?php echo e(url('/group/members/' . $g->group_id)); ?>">members</a> / <a href="<?php echo e(url('/group/logs/'.$g->group_id)); ?>">logs</a> / <a href="<?php echo e(url('/group/applications/' . $g->group_id)); ?>">applications</a> / <a href="<?php echo e(url('/group/complaints/' . $g->group_id)); ?>">complaints</a>
				</td>
				<td class="hidden-100">
					<?php if($g->group_application == 0): ?>
						<span class='text-error'>Aplicatii inchise</span>
					<?php else: ?>
						<?php if(is_object($me) && $me->user_group >= 1): ?>
							Aplicatii deschise
						<?php else: ?>
							<a class='btn btn-small btn-success' href='<?php echo e(url('/group/apply/' . $g->group_id)); ?>'>Aplica!</a>
						<?php endif; ?>
					<?php endif; ?>
				</td>
				<td class="center"><?php echo e($g->group_level); ?></td>
			</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</tbody>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Faction List'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>