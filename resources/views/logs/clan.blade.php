@extends('layout.main', ['title' => 'Clan Logs: ' . $clan])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li><a href="{{url('/clan/view/'.$clan.'')}}">{{ 'Clan ' . $clan }}</a></li>
	<i class="icon-angle-right"></i>
	<li class="active">Clan logs: {{ $clan }}</li>
@endsection


@section('content')
<table class="table">
	<tbody>
		@foreach($data as $d)
			<tr>
				<td>{{$d->log}}</td>
				<td>{{$d->time}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<div class="pagination pagination-centered">
	<ul class="pagination">
		{{$data->render()}}
	</ul>
</div>
@endsection