<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Translate String Model
 *
 * @package    Translate
 * @author     Copy112
 * @license    MIT
 */
class Model_Translate_String extends Sprig {
	
	protected function _init()
	{
		$this->_fields += array(
			'id' => new Sprig_Field_Auto,
			
			'language_id' => new Sprig_Field_BelongsTo(array(
                'model' => 'translate_language',
            )),
			//'translate_key_id' => new Sprig_Field_Integer,
			'key' => new Sprig_Field_BelongsTo(array(
                'model' => 'translate_key',
            )),
			'string' => new Sprig_Field_Text,
		);
	}
	
	
	
	
}