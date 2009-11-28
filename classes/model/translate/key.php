<?php defined('SYSPATH') or die('No direct script access.');

class Model_Translate_Key extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'key' => new Sprig_Field_Text,
		);
	}
}