<?php
//ini_set('memory_limit', '512M');	
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$WebDir = "/home/holistic/webapp/gis_spread_split/MIRIP/";
$WebDirGisData = "/home/holistic/webapp/gis_data_holistic/";
$grassexecutable="/usr/local/grass/bin/grass64";	
$grasslocation="/home/holistic/HolisticMapset";
$meteoArhivaFolder="/home/holistic/meteoArhiva/";
$mapset="AdriaFireRisk";
$DefaultMapset="WebGis";
$staticFilename="staticMIRIP";
$dynamicFilename="dynamicMIRIP";
$midFilename="midMIRIP";
$MIRIPRulesFilename=$WebDir."rules_MIRIP";

/*****************************************************************/
/****************Informacije o LAYER-ima**************************/

//Corine
$corine = $WebDirGisData."clc_sve.shp";  		//Ovo treba vidjeti hoce li se koristiti
$corineAttributeName="kod";				      //Must be integer
$corineRulesFilename=$WebDir."rules_corine";

//Elevacija
//$elevacija = $WebDirGisData."el.tif";
$maxElHeightForMIRIP = 1000;							//In meters

/*Ovo više ne spada u static*/

//Ceste
$ceste = $WebDirGisData."/road.shp";
$cesteKoridor = 2000; 									//In meters
$cesteAttrName="jurisdicti";

//Objekti
$objekti = $WebDirGisData."/building.shp";
$objektiKoridor = 15000; 	
$objektiAttrName="jurisdicti";

//Voda
$voda = $WebDirGisData."/voda.shp";
$vodaAttrName="BORDER_WID";

//Dalekovodi
//http://www.overpass-api.de/api/xapi?node[bbox=13.3,42.1,19.2,46.6][power=*]
//Potrebno dodatno obraditi i izbrisati toèke u Zagrebu, itd...
$dalekovodi = $WebDirGisData."/transmission_line.shp";
$dalekovodiKoridor = 20000; 	
$dalekovodiAttrName="jurisdicti";

/*****************************************************************/



if(!file_exists($WebDir.$staticFilename.".sh"))
{
	touch($WebDir.$staticFilename.".sh");
	chmod($WebDir.$staticFilename.".sh", 0777);
}
if(!file_exists($WebDir.$staticFilename."_launch.sh"))
{
	touch($WebDir.$staticFilename."_launch.sh");
	chmod($WebDir.$staticFilename."_launch.sh", 0777);
}
if(!file_exists($WebDir.$dynamicFilename.".sh"))
{
	touch($WebDir.$dynamicFilename.".sh");
	chmod($WebDir.$dynamicFilename.".sh", 0777);
}
if(!file_exists($WebDir.$dynamicFilename."_launch.sh"))
{
	touch($WebDir.$dynamicFilename."_launch.sh");
	chmod($WebDir.$dynamicFilename."_launch.sh", 0777);
}


/*
	Generate static script
*/
function generateStaticScript ($WebDir, $grasslocation, $grassexecutable, $mapset, $DefaultMapset, $staticFilename, $corine, $corineAttributeName, $corineRulesFilename, $maxElHeightForMIRIP, $voda, $vodaAttrName) {

	$textForStatic="#!/bin/sh
	
#treba pripremit kopno pažljivo
#kopno pune rezolucije nije dobro ako je res=500+
#zbog toga se kreira kopno2 sa grow
#ovdje ispod je primjer kako se to radi
#i kopno i kopno2 bi trebali biti u default mapsetu

#g.region rast=kopno
#g.copy rast=kopno_bck_old,kopno --overwrite
#g.region rast=kopno res=400
#g.remove rast=kopno2,kopno.buf,kopno.grown
#r.mapcalc \"kopno2=if(kopno==0,null(),kopno)\"
#r.grow in=kopno2 out=kopno.grown radius=2 --overwrite
#g.remove rast=kopno2,kopno.buf
#g.copy rast=kopno.grown,kopno2 --overwrite
#g.region rast=w_dir
#r.mapcalc \"kopno2=if(isnull(kopno2),0,kopno2)\"


g.mapset mapset=$DefaultMapset
	
#Vodene povrsine
g.remove rast=voda
g.remove vect=voda
v.in.ogr dsn=$voda output=voda --overwrite
v.to.rast input=voda output=voda col='$vodaAttrName'
echo '0 green\n1 red\nend' | r.colors map=voda color=rules rules=-
r.null map=voda@WebGis null=0
g.region rast=voda@$DefaultMapset res=500;
r.out.tiff -t input=voda output=\"/home/holistic/webapp/gis_data_holistic/voda.tif\"
g.region rast=voda@$DefaultMapset res=100;
g.remove vect=voda

	
g.mapset mapset=$mapset
	
#Corine
g.remove rast=model
g.remove rast=model_temp
g.remove rast=Corine_raster
g.remove vect=Corine
#v.in.ogr dsn=$corine output=Corine --overwrite
g.copy vect=Corine_modelAlbini@$DefaultMapset,Corine --overwrite
g.region vect=Corine res=20
v.to.rast --verbose input=Corine output=Corine_raster use=attr column=$corineAttributeName
r.reclass input=Corine_raster output=model_temp rules=$corineRulesFilename
#Stavit gradove bar u 5
r.mapcalc \"model = if(isnull(model_temp), 5, model_temp)\"
g.remove rast=Corine_raster
g.remove vect=Corine
g.remove rast=model_temp
g.remove rast=Corine_raster
g.remove vect=Corine
g.remove rast=model_temp


#Elevacija, aspect, slope, kopno, elMIRIP, elMIRIP.max
g.region rast=el@$DefaultMapset
g.remove rast=elMIRIP
g.remove rast=elMIRIP.max
g.region rast=el@$DefaultMapset
r.mapcalc \"elMIRIP.max = if(el@$DefaultMapset>$maxElHeightForMIRIP,$maxElHeightForMIRIP,el@$DefaultMapset)\"
r.mapcalc \"elMIRIP.max = if(elMIRIP.max<0,0,elMIRIP.max)\"
r.rescale input=elMIRIP.max output=elMIRIP to=0,255 --overwrite
#r.mapcalc \"elMIRIP = abs(elMIRIP-255)*kopno@$DefaultMapset\"
r.mapcalc \"elMIRIP = abs(elMIRIP-255)\"
g.remove rast=elMIRIP.max

";


writeToFile($textForStatic, $staticFilename.".sh");

$textForStatic_launch="export GRASS_BATCH_JOB=$WebDir$staticFilename.sh
$grassexecutable -text $grasslocation/$mapset";

writeToFile($textForStatic_launch, $staticFilename."_launch.sh");

	

}






/*
	Generate static script
*/
function generateDynamicScript ($WebDir, $grasslocation, $grassexecutable, $mapset, $DefaultMapset, $dynamicFilename, $meteoArhivaFolder, $WebDirGisData, $ceste, $cesteKoridor, $cesteAttrName, $objekti, $objektiKoridor, $objektiAttrName, $dalekovodi, $dalekovodiKoridor, $dalekovodiAttrName, $MIRIPRulesFilename) {
	
	$resolutionHigh=100;
	$resolutionLow=500;

	$textForDynamic="#!/bin/sh
	
g.mapset mapset=$mapset

#Region ce biti w_dir1 jer je on najmanji


#Wind_dir
g.region  res=$resolutionHigh;
g.remove rast=w_dir1,w_dir_extended,new_wind_extended,windAspect
r.in.arc input=$meteoArhivaFolder/current/wind_dir.asc output=w_dir1 --overwrite
r.mapcalc w_dir_extended=\"-w_dir1+90\" 
r.mapcalc new_wind_extended=\"if(w_dir_extended>=359.99, w_dir_extended-360, w_dir_extended)\" 
g.region rast=w_dir1 res=$resolutionHigh;
#r.mapcalc windAspect.255 = \"if((cos((new_wind_extended-aspect@$DefaultMapset)/2))<0,255*abs((-cos((new_wind_extended-aspect@$DefaultMapset)/2))*kopno@$DefaultMapset),255*abs((cos((new_wind_extended-aspect@$DefaultMapset)/2)))*kopno@$DefaultMapset)\" 
r.mapcalc windAspect.255 = \"if((cos((new_wind_extended-aspect@$DefaultMapset)/2))<0,255*abs((-cos((new_wind_extended-aspect@$DefaultMapset)/2))),255*abs((cos((new_wind_extended-aspect@$DefaultMapset)/2))))\" 
r.rescale input=windAspect.255 output=windAspect2 to=0,255 --overwrite
r.mapcalc windAspect=\"windAspect2\"
r.null map=windAspect null=255
echo '0 green\n128 yellow\n255 red\nend' | r.colors map=windAspect color=rules rules=-
g.region rast=w_dir1 res=$resolutionLow;
r.out.tiff -t input=windAspect output=\"$WebDirGisData/windAspect.tif\"
g.region rast=w_dir1 res=$resolutionHigh;
g.remove rast=w_dir_extended,new_wind_extended,windAspect.255,windAspect2
g.remove rast=w_dir_extended,new_wind_extended,windAspect.255,windAspect2
g.remove rast=w_dir_extended,new_wind_extended,windAspect.255,windAspect2


#Wind_speed
g.remove rast=w_speed1
r.in.arc input=$meteoArhivaFolder/current/wind_speed.asc output=w_speed1 --overwrite
#r.mapcalc windSlope.255=\"((w_speed1*10)+(slope@$DefaultMapset*10))*kopno@$DefaultMapset\"
r.mapcalc windSlope.255=\"((w_speed1*10)+(slope@$DefaultMapset*10))\"
r.mapcalc windSlope=\"if(windSlope.255>255,255,windSlope.255)\"
r.null map=windSlope null=255
echo '0 green\n128 yellow\n255 red\nend' | r.colors map=windSlope color=rules rules=-
g.region rast=w_dir1 res=$resolutionLow;
r.out.tiff -t input=windSlope output=\"$WebDirGisData/windSlope.tif\"
g.region rast=w_dir1 res=$resolutionHigh;
g.remove rast=w_speed1,windSlope.255
g.remove rast=w_speed1,windSlope.255
g.remove rast=w_speed1,windSlope.255

#FWI
g.remove rast=fwi_1
#r.in.arc input=$meteoArhivaFolder/current/FWI.asc output=fwi_1 --overwrite
g.copy rast=FWI@$DefaultMapset,fwi_1 --overwrite
#Normalizacija do 255
r.mapcalc fwi_1=\"fwi_1*9\" 
r.null map=fwi_1 null=255
echo '0 50:150:235\n4.5 100:185:0\n10.5 255:190:55\n18.5 255:130:35\n29.5 235:60:45\nend' | r.colors map=fwi_1 color=rules rules=-
g.region rast=w_dir1 res=$resolutionLow;
r.out.tiff -t input=fwi_1 output=\"$WebDirGisData/fwi_1.tif\"
g.region rast=w_dir1 res=$resolutionHigh;


#Prec
g.remove rast=precTemp
r.in.arc input=/home/holistic/meteoArhiva//current/prec.asc output=precTemp --overwrite
r.null map=precTemp null=255
echo '0 0:161:230\n1 0:209:140\n5 0:220:0\n10 161:230:51\n15 230:220:51\n20 230:176:46\n25 240:130:41\n30 240:0:0\n100 255:0:0\nend' | r.colors map=precTemp color=rules rules=-
g.region rast=w_dir1 res=$resolutionLow;
r.out.tiff -t input=precTemp output=\"$WebDirGisData/prec.tif\"
g.region rast=w_dir1 res=$resolutionHigh;

#PrecModified
g.remove rast=precModified
r.in.arc input=/home/holistic/meteoArhiva//current/precModified.asc output=precModified --overwrite
r.null map=precModified null=255
#r.out.tiff -t input=precModified output=\"/home/holistic/webapp/gis_data_split//precModified.tif\"
echo '0 green\n128 yellow\n255 red\nend' | r.colors map=precModified color=rules rules=-
g.region rast=w_dir1 res=$resolutionLow;
r.out.tiff -t input=precModified output=\"$WebDirGisData/precModified.tif\"
g.region rast=w_dir1 res=$resolutionHigh;


#MIRIP
g.remove vect=MIRIP_vector
#r.mapcalc MIRIP=\"(0.399*fwi_1+0.097*elMIRIP+0.096*model+0.09*ObjektiMIRIP+0.089*windSlope+0.081*CesteMIRIP+0.075*windAspect+0.073*DalekovodiMIRIP)*kopno@$DefaultMapset*precModified\"
#r.mapcalc MIRIP=\"if(isnull(w_dir1),null(),if(MIRIP>255,255,MIRIP))\"

##Mala promjena da gradovi budu 0 a ne prozirni
##r.mapcalc MIRIP=\"(0.399*fwi_1+0.097*elMIRIP+0.096*model+0.09*ObjektiMIRIP+0.089*windSlope+0.081*CesteMIRIP+0.075*windAspect+0.073*DalekovodiMIRIP)*kopno@$DefaultMapset*precModified\"
#r.mapcalc MIRIP=\"(0.399*fwi_1+0.097*elMIRIP+0.096*model+0.09*ObjektiMIRIP+0.089*windSlope+0.081*CesteMIRIP+0.075*windAspect+0.073*DalekovodiMIRIP)*precModified\"
#r.mapcalc MIRIP=\"if(isnull(MIRIP),0,MIRIP)\"
##r.mapcalc MIRIP=\"if(isnull(w_dir1),null(),if(MIRIP>255,255,if(kopno@$DefaultMapset==0,null(),MIRIP)))\"
#g.region rast=w_dir1 res=$resolutionHigh;
##r.mapcalc MIRIP=\"if(isnull(w_dir1),null(),if(MIRIP>255,255,if(kopno@$DefaultMapset==0,null(),MIRIP)))\"
#r.mapcalc MIRIP=\"if(isnull(w_dir1),0,if(MIRIP>255,255,if(kopno@$DefaultMapset==0,0,MIRIP)))\"
#g.region rast=w_dir1 res=$resolutionHigh;





r.mapcalc MIRIP= \"(0.399*fwi_1+0.097*elMIRIP+0.096*model+0.09*ObjektiMIRIP+0.089*windSlope+0.081*CesteMIRIP+0.075*windAspect+0.073*DalekovodiMIRIP)*precModified\"
r.mapcalc MIRIP=\"if(isnull(MIRIP),0,MIRIP)\"
g.region rast=w_dir1 res=$resolutionHigh;
#r.mapcalc MIRIP=\"if(isnull(w_dir1),0,if(MIRIP>255,255,if(voda@$DefaultMapset==1,0,MIRIP)))\"
r.mapcalc MIRIP=\"if(voda@$DefaultMapset==1,0,MIRIP)\"
r.mapcalc MIRIP=\"if(MIRIP>255,255,MIRIP)\"
r.mapcalc MIRIP=\"if(isnull(w_dir1),0,MIRIP)\"
g.region rast=w_dir1 res=$resolutionHigh;


r.what input=fwi_1,elMIRIP,model,ObjektiMIRIP,windSlope,CesteMIRIP,windAspect,DalekovodiMIRIP,precModified,MIRIP east_north=1825741.945,5389473.435

echo '0 50:150:235\n64 100:185:0\n128 255:190:55\n192 255:130:35\n255 235:60:45\nend' | r.colors map=MIRIP color=rules rules=-
r.out.tiff -t input=MIRIP output=\"$WebDirGisData/MIRIP.tif\"
echo 'AdriaFireRisk geotif exported'
#Priprema i export MIRIP vektora
g.region rast=w_dir1 res=$resolutionLow
r.reclass input=MIRIP output=MIRIPreclassed rules=$MIRIPRulesFilename --overwrite
r.to.vect input=MIRIPreclassed output=MIRIP_vector feature=area --overwrite
#v.generalize input=MIRIP_preVector output=MIRIP_vector method=douglas threshold=20
v.out.ogr input=MIRIP_vector type=area dsn=$WebDirGisData olayer=MIRIP_vector layer=1 format=ESRI_Shapefile --overwrite
g.region rast=w_dir1 res=$resolutionHigh
g.remove rast=w_dir1
g.remove rast=windSlope
g.remove rast=windAspect
g.remove rast=fwi_1
g.remove rast=precModified
#g.remove rast=MIRIP
g.remove rast=windSlope
g.remove rast=windAspect
g.remove rast=fwi_1
g.remove rast=precModified
g.remove rast=MIRIPreclassed
g.remove vect=MIRIP_vector
g.remove vect=MIRIP_preVector

#wget -O - http://10.80.1.13/REST/importAdriaFireRiskData/5e4j8l22qlp9yy2n
python $WebDir/pythonNotifyRisk.py



";

writeToFile($textForDynamic, $dynamicFilename.".sh");

$textForDynamic_launch="export GRASS_BATCH_JOB=$WebDir$dynamicFilename.sh
$grassexecutable -text $grasslocation/$mapset
";

writeToFile($textForDynamic_launch, $dynamicFilename."_launch.sh");

}


function generateMidScript ($WebDir, $grasslocation, $grassexecutable, $mapset, $DefaultMapset, $midFilename, $meteoArhivaFolder, $WebDirGisData, $ceste, $cesteKoridor, $cesteAttrName, $objekti, $objektiKoridor, $objektiAttrName, $dalekovodi, $dalekovodiKoridor, $dalekovodiAttrName) {
	
	

	$textForMid="#!/bin/sh
	
g.mapset mapset=$mapset

g.region rast=FWI@$DefaultMapset res=100;


#Ceste
g.remove rast=Ceste,Ceste.buf,CesteMIRIP
g.remove vect=Ceste
v.in.ogr dsn=$ceste output=Ceste --overwrite
v.to.rast input=Ceste output=Ceste column=$cesteAttrName";
$corridorValues=generateCorridorValues($cesteKoridor, 255);
$textForMid.="
r.buffer input=Ceste output=Ceste.buf distances=$corridorValues
r.null map=Ceste.buf null=255   
#r.mapcalc \"CesteMIRIP = abs(Ceste.buf-255)*kopno@$DefaultMapset \" 
r.mapcalc \"CesteMIRIP = abs(Ceste.buf-255) \" 
echo '0 green\n128 yellow\n255 red\nend' | r.colors map=CesteMIRIP color=rules rules=-
g.region rast=FWI@$DefaultMapset res=500;
r.out.tiff -t input=CesteMIRIP output=\"$WebDirGisData/CesteMIRIP.tif\"
g.region rast=FWI@$DefaultMapset res=100;
g.remove rast=Ceste,Ceste.buf
g.remove vect=Ceste
g.remove rast=Ceste,Ceste.buf
g.remove vect=Ceste

#Objekti
g.remove rast=Objekti,Objekti.buf,ObjektiMIRIP
g.remove vect=Objekti
v.in.ogr dsn=$objekti output=Objekti --overwrite
v.to.rast input=Objekti output=Objekti column=$objektiAttrName";
$corridorValues=generateCorridorValues($objektiKoridor, 255);
$textForMid.="
r.buffer input=Objekti output=Objekti.buf distances=$corridorValues
r.null map=Objekti.buf null=255   
#r.mapcalc \"ObjektiMIRIP = abs(Objekti.buf-255)*kopno@$DefaultMapset \" 
r.mapcalc \"ObjektiMIRIP = abs(Objekti.buf-255) \" 
echo '0 green\n128 yellow\n255 red\nend' | r.colors map=ObjektiMIRIP color=rules rules=-
g.region rast=FWI@$DefaultMapset res=500;
r.out.tiff -t input=ObjektiMIRIP output=\"$WebDirGisData/ObjektiMIRIP.tif\"
g.region rast=FWI@$DefaultMapset res=100;
g.remove rast=Objekti,Objekti.buf
g.remove vect=Objekti
g.remove rast=Objekti,Objekti.buf
g.remove vect=Objekti

#Dalekovodi
g.remove rast=Dalekovodi,Dalekovodi.buf,DalekovodiMIRIP
g.remove vect=Dalekovodi
v.in.ogr dsn=$dalekovodi output=Dalekovodi --overwrite
v.to.rast input=Dalekovodi output=Dalekovodi column=$dalekovodiAttrName";
$corridorValues=generateCorridorValues($dalekovodiKoridor, 255);
$textForMid.="
r.buffer input=Dalekovodi output=Dalekovodi.buf distances=$corridorValues
r.null map=Dalekovodi.buf null=255   
#r.mapcalc \"DalekovodiMIRIP = abs(Dalekovodi.buf-255)*kopno@$DefaultMapset \" 
r.mapcalc \"DalekovodiMIRIP = abs(Dalekovodi.buf-255) \" 
echo '0 green\n128 yellow\n255 red\nend' | r.colors map=DalekovodiMIRIP color=rules rules=-
g.region rast=FWI@$DefaultMapset res=500;
r.out.tiff -t input=DalekovodiMIRIP output=\"$WebDirGisData/DalekovodiMIRIP.tif\"
g.region rast=FWI@$DefaultMapset res=100;
g.remove rast=Dalekovodi,Dalekovodi.buf
g.remove vect=Dalekovodi
g.remove rast=Dalekovodi,Dalekovodi.buf
g.remove vect=Dalekovodi


";

writeToFile($textForMid, $midFilename.".sh");


$textForMid_launch="export GRASS_BATCH_JOB=$WebDir$midFilename.sh
$grassexecutable -text $grasslocation/$mapset";

writeToFile($textForMid_launch, $midFilename."_launch.sh");

}
























/*
	Generiranje stringa koji 
*/
function generateCorridorValues($meters, $numberOfValues)
{
	$step = number_format(floatval($meters / $numberOfValues),2);
		
	$string="";
	for($i=1; $i<=$numberOfValues; $i++)
	{
		$string.= $step*$i.",";
	}
	
	return $string;

}

/*
	Function used to write string to a file
*/
function writeToFile($string, $filename)
{
	$fh = fopen($filename, 'w') or die("can't open file");
	fwrite($fh, $string);
	fclose($fh);
}


generateStaticScript ($WebDir, $grasslocation, $grassexecutable, $mapset, $DefaultMapset, $staticFilename, $corine, $corineAttributeName, $corineRulesFilename, $maxElHeightForMIRIP,$voda, $vodaAttrName);
echo "Scripts \"staticMIRIP.sh\" and \"staticMIRIP_launch.sh\" generated successfully! <br /><br />";

generateMidScript ($WebDir, $grasslocation, $grassexecutable, $mapset, $DefaultMapset, $midFilename, $meteoArhivaFolder, $WebDirGisData, $ceste, $cesteKoridor, $cesteAttrName, $objekti, $objektiKoridor, $objektiAttrName, $dalekovodi, $dalekovodiKoridor, $dalekovodiAttrName);
echo "Scripts \"midMIRIP.sh\" and \"midMIRIP_launch.sh\" generated successfully! <br /><br />";

generateDynamicScript ($WebDir, $grasslocation, $grassexecutable, $mapset, $DefaultMapset, $dynamicFilename, $meteoArhivaFolder, $WebDirGisData, $ceste, $cesteKoridor, $cesteAttrName, $objekti, $objektiKoridor, $objektiAttrName, $dalekovodi, $dalekovodiKoridor, $dalekovodiAttrName, $MIRIPRulesFilename);
echo "Scripts \"dynamicMIRIP.sh\" and \"dynamicMIRIP_launch.sh\" generated successfully! <br /><br />";

?>