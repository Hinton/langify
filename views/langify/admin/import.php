<h3>Import</h3>

<p>To import, enter the file name of your i18n file, make sure you have uploaded it.</p>

<?php
	echo form::open();
	
	echo form::label('file', 'File:');
	echo form::input('file');
	
	echo '<br />';
	
	echo form::label('keys', 'Import keys');
	echo form::checkbox('keys', '1', TRUE);
	
	echo '<br />';
	
	echo form::label('strings', 'Import strings');
	echo form::checkbox('strings', '1');
	
	echo '<br /><br />';
	
	echo form::submit('Import', 'Import', array('class' => 'submit'));
?>
	
