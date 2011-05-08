<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin Controller
 *
 * @package    Langify
 * @category   Controllers
 * @author     Oscar Hinton
 * @copyright  (c) 2011 Oscar Hinton
 * @license    MIT
 */
class Controller_Langify_Admin extends Controller_Langify_Base {
	
	public $view_prefix = 'View_Langify_Admin_';
	
	public $user;
	
	public $message = NULL;
	
	function before()
	{
		parent::before();
		
		if ($this->request->action() !== 'login')
		{
			//$this->check_access();
		}
		
		Assets::add('css', 'css/langify.css');
		Assets::add('js', 'js/langify.js');
	}

	function check_access()
	{
		if (Auth::instance()->logged_in('translate'))
		{
			// The user got the correct role, let him access
		}
		elseif (Auth::instance()->logged_in())
		{
			throw new HTTP_Exception_403('Access denied!');
		}
		else
		{
		    $this->request->redirect('translate/admin/login');
		}
	}
	
	function action_index() {}
	
	
	function action_login()
	{
		// If user already signed-in
		if( Auth::instance()->logged_in() ){
			$this->request->redirect('translate/admin');		
		}

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
		// Grab a list of files that can be imported.
		$files = array();
		$view_files = array();
		foreach (Kohana::list_files('i18n') as $k => $v)
		{
			$files[] = $k;
			$view_files[] = array('key' => $k);
		}
		$this->view->set('files', $view_files);
		
		$post = Validation::factory($_POST)
			->rule('file', 'not_empty')
			->rule('file', 'in_array', array(':value', $files));
		
		if ($post->check())
		{
			// Remove unnesesary junk from the file name.
			$file = $post['file'];
			$file = str_replace(array('i18n\\', 'i18n/', '.php'), '', $file);
			
			$this->import($file, isset($post['keys']), isset($post['strings']));
		}
	}
	
	function action_export()
	{
		/*
		$lang = Sprig::factory('translate_language')->load(NULL, NULL);
		
		$languages = array();
		foreach ($lang as $language) {
			$languages[$language->file] = $language->name;
		}
		
		if ($_POST) {
			$file = security::xss_clean( $_POST['file'] );
			$this->export($file);
		}
		*/
	}

	
	private function import($file = 'en', $import_keys = TRUE, $import_strings = TRUE)
	{
		// Retrive the id of the wanted language
		$language = ORM::factory('langify_language')
			->where('file' ,'=', $file)
			->find();
		
		if ( ! $language->loaded())
		{
			// Language was not found, we should redirect the user to create a language.
			return false;
		}
		
		// Load the translation file
		$i18n = I18n::load($file);
		
		foreach ($i18n as $k => $v)
		{
			$key = ORM::factory('langify_key')
				->where('key', '=', $k)
				->find();
			
			if ($import_keys === TRUE)
			{
				if ( ! $key->loaded())
				{
					$key = ORM::factory('langify_key');
					$key->key = $k;
					
					$key->save();
				}
			}
			
			if ($import_strings)
			{
				if ( ! $key->loaded())
				{
					// This isnt supposed to happen, lets just ignore it.
					continue;
				}
				
				$string = ORM::factory('langify_string')
					->where('language_id', '=', $language->id)
					->and_where('key_id', '=', $key->id)
					->find();
				
				if ( ! $string->loaded())
				{
					$string = ORM::factory('langify_string');
					$string->language_id = $language->id;
					$string->key_id = $key->id;
					$string->string = $v;
					
					$string->save();
				}
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