<?php
session_start();
require("zastita.php");
require("postavke_dir.php"); 


//Provjera je li uopće otvoren session
if ((!isset($_SESSION['userid'])) 
	|| ($_SESSION['who_session']!=md5($_SESSION['userid'].$_SESSION['user_name'].$_SESSION['time_session']))) 
	{
		print "<script>document.location.href='../index.html'</script>";
        exit();
}
//ukoliko je otvoren session provjera da li taj korisnik smije uci na te stranice na osnovu toga sto pise u filu postavke_dir koji se nalazi u istom direktoriju u varijabli level_login
else
{

	$level = explode (" ", $level_login);

	if(!$level[0])
		$level[0]=$level_login;

	$lev_flag=0;
	$br=0;

	//Ako slucajno ne pise nista u file postavke_dir za $level_login to znači da svi mogu tu pristupati
	if(!$level[0])
		$lev_flag=1;


	while ($level[$br])
	{
		if($level[$br] == $_SESSION["user_level"])
		{
			$lev_flag=1;
		}
		$br++;
	}		
}

//Ukoliko taj korisnik ne moze tu pristupati vraća ga se na glavni index.php u root direktoriju
if($lev_flag==0)
{
	print "<script>document.location.href='../index.html'</script>";
	exit(1);
}
?>