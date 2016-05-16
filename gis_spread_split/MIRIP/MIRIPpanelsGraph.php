<?php
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_line.php');
require_once ('jpgraph/src/jpgraph_date.php');

$xmlDir = "/home/holistic/webapp/gis_spread_split/MIRIP/oldXMLs/";
$FWIDir = "/home/holistic/meteoArhiva/";
$locationname ="Split Marjan";

	
		$data = array();
		$dataFWI = array();
		$xdata = array();	
		$xdataFWI = array();			
		$i=0;
		
		//Otvori direktorij u kojem se nalaze xml datoteke
		if ($handle = opendir($xmlDir)) {

			while (false !== ($entry = readdir($handle))) {

				//$entry je ime datoteke (XML-a)
				if ($entry != "." && $entry != "..") 
				{

					//echo "$entry<br />";
					$date = explode(".xml", explode("_", $entry)[4])[0];
					$pieces=explode(".", $date);
					$day=$pieces[0];
					$month=$pieces[1];
					$year=$pieces[2];
					$hour=$pieces[3];
					
					//echo $day." ".$month." ".$year." ".$hour." "."";
					
					
					$timeZone = new DateTimeZone('Europe/Zagreb');          
					$transitionToDst = "$year-$month-$day $hour:00:00";
					$dateToBeSaved = new DateTime($transitionToDst, $timeZone);
					
					//echo $dateToBeSaved->format('D M j, Y G:i:s T') . '<br>';
					$xdata[$i]=$dateToBeSaved->getTimestamp();;
					
					$file = file_get_contents("$xmlDir/$entry", true);
					$xml=simplexml_load_string($file) or die("Error: Cannot create object");
					//echo $xml->current_risk_index."<br />";
					$data[$i]=intval($xml->current_risk_index);
					
					
					$i++;
				}
			}

			closedir($handle);
		}
		
		
		array_multisort($xdata, $data);
		
		
		
		$firstDate=intval($xdata[0]);
		$lastDate=intval(end($xdata));
		$currentDate=intval($firstDate);
		
		//echo $firstDate." ".$lastDate." ".$currentDate."<br />";
		
		
		$i=0;
		while($currentDate<$lastDate)
		{
			//echo $currentDate."<br />";
			$date=getdate($currentDate);
			
			if(strlen($date[mon])==1)
			{
				$mon="0".$date[mon];
			}
			else
			{
				$mon=$date[mon];
			}
			
			if(strlen($date[mday])==1)
			{
				$mday="0".$date[mday];
			}
			else
			{
				$mday=$date[mday];
			}
			
			$dateToProccess=$mday.".".$mon.".".$date[year];
			
			//echo $dateToProccess."<br />";
			$fwiFile=$FWIDir."/".$dateToProccess."/pozar.lis";
			//$file2 = file_get_contents("$fwiFile", true);
			
			$searchthis = $locationname;
			$matches = array();

			$handle = @fopen($fwiFile, "r");
			if ($handle)
			{
				while (!feof($handle))
				{
					$buffer = fgets($handle);
					if(strpos($buffer, $searchthis) !== FALSE)
						$matches[] = $buffer;
				}
				fclose($handle);
			}

			
			$pieces=explode(" ", $matches[0]);
			$lastWord=end($pieces);
			$penultimateWord=prev($pieces);
			$opasnostWord = $penultimateWord." ".$lastWord;
			
			if(trim($opasnostWord) == "vrlo mala")
				$opasnost=1;
			else if(trim($opasnostWord) == "mala")
				$opasnost=2;
			else if(trim($opasnostWord) == "umjerena")
				$opasnost=3;
			else if(trim($opasnostWord) == "velika")
				$opasnost=4;
			else if(trim($opasnostWord) == "vrlo velika")
				$opasnost=5;
			
			//echo $opasnostWord." ".$opasnost."<br />";
			
			$dataFWI[$i]=$opasnost;
			$xdataFWI[$i]=$currentDate;
			$currentDate=$currentDate+86400;
			$i++;
		}
			
		
		
		
	
		

		

		 
		 
		// Create the new graph
		$graph = new Graph(1800,700);
		 
		// Slightly larger than normal margins at the bottom to have room for
		// the x-axis labels
		$graph->SetMargin(40,40,30,130);
		 
		// Fix the Y-scale to go between [0,100] and use date for the x-axis
		$graph->SetScale('datlin',0,5);
		$graph->title->Set("Wildfire risk index");
		 
		// Set the angle for the labels to 90 degrees
		$graph->xaxis->SetLabelAngle(90);
		 
		$lineMIRIP = new LinePlot($data,$xdata);
		$lineMIRIP->SetLegend('AdriaFireRisk');
		$lineMIRIP->SetFillColor('lightblue@0.5');
		$graph->Add($lineMIRIP);
		
		$lineFWI = new LinePlot($dataFWI,$xdataFWI);
		$lineFWI->SetLegend('FWI');
		$lineFWI->SetFillColor('lightred@0.5');
		$graph->Add($lineFWI);
		
		
		$graph->Stroke();
		
		
		
		
		
		?>
