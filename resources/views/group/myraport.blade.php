@extends('layout.main', ['title' => 'Raportul meu de activitate'])


@section('content')

<div class="page-header">
	<h1>Raportul meu de activitate</h1>
</div>

Esti un membru al factiunii <b>{{ App\Group::getGroupName($me->user_group) }}</b> din <b> {{ date('d.m.Y', strtotime($f_stats->joined)) }}</b>
<br>
Rank: <b> {{ $f_stats->rank }} </b>

<hr>

@foreach($goals as $g)
	@if($g->rank == $f_stats->rank || !$g->rank)

		<?php $shown = false; ?>

		@foreach($points as $p)

			@if($p->type == $g->type)
				<?php $shown = true; ?>

				{{ ucfirst(trans('goals.' . $g->type)) }}
				@if($g->type == 0)
					<div class="progress progress-striped" style="" data-percent="{{ gmdate('H:i', $p->current) }}/{{ gmdate('H:i', $g->goal) }}">
						<div class="bar bar-success" style="width: {{ ($p->current/($g->goal))*100 }}%;"></div>
					</div>	
				@else
					<div class="progress progress-striped" style="" data-percent="{{ $p->current }}/{{ $g->goal }}">
						<div class="bar bar-success" style="width: {{ ($p->current/$g->goal)*100 }}%;"></div>
					</div>
				@endif

			@endif

		@endforeach

		@if(!$shown)
			<?php $shown = true; ?>

			{{ ucfirst(trans('goals.' . $g->type)) }}
			@if($g->type == 0)
				<div class="progress progress-striped" style="" data-percent="{{ gmdate('H:i', 0) }}/{{ gmdate('H:i', $g->goal) }}">
					<div class="bar bar-success" style="width: 0%;"></div>
				</div>	
			@else
				<div class="progress progress-striped" style="" data-percent="0/{{ $g->goal }}">
					<div class="bar bar-success" style="width: 0%;"></div>
				</div>
			@endif
		@endif
	@endif
@endforeach

<hr>

Raportul tau de activitate va fi procesat <b>{{ $process_date }}</b>.<br>

<p>
@if($me->user_grouprank > 5)
	Nu vei primi rank up dupa procesarea raportului de activitate.
@else
	Vei primi rank up <b>{{ $rankup_date }}</b>.
@endif
</p>

<hr>
<h4>Faction Warn-uri</h4>
<p>
@if($f_stats->fw == 0)
	Nu ai faction warn-uri primite.
@else
	Ai <b>{{ $f_stats->fw }}/3</b> Faction Warn-uri
@endif
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

@endsection