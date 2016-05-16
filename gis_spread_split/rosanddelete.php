<?php
//***************************************************************************************************//

//Glavni ROS se nalazi u files direktoriju.. njega se podešava ruèno

//***************************************************************************************************//

$WebDir_temp_data="/var/www/gis_data_temp_split";;

/**
 * Brisanje vlastitog ROS-a
 * @param unknown_type $WebDir
 * @param unknown_type $korisnik
 * @return unknown_type
 */
function deletedata($WebDir, $korisnik)
{

	$delete_ros="$WebDir/user_files/$korisnik/rm_prev_data.sh";

	$fh2 = fopen($delete_ros, 'r') or die("can't open file");
	$stringforrandfind20 = fread($fh2, filesize($delete_ros));
	fclose($fh2);

   $delimeterLeft="#Start";
   $delimeterRight="#End";
   $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
   $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
   $string=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);

	$newstring="
g.remove rast=my_ros_$korisnik.max,my_ros_$korisnik.base,my_ros_$korisnik.maxdir,my_ros_$korisnik.spotdist,mois_l
";

	setIntoFile ($delete_ros, $string, $newstring);

	$rosdeletesh="$WebDir/user_files/$korisnik/rm_prev_data.sh";
	$ps = run_in_background($rosdeletesh);
  	while(is_process_running($ps))
   	{
		session_write_close();
	  	sleep(1);
		ob_flush;
		flush();
    }
}

/**
 * Racunanje vlastitog ROS-a, file: calculate_ros.sh, rezolucija se postavlja ahrdcodirano zasad
 * calculateros_launch.sh se poziva za izvoðenje
 * @param $WebDir
 * @param $korisnik
  */
function calculateROS2($WebDir, $korisnik, $el, $rastForAspect, $rastForSlope, $rastForModel, $grassmapset, $external_param_file, $chosenFuelModel, $barriers)
{
	
	/*Barijere se više ne rade u ROS-u*/
	
	/*if(!file_exists($WebDir."/user_files/$korisnik/barriers"))
	{
		copy($WebDir."/userdefault/crontab", $WebDir."/user_files/$korisnik/barriers");
		chmod($WebDir."/user_files/$korisnik/barriers", 0777);
	}
	
	$filename=$WebDir."/user_files/$korisnik/barriers";
	$fh = fopen($filename, 'w') or die("can't open file");
	fwrite($fh, $barriers);
	fclose($fh);*/
	
	
	/***/
	
	
	$calculate_ros="$WebDir/user_files/$korisnik/calculate_ros.sh";
	$fh2 = fopen($calculate_ros, 'r') or die("can't open file1");
	$stringforrandfind20 = fread($fh2, filesize($calculate_ros));
	fclose($fh2);

	 

    $delimeterLeft="#Start1";
    $delimeterRight="#End1";
    $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
    $string=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);

	
	$newstring="
   g.mapset mapset=$korisnik
   #history -w
   #history -r /$GISDBASE/$LOCATION/$MAPSET/.bash_history
   #HISTFILE=/$GISDBASE/$LOCATION/$MAPSET/.bash_history

g.remove -f rast=my_ros_$korisnik.max,my_ros_$korisnik.base,my_ros_$korisnik.maxdir,my_ros_$korisnik.spotdist   
g.remove -f rast=my_ros_$korisnik"."_$chosenFuelModel.max,my_ros_$korisnik"."_$chosenFuelModel.base,my_ros_$korisnik"."_$chosenFuelModel.maxdir,my_ros_$korisnik"."_$chosenFuelModel.spotdist

g.remove -f rast=mois_$korisnik,mois_l_$korisnik,mois_l0_$korisnik,mois_l00_$korisnik,w_speed1_$korisnik,w_dir1_$korisnik

g.remove -f rast=$rastForAspect,$rastForSlope,$el

#g.copy rast=$el@$grassmapset,$el
#g.copy rast=$rastForAspect@$grassmapset,$rastForAspect
#g.copy rast=$rastForSlope@$grassmapset,$rastForSlope

#Ako ne postoje modeli, da ih kopira, ali ne overwrite
#g.copy rast=modelAlbini@$grassmapset,modelAlbini
#g.copy rast=modelScott@$grassmapset,modelScott

#Ovo æe trebat mijenjat
g.region rast=$el@$grassmapset res=100
";

	setIntoFile ($calculate_ros, $string, $newstring);
	
	

    $delimeterLeft="#Start2";
    $delimeterRight="#End2";
    $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
    $string=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);

	$newstring="
r.in.arc input=$WebDir/user_files/$korisnik/wind_dir.asc output=w_dir1_$korisnik type=FCELL mult=1.0
r.in.arc input=$WebDir/user_files/$korisnik/wind_speed.asc output=w_speed1_$korisnik type=FCELL mult=1.0
";

	setIntoFile ($calculate_ros, $string, $newstring);

    $delimeterLeft="#Start3";
    $delimeterRight="#End3";
    $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
    $string=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);

$newstring="
#smjer vjetra popravljen
r.mapcalc w_dir1_$korisnik=w_dir1_$korisnik-180
#preracunaj u km/h
r.mapcalc w_speed1_$korisnik=w_speed1_$korisnik*54.68
";

	setIntoFile ($calculate_ros, $string, $newstring);

    $delimeterLeft="#Start4";
    $delimeterRight="#End4";
    $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
    $string=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);


	$newstring="
	r.in.arc input=$WebDir/user_files/$korisnik/mois_live.asc output=mois_$korisnik type=FCELL mult=1.0
	r.in.arc input=$WebDir/user_files/$korisnik/mois1h.asc output=mois_l_$korisnik type=FCELL mult=1.0
	r.in.arc input=$WebDir/user_files/$korisnik/mois10h.asc output=mois_l0_$korisnik type=FCELL mult=1.0
	r.in.arc input=$WebDir/user_files/$korisnik/mois100h.asc output=mois_l00_$korisnik type=FCELL mult=1.0
";
	setIntoFile ($calculate_ros, $string, $newstring);

    $delimeterLeft="#Start5";
    $delimeterRight="#End5";
    $posLeft  = stripos($stringforrandfind20,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($stringforrandfind20,$delimeterRight,$posLeft+1);
    $string=substr($stringforrandfind20,$posLeft,$posRight-$posLeft);



	//If default, try to get from default mapset
	if($chosenFuelModel == "Albini_default" || $chosenFuelModel == "Scott_default")
	{
		$rastForModel=$rastForModel."@$grassmapset";
	}
	
	
	if($chosenFuelModel == "Albini_default")
	{
	$newstring="
	#ROS Albini_default
	
	r.ros -v model=$rastForModel moisture_live=mois_$korisnik moisture_1h=mois_l_$korisnik moisture_10h=mois_l0_$korisnik moisture_100h=mois_l00_$korisnik velocity=w_speed1_$korisnik direction=w_dir1_$korisnik slope=$rastForSlope@$grassmapset aspect=$rastForAspect@$grassmapset elevation=$el@$grassmapset output=my_ros_$korisnik"."_$chosenFuelModel
	
	#r.in.poly input=$WebDir/user_files/$korisnik/barriers output=fireBarriers --overwrite 	
	#r.mapcalc my_ros_$korisnik"."_$chosenFuelModel.base = \"if(isnull(fireBarriers),my_ros_$korisnik"."_$chosenFuelModel.base,0)\"
	
	#r.out.tiff input=my_ros_$korisnik"."_$chosenFuelModel.base output=\"$WebDir/user_files/$korisnik/Layers/rast/ros_base_$korisnik"."_$chosenFuelModel\" compression=none -t 
	";	
	}
	else
	{
	$newstring="
	#ROS $chosenFuelModel
	
	r.ros -v model=$rastForModel moisture_live=mois_$korisnik moisture_1h=mois_l_$korisnik moisture_10h=mois_l0_$korisnik moisture_100h=mois_l00_$korisnik velocity=w_speed1_$korisnik direction=w_dir1_$korisnik slope=$rastForSlope@$grassmapset aspect=$rastForAspect@$grassmapset elevation=$el@$grassmapset output=my_ros_$korisnik"."_$chosenFuelModel external_param_file=\"$WebDir/user_files/$korisnik/$external_param_file\"
	
	#r.in.poly input=$WebDir/user_files/$korisnik/barriers output=fireBarriers --overwrite 	
	#r.mapcalc my_ros_$korisnik"."_$chosenFuelModel.base = \"if(isnull(fireBarriers),my_ros_$korisnik"."_$chosenFuelModel.base,0)\"

	#r.out.tiff input=my_ros_$korisnik"."_$chosenFuelModel.base output=\"$WebDir/user_files/$korisnik/Layers/rast/ros_base_$korisnik"."_$chosenFuelModel\" compression=none -t 
	";
		
	}
	
	
	

	

	

	setIntoFile ($calculate_ros, $string, $newstring);
	
	
	
	
	


	$calculaterossh="$WebDir/user_files/$korisnik/calculateros_launch.sh";
	$ps = run_in_background($calculaterossh);
	
	
	while(is_process_running($ps))
   	{
		session_write_close();
	  	sleep(1);
		ob_flush;
		flush();
	}
	
	

}
