<?php
session_start();
include_once("../db_functions.php");
include_once("../postavke_dir_gis.php");

//Samo ukoliko je user uspješno logiran
if($korisnik!="" && $editableLanguage!="NUL") {
	require_once ("code/MainPage/MainPageView.php");
	
	$mainPageView = new MainPageView();
	echo ($mainPageView->ShowAll());
	}
	else {
	echo '<center><h2>AdriaFirePropagator</h2>'._NATPIS_NO_LOGIN.'</center>';
	}
?>
