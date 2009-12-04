<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin Controller
 *
 * @package    Langify
 * @author     Copy112
 * @license    MIT
 */
class Controller_Langify_Admin extends Controller_Template {
	
	public $template = 'langify/admin/template';
	public $user;
	public $protected = TRUE;
	
	// yes i'm lazy.
	private $version = '0.1';
	
	function before()
	{
		
		parent::before();
		
		// Load the accepted language list
		$translations = Kohana::message('langify', 'translations');
		
		$this->template->set('version', $this->version);
		$this->template->set('translations', $translations);
		
		
		/*
		 * Borrowed from userguide
		 */
		if (isset($_GET['lang']))
		{
			$lang = $_GET['lang'];

			if (in_array($lang, array_keys($translations) ))
			{
				// Set the language cookie
				Cookie::set('langify_language', $lang, Date::YEAR);
			}

			// Reload the page
			$this->request->redirect($this->request->uri);
		}

		// Set the translation language
		I18n::$lang = Cookie::get('langify_language', Kohana::config('langify')->lang);
		
	}
	
	function action_index()
	{
		
		$this->template->content = View::factory('langify/index')
			->bind('languages', $languages);
		
		$languages = Sprig::factory('translate_language')->load(NULL, NULL);
		
	}
	
	
	
	
}