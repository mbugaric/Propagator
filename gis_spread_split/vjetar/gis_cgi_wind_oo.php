<?php
ini_set("memory_limit","256M");
/*ini_set('display_errors', 'On');
error_reporting(E_ALL); 
*/

require("../db_functions.php");
require("../postavke_dir_gis.php");

$korisnik=$_GET['user_name'];


$numtocaka=25;

/*http://192.168.0.40/cgi-bin/mapserv?map=/var/www/gis_spread/vjetar/webgiszupanija.map&vjetar=trenutni&FORMAT=image/png&LAYERS=wind&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetMap&STYLES=&EXCEPTIONS=application/vnd.ogc.se_inimage&SRS=EPSG:900913&BBOX=1817255.8996016665,5405476.790478902,1856391.6580766665,5444612.548953902&WIDTH=256&HEIGHT=256*/
class olWind
{
		private $Wind_dirAsc_temp;
		private $Wind_speedAsc_temp;
		private $grass_res=2000;
		
		
		public function preLoadFullAscFiles($rastForWindRegion, $WebDir, $korisnik)
		{
			
			global $mapset;
			
			$text="g.mapset mapset=$korisnik
g.region rast=$rastForWindRegion@$mapset res=".$this->grass_res."

g.remove rast='windDirFromAsc'
g.remove rast='windSpeedFromAsc'
g.remove rast='windFromAsc'

r.in.arc input=".$this->Wind_dirAsc_temp." output=windDirFromAsc type=FCELL mult=1.0
r.in.arc input=".$this->Wind_speedAsc_temp." output=windSpeedFromAsc type=FCELL mult=1.0

			";
			
			
			//echo $text;
			
			$filename="$WebDir/user_files/$korisnik/calculate_wind_3.sh";
			$fp = fopen($filename, 'w');
			fwrite($fp, $text);
			fclose($fp);

			$stringps="$WebDir/user_files/$korisnik/launch_wind_3.sh";
			$ps = $this->run_in_background($stringps);
			
			while($this->is_process_running($ps))
			{
					sleep(0.3);
			}
		}
		

		//***************************************************************************************************//

		//	Funkcija koja iz .asc file procita podatke, prilagodi ih trenutnom prikazu u mapserveru,
		//	odnosno georeferencira ih, izraèuna prosijeènu vrijednost, te prilagodi koordinatnom sustavu
		//	samog mapservera koji ispisuje od dolje lijeve prema desno i prema gore, za razliku od samog
		//	asc file-a koji je od gore lijevo prema desno i dolje.

		//***************************************************************************************************//
		public function loadFromAsc($type, $minx, $miny, $x_step, $y_step, $numtocaka, $isSpeed, $WebDir, $korisnik)
		{

			$rand=rand(0,99999);
			
			$filename="";
			$input="";
			
			if(!strcmp($type,"windDir"))
			{
				//Isti su
				$filename=$this->Wind_dirAsc_temp;
				$input="windDirFromAsc";
			}
			else
			{
				$filename=$this->Wind_speedAsc_temp;	
				$input="windSpeedFromAsc";				
			}
			
	
			$n=$miny + $numtocaka*$y_step;
			$s=$miny;
			$e=$minx + $numtocaka*$x_step;
			$w=$minx;
			
			$text="g.mapset mapset=$korisnik

g.region rast=$input n=$n s=$s e=$e w=$w rows=$numtocaka cols=$numtocaka
echo \"#Start\"
r.out.arc input=$input out=-
echo \"#End\"
			";
			
		
			$filename="$WebDir/user_files/$korisnik/calculate_wind_2.sh";
			$fp = fopen($filename, 'w');
			fwrite($fp, $text);
			fclose($fp);

			$stringps="$WebDir/user_files/$korisnik/launch_wind_2.sh";
			$values=shell_exec($stringps);
			
			
			
			$delimeterLeft="#Start";
			$delimeterRight="#End";
			$posLeft  = stripos($values,$delimeterLeft)+strlen($delimeterLeft);
			$posRight = stripos($values,$delimeterRight,$posLeft+1);
			$string=substr($values,$posLeft,$posRight-$posLeft);	
			
			
			
			//echo $string."<br>";
			
			$windData=explode("\n", $string);
			//print_r($windData);
			
			$windData[1]=preg_replace("/ [^\w]* /"," ",$windData[1]); 
			$temp = explode(" ", $windData[1]);
			$ncols=$temp[1];
			//nrows
			$windData[2]=preg_replace("/ [^\w]* /"," ",$windData[2]); 
			$temp = explode(" ", $windData[2]);
			$nrows=$temp[1];
			//xllcorner
			$windData[3]=preg_replace("/ [^\w]* /"," ",$windData[3]); 
			$temp = explode(" ", $windData[3]);
			$xllcorner=$temp[1];
			//yllcorner
			$windData[4]=preg_replace("/ [^\w]* /"," ",$windData[4]); 
			$temp = explode(" ", $windData[4]);
			$yllcorner=$temp[1];
			//cellsize
			$windData[5]=preg_replace("/ [^\w]* /"," ",$windData[5]); 
			$temp = explode(" ", $windData[5]);
			$cellsize=$temp[1];
			//NODATA_value
			$windData[6]=preg_replace("/ [^\w]* /"," ",$windData[6]); 
			$temp = explode(" ", $windData[6]);
			$NODATA_value=$temp[1];	
			
			//echo $ncols." ".$nrows." ".$xllcorner." ".$yllcorner." ".$cellsize." ".$NODATA_value;
			
			$data="";
			for($i=7; $i<7+$numtocaka; $i++)
			{
				$data.=$windData[$i];
			}
			
			$windData=$data;
			
			$wind_data = explode(" ", $windData);
			unset($windData);

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

		//var_dump($localExtent_minx); echo "<br /><br /><br /><br />";




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
		public function windPoint ($x,$y) {

		$point = ms_newPointObj(); 
		$point->setXY($x,$y);
		return $point;
		}



		//***************************************************************************************************//

		//	Ovom se funkcijom iscrtavaju smjerovi/jacine vjetra, bitno je mjesto pozivanja ove funkcije
		//	pogledati PRIMJER KORISTENJA. Mijenja se kut (velicina) strelice (ili bilo kojeg drugog znaka)
		//	Strelica je samo znak "1" u fontu koji se koristi i koji je definiran u .map file-u.

		//***************************************************************************************************//
		public function drawWind($map,$Wind_dirAsc, $Wind_speedAsc, &$mylayer, &$myclass, $numtocaka, &$image, $WebDir, $rastForWindRegion, $korisnik, $isVlastiti)
		{


		
			$new_bounds=explode(",", $_GET["BBOX"]);

			//$projOutObj =ms_newprojectionobj("proj=tmerc,ellps=WGS84,units=m,lon_0=15,k=0.9999,x_0=6500000,y_0=0,no_defs");
			$projOutObj = ms_newprojectionobj("init=epsg:900913");
			$projInObj = ms_newprojectionObj ("proj=merc,a=6378137,b=6378137,lat_ts=0.0,lon_0=0.0,x_0=0.0,y_0=0,k=1.0,units=m,nadgrids=@null,no_defs" );

			
			
			$poPoint = ms_newpointobj();
			$poPoint->setXY($new_bounds[0],$new_bounds[1]); //original coordinates
			$poPoint->project($projInObj, $projOutObj);	
			
			$poPoint2 = ms_newpointobj();
			$poPoint2->setXY($new_bounds[2],$new_bounds[3]); //original coordinates
			$poPoint2->project($projInObj, $projOutObj);	


			$map->extent->minx=$poPoint->x;    
			$map->extent->miny=$poPoint->y;		
			$map->extent->maxx=$poPoint2->x;  
			$map->extent->maxy=$poPoint2->y;    
			
			
			
			

			$map->setExtent($poPoint->x, $poPoint->y, $poPoint2->x, $poPoint2->y);
			

			//echo $map->extent->minx." ".$map->extent->miny." ".$map->extent->maxx." ".$map->extent->maxy ;
			
			
			$x_step=($map->extent->maxx-$map->extent->minx)/($numtocaka);
			$y_step=($map->extent->maxy-$map->extent->miny)/($numtocaka);


			$res=($map->extent->maxx-$map->extent->minx)/50;

			//echo $res;


		//Dio gdje Grass treba prilagoditi

			$n=$map->extent->maxy;
			$s=$map->extent->miny;
			$e=$map->extent->maxx;
			$w=$map->extent->minx;
			
			


			//$Wind_dirAsc_temp=$WebDir."/user_files/$korisnik/wind_dir_temp.asc";
			//$Wind_speedAsc_temp=$WebDir."/user_files/$korisnik/wind_speed_temp.asc";

			$Wind_dirAsc_temp = $this->Wind_dirAsc_temp;
			$Wind_speedAsc_temp = $this->Wind_speedAsc_temp;
			
			//Ucitaj originalne asc fileove, da se kasnije ne duplira
			$this->preLoadFullAscFiles($rastForWindRegion, $WebDir, $korisnik);

			
			$wind_d=$this->loadFromAsc("windDir", $map->extent->minx, $map->extent->miny, $x_step, $y_step, $numtocaka, false, $WebDir, $korisnik);
			$wind_s=$this->loadFromAsc("windSpeed", $map->extent->minx, $map->extent->miny, $x_step, $y_step, $numtocaka, true, $WebDir, $korisnik);

	
			$points=Array();



			for($i=0;$i<$numtocaka;$i++)
			{
				for($j=0;$j<$numtocaka;$j++)
				{

					$wind_d[$j][$i]=-$wind_d[$j][$i]-90;
					
					$myclass->label->set("size", 70);
					$myclass->label->set("angle", $wind_d[$j][$i]);
					if(is_string($wind_s[$j][$i]))
					{
						$myclass->label->color->setRGB(255,15,0);
					}
					else
					{
						$myclass->label->color->setRGB(0,0,0);
					}
					$points[$i][$j] = $this->windPoint($map->extent->minx + $i*$x_step+($x_step/2), $map->extent->miny+$j*$y_step+($y_step/2));


					if($wind_d[$j][$i]!=-9999)
					{
						$points[$i][$j]->draw($map, $mylayer, $image, 0, $wind_s[$j][$i]);
					}

				}
			}

			//Dvije vazne linije koda koje su bitne kako bi funkcioniralo ovo u openlayers okruzenju, extent se postavi na trenuni tile i renderira se slika te posalje na buffer
			$map->drawLabelCache($image);
			$image->saveImage("", $map);
			
			

			
		}

			public function run_in_background($Command, $Priority = 0)
			{
				if($Priority)
					$PID = shell_exec("nohup nice -n $Priority $Command 2> /dev/null & echo $!");
				else
			  $PID = shell_exec("nohup $Command > /dev/null 2> /dev/null & echo $!");
					//$PID = shell_exec("nohup $Command 2> /dev/null & echo $!");
				return($PID);
			}

			public function is_process_running($PID)
			{
				exec("ps $PID", $ProcessState);
				return(count($ProcessState) >= 2);
			}


		public function asd($map,$Wind_dirAsc, $Wind_speedAsc, &$mylayer, &$myclass, $numtocaka, &$image, $WebDir, $rastForWindRegion, $korisnik, $isVlastiti)
		{
		
					/*$minx=$map->extent->minx;
					$miny=$map->extent->miny;
					$x_step=($map->extent->maxx-$map->extent->minx)/($numtocaka);
					$y_step=($map->extent->maxy-$map->extent->miny)/($numtocaka);
		
					$n=$miny + $numtocaka*$y_step;
					$s=$miny;
					$e=$minx + $numtocaka*$x_step;
					$w=$minx;*/
					
					$Wind_dirAsc_temp=$WebDir."/user_files/$korisnik/wind_dir_temp_$isVlastiti.asc";
					$Wind_speedAsc_temp=$WebDir."/user_files/$korisnik/wind_speed_temp_$isVlastiti.asc";
					
					unlink($Wind_dirAsc_temp);
					unlink($Wind_speedAsc_temp);
					

					$this->Wind_dirAsc_temp = $Wind_dirAsc_temp;
					$this->Wind_speedAsc_temp = $Wind_speedAsc_temp;

					$nstt="g.mapset mapset=$korisnik
					
g.region rast=$rastForWindRegion@WebGis res=".$this->grass_res."
g.remove rast='wind_dir_temp_$korisnik'
r.in.arc input=$Wind_dirAsc output=wind_dir_temp_$korisnik type=FCELL mult=1.0
r.out.arc input=wind_dir_temp_$korisnik output=$Wind_dirAsc_temp dp=1
g.remove rast='wind_speed_temp_$korisnik'
r.in.arc input=$Wind_speedAsc output=wind_speed_temp_$korisnik type=FCELL mult=1.0
r.out.arc input=wind_speed_temp_$korisnik output=$Wind_speedAsc_temp dp=2";

					

					$filename="$WebDir/user_files/$korisnik/calculate_wind.sh";
					$fp = fopen($filename, 'w');
					fwrite($fp, $nstt);
					fclose($fp);

					$stringps="$WebDir/user_files/$korisnik/launch_wind.sh";
					$ps = $this->run_in_background($stringps);
					
				

					
					while($this->is_process_running($ps))
					{
							sleep(1);
					}

		}
}



//dl("php_mapscript.so");
session_start();


//echo $korisnik;

//

$isVlastiti=0;


if($_GET["vjetar"]=="vlastiti")
{
$Wind_dirAsc="$WebDir/user_files/$korisnik/wind_dir.asc"; 		
$Wind_speedAsc="$WebDir/user_files/$korisnik/wind_speed.asc";	
$isVlastiti=1;
}
else
{
$Wind_dirAsc="/home/holistic/meteoArhiva/current/wind_dir.asc"; 		
$Wind_speedAsc="/home/holistic/meteoArhiva/current/wind_speed.asc";	
$isVlastiti=0;
}


$rastForWindRegion='el';
$wms_map="$WebDir/vjetar/webgiszupanija.map";





$request = ms_newowsrequestobj();


foreach ($_REQUEST as $key =>$value)
{
	/*if(!strcmp($key,"WIDTH"))
	{
		$value=$value*5;
	}
	if(!strcmp($key,"HEIGHT"))
	{
		$value=$value*5;
	}*/
	
	$request->setParameter($key,$value);
}
ms_ioinstallstdouttobuffer();


if($request->getValueByName('SERVICE') == 'WMS'){
$oMap = ms_newMapobj("$wms_map");
}
if($request->getValueByName('SERVICE') == 'WFS'){
$oMap = ms_newMapobj("$wfs_map");
}


$mylayer = $oMap->getLayerByName("wind");
$myclass = $mylayer->getClass(0);
$mystyle = $myclass->getStyle(0);

$image=$oMap->draw();





$vlastitiWind = new olWind();




$vlastitiWind->asd($oMap,$Wind_dirAsc,$Wind_speedAsc, $mylayer, $myclass, $numtocaka, $image, $WebDir, $rastForWindRegion, $korisnik, $isVlastiti);

$vlastitiWind->drawWind($oMap,$Wind_dirAsc,$Wind_speedAsc, $mylayer, $myclass, $numtocaka, $image, $WebDir, $rastForWindRegion, $korisnik, $isVlastiti);



$oMap->drawLabelCache($image);

$oMap->owsdispatch($request);

$contenttype = ms_iostripstdoutbuffercontenttype();
if ($contenttype == 'image/png'){
header('Content-type: image/png; mode=24bit');
ms_iogetStdoutBufferBytes();
}
if ($contenttype == 'image/png; mode=24bit'){
header('Content-type: image/png; mode=24bit');
ms_iogetStdoutBufferBytes();
}
if ($contenttype == 'application/vnd.ogc.wms_xml'){
$buffer = ms_iogetstdoutbufferstring();
header('Content-type: text/xml');
echo $buffer;
}
if ($contenttype == 'application/vnd.ogc.gml'){

$buffer = ms_iogetstdoutbufferstring();
header('Content-type: text/xml');
echo $buffer;
}
if ($contenttype == 'text/xml'){
$buffer = ms_iogetstdoutbufferstring();
header('Content-type: text/xml');
echo $buffer;
}
if ($contenttype == 'text/html'){
$buffer = ms_iogetstdoutbufferstring();
header('Content-type: text/html');
echo $buffer;
}
 
ms_ioresethandlers();


?>



<?php
/***stara funkcija**/
/*
public function loadFromAsc($filename, $minx, $miny, $x_step, $y_step, $numtocaka, $isSpeed)
		{

			$windData=array();
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


			$windData="";
			while (!feof($fh2)) {
				$windData .= fread($fh2, 8192);
			}
			
			fclose($fh2);

			$wind_data = explode(" ", $windData);
			unset($windData);

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
		
*/

?>		
