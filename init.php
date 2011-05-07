<?php defined('SYSPATH') or die('No direct script access.');
/**
 * init.php
 *
 * @package    Langify
 * @author     Oscar Hinton
 * @copyright  (c) 2011 Oscar Hinton
 * @license    MIT
 */
Route::set('translate/admin', 'translate/admin(/<action>(/<language>(/<id>)))')
	->defaults(array(
		'directory'  => 'langify',
		'controller' => 'admin',
		'action'     => 'index',
	));

Route::set('translate', 'translate(/<action>(/<language>(/<id>)))')
	->defaults(array(
		'directory'  => 'langify',
		'controller' => 'translate',
		'action'     => 'index',
	));
