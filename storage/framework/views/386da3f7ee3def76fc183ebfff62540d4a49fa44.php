<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li class="active">Staff</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if($auth && $me->user_helper >= 1): ?>
	Raspunsuri pe /n in ultimele 7 zile: <b><?php echo e($my_nre); ?></b><br>
	<span style='color:grey'>// datele sunt actualizate o data la 60 de minute</span><br>
	<span style='color:grey'>// ultima actualizare: <?php echo e($my_nre_time); ?></span><br>
	<hr>
<?php endif; ?>

<h4>Admins (<?php echo e($data->where('user_status', '>', 0)->where('user_admin', '>', 0)->count()); ?>/<?php echo e($data->where('user_admin', '>', 0)->count()); ?>)</h4>

<table class="table table-condensed">
	<tbody>
		<tr class="success">
			<td>Status</td>
			<td>Name</td>
			<td>Admin level</td>
			<td>Info</td>
			<td>Last online</td>
			<?php if($auth && $me->user_admin >= 1): ?>
				<td>online 7d</td>
				<td>last rank change</td>
			<?php endif; ?>			
		</tr>
		<?php $__currentLoopData = $data->where('user_admin', '>', 0)->sortByDesc('user_admin'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo $d->user_status == 0 ? "<span class='badge badge-grey'>offline</span>" : "<span class='badge badge-success'>online</span>"; ?></td>
			<td><a href="<?php echo e(url('/profile/'.$d->name.'')); ?>"><?php echo e($d->name); ?></a></td>
			<td><?php echo e($d->user_admin); ?></td>
			<td>
				<?php if($d->user_admin == 6 && $d->id != 1): ?>
					<span class="label label-inverse arrowed-in-right"><i class="icon-sitemap white"></i> owner </span>
				<?php elseif($d->id == 1): ?>
					<span class="label label-inverse arrowed-in-right"><i class="icon-sitemap white"></i> owner & scripter </span>
				<?php endif; ?>

				<?php if(!is_null($d->user_admfunc)): ?>
					<span class="label label-purple arrowed-in-right"><i class="icon-gear white"></i> <?php echo e($d->user_admfunc); ?> </span>
				<?php endif; ?>
				<?php if($d->user_support == 1): ?>
					<span class="label label-purple arrowed-in-right"><i class="icon-comments white"></i> support </span>
				<?php elseif($d->user_support == 2): ?>
					<span class="label label-yellow arrowed-in-right"><i class="icon-shield grey"></i> support, account moderator</span>
				<?php endif; ?>
				<?php if($d->user_beta == 1): ?>
					<span class="label label-pink arrowed-in-right"><i class="icon-bug white"></i> beta tester </span>
				<?php endif; ?>			

				<?php if($auth && $me->user_admin >= 6): ?>
					<a href="<?php echo e(url('/admin/remove/'.$d->id)); ?>" onclick="return confirm('Esti sigur ca vrei sa il scoti pe acest jucator din staff?');"><i class="icon-remove-circle red"></i></a>

					<?php if($d->user_support >= 1): ?>
						- <a href="<?php echo e(url('/admin/support/0/' . $d->id)); ?>" onclick="return confirm('Esti sigur ca vrei sa ii scoti functia de SUPPORT acestui admin?');"><i class="icon-ticket red"></i></a>
					<?php endif; ?>

					- <a href="<?php echo e(url('/admin/support/1/' . $d->id)); ?>" onclick="return confirm('Esti sigur ca vrei sa il promovezi pe acest admin la SUPPORT LEVEL 1?');"><i class="icon-ticket green"></i></a>
					- <a href="<?php echo e(url('/admin/support/2/' . $d->id)); ?>" onclick="return confirm('Esti sigur ca vrei sa il promovezi pe acest admin la SUPPORT LEVEL 2?');"><i class="icon-ticket blue"></i><i class="icon-ticket blue"></i></a>
				<?php endif; ?>				
			</td>
			<td><?php echo e($d->last_login); ?></td>
			<?php if($auth && $me->user_admin >= 1): ?>
				<td>
					<?php if($d->last7 < 10): ?>
						<b><span class="red"> <?php echo e($d->last7); ?></span></b>
					<?php else: ?>
						<?php echo e($d->last7); ?>

					<?php endif; ?>
				</td>
				<td>
					<?php echo e($d->staffchange); ?> days ago
				</td>
			<?php endif; ?>			
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</tbody>
</table>

<h4>Helpers (<?php echo e($data->where('user_status', '>', 0)->where('user_helper', '>', 0)->count()); ?>/<?php echo e($data->where('user_helper', '>', 0)->count()); ?>)</h4>

<table class="table table-condensed">
	<tbody>
		<tr class="success">
			<td>Status</td>
			<td>Name</td>
			<td>Helper level</td>
			<td>Last online</td>
			<?php if($auth && $me->user_admin >= 1): ?>
				<td>/n - last 7 days</td>
				<td>online last 7 days</td>
				<td>last rank change</td>
			<?php endif; ?>			
		</tr>
		<?php $__currentLoopData = $data->where('user_helper', '>', 0)->sortByDesc('user_helper'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo $d->user_status == 0 ? "<span class='badge badge-grey'>offline</span>" : "<span class='badge badge-success'>online</span>"; ?></td>
			<td><a href="<?php echo e(url('/profile/' . $d->name)); ?>"><?php echo e($d->name); ?></a></td>
			<td><?php echo e($d->user_helper); ?></td>
			<td><?php echo e($d->last_login); ?></td>
			<?php if($auth && $me->user_admin >= 1): ?>
				<td>
					<?php if($d->last_nre < 20): ?>
						<b><span class="red"> <?php echo e($d->last_nre); ?></span></b>
					<?php else: ?>
						<?php echo e($d->last_nre); ?>

					<?php endif; ?>
				</td>				
				<td>
					<?php if($d->last7 < 10): ?>
						<b><span class="red"> <?php echo e($d->last7); ?></span></b>
					<?php else: ?>
						<?php echo e($d->last7); ?>

					<?php endif; ?>
				</td>			
				<td>
					<?php echo e($d->staffchange); ?> days ago
				</td>				
			<?php endif; ?>			
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</tbody>
</table>

<h4>Leaders (<?php echo e($data->where('user_status', '>', 0)->where('user_grouprank', '=', 7)->count()); ?>/<?php echo e($data->where('user_grouprank', '=', 7)->count()); ?>)</h4>

<table class="table table-condensed">
	<tbody>
		<tr class="success">
			<td>Status</td>
			<td>Name</td>
			<td>Faction</td>
			<td>Faction members</td>		
			<td>Last online</td>
			<?php if($auth && $me->user_admin >= 1): ?>
				<td>online last 7 days</td>
			<?php endif; ?>				
		</tr>
		<?php $__currentLoopData = $data->where('user_grouprank', '=', 7)->sortBy('user_group'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo $d->user_status == 0 ? "<span class='badge badge-grey'>offline</span>" : "<span class='badge badge-success'>online</span>"; ?></td>
			<td><a href="<?php echo e(url('/profile/'.$d->name.'')); ?>"><?php echo e($d->name); ?></a></td>
			<td><a href="<?php echo e(url('/group/members/'.$d->user_group.'')); ?>"><?php echo e($groups->where('group_id', '=', $d->user_group)->first()->group_name); ?></td>
			<td><?php echo e($groups->where('group_id', '=', $d->user_group)->first()->group_members); ?>/<?php echo e($groups->where('group_id', '=', $d->user_group)->first()->group_slots); ?></td>	
			<td><?php echo e($d->last_login); ?></td>
			<?php if($auth && $me->user_admin >= 1): ?>
				<td>
					<?php if($d->last7 < 10): ?>
						<b><span class="red"> <?php echo e($d->last7); ?></span></b>
					<?php else: ?>
						<?php echo e($d->last7); ?>

					<?php endif; ?>
				</td>			
			<?php endif; ?>					
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</tbody>
</table>

Complaints created last 7 days: <b><?php echo e($complaints_7d); ?></b><br/>
Complaints created last 24h: <b><?php echo e($complaints_24h); ?></b><br>
Newbie questions asked in the last 7 days: <b><?php echo e($newbie); ?></b>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Staff'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>