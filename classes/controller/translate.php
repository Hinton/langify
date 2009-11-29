<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Translate Controller
 *
 * @package    Translate
 * @author     Copy112
 */
class Controller_Translate extends Controller_Template {
	
	public $template = 'translate/template';
	
	
	function action_index()
	{
		
		
		$languages = Sprig::factory('translate_language')->load(NULL, NULL);
		
		$this->template->content = View::factory('translate/index')
			->set('languages', $languages);
		
		
		// Uncomment this line if you want to import a language file.
		// $this->import('en', FALSE);
		
	}
	
	function action_view($lang)
	{
		
		$language = Sprig::factory('translate_language')->load();
		
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
	private function export()
	{
		
	}
	
}