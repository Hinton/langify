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
class View_Langify_Index extends View_Langify_Layout {

	public $title = 'Index';
	
	public function languages()
	{
		$languages = array();
		$orm = ORM::factory('langify_language')
			->find_all();

		foreach ($orm as $language)
		{
			$languages[] = array(
				'file' => $language->file,
				'name' => $language->name,
			);
		}
		return $languages;
	}

}