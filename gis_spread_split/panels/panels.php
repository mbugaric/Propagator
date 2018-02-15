<?php
include_once("../db_functions.php");

session_start();
if($_SESSION['user_name_panels']!="")
{
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
   <style>
	    #myDiv 
		{
		  height:100px;
		  width:100%;
		  position: relative;
		  left: 50%;
		  margin-left: -245px;
		  
		}
		#myDiv img
		{
		  width: 490px;
		  height: 100px;
		  margin:auto;
		  display:inline;
		}
    </style>
</head>
<body>

<div class="container">
  <div class="jumbotron">
    <h1 style="text-align: center;">AdriaFireRisk Panels</h1>
	<div id="myDiv">
		<img src="../css/images/logo490x100.png" >
	</div>
  </div>
  <?php echo "Welcome, ".$_SESSION['user_name_panels']; ?>
  <br />
  <div class="row">
	<div class="col-12">
		<div class="well">
			<button type="button" class="btn btn-success btn-block" onClick="window.open('./existingPanels.php','_self')" >List existing panel locations</button>
		</div>
	</div>
  </div>
  <div class="row">
	<div class="col-12">
		<div class="well">
			<button type="button" class="btn btn-success btn-block" onClick="window.open('./addPanel.php','_self')">Add new panel location</button>
		</div>
	</div>
	<div class="col-12">
		<div class="well">
			<button type="button" class="btn btn-danger btn-block" onClick="window.open('./logout.php','_self')">Logout</button>
		</div>
	</div>
  </div>
</div>

</body>
</html>

<?php
}
?>