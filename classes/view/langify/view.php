<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * View string view class
 *
 * @package    Langify
 * @category   Views
 * @author     Oscar Hinton
 * @copyright  (c) 2011 Oscar Hinton
 * @license    MIT
 */
class View_Langify_View extends View_Langify_Layout {

	public $title = 'View';
	public $language = NULL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->breadcrumb[] = array('title' => 'View', 'url' => '');
	}
	
	public function strings()
	{
		$strings = array();

		// Load the langify keys with strings joined.
		$orm = ORM::factory('langify_key')
			->find_with_strings($this->language);

		foreach ($orm as $string)
		{
			$strings[] = array(
				'id'     => $string->string_id,
				'key_id' => $string->key_id,
				'key'    => $string->key,
				'string' => $string->string,
			);
		}
		return $strings;
	}

}