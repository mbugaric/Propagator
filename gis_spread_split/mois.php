<?php 
//ini_set('memory_limit', '512M');	
/*ini_set('display_errors', 'On');
error_reporting(E_ALL); */

include_once("db_functions.php");
include_once("postavke_dir_gis.php");
include_once("$meteoArchiveDir/getMeteoDataHolistic_nonShell.php");

require("rosUpdate.php");
require("./js/sajax-0.12/php/Sajax.php");
sajax_init();
sajax_export("insertValueToCalculateROS");
sajax_handle_client_request();

?>

<script>

//Poneke PHP varijable se moraju prebaciti u JS varijable radi sajax-a
WebDir = "<?php echo $WebDir; ?>" ;
korisnik = "<?php echo $_GET["kor"]; ?>";
<?php
sajax_show_javascript();
?>


function notif(text)
{
	$(".notif").remove();
	$("body").append('<span class="notif" style="font-size:10px; position: absolute; top: 350px;">'+text+'</span>');
}

function notifAndClose(text)
{
	$(".notif").remove();
	$("body").append('<span class="notif" style="font-size:10px; position: absolute; top: 350px;">'+text+'</span>');
	//x_insertValueToCalculateROS(WebDir, korisnik, 1, function(){});
	x_insertValueToCalculateROS(WebDir, korisnik, 1, "Albini_custom", function(){});
	x_insertValueToCalculateROS(WebDir, korisnik, 1, "Scott_custom", function(){});
	x_insertValueToCalculateROS(WebDir, korisnik, 1, "Albini_default", function(){});
	x_insertValueToCalculateROS(WebDir, korisnik, 1, "Scott_default", function(){});
	setTimeout(function(){window.close();}, 2000);
	
}

</script>

<?php
//********************************************************************************************
// Sredjivanje postavki vlage, unosenje podataka i slicno
//********************************************************************************************

function run_in_background2($Command, $Priority = 0)
{
    if($Priority)
        $PID = shell_exec("nohup nice -n $Priority $Command 2> /dev/null & echo $!");
    else
	$PID = shell_exec("nohup $Command > /dev/null 2> /dev/null & echo $!");
        //$PID = shell_exec("nohup $Command 2> /dev/null & echo $!");
    return($PID);
}

function getAverageFromAverageAsc($filename)
{
	$average=-9999;
	$fh2 = fopen($filename, 'r') or die("can't open file $filename");

	$windData="";
	for($i=0;$i<6;$i++)
	{
  		//$windData .= fread($fh2, 8192);
		$windData[$i] = fgets($fh2);
	}
	$windData="";
	$windData = fgets($fh2);

	return $windData;
	
}

//**************************************
//Izvodi li se proces (pokrenut u pozadini)
//**************************************
function is_process_running2($PID)
{
    exec("ps $PID", $ProcessState);
    return(count($ProcessState) >= 2);
}
function moisSettings($WebDir, $map, $korisnik, $grassexecutable, $grassmapset, $grasslocation, $rastForRegion, $currentMeteoArchiveDir, $meteoArchiveDir)
{
	

if($_POST['mois_option']=="asc")
{
	
	$isSuccess=0;

	if($_FILES['mois_live_asc_file']['name']!="" && $_FILES['mois1h_asc_file']['name']!="")
	{
		$mois10h=0;
		$mois100h=0;

		$flag1=0;
		$flag2=0;
		$flag3=0;
		$flag4=0;
	
		$filename=$_FILES['mois_live_asc_file']['name'];
		$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
		if($ext==".asc" || $ext==".txt" || $_FILES['mois_live_asc_file']['type']=="text/plain" )
		{
			$uploaddir = $WebDir."/user_files/$korisnik/";
			$uploadfile = $uploaddir . "mois_live.asc";

			if (!move_uploaded_file($_FILES['mois_live_asc_file']['tmp_name'], $uploadfile)) 
			{
				echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
			}
			else
			{
				$flag1=1;

			}
		}
		else
		{
			echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
		}

		$filename2=$_FILES['mois1h_asc_file']['name'];
		$ext2 = substr($filename2, strpos($filename2,'.'), strlen($filename2)-1);
		if($ext2==".asc" || $ext2==".txt" || $_FILES['mois1h_asc_file']['type']=="text/plain" )
		{
			$uploaddir = $WebDir."/user_files/$korisnik/";
			$uploadfile = $uploaddir . "mois1h.asc";

			if (!move_uploaded_file($_FILES['mois1h_asc_file']['tmp_name'], $uploadfile)) 
			{
					echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
			}
			else
			{
				$flag2=1;
			}
		}
		else
		{
			echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
		}


		if($_FILES['mois10h_asc_file']['name']!="" && isset($_POST["mois10h"]))
		{
			$filename3=$_FILES['mois10h_asc_file']['name'];
			$ext3 = substr($filename3, strpos($filename3,'.'), strlen($filename3)-1);
			if($ext3==".asc" || $ext3==".txt" || $_FILES['mois10h_asc_file']['type']=="text/plain" )
			{
				$uploaddir = $WebDir."/user_files/$korisnik/";
				$uploadfile = $uploaddir . "mois10h.asc";

				if (!move_uploaded_file($_FILES['mois10h_asc_file']['tmp_name'], $uploadfile)) 
				{
					echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
				}
				else
				{
					$flag3=1;
				}
			}
			$mois10h=1;
		}
		else
		{
			if($ext2==".asc" || $ext2==".txt" || $_FILES['mois1h_asc_file']['type']=="text/plain" )
			{
				$uploaddir = $WebDir."/user_files/$korisnik/";
				$uploadfiledest = $uploaddir . "mois10h.asc";
				$uploadfilesource=$uploaddir."mois1h.asc";
				
				if(!copy($uploadfilesource,$uploadfiledest))
				{
					echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
				}
				else
				{
					$flag3=1;
				}

			}
		}


		if($_FILES['mois100h_asc_file']['name']!="" && isset($_POST["mois100h"]))
		{
			$filename4=$_FILES['mois100h_asc_file']['name'];
			$ext4 = substr($filename4, strpos($filename4,'.'), strlen($filename4)-1);
			if($ext4==".asc" || $ext4==".txt" || $_FILES['mois100h_asc_file']['type']=="text/plain" )
			{
				$uploaddir = $WebDir."/user_files/$korisnik/";
				$uploadfile = $uploaddir . "mois100h.asc";

				if (!move_uploaded_file($_FILES['mois100h_asc_file']['tmp_name'], $uploadfile)) 
				{
					echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
				}
				else
				{
					$flag4=1;
				}
			}
			$mois100h=1;
		}
		else
		{
			if($ext2==".asc" || $ext2==".txt" || $_FILES['mois1h_asc_file']['type']=="text/plain" )
			{
				$uploaddir = $WebDir."/user_files/$korisnik/";
				$uploadfiledest = $uploaddir . "mois100h.asc";
				$uploadfilesource=$uploaddir."mois1h.asc";
				
				if(!copy($uploadfilesource,$uploadfiledest))
				{
					echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
				}
				else
				{
					$flag4=1;
				}
			}
		}

		
		
		$text="
g.mapset mapset=$korisnik
#history -w
#history -r /$GISDBASE/$LOCATION/$MAPSET/.bash_history
#HISTFILE=/$GISDBASE/$LOCATION/$MAPSET/.bash_history
	
#g.copy rast=kopno@$grassmapset,kopno

g.remove rast='mois_$korisnik'
g.remove rast='mois_l_$korisnik'
g.remove rast='mois_l0_$korisnik'
g.remove rast='mois_l00_$korisnik'

r.in.arc input=$WebDir/user_files/$korisnik/mois_live.asc output=mois_$korisnik type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/mois1h.asc output=mois_l_$korisnik type=FCELL mult=1.0

";

	if($_FILES['mois10h_asc_file']['name']!="" && isset($_POST["mois10h"]))
		$text=$text."r.in.arc input=$WebDir/user_files/$korisnik/mois10h.asc output=mois_l0_$korisnik type=FCELL mult=1.0
";
	else
		$text=$text."r.in.arc input=$WebDir/user_files/$korisnik/mois1h.asc output=mois_l0_$korisnik type=FCELL mult=1.0
";

	if($_FILES['mois100h_asc_file']['name']!="" && isset($_POST["mois100h"]))
		$text=$text."r.in.arc input=$WebDir/user_files/$korisnik/mois100h.asc output=mois_l00_$korisnik type=FCELL mult=1.0
";
	else
		$text=$text."r.in.arc input=$WebDir/user_files/$korisnik/mois1h.asc output=mois_l00_$korisnik type=FCELL mult=1.0
";

		$text.="
g.region rast=mois_$korisnik res=1200
echo '0 235:60:45\n30 255:190:55\n60 101:185:1\n100 50:150:235\n300 50:150:235\nend' | r.colors map=mois_$korisnik color=rules rules=-
r.out.tiff input=mois_$korisnik output=\"$WebDir/user_files/$korisnik/raster/mois_live\" compression=none -t 
";

		$filename=$WebDir."/user_files/$korisnik/mois_value.sh";
		$fh = fopen($filename, 'w') or die("can't open file");
					fwrite($fh, $text);
					fclose($fh);

	$text2="export GRASS_BATCH_JOB=$WebDir/user_files/$korisnik/mois_value.sh
	$grassexecutable -text $grasslocation/$korisnik";

		$filename=$WebDir."/user_files/$korisnik/mois_value_launch.sh";
		$fh = fopen($filename, 'w') or die("can't open file");
					fwrite($fh, $text2);
					fclose($fh);

		$stringps="$WebDir/user_files/$korisnik/mois_value_launch.sh";
		$ps = run_in_background2($stringps);
		while(is_process_running2($ps))
		{
			session_write_close();
			sleep(1);
			ob_flush;
			flush();
		}
		
		if($flag1==1 && $flag2 == 1 && $flag3==1 && $flag4 == 1)
		{
			$isSuccess=1;
		}
		else
		{
			echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
		}
	}
}

if($_POST['mois_option']=="value")
{


	if(!is_numeric($_POST["live"]) || !is_numeric($_POST["1h"]) || !is_numeric($_POST["10h"]) || !is_numeric($_POST["100h"]))
	{
		echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
	}
	else
	{
		$num1=$_POST['live'];
		$num2=$_POST['1h'];
		$num3=$_POST['10h'];
		$num4=$_POST['100h'];		

	$text="
	
   g.mapset mapset=$korisnik
   #history -w
   #history -r /$GISDBASE/$LOCATION/$MAPSET/.bash_history
   #HISTFILE=/$GISDBASE/$LOCATION/$MAPSET/.bash_history
	
#g.copy rast=kopno@$grassmapset,kopno --overwrite
	
g.remove rast='mois_$korisnik'
g.remove rast='mois_l_$korisnik'
g.remove rast='mois_l0_$korisnik'
g.remove rast='mois_l00_$korisnik'

g.region rast=$rastForRegion@$grassmapset res=500

r.mapcalc \"mois_$korisnik=if(kopno2@$grassmapset==0,null(), $num1)\"  
r.mapcalc \"mois_l_$korisnik=if(kopno2@$grassmapset==0,null(), $num2)\" 
r.mapcalc \"mois_l0_$korisnik=if(kopno2@$grassmapset==0,null(), $num3)\" 
r.mapcalc \"mois_l00_$korisnik=if(kopno2@$grassmapset==0,null(), $num4)\" 

g.region rast=$rastForRegion@$grassmapset res=1200

r.out.arc input=mois_$korisnik output=$WebDir/user_files/$korisnik/mois_live.asc dp=1
r.out.arc input=mois_l_$korisnik output=$WebDir/user_files/$korisnik/mois1h.asc dp=1
r.out.arc input=mois_l0_$korisnik output=$WebDir/user_files/$korisnik/mois10h.asc dp=1
r.out.arc input=mois_l00_$korisnik output=$WebDir/user_files/$korisnik/mois100h.asc dp=1

g.region rast=mois_$korisnik res=1200
echo '0 235:60:45\n30 255:190:55\n60 101:185:1\n100 50:150:235\n300 50:150:235\nend' | r.colors map=mois_$korisnik color=rules rules=-
r.out.tiff input=mois_$korisnik output=\"$WebDir/user_files/$korisnik/raster/mois_live\" compression=none -t 
";

	$filename=$WebDir."/user_files/$korisnik/mois_value.sh";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $text);
				fclose($fh);

$text2="export GRASS_BATCH_JOB=$WebDir/user_files/$korisnik/mois_value.sh
$grassexecutable -text $grasslocation/$korisnik";

	$filename=$WebDir."/user_files/$korisnik/mois_value_launch.sh";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $text2);
				fclose($fh);

	$stringps="$WebDir/user_files/$korisnik/mois_value_launch.sh";
	$ps = run_in_background2($stringps);
	while(is_process_running2($ps))
	{
		session_write_close();
	  	sleep(1);
		ob_flush;
		flush();
	}
	
	$isSuccess=1;
	}
	
}

if($_POST['mois_option']=="online")
{

	copy($currentMeteoArchiveDir."/mois_live.asc",$WebDir."/user_files/$korisnik/mois_live.asc");
	copy($currentMeteoArchiveDir."/mois1h.asc",$WebDir."/user_files/$korisnik/mois1h.asc");
	copy($currentMeteoArchiveDir."/mois10h.asc",$WebDir."/user_files/$korisnik/mois10h.asc");
	copy($currentMeteoArchiveDir."/mois100h.asc",$WebDir."/user_files/$korisnik/mois100h.asc");

	$text="g.remove rast='mois_$korisnik'
g.remove rast='mois_l_$korisnik'
g.remove rast='mois_l0_$korisnik'
g.remove rast='mois_l00_$korisnik'


r.in.arc input=$WebDir/user_files/$korisnik/mois_live.asc output=mois_$korisnik type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/mois1h.asc output=mois_l_$korisnik type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/mois10h.asc output=mois_l0_$korisnik type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/mois100h.asc output=mois_l00_$korisnik type=FCELL mult=1.0

g.region rast=mois_$korisnik res=1200
echo '0 235:60:45\n30 255:190:55\n60 101:185:1\n100 50:150:235\n300 50:150:235\nend' | r.colors map=mois_$korisnik color=rules rules=-
r.out.tiff input=mois_$korisnik output=\"$WebDir/user_files/$korisnik/raster/mois_live\" compression=none -t 
";

	$filename=$WebDir."/user_files/$korisnik/mois_value.sh";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $text);
				fclose($fh);

$text2="export GRASS_BATCH_JOB=$WebDir/user_files/$korisnik/mois_value.sh
$grassexecutable -text $grasslocation/$korisnik";

	$filename=$WebDir."/user_files/$korisnik/mois_value_launch.sh";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $text2);
				fclose($fh);

	$stringps="$WebDir/user_files/$korisnik/mois_value_launch.sh";
	$ps = run_in_background2($stringps);
	while(is_process_running2($ps))
	{
		session_write_close();
	  	sleep(1);
		ob_flush;
		flush();
	}
	$isSuccess=1;
}


if($_POST['mois_option']=="date")
	{
		$getMeteoScript = $meteoArchiveDir."/getMeteoDataHolistic.php";
		
		$date=$_POST["mois_dir_date"];
		$utchour=$_POST["forecast"];
		
		unlink($meteoArchiveDir."$korisnik/mois_live.asc");
		unlink($meteoArchiveDir."$korisnik/mois_1h.asc");
		unlink($meteoArchiveDir."$korisnik/mois_l0h.asc");
		unlink($meteoArchiveDir."$korisnik/mois_l00h.asc");
		unlink($meteoArchiveDir."$korisnik/mois_l000h.asc");
		
		
		//echo "php ".$getMeteoScript." ".$date." ".$utchour." ".$korisnik;
		
		$stringps="php ".$getMeteoScript." ".$date." ".$utchour." ".$korisnik." mois";;
		$ps = run_in_background2($stringps);
		
		echo "<script>alert(\""._CONTINUE_IN_BCK."\");</script>\n";
		$isSuccess=1;
	}


if(!is_dir  ( "./user_files/$korisnik/averages/" ))
{
	mkdir("./user_files/$korisnik/averages/", 0777);
	chmod("./user_files/$korisnik/averages/", 0777);
}

$averages="g.region rast=mois_$korisnik res=1000000
#r.out.arc input=mois output=$WebDir/user_files/$korisnik/averages/mois_live_average.txt dp=2
#r.out.arc input=mois_l output=$WebDir/user_files/$korisnik/averages/mois_1h_average.txt dp=2
#r.out.arc input=mois_l0 output=$WebDir/user_files/$korisnik/averages/mois_10h_average.txt dp=2
#r.out.arc input=mois_l00 output=$WebDir/user_files/$korisnik/averages/mois_100h_average.txt dp=2
r.out.arc input=mois_$korisnik output=$WebDir/user_files/$korisnik/averages/mois_live_".$korisnik."_average.txt dp=2
r.out.arc input=mois_l_$korisnik output=$WebDir/user_files/$korisnik/averages/mois_1h_".$korisnik."_average.txt dp=2
r.out.arc input=mois_l0_$korisnik output=$WebDir/user_files/$korisnik/averages/mois_10h_".$korisnik."_average.txt dp=2
r.out.arc input=mois_l00_$korisnik output=$WebDir/user_files/$korisnik/averages/mois_100h_".$korisnik."_average.txt dp=2";

	$filename=$WebDir."/user_files/$korisnik/averages_mois.sh";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $averages);
				fclose($fh);

$averages2="export GRASS_BATCH_JOB=$WebDir/user_files/$korisnik/averages_mois.sh
$grassexecutable -text $grasslocation/$korisnik";

	$filename=$WebDir."/user_files/$korisnik/averages_mois_launch.sh";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $averages2);
				fclose($fh);

	$stringps="$WebDir/user_files/$korisnik/averages_mois_launch.sh";
	$ps = run_in_background2($stringps);
	while(is_process_running2($ps))
	{
		session_write_close();
	  	sleep(1);
		ob_flush;
		flush();
	}
	

	if($isSuccess==1)
	{
		echo '<script>notifAndClose("'._GIS_MOIS_SUCCESS.'. ");</script>';
	}
	
	
?>

<script>
	jQuery(document).ready(function() {
		//$("#firstChoice").fadeOut("slow");
		$("#secondChoice").hide();
		$("#thirdChoice").hide();
		$("#fourthChoice").hide();
		
		$(".mois_option").click(function(){
			
			index = $(".mois_option").index(this);
			//alert(index);
			if(index==0)
			{
				$("#secondChoice").fadeOut("slow");
				$("#fourthChoice").fadeOut("slow");
				$("#thirdChoice").fadeOut("slow");
				$("#firstChoice").delay( 500 ).fadeIn("slow");
			}
			else if(index==1)
			{
				$("#firstChoice").fadeOut("slow");
				$("#thirdChoice").fadeOut("slow");
				$("#fourthChoice").fadeOut("slow");
				$("#secondChoice").delay( 500 ).fadeIn("slow");
			}
			else if(index==2)
			{
				$("#firstChoice").fadeOut("slow");
				$("#secondChoice").fadeOut("slow");
				$("#fourthChoice").fadeOut("slow");
				$("#thirdChoice").delay( 500 ).fadeIn("slow");
			}
			else if(index==3)
			{
				$("#firstChoice").fadeOut("slow");
				$("#secondChoice").fadeOut("slow");
				$("#thirdChoice").fadeOut("slow");
				$("#fourthChoice").delay( 500 ).fadeIn("slow");
			}
		
		});
		
	});
</script>

<h1 id="title"><?php echo _MOIS_PROPERTIES;?></h1><br /><hr />

<input type='radio' name="mois_option" class="mois_option" value="online" id="mois_option_online" checked>
<b><?php echo _PARAMETERS_ONLINE;?></b>

<div id="firstChoice" class="choices">
	<br />
	<label><?php echo _GET_MOIS_ONLINE;?></label>
	<br />
</div>

<hr />

<input type='radio' name="mois_option" class="mois_option" value="asc" id="mois_option_0">
<b><?php echo _PARAMETERS_ASC;?></b><br />

<div id="secondChoice" class="choices">
	<br />
		<span class="style2">
		<label><?php echo _GET_MOIS_LIVE;?></label> &nbsp;<INPUT NAME="mois_live_asc_file" TYPE="file" onchange='document.getElementById("mois_option_0").checked = true'><br />
		<label><?php echo _GET_MOIS_1H;?></label> &nbsp;<INPUT NAME="mois1h_asc_file" TYPE="file" onchange='document.getElementById("mois_option_0").checked = true'><br />
		<label><input type="checkbox" name="mois10h" id="mois10h" onchange='document.getElementById("mois_option_0").checked = true'>
		<?php echo _GET_MOIS_10H;?></label> &nbsp;<INPUT NAME="mois10h_asc_file" TYPE="file" onchange='document.getElementById("mois10h").checked = true; document.getElementById("mois_option_0").checked = true'><br />
		<label><input type="checkbox" name="mois100h" id="mois100h" onchange='document.getElementById("mois_option_0").checked = true'>
		<?php echo _GET_MOIS_100H;?></label> &nbsp;<INPUT NAME="mois100h_asc_file" TYPE="file" onchange='document.getElementById("mois100h").checked = true; document.getElementById("mois_option_0").checked = true'><br />
</div>

<hr />
<input type='radio' name="mois_option" class="mois_option" value="value" id="mois_option_1">
<b><?php echo _VALUE;?></b><br />


<div id="thirdChoice" class="choices">
	
	<label><?php echo _GET_MOIS_LIVE;?></label> &nbsp;<input type="number" size="5" autocomplete="off" name="live" min="20" max="200" onchange='document.getElementById("mois_option_1").checked = true'>
	<?php
	// ISPIS ONLINE I VLASTITOG MOIS_LIVE Treba urediti
	/*echo trim(getAverageFromAverageAsc("$WebDir/user_files/$korisnik/averages/mois_live_average.txt"));
	echo ", ";*/
	//echo "( ".getAverageFromAverageAsc("$WebDir/user_files/$korisnik/averages/mois_live_".$korisnik."_average.txt").")";?>
	<br />
	<label><?php echo _GET_MOIS_1H;?></label> &nbsp;<input type="number" size="5" autocomplete="off" name="1h" min="0" max="30" onchange='document.getElementById("mois_option_1").checked = true'>
	<?php 
	// ISPIS ONLINE I VLASTITOG MOIS_1H Treba urediti
	/*echo trim(getAverageFromAverageAsc("$WebDir/user_files/$korisnik/averages/mois_1h_average.txt"));
	echo ", ";*/
	//echo "( ".getAverageFromAverageAsc("$WebDir/user_files/$korisnik/averages/mois_1h_".$korisnik."_average.txt").")";?>
	<br />
	<label><?php echo _GET_MOIS_10H;?></label> &nbsp;<input type="number" size="5" autocomplete="off" name="10h" min="0" max="30" onchange='document.getElementById("mois_option_1").checked = true'>
	<?php 
	// ISPIS ONLINE I VLASTITOG MOIS_10H Treba urediti
	/*echo trim(getAverageFromAverageAsc("$WebDir/user_files/$korisnik/averages/mois_10h_average.txt"));
	echo ", ";*/
	//echo "( ".getAverageFromAverageAsc("$WebDir/user_files/$korisnik/averages/mois_10h_".$korisnik."_average.txt").")";?>
	<br />
	<label><?php echo _GET_MOIS_100H;?></label> &nbsp;<input type="number" size="5" autocomplete="off" name="100h" min="0" max="30" onchange='document.getElementById("mois_option_1").checked = true'>
	<?php 
	// ISPIS ONLINE I VLASTITOG MOIS_100H Treba urediti
	/*echo trim(getAverageFromAverageAsc("$WebDir/user_files/$korisnik/averages/mois_100h_average.txt"));
	echo ", ";*/
	//echo "( ".getAverageFromAverageAsc("$WebDir/user_files/$korisnik/averages/mois_100h_".$korisnik."_average.txt").")";?>
	<br />
</div>
<hr />

<input type='radio' name="mois_option" class="mois_option" value="date" id="mois_option_date">
	<b><?php echo _PARAMETERS_BY_DATE;?></b><br /><hr />

	<div id="fourthChoice" class="choices">
		<br />
		<label><?php echo _WIND_DATE;?></label> &nbsp;<input type="date" NAME="mois_dir_date" id="mois_dir_date" onchange='document.getElementById("mois_option_date").checked = true' min="2016-01-02" ><br />
		<br />
		<label><?php echo _WIND_HOUR;?></label>
		<select id="forecast" name="forecast" onchange='document.getElementById("mois_option_date").checked = true'>
		  <option value="0">00 UTC</option>
		  <option value="3">03 UTC</option>
		  <option value="6">06 UTC</option>
		  <option value="9">09 UTC</option>
		  <option value="12" selected="selected">12 UTC</option>
		  <option value="15">15 UTC</option>
		  <option value="18">18 UTC</option>
		  <option value="21">21 UTC</option>
		  <!--<option value="24">+24</option>-->
		</select>
		<br /><hr />
	</div>
	
	<script>
	document.getElementById('mois_dir_date').valueAsDate = new Date();
	</script>

<input type="submit" name="mois_submit" id="mois_submit" value="<?php echo _UPDATE_MOIS_SETTINGS;?>" align="right" class="rucnoMenu">



	<script>$("#mois_submit").click(function(){
		document.getElementById("mois_submit").value="<?php echo _UPDATE_STILL_WORKING; ?>";
	});</script>
	
<?php

	if($_POST['mois_option']!="")
	{
		echo '<script>document.getElementById("mois_submit").value="'._UPDATE_STILL_WORKING.'";</script>';
		echo '<script>document.getElementById("mois_submit").disabled=true;</script>';
	}

}



?>