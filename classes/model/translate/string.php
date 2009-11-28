<?php defined('SYSPATH') or die('No direct script access.');

class Model_Translate_String extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			'language_id' => new Sprig_Field_BelongsTo(array(
                'model' => 'translate_language',
            )),
			'key_id' => new Sprig_Field_BelongsTo(array(
                'model' => 'translate_key',
            )),
			'string' => new Sprig_Field_Text,
		);
	}
}