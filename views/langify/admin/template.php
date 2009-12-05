<!DOCTYPE html>
<html>
<head>
	<title><?php echo i18n::get('langify admin'); ?></title>
	
	<script type="text/javascript">
		path = "<?php echo url::base(); ?>";
	</script>
	
	<?php
		echo html::style('tmedia/css/admin.css');
		
		echo html::script('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
		echo html::script('tmedia/js/main.js');
	?>
</head>
<body>

<div id="header">
	<div class="wrapper">
		<ul class="breadcrumb">
			<li><?php echo html::anchor('translate', i18n::get('langify')); ?></li>

		</ul>
		<div class="language_select">
			<?php 
				echo form::open(NULL, array('method' => 'get'));
					echo form::select('lang', $translations, I18n::$lang);
				echo form::close();
			?>
		</div>
	</div>
</div>

<div class="wrapper">
	
	<h1><?php echo i18n::get('langify admin'); ?></h1>
	
	<div class="nav">
		<ul>
			<li><?php echo html::anchor('translate/admin', 'Home'); ?></li>
			<li><?php echo html::anchor('translate/admin/language', 'Languages'); ?></li>
			<li><?php echo html::anchor('translate/admin/key', 'Keys'); ?></li>
			<li><?php echo html::anchor('translate/admin/import', 'Import'); ?></li>
			<li><?php echo html::anchor('translate/admin/export', 'Export'); ?></li>
		</ul>
	</div>
	
	<div class="content">
		<?php if ( isset($message) ): ?>
			<p class="message">
				<?php echo $message; ?>
			</p>
		<?php endif ?>
		<?php echo $content; ?>
	</div>
	
	<a href="http://copy112.com/kohana" class="powerdby"><?php echo i18n::get('powered by langify').' '.$version; ?></a>

</div>

</body>
</html>