<?php
ini_set("memory_limit","500M");
dl("php_mapscript.so");


$WebDir= "/var/www/gis_spread/split_spread/meteo2asc/";	
$filename=$WebDir.$argv[1];
echo $filename;

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

	$num=0;
	if($wind_data[$num]=="") $num++;

$long=array();
$lat=array();
$tm_x=array();
$tm_y=array();
$kopno=array();

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

				$projOutObj =ms_newprojectionobj("proj=tmerc,ellps=WGS84,units=m,lon_0=15,k=0.9999,x_0=6500000,y_0=0,no_defs");
				$projInObj = ms_newprojectionObj ("proj=longlat,ellps=WGS84,no_defs" );

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

	for($i=0;$i<=$broj_tocaka_x*$broj_tocaka_y-1;$i++)
	{
				$projOutObj =ms_newprojectionobj("proj=tmerc,ellps=WGS84,units=m,lon_0=15,k=0.9999,x_0=6500000,y_0=0,no_defs");
				$projInObj = ms_newprojectionObj ("proj=longlat,ellps=WGS84,no_defs" );

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

	for($i=0;$i<=$broj_tocaka_x*$broj_tocaka_y-1;$i++)
	{
		for($j=0;$j<8;$j++)
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


$year=$start_modela[0].$start_modela[1].$start_modela[2].$start_modela[3];
$month=$start_modela[4].$start_modela[5];
$day=$start_modela[6].$start_modela[7];
$hour=$start_modela[8].$start_modela[9];
$hoursave=$hour;

//echo "year: ".$year." month: ".$month." day: ".$day." hour: ".$hour;

$string=$hour++;
$string=$hour--;


for($k=0;$k<8;$k++)
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

	if(($string/24)>=1)
		$prekoracenje=0;
	else
		$prekoracenje=1;


	$string=$string%24;
		//echo "\n".$string." ";

	$filename=$WebDir."/meteodata/wind_dir_meteo_$string.asc";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $new_text2);
				fclose($fh);

	$filename=$WebDir."/meteodata/wind_speed_meteo_$string.asc";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $new_text);
				fclose($fh);

$d=date("d.m.y");
$d2=date("Ymd");
$start_modela=trim($start_modela);
$ura=substr("$start_modela", -2);
$d2.=$ura;

//echo "\n $ura";

if(!is_dir  ( $WebDir."/meteodata/$d" ))
{
	mkdir($WebDir."/meteodata/$d", 0777);
	chmod($WebDir."/meteodata/$d", 0777);
}

if($prekoracenje && ($d2 == $start_modela))
	{
		copy($WebDir."/meteodata/wind_dir_meteo_$string.asc", $WebDir."/meteodata/$d/wind_dir_meteo_$string.asc");
		copy($WebDir."/meteodata/wind_speed_meteo_$string.asc", $WebDir."/meteodata/$d/wind_speed_meteo_$string.asc");
	}

}

$utchournow=gmdate("H");
$utchournow++;
$utchournow--;

//echo "\n************ ".$utchournow." ";

$ostatak=$utchournow%3;
$utchournow=$utchournow-$ostatak;
$utchournow=$utchournow%24;

//echo "\n************ ".$utchournow." ";

copy($WebDir."/meteodata/wind_dir_meteo_$utchournow.asc", $WebDir."../files/wind_dir.asc");
copy($WebDir."/meteodata/wind_speed_meteo_$utchournow.asc", $WebDir."../files/wind_speed.asc");

echo ("\n Trenutni UTC - $utchournow\n");

?>