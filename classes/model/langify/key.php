<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Langify
 * @category   Models
 * @author     Oscar Hinton
 * @copyright  (c) 2011 Oscar Hinton
 * @license    MIT
 */
class Model_Langify_Key extends ORM {

	protected $_has_many = array(
		'key' => array(
			'model'       => 'langify_string',
			'foreign_key' => 'key_id',
		),
	);

	public $_strings = 'langify_strings';

	/**
	 * Load keys and join strings with a specific language.
	 */
	public function find_with_strings($language)
	{
		return DB::select(
			array($this->_table_name.'.id', 'key_id'),
			array($this->_strings.'.id', 'string_id'),
			'key',
			'string'
		)
			->from($this->_table_name)
			->join($this->_strings, 'LEFT')
			->on($this->_table_name.'.id', '=', $this->_strings.'.key_id')
			->on($this->_strings.'.language_id', '=', DB::expr($language))
			->as_object()
			->execute();
	}

}