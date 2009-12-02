<!DOCTYPE html>
<html>
<head>
	<title>Translate Module - <?php echo $title; ?></title>
	
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
			<li><?php echo html::anchor('translate', 'Translate'); ?></li>
			
			<?php foreach ( $breadcrumb as $item ): ?>
			
			<li><?php echo html::anchor($item['url'], $item['text']); ?></li>
			
			<?php endforeach; ?>
			
		</ul>
	</div>
</div>

<div class="wrapper">
	
	<h1>Translate <?php echo $title; ?></h1>
	
	<?php echo $content; ?>
	
	<a href="http://copy112.com/translate" class="powerdby">Powerd by Translate Alpha 1</a>

</div>

</body>
</html>