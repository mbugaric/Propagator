<?php

	//$contents = file_get_contents("/home/holistic/webapp/gis_spread_split/MIRIP/access.log");
	$contents = file_get_contents("/var/log/apache2/access.log");
	
	//echo $contents;


	$latestIP="";
	$latestTime="";
	
	//echo date('d/M/Y:H:m:s', time())."<br />";
	$currentTime=time();
	
	$min_time=999999;
	
	foreach(preg_split("/((\r?\n)|(\r\n?))/", $contents) as $line){
		
		
		
		if (strpos($line,'"GET /gis_spread_split/MIRIP/HR_Split_Marjan_1.xml HTTP/1.1" 200 355 "-" "-"') !== false) {
			
			
			
			$pieces = explode(" ", $line);
			$test = strtotime(trim($pieces[3], "[")." ".trim($pieces[4], "]"));
			
			
		
			$differenceInSeconds= $currentTime-$test;
			
			
			
			if($min_time>$differenceInSeconds)
			{
				$min_time=$differenceInSeconds;
				$latestIP=$pieces[0];
			}

			
		}
		
	} 
	
	$javljanjePrijeXSati=$min_time/60/60;
	echo "Zadnje javljanje prije $javljanjePrijeXSati sati od strane ($latestIP)";
	
	$threshold=15*60*60; //15sati
	if($min_time>$threshold)
	{
		
		$message="Zadnje javljanje prije $javljanjePrijeXSati sati od strane ($latestIP)";
		
		$to      = 'toni.jakovcevic@gmail.com';
		$subject = 'Problem sa Marjan panelom';
		$message = "Zadnje javljanje prije $javljanjePrijeXSati sati od strane ($latestIP)";
		$headers = 'From: kamismeteo@gmail.com' . "\r\n" .
			'Reply-To: kamismeteo@gmail.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		mail($to, $subject, $message, $headers);
	}
 

?>