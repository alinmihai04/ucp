<?php $__env->startSection('content'); ?>

	<div id="feed" class="tab-pane">
		<div class="profile-feed row-fluid">
			<div class="span12">
	
				<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

					<div class="profile-activity clearfix">
						<div>
							<i class="icon-bell pull-left icon-3x"></i>
							<?php echo e($e->message); ?>

							<?php echo $e->link != '#' ? "<a href=". url($e->link) . " class='btn btn-success pull-right'>Click to view</a>" : ''; ?>

							<div class="time">
								<i class="icon-time bigger-110"></i>
								<?php echo e($e->time); ?>

							</div>
						</div>
					</div>	

				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Notifications'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>