@extends('layout.main', ['title' => "Raport logs"])


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
