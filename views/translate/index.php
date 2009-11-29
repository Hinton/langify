<p>To get started select the language you would like to translate from below.</p>

<?php foreach($languages as $language): ?>
	
<?php echo html::anchor('translate/view/'.$language->file, $language->name); ?><br />

<?php endforeach ?>