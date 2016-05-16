<?php require("../korisnik.php"); ?>
<?

//print_r( $_REQUEST);

$sql="update  system_users set name_user='".$_REQUEST['name']."', lastname_user='".$_REQUEST['lastname']."', username_user ='".$_REQUEST['uname']."', password_user='".$_REQUEST['password']."', user_level='".$_REQUEST['user_level']."' where id_user=".$_REQUEST['id_user'].";";
if ($res=pg_query($sql)){
echo "OK";}
else
echo "Greška";
 ?>