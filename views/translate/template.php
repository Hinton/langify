<!DOCTYPE html>
<html>
<head>
	<title>Translate Module - <?php echo $title; ?></title>
	
	<?php
		echo html::style('tmedia/css/main.css');
		//echo html::script($script);
	?>
</head>
<body>

<div id="header">
	<div class="wrapper">
		<ul class="breadcrumb">
			<li><a href="/translate">Translate</a></li>
		</ul>
	</div>
</div>

<div class="wrapper">
	
	<h1>Translate <?php echo $title; ?></h1>
	
	<?php echo $content; ?>

</div>

</body>
</html>