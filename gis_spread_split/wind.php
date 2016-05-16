<?php 
//ini_set('memory_limit', '512M');	
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

include_once("db_functions.php");
include_once("postavke_dir_gis.php");

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
	x_insertValueToCalculateROS(WebDir, korisnik, 1, "Albini_custom", function(){});
	x_insertValueToCalculateROS(WebDir, korisnik, 1, "Scott_custom", function(){});
	x_insertValueToCalculateROS(WebDir, korisnik, 1, "Albini_default", function(){});
	x_insertValueToCalculateROS(WebDir, korisnik, 1, "Scott_default", function(){});
	setTimeout(function(){window.close();}, 2000);
	
}

</script>

<?php

function run_in_background2($Command, $Priority = 0)
{
    if($Priority)
        $PID = shell_exec("nohup nice -n $Priority $Command 2> /dev/null & echo $!");
    else
	$PID = shell_exec("nohup $Command > /dev/null 2> /dev/null & echo $!");
        //$PID = shell_exec("nohup $Command 2> /dev/null & echo $!");
    return($PID);
}

function is_process_running2($PID)
{
    exec("ps $PID", $ProcessState);
    return(count($ProcessState) >= 2);
}

//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//
//   Prikaz vjetra u mapserveru na temelju ulaznog asc filea, moguce iskoristiti za smjer i jacinu   //
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//


function windSettings($WebDir, $currentMeteoArchiveDir, $map, $korisnik, $meteoArchiveDir)
{
	
	$isSuccess=0;
	
	$today= date("d.m.Y");
	$folderOnlineForecast=$currentMeteoArchiveDir."../".$today."/meteodata/";
	
	if($_POST['wind_option']=="meteo" && $_FILES['wind_meteo_file']['name'] !="" )
	{
		
		$isSuccess=0;
		
		$hour=$_POST["forecast"];

		if(1)
		{
			$uploaddir = $WebDir."/user_files/$korisnik/";
			$uploadfile = $uploaddir . "wind_meteo";
			

			if (!move_uploaded_file($_FILES['wind_meteo_file']['tmp_name'], $uploadfile)) 
			{
				echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
			}
			else
			{
				convertMeteoToAsc($WebDir, $uploadfile, $korisnik, 6);
				copy($WebDir."/user_files/$korisnik/meteo/wind_dir_meteo_$hour.asc", $WebDir."/user_files/$korisnik/wind_dir.asc");
				copy($WebDir."/user_files/$korisnik/meteo/wind_speed_meteo_$hour.asc", $WebDir."/user_files/$korisnik/wind_speed.asc");
				
				$isSuccess=1;
			}
		}
	}

	//Ukoliko se ucitava iz asc file-a

	if($_POST['wind_option']=="asc" && (($_FILES['wind_dir_asc_file']['name'])!="" || ($_FILES['wind_speed_asc_file']['name'])!=""))
	{
		
		$isSuccess=0;
		$flag1=0;
		$flag2=0;
		
		$filename=$_FILES['wind_dir_asc_file']['name'];
		$filename2=$_FILES['wind_speed_asc_file']['name'];
		$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
		$ext2 = substr($filename2, strpos($filename2,'.'), strlen($filename2)-1);

		
		if($ext==".asc" || $ext==".txt" || $_FILES['wind_dir_asc_file']['type']=="text/plain" )
		{
			$uploaddir = $WebDir."/user_files/$korisnik/";
			$uploadfile = $uploaddir . "wind_dir.asc";

			if (!move_uploaded_file($_FILES['wind_dir_asc_file']['tmp_name'], $uploadfile)) 
			{
				echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';					
			}
			else
			{
				$flag1=1;
			}
		}

		if( $ext2==".asc" || $ext2==".txt" || $_FILES['wind_speed_asc_file']['type']=="text/plain")
		{

			$uploaddir2 = $WebDir."/user_files/$korisnik/";
			$uploadfile2 = $uploaddir2 . "wind_speed.asc";
			//echo "<br>".$uploadfile;		

			if (!move_uploaded_file($_FILES['wind_speed_asc_file']['tmp_name'], $uploadfile2)) 
			{
					echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
					
			}
			else
			{
				$flag2=1;
			}
			
		}
		
		if($flag1==1 && $flag2 == 1)
		{
			$isSuccess=1;
		}
		else
		{
			echo '<script>notif("'._GIS_UNSUCCESSFUL_ATTEMPT.'");</script>';
		}
		
	}


	//Ukoliko se unose vrijednosti


	if($_POST['wind_option']=="single_value")
	{
		$isSuccess=0;

		if($_POST["smjer"]==NULL || $_POST["jacina"]==NULL )
		{
			echo '<script>notif("'._GIS_DATA_MISSING.'");</script>';
			
		}

		if((!is_numeric($_POST["smjer"]) || !is_numeric($_POST["jacina"])))
			echo '<script>notif("'._GIS_DATA_INCOMPLETE.'");</script>';

		else
		{
			$smjer=$_POST["smjer"];
			$jacina=$_POST["jacina"];
			$rezolucija=50;
		
			createWind_sv($WebDir, $map, $smjer, $jacina, $rezolucija, $korisnik);
			$isSuccess=1;
		}
	}

	if($_POST['wind_option']=="online")
	{

		copy($currentMeteoArchiveDir."/wind_dir.asc",$WebDir."/user_files/$korisnik/wind_dir.asc");
		copy($currentMeteoArchiveDir."/wind_speed.asc",$WebDir."/user_files/$korisnik/wind_speed.asc");
		
		/*$hour=$_POST["forecastOnline"];
		
		copy($folderOnlineForecast."/wind_dir_meteo_$hour.asc",$WebDir."/user_files/$korisnik/wind_dir.asc");
		copy($folderOnlineForecast."/wind_speed_meteo_$hour.asc",$WebDir."/user_files/$korisnik/wind_speed.asc");*/
		
		$isSuccess=1;
	}
	
	
	if($_POST['wind_option']=="date")
	{
		
		$getMeteoScript = $meteoArchiveDir."/getMeteoDataHolistic.php";

		$date=$_POST["wind_dir_date"];
		$utchour=$_POST["forecast"];
		
		unlink($meteoArchiveDir."$korisnik/wind_dir.asc");
		unlink($meteoArchiveDir."$korisnik/wind_speed.asc");
		
		//echo "php ".$getMeteoScript." ".$date." ".$utchour." ".$korisnik;
		
		$stringps="php ".$getMeteoScript." ".$date." ".$utchour." ".$korisnik." wind";
		$ps = run_in_background2($stringps);
		
		echo "<script>alert(\""._CONTINUE_IN_BCK."\");</script>\n";
		$isSuccess=1;
	}
	
	

	if($isSuccess==1)
	{
		echo '<script>notifAndClose("'._GIS_WIND_SUCCESS.'. ");</script>';
		
	}
	
	


	?>

	<script>
		jQuery(document).ready(function() {
			//$("#firstChoice").fadeOut("slow");
			$("#secondChoice").hide();
			$("#thirdChoice").hide();
			$("#fourthChoice").hide();
			$("#fifthChoice").hide();
			
			$(".wind_option").click(function(){
				
				index = $(".wind_option").index(this);
				//alert(index);
				if(index==0)
				{
					$("#secondChoice").fadeOut("slow");
					$("#thirdChoice").fadeOut("slow");
					$("#fourthChoice").fadeOut("slow");
					$("#fifthChoice").fadeOut("slow");
					$("#firstChoice").delay( 500 ).fadeIn("slow");
				}
				else if(index==1)
				{
					$("#firstChoice").fadeOut("slow");
					$("#thirdChoice").fadeOut("slow");
					$("#fourthChoice").fadeOut("slow");
					$("#fifthChoice").fadeOut("slow");
					$("#secondChoice").delay( 500 ).fadeIn("slow");
				}
				else if(index==2)
				{
					$("#firstChoice").fadeOut("slow");
					$("#secondChoice").fadeOut("slow");
					$("#fourthChoice").fadeOut("slow");
					$("#fifthChoice").fadeOut("slow");
					$("#thirdChoice").delay( 500 ).fadeIn("slow");
				}
				else if(index==3)
				{
					$("#firstChoice").fadeOut("slow");
					$("#secondChoice").fadeOut("slow");
					$("#thirdChoice").fadeOut("slow");
					$("#fifthChoice").fadeOut("slow");
					$("#fourthChoice").delay( 500 ).fadeIn("slow");
				}
				else if(index==4)
				{
					$("#firstChoice").fadeOut("slow");
					$("#secondChoice").fadeOut("slow");
					$("#thirdChoice").fadeOut("slow");
					$("#fourthChoice").fadeOut("slow");
					$("#fifthChoice").delay( 500 ).fadeIn("slow");
				}
				
			});
			
		});
		
		
		
		

	</script>

	<h1 id="title"><?php echo _WIND_PROPERTIES;?></h1><br /><hr>

	<input type='radio' name="wind_option" class="wind_option" value="online" id="wind_option_online" checked>
	<b><?php echo _PARAMETERS_ONLINE;?></b>

	<div id="firstChoice" class="choices">
		<br />
		<label><?php echo _GET_WIND_ONLINE;?></label>
		<?php/* $utchournow=gmdate("H");
		$utchournow++;
		$utchournow--;
		$ostatak=$utchournow%3;
		$utchournow=$utchournow-$ostatak;
		$utchournow=$utchournow%24;
		//echo $utchournow;
		$indexToBeSelected=($utchournow/4)+1;*/		
		?>
		<!--<label><?php //echo _WIND_FORECAST_HOUR;?></label>
		<select id="forecastOnline" name="forecastOnline">
		  <option value="0">00 UTC</option>
		  <option value="3">03 UTC</option>
		  <option value="6">06 UTC</option>
		  <option value="9">09 UTC</option>
		  <option value="12">12 UTC</option>
		  <option value="15">15 UTC</option>
		  <option value="18">18 UTC</option>
		  <option value="21">21 UTC</option>
		</select>
		
		<script>document.getElementById('forecastOnline').selectedIndex=<?php //echo $indexToBeSelected;  ?>;</script>-->
		<br />
	</div>
	<hr />

	<input type='radio' name="wind_option"  class="wind_option" value="meteo" id="wind_option_0">
	<b><?php echo _GET_METEO;?></b><br />

	<div id="secondChoice" class="choices">
		<br />
		<label><?php echo _GET_FILE_COLON;?></label> &nbsp;<INPUT NAME="wind_meteo_file" TYPE="file" onchange='document.getElementById("wind_option_0").checked = true'><br />
		<br />
		<label><?php echo _WIND_FORECAST_HOUR;?></label>
		<select id="forecast" name="forecast">
		  <option value="0">00 UTC</option>
		  <option value="3">03 UTC</option>
		  <option value="6">06 UTC</option>
		  <option value="9">09 UTC</option>
		  <option value="12">12 UTC</option>
		  <option value="15">15 UTC</option>
		  <option value="18">18 UTC</option>
		  <option value="21">21 UTC</option>
		  <!--<option value="24">+24</option>-->
		</select>
		<br />
	</div>
	<hr />
		
	<input type='radio' name="wind_option" class="wind_option" value="asc" id="wind_option">
	<b><?php echo _PARAMETERS_ASC;?></b><br /><hr />

	<div id="thirdChoice" class="choices">
		<br />
		<label><?php echo _DIRECTION_COLON;?></label> &nbsp;<INPUT NAME="wind_dir_asc_file" TYPE="file" onchange='document.getElementById("wind_option").checked = true'><br />
		<label><?php echo _SPEED_COLON;?></label> &nbsp; <INPUT NAME="wind_speed_asc_file" TYPE="file" onchange='document.getElementById("wind_option").checked = true'><br /><hr />
	</div>

	<input type='radio' name="wind_option" class="wind_option" value="single_value" id="wind_option2">
	<b><?php echo _VALUE;?></b><br /><hr />

	<div id="fourthChoice" class="choices">
		<img src="./gif/windCircle.png" width="100" style="float: right;">
		<br />
		<label><?php echo _DIRECTION;?> (&deg;):</label>  &nbsp;<input type="number" size="5" autocomplete="off" name="smjer" min="0" max="360" onchange='document.getElementById("wind_option2").checked = true'>&nbsp;&nbsp;&nbsp;&nbsp;
		
		<br />
		<label><?php echo _SPEED;?> (km/h):</label> &nbsp;<input type="number" size="5" autocomplete="off" name="jacina" min="0" max="200" onchange='document.getElementById("wind_option2").checked = true'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
		<br style="clear: both">
		<hr />
	</div>
	
	
	<input type='radio' name="wind_option" class="wind_option" value="date" id="wind_option_date">
	<b><?php echo _PARAMETERS_BY_DATE;?></b><br /><hr />

	<div id="fifthChoice" class="choices">
		<br />
		<label><?php echo _WIND_DATE;?></label> &nbsp;<input type="date" NAME="wind_dir_date" id="wind_dir_date" onchange='document.getElementById("wind_option_date").checked = true' min="2016-01-02" ><br />
		<br />
		<label><?php echo _WIND_HOUR;?></label>
		<select id="forecast" name="forecast" onchange='document.getElementById("wind_option_date").checked = true'>
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
	document.getElementById('wind_dir_date').valueAsDate = new Date();
	</script>
	

	<input type="submit" name="wind_submit" id="wind_submit" value="<?php echo _UPDATE_WIND_SETTINGS;?>" align="right"  class="rucnoMenu">

	<div id="notifDiv"> </div>

	
	
	<script>$("#wind_submit").click(function(){
		document.getElementById("wind_submit").value="<?php echo _UPDATE_STILL_WORKING; ?>";
	});</script>
	
	<?php
	
	if($_POST['wind_option']!="")
	{
		echo '<script>document.getElementById("wind_submit").value="'._UPDATE_STILL_WORKING.'";</script>';
		echo '<script>document.getElementById("wind_submit").disabled=true;</script>';
	}
	
	
}

//***************************************************************************************************//
//Provjera asc file-a
//***************************************************************************************************//

function checkAsc($filename)
{
	
	
	$windData="";
	$fh2 = fopen($filename, 'r') or die("can't open file");

	//while (!feof($fh2)) {
	for($i=0;$i<6;$i++)
	{
  		//$windData .= fread($fh2, 8192);
		$windData[$i] = fgets($fh2);
	}
	
	//ncols
	$windData[0]=preg_replace("/ [^\w]* /"," ",$windData[0]); 
	$temp = explode(" ", $windData[0]);
	$ncols=$temp[1];
	//nrows
	$windData[1]=preg_replace("/ [^\w]* /"," ",$windData[1]); 
	$temp = explode(" ", $windData[1]);
	$nrows=$temp[1];
	//xllcorner
	$windData[2]=preg_replace("/ [^\w]* /"," ",$windData[2]); 
	$temp = explode(" ", $windData[2]);
	$xllcorner=$temp[1];
	//yllcorner
	$windData[3]=preg_replace("/ [^\w]* /"," ",$windData[3]); 
	$temp = explode(" ", $windData[3]);
	$yllcorner=$temp[1];
	//cellsize
	$windData[4]=preg_replace("/ [^\w]* /"," ",$windData[4]); 
	$temp = explode(" ", $windData[4]);
	$cellsize=$temp[1];
	//NODATA_value
	$windData[5]=preg_replace("/ [^\w]* /"," ",$windData[5]); 
	$temp = explode(" ", $windData[5]);
	$NODATA_value=$temp[1];	

	//echo $ncols."<br>".$nrows."<br>".$xllcorner."<br>".$yllcorner."<br>".$cellsize."<br>".$NODATA_value;
	
	$windData="";
	while (!feof($fh2)) {
  		$windData .= fread($fh2, 8192);
	}
	
	$windData=preg_replace("/\n[^\w]*\n/","\n\n",$windData); 
	$windData=preg_replace("/ [^\w]* /"," ",$windData);

	fclose($fh2);

	$wind_data = explode(" ", $windData);

	if(count($wind_data)>($ncols*$nrows-5) && count($wind_data)<($ncols*$nrows+5) && $ncols!=0 && $nrows!=0)
	{
		return true;
	}
	else
	{
		return false;
	}

}

//***************************************************************************************************//
//Convert iz meteo u asc
//***************************************************************************************************//

function convertMeteoToAsc($WebDir, $filename, $korisnik, $firsthour)
{

	
	

	$fh2 = fopen($filename, 'r') or die("can't open file");
	$windData="";
	


	for($i=0;$i<5;$i++)
	{
  		//$windData .= fread($fh2, 8192);
		$windData[$i] = fgets($fh2);
	}
	
	//BROJ_TOCAKA_X_:
	$windData[0]=preg_replace("/ [^\w]* /"," ",$windData[0]); 
	$temp = explode(" ", $windData[0]);
	$num=0;
	if($temp[$num]=="") $num++;
	$num++;
	$broj_tocaka_x=$temp[$num];
	

	//BROJ_TOCAKA_Y_:
	$windData[1]=preg_replace("/ [^\w]* /"," ",$windData[1]); 
	$temp = explode(" ", $windData[1]);
	$num=0;
	if($temp[$num]=="") $num++;
	$num++;
	$broj_tocaka_y=$temp[$num];

	//_START_MODELA_:
	$windData[2]=preg_replace("/ [^\w]* /"," ",$windData[2]); 
	$temp = explode(" ", $windData[2]);
	$num=0;
	if($temp[$num]=="") $num++;
	$num++;
	$start_modela=$temp[$num];

	//_BROJ_TERMINA_:
	$windData[3]=preg_replace("/ [^\w]* /"," ",$windData[3]); 
	$temp = explode(" ", $windData[3]);
	$num=0;
	if($temp[$num]=="") $num++;
	$num++;
	$counter=$temp[$num];

	$windData[4]=preg_replace("/ [^\w]* /"," ",$windData[4]); 
	$temp = explode(" ", $windData[4]);
	$num=0;
	if($temp[$num]=="") $num++;
	
	$windData="";
	while (!feof($fh2)) {
  		$windData .= fread($fh2, 8192);
	}
	
	$windData=preg_replace("/\n[^\w]*\n/","\n\n",$windData); 
	$windData=preg_replace("/ [^\w]* /"," ",$windData);

	fclose($fh2);
	
	$wind_data = explode(" ", $windData);
	
	unset($windData);

	$num=0;
	if($wind_data[$num]=="") $num++;

$long=array();
$lat=array();
$tm_x=array();
$tm_y=array();
$kopno=array();

//$projOutObj =ms_newprojectionobj("proj=tmerc,ellps=WGS84,units=m,lon_0=15,k=0.9999,x_0=6500000,y_0=0,no_defs");
$projOutObj =ms_newprojectionobj("init=epsg:900913");
$projInObj = ms_newprojectionObj ("proj=longlat,ellps=WGS84,no_defs" );


	for($i=0;$i<=$broj_tocaka_x*$broj_tocaka_y-1;$i++)
	{
		if($i==0 && $j==0)
		{
			$k1=0;
			$k2=0;
			for($j=1;$j<=(($counter*2)+3);$j++)
			{
				$wind_data[$i*(($counter*2)+3)+$j]." ";
				$long[0]=$wind_data[1];
				$lat[0]=$wind_data[2];
				$kopno[0]=$wind_data[3];

			
				

				$poPoint = ms_newpointobj();
        		$poPoint->setXY($long[$i], $lat[$i]); //original coordinates
				$poPoint->project($projInObj, $projOutObj);	

				$tm_x[0]=$poPoint->x;
				$tm_y[0]=$poPoint->y;
				

				$tm_x_min=$tm_x[0];
				$tm_y_min=$tm_y[0];
				$tm_x_max=$tm_x[0];
				$tm_y_max=$tm_y[0];


				if($j>3)
				{
					
					if($j%2==0 && $j != 0) { $wind_u[0][$k1]=$wind_data[$j]; $k1++;}
					if($j%2==1 && $j != 1) { $wind_v[0][$k2]=$wind_data[$j]; $k2++;}
				}
			}
		}
		else
		{
			$k1=0;
			$k2=0;
			for($j=1;$j<=(($counter*2)+3);$j++)
			{
				//if($i< 5) echo $wind_data[$i*(($counter*2)+3)+$j]." ";
				if($j==1) $long[$i]=$wind_data[$i*(($counter*2)+3)+$j];
				if($j==2) $lat[$i]=$wind_data[$i*(($counter*2)+3)+$j];
				if($j==3) $kopno[$i]=$wind_data[$i*(($counter*2)+3)+$j];

				if($j%(2*$counter+3)>3 ||  $j==(2*$counter+3))
				{
					if($j%2==0 && $j != 0) { $wind_u[$i][$k1]=$wind_data[$i*(($counter*2)+3)+$j]; $k1++;}
					if($j%2==1 && $j != 1) { $wind_v[$i][$k2]=$wind_data[$i*(($counter*2)+3)+$j]; $k2++;}
				}

			}
		}
		
	}
	
	unset($wind_data);
	
	//$projOutObj =ms_newprojectionobj("proj=tmerc,ellps=WGS84,units=m,lon_0=15,k=0.9999,x_0=6500000,y_0=0,no_defs");
	$projOutObj =ms_newprojectionobj("init=epsg:900913");
	$projInObj = ms_newprojectionObj ("proj=longlat,ellps=WGS84,no_defs" );

	for($i=0;$i<=$broj_tocaka_x*$broj_tocaka_y-1;$i++)
	{
				$poPoint = ms_newpointobj();
        		$poPoint->setXY($long[$i], $lat[$i]); //original coordinates
				$poPoint->project($projInObj, $projOutObj);	

				$tm_x[$i]=$poPoint->x;
				$tm_y[$i]=$poPoint->y;


				if(	$tm_x[$i] < $tm_x_min ) $tm_x_min = $tm_x[$i];
				if(	$tm_x[$i] > $tm_x_max ) $tm_x_max = $tm_x[$i];
				if(	$tm_y[$i] < $tm_y_min ) $tm_y_min = $tm_y[$i];
				if(	$tm_y[$i] > $tm_y_max ) $tm_y_max = $tm_y[$i];
	}
	
	

	$column1_nodouble=((6-$hour)/3);
	$column1=((6-$hour)/3+1)+2;
	


	for($i=0;$i<=$broj_tocaka_x*$broj_tocaka_y-1;$i++)
	{
		for($j=0;$j<16;$j++)
		{
			
			$wind_speed[$j][$i]=sqrt($wind_u[$i][$j]*$wind_u[$i][$j]+$wind_v[$i][$j]*$wind_v[$i][$j]);
			$wind_dir[$j][$i]=atan2(-$wind_u[$i][$j],-$wind_v[$i][$j])*57.29578;
			
		}
	}





	$ncols=$broj_tocaka_x;
	$nrows=$broj_tocaka_y;
	$xllcorner=$tm_x_min;
	$yllcorner=$tm_y_min;
	$cellsize=($tm_y_max-$tm_y_min)/$broj_tocaka_y;
	$NODATA_value=-9999;

/*
	$new_text=
	"ncols ".$ncols."\nnrows ".$nrows."\nxllcorner ".$xllcorner."\nyllcorner ".$yllcorner."\ncellsize ".$cellsize."\nNODATA_value ".$NODATA_value."\n";

	$new_text2=
	"ncols ".$ncols."\nnrows ".$nrows."\nxllcorner ".$xllcorner."\nyllcorner ".$yllcorner."\ncellsize ".$cellsize."\nNODATA_value ".$NODATA_value."\n";

	$new_text3=
	"ncols ".$ncols."\nnrows ".$nrows."\nxllcorner ".$xllcorner."\nyllcorner ".$yllcorner."\ncellsize ".$cellsize."\nNODATA_value ".$NODATA_value."\n";
	*/

	/*$new_text2=
	"ncols ".$ncols."\nnrows ".$nrows."\nxllcorner 6577755\nyllcorner 4726968\ncellsize ".$cellsize."\nNODATA_value ".$NODATA_value."\n";*/

	//print_r($kopno);
	//echo "xmin xmax ymin ymax:".$tm_x_min." ".$tm_x_max." ".$tm_y_min." ".$tm_y_max;

//print_r($wind_speed);


//echo $start_modela;

$year=$start_modela[0].$start_modela[1].$start_modela[2].$start_modela[3];
$month=$start_modela[4].$start_modela[5];
$day=$start_modela[6].$start_modela[7];
$hour=$start_modela[8].$start_modela[9];
$hoursave=$hour;

//echo "year: ".$year." month: ".$month." day: ".$day." hour: ".$hour;

$string=$hour++;
$string=$hour--;


for($k=0;$k<16;$k++)
{

	$new_text=
	"ncols ".$ncols."\nnrows ".$nrows."\nxllcorner ".$xllcorner."\nyllcorner ".$yllcorner."\ncellsize ".$cellsize."\nNODATA_value ".$NODATA_value."\n";

	$new_text2=
	"ncols ".$ncols."\nnrows ".$nrows."\nxllcorner ".$xllcorner."\nyllcorner ".$yllcorner."\ncellsize ".$cellsize."\nNODATA_value ".$NODATA_value."\n";

	$new_text3=
	"ncols ".$ncols."\nnrows ".$nrows."\nxllcorner ".$xllcorner."\nyllcorner ".$yllcorner."\ncellsize ".$cellsize."\nNODATA_value ".$NODATA_value."\n";

	for($i=$nrows-1;$i>-1;$i=$i-1)
	{
		for($j=0;$j<$ncols;$j++)
		{
			$speed=$wind_speed[$k][$i*$ncols+$j]*3.6;
			$new_text.=$speed." ";
			$new_text2.=$wind_dir[$k][$i*$ncols+$j]." ";
			$new_text3.=$kopno[$i*$ncols+$j]." ";
		}
		$new_text.="\n";
		$new_text2.="\n";
		$new_text3.="\n";


	}

	
	
	$string=$hour;
	$hour=$hour+3;

	$filename=$WebDir."/user_files/$korisnik/meteo/wind_dir_meteo_$string.asc";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $new_text2);
				fclose($fh);

	$filename=$WebDir."/user_files/$korisnik/meteo/wind_speed_meteo_$string.asc";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $new_text);
				fclose($fh);


}





}



//***************************************************************************************************//
//Kreiranje asc file-a
//***************************************************************************************************//

function createWind_sv($WebDir, $map, $smjer, $jacina, $rezolucija, $korisnik)
{
	$aspect=floor( ($map->extent->maxx-$map->extent->minx) / ($map->extent->maxy-$map->extent->miny))+1;
	$ncols=floor($rezolucija*$aspect);
	$nrows=$rezolucija+1;
	$xllcorner=$map->extent->minx;
	$yllcorner=$map->extent->miny;
	$cellsize=($map->extent->maxx - $map->extent->minx)/$ncols;
	$NODATA_value=-9999;

	$new_text=
	"ncols ".$ncols."\nnrows ".$nrows."\nxllcorner ".$xllcorner."\nyllcorner ".$yllcorner."\ncellsize ".$cellsize."\nNODATA_value ".$NODATA_value."\n";

	$new_text2=
	"ncols ".$ncols."\nnrows ".$nrows."\nxllcorner ".$xllcorner."\nyllcorner ".$yllcorner."\ncellsize ".$cellsize."\nNODATA_value ".$NODATA_value."\n";

	for($i=0;$i<$nrows;$i++)
	{
		for($j=0;$j<$ncols;$j++)
		{
			$new_text.=$smjer." ";
			$new_text2.=$jacina." ";
		}
		$new_text.="\n";
		$new_text2.="\n";
	}

	$filename=$WebDir."/user_files/$korisnik/wind_dir.asc";
	$filename2=$WebDir."/user_files/$korisnik/wind_speed.asc";


	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $new_text);
				fclose($fh);

	$fh2 = fopen($filename2, 'w') or die("can't open file");
			fwrite($fh2, $new_text2);
			fclose($fh2);

}

//***************************************************************************************************//

//	Funkcija koja iz .asc file procita podatke, prilagodi ih trenutnom prikazu u mapserveru,
//	odnosno georeferencira ih, izračuna prosiječnu vrijednost, te prilagodi koordinatnom sustavu
//	samog mapservera koji ispisuje od dolje lijeve prema desno i prema gore, za razliku od samog
//	asc file-a koji je od gore lijevo prema desno i dolje.

//***************************************************************************************************//
function loadFromAsc($filename, $minx, $miny, $x_step, $y_step, $numtocaka, $isSpeed)
{
	$windData="";
	$fh2 = fopen($filename, 'r') or die("can't open file $filename");

	//while (!feof($fh2)) {
	for($i=0;$i<6;$i++)
	{
  		//$windData .= fread($fh2, 8192);
		$windData[$i] = fgets($fh2);
	}
	
	//ncols
	$windData[0]=preg_replace("/ [^\w]* /"," ",$windData[0]); 
	$temp = explode(" ", $windData[0]);
	$ncols=$temp[1];
	//nrows
	$windData[1]=preg_replace("/ [^\w]* /"," ",$windData[1]); 
	$temp = explode(" ", $windData[1]);
	$nrows=$temp[1];
	//xllcorner
	$windData[2]=preg_replace("/ [^\w]* /"," ",$windData[2]); 
	$temp = explode(" ", $windData[2]);
	$xllcorner=$temp[1];
	//yllcorner
	$windData[3]=preg_replace("/ [^\w]* /"," ",$windData[3]); 
	$temp = explode(" ", $windData[3]);
	$yllcorner=$temp[1];
	//cellsize
	$windData[4]=preg_replace("/ [^\w]* /"," ",$windData[4]); 
	$temp = explode(" ", $windData[4]);
	$cellsize=$temp[1];
	//NODATA_value
	$windData[5]=preg_replace("/ [^\w]* /"," ",$windData[5]); 
	$temp = explode(" ", $windData[5]);
	$NODATA_value=$temp[1];	

	//echo $ncols."<br>".$nrows."<br>".$xllcorner."<br>".$yllcorner."<br>".$cellsize."<br>".$NODATA_value;

	$windData="";
	while (!feof($fh2)) {
  		$windData .= fread($fh2, 8192);
	}
	
	fclose($fh2);

	$wind_data = explode(" ", $windData);


	$wind2D=array();	
	$listSize=0;

	$nrows=(int)$nrows;

	for($i=$nrows-1;$i>=0;$i--)
	{
		for($j=0;$j<$ncols;$j++)
		{
			$wind2D[$i][$j]=$wind_data[$listSize];
			$listSize++;
		}	
	}
	
	for($i=0;$i<$ncols;$i++)
	{
		$wind_xcoord[$i]=$xllcorner+$i*$cellsize;

	}
	for($j=0;$j<$nrows;$j++)
	{
		$wind_ycoord[$j]=$yllcorner+$j*$cellsize;
	}


	$localExtent_minx=array();
	$localExtent_miny=array();
	$localExtent_maxx=array();
	$localExtent_maxy=array();

	for($b=0;$b<$numtocaka;$b++)
	{
		for($c=0;$c<$numtocaka;$c++)
		{
			$localExtent_minx[$b][$c]=$minx+$c*$x_step;
			$localExtent_maxx[$b][$c]=$localExtent_minx[$b][$c]+$x_step;
			$localExtent_miny[$b][$c]=$miny+$b*$y_step;
			$localExtent_maxy[$b][$c]=$localExtent_miny[$b][$c]+$y_step;
		}
	}

$lastWind=0;

$faster=array();
$wind1=array();
	for($b=0;$b<$numtocaka;$b++)
	{
		for($c=0;$c<$numtocaka;$c++)
		{
			$count=0;
			$average=0;
			for($i=0;$i<$nrows;$i++)
			{
				$faster[$i]=0;
	
				for($j=0;$j<$ncols;$j++)
				{
					if($wind_xcoord[$j]>=$localExtent_minx[$b][$c] && $wind_xcoord[$j]<=$localExtent_maxx[$b][$c] && $wind_ycoord[$i]>=$localExtent_miny[$b][$c] && $wind_ycoord[$i] <= $localExtent_maxy[$b][$c])
					{
						$count++;
						if($wind2D[$i][$j] != (int)$NODATA_value)
						{
							$average+=$wind2D[$i][$j];
							$faster[$i]++;
						}
					}
				}


				if($i>0 && $faster[$i]==0 && $faster[$i-1]!=0)
				{						
						break;
				}
			}
		
			if($count!=0)
			{
				$average=$average/$count;

			}
			if($count==0)
			{
				$average=-9999;
				//echo $average;
			}
		
			$wind1[$b][$c]=$average;
		}
	}

	if($isSpeed)
	{
		for($i=0;$i<$numtocaka;$i++)
		{
			for($j=0;$j<$numtocaka;$j++)
			{



				$wind1[$i][$j]=$wind1[$i][$j]*0.27778;

				if($wind1[$i][$j]>=0 && $wind1[$i][$j]<0.5)
				{
					$wind11[$i][$j]=1;
				}
				if($wind1[$i][$j]>=0.5 && $wind1[$i][$j]<1)
				{
					$wind11[$i][$j]=2;
				}
				if($wind1[$i][$j]>=1.0 && $wind1[$i][$j]<3.6)
				{
					$wind11[$i][$j]=3;
				}
				if($wind1[$i][$j]>=3.6 && $wind1[$i][$j]<6.2)
				{
					$wind11[$i][$j]=4;
				}
				if($wind1[$i][$j]>=6.2 && $wind1[$i][$j]<8.7)
				{
					$wind11[$i][$j]=5;
				}
				if($wind1[$i][$j]>=8.7 && $wind1[$i][$j]<11.3)
				{
					$wind11[$i][$j]=6;
				}
				if($wind1[$i][$j]>=11.3 && $wind1[$i][$j]<13.9)
				{
					$wind11[$i][$j]=7;
				}
				if($wind1[$i][$j]>=13.9 && $wind1[$i][$j]<16.5)
				{
					$wind11[$i][$j]=8;
				}
				if($wind1[$i][$j]>=16.5 && $wind1[$i][$j]<19)
				{
					$wind11[$i][$j]=9;
				}
				if($wind1[$i][$j]>=19 && $wind1[$i][$j]<21.6)
				{
					$wind11[$i][$j]="a";
				}
				if($wind1[$i][$j]>=19 && $wind1[$i][$j]<24.2)
				{
					$wind11[$i][$j]="b";
				}
				if($wind1[$i][$j]>=24.2 && $wind1[$i][$j]<26.8)
				{
					$wind11[$i][$j]="c";
				}
				if($wind1[$i][$j]>=26.8 && $wind1[$i][$j]<29.3)
				{
					$wind11[$i][$j]="d";
				}
				if($wind1[$i][$j]>=29.3 && $wind1[$i][$j]<31.9)
				{
					$wind11[$i][$j]="e";
				}
				if($wind1[$i][$j]>=31.9 && $wind1[$i][$j]<34.5)
				{
					$wind11[$i][$j]="f";
				}
				if($wind1[$i][$j]>=34.5 && $wind1[$i][$j]<37)
				{
					$wind11[$i][$j]="g";
				}
				if($wind1[$i][$j]>=37 && $wind1[$i][$j]<39.6)
				{
					$wind11[$i][$j]="h";
				}
				if($wind1[$i][$j]>=39.6 && $wind1[$i][$j]<42.2)
				{
					$wind11[$i][$j]="i";
				}
				if($wind1[$i][$j]>=42.2 && $wind1[$i][$j]<44.8)
				{
					$wind11[$i][$j]="j";
				}
				if($wind1[$i][$j]>=44.8 && $wind1[$i][$j]<47.3)
				{
					$wind11[$i][$j]="k";
				}
				if($wind1[$i][$j]>=47.3 && $wind1[$i][$j]<49.9)
				{
					$wind11[$i][$j]="l";
				}
				if($wind1[$i][$j]>=49.9 && $wind1[$i][$j]<52.5)
				{
					$wind11[$i][$j]="m";
				}
				if($wind1[$i][$j]>=52.5 && $wind1[$i][$j]<55)
				{
					$wind11[$i][$j]="n";
				}
				if($wind1[$i][$j]>=55 && $wind1[$i][$j]<57.6)
				{
					$wind11[$i][$j]="o";
				}
				if($wind1[$i][$j]>=57.6)
				{
					$wind11[$i][$j]="p";
				}

				$wind1[$i][$j]=$wind11[$i][$j];

			}
		}
	}

	return $wind1;
}

//***************************************************************************************************//

//	Jednostavna funkcija koja kreira Point i georeferencira ga na temelju ulaznih parametara

//***************************************************************************************************//
function windPoint ($x,$y) {

$point = ms_newPointObj(); 
$point->setXY($x,$y);
return $point;
}

//***************************************************************************************************//

//	Priprema prije izvodjenja drawWind. Postavljaju se parametri o layeru, klasi tog layera,
//	i style-u tog layera. Parametri angle i size kasnije se (mogu) mijenjati.

//***************************************************************************************************//
function prepareWind(&$map, &$layera2, &$classa2, &$stylea2, $numtocaka)
{
	//$layera2 = $map->getLayerByName('Wind_dir');
	$layera2->set("type", MS_LAYER_POINT);
	$layera2->set("transparency", 0);
	$classa2->label->color->setRGB(0,0,0);
	$classa2->label->set("type", MS_TRUETYPE);
	$classa2->label->set("size", 10);
	$classa2->label->set("antialias", MS_TRUE);
	$classa2->label->set("font", "wind_arrows");
	$classa2->label->set("partials", MS_TRUE);
	$classa2->label->set("angle", 0);

}

//***************************************************************************************************//

//	Ovom se funkcijom iscrtavaju smjerovi/jacine vjetra, bitno je mjesto pozivanja ove funkcije
//	pogledati PRIMJER KORISTENJA. Mijenja se kut (velicina) strelice (ili bilo kojeg drugog znaka)
//	Strelica je samo znak "1" u fontu koji se koristi i koji je definiran u .map file-u.

//***************************************************************************************************//
function drawWind($map,$Wind_dirAsc, $Wind_speedAsc, &$mylayer, &$myclass, $numtocaka, &$image, $WebDir, $rastForWindRegion, $korisnik)
{

	$x_step=($map->extent->maxx-$map->extent->minx)/($numtocaka);
	$y_step=($map->extent->maxy-$map->extent->miny)/($numtocaka);


	$res=($map->extent->maxx-$map->extent->minx)/50;


//Dio gdje Grass treba prilagoditi

	$n=$map->extent->maxy;
	$s=$map->extent->miny;
	$e=$map->extent->maxx;
	$w=$map->extent->minx;



	$Wind_dirAsc_temp=$WebDir."/user_files/$korisnik/wind_dir_temp.asc";
	$Wind_speedAsc_temp=$WebDir."/user_files/$korisnik/wind_speed_temp.asc";

	/*system("g.region rast=$rastForWindRegion n=$n s=$s w=$w e=$e res=$res  > $WebDir/files/wind_temp.log ");

	system("g.remove rast='wind_dir_temp_$korisnik' >> $WebDir/files/wind_temp.log");
	system("r.in.arc input=$Wind_dirAsc output=wind_dir_temp_$korisnik type=FCELL mult=1.0 >> $WebDir/files/wind_temp.log ");
	system("r.out.arc input=wind_dir_temp_$korisnik output=$Wind_dirAsc_temp dp=1 >> $WebDir/files/wind_temp.log");
	
	system("g.remove rast='wind_speed_temp_$korisnik' >> $WebDir/files/wind_temp.log");
	system("r.in.arc input=$Wind_speedAsc output=wind_speed_temp_$korisnik type=FCELL mult=1.0  >> $WebDir/files/wind_temp.log");
	system("r.out.arc input=wind_speed_temp_$korisnik output=$Wind_speedAsc_temp dp=2 >> $WebDir/files/wind_temp.log");*/
	
	
	/*$nstt="g.region rast=$rastForWindRegion n=$n s=$s w=$w e=$e res=$res  > $WebDir/files/wind_temp.log
	g.remove rast='wind_dir_temp_$korisnik' >> $WebDir/files/wind_temp.log
	r.in.arc input=$Wind_dirAsc output=wind_dir_temp_$korisnik type=FCELL mult=1.0 >> $WebDir/files/wind_temp.log
	r.out.arc input=wind_dir_temp_$korisnik output=$Wind_dirAsc_temp dp=1 >> $WebDir/files/wind_temp.log
	
	g.remove rast='wind_speed_temp_$korisnik' >> $WebDir/files/wind_temp.log
	r.in.arc input=$Wind_speedAsc output=wind_speed_temp_$korisnik type=FCELL mult=1.0  >> $WebDir/files/wind_temp.log
	r.out.arc input=wind_speed_temp_$korisnik output=$Wind_speedAsc_temp dp=2 >> $WebDir/files/wind_temp.log";


					$filename="$WebDir/user_files/$korisnik/calculate_wind_temp_1.sh";
					$fp = fopen($filename, 'w');
					fwrite($fp, $nstt);
					fclose($fp);*/

					/*$stringps="$WebDir/user_files/$korisnik/launch_wind_temp_1.sh";
					$ps = $this->run_in_background($stringps);
					while($this->is_process_running($ps))
					{
						session_write_close();
						sleep(1);
						ob_flush;
						flush();
					}*/
	

//

	$wind_d=loadFromAsc($Wind_dirAsc_temp, $map->extent->minx, $map->extent->miny, $x_step, $y_step, $numtocaka, false);
	
	$wind_s=loadFromAsc($Wind_speedAsc_temp, $map->extent->minx, $map->extent->miny, $x_step, $y_step, $numtocaka, true);

	$points=Array();




	for($i=0;$i<$numtocaka;$i++)
	{
		for($j=0;$j<$numtocaka;$j++)
		{

			$wind_d[$j][$i]=-$wind_d[$j][$i]-90;
			
			$myclass->label->set("size", 23);
			$myclass->label->set("angle", $wind_d[$j][$i]);
			if(is_string($wind_s[$j][$i]))
			{
				$myclass->label->color->setRGB(255,15,0);
			}
			else
			{
				$myclass->label->color->setRGB(0,0,0);
			}
 			$points[$i][$j] = windPoint($map->extent->minx + $i*$x_step+($x_step/2), $map->extent->miny+$j*$y_step+($y_step/2));


			if($wind_d[$j][$i]!=-9999)
			{
				$points[$i][$j]->draw($map, $mylayer, $image, 0, $wind_s[$j][$i]);
			}
		}
	}

	$map->drawLabelCache($image);

}

//***************************************************************************************************//
// PRIMJER KORISTENJA
//
//	Nije provjerena funkcionalnost, samo je pokazan princip koristenja...
//
//***************************************************************************************************//
//Marin//

/*
$map_file="***.map";
$map = ms_newMapObj($map_file);

if($enableWind && isset($_POST["wind"]))
{
	$mylayer = ms_newLayerObj($map);
	$myclass = ms_newClassObj($mylayer);
	$mystyle = ms_newStyleObj($myclass);
	prepareWind($map, $mylayer, $myclass, $mystyle, $numtocaka, $x_step, $y_step);
}


$map_granice = $map->extent->minx." ".$map->extent->miny." ".$map->extent->maxx." ".$map->extent->maxy;
$image=$map->draw();

if($enableWind && isset($_POST["wind"]))
{
	drawWind($map,$WindAsc,$mylayer,$myclass, $numtocaka, $image);
}

$image_url=$image->saveWebImage();
*/
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//
/*
for($i=0;$i<count($layers);$i++)
{
?>
<input type='checkbox' name="layer<?php echo $i?>"
<?php if($layers[$i]->status) echo "checked";?>>
<span class="style2"><?php echo $layers[$i]->name ?><br>
<?php
}
?>
<?php
if($enableWind)
{
?>
	<input type='checkbox' name="wind"
	<?php if(isset($_POST["wind"])) echo "checked";?>>
	<span class="style2">Wind<br>
<?php
}
*/

?>
</body>
</html>