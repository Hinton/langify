<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Base controller for Langify.
 *
 * @package    Langify
 * @category   Controllers
 * @author     Oscar Hinton
 * @copyright  (c) 2011 Oscar Hinton
 * @license    MIT
 */
abstract class Controller_Langify_Base extends Controller {

	public $auto_render = TRUE;
	public $version = '0.5';
	
	public $view_prefix = 'View_Langify_';

	public function before()
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
		$view_name = $this->view_prefix.Request::current()->action();
		if (Kohana::find_file('classes', strtolower(str_replace('_', '/', $view_name))))
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

} // End Controller_Langify_Base	