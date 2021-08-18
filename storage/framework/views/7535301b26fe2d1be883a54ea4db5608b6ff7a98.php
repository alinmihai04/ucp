<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <h1>Changing user <?php echo e($userdata->name); ?>'s mail</h1>
    </div>
    <p class="text-error">(demo) Mail sending feature is not yet implemented, this is not a safe approach for changing the email.</p>

    <p>
        Adresa curenta de email: <b><?php echo e($userdata->user_email); ?></b>
    </p>
    <?php echo Form::open(array('url' => '/user/changemail/done/'.$userdata->id.'')); ?>


    <?php echo Form::label('new_email', 'Noua adresa de email:'); ?>

    <?php echo Form::email('new_email', '', ['class' => 'form-control']); ?>

    <?php echo Form::label('c_password', 'Parola curenta:'); ?>

    <?php echo Form::password('c_password', ['class' => 'form-control']); ?>

    <br>
    <?php echo Form::submit('Schimba mail', ['class' => 'btn btn-grey btn-small']); ?>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>