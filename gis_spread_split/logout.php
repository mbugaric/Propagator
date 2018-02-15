<?php
session_start();
session_unset();
session_destroy();

header("location:login.php");

//header("Location:  http://propagator.adriaholistic.eu" ); /*Redirect browser */
exit();
?>