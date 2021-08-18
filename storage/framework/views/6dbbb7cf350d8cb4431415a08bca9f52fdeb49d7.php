<?php $__env->startSection('content'); ?>

<div class="page-header">
	<h1>Raportul meu de activitate</h1>
</div>

Esti un membru al factiunii <b><?php echo e(App\Group::getGroupName($me->user_group)); ?></b> din <b> <?php echo e(date('d.m.Y', strtotime($f_stats->joined))); ?></b>
<br>
Rank: <b> <?php echo e($f_stats->rank); ?> </b>

<hr>

<?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if($g->rank == $f_stats->rank || !$g->rank): ?>

		<?php $shown = false; ?>

		<?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

			<?php if($p->type == $g->type): ?>
				<?php $shown = true; ?>

				<?php echo e(ucfirst(trans('goals.' . $g->type))); ?>

				<?php if($g->type == 0): ?>
					<div class="progress progress-striped" style="" data-percent="<?php echo e(gmdate('H:i', $p->current)); ?>/<?php echo e(gmdate('H:i', $g->goal)); ?>">
						<div class="bar bar-success" style="width: <?php echo e(($p->current/($g->goal))*100); ?>%;"></div>
					</div>	
				<?php else: ?>
					<div class="progress progress-striped" style="" data-percent="<?php echo e($p->current); ?>/<?php echo e($g->goal); ?>">
						<div class="bar bar-success" style="width: <?php echo e(($p->current/$g->goal)*100); ?>%;"></div>
					</div>
				<?php endif; ?>

			<?php endif; ?>

		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

		<?php if(!$shown): ?>
			<?php $shown = true; ?>

			<?php echo e(ucfirst(trans('goals.' . $g->type))); ?>

			<?php if($g->type == 0): ?>
				<div class="progress progress-striped" style="" data-percent="<?php echo e(gmdate('H:i', 0)); ?>/<?php echo e(gmdate('H:i', $g->goal)); ?>">
					<div class="bar bar-success" style="width: 0%;"></div>
				</div>	
			<?php else: ?>
				<div class="progress progress-striped" style="" data-percent="0/<?php echo e($g->goal); ?>">
					<div class="bar bar-success" style="width: 0%;"></div>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<hr>

Raportul tau de activitate va fi procesat <b><?php echo e($process_date); ?></b>.<br>

<p>
<?php if($me->user_grouprank > 5): ?>
	Nu vei primi rank up dupa procesarea raportului de activitate.
<?php else: ?>
	Vei primi rank up <b><?php echo e($rankup_date); ?></b>.
<?php endif; ?>
</p>

<hr>
<h4>Faction Warn-uri</h4>
<p>
<?php if($f_stats->fw == 0): ?>
	Nu ai faction warn-uri primite.
<?php else: ?>
	Ai <b><?php echo e($f_stats->fw); ?>/3</b> Faction Warn-uri
<?php endif; ?>
</p>

<hr>

Daca faci mai multe puncte de activitate decat este necesar pentru a termina raportul, acestea vor fi transferate pentru raportul de activitate de saptamana viitoare.<br>
Va fi transferat un maxim de puncte de activitate egal cu raportul de activitate.<br>
<br>

Ex #1: Daca raportul de activitate este de 200 puncte activitate si faci 450 puncte de activitate, in saptamana viitoare vei avea 200 puncte de activitate.<br>
Ex #2: Daca raportul de activitate este de 200 puncte activitate si faci 350 puncte de activitate, in saptamana viitoare vei avea 150 puncte de activitate.<br>
<br>

<hr>

<h4>Informatii rank up</h4>

La terminarea raportului de activitate vei primi rank up automat daca ai raportul complet si ai rank up disponibil.<br>
Rank up-ul va fi primit doar cand sunt procesate/resetate rapoartele de activitate daca ai un rank up disponibil.<br>
<br>
Playerii de rank 1 si 2 vor primi rank up dupa 14 zile daca au raportul de activitate complet.<br>
Playerii cu rank 3+ vor primi rank up automat o data la 7 zile daca au raportul de activitate complet.<br>
Playerii de rank 5+ nu vor primi rank up automat.<br>
Primirea unui FW va adauga 7 zile in care nu vei primi rank up<br>
FW-urile sunt serse de pe cont dupa 5 zile de la data acordarii lor.

<hr>

<h4>Informatii inactivitate</h4>
Playerii de rank 1 cu raport de activitate incomplet vor primi uninvite automat cu FP.<br>
Playerii de rank 2+ cu raport de activitate incomplet vor primi un avertisment (ce se va sterge automat dupa 20 zile). Playerii cu rank 2+ ce au deja un avertisment si nu isi termina raportul de activitate vor primi automat uninvite fara FP.<br>
<br>
Daca ai o perioada in care esti inactiv, poti recupera punctele de activitate dupa ce revii pe server sau poti face mai multe puncte de activitate inainte de o perioada de inactivitate.<br>
Nu se vor mai face cereri de inactivitate.

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Raportul meu de activitate'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>