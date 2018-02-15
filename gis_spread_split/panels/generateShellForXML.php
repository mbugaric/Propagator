<?php
include_once("/home/holistic/webapp/gis_spread_split/db_functions.php");

$files = glob('/home/holistic/webapp/gis_spread_split/panels/XML/*.txt'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

$areaToCover=1000; //in meters, radius (r)
$resolution=25;

$string="g.mapset mapset=AdriaFireRisk
g.region rast=MIRIP
";
	
$db=new db_func();
$db->connect();
$query = "SELECT id_panel, name, lat, lon, xmlpath FROM panels";
$result = $db->query($query);

while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	$string.="#".$line[name]."
r.what input=MIRIP east_north=";
	//echo $line[name]."<br />";
	$projOutObj =ms_newprojectionobj("init=epsg:900913");
	$projInObj = ms_newprojectionObj ("proj=longlat,ellps=WGS84,no_defs" );
    $poPoint = ms_newpointobj();
    $poPoint->setXY($line[lon], $line[lat]); //original coordinates
    $poPoint->project($projInObj, $projOutObj);	
	
	$coodr1=$poPoint->x;
	$coodr2=$poPoint->y;
	
	$string.=$coodr1.",".$coodr2;

	$left= $coodr1-500;
	$right = $coodr1+500;
	$bottom = $coodr2-500;
	$top = $coodr2+500;
	$step = ($areaToCover*2)/$resolution;
	
	for($br1=0; $br1< $resolution; $br1++)
	{
		for($br2=0; $br2< $resolution; $br2++)
		{
			$x=$left+$br1*$step;
			$y=$bottom+$br2*$step;
			$string.=",".$x.",".$y;
		}
	}
	
	$txtExtension = replace_extension($line[xmlpath], "txt");
	$txtExtension = "/home/holistic/webapp/gis_spread_split/panels/XML/".$txtExtension;

	//echo $line[xmlpath]."<br />";

	$string.="  > $txtExtension
";	
}

//echo $string;

$myfile = fopen('/home/holistic/webapp/gis_spread_split/panels/generateXML.sh', "w") or die("Unable to open file!");
fwrite($myfile, $string);


function replace_extension($filename, $new_extension) {
    $info = pathinfo($filename);
    return $info['filename'] . '.' . $new_extension;
}

?>