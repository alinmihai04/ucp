<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li>
		<a href="<?php echo e(url('/admin')); ?>">Admin panel</a>
	</li>
	<i class="icon-angle-right"></i>
	<li class="active">
		View group raport
	</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>Editing raport for <?php echo e($name); ?> (<span class="red"><?php echo e($grouptypename); ?></span>)</h1> 
</div>

<p>Current raport: </p>

<?php if($grouptype == 6): ?>
	<ul>
		<li>
			<?php echo e(ucfirst(trans('goals.0'))); ?>

			<?php if($goals->isEmpty()): ?>
				- none 
			<?php else: ?>		
				(<?php echo e(date('H:i', mktime($goals->where('type', '=', '0')->first()->goal, 0))); ?> hours)
			<?php endif; ?>
		</li>

		<li>
			Materials Member <a href="<?php echo e(url('/raport/edit/' . $group . '/11')); ?>"><i class="icon-edit"></i></a>
		</li>

		<?php $__currentLoopData = $goals->where('rank', '=', 11); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			- <?php echo e(ucfirst(trans('goals.' . $g->type))); ?>: <?php echo e($g->goal); ?><br>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

		<li>
			Drugs Member <a href="<?php echo e(url('/raport/edit/' . $group . '/12')); ?>"><i class="icon-edit"></i></a>
		</li>

		<?php $__currentLoopData = $goals->where('rank', '=', 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			- <?php echo e(ucfirst(trans('goals.' . $g->type))); ?>: <?php echo e($g->goal); ?><br>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		

		<li>
			Tester / Helper <a href="<?php echo e(url('/raport/edit/' . $group . '/10')); ?>"><i class="icon-edit"></i></a>
		</li>

		<?php $__currentLoopData = $goals->where('rank', '=', 10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			- <?php echo e(ucfirst(trans('goals.' . $g->type))); ?>: <?php echo e($g->goal); ?><br>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>				
	</ul>
<?php else: ?>

	<ul>
		<li>
			<?php echo e(ucfirst(trans('goals.0'))); ?>

			<?php if($goals->isEmpty()): ?>
				- none 
			<?php else: ?>		
				(<?php echo e(date('H:i', mktime($goals->where('type', '=', '0')->first()->goal, 0))); ?> hours)
			<?php endif; ?>
		</li>

		<?php for($i = 6; $i >= 1; $i--): ?>
			<li>
				Rank <?php echo e($i); ?> <a href="<?php echo e(url('/raport/edit/' . $group . '/' . $i)); ?>"><i class="icon-edit"></i></a>
			</li>

			<?php $__currentLoopData = $goals->where('rank', '=', $i); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				- <?php echo e(ucfirst(trans('goals.' . $g->type))); ?>: <?php echo e($g->goal); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endfor; ?>

		<li>
			Tester / Helper <a href="<?php echo e(url('/raport/edit/' . $group . '/10')); ?>"><i class="icon-edit"></i></a>
		</li>

		<?php $__currentLoopData = $goals->where('rank', '=', 10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			- <?php echo e(ucfirst(trans('goals.' . $g->type))); ?>: <?php echo e($g->goal); ?><br>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		
	</ul>

<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>