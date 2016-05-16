<?php
require_once ("ValueTypeHelper.php");

class UrlHelper
{
	public static function GetCurrentURL()
	{	
		return  $PHP_SELF;
	}
	
	public static function GetAttributeValue($attribute)
	{
		return $_REQUEST[$attribute];
	}
	
	public static function GetAttributeOrDefaultValue($attribute, $arrayOfPossibleValues, $defaultValue)
	{
		$attributeFromRequest = UrlHelper::GetAttributeValue($attribute);
		
		if(isset($attributeFromRequest))
		{
			foreach ($arrayOfPossibleValues as $possibleValue)
			{
				if(ValueTypeHelper::AreEqual($possibleValue, $attributeFromRequest))
				{
					return $possibleValue; 
				}
			}	
		}
		
		return $defaultValue;
	}
	
	public static function GetCurrentPageName()
	{
		return $_SERVER['SCRIPT_NAME'];
	}
	
	public static function GetRequest()
	{
		$currentUrl =  ($_SERVER['REQUEST_URI']);
		
		$splittedUrl = explode('?', $currentUrl, 2);
		
		echo ($splittedUrl[1]);
	}
}
?>