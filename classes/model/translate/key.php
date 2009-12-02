<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Translate Key Model
 *
 * @package    Translate
 * @author     Copy112
 * @license    MIT
 */
class Model_Translate_Key extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'key' => new Sprig_Field_Text,
		);
	}
}