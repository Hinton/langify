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
class Controller_Translate extends Controller {

	public $template = 'langify/template';
	public $auto_render = TRUE;

	public $title = '';
	public $breadcrumb = array();

	// yes i'm lazy.
	private $version = '0.5';

	function before()
	{
		parent::before();

		// Borrowed from userguide
		if (isset($_GET['lang']))
		{
			$lang = $_GET['lang'];

			// Make sure the translations is valid
			$translations = Kohana::message('langify', 'translations');
			if (in_array($lang, array_keys($translations)))
			{
				// Set the language cookie
				Cookie::set('langify_language', $lang, Date::YEAR);
			}

			// Reload the page
			$this->request->redirect($this->request->uri());
		}

		// Set the translation language
		I18n::$lang = Cookie::get('langify_language', Kohana::config('langify')->lang);

		// Borrowed from Vendo
		// Automaticly load a view class based on action.
		$view_name = 'View_Langify_'.Request::current()->action();
		if(Kohana::find_file('classes', strtolower(str_replace('_', '/', $view_name))))
		{
			$this->view = new $view_name;
			$this->view->set('version', $this->version);
		}
	}

	public function after()
	{
		parent::after();

		if ($this->auto_render === TRUE)
		{
			$this->response->body($this->view->render());
		}
	}

	function action_index()
	{

	}

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
}