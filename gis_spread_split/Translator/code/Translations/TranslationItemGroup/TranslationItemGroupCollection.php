<?php
require_once ("kamis/Math/MathHelper.php");

class TranslationItemGroupCollection
{
	/**
	 * @param $translationItemGroupArray - array of TranslationItemGroups
	 * @return void
	 */
	public function TranslationItemGroupCollection($translationItemGroupArray)
	{
		if(isset($translationItemGroupArray) && is_array($translationItemGroupArray))
		{
			$this->_translationItemGroupArray = $translationItemGroupArray;
		}
		else
		{
			$this->_translationItemGroupArray = array();
			echo ("<br>Invalid input parameter<br>");
		}	
	}
	
	/**
	 * @param $translationItemGroup
	 * @return void
	 */
	public function AddTranslationItemGroup($translationItemGroup)
	{
		$this->_translationItemGroupArray[] = $translationItemGroup;
	}
	
	/**
	 * Get TranslationItems starting with $startIndex and ending with $endIndex
	 * organized into translationGroups
	 * @param $startIndex - int
	 * @param $endIndex - int
	 * @return array of TranslationItemGroup
	 */
	public function GetTranslationItemGroups($startIndex, $endIndex)
	{
		$groups = array();
		
		foreach($this->_translationItemGroupArray as $translationGroup)
		{
			if(MathHelper::AreIntervalsIntersecting
			  (
					$translationGroup->GetFirstItemIndex(),
					$translationGroup->GetLastItemIndex(),
					$startIndex,
					$endIndex
			  ))
			{
				$groupItems = $translationGroup->GetItems();
				$groupItemsToSelect = array();

				foreach($groupItems as $groupItem)
				{
					if(MathHelper::IsInInclusiveInterval($groupItem->GetIndex(), $startIndex, $endIndex))
					{
						$groupItemsToSelect[] = $groupItem; 
					}
				}
				
				if(sizeof($groupItemsToSelect) > 0)
				{
					$groups[] = new TranslationItemGroup($translationGroup->GetTitle(), $groupItemsToSelect);
				} 
			}
		}
		
		return $groups;
	}
	
	/**
	 * @return $size - int
	 */
	public function GetTotalTranslationItemsCount()
	{
		$size = 0;
		
		foreach($this->_translationItemGroupArray as $translationItemGroup)
		{
			$translationItems = $translationItemGroup->GetItems();
			
			foreach($translationItems as $translationItem)
			{
				$size++;
			}
		}
		
		return $size;
	}
	
	private $_translationItemGroupArray;
}