@extends('layout.main', ['title' => $groupname."'s logs"])

@section('breadcrumb')
<i class="icon-angle-right"></i>
<li><a href="{{url('/group/view/'.$group)}}">{{$groupname}}</a></li>
<i class="icon-angle-right"></i>
<li class="active">Group logs</li>
@endsection

@section('content')
    <table class="table">
        <tbody>
        @foreach($data as $d)
            <tr>
                <td>{{$d->text}}</td>
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
