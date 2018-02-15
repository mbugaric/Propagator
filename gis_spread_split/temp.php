<?php
//sleep(45);

$users=array();
array_push($users, "zradunic");
array_push($users, "bcuk");
array_push($users, "zpopovic");
array_push($users, "mstarcevic");
array_push($users, "rpodbojec");
array_push($users, "njagodin");
array_push($users, "rrurzic");
array_push($users, "jaras");
array_push($users, "zblacic");
array_push($users, "nivancevic");
array_push($users, "mmagud");
array_push($users, "rrizzolo");
array_push($users, "evalese");
array_push($users, "acardillo");
array_push($users, "mottaviano");
array_push($users, "rlotto");
array_push($users, "cliva");
array_push($users, "tstrum");
array_push($users, "jcernigoj");
array_push($users, "ibenko");
array_push($users, "mergaver");
array_push($users, "zkritikou");
array_push($users, "kkollyrou");
array_push($users, "imilicevic");
array_push($users, "rbosnjak");
array_push($users, "mcovic");


foreach ($users as &$value) {
    $username=$value;
	$password=hash_hmac('ripemd160',$value,"AdriaProp");
	/*echo "INSERT INTO users (username, password, language_id, email)
    VALUES ('$username', '$password', 1, '$username@$username'); <br />";*/
	//echo $username.":".$username."<br />";
}


/*
$users=array();
array_push($users, "rruzic");
array_push($users, "clivia");
array_push($users, "tsturm");
array_push($users, "friuli_editor");
array_push($users, "zadar_editor");
array_push($users, "wherzegovina_editor");
array_push($users, "ionian_editor");
array_push($users, "split_editor");
array_push($users, "ajdovscina_editor");
array_push($users, "molise_editor");
array_push($users, "spllit_viewer");
array_push($users, "rrurzic");
array_push($users, "cliva");
array_push($users, "tstrum");
array_push($users, "split_viewer");*/



$users=array();
array_push($users, "nnarda");
array_push($users, "afurlan");
array_push($users, "smichos");
array_push($users, "nmijanovic");
array_push($users, "panels1");
array_push($users, "hvarcase");
array_push($users, "lastovocase");
array_push($users, "ljiljana");
array_push($users, "ioannouFB14");
array_push($users, "aprimiero");
array_push($users, "istraCounty");
array_push($users, "splitCounty");
array_push($users, "sibenikCounty");
array_push($users, "ForestDeptCorfu");
array_push($users, "FireFighterCorfu");
array_push($users, "prvitreptac");
array_push($users, "kamir");
array_push($users, "corfupanels");
array_push($users, "ddukic");
array_push($users, "OiV");
array_push($users, "upravahnz");
array_push($users, "Baksic");
array_push($users, "zsutlar");


$pass=array();
array_push($pass, "apdhu76a");
array_push($pass, "7f3490fg");
array_push($pass, "945bc02k");
array_push($pass, "3jkg734kgn");
array_push($pass, "3jkg734kgn");
array_push($pass, "hvarcase");
array_push($pass, "lastovocase");
array_push($pass, "ljiljana1700");
array_push($pass, "l3jhg73hrf");
array_push($pass, "a908askdj");
array_push($pass, "dfistra933");
array_push($pass, "spl74hf");
array_push($pass, "sib7g4ni");
array_push($pass, "stDeptC23hu");
array_push($pass, "eFight4j389d");
array_push($pass, "hufd36s");
array_push($pass, "sd8923jk");
array_push($pass, "asd87wek3");
array_push($pass, "34nso7d");
array_push($pass, "v32di4o");
array_push($pass, "ao3g6nn");
array_push($pass, "dj3a8fh");
array_push($pass, "jfu4hdr");

for($counter=0; $counter<count($users); $counter++) {
    $username=$users[$counter];
	$password=hash_hmac('ripemd160',$pass[$counter],"AdriaProp");
	echo "INSERT INTO users (username, password, language_id, email)
    VALUES ('$username', '$password', 1, '$username@$username'); <br />";
	//echo $username.":".$username."<br />";
}


/*$password=hash_hmac('ripemd160',"3jkg734kgn","AdriaProp");
echo $password;*/

//echo hash_hmac('ripemd160',"pass21","AdriaProp");

//var_dump($parsed); // (result = dog)


?>