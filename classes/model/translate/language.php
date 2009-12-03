<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Translate Language Model
 *
 * @package    Translate
 * @author     Copy112
 * @license    MIT
 */
class Model_Translate_Language extends Sprig {
	
	protected $_sorting = array('name' => 'asc');
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'file' => new Sprig_Field_Char,
			'name' => new Sprig_Field_Char,
			
			'strings' => new Sprig_Field_HasMany(array(
				'model' => 'translate_string',
				'column' => 'language_id',
			)),
		);
	}
}