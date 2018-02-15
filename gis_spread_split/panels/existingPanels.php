<?php
include_once("../db_functions.php");

session_start();
if($_SESSION['user_name_panels']!="")
{
	
	$db=new db_func();
	$db->connect();
	$query = "SELECT id_panel, name, lat, lon, xmlpath FROM panels WHERE user_id = '".$_SESSION['id_user']."'";
	$result = $db->query($query);
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
	<script>
	//
	
	function handleUpdatePanel(id)
	{
		lat=document.getElementById("Latitude_"+id).value;
		lon=document.getElementById("Longitude_"+id).value;
		window.open('./updatePanel.php?id='+id+'&lat='+lat+'&lon='+lon,'_self');
	}
	
	//href=\"deletePanel.php?id=$id\"
	function handleDeletePanel(id)
	{
		var result = confirm("Want to delete?");
		if (result) {
			window.open('./deletePanel.php?id='+id,'_self');
		}
	}
	</script>
  
  </head>
<body>

<div class="container">
  <div class="jumbotron">
    <h1 style="text-align: center;">AdriaFireRisk Panels</h1>
  </div>
  <?php echo "Welcome, ".$_SESSION['user_name_panels']; ?>
  <br />
  NOTE: XML files may not appear immediately when now location is added.

  <h2>Existing panels</h2>
  <table class="table">
    <thead>
      <tr>
        <th>Location name</th>
        <th>lat</th>
        <th>lon</th>
		<th>XML file path (automatically generated)</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
	<?php
		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			echo "<tr>";
				echo "<td>".$line[name]."</td>";
				$id=$line[id_panel];
				echo "<td><input type=\"number\"  step=\"0.00001\" id=\"Latitude_$id\" value=\"$line[lat]\" required></td>";
				echo "<td><input type=\"number\"  step=\"0.00001\" id=\"Longitude_$id\" value=\"$line[lon]\" required></td>";
				echo "<td><a href=\"$line[xmlpath]\">$line[xmlpath]</a></td>";				
				echo "<td><button class=\"label label-warning\" onclick=\"handleUpdatePanel($id)\" >Save changes</a></td>";
				echo "<td><a class=\"label label-danger\" onclick=\"handleDeletePanel($id)\">Delete</a></td>";
			echo "</tr>";
			}
		
		
		
	?>
    </tbody>
  </table>
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
?>