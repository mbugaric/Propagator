<?php include_once("../db_functions.php");
include_once("../postavke_dir_gis.php"); ?>
<html>
<head>
<?php include_once("../header.php");?>
<link rel="stylesheet" href="../css/style.css" type="text/css" />
</head>
<body>
<h1>AdriaFirePropagetor Users</h1>
<?


/*{
'superadmin'=>11,
'admin'=>10,
'operater'=>2,
'korisnik'=>1
}*/

 
/*
function create_drop_down_ulevels($level){
$url="user_levels.json";
$contents = file_get_contents($url); 
 
$contents = utf8_encode($contents); 
$user_levels = json_decode($contents); 
$returnstring="<option></option>";
//print_r($user_levels);
foreach ($user_levels as $k=>$v){
$returnstring.="<option value=".$v." ";
if ($v==$level)  $returnstring.=" selected ";
$returnstring.=">$k</option>";
}
return $returnstring;
}
*/

			
echo $korisnik;			
$SPREMI="SPREMI";
$IZBRISI="IZBRIŠI";
$DODAJ_NOVI="DODAJ NOVI";

if (class_exists('db_func')) {
		//Connect to database
//Connect to database
$db = new db_func();
$db->connect();

$query="SELECT * FROM users order by user_id;";
echo $query;
		?>
  <table id='myTable' style="border: gray 1px solid;">
  <thead> 
  <tr> 
  <td>Id</td>
  <td>Username</td>
  <td>Password</td>
  <td>E-mail</td>
  <td>Default View</td>
  <td>Language</td>
  <td>Editable Language</td>
  <td> </td>
    <td></td>
    <td> </td>
  
  </tr>
  </thead>
<?
		$result = $db->query($query);
		
		while($row = pg_fetch_object($result)){
		echo "<tr>";
			echo "<td>".$row->user_id."</td>";
			echo "<td> <input type=text id='username".$row->user_id."' value=".$row->username."></td>";
			//echo "<td>&nbsp;</td>";
			echo "<td> <input type=password id='password".$row->user_id."' value=".$row->password."></td>";
			echo "<td> <input type=text id='email".$row->user_id."' value=".$row->email."></td>";
			echo "<td> <input type=text id='defaultview".$row->user_id."' value=".$row->defaultview."></td>";
			echo "<td> <input type=text id='language_id".$row->user_id."' value=".$row->language_id."></td>";
			echo "<td> <input type=text id='editable_id".$row->user_id."' value=".$row->editable_id."></td>";
			echo "<td>&nbsp;</td>";
			
			
/*
		//	echo "<td> <input type=text id='user_level".$row->user_id."' value=".$row->user_level."></td>";
			echo "<td> <select id='user_level".$row->user_id."' >".create_drop_down_ulevels($row->user_level)."</select></td>";
*/
 
			
			
			
			echo "<td> <input type=button id='save".$row->user_id."' value=".$SPREMI." onclick='spremi(".$row->user_id.")'></td>";
			echo "<td> <input type=button id='delete".$row->user_id."' value=".$IZBRISI." onclick='izbrisi(".$row->user_id.")'></td>";
			
			
echo "</tr>";
			}
			
echo "<tr>";
			echo "<td>&nbsp;</td>";
			echo "<td> <input type=text id='aaa' value=''></td>";
			echo "<td> <input type=password id='password_new' value='xxx'></td>";
			echo "<td> <input type=text id='email_new' value=''></td>";
			echo "<td> <input type=text id='defaultview_new' value=''></td>";
			echo "<td> <input type=text id='language_id_new' value=''></td>";
			echo "<td> <input type=text id='editable_id_new' value=''></td>";
			echo "<td>&nbsp;</td>";
			echo "<td colspan=2> <input type=button id='save_new' value='".$DODAJ_NOVI."' onclick='dodaj_user()'></td>";
		 
		 
echo "</tr>";	
			echo "</table>";
			
			// Free resultset
		pg_free_result($res);
		
		// Closing connection
		$db->disconnect();
		
			}
			else { echo 'XXX';}

?>
</body>
</html>