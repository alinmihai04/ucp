<?php $__env->startSection('breadcrumb'); ?>
<i class="icon-angle-right"></i>
<li><a href="<?php echo e(url('/group/view/'.$group)); ?>"><?php echo e($groupname); ?></a></li>
<i class="icon-angle-right"></i>
<li class="active">Group logs</li>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => $groupname."'s logs"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>