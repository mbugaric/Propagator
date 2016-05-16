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

$pass=array();
array_push($pass, "apdhu76a");
array_push($pass, "7f3490fg");
array_push($pass, "945bc02k");
array_push($pass, "3jkg734n");

for($counter=0; $counter<count($users); $counter++) {
    $username=$users[$counter];
	$password=hash_hmac('ripemd160',$pass[$counter],"AdriaProp");
	echo "INSERT INTO users (username, password, language_id, email)
    VALUES ('$username', '$password', 1, '$username@$username'); <br />";
	//echo $username.":".$username."<br />";
}


//echo hash_hmac('ripemd160',"pass21","AdriaProp");

//var_dump($parsed); // (result = dog)


?>