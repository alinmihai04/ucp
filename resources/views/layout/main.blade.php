<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />

	<title>{{$title}} - {{config('app.title')}} Panel</title>

	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-responsive.min.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}" />

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet">

	<!-- ace styles -->
	<link rel="stylesheet" href="{{ URL::asset('css/ace.min.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/ace-responsive.min.css') }}" />
	<link rel="stylesheet" href="{{ URL::asset('css/ace-skins.min.css') }}" />

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body class style>
	@include('layout.header') <!-- include header elements !-->

	<div class="main-content">
		<div class="breadcrumbs" id="breadcrumbs">
			<script type="text/javascript">
				try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
			</script>

			<ul class="breadcrumb">
				<li>
					<i class="icon-home home-icon"></i>
					<a href="{{url('/')}}">Home</a>
				</li>
				@yield('breadcrumb')
			</ul><!-- /.breadcrumb -->
			<div class="nav-search" id="nav-search">
				{!! Form::open(['url' => '/search', 'class' => 'form-search']) !!}
				<span class="input-icon">
					{!! Form::text('sname', '', ['class' => 'nav-search-input', 'placeholder' => 'Search ...', 'autocomplete' => 'off']) !!}
					<i class="icon-search nav-search-icon"></i>
				</span>
				{!! Form::close() !!}
			</div> <!-- /.nav-search -->
		</div>
		<div class="page-content">
			<div class="row-fluid">
				<div class="span12">
					@if(session('success'))
						<div class="alert alert-success">{!! session('success') !!}</div>
					@elseif(session('error'))
						<div class="alert alert-danger">{!! session('error') !!}</div>
					@elseif(session('info'))
						<div class="alert alert-info">{!! session('info') !!}</div>
					@endif
					<div class="row-fluid">
						@yield('content')
					</div>
				</div>
			</div>

	@include('layout.footer')

</body>
