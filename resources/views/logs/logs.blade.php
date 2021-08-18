@extends('layout.main', ['title' => 'Player Logs'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li><a href="{{url('/profile/'.$username.'')}}">{{$username}}</a></li>
	<i class="icon-angle-right"></i>
	<li class="active">Player logs</li>
@endsection


@section('content')
<table class="table">
	<tbody>
		@foreach($data as $d)
			<tr>
				<td>{!! $d->text !!}</td>
				<td>{{$d->time}}</td>
				<td>{{$d->type}}</td>
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
