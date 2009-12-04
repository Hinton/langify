<h3>Import</h3>

<p>To import, enter the file name of your i18n file, make sure you have uploaded it.</p>

<?php
	echo form::open();
	
	echo form::label('file', 'File:');
	echo form::input('file');
	
	echo form::submit('Import', 'Import', array('class' => 'submit'));
?>
	
