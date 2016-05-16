<?php
require_once ("kamis/Templates/TemplateHelper.php");

require_once ("code/Translations/TranslationItem/TranslationItem.php");
require_once ("code/Translations/TranslationItem/TranslationItemConstants.php");

class TranslationItemView
{
	/**
	 * @param $translationItem
	 * @return void
	 */	
	public function TranslationItemView($translationItem)
	{
		if(!isset(TranslationItemView::$_TRANSLATION_ITEM_TEMPLATE))
		{
			TranslationItemView::$_TRANSLATION_ITEM_TEMPLATE = TemplateHelper::GetTemplate(TranslationItemConstants::TEMPLATE_PATH_TRANSLATION_ITEM); 
		}
		
		$this->_translationItem = $translationItem;
	}
	/**
	 * @return TranslationItem_HTML
	 */
	public function Show()
	{
		if(!isset(TranslationItemView::$_TRANSLATION_ITEM_TEMPLATE)) {return "Template is not loaded";}
		
		$rowCount = strlen($this->_translationItem->GetFirstValue())/TranslationItemConstants::DEFAULT_COLUMNS_COUNT;
		$rowCount++;
		
		if($rowCount < 1){ $rowCount = 1; }
		if($rowCount > 15){$rowCount = 15;}
		
		$fillerArray = array
		(
			'FIRST_VALUE'  => $this->_translationItem->GetFirstValue(),
			'INDEX'  	   => $this->_translationItem->GetIndex(),
			'SECOND_VALUE' => $this->_translationItem->GetSecondValue(),
			'COL_COUNT'    => TranslationItemConstants::DEFAULT_COLUMNS_COUNT,
			'KEY'		   => $this->_translationItem->GetKey(),
			'ROW_COUNT'    => $rowCount,
		);
		
		$filledTemplate = TemplateHelper::FillTemplate(TranslationItemView::$_TRANSLATION_ITEM_TEMPLATE, $fillerArray, $removeHeader = true); 
		
		return $filledTemplate;
	}

	private $_translationItem;
	private static $_TRANSLATION_ITEM_TEMPLATE;
}