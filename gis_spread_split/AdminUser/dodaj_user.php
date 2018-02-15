<?php require("../korisnik.php"); ?>
<?

//print_r( $_REQUEST);

$sql="insert into  system_users   (name_user,  lastname_user, username_user , password_user,user_level)
values('".$_REQUEST['name']."', '".$_REQUEST['lastname']."', '".$_REQUEST['uname']."','".$_REQUEST['password']."',".$_REQUEST['user_level'].");";

 //echo $sql;
if ($res=pg_query($sql)){
echo "Success";}
else
echo "Error!";
 ?>