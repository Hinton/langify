<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Langify
 * @category   Models
 * @author     Oscar Hinton
 * @copyright  (c) 2011 Oscar Hinton
 * @license    MIT
 */
class Model_Langify_String extends ORM {

	protected $_belongs_to = array(
		'key' => array(
			'model'       => 'langify_key',
			'foreign_key' => 'key_id',
		),
	);

	protected $_load_width = array('key');

}