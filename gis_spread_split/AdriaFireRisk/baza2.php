<?php


	include_once("../db_functions.php");
	
	$db=new db_func();
	$db->connect();
	$query = "SELECT id_panel, name, lat, lon, xmlpath FROM panels";
	$result = $db->query($query);
	
	$i=0;
	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
	{
		$lat[$i] = $line["lat"];
		$longi[$i]=$line["lon"];
		
		$line["xmlpath"] = str_replace("http://propagator.adriaholistic.eu", "..", $line["xmlpath"]);
		
		$xmlData = simplexml_load_file($line["xmlpath"]);
		$risk[$i] = (float) $xmlData->current_risk_index[0];
		
		$i++;
		$x=$i;
	}


	
	?>
