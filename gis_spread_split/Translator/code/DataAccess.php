<?php
require_once ("kamis/DataAccess/FileAccess.php");
require_once ("kamis/ValueTypeHelper.php");

require_once ("constants/Constants.php");

require_once ("code/Translations/TranslationItem/TranslationItem.php");
require_once ("code/Translations/TranslationItemGroup/TranslationItemGroup.php");
require_once ("code/Translations/TranslationItemGroup/TranslationItemGroupCollection.php");

class DataAccess
{
	private static $START_TAG = 'DEFINE(';
	private static $DELIMITER = ',';
	private static $END_TAG = ');';
	
	private static $SECTION_START_BEGINNING = "SECTION_START(";
	private static $SECTION_START_DELIMITER = "|";
	private static $SECTION_START_END = ")";
	
	private static $SECTION_END = "/* SECTION_END */";

	public static function GetTranslations($pathToPrimaryLanguageFile, $pathToSecondaryLanguageFile, $uiLanguage)
	{
		//Get primary and secondary file content
		$primaryFileContent = FileAccess::GetFileContent($pathToPrimaryLanguageFile);
		$secondaryFileContent = FileAccess::GetFileContent($pathToSecondaryLanguageFile);

		//find all language tokes in both files
		$primaryLanguageTranslations = DataAccess::_ParseLanguageGroups($primaryFileContent, $uiLanguage);
		$secondaryLanguageTranslations = DataAccess::_ParseLanguageGroups($secondaryFileContent, $uiLanguage);
		
		if(sizeof($primaryLanguageTranslations) !== sizeof($secondaryLanguageTranslations))
		{
			echo ("Translation Item arrays must be of same size");
		}

		//DataAccess::check($primaryLanguageTranslations, $secondaryLanguageTranslations);

		//create joined array which takes:
		//key, index, firstValue from the first collection 
		//secondValue from the secondArray.FirstValue
		return new TranslationItemGroupCollection(DataAccess::_CreateJoinedGroups($primaryLanguageTranslations, $secondaryLanguageTranslations));
	}

	public static function check($translationGroups1, $translationGroups2)
	{
		if(sizeof($translationGroups1) != sizeof($translationGroups2))
		{
			echo ("Translation groups differ in size");
		}
	
		$collectionLength = sizeof ($translationGroups1);
		
		for($index = 0; $index < $collectionLength; $index++ )
		{
			$primaryTranslationGroup = $translationGroups1[$index];
			$secondaryLanguageGroup = $translationGroups2[$index];

			$primaryItems =  $primaryTranslationGroup->GetItems();
			$secondaryItems = $secondaryLanguageGroup->GetItems();

			$title1 = $primaryTranslationGroup->GetTitle();
			$title2 = $secondaryLanguageGroup->GetTitle();
			
			for($k = 0; $k < sizeof($primaryItems) && $k < sizeof($secondaryItems); $k++)
			{
				if($primaryItems[$k]->GetKey() !== $secondaryItems[$k]->GetKey())
				{
					$key1 = $primaryItems[$k]->GetKey();
					$key2 = $secondaryItems[$k]->GetKey();
					echo("<br/> $key1 and $key2 differ in $title1; $title2<br/>");
				}
			}
		}
		
	}
	
	public static function SaveTranslations($pathToFile, $newTranslationItems)
	{
		$fileContent = FileAccess::GetFileContent($pathToFile);
		$currentTranslationItems = DataAccess::_ParseLanguage($fileContent);
		
		$translationItems = DataAccess::_UpdateTranslationItems ($currentTranslationItems, $newTranslationItems);
			
		FileAccess::SetFileContent($pathToFile, DataAccess::_Update($fileContent, $translationItems));
	}
	
	public static function CreateEmptyCopy ($pathToPrimaryLanguageFile, $pathToSecondaryLanguageFile)
	{
		//Copy primary file content to destination file
		$returnedValue = FileAccess::CopyFile($pathToPrimaryLanguageFile, $pathToSecondaryLanguageFile);
		if(!$returnedValue) { return false; }
		
		$secondaryLanguageFileContent = FileAccess::GetFileContent($pathToSecondaryLanguageFile);	
		$secondaryLanguageFileContent = DataAccess::ClearValues($secondaryLanguageFileContent);
		
		FileAccess::SetFileContent($pathToSecondaryLanguageFile, $secondaryLanguageFileContent);
		
		return true;
	}

	public static function ClearValues($fileContent)
	{
		$fileLines = explode ("\n",$fileContent);
		$newContent = "";
		
		foreach ($fileLines as $line)
		{
			if(ValueTypeHelper::StartsWith($line, DataAccess::$START_TAG))
			{			
				$splitedLine = explode(DataAccess::$DELIMITER, $line, 2);
					
				if(sizeof($splitedLine) == 2)
				{
					echo("");
					$line = str_replace
					(	
						$splitedLine[1],
						"\"\"" . DataAccess::$END_TAG,
						$line
					);
				}
			}
			
			$newContent = $newContent . $line . "\n";
		}
		
		return $newContent;
	}
	
	private static function _ParseLanguage($fileContent, $index = 0)
	{
		$translations = array();
		$fileLines = explode ("\n",$fileContent);
		
		foreach ($fileLines as $line)
		{
			if(ValueTypeHelper::StartsWith($line, DataAccess::$START_TAG))
			{			
				$splitedLine = explode(DataAccess::$DELIMITER, $line, 2);
					
				if(sizeof($splitedLine) == 2)
				{
					$key = substr($splitedLine[0], strlen(DataAccess::$START_TAG));
					$endTagIndex = strpos($splitedLine[1],DataAccess::$END_TAG);
					
					if($endTagIndex !== false)
					{
						$value = substr($splitedLine[1], 0, $endTagIndex);
						
						$key = str_replace(DataAccess::$START_TAG,"", $key);
						$key = str_replace("'", "", $key);
						
						$value = str_replace("\"", "", $value);

						$translations[] = new TranslationItem($index++,$key, $value,'' );
					}
				}
			}
		}
		
		return $translations;
	}
	
	private static function _ParseLanguageGroups($fileContent, $uiLanguage)
	{
		$sectionsWithStartSectionTag = explode (DataAccess::$SECTION_END, $fileContent);
		$translationItemGroups = array();
		
		foreach($sectionsWithStartSectionTag as $sectionWithStartSectionTag)
		{
			$sectionTitleIndex = strpos($sectionWithStartSectionTag, DataAccess::$SECTION_START_BEGINNING);

			if($sectionTitleIndex)
			{
				$sectionContentIndex = $sectionTitleIndex + strlen(DataAccess::$SECTION_START_BEGINNING);
				$endContentIndex = strpos($sectionWithStartSectionTag, DataAccess::$SECTION_START_END, $sectionContentIndex);
				
				if($endContentIndex)
				{
					$titleContent = substr($sectionWithStartSectionTag, $sectionContentIndex, $endContentIndex - $sectionContentIndex);
					if($titleContent)
					{
						$titles = explode(DataAccess::$SECTION_START_DELIMITER, $titleContent);
						$index = array_search($uiLanguage, Constants::$SUPPORTED_UI_LANGUAGES);

						if(!$index || $index >= sizeof($titles)) {$index = 0;}
						
						$translationGroupsCount = sizeof($translationItemGroups);
						$nextTranslationItemIndex = 0;
						if(!ValueTypeHelper::AreEqual($translationGroupsCount, 0))
						{
							 $lastTranslationItemGroup = $translationItemGroups[$translationGroupsCount - 1];
							 $nextTranslationItemIndex = $lastTranslationItemGroup->GetLastItemIndex() + 1;
						}
						
						$translationItems = DataAccess::_ParseLanguage($sectionWithStartSectionTag, $nextTranslationItemIndex);
												
						$translationItemGroups[] = new TranslationItemGroup($titles[$index], $translationItems);
					}
				}
			}
		}
		
		return $translationItemGroups;
	}
	
	private static function _CreateJoinedGroups($primaryLanguageGroups, $secondaryLanguageGroups)
	{
		if(sizeof($primaryLanguageGroups) !== sizeof($secondaryLanguageGroups))
		{
			echo("Number of groups differ");
		}
		
		$translationGroups = array();
		$collectionLength = sizeof ($primaryLanguageGroups);
		
		for($index = 0; $index < $collectionLength; $index++ )
		{
			$primaryLanguageGroup = $primaryLanguageGroups[$index];
			$secondaryLanguageGroup = $secondaryLanguageGroups[$index]; 
			
			if($primaryLanguageGroup->GetTitle() !== $secondaryLanguageGroup->GetTitle())
			{
				$title1 = $primaryLanguageGroups->GetTitle();
				$title2 = $secondaryLanguageGroup->GetTitle();
				echo("<br/> *** Groups: $title1 and $title2 differ in title! *** <br/>");
			}
			
			$translationGroups[] = new TranslationItemGroup
		    (
		  		$primaryLanguageGroup->GetTitle(),
			  	DataAccess::_CreateJoinedArray
			  	(
			  		$primaryLanguageGroup->GetItems(),
			  		$secondaryLanguageGroup->GetItems()
			  	)				  	
		    );
		}
		
		return $translationGroups;
	}
	private static function _CreateJoinedGroupsOld($primaryLanguageGroups, $secondaryLanguageGroups)
	{
		$translationGroups = array();
		$collectionLength = sizeof ($primaryLanguageGroups);
		
		for($index = 0; $index < $collectionLength; $index++ )
		{
			$primaryTranslationGroup = $primaryLanguageGroups[$index];
			$secondaryLanguageGroup = $secondaryLanguageGroups[$index]; 
			
			$translationGroups[] = new TranslationItemGroup
		    (
		  		$primaryTranslationGroup->GetTitle(),
			  	DataAccess::_CreateJoinedArray
			  	(
			  		$primaryTranslationGroup->GetItems(),
			  		$secondaryLanguageGroup->GetItems()
			  	)				  	
		    );
		}
		
		return $translationGroups;
	}
	
	private static function _CreateJoinedArray($primaryLanguageTranslations, $secondaryLanguageTranslations)
	{		
		$translationItems = array();
		$collectionLength = sizeof($primaryLanguageTranslations);
		
		for($index = 0; $index < $collectionLength; $index++ )
		{
			$primaryTranslationItem = $primaryLanguageTranslations[$index];
			$secondaryTranslationItem = DataAccess::_FindMatchingItem($secondaryLanguageTranslations, $primaryTranslationItem);

			if($secondaryTranslationItem == null)
			{
				echo("<br/>No match for:<br/>");
				echo($primaryTranslationItem->GetKey());
				echo("<br/>*****<br/><br/>");
				//var_dump($primaryLanguageTranslations);
				//echo("<br/>+++++<br/><br/>");
				//var_dump($secondaryLanguageTranslations);	
			}
			
			if($secondaryTranslationItem != null)
			{
				$translationItem = new TranslationItem
			    (
			    	$primaryTranslationItem->GetIndex(),		
			  		$primaryTranslationItem->GetKey(),
				  	$primaryTranslationItem->GetFirstValue(),
					$secondaryTranslationItem->GetFirstValue()			  				  	
			    );
								  
				$translationItems[] = $translationItem;
			}
		}
		
		return $translationItems;
	}
	
	private static function _FindMatchingItem($languageTranslations, $translationItem)
	{
		$translationCount = sizeof($languageTranslations);
		for($i = 0; $i < $translationCount; $i++)
		{
			if($languageTranslations[$i]->GetKey() === $translationItem->GetKey())
			{
				return $languageTranslations[$i];
			}
		}
	}
	
	//SHOULD BE OPTIMIZED
	private static function _UpdateTranslationItems($oldTranslationItems, $newTranslationItems)
	{
		foreach($oldTranslationItems as $oldTranslationItem)
		{
			foreach($newTranslationItems as $newTranslationItem)
			{
				if(ValueTypeHelper::AreEqual($oldTranslationItem->GetKey(), $newTranslationItem->GetKey()))
				{
					$oldTranslationItem->SetFirstValue($newTranslationItem->GetFirstValue());
					break;
				}
			}
		}
		
		return $oldTranslationItems;
	}
	
	private static function _Update($fileContent, $translationItems)
	{			
		$translations = array();
		$fileLines = explode ("\n",$fileContent);
		
		$index = 0;
		
		foreach ($fileLines as $line)
		{
			if(ValueTypeHelper::StartsWith($line, DataAccess::$START_TAG))
			{			
				$splitedLine = explode(DataAccess::$DELIMITER, $line, 2);
					
				if(sizeof($splitedLine) == 2)
				{
					$endTagIndex = strpos($splitedLine[1],DataAccess::$END_TAG);
					
					if($endTagIndex !== false)
					{
						$translationItem = $translationItems[$index++];
						$value = substr($splitedLine[1], 0, $endTagIndex);
						$newLine = str_replace
						(
							$value,
							"\"".$translationItem->GetFirstValue()."\"",
							$line
						);
						
						$fileContent = str_replace($line, $newLine, $fileContent);
					}
				}
			}
		}
		
		return $fileContent;
	}
}