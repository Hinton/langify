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
abstract class View_Langify_Layout extends Kostache_Layout {

	protected $_layout = 'langify/layout';

	public $title = 'Undefined';

	/**
	 * Grab all the translations avaible
	 */
	public function translations()
	{
		$translations = array();
		foreach (Kohana::message('langify', 'translations') as $key => $value)
		{
			$selected = FALSE;
			if (I18n::$lang === $key)
				$selected = TRUE;
			
			$translations[] = array(
				'value'    => $key,
				'name'     => $value,
				'selected' => $selected,
			);
		}
		return $translations;
	}

	public function base()
	{
		return URL::base(FALSE, TRUE);
	}

}