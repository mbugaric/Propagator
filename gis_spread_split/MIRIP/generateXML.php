<?php


//print_r($argv);

//echo $argv[1];

$inputString = file_get_contents($argv[1], true);

$lines = explode(PHP_EOL, $inputString);


$nrValues=0;
$sum=0;
for($i=0;$i<count($lines);$i++)
{
	if($lines[$i]!="")
	{
		$nrValues++;
		$current_value=explode("||", $lines[$i]);
		//echo intval($current_value[1])."\n";
		$sum=$sum+$current_value[1];
	}
}

$miripAverage = intval($sum / $nrValues);
#echo $miripAverage;

$riskValue=0;

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
elseif ($miripAverage > 210 && $miripAverage <= 255)
{
	$riskValue=5;
}

echo "\n\n\n".$miripAverage."\n\n\n";


$finalString="<?xml version='1.0' encoding='ISO-8859-2'?>
<risk_index>
	<current_risk_index>$riskValue</current_risk_index>
</risk_index>";

echo "\n".$finalString."\n";


$myfile = fopen($argv[2], "w") or die("Unable to open file!");
fwrite($myfile, $finalString);


//////////////////
/*Privremeno spremaj stare*/

$oldXMLfolder="/home/holistic/webapp/gis_spread_split/MIRIP/oldXMLs/";
$today= date("d.m.Y.H");
$oldFile= $oldXMLfolder."HR_Split_Marjan_1_".$today.".xml";

$myfile = fopen($oldFile, "w") or die("Unable to open file!");
fwrite($myfile, $finalString);



?>