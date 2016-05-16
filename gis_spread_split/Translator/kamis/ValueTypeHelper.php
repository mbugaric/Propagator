<?php
class ValueTypeHelper
{
	public static function AreEqual($firstValue, $secondValue)
	{
		if (is_string($firstValue) && is_string($secondValue))
		{
			return strcmp($firstValue, $secondValue) == 0;
		}
		elseif (is_numeric($firstValue) && is_numeric($secondValue))
		{
			return $firstValue == $secondValue;
		}
		else
		{
			return false;
		}
	}

	public static function Contains($mainString, $stringToSearch)
	{
		if (strpos($mainString, $stringToSearch) === false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public static function ArrayContains ($array, $itemToSearch)
	{
		foreach($array as $item)
		{
			if(ValueTypeHelper::AreEqual($item, $itemToSearch))
			{
				return true;				
			}
		}		
		
		return false;
	}
	
	public static function GetSubArray ($sourceArray, $startIndex, $endIndex)
	{
		if(!is_array($sourceArray) || !is_int($startIndex) || $startIndex < 0 
		|| !is_int($endIndex) || $endIndex > count($sourceArray))
		{
			return;	
		}
		
		$subarray = array();
		
		for($i = $startIndex; $i < $endIndex; $i+=1 )
		{
			$subarray[] = $sourceArray[$i];
		}
		
		return $subarray;
	}
	
	public static function StartsWith($mainString, $value)
	{
		$index = strpos($mainString, $value, 0);
			
		if($index === false){ return false;}
		
		if($index === 0) {return true;}
		
		return false;
	}
}
?>