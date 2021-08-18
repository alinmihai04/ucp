<?php $__env->startSection('content'); ?>
    <?php if($editAttr == 'slots'): ?>
        <div class="page-header">
            <h1>Editing group <?php echo e($group->group_name); ?> slots (current: <?php echo e($group->group_slots); ?>)</h1>
        </div>

        <?php echo Form::open(array('url' => '/admin/groupslots/'.$group->group_id.'')); ?>


        <?php echo Form::label('slots', 'New group slots:'); ?>

        <?php echo Form::number('slots', '', ['class' => 'form-control']); ?>

        <br>
        <?php echo Form::submit('Change slots', ['class' => 'btn btn-purple btn-small']); ?>

        <?php echo Form::close(); ?>

    <?php else: ?>
        <div class="page-header">
            <h1>Editing group <?php echo e($group->group_name); ?> level (current: <?php echo e($group->group_level); ?>)</h1>
        </div>

        <?php echo Form::open(array('url' => '/admin/grouplevel/'.$group->group_id.'')); ?>


        <?php echo Form::label('level', 'New group level:'); ?>

        <?php echo Form::number('level', '', ['class' => 'form-control']); ?>

        <br>
        <?php echo Form::submit('Change level', ['class' => 'btn btn-purple btn-small']); ?>

        <?php echo Form::close(); ?>

    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>