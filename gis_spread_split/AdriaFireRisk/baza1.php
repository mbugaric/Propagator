<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "zavrsni_rad_baza";
	$lat= array("","","");
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	//potrebno promijeniti url,ovaj url samo za provjeru ispravnosti
    $url="http://agentii.infoturism.ro/xml/4699_18f2f97e00a6d416/lm/1325368800/";
	$ch=curl_init();
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_URL,$url);
	
	$data=curl_exec($ch);
	curl_close($ch);
	$xml = simplexml_load_string($data);
	$con=mysql_connect("localhost","root","");
	mysql_select_db("zavrsni_rad_baza",$con) or die(mysql_error());
	$i=0;
	foreach($xml -> item as $row){
		$i++;
		$price =$row ->price;
		$sql ="UPDATE `adria_fire_panels` SET `risk`='$price' WHERE `id`='$i'";
	
	$result=mysql_query($sql);
	if(!$result){
		echo 'mysql error';
	}else{
		echo 'succes';
	}
	}
?>