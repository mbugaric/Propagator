<?php require("../korisnik.php"); ?>
<?

//print_r( $_REQUEST);

$sql="delete from  users  where user_id=".$_REQUEST['id_user'].";";
//echo $sql;
if ($res=pg_query($sql)){
echo "Success in deleting User";}
else
echo "Error in deleting User";

?>