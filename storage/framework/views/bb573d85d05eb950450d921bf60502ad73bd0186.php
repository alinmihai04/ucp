<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li class="active">Clan List</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>Clan List</h1>
</div>

<?php if(Auth::check()): ?>
	<?php if($me->user_clan > 0): ?>
		<a href="<?php echo e(url('/clan/view/'.$me->user_clan.'')); ?>" class="btn btn-inverse">View my clan</a>
	<?php endif; ?>
	<?php if($me->user_clanrank < 7): ?>
		<a href="<?php echo e(url('/clan/register')); ?>" class="btn btn-danger">Create a clan</a>
	<?php endif; ?>
<?php endif; ?>
<div class="space-12"></div>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th class="center">ID</th>
			<th>Name</th>
			<th class="hidden-100">Tag</th>
			<th class="hidden-480">Members</th>
		</tr>
	</thead>
	<tbody>
		<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td class="center"><?php echo e($d->id); ?></td>
			<td><a href="<?php echo e(url('/clan/view/'.$d->id.'')); ?>"><?php echo e($d->clan_name); ?></a></td>
			<td class="hidden-100"><?php echo e($d->clan_tag); ?></td>
			<td class="hidden-480"><?php echo e($d->clan_members); ?>/<?php echo e($d->clan_slots); ?></td>
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
<?php echo $__env->make('layout.main', ['title' => 'Clan list'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>