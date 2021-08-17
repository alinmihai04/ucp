<?php $__env->startSection('breadcrumb'); ?>
    <i class="icon-angle-right"></i>
    <li class="active">Login</li>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<center>
    <h3><?php echo e(config('app.title')); ?> login</h3>

    <?php echo Form::open(['url' => route('login')]); ?>

    <?php echo Form::label('name', 'Username:'); ?>

    <?php echo Form::text('name'); ?>

    <?php echo Form::label('password', 'Password:'); ?>

    <?php echo Form::password('password'); ?>

    <br>
    <?php echo Form::submit('login', ['class' => 'btn btn-inverse']); ?>

    <?php echo Form::close(); ?>


    <br><br>
    Forgot your password? Click <a href="<?php echo e(url('/recover')); ?>">here</a>!
</center>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Login'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>