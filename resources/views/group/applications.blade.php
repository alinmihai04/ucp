@extends('layout.main', ['title' => 'Applications Lits - ' . $groupname])

@section('content')

<div class="page-header">
    <h1>Aplicatii pentru {{ $groupname }}</h1>
</div>

<h4 class="purple">
    <i class="icon-list-ul"></i>
    Playeri acceptati pentru teste ({{ $data->where('status', '=', 2)->count() }})
</h4>
<table class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
        <th class="center">ID</th>
        <th>Player</th>
        <th class="hidden-100">Date</th>
        <th class="hidden-480">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach($data->where('status', '=', 2) as $a)
                <td class="center">
                    {{ $a->id }}
                </td>
                <td>
                    <a href="{{ url('/group/viewapplication/' . $a->id) }}">{{ $a->name }}</a>
                </td>
                <td class="hidden-100">
                    {{ $a->time }}
                </td>
                <td class="hidden-480">
                    <a href="{{ url('/group/viewapplication/' . $a->id) }}">Citeste aplicatie</a>
                </td>
            @endforeach
        </tr>
    </tbody>
</table>

<h4 class="blue">
    <i class="icon-sun"></i>
    Aplicatii noi ({{ $data->where('status', '=', 0)->count() }})
</h4>
<table class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
        <th class="center">ID</th>
        <th>Player</th>
        <th class="hidden-100">Date</th>
        <th class="hidden-480">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach($data->where('status', '=', 0) as $a)
                <td class="center">
                    {{ $a->id }}
                </td>
                <td>
                    <a href="{{ url('/group/viewapplication/' . $a->id) }}">{{ $a->name }}</a>
                </td>
                <td class="hidden-100">
                    {{ $a->time }}
                </td>
                <td class="hidden-480">
                    <a href="{{ url('/group/viewapplication/' . $a->id) }}">Citeste aplicatie</a>
                </td>
            @endforeach
        </tr>
    </tbody>
</table>

<h4 class="red">
    <i class="icon-thumbs-down"></i>
    Aplicatii noi ({{ $data->where('status', '=', 1)->count() }})
</h4>
<table class="table table-striped table-condensed table-hover">
    <thead>
        <tr>
        <th class="center">ID</th>
        <th>Player</th>
        <th class="hidden-100">Date</th>
        <th class="hidden-480">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @foreach($data->where('status', '=', 1) as $a)
                <td class="center">
                    {{ $a->id }}
                </td>
                <td>
                    <a href="{{ url('/group/viewapplication/' . $a->id) }}">{{ $a->name }}</a>
                </td>
                <td class="hidden-100">
                    {{ $a->time }}
                </td>
                <td class="hidden-480">
                    <a href="{{ url('/group/viewapplication/' . $a->id) }}">Citeste aplicatie</a>
                </td>
            @endforeach
        </tr>
    </tbody>
</table>

@endsection
