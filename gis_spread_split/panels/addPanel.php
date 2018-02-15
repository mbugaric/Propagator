<?php
session_start();
include_once("../db_functions.php");

if($_POST['locationName']!="" && $_POST['Longitude']!="" && $_POST['Latitude']!="")
{
	/*echo $_POST['locationName']."<br />";
	echo $_POST['Longitude']."<br />";
	echo $_POST['Latitude']."<br />";*/
	
	//echo $_SESSION['id_user'];
	

	
	$sql="insert into  panels   (name, lat, lon, user_id)
values('".$_POST['locationName']."', '".$_POST['Latitude']."', '".$_POST['Longitude']."',".$_SESSION['id_user'].") RETURNING id_panel;";
	//echo $sql."<br />";
	$db=new db_func();
	$db->connect();

	$result = $db->query($sql);
	
	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		$id=$line[id_panel];
	}
	
	$nameForXML = str_replace(" ", "_", $_POST['locationName']);
	$nameForXML = strtolower($nameForXML);
	$nameForXML = $nameForXML."_".$id.".xml";
	$nameForXML=ucfirst($nameForXML);
	$nameForXML="http://propagator.adriaholistic.eu/panels/XML/$nameForXML";
	
	
	$query2 = "UPDATE panels SET xmlpath='$nameForXML' WHERE id_panel = ".$id;
	//echo $query2." ";

		$result = $db->query($query2);
			if ($result)
				echo "<div class=\"well\">Success</div>";
			else
				echo "<div class=\"well\">Error</div>";
		
	
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
	
	
	if ($result)
		echo "<div class=\"well\">Success</div>";
	else
		echo "<div class=\"well\">Error</div>";
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
<?
} 
else 
{


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
   <link rel="stylesheet" href="http://openlayers.org/en/v3.16.0/css/ol.css" type="text/css">
</head>
<body>

<style>
  .map {
	height: 400px;
	width: 100%;
  }
</style>
<script src="http://openlayers.org/en/v3.16.0/build/ol.js" type="text/javascript"></script>

<div class="container">
  <div class="jumbotron">
    <h1 style="text-align: center;">AdriaFireRisk Panels</h1>
  </div>
  <?php echo "Welcome, ".$_SESSION['user_name_panels']; ?>
  <br /><br />


<form action="" method="post">
	<div class="form-group">
		<label class="control-label col-sm-2">Location name:</label>
		<div class="col-sm-10">
		  <input type="text" class="form-control" id="locationName" name="locationName" placeholder="Enter location name" required>
		</div>
	  </div>
	  <div class="form-group">
		<label class="control-label col-sm-2" for="Latitude">Latitude (decimal):</label>
		<div class="col-sm-4"> 
		  <input type="number"  step="0.00001" class="form-control" id="Latitude" name="Latitude" placeholder="Enter Latitude" required>
		</div>
	  <label class="control-label col-sm-2" for="Longitude" >Longitude (decimal):</label>
		<div class="col-sm-4"> 
		  <input type="number"  step="0.00001" class="form-control" id="Longitude" name="Longitude" placeholder="Enter longitude" required>
		</div>
	  </div>
	  <div class="form-group"> 
		<div class="col-sm-offset-2 col-sm-10">
		  <button type="submit" class="btn btn-default">Submit</button>
		</div>
	  </div>
	  <br /><br />
</form>


<div id="map" class="map"></div>
    <script type="text/javascript">
	
	
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM(),
                name: 'OpenStreetMap'
          })
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([16.10, 42.82]),
          zoom: 5
        })
      });
	  
		var mousePosition = new ol.control.MousePosition({
				coordinateFormat: ol.coordinate.createStringXY(2),
				projection: 'EPSG:4326',
				target: document.getElementById('myposition'),
				undefinedHTML: '&nbsp;'
			  });

			  map.addControl(mousePosition);
	  
	  map.on('click', function(evt) {
		var coordinate = evt.coordinate;
		var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
		  var lon = lonlat[0];
		  var lat = lonlat[1];
		  lon = Math.round(lon * 1000000000) / 1000000000;
		  lat = Math.round(lat * 1000000000) / 1000000000;
		  document.getElementById("Longitude").value= lon;
		  document.getElementById("Latitude").value= lat;
		  
		});

    </script>
<br /><br /><br /><br /><br />
<div class="row">
		<div class="col-12">
			<div class="well">
				<button type="button" class="btn btn-success btn-block" onClick="window.open('./panels.php','_self')">Back to main page</button>
			</div>
		</div>
	</div>
</body>
</html>

<?php
}
}
?>