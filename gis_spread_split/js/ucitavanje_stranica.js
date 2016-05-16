/**
* IPNAS - Integralni Protupožarni NAdzorni Sustav
* @ Copyright (C) 2006 Katedra za modeliranje i inteligentne računalne sustave, FESB Split
* @ All rights reserved
* @ Verzija 2.7 $Revision: 1.00 $
* @ Zadnja promjena 29.08.2012
**/

//Refresh funkcija timePeriod u msek npr za 5 sek treba biti 5000
function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}


// otvaranje stranica u framovima
//Upravljanje osnovna stranica
function upravljanje(){
window.parent.glavni.location.href= "glavni-osnovni.php";
window.parent.control.location.href= "control.php";
}

//Upravljanje po panorami
function panorama(){
window.parent.glavni.location.href= "glavni-panorama.php";
}
//Upravljanje po presetu
function preset(){
window.parent.glavni.location.href= "glavni-preset.php";
}
//Setup preset pozicija
function presetSetup(){
window.parent.glavni.location.href= "glavni-preset-setup.php";
window.parent.control.location.href= "control.php";
}
//Setup preset pozicija
function presetSetupNatrag(){
window.top.glavni.location.href= "glavni-preset-setup.php";
window.top.control.location.href= "control.php";
}
//Automatski rad - Detekcija parametri
function automatski(){
//window.parent.glavni.location.href= "glavni-automatski.php";
window.parent.glavni.location.href= "automatski-podesavanja.php";
}
//Automatski rad - Detekcija - nadzor kamera
function automatski2(){
window.parent.glavni.location.href= "glavni-automatski.php";

}
//Izrada thumbova preset pozicija - stavljena u file preset-setup.php
function ThumbCreation(){
window.top.glavni.location.href= "glavni-preset-setup-thumb.php";
}
//Automatska izrada preset pozicija - - stavljena u file preset-setup.php
function AutomaticPreset(){
window.top.glavni.location.href= "glavni-preset-setup-automatic.php";
}
/*
//Forsirano podizanje prozora s alarmima
function automatski-alarmi(){
window.parent.trash.location.href= "../admin_cvora/osnovni-alarm.php?za_ponisti=1";
}
*/
// Postavljanje alarmnih vrijednosti
function alarmi(){
window.parent.glavni.location.href= "meteo-alarmi.php";
}
//Reset prozor - ucitava se u donji dio glavnog
function reset(){
window.parent.glavni.location.href= "reset.php";
}

//Setup
function setup(){
window.parent.glavni.location.href= "glavni-setup.php";
window.parent.control.location.href= "control_setup.php";
}

//Setup
function izradaMaske(){
window.parent.glavni.location.href= "izrada-maske.php";
window.parent.control.location.href= "control_setup.php";
}

//Izrada maske iz fila preset-setup-automatski.php
function izradaMaske_2(){
window.top.glavni.location.href= "izrada-maske.php";
}

//Setup baza
function setupBaza(){

	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth < 1350){
	MyWindow = window.open('../admin/web_admin_system.php','setupBaze','width='+availWidth+',height='+availHeight+',left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}

else{
	MyWindow = window.open('../admin/web_admin_system.php','setupBaze','width=1350,height=1010,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
}

//Setup sensora
function setupSensors(){

	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth < 1350){
	MyWindow = window.open('../admin/web_admin_observer.php','setupBaze','width='+availWidth+',height='+availHeight+',left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}

else{
	MyWindow = window.open('../admin/web_admin_observer.php','setupBaze','width=1350,height=1010,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
}

//Setup regija
function setupRegion(){

	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth < 1350){
	MyWindow = window.open('../admin/web_admin_region.php','setupBaze','width='+availWidth+',height='+availHeight+',left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}

else{
	MyWindow = window.open('../admin/web_admin_region.php','setupBaze','width=1350,height=1010,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
}


//Setup IP adrese servera
function setupIPserver(){
window.parent.centralni.location.href= '../admin/network.php';
}

//Setup korisnika
function setupUsers(){
window.parent.centralni.location.href= '../admin_korisnika/svi_korisnici.php';
}

//Statistika alarma 25.11.2012.
function statisticsAlarms(){
availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth < 1350){
	MyWindow = window.open('../admin/web_alarm_statistics.php','setupBaze','width='+availWidth+',height='+availHeight+',left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}

else{
	MyWindow = window.open('../admin/web_alarm_statistics.php','setupBaze','width=1350,height=1010,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
}

//Setup bezicnih uredaja
function setupWireless(){
	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth < 1350){
	MyWindow = window.open('../admin/web_admin_system_wireless.php','setupBaze','width='+availWidth+',height='+availHeight+',left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}

else{
	MyWindow = window.open('../admin/web_admin_system_wireless.php','setupBaze','width=1350,height=1010,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
}

//Setup korisnika
function setupJezik(){
window.parent.centralni.location.href= '../IForestFireTranslator/index.php';
}

//Test linkova uvodna
function LinkTest(){
window.parent.centralniControl.location.href= "ping_test.php";
}

//Test linkova natrag na centralni control
function LinkTestNatrag(){
window.parent.centralniControl.location.href= "centralni-control.php";
}
//Test linkova
function LinkTest2(){
window.parent.centralniControl.location.href= "ping_test_2.php";
}

//Test linkova detaljni
function LinkTestDetaljno(naziv,adresa){
window.parent.centralni.location.href= "ping_test_3.php?naziv="+naziv+"&adresa="+adresa;
}

//Reset agenata
function AgentiReset(){
window.parent.trashCentralni.location.href= "reset_agenta.php";
}

//4ekrana otvaranje iz prozora otvorene kamere u slucaju da je netko zatvorio
function quad(){
	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora/index22-4ekrana.php','centralniArhiva','width='+availWidth+',height='+availHeight+',left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}

else{
	MyWindow = window.open('../admin_cvora/index22-4ekrana.php','centralniArhiva','width=1270,height=1010,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
}

//Arhiva otvaranje iz prozora otvorene kamere u slucaju da je netko zatvorio
function arhiva(i){
	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora/index22-video.php?kamera='+i+'','centralniArhiva','width='+availWidth+',height='+availHeight+',left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}

else{
	MyWindow = window.open('../admin_cvora/index22-video.php?kamera='+i+'','centralniArhiva','width=1270,height=1010,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
}

//Arhiva meteo otvaranje iz prozora otvorene kamere u slucaju da je netko zatvorio
function arhivaMeteo(i){
	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora/index22-meteo.php?kamera='+i+'','centralniArhiva','width='+availWidth+',height='+availHeight+',left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}

else{
	MyWindow = window.open('../admin_cvora/index22-meteo.php?kamera='+i+'','centralniArhiva','width=1270,height=1010,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
}

//Otvaranje trenutnih meteo vrijednosti u slucaju da je netko zatvorio
function meteo(i){
MyWindow = window.open("../arhiva_meteo_"+i+"/trenutni_meteo_close.php","trenMeteo","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=810, height=1000");
}

//Otvaranje kamera
function kamera(i){
	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth > 2*availHeight){
	leftLoc=availWidth/2+5;	
	MyWindow = window.open('../admin_cvora_'+i+'/index1.php','upravljanje','width=1100,height=970,left='+leftLoc+',top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();
 }
 else if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora_'+i+'/index1.php','upravljanje','width=1000,height=700,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
else{
	MyWindow = window.open('../admin_cvora_'+i+'/index1.php','upravljanje','width=1100,height=970,left=50,top=10,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();
	}
}

//Otvaranje kamera pomocni 28.08.2012.
function kamera_focus(i){
	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth > 2*availHeight){
	leftLoc=availWidth/2+5;	
	MyWindow = window.open('../admin_cvora_'+i+'/index1.php','upravljanje','width=1100,height=970,left='+leftLoc+',top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
 }
 else if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora_'+i+'/index1.php','upravljanje','width=1000,height=700,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	}
else{
	MyWindow = window.open('../admin_cvora_'+i+'/index1.php','upravljanje','width=1100,height=970,left=50,top=10,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	}
}

//Otvaranje kamera u preset modu
function kameraPreset(i){
	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth > 2*availHeight){
	leftLoc=availWidth/2+5;	
	MyWindow = window.open('../admin_cvora_'+i+'/index1-preset.php','upravljanje','width=1100,height=970,left='+leftLoc+',top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();
 }
 else if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora_'+i+'/index1-preset.php','upravljanje','width=1000,height=700,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
else{
	MyWindow = window.open('../admin_cvora_'+i+'/index1-preset.php','upravljanje','width=1100,height=970,left=50,top=10,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();
	}
}
//Otvaranje kamera za offline u glavnom prozoru
function offline(){
window.parent.centralni.location.href= '../virtual_vatra/offline_detect.php';
}
//Otvaranje kamera u glavnom prozoru
function kameraG(i){
window.parent.centralni.location.href= '../admin_cvora_'+i+'/glavni-osnovni-central.php';
}
//Otvaranje prozora detekcije kamere u glavnom prozoru
function kamera4(i){
window.parent.centralni.location.href= '../admin_cvora/glavni-1-1234.php?kamera='+i;
}
//Otvaranje kamera u glavnom prozoru samo za gledanje
function kameraGSEE(i){
window.parent.centralni.location.href= '../see_cvora_'+i+'/glavni.php';
}
//Otvaranje vise kamera u glavnom prozoru samo za gledanje
function quadOpenSEE(){
window.parent.centralni.location.href= '../see_cvora/glavni1234.php'; 
}
//Otvaranje zemljovida s lokacijama u glavnom prozoru samo za gledanje
function katraSEE(){
window.parent.centralni.location.href= '../gis/gis.php'; 
}
//Otvaranje kamera u glavnom prozoru samo za gledanje
function kameraGSEEmapa(i){
window.top.centralni.location.href= '../see_cvora_'+i+'/glavni.php';
}
function kameraGSEEmapaOstale(id,idMeteo){
	window.top.centralni.location.href= '../see_cvora/glavniOstale.php?id='+id+'&idM='+idMeteo+'';
	}
//Otvaranje vise kamera u glavnom prozoru
function quadOpen(){
window.top.location.href= '../admin_cvora/index22.php'; 
}
//Otvaranje ulazne slike sa vise kamera u glavnom prozoru
function quadUlaznaOpen(){
window.parent.centralni.location.href= '../admin_cvora/glavni1234-ulazna.php'; 
}

//Otvaranje trenutnih alama sa vise kamera u glavnom prozoru
function quadAlarmOpen(){
window.parent.centralni.location.href= '../admin_cvora/glavni1234-alarm.php'; 
}
//Otvaranje zadnjih neponištenih alama iz arhive sa vise kamera u glavnom prozoru
function quadAlarmArchivaOpen(){
window.parent.centralni.location.href= '../admin_cvora/glavni1234-alarm-arhiva-zadnji.php'; 
}
//Otvaranje svih zadnjih alama iz arhive sa vise kamera u glavnom prozoru
function quadAlarmArchivaOpenSvi(){
window.parent.centralni.location.href= '../admin_cvora/glavni1234-alarm-arhiva-zadnji-svi.php'; 
}
//Otvaranje zadnjih alama iz arhive sa vise kamera u glavnom prozoru
function quadAlarmArchivaOpen_popis(){
window.parent.centralni.location.href= '../admin_cvora/glavni1234-alarm-arhiva_ispis.php'; 
}
//Otvaranje zadnjih alama iz arhive sa vise kamera u novom prozoru
function quadAlarmArchivaOpen_popis_zatvori(){
availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth > 2*availHeight){
	leftLoc=availWidth/2+5;	
	MyWindow = window.open('../admin_cvora/glavni1234-alarm-arhiva_ispis_zatvori.php','alarmi','width=1270,height=850,left='+leftLoc+',top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	}
 else if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora/glavni1234-alarm-arhiva_ispis_zatvori.php','alarmi','width=1270,height=850,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	}
else{
	MyWindow = window.open('../admin_cvora/glavni1234-alarm-arhiva_ispis_zatvori.php','alarmi','width=1270,height=850,left=50,top=10,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	}
	MyWindow.outerWidth="1286";
	MyWindow.outerHeight="935";
	MyWindow.focus();

}
//Otvaranje zadnjih alama iz arhive samo za jednu kameru i svih 8 preset pozicija u novom prozoru
function oneAlarmArchivaOpen_popis_zatvori(cam){
availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth > 2*availHeight){
	leftLoc=availWidth/2+5;	
	MyWindow = window.open('../admin_cvora_'+cam+'/glavni-one-alarm-arhiva_ispis_zatvori.php','alarmi','width=1270,height=850,left='+leftLoc+',top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	}
 else if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora_'+cam+'/glavni-one-alarm-arhiva_ispis_zatvori.php','alarmi','width=1270,height=850,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');

	}
else{
	MyWindow = window.open('../admin_cvora_'+cam+'/glavni-one-alarm-arhiva_ispis_zatvori.php','alarmi','width=1270,height=850,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	}

	MyWindow.outerWidth="1286";
	MyWindow.outerHeight="935";
	MyWindow.focus();

}
//Otvaranje zadnjih alama iz arhive samo za jednu kameru i svih 8 preset pozicija u novom prozoru
function oneAlarmArchivaOpen_popis_zatvori_2(cam){
availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth > 2*availHeight){
	leftLoc=availWidth/2+5;	
	MyWindow = window.open('../admin_cvora_'+cam+'/glavni-one-alarm-arhiva_ispis_zatvori_2.php','alarmi2','width=1270,height=850,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	}
 else if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora_'+cam+'/glavni-one-alarm-arhiva_ispis_zatvori_2.php','alarmi2','width=1270,height=850,left=10,top=10,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');

	}
else{
	MyWindow = window.open('../admin_cvora_'+cam+'/glavni-one-alarm-arhiva_ispis_zatvori_2.php','alarmi2','width=1270,height=850,left=10,top=10,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	}

	MyWindow.outerWidth="1286";
	MyWindow.outerHeight="935";
	MyWindow.focus();

}
//Otvaranje svih kamera lokalnog podrucja
function kamereLokalnoPodrucje(){
	window.parent.centralni_donji.location.href= '../admin_cvora/glavni1234.php'; 
	}
//Otvaranje svih kamera cijele regije
function kamereCijeloPodrucje(){
//Ovo je standardno npr. za Istru
//window.parent.centralni_donji.location.href= '../see_cvora/glavni1234-mapa.php';
//Ovo je za demo sustav s jednom kamerom bez položaja lokacija
//window.parent.location.href= '../gis/gis.php'; 
window.parent.centralni_donji.location.href= '../admin_cvora/glavni1234-gis.php'; 
}
//Otvaranje arhivu video - trakasti prikaz 
function trakaKamera(i){
window.parent.centralni.location.href= '../arhiva_video_'+i+'/arhiva-traka-kamera.php';
}
//Otvaranje arhivu video - trakasti prikaz u novom prozoru
function trakaKameraProzor(i){
availHeight = screen.availHeight;
availWidth=screen.availWidth;
if (availWidth > 2*availHeight){
	leftLoc=availWidth/2+5;	
	MyWindow = window.open('../arhiva_video_'+i+'/arhiva-traka-kamera_close.php','arhiva','width=950, height=980,left='+leftLoc+',top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();;
 }
 else if (availWidth < 1100){
	MyWindow = window.open('../arhiva_video_'+i+'/arhiva-traka-kamera_close.php','arhiva','width=950, height=980,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();;
	}
else{
	MyWindow = window.open('../arhiva_video_'+i+'/arhiva-traka-kamera_close.php','arhiva','width=950, height=980,left=50,top=10,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();;
	}}
//Otvaranje arhivu video - film prikaz 
function filmKamera(i){
window.parent.centralni.location.href= '../arhiva_video_'+i+'/arhiva-film-kamera.php';
}
//Otvaranje arhivu video - film prikaz u novom prozoru
function filmKameraProzor(i){
availHeight = screen.availHeight;
availWidth=screen.availWidth;
if (availWidth > 2*availHeight){
	leftLoc=availWidth/2+5;	
	MyWindow = window.open('../arhiva_video_'+i+'/film-kamera_close.php','arhiva','width=950, height=820,left='+leftLoc+',top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();;
 }
 else if (availWidth < 1100){
	MyWindow = window.open('../arhiva_video_'+i+'/film-kamera_close.php','arhiva','width=950, height=820,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();;
	}
else{
	MyWindow = window.open('../arhiva_video_'+i+'/film-kamera_close.php','arhiva','width=950, height=820,left=50,top=10,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();;
	}}
//Otvaranje arhivu video - ispis alarma
function ispisKamera(i){
window.parent.centralni.location.href= '../arhiva_video_'+i+'/ispis-kamera.php';
}
//Otvaranje arhivu video - ispis alarma u novom prozoru
function ispisKameraProzor(i){
availHeight = screen.availHeight;
availWidth=screen.availWidth;
if (availWidth > 2*availHeight){
	leftLoc=availWidth/2+5;	
	MyWindow = window.open('../arhiva_video_'+i+'/ispis-kamera_close.php','arhiva','width=950, height=920,left='+leftLoc+',top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();;
 }
 else if (availWidth < 1100){
	MyWindow = window.open('../arhiva_video_'+i+'/ispis-kamera_close.php','arhiva','width=950, height=920,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();;
	}
else{
	MyWindow = window.open('../arhiva_video_'+i+'/ispis-kamera_close.php','arhiva','width=950, height=920,left=50,top=10,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();;
	}}
//Otvaranje trenutnih vrijednosti meteorolskih podataka u osnovnom prozoru
function MeteoTrenutne(i) {
window.parent.centralni.location.href= "../arhiva_meteo_"+i+"/trenutni_meteo.php";
}
//Otvaranje trenutnih vrijednosti meteorloskih podataka u novom prozoru
function MeteoTrenutneProzor(i) {
//window.parent.centralni.location.href= "../arhiva_meteo_"+i+"/trenutni_meteo.php";
availHeight = screen.availHeight;
availWidth=screen.availWidth;
if (availWidth > 2*availHeight){
	leftLoc=availWidth/2+5;	
	MyWindow = window.open('../arhiva_meteo_'+i+'/trenutni_meteo_close.php','meteoprozor','width=820, height=720,left='+leftLoc+',top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();;
 }
 else if (availWidth < 1100){
	MyWindow = window.open('../arhiva_meteo_'+i+'/trenutni_meteo_close.php','meteoprozor','width=820, height=720,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();;
	}
else{
	MyWindow = window.open('../arhiva_meteo_'+i+'/trenutni_meteo_close.php','meteoprozor','width=850, height=720,left=50,top=10,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=no');
	MyWindow.focus();;
	}
}
//Otvaranje arhivu meteo u glavnom prozoru - zadnja 24 sata - prikaz svih veličina - meteo stanica i
function arhivaMeteo24(i,per){
window.parent.centralni.location.href= "../arhiva_meteo_"+i+"/arhiva_meteo_period.php?period="+per;
}
//Otvaranje meteo 24 sata u svom prozoru sa zatvori botunom - meteo stanica i 
function arhivaMeteo24Close(i,per){
MyWindow = window.open("../arhiva_meteo_"+i+"/arhiva_meteo_period.php?close=1&period="+per+"","meteo24sata","toolbar=no, width=950, height=970, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no");
MyWindow.focus();
	}
//Otvaranje arhivu meteo u glavnom prozoru samo za see_cvora - zadnja 24 sata - prikaz svih veličina - meteo stanica 
function arhivaMeteo24SEE(i,per){
window.top.centralni.location.href= "../arhiva_meteo_"+i+"/arhiva_meteo_period.php?period="+per;
}
//Otvaranje arhivu meteo u glavnom prozoru - izbor po datumu i veličinama - meteo stanica i
function arhivaMeteoDatum(i){
window.parent.centralni.location.href= "../arhiva_meteo_"+i+"/meteo-graf.php";
}
//Otvaranje arhivu meteo u glavnom prozoru - izbor po datumu i veličinama - meteo stanica i -u novom prozoru
function arhivaMeteoDatumProzor(i){
MyWindow = window.open("../arhiva_meteo_"+i+"/meteo-graf.php?close=1","meteo24sata","width=950, height=970, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no");
MyWindow.focus();
}

//Otvaranje meteo 24 sata u osnovnomprozoru - meteo stanica i - deaktivirano i prebačeno u novi prozor
/*function meteo24sata(i,per){

	availHeight = screen.availHeight;
	availWidth=screen.availWidth;

if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora/index22.php','centralniArhiva','width='+availWidth+',height='+availHeight+',left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}

else{
	MyWindow = window.open('../admin_cvora/index22.php','centralniArhiva','width=1270,height=1010,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	window.parent.centralni.location.href= "../arhiva_meteo_"+i+"/arhiva_meteo_period_close.php?period="+per;
	}

}*/

//Otvaranje slike uz ispis alarma
function otvoriSliku(url){
MyWindow = window.open(url,"slika_alarma","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width=970, height=900");
	MyWindow.focus();}

//GIS otvaranje u glavnom prozoru 2D
function gisOpen(){
	window.parent.centralni.location.href= "../gis/gis.php";
}

//GIS otvaranje u glavnom prozoru Meteo slojevi
function gisOpenMeteo(){
	window.parent.centralni.location.href= "../gis/gis1.php";
}

//GIS otvaranje u glavnom prozoru 3D
function gisOpen3D(){
	window.parent.centralni.location.href= "../gis_earth/gis_3d.php";
}

//GIS otvaranje u novom prozoru 2D
function gisOpenProzor(){
	MyWindow = window.open("../gis/gis.php","GISprozor","toolbar=no, width=950, height=930, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no");
MyWindow.focus();
	}

//GIS otvaranje u novom prozoru Meteo slojevi
function gisOpenMeteoProzor(){
	MyWindow = window.open("../gis/gis1.php","GISprozor","toolbar=no, width=950, height=930, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no");
MyWindow.focus();
}

//GIS otvaranje u novom prozoru 3D
function gisOpen3DProzor(){
	MyWindow = window.open("../gis_earth/gis_3d.php","GISprozor","toolbar=no, width=950, height=930, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no");
MyWindow.focus();
}

//GIS otvaranje u glavnom prozoru Edit
function gisEdit(){
	window.parent.centralni.location.href= "../gis/insert_newLayer.php";
}

//GIS otvaranje iz prozora kamere
function gisControl(){
	availHeight = screen.availHeight;
	availWidth=screen.availWidth;
if (availWidth < 1100){
	MyWindow = window.open('../admin_cvora/index22-gis.php','centralniArhiva','width='+availWidth+',height='+availHeight+',left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
else{
	MyWindow = window.open('../admin_cvora/index22-gis.php','centralniArhiva','width=1270,height=1010,left=0,top=0,status=no,titlebar=no,toolbar=no,location=no,directories=no,menubar=no,copyhistory=no,scrollbars=yes,resizable=yes');
	MyWindow.focus();
	}
}
//Upravljenje kamerom preko obicne mape
function gisControl1(){
window.parent.mapa.location.href= "mapa.php";
}
//Upravljenje kamerom preko Google mape
function gisControl2(){
window.parent.mapa.location.href= "mapa-gis.php";
}

//Satelit
function satelit(){
window.parent.centralni.location.href= "../gis/satelit.php";
}
//Upravljanje preko mape
function mapa(){
window.parent.glavni.location.href= "glavni-osnovni.php";
window.parent.control.location.href= "control.php";
window.parent.mapa.location.href= "mapa.php";
}
//Info
function info(){
MyWindow = window.open("../info.php","info","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width=400, height=400");
MyWindow.focus();
}

//Video - snimanje video sekvence
function video_snimanje(i){
window.parent.audio.location.href= "../admin_cvora_"+i+"/video.php";
}

//Video - snimanje video sekvence frame po frame
function video_frames(i){
window.parent.audio.location.href= "../admin_cvora_"+i+"/video_frames.php";
}

//Audio - Glasovna komunikacija 
function audio(i){
window.parent.audio.location.href= "../admin_cvora_"+i+"/audio.php";
}


//Setup video Web posluzitelja
function video(natpis){
	alert(natpis);
	MyWindow = window.open(BaseURL +"/operator/basic.shtml", "_blank","toolbar=yes, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width=720, height=500");
	MyWindow.focus();
	}
//Setup data Web posluzitelja

function data(natpis){
	alert(natpis);
	MyWindow = window.open('../admin_cvora_1/glavni-setup-data.php', "_blank","toolbar=yes, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width=840, height=700");
	MyWindow.focus();
	}
/*
function data(natpis){
	alert(natpis);
	MyWindow = window.parent.glavni.location.href= "glavni-setup-data.php";
	MyWindow.focus();
	}
	*/
function data2(natpis){
	alert(natpis);
	MyWindow = window.parent.glavni.location.href= "glavni-setup-data2.php";
	MyWindow.focus();
	}


// Help filovi
//Help upravljanje
function helpMain(){
MyWindow = window.open("../help/help-main.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
//Help upravljanje
function helpUpravljanje(){
MyWindow = window.open("../help/help-upravljanje.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
//Help setup
function helpSetup(){
MyWindow = window.open("../help/help-setup.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
function helpSetupMaska(){
MyWindow = window.open("../help/help-setup.php#maska","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
function helpSetupPreset(){
MyWindow = window.open("../help/help-setup.php#preset","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
function helpSetup2(){
MyWindow = window.open("../help/help-setup2.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
function helpSetup3(){
MyWindow = window.open("../help/help-setup3.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
//Help automatski
function helpAutomatski(){ //za 1 kameru sa upravljenjem i detekcijom pozara
MyWindow = window.open("../help/help-automatski.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
function helpAutomatskiKratki(){ //za 1 kameru sa upravljenjem i detekcijom pozara
MyWindow = window.open("../help/help-automatski-kratki.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
function helpAlarmi(){ //Prozor u kojem se prikazuju alarmi
MyWindow = window.open("../help/help-alarmi.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
//Help automatski
function helpAutomatski(){ //za 1 kameru sa upravljenjem i detekcijom pozara
MyWindow = window.open("../help/help-automatski.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
//Help arhiva meteo
function helpArhivameteo(){
MyWindow = window.open("../help/help-arhiva-meteo.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
//trenutno se nigdje na poziva pa je izbrisana stranica help-arhiva-meteo2.php i zakomenitrana funkcija
/*
function helpArhivameteo2(){
MyWindow = window.open("../help/help-arhiva-meteo2.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}*/

//Help arhiva video
function helpArhivavideo(){
MyWindow = window.open("../help/help-arhiva-video.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
function helpArhivavideo2(){
MyWindow = window.open("../help/help-arhiva-video2.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
//Help obrada slike
function helpObradaslike(){
MyWindow = window.open("../help/help-arhiva-obradaslike.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
//Help Corine
function helpCorine(){
MyWindow = window.open("./corine.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
//Help GIS
function helpGIS(){
MyWindow = window.open("../help/help-gis.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=800, height=800");
MyWindow.focus();
}
//Help Prostorni plam
//ovaj help je za paklenica, trenutno se nigdje na poziva pa je izbrisana stranica help-gis-prostorni.php i zakomenitrana funkcija
/*function helpGis(){
MyWindow = window.open("../help/help-gis-prostorni.php","help","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=900, height=800");
MyWindow.focus();
}*/


function kameraMaska(kamera, preset)
{
	window.location.href = "../izrada_maske/selekcija.php?id_kamera="+kamera+"&id_logic_camera="+preset;
}
