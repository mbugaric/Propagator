<?php
function getInfo($x,$y, $korisnik, $WebDir, $defaultMapset)
{
	$string="g.region rast=el@$defaultMapset

r.what input=MIRIP@AdriaFireRisk,FWI@FWI,latestRos.base,latestRos.max,latestRos.maxdir,slope@$defaultMapset,aspect@$defaultMapset,latestMoislive,latestMois1h,latestMois10h,latestMois100h,latestWindspeed,latestWinddir,latestWindspeedNonModified east_north=$x,$y > $WebDir/user_files/$korisnik/getInfo.log";
	
	$fileSh = $WebDir."/user_files/$korisnik/getInfo.sh";
	file_put_contents($fileSh, $string);
	
	$fileSh_launch = $WebDir."/user_files/$korisnik/getInfo_launch.sh";
	
	$ps = run_in_backgroundGetInfo($fileSh_launch);
	while(is_process_runningGetInfo($ps))
	{
		session_write_close();
		sleep(0.1);
		ob_flush;
		flush();
	}
	
	
	$resultUnparsed=file_get_contents($WebDir."/user_files/$korisnik/getInfo.log");
	$resultsPrior = explode("||", $resultUnparsed);
	$results = explode("|", $resultsPrior[1]);
	$AdriaFireRisk=round($results[0]); if($results[0]=="*") $AdriaFireRisk="X";
	$FWI=round($results[1]); if($results[1]=="*") $FWI="X";
	$ROSbase=round($results[2],1); if($results[2]=="*") $ROSbase="X";
	$ROSmax=round($results[3],1); if($results[3]=="*") $ROSmax="X";
	$ROSmaxdir=round($results[4],1); if($results[4]=="*") $ROSmaxdir="X";
	$slope=round($results[5],1); if($results[5]=="*") $slope="X";
	$aspect=round($results[6],1); if($results[6]=="*") $aspect="X";
	$moisLive=round($results[7],1); if($results[7]=="*") $moisLive="X";
	$mois1h=round($results[8],1); if($results[8]=="*") $mois1h="X";
	$mois10h=round($results[9],1); if($results[9]=="*") $mois10h="X";
	$mois100h=round($results[10],1); if($results[10]=="*") $mois100h="X";
	$wSpeed=round($results[11]*0.018288,3); if($results[11]=="*") $wSpeed="X";
	$wDir=round($results[12],1); $wDir=$wDir+180;	/*if($wDir<0) $wDir += 360;*/ if($results[12]=="*") $wDir="X";
	$wSpeedNonModified=round($results[13]*0.018288,1); if($results[13]=="*") $wSpeedNonModified="X";
	
	
	return _GIS_MIRIP.": $AdriaFireRisk/255, "._GIS_FWI."=$FWI <br />
			"._GIS_MOISTURE_GENERAL.": $moisLive,$mois1h,$mois10h,$mois100h (%) <br />
			"._GIS_WIND_GENERAL.": $wSpeed (km/h), $wDir ("._GIS_DEGREES_SHORT.") <br />
			"._GIS_WIND_GENERAL." 10m: $wSpeedNonModified (km/h) <br />
			"._GIS_SLOPE.": $slope ("._GIS_DEGREES_SHORT."), aspect=$aspect ("._GIS_DEGREES_SHORT.") <br />
			"._GIS_ROSBASE.": $ROSbase cm/min <br />
			"._GIS_ROSMAX.": $ROSmax cm/min <br />
			"._GIS_ROSMAXDIR.": $ROSmaxdir ("._GIS_DEGREES_SHORT.") <br />			
			
			";
	
	
	
}


function run_in_backgroundGetInfo($Command, $Priority = 0)
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
function is_process_runningGetInfo($PID)
{
    exec("ps $PID", $ProcessState);
    return(count($ProcessState) >= 2);
}

?>