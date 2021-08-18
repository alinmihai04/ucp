<?php $__env->startSection('content'); ?>

<?php if($data->user_admin > 0 || $data->user_helper > 0): ?>
	<div class="alert alert-error">
		Reclamatiile impotriva unui admin/helper se fac DOAR pentru chestii grave.<br>Orice reclamatie facuta pentru un mute/kick va fi ignorata iar playerul ce a facut reclamatia va fi sanctionat cu suspend 5 - 30 zile in panel.<br>Daca stii ca esti vinovat si faci reclamatie doar pentru a vedea dovezile vei fi sanctiont cu suspend 5-30 zile in panel.<br>Daca ti s-a raspuns la o reclamatie si ti s-a zis ca sunt dovezi insuficiente, in 99% din cazuri si adminul ce va raspunde la reclamatiile pentru admini va spune acelasi lucru.<br>Nu crea reclamatii daca nu e ceva grav sau poti fi sanctionat cu suspend 5-30 zile in panel.
	</div>
<?php endif; ?>

<div class="row-fluid">
	<div class="span4">
		<h4>Player reclamat</h4>
		<ul>
			<li>Nickname: <?php echo e($data->name); ?></li>
			<li>Factiune: <?php echo e($data->user_group == 0 ? 'Civilian' : App\Group::getGroupName($data->user_group) . ", rank " . $data->user_grouprank); ?></li>
			<li>Level: <?php echo e($data->user_level); ?></li>
			<li>Ore jucate: <?php echo e($data->user_hours); ?></li>
		</ul>
		<h4>Info</h4>
		<ul>
			<li>Inainte de a reclama un player, cititi <a href="#">regulamentul serverului</a>. Daca faceti reclamatie unui lider, cititi si <a href="#">regulamentul liderilor</a>.</li>
			<li>Puteti uploada imagini pe site-uri ca <a href="http://imgur.com" target="_blank">imgur</a></li>
		</ul>
	</div>	

	<div class="span6">
		<h4>Creaza o reclamatie</h4>
		<?php echo Form::open(['url' => '/complaint/create/' . $data->id]); ?>

			<select name="reason">
				<?php if($data->user_group > 0): ?>
					<option value="2">Factiune</option>
				<?php endif; ?>
				<option value="1">DM</option>
				<option value="3">Jigniri, injurii, limbaj vulgar</option>
				<option value="4">Inselatorie</option>
				<option value="5">Altceva (abuz, comportament non RP)</option>
				<?php if($data->user_admin > 0 || $data->user_helper > 0): ?>
					<option value="6">Abuz admin/helper</option>
				<?php endif; ?>
				<?php if($data->user_grouprank == 7): ?>
					<option value="7">Greseli ca lider</option>
				<?php endif; ?>				
			</select> 
			<br>
			<?php echo Form::label('links', 'Dovezi (screenshot-uri, video-uri)'); ?>

			<?php echo Form::textarea('links', '', ['class' => 'span10', 'rows' => 3, 'cols' => 50]); ?>		
			<br>
			<?php echo Form::label('desc', 'Detalii'); ?>

			<?php echo Form::textarea('desc', '', ['class' => 'span10', 'rows' => 5, 'cols' => 50]); ?>			
			<br>
			<?php echo Form::submit('Post complaint', ['class' => 'btn btn-small btn-danger']); ?>

		<?php echo Form::close(); ?>

	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Add Complaint'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>