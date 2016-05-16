<?php
require_once ("kamis/ValueTypeHelper.php");
require_once ("constants/Constants.php");

class Dictionary
{	
	public static function GetSourceLanguageCaption($language)
	{
		if(Dictionary::_LanguageExsists(Dictionary::$SOURCE_LANGUAGE_CAPTION_DICTIONARY, $language))
		{
			return Dictionary::$SOURCE_LANGUAGE_CAPTION_DICTIONARY[$language];
		}
		else
		{
			return Dictionary::$SOURCE_LANGUAGE_CAPTION_DICTIONARY[Constants::DEFAULT_UI_LANGUAGE];
		}	
	}
	
	public static function GetDestinationLanguageCaption($language)
	{
		if(Dictionary::_LanguageExsists(Dictionary::$DESTINATION_LANGUAGE_CAPTION_DICTIONARY, $language))
		{
			return Dictionary::$DESTINATION_LANGUAGE_CAPTION_DICTIONARY[$language];
		}
		else
		{
			return Dictionary::$DESTINATION_LANGUAGE_CAPTION_DICTIONARY[Constants::DEFAULT_UI_LANGUAGE];
		}	
	}
	
	public static function GetPageSizeCaption($language)
	{
		if(Dictionary::_LanguageExsists(Dictionary::$PAGE_SIZE_CAPTION_DICTIONARY, $language))
		{
			return Dictionary::$PAGE_SIZE_CAPTION_DICTIONARY[$language];
		}
		else
		{
			return Dictionary::$PAGE_SIZE_CAPTION_DICTIONARY[Constants::DEFAULT_UI_LANGUAGE];
		}	
	}
	
	public static function GetButtonSaveCaption($language)
	{
		if(Dictionary::_LanguageExsists(Dictionary::$BUTTON_SAVE_CAPTION_DICTIONARY, $language))
		{
			return Dictionary::$BUTTON_SAVE_CAPTION_DICTIONARY[$language];
		}
		else
		{
			return Dictionary::$BUTTON_SAVE_CAPTION_DICTIONARY[Constants::DEFAULT_UI_LANGUAGE];
		}	
	}
	
	public static $SOURCE_LANGUAGE_CAPTION_DICTIONARY = array (
		'HRV' => 'Odaberi izvorni jezik',
		'ENG' => 'Select source language',
		'GER' => 'Wahlen Sie die Ausgangssprache',
		'GRE' => 'Επιλέξτε γλώσσα'
	);
	
	public static $DESTINATION_LANGUAGE_CAPTION_DICTIONARY = array (
		'HRV' => 'Odaberi odredišni jezik',
		'ENG' => 'Select destination language',
		'GER' => 'Wahlen Sie die Sprache',
		'GRE' => 'Επιλέξτε προορισμό γλώσσα'	
	);
	
	public static $PAGE_SIZE_CAPTION_DICTIONARY = array (
		'HRV' => 'Stavki po stranici',
		'ENG' => 'Items per page',
		'GER' => 'Artikel pro Seite',
		'GRE' => 'Στοιχεία ανά σελίδα'
	);
	
	public static $BUTTON_SAVE_CAPTION_DICTIONARY = array (
		'HRV' => 'Spremi',
		'ENG' => 'Save',
		'GER' => 'Sichern',
		'GRE' => 'Αποθηκεύω'
	);
	
	private static function _LanguageExsists($dictionary, $language)
	{
		foreach($dictionary as $dictionaryKey => $dictionaryValue)
		{
			if(ValueTypeHelper::AreEqual($language,$dictionaryKey))
			{
				return true;
			}	
		}
		
		return false;
	}
}
