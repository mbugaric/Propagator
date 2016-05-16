<?php
require_once ("kamis/UrlHelper.php");

require_once ("constants/Constants.php");

class Current
{
	public static function GetUiLanguage()
	{
		if(!Current::$_IS_INITIALIZED){ Current::_Initialize(); }
		
		return Current::$_UI_LANGUAGE;
	}
	
	public static function GetPageSize()
	{
		if(!Current::$_IS_INITIALIZED){ Current::_Initialize(); }
		
		return Current::$_PAGE_SIZE;		
	}

	public static function GetPageNumber()
	{
		if(!Current::$_IS_INITIALIZED){ Current::_Initialize(); }
		
		return Current::$_PAGE_NUMBER;		
	}
	
	public static function GetSourceLanguage()
	{
		if(!Current::$_IS_INITIALIZED){ Current::_Initialize(); }
		
		return Current::$_SOURCE_LANGUAGE;		
	}
	
	public static function GetDestinationLanguage()
	{
		if(!Current::$_IS_INITIALIZED){ Current::_Initialize(); }
		
		return Current::$_DESTINATION_LANGUAGE;		
	}
	
	public static function GetCurrentStateQuery()
	{
		if(!Current::$_IS_INITIALIZED){ Current::_Initialize(); }
		
		return Constants::REQUEST_SOURCE_LANGUAGE .    '=' . Current::$_SOURCE_LANGUAGE .'&'
			  .Constants::REQUEST_DESINATION_LANGUAGE. '=' . Current::$_DESTINATION_LANGUAGE.'&'
			  .Constants::REQUEST_PAGE_NUMBER .        '=' . Current::$_PAGE_NUMBER. '&' 
			  .Constants::REQUEST_PAGE_SIZE .          '=' . Current::$_PAGE_SIZE;
	}
	
	private static function _Initialize()
	{
		Current::$_UI_LANGUAGE = UrlHelper::GetAttributeOrDefaultValue
		(
			Constants::REQUEST_UI_LANGUAGE,
			Constants::$SUPPORTED_UI_LANGUAGES,
			Constants::DEFAULT_UI_LANGUAGE
		);
		
		Current::$_SOURCE_LANGUAGE = UrlHelper::GetAttributeOrDefaultValue
		(
			Constants::REQUEST_SOURCE_LANGUAGE,
			Constants::$SUPPORTED_SOURCE_LANGUAGES,
			Constants::DEFAULT_SOURCE_LANGUAGE
		);

		Current::$_DESTINATION_LANGUAGE = UrlHelper::GetAttributeOrDefaultValue
		(
			Constants::REQUEST_DESINATION_LANGUAGE,
			Constants::$SUPPORTED_DESTINATION_LANGUAGES,
			Constants::DEFAULT_DESTINATION_LANGUAGE
		);
				
		Current::$_PAGE_SIZE = UrlHelper::GetAttributeOrDefaultValue
		(
			Constants::REQUEST_PAGE_SIZE,
			Constants::$SUPPORTED_PAGE_SIZE,
			Constants::DEFAULT_PAGE_SIZE
		);	
		
		
		Current::$_PAGE_NUMBER = UrlHelper::GetAttributeValue(Constants::REQUEST_PAGE_NUMBER);
		if(!isset(Current::$_PAGE_NUMBER)) 
		{
			Current::$_PAGE_NUMBER = 1;
		}
		
		Current::$_IS_INITIALIZED = true;
	}
	
	private static $_UI_LANGUAGE;
	private static $_PAGE_SIZE;
	private static $_PAGE_NUMBER;
	private static $_SOURCE_LANGUAGE;
	private static $_DESTINATION_LANGUAGE;
	
	private static $_IS_INITIALIZED = false;
}