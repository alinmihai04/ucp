<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li><a href="<?php echo e(url('/group/view/' . $group)); ?>"><?php echo e(App\Group::getGroupName($group)); ?></a></li>
	<i class="icon-angle-right"></i>
	<li class="active">Members</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<div class="page-header">
		<h1><?php echo e(App\Group::getGroupName($group)); ?></h1>
	</div>
	<table class="table">
		<tbody>
			<tr>
				<td>Name</td>
				<td>Rank</td>
				<td>FW</td>
				<td>Days in faction</td>
				<td>Last Online</td>
				<?php if($grouptype == 6): ?>
					<td>War Stats</td>
				<?php endif; ?>
				<td>Faction Raport</td>
				<td>Raport Process Date</td>
				<td>Options</td>
			</tr>
			<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr>
					<td><img src="<?php echo e(URL::asset('images/avatars/' . $m->user_groupskin)); ?>.png" style="width: 15px"> <a href="<?php echo e(url('/profile/' . $m->name)); ?>"><?php echo e($m->name); ?></a></td>
					<td>
						<?php echo e($m->rank); ?>

						<?php if($m->fgroup == 11): ?>
							<span class="label label-success arrowed-in-right"><i class="icon-certificate white"></i> tester</span>
						<?php endif; ?>
					</td>
					<td><?php echo e($m->fw); ?></td>
					<td><?php echo e($m->days); ?></td>
					<td><?php echo e($m->last_login); ?></td>
					<?php if($grouptype == 6): ?>
						<td><?php echo e($m->war_kills); ?> kills / <?php echo e($m->war_deaths); ?> deaths</td>
					<?php endif; ?>
					<td>
						<?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

							<?php if(($g->rank == $m->rank && !$m->fgroup) || $m->fgroup == $g->rank || ($m->fgroup == 14 && $g->rank == 11) || (!$g->rank)): ?>
								<?php $shown = false; ?>


								<?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

									<?php if($p->type == $g->type && $p->user_id == $m->user): ?>
										<?php $shown = true; ?>

										<?php echo e(ucfirst(trans('goals.' . $g->type))); ?>:
										<?php if($g->type == 0): ?>
											<?php echo e(gmdate('H:i', $p->current)); ?>/<?php echo e(gmdate('H:i', $g->goal)); ?><br>
										<?php else: ?>
											<?php echo e($p->current); ?>/<?php echo e($g->goal); ?><br>
										<?php endif; ?>
									<?php endif; ?>

								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

								<?php if(!$shown): ?>
									<?php $shown = true; ?>

									<?php echo e(ucfirst(trans('goals.' . $g->type))); ?>:
									<?php if($g->type == 0): ?>
										<?php echo e(gmdate('H:i', 0)); ?>/<?php echo e(gmdate('H:i', $g->goal)); ?><br>
									<?php else: ?>
										<?php echo e(0); ?>/<?php echo e($g->goal); ?><br>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>

						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</td>
					<td><?php echo e($m->raport_process); ?></td>
					<td><a class="btn btn-danger btn-small" href="<?php echo e(url('complaint/create/' . $m->id)); ?>">Reclama player</a></td>
				</tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</tbody>
	</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => App\Group::getGroupName($group)], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>