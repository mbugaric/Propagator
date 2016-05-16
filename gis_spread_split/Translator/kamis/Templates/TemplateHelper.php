<?php
require_once ("kamis/DataAccess/FileAccess.php");

class TemplateHelper
{
	private static $START_TEMPLATE_TAG = "{";
	private static $END_TEMPLATE_TAG = "}";
	private static $START_REPEATER_TAG = "<!-- START_REPEATER_{0} -->";
	private static $END_REPEATER_TAG = "<!-- END_REPEATER_{0} -->";
	private static $HTML_START_CONTENT_TAG = "<body>";
	private static $HTML_END_CONTENT_TAG = "</body>";
	

	public static function FillTemplate($template, $templateFillerArray, $removeHeader = false)
	{
		if($removeHeader)
		{
			$template = TemplateHelper::_RemoveHeader($template);		
		}
		
		$content = $template;
		
		foreach ($templateFillerArray as $templateTag => $templateContent)
		{
			$searchTag = TemplateHelper::$START_TEMPLATE_TAG . $templateTag . TemplateHelper::$END_TEMPLATE_TAG;
			$content = str_replace($searchTag, $templateContent, $content);
		}

		return $content;
	}
	
	public static function FillRepeaterTemplate ($template, $templateFillerArray, $repeaterTag, $removeHeader = false)
	{
		if($removeHeader)
		{
			$template = TemplateHelper::_RemoveHeader($template);		
		}
		
		$repeaterTemplate = TemplateHelper::_GetRepeaterTemplate($template, $repeaterTag);
		$repeaterTemplateWithEnclosure = TemplateHelper::_GetRepeaterTemplateWithEnclosure($template, $repeaterTag);
		$repeaterContent = "";
			
		foreach ($templateFillerArray as $itemTemplate)
		{			
			$repeaterContent = $repeaterContent . TemplateHelper::FillTemplate($repeaterTemplate, $itemTemplate); 
		}
		
		return str_replace($repeaterTemplateWithEnclosure, $repeaterContent, $template); 
	}
	
	public static function GetTemplate($templateRelativePath)
	{
		return FileAccess :: GetFileContent($templateRelativePath);
	}
	
	private static function _RemoveHeader($template)
	{
		$startContentTagIndex = strpos($template, TemplateHelper::$HTML_START_CONTENT_TAG);
		
		if($startContentTagIndex)
		{
			$endContentTagIndex = strripos($template, TemplateHelper::$HTML_END_CONTENT_TAG);
			
			if($endContentTagIndex)
			{
				$template = substr($template, $startContentTagIndex, $endContentTagIndex + strlen(TemplateHelper::$HTML_END_CONTENT_TAG));
			}
		} 
		
		return $template;
	}
	
	private static function _GetRepeaterTemplate ($template, $repeaterTag)
	{
		$startRepeaterTag = str_replace('{0}', $repeaterTag, TemplateHelper::$START_REPEATER_TAG);
		$endRepeaterTag = str_replace('{0}', $repeaterTag, TemplateHelper::$END_REPEATER_TAG);
		
		$startRepeaterIndex = strpos($template, $startRepeaterTag);
		$repeaterTemplate = "";
		
		if($startRepeaterIndex !== false)
		{
			$endRepeaterIndex = strpos($template, $endRepeaterTag, $startRepeaterIndex);
			
			if($endRepeaterIndex !== false)
			{
				$repeaterContentStartIndex = $startRepeaterIndex + strlen($startRepeaterTag);
				$repeaterContentLength = $endRepeaterIndex - $repeaterContentStartIndex;   
				$repeaterTemplate = substr($template, $repeaterContentStartIndex, $repeaterContentLength);
			}
		}
		
		return $repeaterTemplate;
	}
	
	private static function _GetRepeaterTemplateWithEnclosure($template, $repeaterTag)
	{
		$startRepeaterTag = str_replace('{0}', $repeaterTag, TemplateHelper::$START_REPEATER_TAG);
		$endRepeaterTag = str_replace('{0}', $repeaterTag, TemplateHelper::$END_REPEATER_TAG);
		
		$startRepeaterIndex = strpos($template, $startRepeaterTag);
		$repeaterTemplate = "";
		
		if($startRepeaterIndex !== false)
		{
			$endRepeaterIndex = strpos($template, $endRepeaterTag, $startRepeaterIndex);
			
			if($endRepeaterIndex !== false)
			{  
				$repeaterTemplate = substr
				(
					$template, 
					$startRepeaterIndex, 
					($endRepeaterIndex + strlen($endRepeaterTag) - $startRepeaterIndex)
				);
			}
		}
		
		return $repeaterTemplate;
	}
}