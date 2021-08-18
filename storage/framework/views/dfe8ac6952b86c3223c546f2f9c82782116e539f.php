<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>Clan <?php echo e($data->clan_name); ?></h1>
</div>

<div class="row-fluid">
	<div class="span3">
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-info"></i>
					Clan info
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					Name: <?php echo e($data->clan_name); ?><br>
					Tag: <?php echo e($data->clan_tag); ?><br>
					Members: <?php echo e($members->count()); ?>/<?php echo e($data->clan_slots); ?><br><br>
					Created at: <b><?php echo e($data->clan_created); ?></b><br>
					Expires at: <b><?php echo e(date('Y-m-d H:i:s', $data->clan_expire)); ?></b>
				</div>
			</div>
		</div>
		<br>
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-info"></i>
					Clan forum
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<a href="#" class="btn btn-inverse btn-block">View clan forum</a>
				</div>
			</div>
		</div>
		<br>
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-info"></i>
					Clan ranks
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					1 - <?php echo e($data->clan_rankname1); ?><br>
					2 - <?php echo e($data->clan_rankname2); ?><br>
					3 - <?php echo e($data->clan_rankname3); ?><br>
					4 - <?php echo e($data->clan_rankname4); ?><br>
					5 - <?php echo e($data->clan_rankname5); ?><br>
					6 - <?php echo e($data->clan_rankname6); ?><br>
					7 - <?php echo e($data->clan_rankname7); ?><br>
				</div>
			</div>
		</div>				
	</div>
	<div class="span6">
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-user green"></i>
					Clan members
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<ul>
						<?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li><a href="<?php echo e(url('/profile/'.$m->name)); ?>"><?php echo e($m->name); ?></a> - rank <?php echo e($m->rank); ?> - joined on <?php echo e($m->joined); ?> (<?php echo e($m->days); ?> days in clan)</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
					</ul>
				</div>
			</div>
		</div>			
	</div>
	<div class="span3">
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-comments red"></i>
					Clan MOTD
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<?php echo e($data->clan_motd); ?>

				</div>
			</div>
		</div>		
		<br>	
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-ticket red"></i>
					Clan description
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<span class="claninfo">
						<?php echo $data->clan_desc; ?>

						<br><br>
						<?php if($auth && ($me->user_admin > 0 || ($me->user_clanrank == 7 && $me->user_clan == $data->id))): ?>
							<c class="btn btn-info btn-small" onclick="startediting(); ">Edit</a>						
						<?php endif; ?>
					</span>

				<form class="clanedit" action="http://blackpanel.bugged.ro/clan/view/2" method="POST" style="display: none;">
				<textarea name="cinfo" class="span12" rows="20">????Edited by Admin Ap9llo</textarea>
				<input type="submit" value="Save" class="btn btn-success btn-small">
				<input type="hidden" name="_token" value="l631UUbk7XbbHbvxl2a7hzghkIueVqipsEXSpA7f">
				</form>									
				</div>
			</div>
		</div>
		<br>
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-ticket red"></i>
					<a href="<?php echo e(url('/logs/clan/'.$data->id)); ?>">Clan logs</a>
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<ul>
						<?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li>
								<?php echo e($l->time); ?> <br>
								<?php echo e($l->log); ?>

							</li>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</ul>
				</div>
			</div>
		</div>	
		<?php if($auth && ($me->user_admin >= 5 || ($me->user_clanrank == 7 && $me->user_clan == $data->id))): ?>
		<br>
		<div class="widget-box">
			<div class="widget-header widget-header-flat widget-header-small">
				<h5>
					<i class="icon-legal red"></i>
					Admin tools
				</h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<a href="<?php echo e(url('/clan/delete/' . $data->id)); ?>" class="btn btn-primary" onclick="return confirm('Esti sigur ca vrei sa stergi clanul? Actiunea nu poate fi remediata. Nu iti vei primi inapoi punctele premium pe care le-ai folosit pentru a crea acest clan.');"><i class="icon-trash"></i>Delete clan</a>
				</div>
			</div>
		</div>				
		<?php endif; ?>				
	</div>	
</div>

<script>
	$('.clanedit').hide();
	$('.startediting').click(function(){
		$('.clanedit').show();
		$('.textareaishidden').hide();
		$('.claninfo').hide();
	});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', ['title' => 'Clan: '.$data->clan_name], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>