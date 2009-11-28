<?php defined('SYSPATH') or die('No direct script access.');

class Model_Translate_Language extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'file' => new Sprig_Field_Char,
			'name' => new Sprig_Field_Char,
		);
	}
}