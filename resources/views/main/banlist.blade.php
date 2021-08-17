@extends('layout.main', ['title' => 'Ban list'])

@section('content')

<table class="table">
	<tbody>
		<tr class="info">
			<td>Player</td>
			<td>Ban Date</td>
			<td>Ban Reason</td>
			<td>Banned by</td>
			<td>Ban Expire at</td>
			<td>IP Ban</td>
		</tr>

		@foreach($data as $d)
			<tr>
				<td><a href="{{ url('/profile/' . App\User::getName($d->ban_playerid)) }}">{{ App\User::getName($d->ban_playerid) }}</a></td>
				<td>{{ $d->ban_currenttime }}</td>
				<td>{{ $d->ban_reason }}</td>
				<td>{{ $d->ban_adminname }}</td>
				<td>
					@if($d->ban_permanent == 1)
						permanent
					@elseif($d->ban_expiretimestamp == 0)
						ban expired / unbanned  
					@else
						{!! date('j M Y, H:i', $d->ban_expiretimestamp) !!}
					@endif
				</td>
				<td>{{ $d->ban_ipban == 1 ? 'yes' : 'no' }}</td>
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