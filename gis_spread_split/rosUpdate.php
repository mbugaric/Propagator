<?php


//Provjera treba li u meni-u zacrvenjeti Calculate ROS
function needToCalculateROS($WebDir, $korisnik, $chosenFuelModel)
{
	$filename="$WebDir/user_files/$korisnik/toCalculateROS";	
	$stringToFind="customSimulation_".$chosenFuelModel;	
	$string=getFromFile ($filename, "\n", "=", $stringToFind);
	
	return $string;
}

//Upisati vrijednost u toCalculateROS
function insertValueToCalculateROS($WebDir, $korisnik, $value, $chosenFuelModel)
{	
	
	$filename="$WebDir/user_files/$korisnik/toCalculateROS";	
	$fh2 = fopen($filename, 'r') or die("can't open file");
	$stringforrandfind20 = fread($fh2, filesize($filename));
	fclose($fh2);
	

	$stringforrandfind20 = str_replace("customSimulation_".$chosenFuelModel."=1", "customSimulation_".$chosenFuelModel."=".$value, $stringforrandfind20);
	$stringforrandfind20 = str_replace("customSimulation_".$chosenFuelModel."=0", "customSimulation_".$chosenFuelModel."=".$value, $stringforrandfind20);
	
	$fh = fopen($filename, 'w') or die("can't open file");
	fwrite($fh, $stringforrandfind20);
	fclose($fh);
	
	
	
}
?>