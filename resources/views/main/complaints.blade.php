@extends('layout.main', ['title' => 'Complaints'])

@section('breadcrumb')
<i class="icon-angle-right"></i>
<li class="active">Complaints</li>
@endsection

@section('content')
<div class="col-xs-12 center">
	<div class="table-responsive">
        @if(!isset($mycomplaints))
		<div class="pull-left control-group">
			<a href="{{ url('/complaint/create') }}" class="btn btn-danger">New Complaint</a>
		</div>
		<div class="pull-left control-group">
			&nbsp;<a href="{{ url('/mycomplaints') }}" class="btn btn-info">Reclamatii create de mine</a>
		</div>
        @endif
		<br>
		<table id="sample-table-1" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Title</th>
					<th>Created By</th>
					<th>
						<i class="icon-time bigger-110 hidden-480"></i>
						Date
					</th>
					<th class="hidden-480">Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data->where('status', '=', 0) as $complaint)
					<tr>
						<td>
							@if($complaint->reason == 7)
								<a href="{{ url('/complaint/view/' . $complaint->id) }}">{{ $complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] . ' - faction: ' . App\Group::getGroupName($complaint->user_group) }}</a>
							@else
								<a href="{{ url('/complaint/view/' . $complaint->id) }}">{{ $complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] }}</a>
							@endif
						</td>
						<td>{{ $complaint->creator_name }}</td>
						<td>{{ $complaint->time }}</td>
						<td>
							@if($complaint->status == 0)
								Open
							@elseif($complaint->status == 1)
								Closed
							@elseif($complaint->status == 2)
								Waiting for owner reply
							@elseif($complaint->status == 3)
								Deleted
							@endif
						</td>
					</tr>
				@endforeach
				@foreach($data->where('status', '=', 1) as $complaint)
					<tr>
						<td>
							@if($complaint->reason == 7)
								<a href="{{ url('/complaint/view/' . $complaint->id) }}">{{ $complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] . ' - faction: ' . App\Group::getGroupName($complaint->user_group) }}</a>
							@else
								<a href="{{ url('/complaint/view/' . $complaint->id) }}">{{ $complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] }}</a>
							@endif
						</td>
						<td>{{ $complaint->creator_name }}</td>
						<td>{{ $complaint->time }}</td>
						<td>
							@if($complaint->status == 0)
								Open
							@elseif($complaint->status == 1)
								Closed
							@elseif($complaint->status == 2)
								Waiting for owner reply
							@elseif($complaint->status == 3)
								Deleted
							@endif
						</td>
					</tr>
				@endforeach
				@foreach($data->where('status', '=', 2) as $complaint)
					<tr>
						<td>
							@if($complaint->reason == 7)
								<a href="{{ url('/complaint/view/' . $complaint->id) }}">{{ $complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] . ' - faction: ' . App\Group::getGroupName($complaint->user_group) }}</a>
							@else
								<a href="{{ url('/complaint/view/' . $complaint->id) }}">{{ $complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] }}</a>
							@endif
						</td>
						<td>{{ $complaint->creator_name }}</td>
						<td>{{ $complaint->time }}</td>
						<td>
							@if($complaint->status == 0)
								Open
							@elseif($complaint->status == 1)
								Closed
							@elseif($complaint->status == 2)
								Waiting for owner reply
							@elseif($complaint->status == 3)
								Deleted
							@endif
						</td>
					</tr>
				@endforeach
				@foreach($data->where('status', '=', 3) as $complaint)
					<tr class='warning'>
						<td>
							@if($complaint->reason == 7)
								<a href="{{ url('/complaint/view/' . $complaint->id) }}">{{ $complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] . ' - faction: ' . App\Group::getGroupName($complaint->user_group) }}</a>
							@else
								<a href="{{ url('/complaint/view/' . $complaint->id) }}">{{ $complaint->name . ' - ' . App\Complaint::$reason_text[$complaint->reason] }}</a>
							@endif
						</td>
						<td>{{ $complaint->creator_name }}</td>
						<td>{{ $complaint->time }}</td>
						<td>
							@if($complaint->status == 0)
								Open
							@elseif($complaint->status == 1)
								Closed
							@elseif($complaint->status == 2)
								Waiting for owner reply
							@elseif($complaint->status == 3)
								Deleted
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<div class="pagination pagination-centered">
	<ul class="pagination">
		{{$data->render()}}
	</ul>
</div>
@endsection
