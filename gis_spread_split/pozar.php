<?php

set_time_limit(320);
ini_set('memory_limit', '528M');







//********************************************************************************************
// Iz userdefault foldera se koriste podaci, te se prilagođavaju na različite načine 
// korisniku, uglavnom mijenjanjem calculate_xxx fileova i map file-a.
//********************************************************************************************

function get_line ($arg_handle, $arg_delimiter = NULL)
{
  $delimiter = (NULL !== $arg_delimiter) ? $arg_delimiter : chr(10);
  $result    = array();

  while ( ! feof($arg_handle))
  {
    $currentCharacter = fgetc($arg_handle);

    if ($delimiter === $currentCharacter)
    {
      return implode('', $result);
    }

    $result[] = $currentCharacter;
  }

  return implode('', $result);
}











/////Fire za API
function fire2($WebDir, $rastForRegion, $MonImgName, $max_resolution, $korisnik, $coodr1, $coodr2, $type, $spread_vrijeme_js, $slider_value_js, $spread_comp_js, $step, $grassmapset, $chosenFuelModel, $perimeters, $chosenIgnition, $waitForExecution=false, $meteoArchiveDir, $external_param_file_AlbiniDefault, $external_param_file_ScottDefault, $external_param_file_AlbiniCustom, $external_param_file_ScottCustom, $barriers, $calculate_ROS_enabled, $rastForModel, $rastForAspect, $rastForSlope) 
{
	//Log
	
	$stringLog=date("Y/m/d h:i:s")." ".$korisnik."
"; 
	$file = $WebDir."/user_files/log.txt";
	// Open the file to get existing content
	$current = file_get_contents($file);
	// Append a new person to the file
	$current .= $stringLog;
	// Write the contents back to the file
	file_put_contents($file, $current);
	
	$currentFolderName="current";
	
	/*$zadarMode=true;
	if($zadarMode)
	{
		$currentFolderName="currentZadar";
	}*/

	
	/*Prvo priprema barijera*/
	
	if(!file_exists($WebDir."/user_files/$korisnik/barriers"))
	{
		copy($WebDir."/userdefault/crontab", $WebDir."/user_files/$korisnik/barriers");
		chmod($WebDir."/user_files/$korisnik/barriers", 0777);
	}
	
	$filename=$WebDir."/user_files/$korisnik/barriers";
	$fh = fopen($filename, 'w') or die("can't open file");
	fwrite($fh, $barriers);
	fclose($fh);
	
	
	/***/
	
	/*if(($chosenFuelModel=="Albini_custom" || $chosenFuelModel=="Scott_default" || $chosenFuelModel=="Scott_custom") && $type==1)
	{
		echo 'alert("Not yet supported!");';
		return;
	}*/

	$_POST['spread_vrijeme']=$spread_vrijeme_js;

	//od 1 do 20
	$_POST['slider_value']=$slider_value_js;

	$_POST['spread_comp']=$spread_comp_js;
	


	//Random number koji se koristi radi visekorisnickog sustava
	$rand=rand(1000000, 9999999);
	
	//file_put_contents("$WebDir/user_files/$korisnik/tempFileNow", $WebDir." ".$rastForRegion." ".$MonImgName." ".$max_resolution." ".$korisnik." ".$coodr1." ".$coodr2." ".$type." ".$spread_vrijeme_js." ".$slider_value_js." ".$spread_comp_js." ".$step." ".$grassmapset." ".$chosenFuelModel." ".$perimeters." ".$chosenIgnition." ".$waitForExecution);
	
	//Prilikom postavljanja novog servera, cesto ne radi fire2 jer nije osposobljen mapscript
	
	//$projOutObj =ms_newprojectionobj("proj=tmerc,ellps=WGS84,units=m,lon_0=15,k=0.9999,x_0=6500000,y_0=0,no_defs");
	$projOutObj =ms_newprojectionobj("init=epsg:900913");

	$projInObj = ms_newprojectionObj ("proj=longlat,ellps=WGS84,no_defs" );
    $poPoint = ms_newpointobj();
    $poPoint->setXY($coodr2, $coodr1); //original coordinates
    $poPoint->project($projInObj, $projOutObj);	
	
	$coodr1=$poPoint->x;
	$coodr2=$poPoint->y;
	
	$click[0]=$coodr1;
	$click[1]=$coodr2;
	
	
	

	$checkros="$WebDir/user_files/$korisnik/checkros.sh";
	$fh2 = fopen($checkros, 'r') or die("can't open file");
	$stringforrandfind20 = fread($fh2, filesize($checkros));
	fclose($fh2);

    $delimeterLeft="#Start";
    $delimeterRight="#End";
    $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
    $stringcheck=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);


	$stringchecknewdefault="
g.list rast > '$WebDir/files/glist.log'

g.mapset mapset=$korisnik
   #history -w
   #history -r /$GISDBASE/$LOCATION/$MAPSET/.bash_history
   #HISTFILE=/$GISDBASE/$LOCATION/$MAPSET/.bash_history
   
 g.list rast > '$WebDir/user_files/$korisnik/glist.log'
";

	setIntoFile ($checkros, $stringcheck,$stringchecknewdefault);

	$stringps="$WebDir/user_files/$korisnik/checkros_launch.sh";
	$ps = run_in_backgroundPozar($stringps);
	while(is_process_runningPozar($ps))
	{
		session_write_close();
		sleep(1);
		ob_flush;
		flush();
	}


	//echo 'alert("'.$click[0].' '.$click[1].'");';
	
	
	
	$myFile = "$WebDir/files/glist.log";
	$fh = fopen($myFile, 'r');
	$theData2 = fread($fh, filesize($myFile));
	fclose($fh);
	$glistarray=preg_split("/[\s+,\t+,\n+]/", $theData2);
	
	
	$myFile22 = "$WebDir/user_files/$korisnik/glist.log";
	$fh22 = fopen($myFile22, 'r');
	$theData222 = fread($fh22, filesize($myFile22));
	fclose($fh22);
	$glistarray22=preg_split("/[\s+,\t+,\n+]/", $theData222);

	
	$isRosCalculated=0;
	$isVlastitiRosCalculated=0;
	
	//Check current ROS
	for($i = 0; $i < count($glistarray); $i++)
	{
		if( !strcmp(trim($glistarray[$i]),"my_ros.maxdir") || !strcmp(trim($glistarray[$i]),"my_ros.base") ||  !strcmp(trim($glistarray[$i]),"my_ros.max") )
			$isRosCalculated++;
	}
	
	//Now check custom ROS
	for($i = 0; $i < count($glistarray22); $i++)
	{
		
		
		if( !strcmp(trim($glistarray22[$i]),"my_ros_$korisnik"."_$chosenFuelModel.maxdir") || !strcmp(trim($glistarray22[$i]),"my_ros_$korisnik"."_$chosenFuelModel.base") ||  !strcmp(trim($glistarray22[$i]),"my_ros_$korisnik"."_$chosenFuelModel.max") )
		{
			
			$isVlastitiRosCalculated++;
		}
	}
	
	//echo 'alert("a'.$isVlastitiRosCalculated.'a");';
	
	
	if($isRosCalculated<3 && $type==1 && $calculate_ROS_enabled)
	{
	
		echo 'alert("Main ROS not calculated");';
			
	}
	else if($isVlastitiRosCalculated<3 && $type==2 && $calculate_ROS_enabled)
	{
	
		echo 'alert("Custom ROS not calculated");';
			
	}
	else
	{
		
		
		//Provjeriti je li racunanje ros u tijeku
		$myFile = "$WebDir/files/process.log";
		$fh = fopen($myFile, 'r');
		$theData = fread($fh, filesize($myFile));
		fclose($fh);

		
		

		if(is_process_runningPozar($theData) && $calculate_ROS_enabled)
		{
			echo 'alert("Main ROS calculation in progress! Please try again later!");';
			return;
			
		}
		else
		{
			
			
			//$click=click2currentmap($WebDir, $rastForRegion, $MonImgName, $korisnik);
			system ("echo ".$click[0]."'|'".$click[1]. "'|'1 > $WebDir/user_files/$korisnik/ascii_$korisnik.txt");

			//Poveca se region da se odredi smjer

			//Odredi se u kojem je smjeru vjetar najizrazeniji


			
			
			$stringtempnewdefault="Begin";
			
				
			
			
			/*//$type==1 trenutni
			if($type==1)
			{
				$stringtempnewdefault="
g.mremove rast=\"*_temp_for_current*\" -f	
g.mapset mapset=$grassmapset
g.region rast=$rastForRegion@$grassmapset res=2000;
r.in.arc input=$meteoArchiveDir/current/wind_dir.asc output=w_dir1_temp_for_current type=FCELL mult=1.0
r.in.arc input=$meteoArchiveDir/current/wind_speed.asc output=w_speed1_temp_for_current type=FCELL mult=1.0
g.region rast=w_speed1_temp_for_current res=10000000000000000
r.stats input=w_dir1_temp_for_current,w_speed1_temp_for_current fs=space nv=* nsteps=1 -1 -n";


				$wind_stats=executeGRASS($WebDir, $korisnik, $stringtempnewdefault);
					//return $wind_stats;
			}
			if($type==2)
			{
				$stringtempnewdefault="
g.mremove rast=\"*_temp_for_current*\" -f	
g.mapset mapset=$korisnik
g.region rast=$rastForRegion@$grassmapset res=2000;
r.in.arc input=$WebDir/user_files/$korisnik/wind_dir.asc output=w_dir1_temp_for_current type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/wind_speed.asc output=w_speed1_temp_for_current type=FCELL mult=1.0
g.region rast=w_speed1_temp_for_current res=10000000000000000
r.stats input=w_dir1_temp_for_current,w_speed1_temp_for_current fs=space nv=* nsteps=1 -1 -n";

				$wind_stats=executeGRASS($WebDir, $korisnik, $stringtempnewdefault);
				
			

			}*/
			
			
			$west=$click[0]-100000;
			$east=$click[0]+100000;
			$south=$click[1]-100000;
			$north=$click[1]+100000;
			
			
			
			//Ako je riječ o fire perimeters, treba gledati drugačije, više nema veze sa clickom
			/*Prvo priprema perimeters*/
	
				if(!file_exists($WebDir."/user_files/$korisnik/perimeters"))
				{
					copy($WebDir."/userdefault/crontab", $WebDir."/user_files/$korisnik/perimeters");
					chmod($WebDir."/user_files/$korisnik/perimeters", 0777);
				}
				
				$filename=$WebDir."/user_files/$korisnik/perimeters";
				$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $perimeters);
				fclose($fh);
				
				
				/***/
			
			if($perimeters!="" && $chosenIgnition=="perimeterIgnition")
			{
				$fullstringPerimeters = file_get_contents("$WebDir/user_files/$korisnik/perimeters");
				$parsed = get_string_between($fullstringPerimeters, 'A', '=255 fire_perimeter');

				$minLat=999999999999;
				$maxLat=-10;
				$minLong=999999999999;
				$maxLong=-10;



				for($brPerim=0;$brPerim<count($parsed)-1;$brPerim++)
				{
					$explodPerim = multiexplode(array(" ","\n"),$parsed[$brPerim]);
					for($br2Perim=0;$br2Perim<count($explodPerim); $br2Perim++)
					{
						if($br2Perim%2==0)
						{
							if(floatval($explodPerim[$br2Perim])<$minLat) $minLat = floatval($explodPerim[$br2Perim]);
							if(floatval($explodPerim[$br2Perim]>$maxLat)) $maxLat = floatval($explodPerim[$br2Perim]);
						}
						else
						{
							if(floatval($explodPerim[$br2Perim])<$minLong) $minLong = floatval($explodPerim[$br2Perim]);
							if(floatval($explodPerim[$br2Perim])>$maxLong) $maxLong = floatval($explodPerim[$br2Perim]);
						}
					}

				}
				
				//echo $minLat." ".$maxLat." ".$minLong." ".$maxLong;
			
				$west=$minLat-100000;
				$east=$maxLat+100000;
				$south=$minLong-100000;
				$north=$maxLong+100000;
				
				
			}
			
			
			if($type==1)
			{
				//ovo treba popraviti pametno, ne smije se ovo raditi u rassmapsetu PAZI
				//treba vec bit ucitano u WebGis, pa onda povuc i obradit u korisnik
				$stringtempnewdefault="
g.mapset mapset=$korisnik
g.mremove rast=\"*_temp_for_current*\" -f	
g.region n=$north s=$south e=$east w=$west res=1000;
r.in.arc input=$meteoArchiveDir/$currentFolderName/wind_dir.asc output=w_dir1_temp_for_current type=FCELL mult=1.0
r.in.arc input=$meteoArchiveDir/$currentFolderName/wind_speed.asc output=w_speed1_temp_for_current type=FCELL mult=1.0
r.in.arc input=$meteoArchiveDir/$currentFolderName/mois_live.asc output=mois_live1_temp_for_current type=FCELL mult=1.0
r.in.arc input=$meteoArchiveDir/$currentFolderName/mois1h.asc output=mois_1h1_temp_for_current type=FCELL mult=1.0
g.region n=$north s=$south e=$east w=$west res=1000;
r.mapcalc mois_together_temp_for_current=mois_live1_temp_for_current/2 + mois_1h1_temp_for_current/2
r.mapcalc w_dir2_temp_for_current=w_dir1_temp_for_current-180
r.mapcalc w_speed2_temp_for_current=w_speed1_temp_for_current*54.68
r.reclass input=modelAlbini@$grassmapset --overwrite output=wind_correction rules=$WebDir/user_files/$korisnik/reclass_WindCorrection.r
r.mapcalc w_speed2_temp_for_current=w_speed2_temp_for_current*wind_correction/100
g.remove rast=wind_correction
r.ros -v model=modelAlbini@$grassmapset moisture_live=mois_live1_temp_for_current moisture_1h=mois_1h1_temp_for_current velocity=w_speed2_temp_for_current direction=w_dir2_temp_for_current slope=$rastForSlope@$grassmapset aspect=$rastForAspect@$grassmapset  output=my_ros1_temp_for_current
g.region n=$north s=$south e=$east w=$west res=10000000000000000
r.stats input=w_dir1_temp_for_current,w_speed1_temp_for_current,mois_together_temp_for_current,my_ros1_temp_for_current.max fs=space nv=* nsteps=1 -1 -n";



				$wind_stats=executeGRASS($WebDir, $korisnik, $stringtempnewdefault);
					//return $wind_stats;
			}
			if($type==2)
			{
				//treba sredit da je wind vec ucitan
				$stringtempnewdefault="
g.mapset mapset=$korisnik
g.mremove rast=\"*_temp_for_current*\" -f	
g.region n=$north s=$south e=$east w=$west res=1000;
r.in.arc input=$WebDir/user_files/$korisnik/wind_dir.asc output=w_dir1_temp_for_current type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/wind_speed.asc output=w_speed1_temp_for_current type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/mois_live.asc output=mois_live1_temp_for_current type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/mois1h.asc output=mois_1h1_temp_for_current type=FCELL mult=1.0
g.region n=$north s=$south e=$east w=$west res=1000;
r.mapcalc mois_together_temp_for_current=mois_live1_temp_for_current/2 + mois_1h1_temp_for_current/2
r.mapcalc w_dir2_temp_for_current=w_dir1_temp_for_current-180
r.mapcalc w_speed2_temp_for_current=w_speed1_temp_for_current*54.68
r.reclass input=modelAlbini@$grassmapset --overwrite output=wind_correction rules=$WebDir/user_files/$korisnik/reclass_WindCorrection.r
r.mapcalc w_speed2_temp_for_current=w_speed2_temp_for_current*wind_correction/100
g.remove rast=wind_correction
r.ros -v model=modelAlbini@$grassmapset moisture_live=mois_live1_temp_for_current moisture_1h=mois_1h1_temp_for_current velocity=w_speed2_temp_for_current direction=w_dir2_temp_for_current slope=$rastForSlope@$grassmapset aspect=$rastForAspect@$grassmapset  output=my_ros1_temp_for_current
g.region n=$north s=$south e=$east w=$west res=10000000000000000
r.stats input=w_dir1_temp_for_current,w_speed1_temp_for_current,mois_together_temp_for_current,my_ros1_temp_for_current.max fs=space nv=* nsteps=1 -1 -n";

				$wind_stats=executeGRASS($WebDir, $korisnik, $stringtempnewdefault);
				
			

			}
			
			
			$wind_array_stats=explode(" ",$wind_stats);		
			
			
		
					

			
			$wind_array_stats[0] = $wind_array_stats[0] % 360;
			$wind_array_stats[0]=$wind_array_stats[0]+180;		
			$wind_array_stats[1]=(float)$wind_array_stats[1]/54.68;
			$wind_array_stats[2]=(float)$wind_array_stats[2];
			$wind_array_stats[3]=(float)$wind_array_stats[3];
			

			
			//izvuc average ROS max za okolno podrucje
			$averageROSmax=$wind_array_stats[3];
			//brzina vjetra u km/h
			$windInkmH=$wind_array_stats[1]*54.68*0.25;
			//uzet u obzir average ROS max i brzinu vjetra i nekako odredit averageRES
			$averageRes=0.45*($averageROSmax/300+50+($windInkmH*3.5));
			//ipak se ograničit na interval 50 do 800
			if($averageRes>800) $averageRes=800;
			if($averageRes<50) $averageRes=50;
			//Ako je voda ili drugo negorivo područje
			
			//echo 'alert(" averageRos je '.$averageROSmax.'");';
			if($averageROSmax/200 <= 0) $averageRes=8000;
			//echo 'alert(" averageRos je '.$averageROSmax.'");';


			//treba i average pisture da se procijeni area za proracun
			$averageMoisture =$wind_array_stats[2];				
			if($averageMoisture<2) $averageMoisture=2;
			
			
			//treba i wind i duration
			$multiply_wind=sqrt($wind_array_stats[1]);
			$multiply_duration=$_POST['spread_vrijeme']/120;
			if($multiply_duration<1) $multiply_duration=1;
			//if($wind_array_stats[1]>3) $multiply_wind=$multiply_wind/4;
			$multiply_wind=$multiply_wind*7;
			if($multiply_wind>10) $multiply_wind=10;
			
			
		
			$area_min=3000;
			$area_max=300000;
			
			$baseValue=11000;
			if($perimeters!="" && $chosenIgnition=="perimeterIgnition")
			{
				$baseValue=$baseValue*1.5;
			}
			
			$area_default=$baseValue*pow($multiply_wind,1.5)*pow($multiply_duration,0.8)/(pow($averageMoisture,0.6));
			if($area_default<3500) $area_default=3500;
			//$area_default=3500*pow($averageROSmax,1.035)*pow($multiply_duration,1.03)/(pow($averageMoisture,0.25));
			
			//Ako je voda ili negorivo, area je samo 500
			if($averageROSmax/200 <= 0) 
			{
				$area_default =500;
				//echo 'alert(" averageRos je '.$averageROSmax.'");';
			}
				
			
			//echo 'alert(" '.$a.'* '.$b.' / '.$c.'");';	
			/*return;*/			

			
			$area_e=$area_default;
			$area_w=$area_default;
			$area_n=$area_default;
			$area_s=$area_default;
			
			

			
			//koji je srednji smjer vjetra...
			//ovo je bilo pogrešno
			/*if($wind_array_stats[0]>=0 && $wind_array_stats[0]<=90)
			{
				$area_w+=$area_default;
				$area_s+=$area_default;
			}
			if($wind_array_stats[0]>=90 && $wind_array_stats[0]<=180)
			{
				$area_w+=$area_default;
				$area_n+=$area_default;
			}
			if($wind_array_stats[0]>=180 && $wind_array_stats[0]<=270)
			{
				$area_n+=$area_default;
				$area_e+=$area_default;
			}
			if($wind_array_stats[0]>=270 && $wind_array_stats[0]<=360)
			{
				$area_e+=$area_default;
				$area_s+=$area_default;
			}*/
			
			
			
			
			//Prva dva u biti su nebitna, zbog onih +180
			if($wind_array_stats[0]>=0 && $wind_array_stats[0]<=90)
			{
				$area_e+=$area_default;
				$area_n+=$area_default;
			}
			if($wind_array_stats[0]>=90 && $wind_array_stats[0]<=180)
			{
				$area_e+=$area_default;
				$area_s+=$area_default;
			}
			if($wind_array_stats[0]>=180 && $wind_array_stats[0]<=270)
			{
				$area_s+=$area_default;
				$area_w+=$area_default;
			}
			if($wind_array_stats[0]>=270 && $wind_array_stats[0]<=360)
			{
				$area_w+=$area_default;
				$area_n+=$area_default;
			}
			if($wind_array_stats[0]>=360 && $wind_array_stats[0]<=450)
			{
				$area_e+=$area_default;
				$area_n+=$area_default;
			}
			if($wind_array_stats[0]>=450 && $wind_array_stats[0]<=540)
			{
				$area_e+=$area_default;
				$area_s+=$area_default;
			}
			

			$west=$click[0]-$area_w;
			$east=$click[0]+$area_e;
			$south=$click[1]-$area_s;
			$north=$click[1]+$area_n;
			
			
			
			if($perimeters!="" && $chosenIgnition=="perimeterIgnition")
			{
				$fullstringPerimeters = file_get_contents("$WebDir/user_files/$korisnik/perimeters");
				$parsed = get_string_between($fullstringPerimeters, 'A', '=255 fire_perimeter');

				$minLat=999999999999;
				$maxLat=-10;
				$minLong=999999999999;
				$maxLong=-10;



				for($brPerim=0;$brPerim<count($parsed)-1;$brPerim++)
				{
					$explodPerim = multiexplode(array(" ","\n"),$parsed[$brPerim]);
					for($br2Perim=0;$br2Perim<count($explodPerim); $br2Perim++)
					{
						if($br2Perim%2==0)
						{
							if(floatval($explodPerim[$br2Perim])<$minLat) $minLat = floatval($explodPerim[$br2Perim]);
							if(floatval($explodPerim[$br2Perim]>$maxLat)) $maxLat = floatval($explodPerim[$br2Perim]);
						}
						else
						{
							if(floatval($explodPerim[$br2Perim])<$minLong) $minLong = floatval($explodPerim[$br2Perim]);
							if(floatval($explodPerim[$br2Perim])>$maxLong) $maxLong = floatval($explodPerim[$br2Perim]);
						}
					}

				}
				
				//echo $minLat." ".$maxLat." ".$minLong." ".$maxLong;
			
				$west=$minLat-$area_w;
				$east=$maxLat+$area_e;
				$south=$minLong-$area_s;
				$north=$maxLong+$area_n;
				
				
			}
			
						
			
			//save region in latlon format in output file
			if(!file_exists("$WebDir/user_files/$korisnik/raster/bbox.txt"))
			{
				copy($WebDir."/userdefault/spread_rast.tfw", "$WebDir/user_files/$korisnik/raster/bbox.txt");
				chmod("$WebDir/user_files/$korisnik/raster/bbox.txt", 0777);
			}
			$projInTemp =ms_newprojectionobj("init=epsg:900913");
			$projOutTemp = ms_newprojectionObj ("proj=longlat,ellps=WGS84,no_defs" );
			$poPointTemp = ms_newpointobj();
			$poPointTemp->setXY($west, $south); //original coordinates
			$poPointTemp->project($projInTemp, $projOutTemp);				
			$coodr1Temp=$poPointTemp->x;
			$coodr2Temp=$poPointTemp->y;
			$poPointTemp2 = ms_newpointobj();
			$poPointTemp2->setXY($east, $north); //original coordinates
			$poPointTemp2->project($projInTemp, $projOutTemp);				
			$coodr3Temp=$poPointTemp2->x;
			$coodr4Temp=$poPointTemp2->y;
			$textToSave = $coodr1Temp."|".$coodr2Temp."|".$coodr3Temp."|".$coodr4Temp;
			//$textToSave = $west."|".$east."|".$south."|".$north;
			file_put_contents("$WebDir/user_files/$korisnik/raster/bbox.txt", $textToSave);


			$area_ew=$area_e+$area_w;
			$area_sn=$area_s+$area_n;

			if($area_sn>=$area_ew)	$area=$area_sn/2;
			else $area=$area_ew/2;
			
			
					

			
			if($area>$area_max) $area=$area_max;
			if($area<$area_min) $area=$area_min;
			
			
			//nastavak proracuna rezolucije, još treba uzeti u obzir i trajanje vatre
			$min_dozvoljen_res=1.5*$averageRes*pow($multiply_duration,0.4);
			if($perimeters!="" && $chosenIgnition=="perimeterIgnition")
			{
				$min_dozvoljen_res=2*$min_dozvoljen_res;
			}
			
			//max rezolucija je duplo bolja
			if($min_dozvoljen_res<=150) $max_dozvoljen_res=15;
			if($min_dozvoljen_res>150 && $min_dozvoljen_res<=200) $max_dozvoljen_res=50;
			if($min_dozvoljen_res>200) $max_dozvoljen_res=60; //$max_dozvoljen_res=$min_dozvoljen_res/3;
			
			

			$korak = ($min_dozvoljen_res-$max_dozvoljen_res) / 19;
			$trenutni_res=floor($min_dozvoljen_res-($_POST['slider_value']-1)*$korak);
			
			//echo 'alert("min: '.$min_dozvoljen_res.' max: '.$max_dozvoljen_res.' trenutni: '.$trenutni_res.' multiply_wind: '.$multiply_wind.'");';
			//return;
			
			
			
			//$trenutni_res=2000;			
			//$trenutni_res=$trenutni_res*4;
			
			
			$filename="$WebDir/user_files/$korisnik/calculate_spread_res.sh";

			
			
			
			
			//trenutni
			if($type==1)
			{

				$new_text="
   g.mapset mapset=$korisnik
	g.mremove -f rast=\"start*\"
	g.mremove -f vect=\"contour*\"
	g.mremove -f vect=\"points*\"
	g.mremove -f rast=\"my_spre*\"
	
g.remove rast=my_ros.max,my_ros.base,my_ros.maxdir,my_ros.spotdist,w_speed1,mois_l

#g.copy rast=$rastForRegion@$grassmapset,$rastForRegion
#g.copy rast=my_ros.max@$grassmapset,my_ros.max
#g.copy rast=my_ros.base@$grassmapset,my_ros.base
#g.copy rast=my_ros.maxdir@$grassmapset,my_ros.maxdir
#g.copy rast=my_ros.spotdist@$grassmapset,my_ros.spotdist
#g.copy rast=w_speed1@$grassmapset,w_speed1
#g.copy rast=mois_l@$grassmapset,mois_l

g.region -d
g.region n=$north s=$south e=$east w=$west res=$trenutni_res";

			}

			if($type==2)
			{

				$new_text="
   g.mapset mapset=$korisnik
	g.mremove -f rast=\"start*\"
	g.mremove -f vect=\"contour*\"
	g.mremove -f vect=\"points*\"
	g.mremove -f rast=\"my_spre*\"

g.region -d
g.region n=$north s=$south e=$east w=$west res=$trenutni_res";

			}

			//Ovo treba izbacit jer je samo za kreiranje region_temp_for_current
			$new_text=$new_text."
g.region n=$north s=$south e=$east w=$west res=1000
g.remove rast=region_temp_for_current
r.mapcalc region_temp_for_current=255
r.out.tiff input=region_temp_for_current output=\"$WebDir/user_files/$korisnik/raster/region_temp_for_current\" compression=none -t 
g.region n=$north s=$south e=$east w=$west res=$trenutni_res
";
			
			
	
			//$new_text="g.region rast=el res=$trenutni_res";
			$fh = fopen($filename, 'w') or die("can't open file");
			fwrite($fh, $new_text);
			fclose($fh);

			$stringps_res="$WebDir/user_files/$korisnik/calculate_spread_res.sh";
			//$ps_res = run_in_backgroundPozar($stringps_res);
			//while(is_process_runningPozar($ps_res))
			//{
			//		sleep(1);
			//}

			

			$stringtempnewdefault="g.region rast=my_ros.base@$grassmapset
r.what input=my_ros.base@$grassmapset cache=500 null=* east_north=$click[0],$click[1]";
			
			$rosnotnull=executeGRASS($WebDir, $korisnik, $stringtempnewdefault);

			$rosnotnullarray=explode("||",$rosnotnull);
			

			
			
			
			if(/*$rosnotnullarray[count($rosnotnullarray)-1]!=0*/ $type==1 || $type==2)
			{
				

				//Dohvatiti Hellmanov koeficijent
				$fnameHellman="$WebDir/user_files/$korisnik/reclass_WindCorrection.r";
				$HellmanFullString=file_get_contents($fnameHellman);
				$HellmanResult=explode("99999 =", $HellmanFullString);
				$HellmanResultTemp=$HellmanResult[1];
				$HellmanResultFinal=round(pow((6.096/10),$HellmanResultTemp),2);
				
				//$HellmanResultFinal=print_r($HellmanResult);
				
				
				//Pripremanje dinamičke (radi foldera) calculate_spread skripte
				$spreadString1="g.remove vect=points\n";
				$spreadString2="v.in.ascii input='$WebDir/user_files/$korisnik/ascii_$korisnik.txt' format='point' output='points$rand'  fs='|'\n";		

				
				if($perimeters!="" && $chosenIgnition=="perimeterIgnition")
				{
					$spreadString3="#PERIMETERS
g.remove rast=my_spread,my_spread.x,my_spread.y,my_path,start$rand\n";
					//$spreadString4="v.to.rast input='points$rand' output='start$rand'  col=cat\n$perimeters ASDASDASD\n";
					$spreadString4="r.in.poly input=$WebDir/user_files/$korisnik/perimeters output='start$rand' --overwrite\n$perimeters\n$chosenIgnition";
				}
				else
				{
					$spreadString3="#POINT IGNITION
g.remove rast=my_spread,my_spread.x,my_spread.y,my_path,start$rand\n";
					$spreadString4="v.to.rast input='points$rand' output='start$rand'  col=cat\n";					
				}
				
				
	
				$myFile2 = "$WebDir/user_files/$korisnik/calculate_spread.sh";
				$fh2 = fopen($myFile2, 'w') or die("can't open file");
				$stringData2 = $spreadString1.$spreadString2.$spreadString3.$spreadString4;
				fwrite($fh2, $stringData2);
				fclose($fh2);
				

				//$stringps="$WebDir/user_files/$korisnik/calculate_spread.sh";
				//$ps = run_in_backgroundPozar($stringps);
				//
				//while(is_process_runningPozar($ps))
				//{
       			//		sleep(1);
				//}
			

				$spread_ctd="$WebDir/user_files/$korisnik/calculate_spread_ctd.sh";
				$dsn=getFromFile ($spread_ctd, " ", "=", "dsn");
				$spread_step=getFromFile($spread_ctd,' ', '=', 'step');
				setIntoFile ($spread_ctd, $dsn, "$WebDir/user_files/$korisnik/vector/");	
				
				
				//This is for service step config
				if(isset($step))
					$spread_step=$step;

				
				$fh2 = fopen($spread_ctd, 'r') or die("can't open file");
				$stringforrandfind20 = fread($fh2, filesize($spread_ctd));
				fclose($fh2);
				
				$delimeterLeft="#StartOutput";
				$delimeterRight="#EndOutput";
				$posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
				$posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
				$contourandtiff=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);

				if($spread_step>$_POST['spread_vrijeme'])
				{
					$spread_step=$_POST['spread_vrijeme'];
				}

				$contourandtiffnew="
r.contour input=my_spread$rand output=contour$rand step=$spread_step cut=0
v.info map=contour$rand > '$WebDir/user_files/$korisnik/glistSuccess.log'
r.out.tiff input=my_spread$rand output=\"$WebDir/user_files/KORISNIK/raster/spread_rast\" compression=none -t 
v.out.ogr input=contour$rand type=line,boundary dsn=$WebDir/user_files/KORISNIK/vector/ olayer=spread_shape layer=1 format=ESRI_Shapefile --overwrite
";				

				setIntoFile ($spread_ctd, $contourandtiff,$contourandtiffnew);



				$spread_res="$WebDir/user_files/$korisnik/calculate_spread_res.sh";
				$fh2 = fopen($spread_res, 'r') or die("can't open file");
				$stringforrandfind5 = fread($fh2, filesize($spread_res));
				fclose($fh2);


				setIntoFile ($spread_ctd, "KORISNIK",$korisnik); 

				$fh2 = fopen($spread_ctd, 'r') or die("can't open file");
				$stringforrandfind20 = fread($fh2, filesize($spread_ctd));
				fclose($fh2);
				
				
				
				
				
			    $delimeterLeft="#1Start1";
			    $delimeterRight="#1End1";
			    $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
			    $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
			    $stringspread=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);

				$lag=$_POST['spread_vrijeme'];
				$cdens=$_POST['spread_comp'];
				
				
				$ROSprecalculationForDefault="
g.mremove rast=\"*_temp_for_current*\" -f				
g.region res=$trenutni_res
r.in.arc input=$meteoArchiveDir/$currentFolderName//wind_dir.asc output=w_dir1_temp_for_current$rand type=FCELL mult=1.0
r.in.arc input=$meteoArchiveDir/$currentFolderName//wind_speed.asc output=w_speed1_temp_for_current$rand type=FCELL mult=1.0
r.mapcalc w_dir1_temp_for_current$rand=w_dir1_temp_for_current$rand-180
#Kalkulacija za vjetar (i prije backup)
#Za km/h u ft/min ide * 54.68
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*54.68
g.copy rast=w_speed1_temp_for_current$rand,latestWindspeedNonModified --overwrite
#0.87 je uzeto kao koeficijent da bi se izračunalo v20ft iz v10m (u tom je slucaju alfa = 0.28)
#Nova verzija racuna iz Hellman koeficijent
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*$HellmanResultFinal
";
if($chosenFuelModel=="Albini_default")
{
	$ROSprecalculationForDefault.="
r.reclass input=modelAlbini@$grassmapset --overwrite output=wind_correction rules=$WebDir/user_files/$korisnik/reclass_WindCorrection.r
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*wind_correction/100
g.remove rast=wind_correction
";
}
else if($chosenFuelModel=="Scott_default")
{
	$ROSprecalculationForDefault.="
r.reclass input=modelScott@$grassmapset --overwrite output=wind_correction rules=$WebDir/user_files/$korisnik/reclass_WindCorrection.r
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*wind_correction/100
g.remove rast=wind_correction
";
}
else if($chosenFuelModel=="Albini_custom")
{
	$ROSprecalculationForDefault.="
r.reclass input=modelAlbini --overwrite output=wind_correction rules=$WebDir/user_files/$korisnik/reclass_WindCorrection.r
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*wind_correction/100
g.remove rast=wind_correction
";
}
else if($chosenFuelModel=="Scott_custom")
{
	$ROSprecalculationForDefault.="
r.reclass input=modelScott --overwrite output=wind_correction rules=$WebDir/user_files/$korisnik/reclass_WindCorrection.r
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*wind_correction/100
g.remove rast=wind_correction
";
}
$ROSprecalculationForDefault.="

r.in.arc input=$meteoArchiveDir/$currentFolderName/mois_live.asc output=mois_temp_for_current$rand type=FCELL mult=1.0
r.in.arc input=$meteoArchiveDir/$currentFolderName/mois1h.asc output=mois_l_temp_for_current$rand type=FCELL mult=1.0
r.in.arc input=$meteoArchiveDir/$currentFolderName/mois10h.asc output=mois_l0_temp_for_current$rand type=FCELL mult=1.0
r.in.arc input=$meteoArchiveDir/$currentFolderName/mois100h.asc output=mois_l00_temp_for_current$rand type=FCELL mult=1.0
";
				$ROSprecalculationForDefaultEnding="g.mremove rast=\"*_temp_for_current*\" -f
";
				
				
				//Calculate ROS for current weather conditions for Albini_custom, Scott_default and Scott_custom
				if(($chosenFuelModel=="Albini_custom" || $chosenFuelModel=="Scott_default" || $chosenFuelModel=="Scott_custom" || $chosenFuelModel=="Albini_default") && $type==1 && !$calculate_ROS_enabled)
				{
					
					#TO BE DONE
					if( $chosenFuelModel=="Albini_default")
					{
						$strinspreadnewdefault2=$ROSprecalculationForDefault."
#PRECALCULATING ROS FOR Albini_default - current conditions
r.ros -v model=modelAlbini@$grassmapset moisture_live=mois_temp_for_current$rand moisture_1h=mois_l_temp_for_current$rand moisture_10h=mois_l0_temp_for_current$rand moisture_100h=mois_l00_temp_for_current$rand velocity=w_speed1_temp_for_current$rand direction=w_dir1_temp_for_current$rand slope=$rastForSlope@$grassmapset aspect=$rastForAspect@$grassmapset elevation=$rastForRegion@$grassmapset output=my_ros_temp_for_current$rand
r.in.poly input=$WebDir/user_files/$korisnik/barriers output=fireBarriers --overwrite 	
r.mapcalc my_ros_temp_for_current$rand.base = \"if(isnull(fireBarriers),my_ros_temp_for_current$rand.base,0)\"
#Copy ROS to latest, used for getInfo
g.region res=500
g.copy rast=my_ros_temp_for_current$rand.base,latestRos.base --overwrite 	
g.copy rast=my_ros_temp_for_current$rand.max,latestRos.max --overwrite 	
g.copy rast=my_ros_temp_for_current$rand.maxdir,latestRos.maxdir --overwrite
g.copy rast=mois_temp_for_current$rand,latestMoislive --overwrite
g.copy rast=mois_l_temp_for_current$rand,latestMois1h --overwrite
g.copy rast=mois_l0_temp_for_current$rand,latestMois10h --overwrite
g.copy rast=mois_l00_temp_for_current$rand,latestMois100h --overwrite
g.copy rast=w_speed1_temp_for_current$rand,latestWindspeed --overwrite
g.copy rast=w_dir1_temp_for_current$rand,latestWinddir --overwrite
#Finished copy
g.region res=$trenutni_res
r.spread -v max=my_ros_temp_for_current$rand.max base=my_ros_temp_for_current$rand.base dir=my_ros_temp_for_current$rand.maxdir spot_dist=my_ros_temp_for_current$rand.spotdist w_speed=w_speed1@$grassmapset f_mois=mois_l@$grassmapset start=start$rand output=my_spread$rand x_output=my_spread$rand.x y_output=my_spread$rand.y lag=$lag comp_dens=$cdens\n
".$ROSprecalculationForDefaultEnding;
					}
					else if( $chosenFuelModel=="Scott_default" )
					{
						$strinspreadnewdefault2=$ROSprecalculationForDefault."
#PRECALCULATING ROS FOR Scott_default - current conditions
r.ros -v model=modelScott@$grassmapset moisture_live=mois_temp_for_current$rand moisture_1h=mois_l_temp_for_current$rand moisture_10h=mois_l0_temp_for_current$rand moisture_100h=mois_l00_temp_for_current$rand velocity=w_speed1_temp_for_current$rand direction=w_dir1_temp_for_current$rand slope=$rastForSlope@$grassmapset aspect=$rastForAspect@$grassmapset elevation=$rastForRegion@$grassmapset output=my_ros_temp_for_current$rand external_param_file=\"$WebDir/user_files/$korisnik/$external_param_file_ScottDefault\"
r.in.poly input=$WebDir/user_files/$korisnik/barriers output=fireBarriers --overwrite 	
r.mapcalc my_ros_temp_for_current$rand.base = \"if(isnull(fireBarriers),my_ros_temp_for_current$rand.base,0)\"
g.region res=$trenutni_res
r.spread -v max=my_ros_temp_for_current$rand.max base=my_ros_temp_for_current$rand.base dir=my_ros_temp_for_current$rand.maxdir spot_dist=my_ros_temp_for_current$rand.spotdist w_speed=w_speed1@$grassmapset f_mois=mois_l@$grassmapset start=start$rand output=my_spread$rand x_output=my_spread$rand.x y_output=my_spread$rand.y lag=$lag comp_dens=$cdens\n
".$ROSprecalculationForDefaultEnding;
					}
					else if( $chosenFuelModel=="Scott_custom" )
					{
						$strinspreadnewdefault2=$ROSprecalculationForDefault."
#PRECALCULATING ROS FOR Scott_custom - current conditions
r.ros -v model=modelScott moisture_live=mois_temp_for_current$rand moisture_1h=mois_l_temp_for_current$rand moisture_10h=mois_l0_temp_for_current$rand moisture_100h=mois_l00_temp_for_current$rand velocity=w_speed1_temp_for_current$rand direction=w_dir1_temp_for_current$rand slope=$rastForSlope@$grassmapset aspect=$rastForAspect@$grassmapset elevation=$rastForRegion@$grassmapset output=my_ros_temp_for_current$rand  external_param_file=\"$WebDir/user_files/$korisnik/$external_param_file_ScottCustom\"
r.in.poly input=$WebDir/user_files/$korisnik/barriers output=fireBarriers --overwrite 	
r.mapcalc my_ros_temp_for_current$rand.base = \"if(isnull(fireBarriers),my_ros_temp_for_current$rand.base,0)\"
#Copy ROS to latest, used for getInfo
g.region res=500
g.copy rast=my_ros_temp_for_current$rand.base,latestRos.base --overwrite 
g.copy rast=my_ros_temp_for_current$rand.max,latestRos.max --overwrite
g.copy rast=my_ros_temp_for_current$rand.maxdir,latestRos.maxdir --overwrite
g.copy rast=mois_temp_for_current$rand,latestMoislive --overwrite
g.copy rast=mois_l_temp_for_current$rand,latestMois1h --overwrite
g.copy rast=mois_l0_temp_for_current$rand,latestMois10h --overwrite
g.copy rast=mois_l00_temp_for_current$rand,latestMois100h --overwrite
g.copy rast=w_speed1_temp_for_current$rand,latestWindspeed --overwrite
g.copy rast=w_dir1_temp_for_current$rand,latestWinddir --overwrite
#Finished copy
g.region res=$trenutni_res
r.spread -v max=my_ros_temp_for_current$rand.max base=my_ros_temp_for_current$rand.base dir=my_ros_temp_for_current$rand.maxdir spot_dist=my_ros_temp_for_current$rand.spotdist w_speed=w_speed1@$grassmapset f_mois=mois_l@$grassmapset start=start$rand output=my_spread$rand x_output=my_spread$rand.x y_output=my_spread$rand.y lag=$lag comp_dens=$cdens\n
".$ROSprecalculationForDefaultEnding;
					}
					else if( $chosenFuelModel=="Albini_custom" )
					{
						$strinspreadnewdefault2=$ROSprecalculationForDefault."
#PRECALCULATING ROS FOR Albini_custom - current conditions
r.ros -v model=modelAlbini moisture_live=mois_temp_for_current$rand moisture_1h=mois_l_temp_for_current$rand moisture_10h=mois_l0_temp_for_current$rand moisture_100h=mois_l00_temp_for_current$rand velocity=w_speed1_temp_for_current$rand direction=w_dir1_temp_for_current$rand slope=$rastForSlope@$grassmapset aspect=$rastForAspect@$grassmapset elevation=$rastForRegion@$grassmapset output=my_ros_temp_for_current$rand  external_param_file=\"$WebDir/user_files/$korisnik/$external_param_file_AlbiniCustom\"
r.in.poly input=$WebDir/user_files/$korisnik/barriers output=fireBarriers --overwrite 	
r.mapcalc my_ros_temp_for_current$rand.base = \"if(isnull(fireBarriers),my_ros_temp_for_current$rand.base,0)\"
#Copy ROS to latest, used for getInfo
g.region res=500
g.copy rast=my_ros_temp_for_current$rand.base,latestRos.base --overwrite
g.copy rast=my_ros_temp_for_current$rand.max,latestRos.max --overwrite
g.copy rast=my_ros_temp_for_current$rand.maxdir,latestRos.maxdir --overwrite
g.copy rast=mois_temp_for_current$rand,latestMoislive --overwrite
g.copy rast=mois_l_temp_for_current$rand,latestMois1h --overwrite
g.copy rast=mois_l0_temp_for_current$rand,latestMois10h --overwrite
g.copy rast=mois_l00_temp_for_current$rand,latestMois100h --overwrite
g.copy rast=w_speed1_temp_for_current$rand,latestWindspeed --overwrite
g.copy rast=w_dir1_temp_for_current$rand,latestWinddir --overwrite
#Finished copy
g.region res=$trenutni_res
r.spread -v max=my_ros_temp_for_current$rand.max base=my_ros_temp_for_current$rand.base dir=my_ros_temp_for_current$rand.maxdir spot_dist=my_ros_temp_for_current$rand.spotdist w_speed=w_speed1@$grassmapset f_mois=mois_l@$grassmapset start=start$rand output=my_spread$rand x_output=my_spread$rand.x y_output=my_spread$rand.y lag=$lag comp_dens=$cdens
".$ROSprecalculationForDefaultEnding;
					}
				}
				else //Riječ je o Albini_custom koji se nalazi u default mapsetu
				{			
					$strinspreadnewdefault2="
g.mremove rast=\"*_temp_for_current*\" -f		
g.copy rast=my_ros.base@$grassmapset,my_ros_temp_for_current$rand.base
r.in.poly input=$WebDir/user_files/$korisnik/barriers output=fireBarriers --overwrite 	
r.mapcalc my_ros_temp_for_current$rand.base = \"if(isnull(fireBarriers),my_ros_temp_for_current$rand.base,0)\"
#Copy ROS to latest, used for getInfo
g.region res=500
g.copy rast=my_ros_temp_for_current$rand.base,latestRos.base --overwrite
g.copy rast=my_ros_temp_for_current$rand.max,latestRos.max --overwrite
g.copy rast=my_ros_temp_for_current$rand.maxdir,latestRos.maxdir --overwrite
g.copy rast=mois_temp_for_current$rand,latestMoislive --overwrite
g.copy rast=mois_l_temp_for_current$rand,latestMois1h --overwrite
g.copy rast=mois_l0_temp_for_current$rand,latestMois10h --overwrite
g.copy rast=mois_l00_temp_for_current$rand,latestMois100h --overwrite
g.copy rast=w_speed1_temp_for_current$rand,latestWindspeed --overwrite
g.copy rast=w_dir1_temp_for_current$rand,latestWinddir --overwrite
#Finished copy
g.region res=$trenutni_res
r.spread -v max=my_ros.max@$grassmapset base=my_ros_temp_for_current$rand.base dir=my_ros.maxdir@$grassmapset spot_dist=my_ros.spotdist@$grassmapset w_speed=w_speed1@$grassmapset f_mois=mois_l@$grassmapset start=start$rand output=my_spread$rand x_output=my_spread$rand.x y_output=my_spread$rand.y lag=$lag comp_dens=$cdens 

";
	
				}

				setIntoFile ($spread_ctd, $stringspread,$strinspreadnewdefault2);

	
				$delimeterLeft="#2Start2";
				$delimeterRight="#2End2";
				$posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
				$posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
				$stringspread3=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);

				$strinspreadnewdefault3="
cat $WebDir/files/spread_color.log | r.colors map=my_spread$rand color=rules
";

				setIntoFile ($spread_ctd, $stringspread3,$strinspreadnewdefault3);
				
				
				
				
				//$realtimerange=getrange($WebDir, $korisnik, "my_spread$rand");
				//return $realtimerange;
				
				
				$stringforrandfind20 = file_get_contents($spread_ctd);
				
				$delimeterLeft="#StartRealTime";
				$delimeterRight="#EndRealTime";
				$posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
				$posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
				$rangeold=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);

				
				$rangenew="
r.info map=my_spread$rand -r >$WebDir/user_files/$korisnik/range.log
";

				setIntoFile ($spread_ctd, $rangeold,$rangenew);

				if($type==2)
				{
					$fh2 = fopen($spread_ctd, 'r') or die("can't open file");
					$stringforrandfind20 = fread($fh2, filesize($spread_ctd));
					fclose($fh2);

				   $delimeterLeft="#1Start1";
				   $delimeterRight="#1End1";
				   $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
				   $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
				   $stringspread=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);

					$lag=$_POST['spread_vrijeme'];
					$cdens=$_POST['spread_comp'];

					if($calculate_ROS_enabled)
					{
					//Ukoliko je uključeno računanje ROS-a
					$strinspreadnewdefault="
					
g.mremove rast=\"*_temp_for_current*\" -f

g.copy rast=my_ros_$korisnik"."_$chosenFuelModel.base,my_ros_temp_for_current$rand.base
r.in.poly input=$WebDir/user_files/$korisnik/barriers output=fireBarriers --overwrite 	
r.mapcalc my_ros_temp_for_current$rand.base = \"if(isnull(fireBarriers),my_ros_temp_for_current$rand.base,0)\"
#Copy ROS to latest, used for getInfo
g.region res=500
g.copy rast=my_ros_temp_for_current$rand.base,latestRos.base --overwrite
g.copy rast=my_ros_temp_for_current$rand.max,latestRos.max --overwrite
g.copy rast=my_ros_temp_for_current$rand.maxdir,latestRos.maxdir --overwrite
g.copy rast=mois_temp_for_current$rand,latestMoislive --overwrite
g.copy rast=mois_l_temp_for_current$rand,latestMois1h --overwrite
g.copy rast=mois_l0_temp_for_current$rand,latestMois10h --overwrite
g.copy rast=mois_l00_temp_for_current$rand,latestMois100h --overwrite
g.copy rast=w_speed1_temp_for_current$rand,latestWindspeed --overwrite
g.copy rast=w_dir1_temp_for_current$rand,latestWinddir --overwrite
#Finished copy
g.region res=$trenutni_res					
r.spread -v max=my_ros_$korisnik"."_$chosenFuelModel.max base=my_ros_temp_for_current$rand.base dir=my_ros_$korisnik"."_$chosenFuelModel.maxdir spot_dist=my_ros_$korisnik"."_$chosenFuelModel.spotdist w_speed=w_speed1_$korisnik f_mois=mois_l_$korisnik start=start$rand output=my_spread$rand x_output=my_spread$rand.x y_output=my_spread$rand.y lag=$lag comp_dens=$cdens 
";
					}
					else if(!$calculate_ROS_enabled)
					{
					/**************************************************/
					/***** CUSTOM ROS CALCULATION *********************/
					/**************************************************/
					$ROSprecalculationForDefault="
g.mremove rast=\"*_temp_for_current*\" -f				
g.region res=$trenutni_res
r.in.arc input=$WebDir/user_files/$korisnik/wind_dir.asc output=w_dir1_temp_for_current$rand type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/wind_speed.asc output=w_speed1_temp_for_current$rand type=FCELL mult=1.0
r.mapcalc w_dir1_temp_for_current$rand=w_dir1_temp_for_current$rand-180
#Kalkulacija za vjetar (i prije backup)
#Za km/h u ft/min ide * 54.68
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*54.68
g.copy rast=w_speed1_temp_for_current$rand,latestWindspeedNonModified --overwrite
#0.87 je uzeto kao koeficijent da bi se izračunalo v20ft iz v10m (u tom je slucaju alfa = 0.28)
#Nova verzija racuna iz Hellman koeficijent
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*$HellmanResultFinal
";
if($chosenFuelModel=="Albini_default")
{
	$ROSprecalculationForDefault.="
r.reclass input=modelAlbini@$grassmapset --overwrite output=wind_correction rules=$WebDir/user_files/$korisnik/reclass_WindCorrection.r
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*wind_correction/100
g.remove rast=wind_correction
";
}
else if($chosenFuelModel=="Scott_default")
{
	$ROSprecalculationForDefault.="
r.reclass input=modelScott@$grassmapset --overwrite output=wind_correction rules=$WebDir/user_files/$korisnik/reclass_WindCorrection.r
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*wind_correction/100
g.remove rast=wind_correction
";
}
else if($chosenFuelModel=="Albini_custom")
{
	$ROSprecalculationForDefault.="
r.reclass input=modelAlbini --overwrite output=wind_correction rules=$WebDir/user_files/$korisnik/reclass_WindCorrection.r
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*wind_correction/100
g.remove rast=wind_correction
";
}
else if($chosenFuelModel=="Scott_custom")
{
	$ROSprecalculationForDefault.="
r.reclass input=modelScott --overwrite output=wind_correction rules=$WebDir/user_files/$korisnik/reclass_WindCorrection.r
r.mapcalc w_speed1_temp_for_current$rand=w_speed1_temp_for_current$rand*wind_correction/100
g.remove rast=wind_correction
";
}
$ROSprecalculationForDefault.="

r.in.arc input=$WebDir/user_files/$korisnik/mois_live.asc output=mois_temp_for_current$rand type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/mois1h.asc output=mois_l_temp_for_current$rand type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/mois10h.asc output=mois_l0_temp_for_current$rand type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/mois100h.asc output=mois_l00_temp_for_current$rand type=FCELL mult=1.0
";

						//Ako je _default, mora ici @$grassmapset
						if($chosenFuelModel == "Albini_default")
						{
						$ROSmiddlecalculationForDefault="#ROS Albini_default - custom conditions	
r.ros -v model=$rastForModel@$grassmapset moisture_live=mois_temp_for_current$rand moisture_1h=mois_l_temp_for_current$rand moisture_10h=mois_l0_temp_for_current$rand moisture_100h=mois_l00_temp_for_current$rand velocity=w_speed1_temp_for_current$rand direction=w_dir1_temp_for_current$rand slope=$rastForSlope@$grassmapset aspect=$rastForAspect@$grassmapset elevation=$rastForRegion@$grassmapset output=my_ros_temp_for_current$rand
						";	
						}
						else
						{
							if( $chosenFuelModel=="Scott_default" )
							{
								$external_param_file=$external_param_file_ScottDefault;
								$modelToSimulate=$rastForModel."@$grassmapset";
							}
							else if( $chosenFuelModel=="Scott_custom" )
							{
								$external_param_file=$external_param_file_ScottCustom;
								$modelToSimulate=$rastForModel;
							}
							else if( $chosenFuelModel=="Albini_custom" )
							{
								$external_param_file=$external_param_file_AlbiniCustom;
								$modelToSimulate=$rastForModel;
							}
							else
							{
								$external_param_file="";
								$modelToSimulate=$rastForModel;
							}
							
							
						$ROSmiddlecalculationForDefault="#ROS $chosenFuelModel - custom conditions					
r.ros -v model=$modelToSimulate moisture_live=mois_temp_for_current$rand moisture_1h=mois_l_temp_for_current$rand moisture_10h=mois_l0_temp_for_current$rand moisture_100h=mois_l00_temp_for_current$rand velocity=w_speed1_temp_for_current$rand direction=w_dir1_temp_for_current$rand slope=$rastForSlope@$grassmapset aspect=$rastForAspect@$grassmapset elevation=$rastForRegion@$grassmapset output=my_ros_temp_for_current$rand external_param_file=\"$WebDir/user_files/$korisnik/$external_param_file\"
						";
							
						}

					
					$strinspreadnewdefault=$ROSprecalculationForDefault.$ROSmiddlecalculationForDefault."
r.in.poly input=$WebDir/user_files/$korisnik/barriers output=fireBarriers --overwrite 	
r.mapcalc my_ros_temp_for_current$rand.base = \"if(isnull(fireBarriers),my_ros_temp_for_current$rand.base,0)\"
#Copy ROS to latest, used for getInfo
g.region res=500
g.copy rast=my_ros_temp_for_current$rand.base,latestRos.base --overwrite
g.copy rast=my_ros_temp_for_current$rand.max,latestRos.max --overwrite
g.copy rast=my_ros_temp_for_current$rand.maxdir,latestRos.maxdir --overwrite
g.copy rast=mois_temp_for_current$rand,latestMoislive --overwrite
g.copy rast=mois_l_temp_for_current$rand,latestMois1h --overwrite
g.copy rast=mois_l0_temp_for_current$rand,latestMois10h --overwrite
g.copy rast=mois_l00_temp_for_current$rand,latestMois100h --overwrite
g.copy rast=w_speed1_temp_for_current$rand,latestWindspeed --overwrite
g.copy rast=w_dir1_temp_for_current$rand,latestWinddir --overwrite
#Finished copy
g.region res=$trenutni_res
r.spread -v max=my_ros_temp_for_current$rand.max base=my_ros_temp_for_current$rand.base dir=my_ros_temp_for_current$rand.maxdir spot_dist=my_ros_temp_for_current$rand.spotdist w_speed=w_speed1_temp_for_current$rand f_mois=mois_l_temp_for_current$rand start=start$rand output=my_spread$rand x_output=my_spread$rand.x y_output=my_spread$rand.y lag=$lag comp_dens=$cdens 
";	
						
					}

					setIntoFile ($spread_ctd, $stringspread,$strinspreadnewdefault);
				}

				$filename="$WebDir/user_files/$korisnik/calculate_spread_res.sh";
				$fh2 = fopen($filename, 'r') or die("can't open file");
				$stt1 = fread($fh2, filesize($filename));
				fclose($fh2);
				
				$filename="$WebDir/user_files/$korisnik/calculate_spread.sh";
				$fh2 = fopen($filename, 'r') or die("can't open file");
				$stt2 = fread($fh2, filesize($filename));
				fclose($fh2);
				
				$filename="$WebDir/user_files/$korisnik/calculate_spread_ctd.sh";
				$fh2 = fopen($filename, 'r') or die("can't open file");
				$stt3 = fread($fh2, filesize($filename));
				fclose($fh2);

				$nstt=$stt1."\n".$stt2."\n".$stt3;
				$filename="$WebDir/user_files/$korisnik/calculate_spread_launch.sh";
				$fp = fopen($filename, 'w');
				fwrite($fp, $nstt);
				fclose($fp);

				$stringps="$WebDir/user_files/$korisnik/launch.sh";
				$ps = run_in_backgroundPozar($stringps);

				
				if($waitForExecution && $waitForExecution!="false")
				{
					while(is_process_runningPozar($ps))
					{
						session_write_close();
						sleep(1);
						ob_flush;
						flush();
					}
				}
				
				
				
				
				$maxrange=getFromFile("$WebDir/user_files/$korisnik/range.log", "\n", "=", "max");
				

				$realtimefile="$WebDir/user_files/$korisnik/realtime.sh";
				$fh3 = fopen($realtimefile, 'r') or die("can't open file");
				$stringforrandfind30 = fread($fh3, filesize($realtimefile));
				fclose($fh3);
				

			   $delimeterLeft="#Start";
			   $delimeterRight="#End";
			   $posLeft  = stripos($stringforrandfind30,$delimeterLeft)+strlen($delimeterLeft);
			   $posRight = stripos($stringforrandfind30,$delimeterRight,$posLeft+1);
			   $realtimestring=substr($stringforrandfind30,$posLeft,$posRight-$posLeft);

			   $realtimestringnew="
g.region rast=my_spread$rand res=50
";
			 
//			   $step=50;
			   for($brojac=0;$brojac<$maxrange; $brojac=$brojac+$step)
			   {
			   	$realtimestringnew.="r.mapcalc \"x$brojac=if(my_spread$rand-$brojac,0,0,my_spread$rand)\"
";
			   				   	$realtimestringnew.="
g.region rast=my_spread$rand rast=x$brojac res=100
";
			   	$realtimestringnew.="cat $WebDir/files/spread_color.log | r.colors map=x$brojac color=rules
";
			   	$realtimestringnew.="r.out.tiff input=x$brojac output=\"$WebDir/user_files/$korisnik/raster/realtime/spread_rast_$brojac\" compression=none -t
";							  
			   }

			   
			  $realtimestringnew.="r.mapcalc \"x$maxrange=if(my_spread$rand-$maxrange,0,0,my_spread$rand)\"
";
			  $realtimestringnew.="cat $WebDir/files/spread_color.log | r.colors map=x$maxrange color=rules
";
			  $realtimestringnew.="r.out.tiff input=x$maxrange output=\"$WebDir/user_files/$korisnik/raster/realtime/spread_rast_$maxrange\" compression=none -t
";				
			  $realtimestringnew.="g.mremove -f rast=\"my_spr*\"	  
";					  
			
			   setIntoFile ($realtimefile, $realtimestring,$realtimestringnew);
			   $realtimelaunch="$WebDir/user_files/$korisnik/realtime_launch.sh";
			   setIntoFile ($realtimelaunch, "KORISNIK",$korisnik); 
			   
	
			}
			else
			{
				return 1234567899;
			}
				
		}
			
	}
	
	return $ps;
}














function emptyDir($path) { 
 
	// INITIALIZE THE DEBUG STRING
	$debugStr = '';
	$debugStr .= "Deleting Contents Of: $path<br /><br />";
 
	// PARSE THE FOLDER
	if ($handle = opendir($path)) {
 
		while (false !== ($file = readdir($handle))) {
			
			if(substr($file , 0, 12)=="spread_rast_")
			{	 
				if ($file != "." && $file != "..") {
	 
					// IF IT"S A FILE THEN DELETE IT
					if(is_file($path."/".$file)) {
	 
						if(unlink($path."/".$file)) {
						$debugStr .= "Deleted File: ".$file."<br />";	
						}
	 
					} else {
	 
						// IT IS A DIRECTORY
						// CRAWL THROUGH THE DIRECTORY AND DELETE IT'S CONTENTS
	 
						if($handle2 = opendir($path."/".$file)) {
	 
							while (false !== ($file2 = readdir($handle2))) {
	 
								if ($file2 != "." && $file2 != "..") {
									if(unlink($path."/".$file."/".$file2)) {
									$debugStr .= "Deleted File: $file/$file2<br />";	
									}
								}
	 
							}
	 
						}
	 
						if(rmdir($path."/".$file)) {
						$debugStr .= "Directory: ".$file."<br />";	
						}
	 
					}
	
				}
	  
			}
	 
		}
	}
	//return $debugStr;
}

function numberDir($path) { 
 
	$number=0;
 
	// PARSE THE FOLDER
	if ($handle = opendir($path)) {
 
		while (false !== ($file = readdir($handle))) {
			
			if(substr($file , 0, 12)=="spread_rast_")
			{	 
				  $number++;
			}
	 
		}
	}
	return $number;
}

function eRealTime($WebDir, $korisnik, $step0)
{
	
	emptyDir("$WebDir/user_files/$korisnik/raster/realtime/");
	

	$realtimelaunch="$WebDir/user_files/$korisnik/realtime_launch.sh";
	
	$ps2 = run_in_backgroundPozar($realtimelaunch);
	while(is_process_runningPozar($ps2))
	{
		session_write_close();
	  	sleep(1);
		ob_flush;
		flush();
	}
	$number=numberDir("$WebDir/user_files/$korisnik/raster/realtime/");
	
	$temp="$WebDir/user_files/$korisnik/animatedRT.map";
	$fh3 = fopen($temp, 'r') or die("can't open file");
	$stringforrandfind = fread($fh3, filesize($temp));
	fclose($fh3);

    $delimeterLeft2="#PocetakRT";
    $delimeterRight2="#KrajRT";
    $posLeft2  = stripos($stringforrandfind,$delimeterLeft2)+strlen($delimeterLeft2);
    $posRight2 = stripos($stringforrandfind,$delimeterRight2,$posLeft2+1);
    $stringtemp=substr($stringforrandfind,$posLeft2,$posRight2-$posLeft2);
	
    $number=$number/2;

		

    for($rtcnt=0;$rtcnt<$number;$rtcnt++)
    {
//    	$step=50*$rtcnt;
    	$step=$step0*$rtcnt;
	$stringtempnewdefault.="
LAYER
  NAME \"Pozar$rtcnt\"
  TYPE RASTER
  OFFSITE  255 255 0
STATUS OFF
TRANSPARENCY  80
  DATA $WebDir/user_files/$korisnik/raster/realtime/spread_rast_$step.tif
END

";
    }

	

	setIntoFile ($temp, $stringtemp,$stringtempnewdefault);

	
	$temp="$WebDir/user_files/$korisnik/RTnumber.log";
	$fh3 = fopen($temp, 'r') or die("can't open file");
	$stringforrandfind = fread($fh3, filesize($temp));
	fclose($fh3);

    $delimeterLeft2="#Start";
    $delimeterRight2="#End";
    $posLeft2  = stripos($stringforrandfind,$delimeterLeft2)+strlen($delimeterLeft2);
    $posRight2 = stripos($stringforrandfind,$delimeterRight2,$posLeft2+1);
    $stringtemp=substr($stringforrandfind,$posLeft2,$posRight2-$posLeft2);
	

	$stringtempnewdefault="
number=$number
";
	setIntoFile ($temp, $stringtemp,$stringtempnewdefault);


	return $number;
	
}

function getRTrangeFromFile($WebDir, $korisnik)
{
	$RTrange=getFromFile("$WebDir/user_files/$korisnik/RTnumber.log", "\n", "=", "number");
	return $RTrange;
}



function executeGRASS($WebDir, $korisnik, $stringtempnewdefault)
{ 
	$temp="$WebDir/user_files/$korisnik/temp2.sh";
	
	
	$fh3 = fopen($temp, 'r') or die("can't open file");
	$stringforrandfind = fread($fh3, filesize($temp));
	fclose($fh3);

	

    $delimeterLeft2="#Start";
    $delimeterRight2="#End";
    $posLeft2  = stripos($stringforrandfind,$delimeterLeft2)+strlen($delimeterLeft2);
    $posRight2 = stripos($stringforrandfind,$delimeterRight2,$posLeft2+1);
    $stringtemp=substr($stringforrandfind,$posLeft2,$posRight2-$posLeft2);

	

	$stringtempnewdefault="
$stringtempnewdefault >$WebDir/user_files/$korisnik/temp.log
";


	

	setIntoFile ($temp, $stringtemp,$stringtempnewdefault);

	

	$stringps="$WebDir/user_files/$korisnik/temp2_launch.sh";

	//return $stringps;

	$ps = run_in_backgroundPozar($stringps);
	while(is_process_runningPozar($ps))
	{
		session_write_close();
	  	sleep(1);
		ob_flush;
		flush();
	}
		
	$myFile = "$WebDir/user_files/$korisnik/temp.log";
	$fh = fopen($myFile, 'r');
	$theData = fread($fh, filesize($myFile));
	fclose($fh);

	session_write_close();
	
	return $theData;
}


function checkIfFireExistsWithoutRandAndWithoutGRASS($WebDir, $korisnik)
{
	
	
	$myFile22 = "$WebDir/user_files/$korisnik/glistSuccess.log";
	$fh22 = fopen($myFile22, 'r');
	$theData222 = fread($fh22, filesize($myFile22));
	fclose($fh22);
	
	
	
	
	//$glistarray22=preg_split("/[\s+,\t+,\n+]/", $theData222);
	
	$delimeterLeft2="Number of lines:";
	$delimeterRight2="Number of islands:";
	$posLeft2  = stripos($theData222,$delimeterLeft2)+strlen($delimeterLeft2);
	$posRight2 = stripos($theData222,$delimeterRight2,$posLeft2+1);
	$stringtemp=trim(substr($theData222,$posLeft2,$posRight2-$posLeft2));

	//echo 'alert("'.$stringtemp.'!");';
	
	
	if($stringtemp===0 || $stringtemp=='0')
	{
		//Bolje da prikaze crveni raster
		copy($WebDir."/userdefault/spread_rast.tif", $WebDir."/user_files/$korisnik/raster/spread_rast.tif");
		copy($WebDir."/userdefault/spread_rast.tfw", $WebDir."/user_files/$korisnik/raster/spread_rast.tfw");
		
		//Ali vector izbrisati
		copy($WebDir."/userdefault/spread_shape.shp", $WebDir."/user_files/$korisnik/vector/spread_shape.shp");
		copy($WebDir."/userdefault/spread_shape.shx", $WebDir."/user_files/$korisnik/vector/spread_shape.shx");
		copy($WebDir."/userdefault/spread_shape.prj", $WebDir."/user_files/$korisnik/vector/spread_shape.prj");
		copy($WebDir."/userdefault/spread_shape.dbf", $WebDir."/user_files/$korisnik/vector/spread_shape.dbf");
		
		file_put_contents($myFile22, "");
		
		
		return -1;
	}
	else
	{
		return 1;
	}
	

}








/*
function getrange($WebDir, $korisnik, $spread)
{
	
	$temp="$WebDir/user_files/$korisnik/getrange.sh";
	$fh3 = fopen($temp, 'r') or die("can't open file");
	$stringforrandfind = fread($fh3, filesize($temp));
	fclose($fh3);

    $delimeterLeft2="#Start";
    $delimeterRight2="#End";
    $posLeft2  = stripos($stringforrandfind,$delimeterLeft2)+strlen($delimeterLeft2);
    $posRight2 = stripos($stringforrandfind,$delimeterRight2,$posLeft2+1);
    $stringtemp=substr($stringforrandfind,$posLeft2,$posRight2-$posLeft2);

	$stringtempnewdefault="
r.info map=$spread -r >$WebDir/user_files/$korisnik/range.log
";
	
	setIntoFile ($temp, $stringtemp,$stringtempnewdefault);

	$range_launch="$WebDir/user_files/$korisnik/getrange_launch.sh";
	setIntoFile ($range_launch, "KORISNIK",$korisnik); 
	
	$stringps="$WebDir/user_files/$korisnik/getrange_launch.sh";
	$ps = run_in_backgroundPozar($stringps);
	while(is_process_runningPozar($ps))
	{
		session_write_close();
	  	sleep(1);
		ob_flush;
		flush();
	}
		
	
	$myFile = "$WebDir/user_files/$korisnik/range.log";
	$fh = fopen($myFile, 'r');
	$theData = fread($fh, filesize($myFile));
	fclose($fh);
	
	return $theData;
}*/

//********************************************************************************************
//Pretvaranje koordinata slike u georeferencirane koordinate
//********************************************************************************************
/*function click2currentmap($WebDir, $rastForRegion, $MonImgName, $korisnik)
{
	$temp="$WebDir/user_files/$korisnik/temp.sh";
	$fh3 = fopen($temp, 'r') or die("can't open file");
	$stringforrandfind = fread($fh3, filesize($temp));
	fclose($fh3);

    $delimeterLeft2="#Start";
    $delimeterRight2="#End";
    $posLeft2  = stripos($stringforrandfind,$delimeterLeft2)+strlen($delimeterLeft2);
    $posRight2 = stripos($stringforrandfind,$delimeterRight2,$posLeft2+1);
    $stringtemp=substr($stringforrandfind,$posLeft2,$posRight2-$posLeft2);

	$stringtempnewdefault="
g.region -g >$WebDir/files/reg.log
";

	setIntoFile ($temp, $stringtemp,$stringtempnewdefault);

	$stringps="$WebDir/user_files/$korisnik/temp_launch.sh";
	$ps = run_in_backgroundPozar($stringps);
	while(is_process_runningPozar($ps))
	{
		session_write_close();
	  	sleep(1);
		ob_flush;
		flush();
	}
				
	$fp = fopen($WebDir.'/files/reg.log', 'r');				
	require_once("read_region.php");
	fclose($fp);			

	$width_reg=$e-$w;
	$height_reg=$n-$s;
	$size = getimagesize("$WebDir/files/$MonImgName");
	$colls=$size[0];
	$rows=$size[1];
		
	//$click=click2map($_POST['image_x'], $_POST['image_y'], $e,$w,$n,$s,$rows,$colls);

	return "2";
}*/

//**************************************
//Pokretanje procesa u pozadini
//**************************************
function run_in_backgroundPozar($Command, $Priority = 0)
{
    if($Priority)
        $PID = shell_exec("nohup nice -n $Priority $Command 2> /dev/null & echo $!");
    else
	$PID = shell_exec("nohup $Command > /dev/null 2> /dev/null & echo $!");
        //$PID = shell_exec("nohup $Command 2> /dev/null & echo $!");
    return($PID);
}

//**************************************
//Izvodi li se proces (pokrenut u pozadini)
//**************************************
function is_process_runningPozar($PID)
{
    exec("ps $PID", $ProcessState);
    return(count($ProcessState) >= 2);
}


function get_string_between($string, $start, $end){
    $split_string       = explode($end,$string);
    foreach($split_string as $data) {
         $str_pos       = strpos($data,$start);
         $last_pos      = strlen($data);
         $capture_len   = $last_pos - $str_pos;
         $return[]      = trim(substr($data,$str_pos+1,$capture_len));
    }
    return $return;
}

function multiexplode ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}


function enablePozar($WebDir, $korisnik)
{
?>

<?php
//**************************************
//Ukoliko nema ros, onemogući spread
//**************************************
	$glist=system("g.list rast > '$WebDir/files/glist.log'");
	$myFile = "$WebDir/files/glist.log";
	$fh = fopen($myFile, 'r');
	$theData2 = fread($fh, filesize($myFile));
	fclose($fh);

	//$glistarray = explode(" ", $theData2);
	$glistarray=preg_split("/[\s+,\t+,\n+]/", $theData2);


	$isRosCalculated=0;
	$isVlastitiRosCalculated=0;

	for($i = 0; $i < count($glistarray); $i++){

		if(trim($glistarray[$i]) =='my_ros.maxdir' || trim($glistarray[$i]) =='my_ros.base' || trim($glistarray[$i]) =='my_ros.max')
		{
			$isRosCalculated++;
			
		}
		if(trim($glistarray[$i]) =="my_ros_$korisnik"."_$chosenFuelModel.maxdir" || trim($glistarray[$i]) =="my_ros_$korisnik"."_$chosenFuelModel.base" || trim($glistarray[$i]) =="my_ros_$korisnik"."_$chosenFuelModel.max")
		{
			$isVlastitiRosCalculated++;
			
		}
	}

	if($isRosCalculated<3 && $isVlastitiRosCalculated<3)
	{
	?>
		<div style="background-color: #FFFFCC;">
		<input type='radio' name="hidden_radio" value="hidden_radio">
		<b>POZAR</b><hr>
		</div>
		<div style="text-align: center;">
		<img src="./gif/error.gif" width="24" height="25"> <br> <font color=red> Nedostaje ROS </font>
		</div>
	<?php
	}
	else
	{
?>
<div style="background-color: #FFFFCC;">
<input type='radio' name="selected" value="pozar_selected" id="pozar_selected"
<?php if($_POST["selected"]=='pozar_selected') echo "checked";?>>
<b>PO&#142;AR</b><hr>
</div>
<div style="text-align: center;">
<INPUT name="pozar" id="pozar" value="1" type="hidden">
<?php //Klikni na mjesto<br>izbijanja po&#158;ara.?>
Odaberite vrstu podataka i mjesto izbijanja po&#158;ara:<br />
<input type='radio' name="selectedROS" value="ROS_default" onchange='document.getElementById("pozar_selected").checked = true' <?php if($_POST["selectedROS"]=='ROS_default' || (!isset($_POST["selectedROS"]))) echo "checked";?> ><?php if($isRosCalculated<3) echo "<font color=#ff0000>";?>On-line podaci<?php if($isRosCalculated<3) echo "</font>";?><br />

<?php if($isVlastitiRosCalculated>=3) {?>
<input type='radio' name="selectedROS" value="ROS_own" onchange='document.getElementById("pozar_selected").checked = true' <?php if($_POST["selectedROS"]=='ROS_own') echo "checked";?>>
<?php } ?>

<?php if($isVlastitiRosCalculated<3) echo "<font color=#ff0000>";?>Vlastiti podaci<?php if($isVlastitiRosCalculated<3) echo "</font>";?>

<!--
<img src="pozar.gif" width="24" height="25" onClick='document.getElementById("pozar_selected").checked = true;pozar.selectedIndex=0;' >
<img src="pozar_wait.gif" width="24" height="25" onClick='document.getElementById("pozar_selected").checked = true;pozar.selectedIndex=1;'><br />
<select name="pozar" id="pozar" onchange='document.getElementById("pozar_selected").checked = true'>
		<option value="0"
		<?php if($_POST["pozar"]==0) echo "selected";?>
		>Spread bckg</option>
		<option value="1"
		<?php if($_POST["pozar"]==1 || !isset($_POST["pozar"])) echo "selected";?>
		>Spread wait</option>
</select>
-->
<?php
	}



?>
</div>
</td><td>
<?php
}


?>