<?php $__env->startSection('content'); ?>

<div class="page-header">
    <h1>Aplicatii pentru <?php echo e($groupname); ?></h1>
</div>

<h4 class="purple">
    <i class="icon-list-ul"></i>
    Playeri acceptati pentru teste (<?php echo e($data->where('status', '=', 2)->count()); ?>)
</h4>
<table class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
        <th class="center">ID</th>
        <th>Player</th>
        <th class="hidden-100">Date</th>
        <th class="hidden-480">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php $__currentLoopData = $data->where('status', '=', 2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td class="center">
                    <?php echo e($a->id); ?>

                </td>
                <td>
                    <a href="<?php echo e(url('/group/viewapplication/' . $a->id)); ?>"><?php echo e($a->name); ?></a>
                </td>
                <td class="hidden-100">
                    <?php echo e($a->time); ?>

                </td>
                <td class="hidden-480">
                    <a href="<?php echo e(url('/group/viewapplication/' . $a->id)); ?>">Citeste aplicatie</a>
                </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
    </tbody>
</table>

<h4 class="blue">
    <i class="icon-sun"></i>
    Aplicatii noi (<?php echo e($data->where('status', '=', 0)->count()); ?>)
</h4>
<table class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
        <th class="center">ID</th>
        <th>Player</th>
        <th class="hidden-100">Date</th>
        <th class="hidden-480">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php $__currentLoopData = $data->where('status', '=', 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td class="center">
                    <?php echo e($a->id); ?>

                </td>
                <td>
                    <a href="<?php echo e(url('/group/viewapplication/' . $a->id)); ?>"><?php echo e($a->name); ?></a>
                </td>
                <td class="hidden-100">
                    <?php echo e($a->time); ?>

                </td>
                <td class="hidden-480">
                    <a href="<?php echo e(url('/group/viewapplication/' . $a->id)); ?>">Citeste aplicatie</a>
                </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
    </tbody>
</table>

<h4 class="red">
    <i class="icon-thumbs-down"></i>
    Aplicatii noi (<?php echo e($data->where('status', '=', 1)->count()); ?>)
</h4>
<table class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
        <th class="center">ID</th>
        <th>Player</th>
        <th class="hidden-100">Date</th>
        <th class="hidden-480">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php $__currentLoopData = $data->where('status', '=', 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td class="center">
                    <?php echo e($a->id); ?>

                </td>
                <td>
                    <a href="<?php echo e(url('/group/viewapplication/' . $a->id)); ?>"><?php echo e($a->name); ?></a>
                </td>
                <td class="hidden-100">
                    <?php echo e($a->time); ?>

                </td>
                <td class="hidden-480">
                    <a href="<?php echo e(url('/group/viewapplication/' . $a->id)); ?>">Citeste aplicatie</a>
                </td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
    </tbody>
</table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Applications Lits - ' . $groupname], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>