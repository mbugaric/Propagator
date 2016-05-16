<?php
require_once("kamis/ValueTypeHelper.php");

class FileAccess
{
	public static function GetFileContent($filePath)
	{
		return  file_get_contents($filePath); 
	}
	
	public static function SetFileContent ($filePath, $fileContent)
	{		
		//file_put_contents($filePath, $fileContent);
		$fileHandler = fopen($filePath, 'w') or die("can't open file");
		fwrite($fileHandler, $fileContent);
		fclose($fileHandler);
	}
	/* Stari koji kreira file sa pravima 644
	public static function CopyFile ($sourceFilePath, $destinationFilePath)
	{
		return copy ($sourceFilePath, $destinationFilePath);
	}
	*/
	
	public static function CopyFile ($sourceFilePath, $destinationFilePath)
        {
                $copyReturnValue = copy ($sourceFilePath, $destinationFilePath);

                chmod($destinationFilePath, 0664);

                return $copyReturnValue;
        }


	public static function FileExsists($filePath)
	{
		return file_exists($filePath);
	}
}