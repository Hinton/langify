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
	
	// yes i'm lazy.
	private $version = '0.2';
	
	private $message = NULL;
	
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
	
	function after()
	{
		
		$this->template->set('message', $this->message);
		
		parent::after();
	}
	
	function check_access()
	{
		if (Auth::instance()->logged_in('translate')){
			// The user got the correct role, let him access
		} elseif (Auth::instance()->logged_in()) {
		    die('No access');
		} else {
		    Request::instance()->redirect('translate/admin/login');
		}
	}
	
	function action_index()
	{
		
		$this->check_access();
		
		$this->template->content = View::factory('langify/admin/index');
		
	}
	
	
	function action_login()
	{
		// If user already signed-in
		if( Auth::instance()->logged_in() ){
			Request::instance()->redirect('translate/admin');		
		}
 		
		$content = $this->template->content = View::factory('langify/admin/login');	
 
		// If there is a post and $_POST is not empty
		if ($_POST)
		{
			$user = ORM::factory('user');

			$status = $user->login($_POST);
 
			// If the post data validates using the rules setup in the user model
			if ($status) {		
				// redirect to the user account
				Request::instance()->redirect('translate/admin');
			} else {
                // Get errors for display in view
				$content->errors = $_POST->errors('signin');
			}
 
		}
	}
	
	
	function action_import()
	{
		
		$this->check_access();
		
		$this->template->content = View::factory('langify/admin/import');
		
		if ($_POST) {
			
			$file = security::xss_clean($_POST['file']);
			$keys = FALSE;
			$strings = FALSE;
			if ($_POST['keys']) { 
				$keys = TRUE;
			}
			if ($_POST['strings']) { 
				$strings = TRUE;
			}
			
			$this->import( $file, $keys, $strings );
			
			$this->message = 'Succesfully imported the file!';
		}
	}
	
	function action_export()
	{
		
		$this->check_access();
		
		$this->template->content = View::factory('langify/admin/export')
			->bind('languages', $languages);
			
		$lang = Sprig::factory('translate_language')->load(NULL, NULL);
		
		$languages = array();
		foreach ($lang as $language) {
			$languages[$language->file] = $language->name;
		}
		
		if ($_POST) {
			$file = security::xss_clean( $_POST['file'] );
			$this->export($file);
		}
		
	}

	
	private function import($file = 'en', $import_keys = TRUE, $import_strings = TRUE)
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
		if ($import_strings) {
			
			foreach ($lang as $key => $value)
			{
				
				$key_id = Sprig::factory('translate_key', array( 'key' => $key ))->load();
				
				$strings = Sprig::factory('translate_string', array(
					'language_id' => $language_id->id,
					'key'      => $key_id->id,
					'string'      => $value,
				));
	
				$strings->create();
				
			}
		}
	}
	
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