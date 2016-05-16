<?php 
session_start();
require("mois.php");

//Samo ukoliko je user uspješno logiran
if($korisnik!="") {
?>

<html>
<head>
<?php include_once("header.php");?>
<!--<link rel="stylesheet" href="./css/ipnas.css" type="text/css">-->
<link rel="stylesheet" href="./css/mixitup.css" type="text/css">
<script src="./js/jquery-1.11.0.min.js"></script>

<body>
<?php

//***************************************************************************************************//
//***************************************************************************************************//
//Otvara se popup prozor kod kojeg se unose podaci potrebni za racunanje vlastitog ROS-a
// i to podaci vezani za vlagu
//***************************************************************************************************//
//***************************************************************************************************//

$korisnik=$_GET['kor'];
//$WebDir = "/var/www/gis_spread_split";	
//$map_file="./sd_zupanija.map";
$map_file="./user_files/$korisnik/sd_zupanija.map";

$map = ms_newMapObj($map_file);

?><form enctype="multipart/form-data" method="POST" action=<?php echo $PHP_SELF?>><?php
moisSettings($WebDir, $map, $korisnik, $grassexecutable, $mapset, $grasslocation, $rastForRegion, $currentMeteoArchiveDir, $meteoArchiveDir);
?>
</form>
</body>
</html>
<?php
}
	else {
	echo '<center><h2>AdriaFirePropagator</h2>'._NATPIS_NO_LOGIN.'</center>';
	}
	?>