<?php
class MathHelper
{
	public static function AreEqual($firstValue, $secondValue)
	{
		return $firstValue == $secondValue;		
	}
	
	public static function IsInInclusiveInterval($value, $intervalStart, $intervalEnd)
	{
		return $value >= $intervalStart && $value <= $intervalEnd;
	}
	
	public static function IsInExclusiveInterval($value, $intervalStart, $intervalEnd)
	{
		return $value > $intervalStart && $value < $intervalEnd;		
	}
	
	public static function AreIntervalsIntersecting ($firstIntervalStart, $firstIntervalEnd, $secondIntervalStart, $secondIntervalEnd)
	{
		$intersectionArray = MathHelper::GetIntervalIntersection($firstIntervalStart, $firstIntervalEnd, $secondIntervalStart, $secondIntervalEnd); 
		return !MathHelper::AreEqual(sizeof($intersectionArray), 0); 	
	}
	
	public static function GetIntervalIntersection ($firstIntervalStart, $firstIntervalEnd, $secondIntervalStart, $secondIntervalEnd)
	{
		$intersectionArray = array();

		$start = MathHelper::GetMaximum($firstIntervalStart, $secondIntervalStart);
		$end = MathHelper::GetMinimum($firstIntervalEnd, $secondIntervalEnd);
		
		if($start > $end) { return $intersectionArray;}
		
		for($i = $start;$i <= $end; $i++)
		{
			$intersectionArray[] = $i;			
		}
		
		return $intersectionArray;
	}
	
	public static function GetMinimum($firstValue, $secondValue)
	{
		return $firstValue < $secondValue ? $firstValue
										  : $secondValue;
	}
	
	public static function GetMaximum($firstValue, $secondValue)
	{
		return $firstValue > $secondValue ? $firstValue
										  : $secondValue;
	}	
}
?>