<?php
/**
 * Translate init.php
 *
 * @package    Translate
 * @author     Copy112
 * @license    MIT
 */
Route::set('translate', 'translate(/<action>(/<language>(/<id>)))')
	->defaults(array(
		'controller' => 'translate',
		'action'     => 'index',
	));
