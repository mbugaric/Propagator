<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$links=array();
$long=16.3;
$lat=43.9;

for($cc=1;$cc<=30;$cc++)
{
	$users[$cc]["usrname"]="user".$cc;
	//$users[$cc]["pass"]="pass".$cc;
	$users[$cc]["sig"]=hash_hmac("sha256", $users[$cc]["usrname"].$lat.$long, "3Fz3GG4j4p05jjb0gjzWbaME68Mw4aBr");
	//echo $users[$cc]["sig"]."<br />";
	$links[$cc]="http://propagator.adriaholistic.eu/api/v1/api.php?user=".$users[$cc]["usrname"]."&lat=$lat&long=$long&sig=".$users[$cc]["sig"];
}

echo $links[1];

file_get_contents($links[1]);


?>
<script>
  $(document).ready(function(){
		<?php for($cc=1;$cc<=30;$cc++){ ?>

		window.open('<?=$links[$cc]?>');

		<?php } ?>
  });
</script>


	  
	  
<script>
    //  window.open("<?php echo $links[1]; ?>", "_blank"); 
</script>