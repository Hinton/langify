<p><?php echo i18n::get('langify index decscription'); ?></p>

<ul class="languages">
<?php foreach($languages as $language): ?>
	<li><?php echo html::anchor('translate/view/'.$language->file, $language->name); ?></li>
<?php endforeach ?>
</ul>
