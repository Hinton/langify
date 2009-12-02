<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Translate Controller
 *
 * @package    Translate
 * @author     Copy112
 * @license    MIT
 */
class Controller_Translate extends Controller_Template {
	
	public $template = 'translate/template';
	
	public $title = 'Undefined';
	public $breadcrumb = array();
	
	function before()
	{
		parent::before();
		
		$this->template->bind('title', $this->title);
		$this->template->bind('breadcrumb', $this->breadcrumb);
		
	}
	
	
	function action_index()
	{
		
		$this->title = 'Index';
		$this->template->content = View::factory('translate/index')
			->bind('languages', $languages);
		
		$languages = Sprig::factory('translate_language')->load(NULL, NULL);
		
	}
	
	
	function action_view($lang, $id = FALSE)
	{
		
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
				// print_r( $e->array );
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
		
		// Debug
		// print_r($_POST);
		
		$this->title = 'View';
		$this->template->content = View::factory('translate/view')
			->bind('language', $language)
			->bind('strings', $string_return)
			->bind('keys', $keys)
			->bind('english', $english);
		
		// Load the language and strings from the database
		$strings  = Sprig::factory('translate_string', array('language_id' => $language->id))->load(NULL, NULL);
		$keys     = Sprig::factory('translate_key')->load(NULL, NULL);
		$eng      = Sprig::factory('translate_string', array('language_id' => 1))->load(NULL, NULL);
		
		$english = array();
		
		foreach ( $eng as $engl ) {
			$english[$engl->key->id] = $engl->string;
		}
		
		
		
		$string_return = array();
		
		// Assign all language strings to an array with the key_id as key.
		foreach ($strings as $string)
		{
			$string_return[$string->key->id] = array( 
				'string' => $string->string,
				'id' => $string->id,
			);
		}
		
	}
	
	function action_import($password = '', $lang = null)
	{
		if ($password != Kohana::config('translate.password')) {
			die('Wrong Login info');
		}
		
		if (!$lang) {
			die('You need to enter a language in the url to, after the password');
		}
		
		$this->import($lang);
	}
	
	function action_export($password = '', $lang = null)
	{
		if ($password != Kohana::config('translate.password')) {
			die('Wrong Login info');
		}
		
		if (!$lang) {
			die('You need to enter a language in the url to, after the password');
		}
		
		$this->export($lang);
		
	}
	
	/**
	 * Imports a language file into the db to allow translations
	 * @return 
	 */
	private function import($file = 'en', $import_keys = TRUE)
	{
		
		// Retrive the id of the wanted language
		$language_id = Sprig::factory('translate_language', array('file' => $file))->load();
		
		// Load the translation file
		$lang = I18n::load($file);
		
		// Import the key's into the key table
		if ($import_keys) {
			
			foreach ($lang as $key => $value)
			{
				
				$keys = Sprig::factory('translate_key', array(
					'key' => $key,
				));
				
				$keys->create();
				
			}
			
		}
		
		// Import the lang strings into string table
		foreach ($lang as $key => $value)
		{
			
			$key_id = Sprig::factory('translate_key', array( 'key' => $key ))->load();
			
			$strings = Sprig::factory('translate_string', array(
				'language_id' => $language_id->id,
				'key_id'      => $key_id->id,
				'string'      => $value,
			));

			$strings->create();
			
		}	
		
	}
	
	/**
	 * Perse strings for a language into a download able language file
	 * @return 
	 */
	private function export($lang)
	{
		$this->auto_render = false;
		
		$language = Sprig::factory('translate_language', array('file' => $lang))->load();
		$strings  = Sprig::factory('translate_string', array('language_id' => $language->id))->load(NULL, NULL);
		$keys     = Sprig::factory('translate_key')->load(NULL, NULL);
		
		$string_return = array();
		
		// Assign all language strings to an array with the key_id as key.
		foreach ($strings as $string)
		{
			$string_return[$string->key->key] = $string->string;
		}
		
		
		header('Content-disposition: attachment; filename='.$lang.'.php');
		header('Content-type: text/html');
		
		$output  = "<?php defined('SYSPATH') or die('No direct script access.');\n";
		$output .= "\n";
		$output .= "return array (\n";
		
		foreach ( $string_return as $key => $value )
		{
			$output .= "\t'".$key."' => '".$value."',\n";
		}
		
		
		$output .= ");";
		
		echo $output;
		
	}
	
}