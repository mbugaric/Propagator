<?php
require_once ("kamis/Templates/TemplateHelper.php");
require_once ("kamis/ValueTypeHelper.php");
require_once ("kamis/PagingHelper.php");

require_once ("code/Translations/TranslationItemGroup/TranslationCollectionConstants.php");
require_once ("code/Translations/TranslationItem/TranslationItem.php");
require_once ("code/Translations/TranslationItem/TranslationItemView.php");

require_once ("constants/Dictionary.php");
require_once ("constants/Constants.php");

require_once ("code/Current.php");

class TranslationCollectionView
{
	/**
	 * @param $translationGroupCollection - array of TranslationItemGroup
	 * @return void
	 */
	public function TranslationCollectionView($translationGroupCollection)
	{
		$this->_translationGroupCollection = $translationGroupCollection;
	}
	
	/**
	 * @return TranlsationCollection HTML representation
	 */
	public function Show()
	{
		

		$startIndex = PagingHelper::CalculateStartIndex(Current::GetPageNumber(), Current::GetPageSize()); 
	 	$endIndex = PagingHelper::CalculateEndIndex(Current::GetPageNumber(), Current::GetPageSize(), $this->_translationGroupCollection->GetTotalTranslationItemsCount()); 	 	
	 	
		$translationCollectionTemplate = TemplateHelper::GetTemplate(TranslationCollectionConstants::TRANSLATION_COLLECTION_TEMPLATE_PATH);
		
		$translationCollectionTemplate = $this->_FillPaging($translationCollectionTemplate, Current::GetPageSize(), Current::GetPageNumber(),Current::GetSourceLanguage(), Current::GetDestinationLanguage(), Current::GetUiLanguage());
		$translationCollectionTemplate = $this->_FillWithTranslationGroups($translationCollectionTemplate, $startIndex, $endIndex); 

		$templateFillerArray = array
		(
			'BUTTON_SAVE_CAPTION' => Dictionary::GetButtonSaveCaption(Current::GetUiLanguage())
		);
		
		return TemplateHelper::FillTemplate($translationCollectionTemplate, $templateFillerArray, $removeHeader = true);
	}
	
	private function _FillWithTranslationGroups($template, $startIndex, $endIndex)
	{
		$itemTemplateFillerCollection = array();
		
		$translationGroupsToShow = $this->_translationGroupCollection->GetTranslationItemGroups($startIndex, $endIndex);
		
		foreach ($translationGroupsToShow as $translationGroup)
		{
			$translationItems = $translationGroup->GetItems();
			$translationItemContent = "";	
		
			foreach($translationItems as $translationItem)
			{
				$translationItemView = new TranslationItemView($translationItem);
				$translationItemHTML = $translationItemView->Show();
				$translationItemContent = $translationItemContent . $translationItemHTML; 	
			}
		
			$itemTemplateFillerCollection[] = array 
			(
				'TITLE' => $translationGroup->GetTitle(),
				'TRANSLATION_ITEM_CONTENT' => $translationItemContent
			);	
		}
		
		return TemplateHelper::FillRepeaterTemplate($template, $itemTemplateFillerCollection,"TRANSLATION_GROUP");
	}
	
	private function _FillPaging($template, $pageSize, $pageNumber, $sourceLanguage, $destinationLanguage, $uiLanguage)
	{
		$itemsCount = $this->_translationGroupCollection->GetTotalTranslationItemsCount();
		
		$totalPageNumber = PagingHelper::CalculateTotalPageNumber($itemsCount, $pageSize);
		$currentPageLink = TranslationCollectionView::_GetPageLink($pageNumber, $pageSize, $sourceLanguage, $destinationLanguage, $uiLanguage);
		$pagingFillerCollection = array();
		
		if($pageNumber > 1)// add link to previous
		{
			$pageLink = TranslationCollectionView::_GetPageLink($pageNumber - 1, $pageSize, $sourceLanguage, $destinationLanguage, $uiLanguage);
			$pagingFillerCollection[] = TranslationCollectionView::_CreatePage($pageLink, $pageNumber - 1,'<<', TranslationCollectionConstants::PAGING_STYLE);
		}
		
		if($pageNumber <= 3)
		{
			for($i = 1; $i <= $totalPageNumber && $i <= 5; $i++)
			{
				$pageLink = TranslationCollectionView::_GetPageLink($i, $pageSize, $sourceLanguage, $destinationLanguage, $uiLanguage);
				$pageStyle = TranslationCollectionConstants::PAGING_STYLE;
				if(ValueTypeHelper::AreEqual($i, $pageNumber)){$pageStyle = TranslationCollectionConstants::PAGING_SELECTED_STYLE;}
				$pagingFillerCollection[] = TranslationCollectionView::_CreatePage($pageLink, $i, $i, $pageStyle);
			}	
		}
		else
		{
			//add link to first page
			$pageLink = TranslationCollectionView::_GetPageLink(1, $pageSize, $sourceLanguage, $destinationLanguage, $uiLanguage);
			$pagingFillerCollection[] = TranslationCollectionView::_CreatePage($pageLink, 1, 1, TranslationCollectionConstants::PAGING_STYLE);
			$pagingFillerCollection[] = TranslationCollectionView::_CreatePage($currentPageLink, $pageNumber, '...', TranslationCollectionConstants::PAGING_DISABLED_STYLE);
			
			//add links to previous 2 and nex 2 pages
			for($i = ($pageNumber - 2); $i <= $totalPageNumber && $i <= ($pageNumber + 2); $i++)
			{
				$pageLink =  TranslationCollectionView::_GetPageLink($i, $pageSize, $sourceLanguage, $destinationLanguage, $uiLanguage);
				$pageStyle = TranslationCollectionConstants::PAGING_STYLE;
				if(ValueTypeHelper::AreEqual($i, $pageNumber)){$pageStyle = TranslationCollectionConstants::PAGING_SELECTED_STYLE;}		
				$pagingFillerCollection[] = TranslationCollectionView::_CreatePage($pageLink, $i, $i, $pageStyle); 
			}
		}
		
		//add last page
		if($pageNumber < ($totalPageNumber-2))
		{
			$pagingFillerCollection[] = TranslationCollectionView::_CreatePage($currentPageLink, $pageNumber, '...', TranslationCollectionConstants::PAGING_STYLE);
			$pageLink = TranslationCollectionView::_GetPageLink($totalPageNumber, $pageSize, $sourceLanguage, $destinationLanguage, $uiLanguage);
			$pagingFillerCollection[] = TranslationCollectionView::_CreatePage($pageLink, $totalPageNumber, $totalPageNumber, TranslationCollectionConstants::PAGING_STYLE);
		}
		 
		// add link to next page
		if($pageNumber < $totalPageNumber)
		{
			$pageLink = TranslationCollectionView::_GetPageLink($pageNumber + 1, $pageSize, $sourceLanguage, $destinationLanguage, $uiLanguage);
			$pagingFillerCollection[] = TranslationCollectionView::_CreatePage($pageLink, $pageNumber + 1, '>>', TranslationCollectionConstants::PAGING_STYLE);
		}  
		
		return TemplateHelper::FillRepeaterTemplate($template, $pagingFillerCollection, "PAGE_NUMBER_ITEM");
	}

	
	private function _GetPageLink($pageNumber, $pageSize, $sourceLanguage, $destinationLanguage, $uiLanguage)
	{
		return "index.php"
			 . "?pageSize=$pageSize"
			 . "&pageNumber=$pageNumber"
			 . "&sourceLanguage=$sourceLanguage"
			 . "&destinationLanguage=$destinationLanguage"
			 . "&uiLanguage=$uiLanguage";
	}
	
	private function _CreatePage($pageLink, $pageNumber, $pageContent, $pageStyle)
	{
		return array
		(
			'PAGE_LINK'   => $pageLink,
			'PAGE_NUMBER' => $pageNumber,
			'PAGE_CONTENT' => $pageContent,
			'PAGE_STYLE_NAME' => $pageStyle	
		);  
	}
	

	private $_translationGroupCollection;
}

