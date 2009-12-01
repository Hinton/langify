<?php

Route::set('translate', 'translate(/<action>(/<language>(/<id>)))')
	->defaults(array(
		'controller' => 'translate',
		'action'     => 'index',
	));
