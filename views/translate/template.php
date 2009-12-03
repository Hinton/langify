<!DOCTYPE html>
<html>
<head>
	<title><?php echo i18n::get('langify'); ?> - <?php echo i18n::get($title); ?></title>
	
	<script type="text/javascript">
		path = "<?php echo url::base(); ?>";
	</script>
	
	<?php
		echo html::style('tmedia/css/main.css');
		
		echo html::script('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
		echo html::script('tmedia/js/main.js');
	?>
</head>
<body>

<div id="header">
	<div class="wrapper">
		<ul class="breadcrumb">
			<li><?php echo html::anchor('translate', i18n::get('langify')); ?></li>
			
			<?php foreach ( $breadcrumb as $item ): ?>
				<li><?php echo html::anchor($item['url'], $item['text']); ?></li>
			<?php endforeach; ?>
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
	
	<h1><?php echo i18n::get('langify'); ?> <?php echo i18n::get($title); ?></h1>
	
	<?php echo $content; ?>
	
	<a href="http://copy112.com/kohana" class="powerdby"><?php echo i18n::get('powered by langify').' '.$version; ?></a>

</div>

</body>
</html>