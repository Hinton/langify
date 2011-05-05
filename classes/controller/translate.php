<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Langify translate controller.
 * Provides a interface for users to modify imported language files.
 *
 * @package    Langify
 * @category   Controllers
 * @author     Oscar Hinton
 * @copyright  (c) 2011 Oscar Hinton
 * @license    MIT
 */
class Controller_Translate extends Controller_Langify_Base {

	public $breadcrumb = array();

	function before()
	{
		parent::before();

		Assets::add('css', 'css/langify.css');
		Assets::add('js', 'js/langify.js');
	}

	function action_index()  {}

	function action_view($lang)
	{
		$language = ORM::factory('langify_language')
			->where('file', '=', $lang)
			->find();

		// Make sure the language is valid!
		if ( ! $language->loaded())
			$this->request->redirect('langify');

		// Send the language id to view.
		$this->view->set('language', $language->id);

		if ($_POST)
		{
			$this->auto_render = FALSE;

			$update = Validation::factory($_POST)
				->rule('id', 'not_empty')
				->rule('id', 'digit');

			// Update string
			if ($update->check())
			{
				$string = ORM::factory('langify_string')
					->where('id', '=', $update['id'])
					->find();

				if ($string->loaded())
				{
					$string->string = $update['string'];
	
					try
					{
						$string->save();
						$this->response->body('1');
					}
					catch (Validate_Exception $e)
					{
						print_r($e->array);
					}
				}
				return;
			}

			$new = Validation::factory($_POST)
				->rule('key_id', 'not_empty')
				->rule('key_id', 'digit');

			// Insert new string
			if ($new->check())
			{
				$key = ORM::factory('langify_key')
					->where('id', '=', $_POST['key_id'])
					->find();
				
				if ($key->loaded())
				{
					// Check if string already exist.
					$string = ORM::factory('langify_string')
						->where('key_id', '=', $new['key_id'])
						->and_where('language_id', '=', $language->id)
						->find();

					// Make sure the string dosnt exist already.
					if ( ! $string->loaded())
					{
						$values = array(
							'key_id' => $new['key_id'],
							'language_id' => $language->id,
							'string' => $new['string'],
						);

						$string = ORM::factory('langify_string')
							->values($values)
							->save();

						$this->response->body('1');
					}
				}
			}
		}
	}

} // End Controller_Translate