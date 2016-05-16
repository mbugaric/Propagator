<?php
class TranslationItem
{
	/**
	 * @param $index - int
	 * @param $key - string
	 * @param $firstValue - string or null
	 * @param $secondValue - string or nul
	 * @return void
	 */
	public function TranslationItem($index, $key, $firstValue, $secondValue)
	{	
		$this->_index = $index;
		$this->_key = $key;
		$this->_firstValue = $firstValue;
		$this->_secondValue = $secondValue;	
	}
	/**
	 * @return string
	 */
	public function GetKey()
	{
		return $this->_key;
	}
	
	/**
	 * @return string
	 */
	public function GetFirstValue()
	{
		return $this->_firstValue;
	}
	
	/**
	 * @param $newValue - string
	 * @return void
	 */
	public function SetFirstValue($newValue)
	{
		$this->_firstValue = $newValue;			
	}
	/**
	 * @return index - int
	 */
	public function GetIndex()
	{
		return $this->_index;
	}
	/**
	 * @return secondValue - string
	 */
	public function GetSecondValue()
	{
		return $this->_secondValue;
	}
	
	/**
	 * @param $secondValue - string
	 * @return void
	 */
	public function SetSecondValue($secondValue)
	{
		$this->_secondValue = $secondValue;
	}
	
	private $_key;
	private $_firstValue;
	private $_secondValue;
	private $_index;
}
