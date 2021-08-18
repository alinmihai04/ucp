<?php if($data != null): ?>
	<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<li>
			<a href="<?php echo e(url($d->link)); ?>">
				<?php if($d->seen == 0): ?>
					<i class="btn btn-xs no-hover btn-pink icon-comment"></i>
				<?php else: ?>
					<i class="btn btn-xs no-hover btn-grey icon-comment"></i>
				<?php endif; ?>
				<span class="msg-body">
					<span class="msg-title">	
						<?php echo e($d->message); ?>

					</span>
				</span>
			</a>
		</li>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
<?php endif; ?>

<li><a href="<?php echo e(url('/notifications')); ?>">See all notifications <i class="icon-arrow-right"></i></a></li>