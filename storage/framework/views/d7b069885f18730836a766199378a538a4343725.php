<?php $__env->startSection('breadcrumb'); ?>
	<i class="icon-angle-right"></i>
	<li><a href="<?php echo e(url('/group/list')); ?>">Factions</a></li>
	<i class="icon-angle-right"></i>
	<li class="active">Faction Complaints</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="col-xs-12 center">
	<div class="table-responsive">
		<div class="pull-left control-group">
			<a href="<?php echo e(url('/complaint/create')); ?>" class="btn btn-danger">New Complaint</a>
		</div>
		<br>
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Title</th>
					<th>Created By</th>
					<th>
						<i class="icon-time bigger-110 hidden-480"></i>
						Date
					</th>
					<th class="hidden-480">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php $__currentLoopData = $data->where('status', '=', 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td>
							<?php if($complaint->reason == 7): ?>
								<a href="<?php echo e(url('/complaint/view/' . $complaint->id)); ?>"><?php echo e($complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] . ' - faction: ' . App\Group::getGroupName($complaint->user_group)); ?></a>
							<?php else: ?>
								<a href="<?php echo e(url('/complaint/view/' . $complaint->id)); ?>"><?php echo e($complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason]); ?></a>
							<?php endif; ?>
						</td>
						<td><?php echo e($complaint->creator_name); ?></td>
						<td><?php echo e($complaint->time); ?></td>
						<td>
							<?php if($complaint->status == 0): ?>
								Open
							<?php elseif($complaint->status == 1): ?>
								Closed
							<?php elseif($complaint->status == 2): ?>
								Waiting for owner reply
							<?php elseif($complaint->status == 3): ?>
								Deleted
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>															
			</tbody>
		</table>
		<h2>Archive</h2>
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Title</th>
					<th>Created By</th>
					<th>
						<i class="icon-time bigger-110 hidden-480"></i>
						Date
					</th>
					<th class="hidden-480">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php $__currentLoopData = $data->where('status', '=', 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td>
							<?php if($complaint->reason == 7): ?>
								<a href="<?php echo e(url('/complaint/view/' . $complaint->id)); ?>"><?php echo e($complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] . ' - faction: ' . App\Group::getGroupName($complaint->user_group)); ?></a>
							<?php else: ?>
								<a href="<?php echo e(url('/complaint/view/' . $complaint->id)); ?>"><?php echo e($complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason]); ?></a>
							<?php endif; ?>
						</td>
						<td><?php echo e($complaint->creator_name); ?></td>
						<td><?php echo e($complaint->time); ?></td>
						<td>
							<?php if($complaint->status == 0): ?>
								Open
							<?php elseif($complaint->status == 1): ?>
								Closed
							<?php elseif($complaint->status == 2): ?>
								Waiting for owner reply
							<?php elseif($complaint->status == 3): ?>
								Deleted
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
				<?php $__currentLoopData = $data->where('status', '=', 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $complaint): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td>
							<?php if($complaint->reason == 7): ?>
								<a href="<?php echo e(url('/complaint/view/' . $complaint->id)); ?>"><?php echo e($complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] . ' - faction: ' . App\Group::getGroupName($complaint->user_group)); ?></a>
							<?php else: ?>
								<a href="<?php echo e(url('/complaint/view/' . $complaint->id)); ?>"><?php echo e($complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason]); ?></a>
							<?php endif; ?>
						</td>
						<td><?php echo e($complaint->creator_name); ?></td>
						<td><?php echo e($complaint->time); ?></td>
						<td>
							<?php if($complaint->status == 0): ?>
								Open
							<?php elseif($complaint->status == 1): ?>
								Closed
							<?php elseif($complaint->status == 2): ?>
								Waiting for owner reply
							<?php elseif($complaint->status == 3): ?>
								Deleted
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>															
			</tbody>
		</table>	
	</div>
</div>	

<div class="pagination pagination-centered">
	<ul class="pagination">
		<?php echo e($data->render()); ?>

	</ul>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Faction Complaints'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>