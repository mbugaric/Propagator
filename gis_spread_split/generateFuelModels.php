<?php
//ini_set('memory_limit', '512M');	
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

require("./postavke_dir_gis.php");


/*$attributeNameForCODE="Code_06";
$rastForModelAlbini='modelAlbini';
$rastForModelScott='modelScott';
$korisnik="admin";


//Corine
$corine = $WebDirGisData."/Corine_2006.shp";
$corineAttributeName="Code_06";				      //Must be integer
$corineRulesFilenameAlbini=$WebDir."/user_files/$korisnik/reclass_Albini.r";
$corineRulesFilenameScott=$WebDir."/user_files/$korisnik/reclass_Scott.r";
*/

/*
Input je Corine, koji ima definirano ime atributa gdje je spremljen CODE.

PRJ treba preurediti ako dolazi sa AdriaFireGIS-a

*/

function writeToFile($string, $filename)
{
	$fh = fopen($filename, 'w') or die("can't open file");
	fwrite($fh, $string);
	fclose($fh);
}

function generateScriptForDefaultModels($WebDir, $korisnik, $rastForModelAlbini, $rastForModelScott, $corineAlbini, $corineScott, $corineRulesFilenameAlbini, $corineRulesFilenameScott, $corineAttributeName, $mapset, $WebDirGisData)
{
	
		$textForModelGeneration="#!/bin/sh
	
g.mapset mapset=$mapset
	
#Corine-Albini
g.remove -f rast=$rastForModelAlbini
g.remove -f vect=Corine_$rastForModelAlbini
g.remove -f rast=Corine_raster_$rastForModelAlbini
v.in.ogr dsn=$corineAlbini output=Corine_$rastForModelAlbini --overwrite
g.region vect=Corine_$rastForModelAlbini res=40
v.to.rast --verbose --overwrite input=Corine_$rastForModelAlbini output=Corine_raster_$rastForModelAlbini use=attr column=$corineAttributeName
r.reclass input=Corine_raster_$rastForModelAlbini --overwrite output=$rastForModelAlbini rules=$corineRulesFilenameAlbini
	
g.remove -f vect=$rastForModelAlbini"."_vector
r.to.vect --verbose --overwrite input=$rastForModelAlbini output=$rastForModelAlbini"."_vector feature=area

v.out.ogr input=$rastForModelAlbini"."_vector type=area dsn=$WebDirGisData/ olayer=$rastForModelAlbini layer=1 format=ESRI_Shapefile --overwrite

g.remove -f rast=Corine_raster
#g.remove -f rast=Corine_raster_$rastForModelAlbini
#g.remove -f rast=Corine_raster_$rastForModelScott


#Corine-Scott
g.remove -f rast=$rastForModelScott
";

if($corineAlbini!=$corineScott)
{
	$textForModelGeneration.="v.in.ogr dsn=$corineScott output=Corine_$rastForModelScott --overwrite
	";
}
else
{
	$textForModelGeneration.="g.copy vect=Corine_$rastForModelAlbini,Corine_$rastForModelScott --overwrite
	";
}

$textForModelGeneration.="g.region vect=Corine_$rastForModelScott  res=40
v.to.rast --verbose --overwrite input=Corine_$rastForModelScott output=Corine_raster_$rastForModelScott use=attr column=$corineAttributeName
r.reclass input=Corine_raster_$rastForModelScott --overwrite output=$rastForModelScott rules=$corineRulesFilenameScott

g.remove -f vect=$rastForModelScott"."_vector
r.to.vect --verbose --overwrite input=$rastForModelScott output=$rastForModelScott"."_vector feature=area

v.out.ogr input=$rastForModelScott"."_vector type=area dsn=$WebDirGisData/ olayer=$rastForModelScott layer=1 format=ESRI_Shapefile --overwrite

g.remove -f rast=Corine_raster

";

	writeToFile($textForModelGeneration, $WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine.sh");
	
	
	/*$calculateFuelModels=$WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine_launch.sh";
	$ps = run_in_backgroundNew($calculateFuelModels);
	while(is_process_runningNew($ps))
   	{
		session_write_close();
	  	sleep(1);
		ob_flush;
		flush();
	}*/

}





function generateScriptForCustomModels($WebDir, $korisnik, $rastForModelAlbini, $rastForModelScott, $corineRulesFilenameAlbini, $corineRulesFilenameScott, $corineAttributeName, $rastForRegion, $grassmapset, $WebDirGisData )
{
	
	//prvo dohvatit nove podatke
	
	obtainNewCustomModelsFromServer($WebDir, $korisnik, $rastForModelAlbini, $rastForModelScott);
	
	
	$mapaAlbini="$WebDir/user_files/$korisnik/fuelModels/Albini/custom_fuel_map_albini.shp";
	$mapaScott="$WebDir/user_files/$korisnik/fuelModels/Scott/custom_fuel_map_scott.shp";
	
	
	
	
	
	
	//sad proračun
	
	$textForModelGeneration="#!/bin/sh
g.mapset mapset=$korisnik
";
	
	//if($mapaAlbini!="")
	if(file_exists($mapaAlbini) && filesize($mapaAlbini) > 200)
	{		
		//verzija gdje je potreban reclass
		/*$textForModelGeneration.="
#Corine-Albini
g.remove -f rast=$rastForModelAlbini
g.remove -f vect=Corine_$rastForModelAlbini
g.remove -f rast=Corine_raster_$rastForModelAlbini
v.in.ogr dsn=$mapaAlbini output=Corine_$rastForModelAlbini --overwrite

g.region vect=Corine_$rastForModelAlbini
v.to.rast --verbose --overwrite input=Corine_$rastForModelAlbini output=Corine_raster_$rastForModelAlbini use=attr column=$corineAttributeName
r.reclass input=Corine_raster_$rastForModelAlbini --overwrite output=$rastForModelAlbini rules=$corineRulesFilenameAlbini
	
g.remove -f vect=$rastForModelAlbini"."_vector
r.to.vect --verbose --overwrite input=$rastForModelAlbini output=$rastForModelAlbini"."_vector feature=area

v.out.ogr input=$rastForModelAlbini"."_vector type=area dsn=$WebDir/user_files/$korisnik/vector/ olayer=$rastForModelAlbini layer=1 format=ESRI_Shapefile --overwrite
";*/

	$textForModelGeneration.="
#Corine-Albini
g.remove -f rast=$rastForModelAlbini
g.remove -f vect=Corine_$rastForModelAlbini
g.remove -f rast=Corine_raster_$rastForModelAlbini
v.in.ogr dsn=$mapaAlbini output=Corine_$rastForModelAlbini --overwrite

g.region vect=Corine_$rastForModelAlbini res=10
v.to.rast --verbose --overwrite input=Corine_$rastForModelAlbini output=$rastForModelAlbini use=attr column=$corineAttributeName
r.mapcalc \"$rastForModelAlbini = int($rastForModelAlbini)\"
	
g.remove -f vect=$rastForModelAlbini"."_vector
r.to.vect --verbose --overwrite input=$rastForModelAlbini output=$rastForModelAlbini"."_vector feature=area

v.out.ogr input=$rastForModelAlbini"."_vector type=area dsn=$WebDir/user_files/$korisnik/vector/ olayer=$rastForModelAlbini layer=1 format=ESRI_Shapefile --overwrite
";
	
	}
	else
	{
		$textForModelGeneration.="
#Corine-Albini
g.remove -f rast=$rastForModelAlbini
g.remove -f vect=Corine_$rastForModelAlbini
g.remove -f rast=Corine_raster_$rastForModelAlbini
g.remove -f vect=$rastForModelAlbini"."_vector

g.region rast=$rastForRegion@$grassmapset res=40;

g.copy vect=$rastForModelAlbini"."_vector@$grassmapset,$rastForModelAlbini"."_vector
g.copy rast=$rastForModelAlbini@$grassmapset,$rastForModelAlbini

#v.out.ogr input=$rastForModelAlbini"."_vector type=area dsn=$WebDir/user_files/$korisnik/vector/ olayer=$rastForModelAlbini layer=1 format=ESRI_Shapefile --overwrite
";

	copy($WebDirGisData."/$rastForModelAlbini.shp", "$WebDir/user_files/$korisnik/vector/$rastForModelAlbini.shp");
	copy($WebDirGisData."/$rastForModelAlbini.dbf", "$WebDir/user_files/$korisnik/vector/$rastForModelAlbini.dbf");
	copy($WebDirGisData."/$rastForModelAlbini.prj", "$WebDir/user_files/$korisnik/vector/$rastForModelAlbini.prj");
	copy($WebDirGisData."/$rastForModelAlbini.shx", "$WebDir/user_files/$korisnik/vector/$rastForModelAlbini.shx");	
		
	}
	
		
	if(file_exists($mapaScott) && filesize($mapaScott) > 200 )
	{
		//verzija gdje je potreban reclass
		/*$textForModelGeneration.="
#Corine-Scott
g.remove -f rast=$rastForModelScott
g.remove -f vect=Corine_$rastForModelScott
g.remove -f rast=Corine_raster_$rastForModelScott
v.in.ogr dsn=$mapaScott output=Corine_$rastForModelScott --overwrite

g.region vect=Corine_$rastForModelScott
v.to.rast --verbose --overwrite input=Corine_$rastForModelScott output=Corine_raster_$rastForModelScott use=attr column=$corineAttributeName
r.reclass input=Corine_raster_$rastForModelScott --overwrite output=$rastForModelScott rules=$corineRulesFilenameScott

g.remove -f vect=$rastForModelScott"."_vector
r.to.vect --verbose --overwrite input=$rastForModelScott output=$rastForModelScott"."_vector feature=area

v.out.ogr input=$rastForModelScott"."_vector type=area dsn=$WebDir/user_files/$korisnik/vector/ olayer=$rastForModelScott layer=1 format=ESRI_Shapefile --overwrite


	";*/
	$textForModelGeneration.="
#Corine-Scott
g.remove -f rast=$rastForModelScott
g.remove -f vect=Corine_$rastForModelScott
g.remove -f rast=Corine_raster_$rastForModelScott
v.in.ogr dsn=$mapaScott output=Corine_$rastForModelScott --overwrite

g.region vect=Corine_$rastForModelScott res=10;
v.to.rast --verbose --overwrite input=Corine_$rastForModelScott output=$rastForModelScott use=attr column=$corineAttributeName
r.mapcalc \"$rastForModelScott = int($rastForModelScott)\"

g.remove -f vect=$rastForModelScott"."_vector
r.to.vect --verbose --overwrite input=$rastForModelScott output=$rastForModelScott"."_vector feature=area

v.out.ogr input=$rastForModelScott"."_vector type=area dsn=$WebDir/user_files/$korisnik/vector/ olayer=$rastForModelScott layer=1 format=ESRI_Shapefile --overwrite


	";

	}
	else
	{
		$textForModelGeneration.="
#Corine-Scott
g.remove -f rast=$rastForModelScott
g.remove -f vect=Corine_$rastForModelScott
g.remove -f rast=Corine_raster_$rastForModelScott
g.remove -f vect=$rastForModelScott"."_vector

g.region rast=$rastForRegion@$grassmapset res=40;

g.copy vect=$rastForModelScott"."_vector@$grassmapset,$rastForModelScott"."_vector
g.copy rast=$rastForModelScott@$grassmapset,$rastForModelScott

#v.out.ogr input=$rastForModelScott"."_vector type=area dsn=$WebDir/user_files/$korisnik/vector/ olayer=$rastForModelScott layer=1 format=ESRI_Shapefile --overwrite

";
	
	copy($WebDirGisData."/$rastForModelScott.shp", "$WebDir/user_files/$korisnik/vector/$rastForModelScott.shp");
	copy($WebDirGisData."/$rastForModelScott.dbf", "$WebDir/user_files/$korisnik/vector/$rastForModelScott.dbf");
	copy($WebDirGisData."/$rastForModelScott.prj", "$WebDir/user_files/$korisnik/vector/$rastForModelScott.prj");
	copy($WebDirGisData."/$rastForModelScott.shx", "$WebDir/user_files/$korisnik/vector/$rastForModelScott.shx");

	}




	writeToFile($textForModelGeneration, $WebDir."/user_files/$korisnik/exportModelsFromCorine.sh");
		

	$calculateFuelModels=$WebDir."/user_files/$korisnik/exportModelsFromCorine_launch.sh";
	$ps = run_in_backgroundNew($calculateFuelModels);
	while(is_process_runningNew($ps))
	{
		session_write_close();
		sleep(1);
		ob_flush;
		flush();
	}
	
	
	$isSuccess = checkIfCustomFuelModelVectorsExist($WebDir, $korisnik, $rastForModelAlbini, $rastForModelScott, $WebDirGisData, $grassmapset);
	
	if(!$isSuccess)
		echo 'alert("'._GIS_FUEL_FAILURE.'");';
		
	session_write_close();
	
}







function checkIfCustomFuelModelVectorsExist($WebDir, $korisnik, $rastForModelAlbini, $rastForModelScott)
{
	$first=false;
	$second=false;
	
	$filename1="$WebDir/user_files/$korisnik/vector/$rastForModelAlbini.shp";
	$filename2="$WebDir/user_files/$korisnik/vector/$rastForModelScott.shp";
	
	if(file_exists($filename1) && file_exists($filename2))
	{
		$first=true;
	}
	
	//Sad provjerit u GRASS-u
	
	
	$checkModels="$WebDir/user_files/$korisnik/checkModels.sh";
	$fh2 = fopen($checkModels, 'r') or die("can't open file");
	$stringforrandfind20 = fread($fh2, filesize($checkModels));
	fclose($fh2);

    $delimeterLeft="#Start";
    $delimeterRight="#End";
    $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
    $stringcheck=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);
	
	$stringchecknewdefault="
g.mapset mapset=$korisnik
g.list rast > '$WebDir/user_files/$korisnik/glistModels.log'
";

	setIntoFile ($checkModels, $stringcheck,$stringchecknewdefault);

	$stringps="$WebDir/user_files/$korisnik/checkModels_launch.sh";
	$ps = run_in_backgroundPozar($stringps);
	while(is_process_runningPozar($ps))
	{
		session_write_close();
		sleep(1);
		ob_flush;
		flush();
	}
	
	$myFile = "$WebDir/files/glistModels.log";
	$fh = fopen($myFile, 'r');
	$theData2 = fread($fh, filesize($myFile));
	fclose($fh);
	$glistarray=preg_split("/[\s+,\t+,\n+]/", $theData2);
	
	
	$myFile22 = "$WebDir/user_files/$korisnik/glistModels.log";
	$fh22 = fopen($myFile22, 'r');
	$theData222 = fread($fh22, filesize($myFile22));
	fclose($fh22);
	$glistarray22=preg_split("/[\s+,\t+,\n+]/", $theData222);
	
	//print_r($glistarray22);
	$countModels=0;
	for($i=0; $i<count($glistarray22);$i++)
	{
		if(trim($glistarray22[$i])=="modelAlbini" || trim($glistarray22[$i])=="modelScott")
		{
			$countModels++;
		}
	}
	if($countModels>=2)
		$second=true;
	
	//echo 'alert("'.$glistarray22[1].'");';
	
	if($first && $second)
		return true;
	else
		return false;
	
	
	
	
}

function checkIfDefaultFuelModelVectorsExist($WebDir, $korisnik, $rastForModelAlbini, $rastForModelScott, $WebDirGisData, $grassmapset)
{
	
	$first=false;
	$second=false;
	
	$filename1="$WebDirGisData/$rastForModelAlbini.shp";
	$filename2="$WebDirGisData/$rastForModelScott.shp";
	
	if(file_exists($filename1) && file_exists($filename2))
	{
		$first=true;
	}
	
	//Sad provjerit u GRASS-u
	
	
	$checkModels="$WebDir/user_files/$korisnik/checkModels.sh";
	$fh2 = fopen($checkModels, 'r') or die("can't open file");
	$stringforrandfind20 = fread($fh2, filesize($checkModels));
	fclose($fh2);

    $delimeterLeft="#Start";
    $delimeterRight="#End";
    $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
    $stringcheck=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);
	
	$stringchecknewdefault="
g.mapset mapset=$grassmapset
g.list rast > '$WebDir/user_files/$korisnik/glistModels.log'
";

	setIntoFile ($checkModels, $stringcheck,$stringchecknewdefault);

	$stringps="$WebDir/user_files/$korisnik/checkModels_launch.sh";
	$ps = run_in_backgroundPozar($stringps);
	while(is_process_runningPozar($ps))
	{
		session_write_close();
		sleep(1);
		ob_flush;
		flush();
	}
	
	$myFile = "$WebDir/files/glistModels.log";
	$fh = fopen($myFile, 'r');
	$theData2 = fread($fh, filesize($myFile));
	fclose($fh);
	$glistarray=preg_split("/[\s+,\t+,\n+]/", $theData2);
	
	
	$myFile22 = "$WebDir/user_files/$korisnik/glistModels.log";
	$fh22 = fopen($myFile22, 'r');
	$theData222 = fread($fh22, filesize($myFile22));
	fclose($fh22);
	$glistarray22=preg_split("/[\s+,\t+,\n+]/", $theData222);
	
	//print_r($glistarray22);
	$countModels=0;
	for($i=0; $i<count($glistarray22);$i++)
	{
		if(trim($glistarray22[$i])=="modelAlbini" || trim($glistarray22[$i])=="modelScott")
		{
			$countModels++;
		}
	}
	if($countModels>=2)
		$second=true;
	
	//echo 'alert("'.$glistarray22[1].'");';
	
	if($first && $second)
		return true;
	else
		return false;
	
	
	
}


function run_in_backgroundNew($Command, $Priority = 0)
{
    if($Priority)
        $PID = exec("nohup nice -n $Priority $Command 2> /dev/null & echo $!");
    else
	$PID = exec("nohup $Command > /dev/null 2> /dev/null & echo $!");
        //$PID = shell_exec("nohup $Command 2> /dev/null & echo $!");
	return($PID);
}

//Stara funkcija provjere izvodi li se proces
function is_process_runningNew($PID)
{
    exec("ps $PID", $ProcessState);
    return(count($ProcessState) >= 2);
}

//$test=checkIfFuelModelVectorsExist($WebDir, $korisnik, $rastForModelAlbini, $rastForModelScott);


//generateScriptForModels($WebDir, $korisnik, $rastForModelAlbini, $rastForModelScott, $corine, $corine, $corineRulesFilenameAlbini, $corineRulesFilenameScott, $corineAttributeName);



/*
$brojKategorija=13;
for($n=0; $n<=$brojKategorija; $n++)
{
	$R =round( (255 * $n) / $brojKategorija);
	$G =round ((255 * ($brojKategorija - $n)) / $brojKategorija);
	$B = 0;
	
	echo ("$R $G $B <br />");
}
*/


function obtainNewCustomModelsFromServer($WebDir, $korisnik, $rastForModelAlbini, $rastForModelScott)
{
	
	//Izbrisi stare fajlove
	array_map('unlink', glob("$WebDir/user_files/$korisnik/fuelModels/Albini/*"));
	array_map('unlink', glob("$WebDir/user_files/$korisnik/fuelModels/Scott/*"));
	unlink("$WebDir/user_files/$korisnik/fuelModels/fuelmodelsAlbini.zip");
	unlink("$WebDir/user_files/$korisnik/fuelModels/fuelmodelsScott.zip");
	unlink("$WebDir/user_files/$korisnik/vector/$rastForModelScott.shp");
	unlink("$WebDir/user_files/$korisnik/vector/$rastForModelScott.shx");
	unlink("$WebDir/user_files/$korisnik/vector/$rastForModelScott.dbf");
	unlink("$WebDir/user_files/$korisnik/vector/$rastForModelScott.prj");	
	unlink("$WebDir/user_files/$korisnik/vector/$rastForModelAlbini.shp");
	unlink("$WebDir/user_files/$korisnik/vector/$rastForModelAlbini.shx");
	unlink("$WebDir/user_files/$korisnik/vector/$rastForModelAlbini.dbf");
	unlink("$WebDir/user_files/$korisnik/vector/$rastForModelAlbini.prj");
	
	
	$serverWfs="http://10.80.1.13/wfs";
	$username=$korisnik;
	/*if($korisnik=="admin") $username = "ajdovscina_editor"; */
	
	$urlScott = "$serverWfs?SERVICE=wfs&VERSION=2.0.0&REQUEST=GetFeature&TYPENAME=holistic:custom_fuel_map_scott&srsName=epsg:3857&OUTPUTFORMAT=shape-zip&CQL_FILTER=username='$username'";
	$urlAlbini = "$serverWfs?SERVICE=wfs&VERSION=2.0.0&REQUEST=GetFeature&TYPENAME=holistic:custom_fuel_map_albini&srsName=epsg:3857&OUTPUTFORMAT=shape-zip&CQL_FILTER=username='$username'";
	
	//wget -O "/home/holistic/webapp/gis_spread_split/user_files/rruzic/fuelModels/fuelmodelsScott.zip" "http://10.80.1.13/wfs?SERVICE=wfs&VERSION=2.0.0&REQUEST=GetFeature&TYPENAME=holistic:custom_fuel_map_albini&srsName=epsg:3857&OUTPUTFORMAT=shape-zip&CQL_FILTER=username='ajdovscina_editor'"
	
	exec("wget -O \"$WebDir/user_files/$korisnik/fuelModels/fuelmodelsScott.zip\" \"$urlScott\"");
	exec("wget -O \"$WebDir/user_files/$korisnik/fuelModels/fuelmodelsAlbini.zip\" \"$urlAlbini\"");
	
	$zip = new ZipArchive;
	if ($zip->open("$WebDir/user_files/$korisnik/fuelModels/fuelmodelsScott.zip") === TRUE) {
		$zip->extractTo("$WebDir/user_files/$korisnik/fuelModels/Scott/");
		$zip->close();
		//echo 'ok';
	} else {
		//echo 'failed';
	}
	
	if ($zip->open("$WebDir/user_files/$korisnik/fuelModels/fuelmodelsAlbini.zip") === TRUE) {
		$zip->extractTo("$WebDir/user_files/$korisnik/fuelModels/Albini/");
		$zip->close();
		//echo 'ok';
	} else {
		//echo 'failed';
	}
	
	
	copy($WebDir."/userdefault/epsg900913.prj", $WebDir."/user_files/$korisnik/fuelModels/Scott/custom_fuel_map_scott.prj");
	copy($WebDir."/userdefault/epsg900913.prj", $WebDir."/user_files/$korisnik/fuelModels/Albini/custom_fuel_map_albini.prj");

	
}




?>