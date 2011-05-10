<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Index view class
 *
 * @package    Langify
 * @category   Views
 * @author     Oscar Hinton
 * @copyright  (c) 2011 Oscar Hinton
 * @license    MIT
 */
class View_Langify_Admin_Export extends View_Langify_Admin_Layout {

	public $title = 'Export';
	
	public $languages;
	
	/**
	 * Format the ORM object to array for template.
	 */
	public function languages()
	{
		$languages = ORM::factory('langify_language')
			->find_all();
		
		$return = array();
		foreach ($languages as $k => $v)
		{
			$return[] = array(
				'id' => $v->id,
				'name' => $v->name,
			);
		}
		return $return;
	}

}