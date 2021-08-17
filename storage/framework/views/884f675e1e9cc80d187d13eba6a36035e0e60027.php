<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />

	<title><?php echo e($title); ?> - <?php echo e(config('app.title')); ?> Panel</title>

	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo e(URL::asset('public/css/bootstrap.min.css')); ?>" />
	<link rel="stylesheet" href="<?php echo e(URL::asset('public/css/bootstrap-responsive.min.css')); ?>" />
	<link rel="stylesheet" href="<?php echo e(URL::asset('public/css/font-awesome.min.css')); ?>" />
	<link rel="stylesheet" href="<?php echo e(URL::asset('public/css/custom.css')); ?>" />

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet">

	<!-- ace styles -->
	<link rel="stylesheet" href="<?php echo e(URL::asset('public/css/ace.min.css')); ?>" />
	<link rel="stylesheet" href="<?php echo e(URL::asset('public/css/ace-responsive.min.css')); ?>" />
	<link rel="stylesheet" href="<?php echo e(URL::asset('public/css/ace-skins.min.css')); ?>" />

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body class style>
	<?php echo $__env->make('layout.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <!-- include header elements !-->

	<div class="main-content">
		<div class="breadcrumbs" id="breadcrumbs">
			<script type="text/javascript">
				try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
			</script>

			<ul class="breadcrumb">
				<li>
					<i class="icon-home home-icon"></i>
					<a href="<?php echo e(url('/')); ?>">Home</a>
				</li>
				<?php echo $__env->yieldContent('breadcrumb'); ?>
			</ul><!-- /.breadcrumb -->
			<div class="nav-search" id="nav-search">
				<?php echo Form::open(['url' => '/search', 'class' => 'form-search']); ?>

				<span class="input-icon">
					<?php echo Form::text('sname', '', ['class' => 'nav-search-input', 'placeholder' => 'Search ...', 'autocomplete' => 'off']); ?>

					<i class="icon-search nav-search-icon"></i>
				</span>
				<?php echo Form::close(); ?>

			</div> <!-- /.nav-search -->
		</div>
		<div class="page-content">
			<div class="row-fluid">
				<div class="span12">
					<?php if(session('success')): ?>
						<div class="alert alert-success"><?php echo session('success'); ?></div>
					<?php elseif(session('error')): ?>
						<div class="alert alert-danger"><?php echo session('error'); ?></div>
					<?php elseif(session('info')): ?>
						<div class="alert alert-info"><?php echo session('info'); ?></div>
					<?php endif; ?>
					<div class="row-fluid">
						<?php echo $__env->yieldContent('content'); ?>
					</div>
				</div>
			</div>

	<?php echo $__env->make('layout.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</body>
