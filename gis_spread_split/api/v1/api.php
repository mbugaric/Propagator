<?php

require_once 'MyAPI.class.php';


// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}


try {
    $API = new MyAPI($_SERVER['REQUEST_URI'], $_SERVER['HTTP_ORIGIN']);
	echo $API->processAPI();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage(), 'statusCode' => 4));
}



//Za API
//$sig = hash_hmac("sha256",$params['email'].$params['userid'],$API_KEY)
?>