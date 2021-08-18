<?php $__env->startSection('content'); ?>
	
<?php if($me->user_clan > 0): ?>
	<div class="alert alert-danger">You already are a part of a clan.</div>
<?php endif; ?>

<div class="alert alert-error">
	RO: Registering a clan costs 100 premium points for a 6 month period. After that you will have to pay 10 premium points / month to renew it!<br>
	RO: Inregistrarea unui clan costa 100 puncte premium / 6 luni. Dupa aceasta perioada, prelungirea clanului va costa 10 puncte premium / luna!<br><br>
	EN: Taking the name of another well-known clan that is not registered is strictly forbidden. Your clan will get deleted. Don't register clans like ZEW, St., [AIM] if you are not the founder of that clan.<br>
	EN: Inregistrarea numelui unui alt clan cunoscut care nu este inregistrat este interzisa. Clanul tau poate fi sters. Nu inregistra clanuri ca ZEW, St., [AIM] daca nu esti fondatorul clanului.<br><br>
</div>
<div class="row-fluid">
	<div class="span4">
		<h4>Informatii</h4>
		<ul>
			<li>Clanul iti aduce un chat in joc (/c) si optiunea de a putea invita playeri in clan.</li>
			<li>Se pot modifica numele rank-urilor pentru clanuri (ce apar in chat) si culoarea pentru chatul clanului.</li>
			<li>Exista o limita de 25 membri pentru fiecare clan.</li>
			<li>Clanurile nu au HQ-uri, masini pt clan, war-uri intre clanuri. Clanurile sunt o metoda de a comunica mai usor cu un grup de playeri.</li>
			<br>
			<li>Este interzis sa postati orice legat de piraterie in forumul clanului (link-uri download filme, muzica, jocuri, crack-uri)</li>
			<li>Este interzis sa folositi forumul pentru a jigni alti playeri / clanuri / factiuni</li>
			<li>Regulile generale ale forumului se aplica si in forumurile clanurilor</li>
			<li>Alegeti un nume normal pentru clan. Nu folositi numele altor clanuri. Nu folositi cuvinte vulgare.</li>
			<li>Nerespectarea regulilor poate duce la stergerea clanului</li>
			<li>Vanzarea clanurilor este interzisa!</li>
			<li>Cererea de bani pentru acceptarea in clan/rank up este interzisa</li>
			<li>Playerii ce folosesc clanurile pentru inselatorii (cererea de bani/masini pentru acceptarea in clan, cererea de bani imprumut pentru acceptarea in clan) vor fi banati permanent si vor avea clanul sters</li>
			<li>Clanurile nu pot avea blacklist. Omorarea unui alt player care e pe blacklist se sanctioneaza ca DM.</li>
			<li>Clanurile nu sunt mafii. Nu va fi implementat vreodata sistem de war-uri intre clanuri.</li>
			<li>Pentru a lasa alt player sa fie liderul clanului, acel player trebuie sa aiba 30 zile in clan.</li>
			<li>Nu inregistrati clanuri cu promoveaza cheat-urile in vreun fel (ex: clanul codatilor, clanul aimbot, clanul norecoil)</li>
		</ul>
		<h4>Info</h4>
		<ul>
			<li>By registering a clan, you will get a clan chat (/c) and you will be able to invite people into your clan</li>
			<li>There is a limit of 25 members for every clan</li>
			<li>The clan owner will be able to modify rank names and the chat color for the clan chat(/c).</li>
			<br>
			<li>You're not allowed to post anything warez-related on the forums (download links for torrents, mp3s, videos, games, software, cracks)</li>
			<li>It's forbidden to use the forum just to insult other players/clans/factions</li>
			<li>The forum rules also apply on clan subforums</li>
			<li>Choose a unique name. Don't copy the name of other clans.</li>
			<li>Not respecting the rules could lead to your clan being removed</li>
			<li>You're not allowed to sell your clan.</li>
			<li>You're not allowd to use the clan for scams. Your clan will be removed and you will get banned.</li>
			<li>You're not allowed to ask for money to accept someone to join your clan.</li>
			<li>To make someone else the owner of the clan, that person will have to in the clan for more than 30 days.</li>
		</ul>
	</div>
	<div class="span8">
		<h4>Register a clan</h4>

		<?php echo Form::open(['url' => '/clan/register']); ?>

		<?php echo Form::label('name', 'Clan name:'); ?>

		<?php echo Form::text('name', ''); ?>

		<?php echo Form::label('tag', 'Clan tag (ex: [TAG], Tag., _Tag, .Tag):'); ?>

		<?php echo Form::text('tag', ''); ?>

		<br>
		
		<?php echo Form::submit('Register clan', ['class' => 'btn btn-inverse']); ?>

		<?php echo Form::close(); ?>		
	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Register a Clan'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>