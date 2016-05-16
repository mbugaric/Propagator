<?
# Ime root direktorija web servera
$web_dir = $_SERVER['DOCUMENT_ROOT'];
# Ako slucajno nije postavljen staviti defaultni /home/holistic/webapp
if(!$web_dir)
	$web_dir = "/home/holistic/webapp";
	
// Datoteka koja sadrži izabrani jezik
$currentLanguage = "ENG";

# File koji sadrži postavke jezika
include_once ($web_dir."/gis_spread_split/languages/".$currentLanguage.".php");
?>