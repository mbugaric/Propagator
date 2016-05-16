<?php
class PagingHelper
{
	/**
	 * @param $numberOfItems - int
	 * @param $numberOfItemsPerPage - int
	 * @return $totalPageNumber - int
	 */
	public static function CalculateTotalPageNumber($numberOfItems, $numberOfItemsPerPage)
	{
		$totalPageNumber = (int) ($numberOfItems/$numberOfItemsPerPage);
		
		if($numberOfItems % $numberOfItemsPerPage !== 0)
		{
			$totalPageNumber += 1;	
		}
		
		return $totalPageNumber;
	}
	
	/**
	 * @param $pageNumber - int
	 * @param $pageSize - int
	 * @return startIndex - int
	 */
	public static function CalculateStartIndex ($pageNumber, $pageSize)
	{
		return ($pageNumber - 1)  * $pageSize;
	}
	
	/**
	 * @param $pageNumber - int 
	 * @param $pageSize - int
	 * @param $totalItemCount - int
	 * @return endIndex - int
	 */
	public static function CalculateEndIndex ($pageNumber, $pageSize, $totalItemCount)
	{
		$endIndex = PagingHelper::CalculateStartIndex($pageNumber, $pageSize) + $pageSize;
		
	 	if ($endIndex > $totalItemCount) { $endIndex = $totalItemCount; }
		
	 	return $endIndex;
	}
}