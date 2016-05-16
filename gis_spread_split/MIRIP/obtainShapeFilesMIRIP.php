<?php

	$server="http://10.80.1.13/";
	$WebDirGisData = "/home/holistic/webapp/gis_data_holistic/";
	$prjFile="/home/holistic/meteoArhiva/epsg900913.prj";
	$dalekovodi = $WebDirGisData."Dalekovodi.shp";
	$ceste = $WebDirGisData."Ceste.shp";
	$objekti = $WebDirGisData."Objekti.shp";
	$downloadDir="/home/holistic/webapp/gis_data_holistic/_download/";
	
	if(!is_dir($downloadDir))
	{
		mkdir($downloadDir, 0777);
		chmod($downloadDir, 0777);
	}
	
	
	
	//Izbrisi stare fajlove
	unlink("$downloadDir/transmission_line.zip");
	//unlink("$downloadDir/fwi_data_points.zip");
	unlink($WebDirGisData."/transmission_line.shp");
	unlink($WebDirGisData."/transmission_line.shx");
	unlink($WebDirGisData."/transmission_line.dbf");
	unlink($WebDirGisData."/transmission_line.prj");
	unlink($WebDirGisData."/road.shp");
	unlink($WebDirGisData."/road.shx");
	unlink($WebDirGisData."/road.dbf");
	unlink($WebDirGisData."/road.prj");	
	unlink($WebDirGisData."/building.shp");
	unlink($WebDirGisData."/building.shx");
	unlink($WebDirGisData."/building.dbf");
	unlink($WebDirGisData."/building.prj");
	
	$serverWfs=$server."wfs";
	$urlTransmission =   "$serverWfs?SERVICE=wfs&VERSION=1.0.0&REQUEST=GetFeature&TYPENAME=holistic:transmission_line&srsName=epsg:3857&OUTPUTFORMAT=shape-zip";
	$urlCeste =   "$serverWfs?SERVICE=wfs&VERSION=1.0.0&REQUEST=GetFeature&TYPENAME=holistic:road&srsName=epsg:3857&OUTPUTFORMAT=shape-zip";
	$urlObjekti =   "$serverWfs?SERVICE=wfs&VERSION=1.0.0&REQUEST=GetFeature&TYPENAME=holistic:building&srsName=epsg:3857&OUTPUTFORMAT=shape-zip";
	
	exec("wget -O \"$downloadDir/transmission_line.zip\" \"$urlTransmission\"");
	exec("wget -O \"$downloadDir/road.zip\" \"$urlCeste\"");
	exec("wget -O \"$downloadDir/building.zip\" \"$urlObjekti\"");
	
	$zip = new ZipArchive;
	if ($zip->open("$downloadDir/transmission_line.zip") === TRUE) {
		$zip->extractTo($WebDirGisData."/");
		$zip->close();
		//echo 'ok';
	} else {
		//echo 'failed';
	}
	if ($zip->open("$downloadDir/road.zip") === TRUE) {
		$zip->extractTo($WebDirGisData."/");
		$zip->close();
		//echo 'ok';
	} else {
		//echo 'failed';
	}
	if ($zip->open("$downloadDir/building.zip") === TRUE) {
		$zip->extractTo($WebDirGisData."/");
		$zip->close();
		//echo 'ok';
	} else {
		//echo 'failed';
	}
	
	copy($prjFile, $WebDirGisData."/transmission_line.prj");
	copy($prjFile, $WebDirGisData."/road.prj");
	copy($prjFile, $WebDirGisData."/building.prj");



?>