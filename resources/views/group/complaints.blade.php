@extends('layout.main', ['title' => 'Faction Complaints'])

@section('breadcrumb')
	<i class="icon-angle-right"></i>
	<li><a href="{{ url('/group/list') }}">Factions</a></li>
	<i class="icon-angle-right"></i>
	<li class="active">Faction Complaints</li>
@endsection

@section('content')

<div class="col-xs-12 center">
	<div class="table-responsive">
		<div class="pull-left control-group">
			<a href="{{ url('/complaint/create') }}" class="btn btn-danger">New Complaint</a>
		</div>
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
			</tbody>
		</table>
		<h2>Archive</h2>
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
				@foreach($data->where('status', '=', 3) as $complaint)
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