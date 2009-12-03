<p><?php echo i18n::get('langify index decscription'); ?></p>

<?php foreach($languages as $language): ?>

<?php echo html::anchor('translate/view/'.$language->file, $language->name); ?><br />

<?php endforeach ?>