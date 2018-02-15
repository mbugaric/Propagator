<?php

extension_loaded("php_mapscript.so");

  
/////////////Directoriji i imena fileova ////////////////////
$MonImgName="monitor.png";				/////
$MonImgNameProfile="monitorProfile.png";		/////
$map_file_userdefault="./userdefault/sd_zupanija_userdefault.map";				/////
$numtocaka=20;						/////
$max_resolution=20000000;				/////
/////////////////////////////////////////////////////////////
//Višekorisnkički sustav
$korisnik=$_SESSION["user_name"];
$languagesList=array();
/////////////////////////////////////////////////////////////

	if (class_exists('db_func')) {
		//Connect to database
		$db = new db_func();
		$db->connect();

		//Defaultview from database
		$query = "SELECT defaultview FROM users WHERE username = '".$korisnik."'";
			$result = $db->query($query);
			while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
				foreach ($line as $col_value) {
					$defaultView=$col_value;
				}
			}
		// Free resultset
		pg_free_result($result);
		
		
		
		//Language from database
		$query = "SELECT languages.language_code FROM languages, users WHERE users.username = '".$korisnik."' and users.language_id = languages.language_id";
			$result = $db->query($query);
			while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
				foreach ($line as $col_value) {
					$chosenLanguage=$col_value;
				}
			}
			if($chosenLanguage=="" or is_null($chosenLanguage))
			{
				$chosenLanguage="ENG";
			}
		
		// Free resultset
		pg_free_result($result);
		
		//List of languages
		$query = "SELECT languages.language_code FROM languages where (language_code!='NUL' and language_code!='ALL')";
			$result = $db->query($query);
			while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
				foreach ($line as $col_value) {
					array_push($languagesList, $col_value);
				}
			}

		// Free resultset
		pg_free_result($result);
		
		//Editable languages from Database
		$query = "SELECT languages.language_code FROM languages, users WHERE users.username = '".$korisnik."' and users.editable_id = languages.language_id";
		$result = $db->query($query);
			while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
				foreach ($line as $col_value) {
					$editableLanguage=$col_value;
				}
			}

		// Free resultset
		pg_free_result($result);
		
		//User Administrator from Database
		$query = "SELECT adminuser_id FROM users WHERE username = '".$korisnik."'";
		$result = $db->query($query);
			while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
				foreach ($line as $col_value) {
					$adminuser=$col_value;
				}
			}

		// Free resultset
		pg_free_result($result);
		
		// Closing connection
		$db->disconnect();
	}
	

/////////////////////////////////////////////////////////////

	$WebDir = "/home/holistic/webapp/gis_spread_split";   		//Putanja do glavnog direktorija
	$linuxUser = "holistic";
	//$serverPathWebDir = "/gis_spread_split";							//Unutar public_html
	$serverPathWebDir = "/gis_spread_split";							//Unutar public_html
	$WebDirGisData = "/home/holistic/webapp/gis_data_holistic";		//Putanja do direktorija unutar kojeg su georeferencirani slojevi koji se prikazuju korištenjem mapservera
	$grasslocation="/home/holistic/HolisticMapset";				//Putanja do GRASS podataka
	$meteoArchiveDir = "/home/holistic/meteoArhiva/";
	$currentMeteoArchiveDir = "/home/holistic/meteoArhiva/current/";
	$vjetarWMSDir="/home/holistic/vjetarWMS/";
	$rastForRegion='el';												//Ime elevacijskih podataka u GRASS-u (OBAVEZNO ELEVACIJSKIH)
	$rastForWindRegion='el';	
	$rastForAspect='aspect';
	$rastForSlope='slope';
	$rastForModelAlbini='modelAlbini';
	$rastForModelScott='modelScott';
	$filename_prefix="sd";		
	$mapset="WebGis";													//Zajdenički mapset?
	//$grassexecutable="grass64";	//Putanja do GRASS GIS-a koji se želi pokretat, postaviti u $grassexecutable="grass"; ukoliko se koristi glavni instalirani 
	$grassexecutable="/usr/local/grass/bin/grass64";	
	
	$enableFuelParameters=true;
	$fuelParametersFileAlbini="fuelParametersAlbini.txt";
	$fuelParametersFileScott="fuelParametersScott.txt";
	$fuelParametersFileAlbiniDefault="fuelParametersAlbiniDefault.txt";
	$fuelParametersFileScottDefault="fuelParametersScottDefault.txt";
	
	$corine = $WebDirGisData."/clc_sve.shp";
	//$customFuelMap = $WebDirGisData."/clc_test.shp";
	$corineAttributeName="kod";	
	$customFuelMapsAttributeName="kod";	
	$corineRulesFilenameAlbini="reclass_Albini.r";
	$corineRulesFilenameScott="reclass_Scott.r";
	$corineRulesNewForCustomFuelMaps="reclass_customFuelMaps.r";
	
	$calculate_ROS_enabled = false;
	
	
	/*include language file */
	include_once ($WebDir."/languages/".$chosenLanguage.".php");
	
	
	/* check if .prj file is ok */
	if(isset($korisnik) && $_GET["sig"]==""  )
	{
		$PRJfilename=str_replace(".shp", ".prj", $corine);	
		$PRJ_contents = trim(file_get_contents($PRJfilename, true));
		$PRJ_default_contents = trim("PROJCS[\"Mercator_1SP\",GEOGCS[\"GCS_Geographic Coordinate System\",DATUM[\"D_WGS_1984_MAJOR_AUXILIARY_SPHERE\",SPHEROID[\"Sphere_Radius_6378137_m\",6378137,0]],PRIMEM[\"Greenwich\",0],UNIT[\"Degree\",0.017453292519943295]],PROJECTION[\"Mercator\"],PARAMETER[\"central_meridian\",0],PARAMETER[\"standard_parallel_1\",0],PARAMETER[\"false_easting\",0],PARAMETER[\"false_northing\",0],UNIT[\"Meter\",1]]
");

		if ( 	$PRJ_contents != $PRJ_default_contents )
		{
			$myfilePRJ = fopen($PRJfilename, "w") or die("Unable to open file!");
			fwrite($myfilePRJ, $PRJ_default_contents);
			fclose($myfilePRJ);
			echo "<script>alert(\""._PRJ_ERROR.$PRJfilename."\");</script>\n";
		}
	}
	
	
/////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////
$enableGrass=true;					/////
$enableSpread=true;					/////
$enableWind=true;					/////
$enableWindSettings=true;				/////
$enableMois=true;				/////	
$enableMoisSettings=true;				/////
$enableSpreadSaveDelete=true;				/////
$enableSettings=true;					/////
/////////////////////////////////////////////////////////////
if($enableSpreadSaveDelete || $enableROSandDeleteData)  /////
	$enableAddActions=true;				/////
else							/////
	$enableAddActions=false;			/////
/////////////////////////////////////////////////////////////

/*************************************
Ovo je za svaku lokacju drugacije
*************************************/


$lat_weather0 =44.1;
$lon_weather0=15.4;
$zoom_weather0=8;
$region_zoom=12;
//Granično područje 
$max_extend_north = 50.00; 
$max_extend_south = 35.00; 
$max_extend_east = 30.00; 
$max_extend_west = 5.00;





//Centar, Zoom
/*$lat0 =43.59; 
$lon0=16.47;
$zoom0=10;*/

$lat0 =43.59; 
$lon0=16.47;
$zoom0=10;




$pieces = explode("|", $defaultView);
$lat0 = $pieces[0];
$lon0 = $pieces[1];
$zoom0 = $pieces[2];

$map_file_user="$WebDir/user_files/$korisnik/sd_zupanija.map";				/////



$map_file_user_realtime="$WebDir/user_files/$korisnik/animatedRT.map";				/////
$mapfile=$map_file_user;



/*
// Dinamicko dohvacanje imena servera
$ime_servera = $_SERVER['SERVER_NAME'];

# Ime root direktorija web servera
$web_dir = $_SERVER['DOCUMENT_ROOT'];

# Ako slucajno nije postavljen staviti defaultni /var/www
if(!$web_dir)
	$web_dir = "/home/holistic/webapp";
	
	
include_once ($web_dir."/gis_spread_split/postavke_jezik.php");*/
	
//include_once("./languages/en.php");

# Ip adresa servera
//$SajaxAppendix = "/propagator/"; 				//Ukoliko je putanja javne IP adrese drugačija... npr: lokalno http://10.80.1.14/ a javno: http://propagator.adriaholistic.eu/propagator/, ispod se provjerava je li lokalna adresa ili javna pa se poništava ako nije
$SajaxAppendix = "";
$ip_servera = "propagator.adriaholistic.eu".$SajaxAppendix; 	//$_SERVER['SERVER_ADDR'];
$ip_servera_local="propagator.adriaholistic.eu"; 				//U sajaxu se koristi radi provjere
	
/*
# Konfiguracijski file postgres baze podrazumijeva se da je u root direktoriju web servera
include_once ($web_dir."konfiguracija/postavke_postgresql.php");
# File koji sadrži deklaraciju klase za pristup bazi podrazumijeva se da je u root direktoriju web servera
include_once ($web_dir."zajednicke_klase/class_data.php");
# File s funkcijom za slanje naredbi kameri podrazumijeva se da je u root direktoriju web servera
include_once ($web_dir."zajednicke_klase/function.php");
# File koji sadrži postavke jezika
include_once ($web_dir."postavke_jezik.php");

$var__base = new baza($dbhost,$dbport,$dbname,$dbuser,$dbpasswd);
$pok_baza = new upit($var__base->veza);

$rezultat1 = $pok_baza->execute("SELECT https_adresa  FROM region_system WHERE active = 1 AND type=1");

$myrow1 = pg_fetch_row($rezultat1);
//$ip_https = "161.53.171.118:4430";
$ip_https = "213.191.143.251:4443";
//echo $ip_https;

$rezultat = $pok_baza->execute("SELECT id, name, region, host(ip_camera), host(ip_meteo), host(ip_meteo_reset), host(ip_server), https_adresa, id_region  FROM region_system WHERE active = 1");

$id =  array();
$name =  array();
$region =  array();
$ip_camera =  array();
$ip_meteo =  array();
$ip_meteo_reset =  array();
$ip_server =  array();
$https_adresa =  array();
$id_region =  array();

while ($myrow = pg_fetch_row($rezultat))
{
if($myrow)
{
	# Podaci o lokacijama
	array_push($id, $myrow[0]);
	array_push($name, $myrow[1]);
	array_push($region, $myrow[2]);
	array_push($ip_camera, $myrow[3]);
	array_push($ip_meteo, $myrow[4]);
	array_push($ip_meteo_reset, $myrow[5]);
	array_push($ip_server, $myrow[6]);
	array_push($https_adresa, $myrow[7]);
	array_push($id_region, $myrow[8]);

}
else
{
	echo "<script>alert(\""._ALERT_GRESKA_1_BAZA."\"); window.history.go(-1);</script>\n";
	exit();
}


}
*/


?>
