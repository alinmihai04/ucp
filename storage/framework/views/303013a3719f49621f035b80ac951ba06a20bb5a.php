<?php $__env->startSection('content'); ?>
    <h1>Change complaint reason</h1>

    <?php echo Form::open(array('url' => '/complaint/reason/change/'.$topicID.'')); ?>


    <select name="reason">
        <?php if($user->user_group > 0): ?>
            <option value="2">Factiune</option>
        <?php endif; ?>
        <option value="1">DM</option>
        <option value="3">Jigniri, injurii, limbaj vulgar</option>
        <option value="4">Inselatorie</option>
        <option value="5">Altceva (abuz, comportament non RP)</option>
        <?php if($user->user_admin > 0 || $user->user_helper > 0): ?>
            <option value="6">Abuz admin/helper</option>
        <?php endif; ?>
        <?php if($user->user_grouprank == 7): ?>
            <option value="7">Greseli ca lider</option>
        <?php endif; ?>
    </select>
    <br>
    <?php echo Form::submit('Change reason', ['class' => 'btn btn-purple btn-small']); ?>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Admin Control Panel'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>