<?php $__env->startSection('content'); ?>
<div class="page-header">
	<h1>
		404 Not found
	</h1>
</div>
<p>The page you were looking for cannot be found.<br>
Pagina nu a fost gasita.</p>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', ['title' => 'Page not found'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>