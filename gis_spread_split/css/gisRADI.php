<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
<? include_once("postavke_dir_gis.php"); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1250">
	<link rel="stylesheet" href="./css/google.css" type="text/css" />
	<link rel="stylesheet" href="./css/style.css" type="text/css" />
	<link rel="stylesheet" href="./css/context.css" type="text/css" />
    <script src="../../js/OpenLayers.js"></script>
	<script src="../../js/ScaleBar.js" language="JavaScript"></script>
	<script src="../../js/wz_jsgraphics.js" language="JavaScript"></script>
	<script src="./js/prototype.js" language="JavaScript"></script>
	<script src="./js/livepipe.js" language="JavaScript"></script>
	<script src="./js/all.js" language="JavaScript"></script>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=ABQIAAAAfgwy2cnHSUm_Wikn7Vn2qBQ4B8kNo0tsr1Lb3mwHEFEK2wCPqRTsbt8DOwAP66SXngbsr61J0NRuDw" type="text/javascript"></script>

		<script> 

			document.observe('dom:loaded',function(){
					
			var context_menu_one = new Control.ContextMenu('map');
			context_menu_one.addItem({
				label: 'Left Image, Item 1',
				callback: function(){
					alert("omg");
				}
			});
			context_menu_one.addItem({
				label: 'Left Image, Item 2',
				callback: function(){
					alert("omg");
				}
			});
			
		 
				});
		</script> 
  <?



/////////////Directoriji i imena fileova ////////////////////
$WebDir = "/var/www/gis_spread/";		/////
$WebDir_gisrc = "/var/www/gis_data/Splitsko_dalmatinska";
$MonImgName="monitor.png";				/////
$MonImgNameProfile="monitorProfile.png";		/////
$rastForRegion='el';					/////
$rastForWindRegion='el';				/////
$map_file_userdefault="./userdefault/sd_zupanija_userdefault.map";				/////
$numtocaka=20;						/////
$filename_prefix="sd";					/////
$max_resolution=20000000;				/////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
$enableGrass=true;					/////
$enableSpread=true;					/////
$enableROSandDeleteData=true;				/////
$enableWind=true;					/////
$enableWindSettings=true;				/////
$enableMois=true;				/////	
$enableMoisSettings=true;				/////
$enableSpreadSaveDelete=true;				/////
$enableSettings=true;					/////
$displaycoord=true;					/////
$enableCameraProfile=false;				/////
/////////////////////////////////////////////////////////////
if($enableSpreadSaveDelete || $enableROSandDeleteData)  /////
	$enableAddActions=true;				/////
else							/////
	$enableAddActions=false;			/////
/////////////////////////////////////////////////////////////

//require_once("korisnik.php");
$korisnik="admin";
//if($_GET["kor"]!="") $korisnik=$_GET["kor"];




 //Radi ucitavanja info iz shapefile ESRI
     require("shapefile.php");

//$korisnik=$_SESSION["user_name"];
$map_file_user="./user_files/$korisnik/sd_zupanija.map";				/////
$mapfile=$map_file_user;

$Wind_dirAsc="./user_files/$korisnik/wind_dir.asc"; 		/////
$Wind_speedAsc="./user_files/$korisnik/wind_speed.asc";		/////

$Wind_dir_default_Asc="./files/wind_dir.asc"; 		/////
$Wind_speed_default_Asc="./files/wind_speed.asc";		/////



function full_copy( $source, $target )
    {
		?><div style="position: absolute; top: 1300px;">
<?


        if ( is_dir( $source ) )
        {
            @mkdir( $target );
           
            $d = dir( $source );
           
            while ( FALSE !== ( $entry = $d->read() ) )
            {
                if ( $entry == '.' || $entry == '..' )
                {
                    continue;
                }
               
                $Entry = $source . '/' . $entry;           
                if ( is_dir( $Entry ) )
                {
                    full_copy( $Entry, $target . '/' . $entry );
                    continue;
                }
                copy( $Entry, $target . '/' . $entry );
            }
           
            $d->close();
        }else
        {
            copy( $source, $target );
        }
		?>
</div>
<?
    }


if(!is_dir  ( "./user_files/$korisnik" ))
{
	mkdir("./user_files/$korisnik/", 0777);
	chmod("./user_files/$korisnik/", 0777);
}
if(!is_dir  ( "./user_files/$korisnik/raster/" ))
{
	mkdir("./user_files/$korisnik/raster/", 0777);
	chmod("./user_files/$korisnik/raster/", 0777);
}
if(!is_dir  ( "./user_files/$korisnik/vector/" ))
{
	mkdir("./user_files/$korisnik/vector/", 0777);
	chmod("./user_files/$korisnik/vector/", 0777);
}
if(!is_dir  ( "./user_files/$korisnik/Layers/" ))
{
	mkdir("./user_files/$korisnik/Layers/", 0777);
	chmod("./user_files/$korisnik/Layers/", 0777);
}
if(!is_dir  ( "./user_files/$korisnik/Layers/rast/" ))
{
	mkdir("./user_files/$korisnik/Layers/rast/", 0777);
	chmod("./user_files/$korisnik/Layers/rast/", 0777);
}
if(!is_dir  ( "./user_files/$korisnik/Layers/shape/" ))
{
	mkdir("./user_files/$korisnik/Layers/shape/", 0777);
	chmod("./user_files/$korisnik/Layers/shape/", 0777);
}
if(!is_dir  ( "./user_files/$korisnik/meteo/" ))
{
	mkdir("./user_files/$korisnik/meteo", 0777);
	chmod("./user_files/$korisnik/meteo", 0777);
}
if(!is_dir  ( "./user_files/$korisnik/averages/" ))
{
	mkdir("./user_files/$korisnik/averages", 0777);
	chmod("./user_files/$korisnik/averages", 0777);
}

 if(!file_exists($map_file_user))
{
	copy($map_file_userdefault, $map_file_user);
	chmod($map_file_user, 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_live_average.txt"))
{
	copy($WebDir."/userdefault/mois_live_average.txt", $WebDir."/user_files/$korisnik/averages/mois_live_average.txt");
	chmod($WebDir."/user_files/$korisnik/averages/mois_live_average.txt", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_live_".$korisnik."_average.txt"))
{
	copy($WebDir."/userdefault/mois_live_admin_average.txt", $WebDir."/user_files/$korisnik/averages/mois_live_".$korisnik."_average.txt");
	chmod($WebDir."/user_files/$korisnik/averages/mois_live_".$korisnik."_average.txt", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_1h_average.txt"))
{
	copy($WebDir."/userdefault/mois_1h_average.txt", $WebDir."/user_files/$korisnik/averages/mois_1h_average.txt");
	chmod($WebDir."/user_files/$korisnik/averages/mois_1h_average.txt", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_1h_".$korisnik."_average.txt"))
{
	copy($WebDir."/userdefault/mois_1h_admin_average.txt", $WebDir."/user_files/$korisnik/averages/mois_1h_".$korisnik."_average.txt");
	chmod($WebDir."/user_files/$korisnik/averages/mois_1h_".$korisnik."_average.txt", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_10h_average.txt"))
{
	copy($WebDir."/userdefault/mois_10h_average.txt", $WebDir."/user_files/$korisnik/averages/mois_10h_average.txt");
	chmod($WebDir."/user_files/$korisnik/averages/mois_10h_average.txt", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_10h_".$korisnik."_average.txt"))
{
	copy($WebDir."/userdefault/mois_10h_admin_average.txt", $WebDir."/user_files/$korisnik/averages/mois_10h_".$korisnik."_average.txt");
	chmod($WebDir."/user_files/$korisnik/averages/mois_10h_".$korisnik."_average.txt", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_100h_average.txt"))
{
	copy($WebDir."/userdefault/mois_100h_average.txt", $WebDir."/user_files/$korisnik/averages/mois_100h_average.txt");
	chmod($WebDir."/user_files/$korisnik/averages/mois_100h_average.txt", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_100h_".$korisnik."_average.txt"))
{
	copy($WebDir."/userdefault/mois_100h_admin_average.txt", $WebDir."/user_files/$korisnik/averages/mois_100h_".$korisnik."_average.txt");
	chmod($WebDir."/user_files/$korisnik/averages/mois_100h_".$korisnik."_average.txt", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/averages_mois.asc"))
{
	copy($WebDir."/userdefault/averages_mois.asc", $WebDir."/user_files/$korisnik/averages_mois.asc");
	chmod($WebDir."/user_files/$korisnik/averages_mois.asc", 0777);
}





if(!file_exists($WebDir."/user_files/$korisnik/calculate_ros.sh"))
{
	copy($WebDir."/userdefault/calculate_ros.sh", $WebDir."/user_files/$korisnik/calculate_ros.sh");
	chmod($WebDir."/user_files/$korisnik/calculate_ros.sh", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/calculate_spread.sh"))
{
	copy($WebDir."/userdefault/calculate_spread.sh", $WebDir."/user_files/$korisnik/calculate_spread.sh");
	chmod($WebDir."/user_files/$korisnik/calculate_spread.sh", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/calculate_spread_ctd.sh"))
{
	copy($WebDir."/userdefault/calculate_spread_ctd.sh", $WebDir."/user_files/$korisnik/calculate_spread_ctd.sh");
	chmod($WebDir."/user_files/$korisnik/calculate_spread_ctd.sh", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/calculate_spread_res.sh"))
{
	copy($WebDir."/userdefault/calculate_spread_res.sh", $WebDir."/user_files/$korisnik/calculate_spread_res.sh");
	chmod($WebDir."/user_files/$korisnik/calculate_spread_res.sh", 0777);
}

require("setgetFile.php");

setIntoFile ($WebDir."/user_files/$korisnik/calculate_spread_ctd.sh","output=\"\"", "output=\"$WebDir/user_files/$korisnik/raster/spread_rast\"");
setIntoFile ($WebDir."/user_files/$korisnik/calculate_spread_ctd.sh","dsn=\"\"", "dsn=\"$WebDir/user_files/$korisnik/vector/spread_shape\"");

if(!file_exists($WebDir."/user_files/$korisnik/raster/spread_rast.tif"))
{
	copy($WebDir."/userdefault/spread_rast.tif", $WebDir."/user_files/$korisnik/raster/spread_rast.tif");
	chmod($WebDir."/user_files/$korisnik/raster/spread_rast.tif", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/raster/spread_rast.tfw"))
{
	copy($WebDir."/userdefault/spread_rast.tfw", $WebDir."/user_files/$korisnik/raster/spread_rast.tfw");
	chmod($WebDir."/user_files/$korisnik/raster/spread_rast.tfw", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/vector/spread_shape.shp"))
{
	copy($WebDir."/userdefault/spread_shape.shp", $WebDir."/user_files/$korisnik/vector/spread_shape.shp");
	chmod($WebDir."/user_files/$korisnik/vector/spread_shape.shp", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/vector/spread_shape.shx"))
{
	copy($WebDir."/userdefault/spread_shape.shx", $WebDir."/user_files/$korisnik/vector/spread_shape.shx");
	chmod($WebDir."/user_files/$korisnik/vector/spread_shape.shx", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/vector/spread_shape.dbf"))
{
	copy($WebDir."/userdefault/spread_shape.dbf", $WebDir."/user_files/$korisnik/vector/spread_shape.dbf");
	chmod($WebDir."/user_files/$korisnik/vector/spread_shape.dbf", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/wind_dir.asc"))
{
	copy($WebDir."/userdefault/wind_dir.asc", $WebDir."/user_files/$korisnik/wind_dir.asc");
	chmod($WebDir."/user_files/$korisnik/wind_dir.asc", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/wind_speed.asc"))
{
	copy($WebDir."/userdefault/wind_speed.asc", $WebDir."/user_files/$korisnik/wind_speed.asc");
	chmod($WebDir."/user_files/$korisnik/wind_speed.asc", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/wind_dir_temp.asc"))
{
	copy($WebDir."/userdefault/wind_dir_temp.asc", $WebDir."/user_files/$korisnik/wind_dir_temp.asc");
	chmod($WebDir."/user_files/$korisnik/wind_dir_temp.asc", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/wind_speed_temp.asc"))
{
	copy($WebDir."/userdefault/wind_speed_temp.asc", $WebDir."/user_files/$korisnik/wind_speed_temp.asc");
	chmod($WebDir."/user_files/$korisnik/wind_speed_temp.asc", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/mois_live.asc"))
{
	copy($WebDir."/userdefault/mois_live.asc", $WebDir."/user_files/$korisnik/mois_live.asc");
	chmod($WebDir."/user_files/$korisnik/mois_live.asc", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/mois1h.asc"))
{
	copy($WebDir."/userdefault/mois1h.asc", $WebDir."/user_files/$korisnik/mois1h.asc");
	chmod($WebDir."/user_files/$korisnik/mois1h.asc", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/mois10h.asc"))
{
	copy($WebDir."/userdefault/mois10h.asc", $WebDir."/user_files/$korisnik/mois10h.asc");
	chmod($WebDir."/user_files/$korisnik/mois10h.asc", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/mois100h.asc"))
{
	copy($WebDir."/userdefault/mois100h.asc", $WebDir."/user_files/$korisnik/mois100h.asc");
	chmod($WebDir."/user_files/$korisnik/mois100h.asc", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/rm_prev_data.sh"))
{
	copy($WebDir."/userdefault/rm_prev_data.sh", $WebDir."/user_files/$korisnik/rm_prev_data.sh");
	chmod($WebDir."/user_files/$korisnik/rm_prev_data.sh", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/calculate_ros.sh"))
{
	copy($WebDir."/userdefault/calculate_ros.sh", $WebDir."/user_files/$korisnik/calculate_ros.sh");
	chmod($WebDir."/user_files/$korisnik/calculate_ros.sh", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tif"))
{
	copy($WebDir."/userdefault/ros_base.tif", $WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tif");
	chmod($WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tif", 0777);
}
if(!file_exists($WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tfw"))
{
	copy($WebDir."/userdefault/ros_base.tfw", $WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tfw");
	chmod($WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tfw", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/calculate_spread_launch.sh"))
{
	copy($WebDir."/userdefault/calculate_spread_launch.sh", $WebDir."/user_files/$korisnik/calculate_spread_launch.sh");
	chmod($WebDir."/user_files/$korisnik/calculate_spread_launch.sh", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/launch.sh"))
{
	copy($WebDir."/userdefault/launch.sh", $WebDir."/user_files/$korisnik/launch.sh");
	chmod($WebDir."/user_files/$korisnik/launch.sh", 0777);
}

if(!file_exists($WebDir."/user_files/$korisnik/mois_value.asc"))
{
	copy($WebDir."/userdefault/mois_value.asc", $WebDir."/user_files/$korisnik/mois_value.asc");
	chmod($WebDir."/user_files/$korisnik/mois_value.asc", 0777);
}

full_copy( $WebDir."/userdefault/korisnik/", $WebDir_gisrc."/$korisnik/");
//dircopy($WebDir."/userdefault/test/", $WebDir."/user_files/$korisnik/test/", 0);

setIntoFile ($WebDir."/user_files/$korisnik/launch.sh", 
"KORISNIK", "$korisnik");

setIntoFile ($map_file_user, 
"  #Promijeniti raster u user folder
  DATA", "  DATA $WebDir/user_files/$korisnik/raster/spread_rast.tif
");

setIntoFile ($map_file_user, 
"  #Promijeniti vector u user folder
  DATA ", "  DATA $WebDir/user_files/$korisnik/vector/spread_shape.shp
");

	setIntoFile ($map_file_user, 
"  #Promijeniti ros_base u user folder
  DATA", "  DATA $WebDir/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tif
");

if($enableGrass)
{	
	require("grasslib.php");
	setgrassenv($WebDir,$MonImgName);
}
if(!$enableWind)
{
	$enableWindSettings=false;
}
if($enableWind)
{
	require("wind.php");
}
if(!$enableMois)
{
	$enableMoisSettings=false;
}
if($enableMois)
{
	require("mois.php");
}
if($enableSpreadSaveDelete)
{
	require("spreadSaveDelete.php");
}
if($enableSettings)
{
	require("settings.php");
}
if($enableSpread)
{
	require("pozar.php");
}
if($enableROSandDeleteData)
{
	require("rosanddelete.php");
}
if($displaycoord)
{
	require("displaycoord.php");
}
if($enableCameraProfile)
{
	require("cameraprofile.php");
	require("cam_params.php");
}

function click2map ($click_x, $click_y) {
    global $map;
    $e= &$map->extent; //Tip for saving type time
    $x_pct = ($click_x / $map->width);
    $y_pct = 1-($click_y / $map->height);
    $x_map = $e->minx + ( ($e->maxx - $e->minx) * $x_pct);
    $y_map = $e->miny + ( ($e->maxy - $e->miny) * $y_pct);


    return array($x_map, $y_map);
}

//Radi prebacivanja PHP nizova u JS nizove
class array_to_js {
    var $js_arrays;
    function error ($message, $stop = true) {
        echo "<b>array_to_js</b> - FATAL ERROR: ".$message;
        if ($stop) exit;
    }
    function add_array($myarray, $outputvarname, $level = 0) {
        if (isset($this->js_arrays[$outputvarname]))
            $this->error('This Array has been added more than once: "'.$outputvarname.'"');
        for ($i=0; $i<$level; $i++) $pre .= '    ';
        $this->js_arrays[$outputvarname] .= $pre.$outputvarname.' = new Object();'."\n";
        foreach ($myarray as $key => $value) {
            if (!is_int($key))
                $key = '"'.addslashes($key).'"';
            if (is_array($value))
                $this->add_array($value, $outputvarname.'['.$key.']', $level+1);
            else {
                $this->js_arrays[$outputvarname] .= $pre.'    '.$outputvarname.'['.$key.']'.' = ';

                if (is_int($value) or is_float($value))
                    $this->js_arrays[$outputvarname] .= $value;
                elseif (is_bool($value))
                    $this->js_arrays[$outputvarname] .= $value ? "true" : "false";
                elseif (is_string($value))
                    $this->js_arrays[$outputvarname] .= '"'.addslashes($value).'"';
                else
                    $this->error('Unknown Datatype for "'.$outputvarname.'['.$key.']"');
                $this->js_arrays[$outputvarname] .= ";\n";
            }
        }
    }
    function output_all($scripttag = true) {
        if ($scripttag) $outputstring = '<script language="JavaScript" type="text/javascript">'."\n";
        foreach ($this->js_arrays as $array)
            $outputstring .= $array;
        if ($scripttag) $outputstring .= '</script>'."\n";

        return $outputstring;
    }
} 

//Stara funkcija pokretanja procsa u linuxu u pozdarini
function run_in_background($Command, $Priority = 0)
{
    if($Priority)
        $PID = shell_exec("nohup nice -n $Priority $Command 2> /dev/null & echo $!");
    else
	$PID = shell_exec("nohup $Command > /dev/null 2> /dev/null & echo $!");
        //$PID = shell_exec("nohup $Command 2> /dev/null & echo $!");
    return($PID);
}

//Stara funkcija provjere izvodi li se proces
function is_process_running($PID)
{
    exec("ps $PID", $ProcessState);
    return(count($ProcessState) >= 2);
}
  ?>

<?php


//Dohvaćanje podataka za osmatracnice
$shp = new ShapeFile("../gis_data_temp_istra/osmatracnice.shp", ""); 

$i = 0;
	while ($record = $shp->getNext()) {
		$dbf_data = $record->getDbfData();
		$shp_data = $record->getShpData();
		$projInObj =ms_newprojectionobj("proj=tmerc,ellps=WGS84,units=m,lon_0=15,k=0.9999,x_0=6500000,y_0=0,no_defs");
		$projOutObj = ms_newprojectionObj ("proj=longlat,ellps=WGS84,no_defs" );
		if($dbf_data[NAME]!="")
		{

			$osm_ime[$i]=$dbf_data[NAME];
			$osm_elevation[$i]=$dbf_data[ELEVATION];
			$osm_jvp[$i]=$dbf_data[JVP];
			$osm_visibility[$i]=$dbf_data[VISIBILITY];
			$osm_area[$i]=$dbf_data[AREA];
			$poPoint = ms_newpointobj();
			if(!($shp_data[x]=="" || $shp_data[x]==null || $shp_data[y]=="" || $shp_data[y]==null))
			{
			$osm_x_latlon[$i]=$shp_data[x];
			$osm_y_latlon[$i]=$shp_data[y];
			}
        	$poPoint->setXY($shp_data[x], $shp_data[y]);
        	$poPoint->project($projInObj, $projOutObj);	
			$osm_x[$i]=$poPoint->x;
			$osm_y[$i]=$poPoint->y;
			$osm_id[$i]=$dbf_data[ID];
			//echo $i." - ".$osm_id[$i]." - ".$osm_ime[$i]."<br>";
		/*
			$rez = $pok_baza->execute("SELECT name, region, host(ip_camera), host(ip_meteo), host(ip_meteo_reset), host(ip_server), https_adresa, id_region  FROM region_system WHERE id = $osm_id[$i]");
			$myrez = pg_fetch_row($rez);
			$osm_ip_camera[$i]= $myrez[2];
			echo $osm_ip_camera[$i]."<br>";
			*/
		}
		$i++;
	}

//prebacivanje php nizova u js nizove

$myconverter = new array_to_js(); 
$myconverter->add_array($osm_x_latlon, "osm_x_latlon"); 
$myconverter->add_array($osm_y_latlon, "osm_y_latlon"); 
$myconverter->add_array($osm_ime, "osm_ime"); 
$myconverter->add_array($osm_x, "osm_x"); 
$myconverter->add_array($osm_y, "osm_y"); 
$myconverter->add_array($osm_elevation, "osm_elevation"); 
$myconverter->add_array($osm_jvp, "osm_jvp"); 
$myconverter->add_array($osm_visibility, "osm_visibility"); 
$myconverter->add_array($osm_area, "osm_area"); 
$myconverter->add_array($osm_id, "osm_id");
//$myconverter->add_array($osm_ip_camera, "osm_ip_camera");

?>

    <script type="text/javascript">

//neki slojevi mojraju biti globalno deklarirani radi funkcionalnosti
		var gphy;
        var map, popup, popup_corine, popup_opacity, selectControl,selectControl2,selectControl3,selectControl4,selectControl5,selectControl6;
		var reljef;
		var content;
        var maxOpacity = 0.9;
        var minOpacity = 0.1;
        var markers, marker;
		var feature = [];
		var marker = [];
		var visLayer = false;

//MIRIP slojevi
	var mirip;
	var Vegetacija;
	var FWI;
	var Naselja;
	var windaspect; //"Smjer vjetra i nagib terena"
	var Ceste;
	var Pruge; //Udaljenost od pruga
	var Dalekovodi;
	var Pozar; //Povijest pozara (2008)
	var Otpad;
	var Minirano;

// promjena prozirnosti, na temelju informacije iz popupa se promijeni prozirnost
        function changeOpacity(byOpacity, layerid) {
         	for ( var i in map.layers )
			{
				if( map.layers[i].id == layerid)
				{

					if(OpenLayers.Util.getElement('opacity'+i).value=="null") {OpenLayers.Util.getElement('opacity'+i).value=0.9;}
					var newOpacity = (parseFloat(OpenLayers.Util.getElement('opacity'+i).value) + byOpacity).toFixed(1);
					newOpacity = Math.min(maxOpacity,
										  Math.max(minOpacity, newOpacity));
					OpenLayers.Util.getElement('opacity'+i).value = newOpacity;
					map.layers[i].setVisibility(true);
					map.layers[i].setOpacity(newOpacity);
				}
			}
		 
        }
//postavi vidljivost layera 
		function turnLayerOn(layerid) {
         	for ( var i in map.layers )
			{
				if( map.layers[i].id == layerid)
				{
					map.layers[i].setVisibility(true);
				}
			}
		 
        }
//postavi vidljivost layera 				
		function turnLayerOff(layerid) {
         	for ( var i in map.layers )
			{
				if( map.layers[i].id == layerid)
				{
					map.layers[i].setVisibility(false);
				}
			}
		 
        }
//kad se ugasi popup (vrijedi za neke popupe)
	   function onPopupClose(evt) {
            selectControl.unselectAll();
			selectControl2.unselectAll();
			selectControl3.unselectAll();
			selectControl4.unselectAll();
			selectControl5.unselectAll();
			selectControl6.unselectAll();
			popup_opacity.destroy();

        }
	
//stvaranje opacity popupa u centar trenutnog pogleda
		 function addOpacityPopup() {    
		  var content_opacity = "<h1 style=\"font-size:22px;text-align:center\"> Kontrola prozirnosti </h1><h2>Osnovni slojevi:</h2><table style=\"width:100%;border:1px solid #000080;padding:2px;\">";

			for ( var i in map.layers )
			{
				if((map.layers[i].isBaseLayer))
				{
					var prozirnost = map.layers[i].opacity;
					if (map.layers[i].opacity=="null" || map.layers[i].opacity==null)
					{
						prozirnost = 0.9;
					}

					content_opacity += "<tr><td style=\"background-color:#cccccc;padding:2px;\">" + map.layers[i].name + "</td><td style=\"text-align: right;background-color:#eeeeee;padding:2px\"><i>Nije omogućeno</i></td></tr>";
				}
			}

			content_opacity += "</table><h2>Slojevi:</h2><table style=\"width:100%;border:1px solid #000080;padding:2px;\">";

			for ( var i in map.layers )
			{
				if(!(map.layers[i].isBaseLayer))
				{


					var prozirnost = map.layers[i].opacity;
					if (map.layers[i].opacity=="null" || map.layers[i].opacity==null)
					{
						prozirnost = 0.9;
					}

					content_opacity += "<tr><td style=\"background-color:#cccccc;padding:2px;\">" + map.layers[i].name + "</td><td style=\"text-align: center;background-color:#eeeeee;padding:2px\">  <a title=\"decrease opacity\" href=\"javascript: changeOpacity(-0.1, '" +  map.layers[i].id +"');\">&lt;&lt;</a><input id=\"opacity" + i +"\" type=\"text\" value=\"" + prozirnost + "\" size=\"3\" disabled=\"true\" /><a title=\"increase opacity\" href=\"javascript: changeOpacity(0.1, '" +  map.layers[i].id +"');\">&gt;&gt;</a></td><td style=\"text-align: center;background-color:#eeeeee;padding:2px\"><a title=\"on\" href=\"javascript: turnLayerOn('" +  map.layers[i].id +"');\"> ON</a></td><td style=\"text-align: center;background-color:#eeeeee;padding:2px\"><a title=\"on\" href=\"javascript: turnLayerOff('" +  map.layers[i].id +"');\"> OFF</a></td></tr>";
				}
			}

			content_opacity += "</table>";




           popup_opacity = new OpenLayers.Popup.FramedCloud("chicken", 
                                     map.getCenter(),
                                     new OpenLayers.Size(400,200), //zanemarivo
                                     content_opacity,
                                     null, true, onPopupClose);
						 
			popup_opacity.autoSize=false;
            popup_opacity.setSize(new OpenLayers.Size(450,600)); //ovdje se definira prava vrijednost
            map.addPopup(popup_opacity);
                                                             
        }

//Kad se odabere corine
        function onFeatureSelect(event) {
			
            var feature = event.feature;
			var content = "<h2>"+feature.attributes.name + "</h2>" + feature.attributes.description;
		//	alert(event.feature.attributes);

       /*    if (content.search("<script") != -1) {
                content = "Content contained Javascript! Escaped content below.<br />" + content.replace(/</g, "&lt;");
            }*/
	
           popup_corine = new OpenLayers.Popup.FramedCloud("chicken", 
                                     feature.geometry.getBounds().getCenterLonLat(),
                                     new OpenLayers.Size(400,200), //zanemarivo
                                     content,
                                     null, true, onPopupClose);
			popup_corine.autoSize=false;
            popup_corine.setSize(new OpenLayers.Size(400,200)); //ovdje se definira prava vrijednost
            feature.popup_corine = popup_corine;
            map.addPopup(popup_corine);
        }

//Kad se klikne negdje drugdi na kartu (ne vise na marker
        function onFeatureUnselect(event) {
            var feature = event.feature;
            if(feature.popup_corine) {
                map.removePopup(feature.popup_corine);
                feature.popup_corine.destroy();
                delete feature.popup_corine;
            }
        }

//Glavna funkcija
        function init(){
			
			//opcije za map
			var options = {
			div: "map",
			projection: new OpenLayers.Projection("EPSG:900913"),
			displayProjection: new OpenLayers.Projection("EPSG:900913"),
			units: "m",
			numZoomLevels: 16,
			maxResolution: 16543.0339,
			maxExtent: new OpenLayers.Bounds(15.27, 43.10, 17.1, 44.52).transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913")) //Ovdje se samo odreduju krajnje granice, extent se postavlja kasnije

		};

		


			map = new OpenLayers.Map('map', options);
		
            // kreiranje Google layera
            var gmap = new OpenLayers.Layer.Google(
                "Google Streets",
                {'sphericalMercator': true, format: 'image/png'}
            );
            var gsat = new OpenLayers.Layer.Google(
                "Google Satellite",
                {type: G_SATELLITE_MAP, 'sphericalMercator': true, format: 'image/png'}
            );
            var ghyb = new OpenLayers.Layer.Google(
                "Google Hybrid",
                {type: G_HYBRID_MAP, 'sphericalMercator': true, format: 'image/png'}
            );
		    gphy = new OpenLayers.Layer.Google(
                "Google Physical",
                {type: G_PHYSICAL_MAP, 'sphericalMercator': true, format: 'image/png'}
            );

	

	// Bitan dodatak je &FORMAT=image%2Fpng& jer time se omogućuje prozirnost na slikama (ne opacity, neg prozirna boja)
			if(location.protocol == "https:")
			{
			var BaseURL = "https://<? echo $ip_https ?>/cgi-bin/mapserv?map=<?echo $mapfile;?>&FORMAT=image%2Fpng&";
			}
			else
			{
			var BaseURL = "http://<? echo $ip_servera ?>/cgi-bin/mapserv?map=<?echo $mapfile;?>&FORMAT=image%2Fpng&";
			}

			
			
			
	
// definiranje raznih slojeva
            reljef = new OpenLayers.Layer.WMS(
                "Reljef",
                BaseURL,
                {'layers': 'reljef'},
                {
                    format: 'image/png','opacity': 0.8, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			reljef.setVisibility(false);

		 var Aspect = new OpenLayers.Layer.WMS(
                "Aspect",
                BaseURL,
                {'layers': 'Aspect'},
                {
                    format: 'image/png','opacity': 0.8, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Aspect.setVisibility(false);

		 var Slope = new OpenLayers.Layer.WMS(
                "Slope",
                BaseURL,
                {'layers': 'Slope'},
                {
                    format: 'image/png','opacity': 0.8, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Slope.setVisibility(false);

		 Corine = new OpenLayers.Layer.WMS(
                "Corine - Rasterska verzija",
                BaseURL,
                {'layers': 'corine_shape'},
                {
                    format: 'image/png','opacity': 0.8, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Corine.setVisibility(false);



			var shape = new OpenLayers.Layer.WMS(
                "Vektor pozara",
                BaseURL,
                {'layers': 'spread_vector'},
                {
                    format: 'image/png','opacity': 0.8, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			shape.setVisibility(false);

			var raster = new OpenLayers.Layer.WMS(
                "Raster pozara",
                "https://<? echo $ip_https ?>/cgi-bin/mapserv?map=<?echo $mapfile;?>&FORMAT=image%2Fpng&",
                {'layers': 'spread_raster'},
                {
                    format: 'image/png','opacity': 0.8, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			raster.setVisibility(false);


//Za razliku od drugih, ovdje se otvara gis_cgi_wind_oo.php kojim se kontrolira trenutni vjetar

			var trenutniWind = new OpenLayers.Layer.WMS(
			"Vjetar trenutni",
			"http://<? echo $ip_servera ?>/gis/gis_cgi_wind_oo.php?map=/var/www/gis2/gis/webgiszupanija.map&vjetar=trenutni&FORMAT=image%2Fpng&",
			{'layers': 'wind'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
			);

		

			trenutniWind.setVisibility(false);

			var vlastitiWind = new OpenLayers.Layer.WMS(
			"Vjetar vlastiti",
			"https://<? echo $ip_https ?>/gis2/gis/gis_cgi_wind_oo.php?map=/var/www/gis2/gis/webgiszupanija.map&vjetar=vlastiti&FORMAT=image%2Fpng&",
			{'layers': 'wind'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
			);

		var corine1 = new OpenLayers.Layer.GML(
        "Corine - Vektor NW",
        "../gis_data_temp_istra/corine_A1.kml" ,
        {projection: new OpenLayers.Projection("EPSG:4326"), formatOptions: {extractAttributes: true, extractStyles: true, maxDepth: 2},
        format: OpenLayers.Format.KML}
    )
		corine1.setVisibility(false);

	    var corine2 = new OpenLayers.Layer.GML(
        "Corine - Vektor N",
        "../gis_data_temp_istra/corine_A2.kml" ,
        {projection: new OpenLayers.Projection("EPSG:4326"), formatOptions: {extractAttributes: true, extractStyles: true, maxDepth: 2},
        format: OpenLayers.Format.KML}
    )
				corine2.setVisibility(false);
		    var corine3 = new OpenLayers.Layer.GML(
        "Corine - Vektor NE",
        "../gis_data_temp_istra/corine_A3.kml" ,
        {projection: new OpenLayers.Projection("EPSG:4326"), formatOptions: {extractAttributes: true, extractStyles: true, maxDepth: 2},
        format: OpenLayers.Format.KML}
    )
				corine3.setVisibility(false);
	    var corine4= new OpenLayers.Layer.GML(
        "Corine - Vektor SW",
        "../gis_data_temp_istra/corine_B1.kml" ,
        {projection: new OpenLayers.Projection("EPSG:4326"), formatOptions: {extractAttributes: true, extractStyles: true, maxDepth: 2},
        format: OpenLayers.Format.KML}
    )
		corine4.setVisibility(false);
	  var corine5 = new OpenLayers.Layer.GML(
        "Corine - Vektor S",
        "../gis_data_temp_istra/corine_B2.kml" ,
        {projection: new OpenLayers.Projection("EPSG:4326"), formatOptions: {extractAttributes: true, extractStyles: true, maxDepth: 2},
        format: OpenLayers.Format.KML}
    )
		corine5.setVisibility(false);
	  var corine6 = new OpenLayers.Layer.GML(
        "Corine - Vektor SE",
        "../gis_data_temp_istra/corine_B3.kml" ,
        {projection: new OpenLayers.Projection("EPSG:4326"), formatOptions: {extractAttributes: true, extractStyles: true, maxDepth: 2},
        format: OpenLayers.Format.KML}
    )
		corine6.setVisibility(false);


			vlastitiWind.setVisibility(false);

			markers = new OpenLayers.Layer.Markers( "Markers" );
			

			var size = new OpenLayers.Size(10,17);
            var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);



			<? echo $myconverter->js_arrays[osm_x_latlon]; ?>
			<? echo $myconverter->js_arrays[osm_y_latlon]; ?>
			<? echo $myconverter->js_arrays[osm_x]; ?>
			<? echo $myconverter->js_arrays[osm_y]; ?>
			<? echo $myconverter->js_arrays[osm_ime]; ?>
			<? echo $myconverter->js_arrays[osm_elevation]; ?>
			<? echo $myconverter->js_arrays[osm_jvp]; ?>
			<? echo $myconverter->js_arrays[osm_visibility]; ?>
			<? echo $myconverter->js_arrays[osm_area]; ?>
			<? echo $myconverter->js_arrays[osm_id]; ?>


            visLayer = new OpenLayers.Layer.WMS(
                "visLayer",
                "https://<? echo $ip_https ?>/cgi-bin/mapserv?map=<?echo $mapfile;?>&FORMAT=image%2Fpng&",
                {'layers': 'visZbevnica'},
                {
                    format: 'image/png','opacity': 0.8, 'transparent': true, 
                    'isBaseLayer': false,
					'displayInLayerSwitcher': false

                }
            );


			visLayer.setVisibility(false);			
			visLayer.display(false);
//MIRIP
/*
	var Vegetacija;
	var FWI;
	var Naselja;
	var windaspect; //"Smjer vjetra i nagib terena"
	var Ceste;
	var Pruge; //Udaljenost od pruga
	var Dalekovodi;
	var Pozar; //Povijest pozara (2008)
	var Otpad;
	var Minirano;
	*/

            mirip = new OpenLayers.Layer.WMS(
                "MIRIP",
                BaseURL,
                {'layers': 'MIRIP'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			mirip.setVisibility(true);

		    Vegetacija = new OpenLayers.Layer.WMS(
                "Vegetacija",
                BaseURL,
                {'layers': 'Vegetacija'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Vegetacija.setVisibility(false);

			FWI = new OpenLayers.Layer.WMS(
                "FWI",
                BaseURL,
                {'layers': 'FWI'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			FWI.setVisibility(false);


			Naselja = new OpenLayers.Layer.WMS(
                "Udaljenost od naselja",
                BaseURL,
                {'layers': 'Udaljenost od naselja'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Naselja.setVisibility(false);

			windaspect = new OpenLayers.Layer.WMS(
                "Smjer vjetra i nagib terena",
                BaseURL,
                {'layers': 'Smjer vjetra i nagib terena'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			windaspect.setVisibility(false);

			Ceste = new OpenLayers.Layer.WMS(
                "Ceste",
                BaseURL,
                {'layers': 'Ceste'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Ceste.setVisibility(false);

			Pruge = new OpenLayers.Layer.WMS(
                "Udaljenost od pruga",
                BaseURL,
                {'layers': 'Udaljenost od pruga'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Pruge.setVisibility(false);

			Dalekovodi = new OpenLayers.Layer.WMS(
                "Dalekovodi",
                BaseURL,
                {'layers': 'Dalekovodi'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Dalekovodi.setVisibility(false);

			Pozar = new OpenLayers.Layer.WMS(
                "Povijest pozara (2008)",
                BaseURL,
                {'layers': 'Povijest pozara (2008)'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Pozar.setVisibility(false);

			Otpad = new OpenLayers.Layer.WMS(
                "Otpad",
                BaseURL,
                {'layers': 'Otpad'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Otpad.setVisibility(false);

			Minirano = new OpenLayers.Layer.WMS(
                "Minirano",
                BaseURL,
                {'layers': 'Minirano'},
                {
                    format: 'image/png','opacity': 0.9, 'transparent': true, 
                    'isBaseLayer': false
                }
            );

			Minirano.setVisibility(false);

//Markeri i njihovi popupi za osmatracnice

			for( var brojac=0; brojac <= <?echo $i; ?>; brojac++)
			{
				feature[brojac] = new OpenLayers.Feature(ghyb, new OpenLayers.LonLat(osm_x[brojac],osm_y[brojac]).transform(new OpenLayers.Projection("EPSG:4326"), map.projection));
				AutoSizeFramedCloud = OpenLayers.Class(OpenLayers.Popup.FramedCloud, {'autoSize': true});    
				popupClass = AutoSizeFramedCloud;
				feature[brojac].popupClass = popupClass;
			
				marker[brojac] = feature[brojac].createMarker();
				//Ikona markera spremljena u /var/www/js/img/marker.png		
				marker[brojac].icon.size=new OpenLayers.Size(12,19);
				marker[brojac].ime = osm_ime[brojac];
				marker[brojac].osm_x_latlon = osm_x_latlon[brojac];
				marker[brojac].osm_y_latlon = osm_y_latlon[brojac];
				marker[brojac].osm_x = osm_x[brojac];
				marker[brojac].osm_y = osm_y[brojac];

				marker[brojac].osm_elevation = osm_elevation[brojac];
				if(osm_jvp[brojac]=="0") marker[brojac].osm_jvp = "Kamera";
				if(osm_jvp[brojac]=="1") marker[brojac].osm_jvp = "Centar";
				if(osm_jvp[brojac]=="2") marker[brojac].osm_jvp = "Čvorište";
				marker[brojac].osm_visibility = osm_visibility[brojac];
				marker[brojac].osm_area = osm_area[brojac];
				marker[brojac].osm_id = osm_id[brojac];
				//marker[brojac].osm_ident_name = osm_ident_name[brojac];
				//marker[brojac].osm_id_reg = osm_id_reg[brojac];

				marker[brojac].identifikator = brojac;

	            markers.addMarker(marker[brojac]);


			
// Kako ce izgledati popup, i kako ce se ponasati
				var markerClick = function (evt) {
						

						var content = "<h1 style=\"font-size:22px;text-align:center\">"+this.osm_id+". "+this.ime+"</h1>"+ 
						"<table style=\"width:100%;border:1px solid #000080;padding:2px;\">"+						
						"<tr><td style=\"background-color:#cccccc;padding:2px;\">LatLon koordinate: </td><td style=\"text-align: right;background-color:#eeeeee;padding:2px\">"+this.osm_x+", "+this.osm_y+"</td></tr>"+
						"<tr><td style=\"background-color:#cccccc;padding:2px;\">Transverse Mercator: </td><td style=\"text-align: right;background-color:#eeeeee;padding:2px\">"+this.osm_x_latlon+", "+this.osm_y_latlon+"</td></tr>"+			
						"<tr><td style=\"background-color:#cccccc;padding:2px;\">Nadmorska visina: </td><td style=\"text-align: right;background-color:#eeeeee;padding:2px \">"+this.osm_elevation+"m</td></tr>"+
						"<tr><td style=\"background-color:#cccccc;padding:2px;\">Područje: </td><td style=\"text-align: right;background-color:#eeeeee;padding:2px \">"+this.osm_area+"</td></tr>"+
						"<tr><td style=\"background-color:#cccccc;padding:2px;\">Tip objekta: </td><td style=\"text-align: right;background-color:#eeeeee;padding:2px \">"+this.osm_jvp+"</td></tr>"+
						"<tr><td style=\"background-color:#cccccc;padding:2px;\">Vidljivost: </td><td style=\"text-align: center;background-color:#eeeeee;padding:2px \"><input type=\"button\" value=\"Uključi\" onclick=\"visibility_on('"+this.osm_visibility+"');\">&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Isključi\" onclick=\"visibility_off() \"></td></tr>"+	
						"</table>";

						if (popup == null) {
						popup = feature[this.identifikator].createPopup(true);
						popup.updatePosition();
					    popup.setContentHTML(content);
						markers.map.addPopup(popup);
						popup.setSize(new OpenLayers.Size(400,250));
						popup.toggle();
						} else {	
						popup = feature[this.identifikator].createPopup(true);
						popup.updatePosition();
					    popup.setContentHTML(content);
						markers.map.addPopup(popup);						
						popup.setSize(new OpenLayers.Size(400,250));
						popup.toggle();
						}
						OpenLayers.Event.stop(evt);
				}

			 marker[brojac].events.register("mousedown", marker[brojac], markerClick);



			}





			var tParams = { format: 'image/png'};
			reljef.mergeNewParams(tParams);
			shape.mergeNewParams(tParams);

			
		    map.addLayers([gphy, gmap, gsat, ghyb, reljef, Aspect, Slope, trenutniWind]);
			//MIRIP
			/*
	var Vegetacija;
	var FWI;
	var Naselja;
	var windaspect; //"Smjer vjetra i nagib terena"
	var Ceste;
	var Pruge; //Udaljenost od pruga
	var Dalekovodi;
	var Pozar; //Povijest pozara (2008)
	var Otpad;
	var Minirano;
	*/
//			map.addLayers([mirip, Vegetacija, FWI, Naselja, windaspect, Ceste, Pruge, Dalekovodi, Pozar, Otpad, Minirano]);
		map.addLayers([mirip, Vegetacija, FWI, Naselja, windaspect, Ceste, Pruge, Dalekovodi, Pozar, Otpad, Minirano]);
			map.addLayer(visLayer);
			map.addLayer(markers);
			map.addLayer(trenutniWind);

//dodavanje kontrola openlayersa


//, CORINE moze biti ukljucen samo jedan odjednom, dosta koda da se to ostvari

			selectControl = new OpenLayers.Control.SelectFeature(corine1,
                {
					multiple: false,
                    clickout: true, toggle: false, hover: false
                }
            );
			selectControl2 = new OpenLayers.Control.SelectFeature(corine2,
                {
					multiple: false,
                    clickout: true, toggle: false, hover: false
                }
            );
			selectControl3 = new OpenLayers.Control.SelectFeature(corine3,
                {
					multiple: false,
                    clickout: true, toggle: false, hover: false
                }
            );
			selectControl4 = new OpenLayers.Control.SelectFeature(corine4,
                {
					multiple: false,
                    clickout: true, toggle: false, hover: false
                }
            );
			selectControl5 = new OpenLayers.Control.SelectFeature(corine5,
                {
					multiple: false,
                    clickout: true, toggle: false, hover: false
                }
            );
			selectControl6 = new OpenLayers.Control.SelectFeature(corine6,
                {
					multiple: false,
                    clickout: true, toggle: false, hover: false
                }
            );

			
            map.addControl(selectControl);
            map.addControl(selectControl2);
            map.addControl(selectControl3);
            map.addControl(selectControl4);
            map.addControl(selectControl5);
            map.addControl(selectControl6);
            selectControl.activate();

			 corine1.events.on({
                "featureselected": onFeatureSelect,
                "featureunselected": onFeatureUnselect
            });
			corine2.events.on({
                "featureselected": onFeatureSelect,
                "featureunselected": onFeatureUnselect
            });
			 corine3.events.on({
                "featureselected": onFeatureSelect,
                "featureunselected": onFeatureUnselect
            });
			corine4.events.on({
                "featureselected": onFeatureSelect,
                "featureunselected": onFeatureUnselect
            });
			 corine5.events.on({
                "featureselected": onFeatureSelect,
                "featureunselected": onFeatureUnselect
            });
			corine6.events.on({
                "featureselected": onFeatureSelect,
                "featureunselected": onFeatureUnselect
            });


corine1.events.register('visibilitychanged', corine1, function (e) {
					if(corine1.visibility==true)
					{
								if(corine2.visibility==true)
								corine2.setVisibility(false);
								if(corine3.visibility==true)
								corine3.setVisibility(false);
								if(corine4.visibility==true)
								corine4.setVisibility(false);
								if(corine5.visibility==true)
								corine5.setVisibility(false);
								if(corine6.visibility==true)
								corine6.setVisibility(false);
								selectControl.activate();
					}
         });
corine2.events.register('visibilitychanged', corine1, function (e) {
					if(corine2.visibility==true)
					{
								if(corine1.visibility==true)
								corine1.setVisibility(false);
								if(corine3.visibility==true)
								corine3.setVisibility(false);
								if(corine4.visibility==true)
								corine4.setVisibility(false);
								if(corine5.visibility==true)
								corine5.setVisibility(false);
								if(corine6.visibility==true)
								corine6.setVisibility(false);
								selectControl2.activate();
					}
         });
corine3.events.register('visibilitychanged', corine3, function (e) {
					if(corine3.visibility==true)
					{
								if(corine1.visibility==true)
								corine1.setVisibility(false);
								if(corine2.visibility==true)
								corine2.setVisibility(false);
								if(corine4.visibility==true)
								corine4.setVisibility(false);
								if(corine5.visibility==true)
								corine5.setVisibility(false);
								if(corine6.visibility==true)
								corine6.setVisibility(false);
								selectControl3.activate();
					}
         });
corine4.events.register('visibilitychanged', corine4, function (e) {
					if(corine4.visibility==true)
					{
								if(corine1.visibility==true)
								corine1.setVisibility(false);
								if(corine2.visibility==true)
								corine2.setVisibility(false);
								if(corine3.visibility==true)
								corine3.setVisibility(false);
								if(corine5.visibility==true)
								corine5.setVisibility(false);
								if(corine6.visibility==true)
								corine6.setVisibility(false);
								selectControl4.activate();
					}
         });
corine5.events.register('visibilitychanged', corine5, function (e) {
					if(corine5.visibility==true)
					{
								if(corine1.visibility==true)
								corine1.setVisibility(false);
								if(corine2.visibility==true)
								corine2.setVisibility(false);
								if(corine3.visibility==true)
								corine3.setVisibility(false);
								if(corine4.visibility==true)
								corine4.setVisibility(false);
								if(corine6.visibility==true)
								corine6.setVisibility(false);
								selectControl5.activate();
					}
         });
corine6.events.register('visibilitychanged', corine6, function (e) {
					if(corine6.visibility==true)
					{
								if(corine1.visibility==true)
								corine1.setVisibility(false);
								if(corine2.visibility==true)
								corine2.setVisibility(false);
								if(corine3.visibility==true)
								corine3.setVisibility(false);
								if(corine4.visibility==true)
								corine4.setVisibility(false);
								if(corine5.visibility==true)
								corine5.setVisibility(false);
								selectControl6.activate();
					}
         });



/****************
DEFInIRANJE EXTeNTA
*****************/

			map.setCenter( new OpenLayers.LonLat(16.47,43.59).transform(new OpenLayers.Projection("EPSG:4326"), map.projection),10);

//ostatak kontrola

            /*map.addControl( new OpenLayers.Control.LayerSwitcher(),
							new OpenLayers.Control.ScaleLine(),
							new OpenLayers.Control.MousePosition());*/
			
			map.addControl(new OpenLayers.Control.Navigation());
			map.addControl(new OpenLayers.Control.PanZoomBar());
			map.addControl(new OpenLayers.Control.LayerSwitcher({'ascending':false}));
			map.addControl(new OpenLayers.Control.ScaleLine
										(
											{
												div: document.getElementById("scalebar"),
												minWidth: 150,
								                maxWidth: 250,
												displaySystem: "metric"
											}
										)
									);


			map.addControl(new OpenLayers.Control.MousePosition({
			div: document.getElementById("mouseposition"),
			prefix: "Koordinate Lat Lon: (", separator: ",", suffix: ")",
			displayProjection: new OpenLayers.Projection("EPSG:4326") 
			}));

			
			map.addControl(new OpenLayers.Control.KeyboardDefaults());
	
			var EPSG4326 = new OpenLayers.Projection("EPSG:4326");
			var EPSG900913 = new OpenLayers.Projection("EPSG:900913");
			var bounds = map.getExtent().clone();
			bounds = bounds.transform(EPSG900913, EPSG4326);

// P.S. EPSG:4326 - latlon, EPSG:900913 - Google
			
        }

//Vidljivosti za pojedniu lokaciju
		function visibility_on(lokacija)
		{
			lokacija = lokacija.replace(/^\s+|\s+$/g, '') ;
		
			if(visLayer.visibility==false)
				visLayer.setVisibility(true);
			else
				visLayer.setVisibility(false);

				visLayer.destroy();
			    visLayer = new OpenLayers.Layer.WMS(
                "visLayer",
                "http://<? echo $ip_servera ?>/cgi-bin/mapserv?map=<?echo $mapfile;?>&FORMAT=image%2Fpng&",
                {'layers': lokacija},
                {
                    format: 'image/png','opacity': 0.8, 'transparent': true, 
                    'isBaseLayer': false,
					'displayInLayerSwitcher': false

                }
            );
			map.addLayers([visLayer]);
			visLayer.setZIndex(1);
			visLayer.setVisibility(true);			

		}

		function visibility_off()
		{
				visLayer.setVisibility(false);
		}


    </script>
  </head>

  <body onload="init()">

    <div id="tags"></div>

    <div id="map" style="width: 930px;height: 800px;border: 1px solid #ccc;"></div>
	<div style="background-color: #00008B; width: 932px; text-align: center;" onclick="addOpacityPopup()"><span style="color: #ffffff; font-size: 14;">Kontrola prozirnosti<b></div>

<br />
<table width="700">
<tr>
<td><div id="mouseposition"></div></td><td align="right"><div id="scalebar"></div></td>
</tr>
</table>

<form id="myform" action="" method="post" enctype="multipart/form-data" name="myform">

<input type="hidden" value="5" size="3" id="slider_value" name="slider_value"/>





</form>




  </body>
</html>
