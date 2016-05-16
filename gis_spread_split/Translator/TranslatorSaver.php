<?php
session_start();
include_once("../db_functions.php");
include_once("../postavke_dir_gis.php");

require_once ("kamis/UrlHelper.php");
require_once ("kamis/DataAccess/FileAccess.php");
require_once ("code/DataAccess.php");
require_once ("code/Translations/TranslationItem/TranslationItem.php");

require_once ("constants/Constants.php");


class TranslatorSaver
{
	
	
	const TRANSLATION_ITEM_DELIMITER = ';;';
	const INDEX_CONTENT_DELIMITER = '__';
	const DESTINATION_LANGUAGE_QUERY_CONSTANT = "destinationLanguage";
	const ITEMS_TO_SAVE_QUERY_CONSTANT = "ItemsToSave";
	
	public static function Save()
	{
		
		$translationItems = TranslatorSaver::_GetSentTranslationItems();
		$destinationLanguage = TranslatorSaver::_GetSentDestinationLanguage();
			
		
		if(isset($translationItems) && isset($destinationLanguage))
		{
		
			$pathToFile = Constants::GetLanguagePath($destinationLanguage);

			
			if(FileAccess::FileExsists($pathToFile))
			{
				DataAccess::SaveTranslations($pathToFile, $translationItems);
			}
		}
	}
	
	private static function _GetSentDestinationLanguage()
	{
		return UrlHelper::GetAttributeValue(TranslatorSaver::DESTINATION_LANGUAGE_QUERY_CONSTANT);
	}
	
	//Assumes that requestString is in the following format:
	//?destinationLanguage=xxx&ItemsToSave=...
	private static function _GetSentTranslationItems()
	{		
		$sentItemsQuery = UrlHelper::GetAttributeValue(TranslatorSaver::ITEMS_TO_SAVE_QUERY_CONSTANT);
		
		$sentItems = explode(TranslatorSaver::TRANSLATION_ITEM_DELIMITER, $sentItemsQuery);
		$translationItems = array();
		
		foreach($sentItems as $sentItem)
		{
			$translationItemInfo = explode(TranslatorSaver::INDEX_CONTENT_DELIMITER, $sentItem);
			$translationItems[] = new TranslationItem($translationItemInfo[1],$translationItemInfo[2], str_replace("\n", " ", $translationItemInfo[0]),'');
		}
		
		return $translationItems;
	}
}


TranslatorSaver::Save();
