<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Layout base view class
 *
 * @package    Langify
 * @category   Views
 * @author     Oscar Hinton
 * @copyright  (c) 2011 Oscar Hinton
 * @license    MIT
 */
abstract class View_Langify_Admin_Layout extends View_Langify_Layout {
	
	public $sidebar = true;
	
	public $navigation = array(
		array(
			'url'   => '',
			'title' => 'Home',
		),
		/*
		array(
			'url'   => 'language',
			'title' => 'Languages',
		),
		array(
			'url'   => 'key',
			'title' => 'Keys',
		),
		*/
		array(
			'url'   => 'import',
			'title' => 'Import',
		),
		array(
			'url'   => 'export',
			'title' => 'Export',
		),
	);
	
	// Sidebar partial
	protected $_partials = array(
		'sidebar' => 'langify/admin/sidebar',
	);
}
	