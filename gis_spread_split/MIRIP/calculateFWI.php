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
class calculateFWI
{
		private $Wind_dirAsc_temp;
		private $Wind_speedAsc_temp;
			

		public function prepare($meteoArhivaDir)
		{
		
					$this->Wind_dirAsc_temp=$meteoArhivaDir."/current/wind_dir.asc";
					$this->Wind_speedAsc_temp=$meteoArhivaDir."/current/wind_speed.asc";
					
		}
			
			
		//***************************************************************************************************//

		//	Funkcija koja iz .asc file procita podatke, prilagodi ih trenutnom prikazu u mapserveru,
		//	odnosno georeferencira ih, izraèuna prosijeènu vrijednost, te prilagodi koordinatnom sustavu
		//	samog mapservera koji ispisuje od dolje lijeve prema desno i prema gore, za razliku od samog
		//	asc file-a koji je od gore lijevo prema desno i dolje.

		//***************************************************************************************************//
		public function loadFromAsc($type/*, $minx, $miny, $x_step, $y_step, $numtocaka, $isSpeed, $WebDir, $korisnik*/)
		{

			$rand=rand(0,99999);
			
			$filename="";
			$input="";
			
			if(!strcmp($type,"windDir"))
			{
				$filename=$this->Wind_dirAsc_temp;
			}
			else if(!strcmp($type,"windSpeed"))
			{
				$filename=$this->Wind_speedAsc_temp;	
			}
			
	
			
			$string = file_get_contents($filename, true);
			


			
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
			

			$nrows=(int)$nrows;
			$ncols=(int)$ncols;

			
			$data="";
			for($i=7; $i<7+$nrows; $i++)
			{
				$data.=$windData[$i];
			}
			
			$windData=$data;
						

			
			
			$wind_data = explode(" ", $windData);
			unset($windData);

			$wind2D=array();	
			$listSize=0;

			

			for($i=$nrows-1;$i>=0;$i--)
			{
				for($j=0;$j<$ncols;$j++)
				{
					$wind2D[$i][$j]=$wind_data[$listSize];
					$listSize++;
				}	
			}
			
			var_dump($wind2D);
			

			//return $wind1;
		}
		
}


$cFWI = new calculateFWI();
$cFWI->prepare("/home/holistic/meteoArhiva/");
$cFWI->loadFromAsc("windDir");
























