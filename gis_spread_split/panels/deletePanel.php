<?php

include_once("../db_functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Panels</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="http://openlayers.org/en/v3.16.0/css/ol.css" type="text/css">
</head>
<body>
	<div class="container">
  <div class="jumbotron">
    <h1 style="text-align: center;">AdriaFireRisk Panels</h1>
  </div>
  
  <?
session_start();
	$panel_id=$_GET["id"];
	
	if($panel_id)		
	{
		$db=new db_func();
		$db->connect();
		$query = "DELETE FROM panels WHERE id_panel = ".$panel_id;
		$result = $db->query($query);
			if ($result)
				echo "<div class=\"well\">Success</div>";
			else
				echo "<div class=\"well\">Error</div>";
		}
?>
	<div class="row">
		<div class="col-12">
			<div class="well">
				<button type="button" class="btn btn-success btn-block" onClick="window.open('./existingPanels.php','_self')">Back to main page</button>
			</div>
		</div>
	</div>
</div>
</body>
</html>
	