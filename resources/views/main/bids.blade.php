@extends('layout.main', ['title' => 'Bids'])


@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li class="active">Bids</li>
@endsection

@section('content')
	<p>
	Proprietatiile playerilor inactivi (ce au sub 10 ore jucate in ultimele 60 zile) vor fi afisate pe aceasta pagina.<br>
	In fiecare luni, serverul va verifica activitatea playerilor de pe server, iar proprietatiile celor inactivi vor fi transferate catre AdmBot<br>
	In weekend (sambata si duminica) intre orele 20:00 - 00:00, proprietatiile detinute de AdmBot vor fi scoase la licitatie, iar playerii vor putea licita pentru ele in joc (folosind /bid).	
	</p>
	<hr>

	Businesses:
	<ul>
		@foreach($biz as $b)
			<li>{{$b->id}} - <a href="{{url('map/'.$b->biz_exterior_posX.'/'.$b->biz_exterior_posY)}}"><i class="icon-map-marker"></i> display on map</a></li>
		@endforeach
	</ul>

	Houses:
	<ul>
		@foreach($houses as $h)
			<li>{{$h->id}} - <a href="{{url('map/'.$h->house_exterior_posX.'/'.$h->house_exterior_posY)}}"><i class="icon-map-marker"></i> display on map</a></li>
		@endforeach
	</ul>

@endsection