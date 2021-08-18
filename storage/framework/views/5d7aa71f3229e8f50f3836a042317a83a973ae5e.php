<?php $__env->startSection('breadcrumb'); ?>
    <i class="icon-angle-right"></i>
    <li class="active">Login</li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="span12 center">
    <h3><?php echo e(config('app.title')); ?> login</h3>

    <?php echo Form::open(['url' => route('login')]); ?>

    <?php echo Form::label('name', 'Username:'); ?>

    <?php echo Form::text('name'); ?>

    <?php echo Form::label('password', 'Password:'); ?>

    <?php echo Form::password('password'); ?>


    <div class="checkbox">
        <label>
            <?php echo Form::checkbox('force_2fa', 'enabled', false, ['class'=>'ace ace-checkbox-2']); ?>

            <span class="lbl"> Check to force 2 factor auth (if enabled) </span>
        </label>
    </div>
    <br>

    <?php echo Form::submit('login', ['class' => 'btn btn-inverse']); ?>

    <?php echo Form::close(); ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Login'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>