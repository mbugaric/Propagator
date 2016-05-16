<?php
session_start();
include_once("../db_functions.php");
include_once("../postavke_dir_gis.php");

require_once ("kamis/Templates/TemplateHelper.php");
require_once ("kamis/DataAccess/FileAccess.php");
require_once ("kamis/ValueTypeHelper.php");

require_once ("code/Current.php");
require_once ("code/DataAccess.php");
require_once ("constants/Dictionary.php");
require_once ("constants/Constants.php");

require_once ("code/MainPage/MainPageConstants.php");
require_once ("code/Translations/TranslationItemGroup/TranslationCollectionView.php");


class MainPageView
{
	/**
	 * @return void
	 */
	public function MainPageView()
	{
		$this->_translationCollection = MainPageView::_CreateTranslationCollection
		(
			Current::GetSourceLanguage(),
			Current::GetDestinationLanguage()
		);
	}

	/**
	 * @return Whole main page as HTML
	 */
	public function ShowAll()
	{	
	
		$mainPageTemplate = TemplateHelper::GetTemplate(MainPageConstants::MAIN_PAGE_TEMPLATE_PATH);
		
		$translationCollectionView = new TranslationCollectionView($this->_translationCollection);
		
		$currentStateQuery = Current::GetCurrentStateQuery();
		
		$mainPageTemplate = $this->_FillSelector
		(
			$mainPageTemplate,
			MainPageConstants::TAG_SOURCE_LANGUAGE_REPEATER_ITEM,
			Constants::$SUPPORTED_SOURCE_LANGUAGES,
			Current::GetSourceLanguage()	
		);
		
		$mainPageTemplate = $this->_FillSelector
		(
			$mainPageTemplate,
			MainPageConstants::TAG_DESTINATION_LANGUAGE_REPEATER_ITEM,
			Constants::$SUPPORTED_DESTINATION_LANGUAGES,
			Current::GetDestinationLanguage()
		);
	
		$mainPageTemplate = $this->_FillSelector
		(
			$mainPageTemplate,
			MainPageConstants::TAG_PAGE_SIZE_REPEATER_ITEM,
			Constants::$SUPPORTED_PAGE_SIZE,
			Current::GetPageNumber()
		);
		
		$templateFillerArray = array
		(
			'TITLE' =>"AdriaFirePropagator Translator",
			'SELECT_SOURCE_LANGUAGE_CAPTION'=> Dictionary::GetSourceLanguageCaption(Current::GetUiLanguage()),
			'SELECT_DESTINATION_LANGUAGE_CAPTION'=> Dictionary::GetDestinationLanguageCaption(Current::GetUiLanguage()),
			'SELECT_PAGE_SIZE_CAPTION'=> Dictionary::GetPageSizeCaption(Current::GetUiLanguage()),
			'BUTTON_SAVE_CAPTION'=>Dictionary::GetButtonSaveCaption(Current::GetUiLanguage()),
			'CURRENT_PAGE_NUMBER'=>Current::GetPageNumber(),
			'CURRENT_UI_LANGUAGE'=>Current::GetUiLanguage(),
			'TRANSLATION_ITEM_CONTENT'=> $translationCollectionView->Show(),
			'LINK_CRO' => "?uiLanguage=HRV" .'&'. $currentStateQuery,
			'LINK_CRO_ID' =>$this->_GetLanguageLinkID('HRV'),										
			'LINK_ENG' => "?uiLanguage=ENG" .'&'. $currentStateQuery,
			'LINK_ENG_ID' =>$this->_GetLanguageLinkID('ENG'),						
		);
		
		return TemplateHelper::FillTemplate($mainPageTemplate, $templateFillerArray);
	}
	
	/**
	 * @return TranslationItems as HTML
	 */
	public function ShowTable()
	{
		$translationCollectionView = new TranslationCollectionView($this->_translationCollection);
		return $translationCollectionView->Show();
	}
	
	private function _CreateTranslationCollection($sourceLanguage, $destinationLanguage)
	{
		$sourceLanguagePath = Constants::GetLanguagePath($sourceLanguage);
		$destinationLanguagePath = Constants::GetLanguagePath($destinationLanguage);
		
		
		
		if(!FileAccess::FileExsists($sourceLanguagePath))
		{
			echo ($sourceLanguagePath. " - Source language file does not exsist<br>");
		}
		else
		{
			if(!FileAccess::FileExsists($destinationLanguagePath))
			{
				DataAccess::CreateEmptyCopy
				(
					$sourceLanguagePath,
					$destinationLanguagePath
				);
			}
			
			return DataAccess::GetTranslations($sourceLanguagePath,$destinationLanguagePath, Current::GetUiLanguage());
		}
	}
	
	private function _FillSelector($template, $repeaterTag, $valuesCollection, $valueToSelect)
	{
		$selectorFiller = array();
				
		foreach($valuesCollection as $value)
		{
			$isSelected = ValueTypeHelper::AreEqual($value,$valueToSelect) ? "selected"
																		   : "";
			$selectorFiller[] = array
			(
				'VALUE' => $value,
				'SELECTED' => $isSelected
			);
		}
		
		return TemplateHelper::FillRepeaterTemplate($template, $selectorFiller, $repeaterTag);
	}
	
	private function _GetLanguageLinkID($language)
	{
		if(ValueTypeHelper::AreEqual($language, Current::GetUiLanguage()))
		{
			return "link" . $language . "Selected";
		}
		else
		{
			return "link" . $language;
		}
	}

	private $_translationCollection;
}

