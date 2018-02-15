<?php

$inputDirectory = "/home/holistic/webapp/gis_spread_split/panels/XML/";


$files = glob("$inputDirectory/*.txt");


    foreach($files as $file) 
	{
		//echo $file." ";
		$xmlFilename=$inputDirectory."".replace_extension($file,"xml");
        
		if (!file_exists($file))
		{
			echo "error - File does not exist\n";
			exit;
		}
		
		$inputString = file_get_contents($file, true);
		$lines = explode(PHP_EOL, $inputString);
		$nrValues=0;
		$sum=0;
		
		for($i=0;$i<count($lines);$i++)
		{
			if($lines[$i]!="")
			{
				
				$current_value=explode("||", $lines[$i]);
				$newValue=intval($current_value[1]);
				if($newValue!=0)
				{
					$nrValues++;
					$sum=$sum+$newValue;
				}
				else
				{
					echo "Ignoring zero";
				}
			}
		}
		$miripAverage = intval($sum / $nrValues);
		$riskValue=0;
		
		$now = time();
		$num = date("m");
		
		echo $num." ".$file;
		
		//Ako je ljeto;
		if($num == '06' || $num == '6' || $num == '07' || $num == '7' || $num == '08' || $num == '8' )
		{
			$miripAverage = $miripAverage + 30;
			echo " ljeto";
		}	
		else if($num == '04' || $num == '4' || $num == '05' || $num == '5' || $num == '09' || $num == '9' || $num == '10' || $num == '10')
		{
			$miripAverage = $miripAverage;
			echo " proljece jesen";
		}	
		else
		{
			$miripAverage = $miripAverage - 5;
			echo " zima";
		}

		if ($miripAverage <= 75)
		{
			$riskValue=1;
		}
		elseif ($miripAverage > 75 && $miripAverage <= 120)
		{
			$riskValue=2;
		}
		elseif ($miripAverage > 120 && $miripAverage <= 165)
		{
			$riskValue=3;
		}
		elseif ($miripAverage > 165 && $miripAverage <= 210)
		{
			$riskValue=4;
		}
		elseif ($miripAverage > 210 && $miripAverage <= 555)
		{
			$riskValue=5;
		}
		echo "\n\n\n".$miripAverage."\n\n\n";
		
		
			
		
		$finalString="<?xml version='1.0' encoding='ISO-8859-2'?>
<risk_index>
	<current_risk_index>$riskValue</current_risk_index>
</risk_index>";

		echo "\n".$finalString."\n";
		$myfile = fopen($xmlFilename, "w") or die("Unable to open file!");
		fwrite($myfile, $finalString);
    }

/*

$oldXMLfolder="/home/holistic/webapp/gis_spread_split/MIRIP/oldXMLs/";
$today= date("d.m.Y.H");
$oldFile= $oldXMLfolder."HR_Split_Marjan_1_".$today.".xml";

$myfile = fopen($oldFile, "w") or die("Unable to open file!");
fwrite($myfile, $finalString);
*/

function replace_extension($filename, $new_extension) {
    $info = pathinfo($filename);
    return $info['filename'] . '.' . $new_extension;
}

?>