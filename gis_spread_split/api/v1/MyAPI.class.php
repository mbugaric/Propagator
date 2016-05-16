<?php
/*ini_set('display_errors', 'On');*/

require_once 'API.class.php';

require_once 'APIkey.class.php';


require_once '../../pozar.php';
require_once '../../db_functions.php';
require_once '../../postavke_dir_gis.php';
require_once '../../setgetFile.php';



class MyAPI extends API
{
    protected $User;
	protected $Lat;
	protected $Lon;
	protected $PID;
	

    public function __construct($request, $origin) {
        parent::__construct($request);
		
	
		//var_dump($this->request);
		$APIKey= new APIkey();


		if(!array_key_exists('user', $this->request))
		{
			throw new Exception('No user provided');
			
		}
		
		$user=$this->request['user'];
		$this->User = $user;
		

		//If simulation is to be started
		if(array_key_exists('lat', $this->request) && array_key_exists('long', $this->request))
		{

			$lat=$this->request['lat'];
			$lon=$this->request['long'];	
			$sig=hash_hmac("sha256", $user.$lat.$lon, "3Fz3GG4j4p05jjb0gjzWbaME68Mw4aBr");
			if($_GET["debug"]==1)
			{
				var_dump($sig);
			}
			
			if (!array_key_exists('sig', $this->request)) {
				throw new Exception('No signature provided');
			} else if (!$APIKey->verifyKey($this->request)) {
				throw new Exception('Invalid signature'); 
			} else if( !is_numeric($lat) || !is_numeric($lon)) {
				throw new Exception('Lat/lon not numeric'); 
			}

			$this->Lat = $lat;
			$this->Lon = $lon;
		}	
		//To check if simulation is finished
		else if(array_key_exists('pid', $this->request))
		{
			$pid=$this->request['pid'];
			$sig=hash_hmac("sha256", $user.$pid, "3Fz3GG4j4p05jjb0gjzWbaME68Mw4aBr");
			if($_GET["debug"]==1)
			{
				var_dump($sig);
			}
			
			if (!array_key_exists('sig', $this->request)) {
				throw new Exception('No signature provided');
			} else if (!$APIKey->verifyKey($this->request)) {
				throw new Exception('Invalid signature'); 
			} 
			
			$this->PID = $pid;
		}
		//Not enough parameters
		else{
			throw new Exception('Not enough parameters!!!');
		}

    }

	protected function checkIfFireExistsWithoutRand($WebDir, $korisnik)
	{
		
		$checkfiresucces="$WebDir/user_files/$korisnik/checkfiresuccess.sh";
		
		$stringchecknewdefault="
	g.mapset mapset=$korisnik
	g.list type=vect > '".$WebDir."/user_files/$korisnik/glistSuccess.log'
	";

		file_put_contents($checkfiresucces, $stringchecknewdefault);

		$stringps="$WebDir/user_files/$korisnik/checkfiresuccess_launch.sh";
		$ps = run_in_backgroundPozar($stringps);
		while(is_process_runningPozar($ps))
		{
			session_write_close();
			sleep(1);
			ob_flush;
			flush();
		}
		
		$myFile22 = "$WebDir/user_files/$korisnik/glistSuccess.log";
		$fh22 = fopen($myFile22, 'r');
		$theData222 = fread($fh22, filesize($myFile22));
		
		fclose($fh22);
		$contourName="contour";
		//$test=explode(" ", $theData222);
		$test = preg_split( '/[ \n]/', $theData222 );
		foreach ($test as &$value) {
			if(strpos($value, "contour") !== false)
			{
				$contourName=trim($value);
			}

		}

		$stringchecknewdefault="
	g.mapset mapset=$korisnik
	v.info map=$contourName > '".$WebDir."/user_files/$korisnik/glistSuccess2.log'
	";

		file_put_contents($checkfiresucces, $stringchecknewdefault);

		$stringps="$WebDir/user_files/$korisnik/checkfiresuccess_launch.sh";
		$ps = run_in_backgroundPozar($stringps);
		while(is_process_runningPozar($ps))
		{
			session_write_close();
			sleep(1);
			ob_flush;
			flush();
		}


		$myFile22 = "$WebDir/user_files/$korisnik/glistSuccess2.log";
		$fh22 = fopen($myFile22, 'r');
		$theData222 = fread($fh22, filesize($myFile22));
		fclose($fh22);
		
		
		
		
		//$glistarray22=preg_split("/[\s+,\t+,\n+]/", $theData222);
		
		$delimeterLeft2="Number of lines:";
		$delimeterRight2="Number of islands:";
		$posLeft2  = stripos($theData222,$delimeterLeft2)+strlen($delimeterLeft2);
		$posRight2 = stripos($theData222,$delimeterRight2,$posLeft2+1);
		$stringtemp=trim(substr($theData222,$posLeft2,$posRight2-$posLeft2));

		//echo $stringtemp." \n";
		
		
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
			return -1;
		}
		else
		{
			return 1;
		}
		

	}

     protected function AdriaFirePropagator() {
		 
 
		 
		if ($this->method == 'GET') {
			
			global $WebDir;
			global $rastForRegion;
			global $MonImgName;
			global $max_resolution;
			global $meteoArchiveDir;
			
			global $fuelParametersFileAlbini;
			global $fuelParametersFileScott;
			global $fuelParametersFileAlbiniDefault;
			global $fuelParametersFileScottDefault;

			$external_param_file_AlbiniDefault = $fuelParametersFileAlbiniDefault;
			$external_param_file_ScottDefault = $fuelParametersFileScottDefault;
			$external_param_file_AlbiniCustom = $fuelParametersFileAlbini;
			$external_param_file_ScottCustom = $fuelParametersFileScott;
			
			global $calculate_ROS_enabled;
			global $rastForModelAlbini;
			global $rastForModelScott;
			
			
			
			
			$korisnik=$this->User;
			
			if(array_key_exists('lat', $this->request) && array_key_exists('long', $this->request))
			{
			
				
				$coodr1=$this->Lat;
				$coodr2=$this->Lon;
				$type=1;
				$spread_vrijeme_js=200;				
				if(array_key_exists('duration', $this->request))
				{
					if(is_numeric($this->request['duration']))
					{
						$spread_vrijeme_js=$this->request['duration'];
					}
				}
				
				
				// Albini_default,Scott_default,Albini_custom,Scott_custom
				if(array_key_exists('fuelModel', $this->request))
				{
					switch ($this->request['fuelModel']) {
						case "Albini_default":
							$chosenFuelModel="Albini_default";  	
							break;
						case "Scott_default":
							$chosenFuelModel="Scott_default"; 
							break;
						case "Albini_custom":
							$chosenFuelModel="Albini_custom"; 
							break;
						case "Scott_custom":
							$chosenFuelModel="Scott_custom"; 
							break;
						default:
							$chosenFuelModel="Invalid fuel model name given... Choosing Albini_default";  
					}
				}
				else
				{
					$chosenFuelModel="Albini_default";  
				}
				
				
				$rastForModel=$chosenFuelModel;
				if($chosenFuelModel=="Albini_custom")
				{
					$rastForModel=$rastForModelAlbini;
				}
				else if ($chosenFuelModel=="Scott_custom")
				{
					$rastForModel=$rastForModelScott;
				}
				else if ($chosenFuelModel=="Albini_default")
				{
					$rastForModel=$rastForModelAlbini;
				}
				else if ($chosenFuelModel=="Scott_default")
				{
					$rastForModel=$rastForModelScott;
				}
				

				global $rastForAspect;
				global $rastForSlope;
				
				
				$slider_value_js=10;
				$spread_comp_js=0.2;
				$step="30";
				global $mapset;$grassmapset=$mapset;
				$perimeters="";
				
				$chosenIgnition = "pointIgnition";
				$waitForExecution=false;
				
				$result="";
				//$result = fire2($WebDir, $rastForRegion, $MonImgName, $max_resolution, $korisnik, $coodr1, $coodr2, $type, $spread_vrijeme_js, $slider_value_js, $spread_comp_js, $step, $grassmapset, $chosenFuelModel, $perimeters, $chosenIgnition, $waitForExecution, $meteoArchiveDir);			
				//echo $WebDir."1 ". $rastForRegion."2 ". $MonImgName."3 ". $max_resolution."4 ". $korisnik."5 ". $coodr1."6 ". $coodr2."7 ". $type."8 ". $spread_vrijeme_js."9 ". $slider_value_js."10 ". $spread_comp_js."11 ". $step."12 ". $grassmapset."13 ". $chosenFuelModel."14 ". $perimeters."15 ". $chosenIgnition."16 ". $waitForExecution."17 ". $meteoArchiveDir."18 ".$external_param_file_AlbiniDefault."19 ". $external_param_file_ScottDefault."20 ". $external_param_file_AlbiniCustom."21 ". $external_param_file_ScottCustom."22 false 23".$rastForModel."24 ". $rastForAspect."25 ". $rastForSlope."26";
				
				$result =  fire2($WebDir, $rastForRegion, $MonImgName, $max_resolution, $korisnik, $coodr1, $coodr2, $type, $spread_vrijeme_js, $slider_value_js, $spread_comp_js, $step, $grassmapset, $chosenFuelModel, $perimeters, $chosenIgnition, false, $meteoArchiveDir, $external_param_file_AlbiniDefault, $external_param_file_ScottDefault, $external_param_file_AlbiniCustom, $external_param_file_ScottCustom, "", false, $rastForModel, $rastForAspect, $rastForSlope); 
				$result = trim(str_replace("\n", "", $result));
				//return $this->User.": ".$result;
				
				//Primjer
				//http://80.80.59.51/cgi-bin/mapserv?map=/home/holistic/webapp/gis_spread_split/user_files/admin/sd_zupanija.map&FORMAT=image%2Fpng&LAYERS=Pozar_vector&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetMap&SRS=EPSG%3A4326&BBOX=16.3,43.55,16.6,43.75&WIDTH=512&HEIGHT=512
				//http://80.80.59.51/cgi-bin/mapserv?map=/home/holistic/webapp/gis_spread_split/user_files/admin/sd_zupanija.map&FORMAT=image%2Fpng&LAYERS=Pozar&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetMap&SRS=EPSG%3A4326&BBOX=16.3,43.55,16.6,43.75&WIDTH=512&HEIGHT=512
				
				$mapfile=$GLOBALS[WebDir]."/user_files/".$this->User."/sd_zupanija.map";
				
				$WMS="http://".$GLOBALS[ip_servera]."/cgi-bin/mapserv?map=".$mapfile."&FORMAT=image%2Fpng";


				$return_value=Array('status' => 'Simulation started', 'statusCode' => $this->statusCode['started'], 'pid' => $result, 'duration' => $spread_vrijeme_js, 'fuel model' => $chosenFuelModel);
				
				return json_encode($return_value);
			
			}
			else if(array_key_exists('pid', $this->request))
			{
				$vectorLayer="Pozar_vector";
				$rasterLayer="Pozar";
				
				//var_dump($this->PID);
				if(is_process_runningPozar($this->PID))
				{
					return json_encode(Array('status' => "Running", 'statusCode' => $this->statusCode['running']));
				}
				else
				{
					//Dohvat bboxa
					$bbox = file_get_contents("$WebDir/user_files/$korisnik/raster/bbox.txt");	

					if($this->checkIfFireExistsWithoutRand($WebDir, $korisnik) == -1 || $this->PID == 1234567899)
					{
						//error or empty results
						return json_encode(Array('status' => "Finished - empty results", 'statusCode' => $this->statusCode['emptyResults'], /*'WMS' => $WMS,*/ 'raster layer' => $rasterLayer, 'vector layer' => $vectorLayer, 'bbox' => $bbox));
					}
					else{
						return json_encode(Array('status' => "Finished", 'statusCode' => $this->statusCode['finished'], /*'WMS' => $WMS,*/ 'raster layer' => $rasterLayer, 'vector layer' => $vectorLayer, 'bbox' => $bbox));
					}
					
					
				}
				
			}
			
			
			
			
        } else {
            return "Only accepts GET requests";
        }
     }
	 

	 
 }
 
 ?>