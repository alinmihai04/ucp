@extends('layout.main', ['title' => $groupname."'s logs"])

@section('breadcrumb')
<i class="icon-angle-right"></i>
<li><a href="{{url('/group/view/'.$group)}}">{{$groupname}}</a></li>
<i class="icon-angle-right"></i>
<li class="active">Group logs</li>
@endsection