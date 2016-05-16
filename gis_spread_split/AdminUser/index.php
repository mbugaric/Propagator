<?php 
session_start();
include_once("../db_functions.php");
include_once("../postavke_dir_gis.php"); 
//Samo ukoliko je user uspješno logiran
if($korisnik!="" && $adminuser=="1") {
	?>
	<html>
<head>
<?php include_once("../header.php");?>
<link rel="stylesheet" href="../css/style.css" type="text/css" />
<style>
table {
border: gray 1px solid;
}
th, td
{
	font-size: 12px;
	//border: gray 1px solid;
	padding: 5px;
}
tr:nth-child(even){background-color: rgb(200,200,200)}

thead, #new_title {
background-color: rgb(76,175,80); 
color:#fff;
font-weight:bold;

}
 
</style>
</head>
<body>
<center>
<h1>AdriaFirePropagetor Users</h1>
<?

// Izmjena podataka korisnika
//..............................
if (isset($_POST['izmjena'])){

if($_POST['izmjena']=="CHANGE USERS DATA"){

echo "<h3>User data has been successfully changed.</h3>";
			}
	}
	
// Brisanje podataka korisnika
//..............................
if (isset($_POST['izbrisi'])){

if($_POST['izbrisi']=="DELITE USERS DATA"){

echo "<h3>User has been successfully deleted.</h3>";
			}
	}

// Ubacivanje novog korisnika
//..............................
if (isset($_POST['dodaj'])){

if($_POST['dodaj']=="INSERT USERS DATA"){

echo "<h3>New user has been successfully inserted.</h3>";
			}
	}

			
//echo $korisnik;			
$SPREMI="SAVE";
$IZBRISI="DELITE";
$DODAJ_NOVI="CREATE";

if (class_exists('db_func')) {
		//Connect to database
//Connect to database
$db = new db_func();
$db->connect();

$query="SELECT * FROM users order by user_id;";
//echo $query;
		?>
		
<form id="forma1" method="post" action="">
  <table id='myTable'>
  <thead> 
  <tr> 
  <td>Id</td>
  <td>Username</td>
  <td>Password</td>
  <td>E-mail</td>
  <td>Default View (Lat)</td>
   <td>Default View (Lon)</td>
    <td>Def.Zoom</td>
  <td>Lang.</td>
  <td>Edit.</td>
  <td> </td>
    <td></td>
    <td> </td>
  
  </tr>
  </thead>
<?
		$result = $db->query($query);
		
		while($row = pg_fetch_object($result)){
		
		$defaultview = $row->defaultview;
		$latlon = (explode("|",$defaultview));
		$lat = $latlon[0];
		$lon = $latlon[1];
		$zoom = $latlon[2];
		
		echo "<tr>";
			echo "<td>".$row->user_id."</td>";
			echo "<td> <input type=text id='username".$row->user_id."' value=".$row->username."></td>";
			//echo "<td>&nbsp;</td>";
			echo "<td> <input type=password id='password".$row->user_id."' value=".$row->password."></td>";
			echo "<td> <input type=text id='email".$row->user_id."' value=".$row->email."></td>";
			echo "<td> <input type=text id='lat".$row->user_id."' value=".$lat."></td>";
			echo "<td> <input type=text id='lon".$row->user_id."' value=".$lon."></td>";
			echo "<td> <input type=text id='lon".$row->user_id."' value=".$zoom." SIZE='3'></td>";
			echo "<td> <input type=text id='language_id".$row->user_id."' value=".$row->language_id." SIZE='2'></td>";
			echo "<td> <input type=text id='editable_id".$row->user_id."' value=".$row->editable_id." SIZE='2'></td>";
			echo "<td>&nbsp;</td>";
			
/*
		//	echo "<td> <input type=text id='user_level".$row->user_id."' value=".$row->user_level."></td>";
			echo "<td> <select id='user_level".$row->user_id."' >".create_drop_down_ulevels($row->user_level)."</select></td>";
*/
 			/*
			echo "<td> <input type=button id='save".$row->user_id."' value=".$SPREMI." onclick='spremi(".$row->user_id.")'></td>";
			echo "<td> <input type=button id='delete".$row->user_id."' value=".$IZBRISI." onclick='izbrisi(".$row->user_id.")'></td>";
			*/
			
			echo "<td> <input type='submit' onclick='submit()' value='CHANGE USERS DATA' id='izmjena' name='izmjena'></td>";
			echo "<td> <input type='submit' onclick='submit()' value='DELITE USERS DATA' id='izbrisi' name='izbrisi'></td>";
			
echo "</tr>";
			}
echo "<tr><td colspan='12' align='center' id='new_title'><b>New User</b></td>";			
echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td> <input type=text id='aaa' value=''></td>";
			echo "<td> <input type=password id='password_new' value=''></td>";
			echo "<td> <input type=text id='email_new' value=''></td>";
			echo "<td> <input type=text id='lat_new' value=''></td>";
			echo "<td> <input type=text id='lon_new' value=''></td>";
			echo "<td> <input type=text id='zoom_new' value='' SIZE='3'></td>";
			echo "<td> <input type=text id='language_id_new' value='' SIZE='2'></td>";
			echo "<td> <input type=text id='editable_id_new' value='' SIZE='2'></td>";
			echo "<td>&nbsp;</td>";
			
			echo "<td> <input type='submit' onclick='submit()' value='INSERT USERS DATA' id='dodaj' name='dodaj'></td>";	 
		 
echo "</tr>";	
			echo "</table>";
			?>
			<table width="60%" cellpadding="0" cellspacing="0" style="border:gray 0px solid">
				<tr>
					<td><img src="../gif/holistic_logo.png" bodrer="0" height="80"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td ><br><img src="../gif/EU_flag.png" border="0" height="50"> &nbsp;&nbsp;</td>
					<td>This project was partly financed by the European Union.<br />The content of this website does not reflect the official opinion of the European Union.</td>
					<td valign="top">&nbsp;&nbsp;&nbsp;<img src="../gif/ipa_logo.png" bodrer="0" height="80"></td>
				</tr>
			</table>
	</center>
</form>	
			<?
			
			// Free resultset
		pg_free_result($res);
		
		// Closing connection
		$db->disconnect();
		
			}
			else { echo 'Can not conect to Database!';}

?>

			
</body>
</html>
<?
	} //Kraj ako je logiran
	else {
	echo '<center><h2>AdriaFirePropagator</h2>'._NATPIS_NO_LOGIN.'</center>';
	}
?>

