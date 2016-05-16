<?php
require_once ("kamis/ValueTypeHelper.php");

class TranslationItemGroup
{
	/**
	 * @param $title - string 
	 * @param $items - array of translation items
	 * @return void
	 */
	public function TranslationItemGroup($title, $items)
	{
		$this->_groupTitle = $title;
		$this->_items = $items;
	}
	
	/**
	 * @return group title - string
	 */
	public function GetTitle()
	{
		return $this->_groupTitle;
	}
	
	/**
	 * @param $translationItem - TranslationItem
	 * @return void
	 */
	public function AddItem($translationItem)
	{
		$this->_items[] = $translationItem;	
	}
	
	/**
	 * @return array of TranslationItems
	 */
	public function GetItems()
	{
		return $this->_items;
	}
	
	/**
	 * @param $index - int
	 * @return if $index is valid return TranslationItem else return void 
	 */
	public function GetItem($index)
	{
		if(!isset($index) || !is_int($index) || $index < 0 || $index >= sizeof($this->_items))
		{
			return;
		}
		
		return $this->_items[$index];
	}
	
	/**
	 * @return int (-1 if items is empty)
	 */
	public function GetFirstItemIndex()
	{
		$itemsCount = sizeof($this->_items);
		if(ValueTypeHelper::AreEqual($itemsCount, 0)) { return -1;}
		
		$translationItem = $this->_items[0];
		return $translationItem->GetIndex();
	}
	
	/**
	 * @return int (-1 if items is empty)
	 */
	public function GetLastItemIndex()
	{
		$itemsCount = sizeof($this->_items);
		if(ValueTypeHelper::AreEqual($itemsCount, 0)) { return -1;}
		
		$translationItem = $this->_items[$itemsCount - 1];
		return $translationItem->GetIndex();
	}
	
	private $_groupTitle;
	private $_items;
}