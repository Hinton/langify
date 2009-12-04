<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Translate Controller
 *
 * @package    Langify
 * @author     Copy112
 * @license    MIT
 */
class Controller_Translate extends Controller_Template {
	
	public $template = 'langify/template';
	
	public $title = '';
	public $breadcrumb = array();
	
	// yes i'm lazy.
	private $version = '0.2';
	
	function before()
	{
		parent::before();
		
		// Load the accepted language list
		$translations = Kohana::message('langify', 'translations');
		
		$this->template->bind('title', $this->title);
		$this->template->bind('breadcrumb', $this->breadcrumb);
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
	
	
	function action_view($lang = FALSE)
	{
		
		if (!$lang) {
			Request::instance()->redirect('translate');
		}
		
		$lang = security::xss_clean($lang);
		$language = Sprig::factory('translate_language', array('file' => $lang))->load();
		
		$this->breadcrumb[] = array(
			'url' => 'translate/view/'.$lang,
			'text' => $language->name,
		);
		
		// Check if someone submited a form
		if ( isset ( $_POST['id'] ) ) {
			
			$post = Sprig::factory('translate_string', array('id' => security::xss_clean($_POST['id']) ))
				->load();
			
			$post->values( array(
				'string' => security::xss_clean($_POST['string']),
			));
			
			try
			{
				$post->update();
			}
			catch (Validate_Exception $e)
			{
				print_r( $e->array );
			}
			
		} elseif ( isset ( $_POST['string'] ) ) {
			
			$post = Sprig::factory('translate_string', array(
				'language_id'      => $language->id,
				'key'              => security::xss_clean( $_POST['key_id'] ),
				'string'           => security::xss_clean( $_POST['string'] ),
			));
			
			try
			{
				$post->create();
			}
			catch (Validate_Exception $e)
			{
				print_r( $e->array->errors('blog/post') );
			}
			
		}
		
		// Ajax is used to submit data, so we don't need to display anything, or recive stuff from the db.
		if (Request::$is_ajax) {
			die();
		}
		
		// Debug
		// print_r($_POST);
		
		$this->title = 'view';
		$this->template->content = View::factory('langify/view')
			->bind('language', $language)
			->bind('strings', $string_return)
			->bind('keys', $keys)
			->bind('english', $english);
		
		// Load the language and strings from the database
		$strings  = Sprig::factory('translate_string', array('language_id' => $language->id))->load(NULL, NULL);
		$keys     = Sprig::factory('translate_key')->load(NULL, NULL);
		$eng      = Sprig::factory('translate_string', array('language_id' => 1))->load(NULL, NULL);
		
		// Insert the english strings into an array.
		$english = array();
		foreach ( $eng as $engl ) {
			$english[$engl->key->id] = $engl->string;
		}
		
		// Insert the requested language into an array.
		$string_return = array();
		foreach ($strings as $string)
		{
			$string_return[$string->key->id] = array( 
				'string' => $string->string,
				'id' => $string->id,
			);
		}
		
	}

	
}