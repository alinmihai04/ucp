<?php $__env->startSection('content'); ?>
    <table class="table">
        <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($d->text); ?></td>
                <td><?php echo e($d->time); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div class="pagination pagination-centered">
        <ul class="pagination">
            <?php echo e($data->render()); ?>

        </ul>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => "Raport logs"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>