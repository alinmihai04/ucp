@extends('layout.main', ['title' => 'Beta testers'])

@section('content')
<h4>Beta testers ({{ $data->count() }})</h4>

<table class="table table-hover">
	<tbody>
		<tr class="warning table-bordered">
			<td>SQL ID</td>
			<td>Name</td>
			<td>Level</td>
		</tr>
		@foreach($data as $d)
			<tr>
				<td>
					{{ $d->id }}
				</td>
				<td>
					{!! $d->user_status == 0 ? "<i class='icon-circle light-red'></i>" : "<i class='icon-circle light-green'></i>" !!}
					<a href="{{ url('/profile/' . $d->name) }}">{{ $d->name }}</a>
				</td>
				<td>
					{{ $d->user_level }}
				</td>	
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