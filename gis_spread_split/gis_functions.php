<?php

require("postavke_dir_gis.php");
require("setgetFile.php");

function full_copy( $source, $target )
    {
		?><div style="position: absolute; top: 1300px;">
<?php


        if ( is_dir( $source ) )
        {
            @mkdir( $target );
           
            $d = dir( $source );
           
            while ( FALSE !== ( $entry = $d->read() ) )
            {
                if ( $entry == '.' || $entry == '..' )
                {
                    continue;
                }
               
                $Entry = $source . '/' . $entry;           
                if ( is_dir( $Entry ) )
                {
                    full_copy( $Entry, $target . '/' . $entry );
                    continue;
                }
                copy( $Entry, $target . '/' . $entry );
            }
           
            $d->close();
        }else
        {
            copy( $source, $target );
        }
		?>
</div>
<?php
	}

//new function that has to be called each time if grassexecutable has been changed
function prepareLaunchUserData($WebDir, $WebDirGisData, $korisnik, $grasslocation, $mapset, $map_file_user, $map_file_userdefault, $WebDir_gisrc, $grassexecutable)
{
	
	//if(!file_exists($WebDir."/user_files/$korisnik/temp_launch.sh"))
	{
		copy($WebDir."/userdefault/temp_launch.sh", $WebDir."/user_files/$korisnik/temp_launch.sh");
		chmod($WebDir."/user_files/$korisnik/temp_launch.sh", 0777);
	}
		setIntoFile ($WebDir."/user_files/$korisnik/temp_launch.sh", "WEBDIRSPREAD", "$WebDir");
		setIntoFile ($WebDir."/user_files/$korisnik/temp_launch.sh", "GRASSEXECUTABLE", $grassexecutable);
		
	setIntoFile ($WebDir."/user_files/$korisnik/temp_launch.sh", 
	"KORISNIK", "$korisnik");
	setIntoFile ($WebDir."/user_files/$korisnik/temp_launch.sh", 
	"GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/temp_launch.sh", 
	"MAPSET", "$mapset");	
	
	
	//if(!file_exists($WebDir."/user_files/$korisnik/temp2_launch.sh"))
	{
		copy($WebDir."/userdefault/temp2_launch.sh", $WebDir."/user_files/$korisnik/temp2_launch.sh");
		chmod($WebDir."/user_files/$korisnik/temp2_launch.sh", 0777);
	}
		setIntoFile ($WebDir."/user_files/$korisnik/temp2_launch.sh", "WEBDIRSPREAD", "$WebDir");
		setIntoFile ($WebDir."/user_files/$korisnik/temp2_launch.sh", "GRASSEXECUTABLE", $grassexecutable);
		
	setIntoFile ($WebDir."/user_files/$korisnik/temp2_launch.sh", 
	"KORISNIK", "$korisnik");
	setIntoFile ($WebDir."/user_files/$korisnik/temp2_launch.sh", 
	"GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/temp2_launch.sh", 
	"MAPSET", "$korisnik");	
	
	
	//if(!file_exists($WebDir."/user_files/$korisnik/realtime_launch.sh"))
	{
		copy($WebDir."/userdefault/realtime_launch.sh", $WebDir."/user_files/$korisnik/realtime_launch.sh");
		chmod($WebDir."/user_files/$korisnik/realtime_launch.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/realtime_launch.sh", "WEBDIRSPREAD", "$WebDir");	
	
	setIntoFile ($WebDir."/user_files/$korisnik/realtime_launch.sh", 
	"GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/realtime_launch.sh", 
	"KORISNIK", "$korisnik");
	setIntoFile ($WebDir."/user_files/$korisnik/realtime_launch.sh", 
	"GRASSEXECUTABLE", $grassexecutable);
	
	
	//if(!file_exists($WebDir."/user_files/$korisnik/launch_wind.sh"))
	{
		copy($WebDir."/userdefault/launch_wind.sh", $WebDir."/user_files/$korisnik/launch_wind.sh");
		chmod($WebDir."/user_files/$korisnik/launch_wind.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind.sh", "KORISNIK",$korisnik); 
	//setIntoFile ($WebDir."/user_files/$korisnik/launch_wind.sh", "KORISNIK","admin"); //ovo bi trebalo dovest u red jednom 
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind.sh", "WEBDIRSPREAD", "$WebDir");
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind.sh", "GRASSLOCATION", $grasslocation);
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind.sh", "GRASSEXECUTABLE", $grassexecutable);
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind.sh", "GRASSLOCATION", "$grasslocation");
	
	//if(!file_exists($WebDir."/user_files/$korisnik/launch_wind.sh"))	
	{
		copy($WebDir."/userdefault/launch_wind_2.sh", $WebDir."/user_files/$korisnik/launch_wind_2.sh");
		chmod($WebDir."/user_files/$korisnik/launch_wind_2.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind_2.sh", "KORISNIK",$korisnik); 
	//setIntoFile ($WebDir."/user_files/$korisnik/launch_wind.sh", "KORISNIK","admin"); //ovo bi trebalo dovest u red jednom 
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind_2.sh", "WEBDIRSPREAD", "$WebDir");
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind_2.sh", "GRASSLOCATION", $grasslocation);
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind_2.sh", "GRASSEXECUTABLE", $grassexecutable);
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind_2.sh", "GRASSLOCATION", "$grasslocation");
	
	//if(!file_exists($WebDir."/user_files/$korisnik/launch_wind.sh"))	
	{
		copy($WebDir."/userdefault/launch_wind_3.sh", $WebDir."/user_files/$korisnik/launch_wind_3.sh");
		chmod($WebDir."/user_files/$korisnik/launch_wind_3.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind_3.sh", "KORISNIK",$korisnik); 
	//setIntoFile ($WebDir."/user_files/$korisnik/launch_wind.sh", "KORISNIK","admin"); //ovo bi trebalo dovest u red jednom 
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind_3.sh", "WEBDIRSPREAD", "$WebDir");
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind_3.sh", "GRASSLOCATION", $grasslocation);
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind_3.sh", "GRASSEXECUTABLE", $grassexecutable);
	setIntoFile ($WebDir."/user_files/$korisnik/launch_wind_3.sh", "GRASSLOCATION", "$grasslocation");
	
	//if(!file_exists($WebDir."/user_files/$korisnik/checkros_launch.sh"))
	{
		copy($WebDir."/userdefault/checkros_launch.sh", $WebDir."/user_files/$korisnik/checkros_launch.sh");
		chmod($WebDir."/user_files/$korisnik/checkros_launch.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/checkros_launch.sh", "WEBDIRSPREAD", "$WebDir");
	setIntoFile ($WebDir."/user_files/$korisnik/checkros_launch.sh", "GRASSEXECUTABLE", $grassexecutable);
	setIntoFile ($WebDir."/user_files/$korisnik/checkros_launch.sh", "GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/checkros_launch.sh", "MAPSET", "$mapset");
	setIntoFile ($WebDir."/user_files/$korisnik/checkros_launch.sh", "KORISNIK", "$korisnik");
	
	//if(!file_exists($WebDir."/user_files/$korisnik/checkfiresuccess_launch.sh"))
	{
		copy($WebDir."/userdefault/checkfiresuccess_launch.sh", $WebDir."/user_files/$korisnik/checkfiresuccess_launch.sh");
		chmod($WebDir."/user_files/$korisnik/checkfiresuccess_launch.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/checkfiresuccess_launch.sh", "WEBDIRSPREAD", "$WebDir");
	setIntoFile ($WebDir."/user_files/$korisnik/checkfiresuccess_launch.sh", "GRASSEXECUTABLE", $grassexecutable);
	setIntoFile ($WebDir."/user_files/$korisnik/checkfiresuccess_launch.sh", "GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/checkfiresuccess_launch.sh", "MAPSET", "$mapset");
	setIntoFile ($WebDir."/user_files/$korisnik/checkfiresuccess_launch.sh", "KORISNIK", "$korisnik");
	
	
	//if(!file_exists($WebDir."/user_files/$korisnik/checkModels_launch.sh"))
	{
		copy($WebDir."/userdefault/checkModels_launch.sh", $WebDir."/user_files/$korisnik/checkModels_launch.sh");
		chmod($WebDir."/user_files/$korisnik/checkModels_launch.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/checkModels_launch.sh", "WEBDIRSPREAD", "$WebDir");
	setIntoFile ($WebDir."/user_files/$korisnik/checkModels_launch.sh", "GRASSEXECUTABLE", $grassexecutable);
	setIntoFile ($WebDir."/user_files/$korisnik/checkModels_launch.sh", "GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/checkModels_launch.sh", "MAPSET", "$mapset");
	setIntoFile ($WebDir."/user_files/$korisnik/checkModels_launch.sh", "KORISNIK", "$korisnik");
	
	
	//if(!file_exists($WebDir."/user_files/$korisnik/calculateros_launch.sh"))
	{
		copy($WebDir."/userdefault/calculateros_launch.sh", $WebDir."/user_files/$korisnik/calculateros_launch.sh");
		chmod($WebDir."/user_files/$korisnik/calculateros_launch.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/calculateros_launch.sh", "WEBDIRSPREAD", "$WebDir");
	
	setIntoFile ($WebDir."/user_files/$korisnik/calculateros_launch.sh", 
	"KORISNIK", "$korisnik");
	setIntoFile ($WebDir."/user_files/$korisnik/calculateros_launch.sh", 
	"GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/calculateros_launch.sh", 
	"MAPSET", "$mapset");
	setIntoFile ($WebDir."/user_files/$korisnik/calculateros_launch.sh", 
	"GRASSEXECUTABLE", $grassexecutable);
	
	//if(!file_exists($WebDir."/user_files/$korisnik/launch.sh"))
	{
		copy($WebDir."/userdefault/launch.sh", $WebDir."/user_files/$korisnik/launch.sh");
		chmod($WebDir."/user_files/$korisnik/launch.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/launch.sh", 
	"KORISNIK", "$korisnik");
	setIntoFile ($WebDir."/user_files/$korisnik/launch.sh", 
	"GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/launch.sh", "WEBDIRSPREAD", "$WebDir");
	setIntoFile ($WebDir."/user_files/$korisnik/launch.sh", "GRASSEXECUTABLE", $grassexecutable);
	
}


function prepareAllUserData($WebDir, $WebDirGisData, $korisnik, $grasslocation, $mapset, $map_file_user, $map_file_userdefault, $WebDir_gisrc, $grassexecutable, $rastForRegion, $currentMeteoArchiveDir, $meteoArchiveDir, $vjetarWMSDir, $linuxUser, $rastForAspect, $rastForSlope)
{

	if(!is_dir  ( "./user_files/$korisnik" ))
	{
		mkdir("./user_files/$korisnik/", 0777);
		chmod("./user_files/$korisnik/", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/raster/" ))
	{
		mkdir("./user_files/$korisnik/raster/", 0777);
		chmod("./user_files/$korisnik/raster/", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/raster/realtime/" ))
	{
		mkdir("./user_files/$korisnik/raster/realtime/", 0777);
		chmod("./user_files/$korisnik/raster/realtime/", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/vector/" ))
	{
		mkdir("./user_files/$korisnik/vector/", 0777);
		chmod("./user_files/$korisnik/vector/", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/Layers/" ))
	{
		mkdir("./user_files/$korisnik/Layers/", 0777);
		chmod("./user_files/$korisnik/Layers/", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/Layers/rast/" ))
	{
		mkdir("./user_files/$korisnik/Layers/rast/", 0777);
		chmod("./user_files/$korisnik/Layers/rast/", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/Layers/shape/" ))
	{
		mkdir("./user_files/$korisnik/Layers/shape/", 0777);
		chmod("./user_files/$korisnik/Layers/shape/", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/meteo/" ))
	{
		mkdir("./user_files/$korisnik/meteo", 0777);
		chmod("./user_files/$korisnik/meteo", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/averages/" ))
	{
		mkdir("./user_files/$korisnik/averages", 0777);
		chmod("./user_files/$korisnik/averages", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/fuelModels/" ))
	{
		mkdir("./user_files/$korisnik/fuelModels", 0777);
		chmod("./user_files/$korisnik/fuelModels", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/fuelModels/Scott/" ))
	{
		mkdir("./user_files/$korisnik/fuelModels/Scott", 0777);
		chmod("./user_files/$korisnik/fuelModels/Scott", 0777);
	}
	if(!is_dir  ( "./user_files/$korisnik/fuelModels/Albini/" ))
	{
		mkdir("./user_files/$korisnik/fuelModels/Albini", 0777);
		chmod("./user_files/$korisnik/fuelModels/Albini", 0777);
	}

	//if(!file_exists($map_file_user))
	{
		copy($map_file_userdefault, $map_file_user);
		chmod($map_file_user, 0777);
	}
	setIntoFile ($map_file_user, "KORISNIK", $korisnik); 
	setIntoFile ($map_file_user, "WEBDIRSPREAD", "$WebDir");
	setIntoFile ($map_file_user, "WEBDIRGISDATA", $WebDirGisData);
	setIntoFile ($map_file_user, "PUTANJAALBINI", "$WebDir/user_files/$korisnik/vector/modelAlbini");
	setIntoFile ($map_file_user, "PUTANJASCOTT", "$WebDir/user_files/$korisnik/vector/modelScott");

	if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_live_average.txt"))
	{
		copy($WebDir."/userdefault/mois_live_average.txt", $WebDir."/user_files/$korisnik/averages/mois_live_average.txt");
		chmod($WebDir."/user_files/$korisnik/averages/mois_live_average.txt", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_live_".$korisnik."_average.txt"))
	{
		copy($WebDir."/userdefault/mois_live_admin_average.txt", $WebDir."/user_files/$korisnik/averages/mois_live_".$korisnik."_average.txt");
		chmod($WebDir."/user_files/$korisnik/averages/mois_live_".$korisnik."_average.txt", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_1h_average.txt"))
	{
		copy($WebDir."/userdefault/mois_1h_average.txt", $WebDir."/user_files/$korisnik/averages/mois_1h_average.txt");
		chmod($WebDir."/user_files/$korisnik/averages/mois_1h_average.txt", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_1h_".$korisnik."_average.txt"))
	{
		copy($WebDir."/userdefault/mois_1h_admin_average.txt", $WebDir."/user_files/$korisnik/averages/mois_1h_".$korisnik."_average.txt");
		chmod($WebDir."/user_files/$korisnik/averages/mois_1h_".$korisnik."_average.txt", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_10h_average.txt"))
	{
		copy($WebDir."/userdefault/mois_10h_average.txt", $WebDir."/user_files/$korisnik/averages/mois_10h_average.txt");
		chmod($WebDir."/user_files/$korisnik/averages/mois_10h_average.txt", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_10h_".$korisnik."_average.txt"))
	{
		copy($WebDir."/userdefault/mois_10h_admin_average.txt", $WebDir."/user_files/$korisnik/averages/mois_10h_".$korisnik."_average.txt");
		chmod($WebDir."/user_files/$korisnik/averages/mois_10h_".$korisnik."_average.txt", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_100h_average.txt"))
	{
		copy($WebDir."/userdefault/mois_100h_average.txt", $WebDir."/user_files/$korisnik/averages/mois_100h_average.txt");
		chmod($WebDir."/user_files/$korisnik/averages/mois_100h_average.txt", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/averages/mois_100h_".$korisnik."_average.txt"))
	{
		copy($WebDir."/userdefault/mois_100h_admin_average.txt", $WebDir."/user_files/$korisnik/averages/mois_100h_".$korisnik."_average.txt");
		chmod($WebDir."/user_files/$korisnik/averages/mois_100h_".$korisnik."_average.txt", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/averages_mois.sh"))
	{
		copy($WebDir."/userdefault/averages_mois.sh", $WebDir."/user_files/$korisnik/averages_mois.sh");
		chmod($WebDir."/user_files/$korisnik/averages_mois.sh", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/slider.log"))
	{
		copy($WebDir."/userdefault/slider.log", $WebDir."/user_files/$korisnik/slider.log");
		chmod($WebDir."/user_files/$korisnik/slider.log", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/calculate_ros.sh"))
	{
		copy($WebDir."/userdefault/calculate_ros.sh", $WebDir."/user_files/$korisnik/calculate_ros.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_ros.sh", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/realtime.sh"))
	{
		copy($WebDir."/userdefault/realtime.sh", $WebDir."/user_files/$korisnik/realtime.sh");
		chmod($WebDir."/user_files/$korisnik/realtime.sh", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/range.log"))
	{
		copy($WebDir."/userdefault/range.log", $WebDir."/user_files/$korisnik/range.log");
		chmod($WebDir."/user_files/$korisnik/range.log", 0777);
	}


	if(!file_exists($WebDir."/user_files/$korisnik/calculate_wind.sh"))
	{
		copy($WebDir."/userdefault/calculate_wind.sh", $WebDir."/user_files/$korisnik/calculate_wind.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_wind.sh", 0777);
	}

	setIntoFile ($WebDir."/user_files/$korisnik/calculate_wind.sh", "KORISNIK",$korisnik); 
	
	
	if(!file_exists($WebDir."/user_files/$korisnik/calculate_wind_2.sh"))
	{
		copy($WebDir."/userdefault/calculate_wind.sh", $WebDir."/user_files/$korisnik/calculate_wind_2.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_wind_2.sh", 0777);
	}
	
	if(!file_exists($WebDir."/user_files/$korisnik/calculate_wind_3.sh"))
	{
		copy($WebDir."/userdefault/calculate_wind.sh", $WebDir."/user_files/$korisnik/calculate_wind_3.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_wind_3.sh", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/calculate_spread.sh"))
	{
		copy($WebDir."/userdefault/calculate_spread.sh", $WebDir."/user_files/$korisnik/calculate_spread.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_spread.sh", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/calculate_spread_ctd.sh"))
	{
		copy($WebDir."/userdefault/calculate_spread_ctd.sh", $WebDir."/user_files/$korisnik/calculate_spread_ctd.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_spread_ctd.sh", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/calculate_spread_res.sh"))
	{
		copy($WebDir."/userdefault/calculate_spread_res.sh", $WebDir."/user_files/$korisnik/calculate_spread_res.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_spread_res.sh", 0777);
	}

	setIntoFile ($WebDir."/user_files/$korisnik/calculate_spread_ctd.sh","output=\"\"", "output=\"$WebDir/user_files/$korisnik/raster/spread_rast\"");
	setIntoFile ($WebDir."/user_files/$korisnik/calculate_spread_ctd.sh","dsn=\"\"", "dsn=\"$WebDir/user_files/$korisnik/vector/spread_shape\"");
	setIntoFile ($WebDir."/user_files/$korisnik/calculate_spread_ctd.sh","KORISNIK", "$korisnik");

	if(!file_exists($WebDir."/user_files/$korisnik/raster/spread_rast.tif"))
	{
		copy($WebDir."/userdefault/spread_rast.tif", $WebDir."/user_files/$korisnik/raster/spread_rast.tif");
		chmod($WebDir."/user_files/$korisnik/raster/spread_rast.tif", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/raster/spread_rast.tfw"))
	{
		copy($WebDir."/userdefault/spread_rast.tfw", $WebDir."/user_files/$korisnik/raster/spread_rast.tfw");
		chmod($WebDir."/user_files/$korisnik/raster/spread_rast.tfw", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/vector/spread_shape.shp"))
	{
		copy($WebDir."/userdefault/spread_shape.shp", $WebDir."/user_files/$korisnik/vector/spread_shape.shp");
		chmod($WebDir."/user_files/$korisnik/vector/spread_shape.shp", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/checkros.sh"))
	{
		copy($WebDir."/userdefault/checkros.sh", $WebDir."/user_files/$korisnik/checkros.sh");
		chmod($WebDir."/user_files/$korisnik/checkros.sh", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/checkfiresuccess.sh"))
	{
		copy($WebDir."/userdefault/checkfiresuccess.sh", $WebDir."/user_files/$korisnik/checkfiresuccess.sh");
		chmod($WebDir."/user_files/$korisnik/checkfiresuccess.sh", 0777);
	}
	
	
	if(!file_exists($WebDir."/user_files/$korisnik/checkModels.sh"))
	{
		copy($WebDir."/userdefault/checkModels.sh", $WebDir."/user_files/$korisnik/checkModels.sh");
		chmod($WebDir."/user_files/$korisnik/checkModels.sh", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/temp.sh"))
	{
		copy($WebDir."/userdefault/temp.sh", $WebDir."/user_files/$korisnik/temp.sh");
		chmod($WebDir."/user_files/$korisnik/temp.sh", 0777);
	}
	
	if(!file_exists($WebDir."/user_files/$korisnik/temp2.sh"))
	{
		copy($WebDir."/userdefault/temp2.sh", $WebDir."/user_files/$korisnik/temp2.sh");
		chmod($WebDir."/user_files/$korisnik/temp2.sh", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/vector/spread_shape.shx"))
	{
		copy($WebDir."/userdefault/spread_shape.shx", $WebDir."/user_files/$korisnik/vector/spread_shape.shx");
		chmod($WebDir."/user_files/$korisnik/vector/spread_shape.shx", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/vector/spread_shape.dbf"))
	{
		copy($WebDir."/userdefault/spread_shape.dbf", $WebDir."/user_files/$korisnik/vector/spread_shape.dbf");
		chmod($WebDir."/user_files/$korisnik/vector/spread_shape.dbf", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/wind_dir.asc"))
	{
		copy($WebDir."/userdefault/wind_dir.asc", $WebDir."/user_files/$korisnik/wind_dir.asc");
		chmod($WebDir."/user_files/$korisnik/wind_dir.asc", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/wind_speed.asc"))
	{
		copy($WebDir."/userdefault/wind_speed.asc", $WebDir."/user_files/$korisnik/wind_speed.asc");
		chmod($WebDir."/user_files/$korisnik/wind_speed.asc", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/wind_dir_temp_1.asc"))
	{
		copy($WebDir."/userdefault/wind_dir_temp.asc", $WebDir."/user_files/$korisnik/wind_dir_temp_1.asc");
		chmod($WebDir."/user_files/$korisnik/wind_dir_temp_1.asc", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/wind_speed_temp_1.asc"))
	{
		copy($WebDir."/userdefault/wind_speed_temp.asc", $WebDir."/user_files/$korisnik/wind_speed_temp_1.asc");
		chmod($WebDir."/user_files/$korisnik/wind_speed_temp_1.asc", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/wind_dir_temp.asc"))
	{
		copy($WebDir."/userdefault/wind_dir_temp.asc", $WebDir."/user_files/$korisnik/wind_dir_temp.asc");
		chmod($WebDir."/user_files/$korisnik/wind_dir_temp.asc", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/wind_speed_temp.asc"))
	{
		copy($WebDir."/userdefault/wind_speed_temp.asc", $WebDir."/user_files/$korisnik/wind_speed_temp.asc");
		chmod($WebDir."/user_files/$korisnik/wind_speed_temp.asc", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/mois_live.asc"))
	{
		copy($WebDir."/userdefault/mois_live.asc", $WebDir."/user_files/$korisnik/mois_live.asc");
		chmod($WebDir."/user_files/$korisnik/mois_live.asc", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/mois1h.asc"))
	{
		copy($WebDir."/userdefault/mois1h.asc", $WebDir."/user_files/$korisnik/mois1h.asc");
		chmod($WebDir."/user_files/$korisnik/mois1h.asc", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/mois10h.asc"))
	{
		copy($WebDir."/userdefault/mois10h.asc", $WebDir."/user_files/$korisnik/mois10h.asc");
		chmod($WebDir."/user_files/$korisnik/mois10h.asc", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/mois100h.asc"))
	{
		copy($WebDir."/userdefault/mois100h.asc", $WebDir."/user_files/$korisnik/mois100h.asc");
		chmod($WebDir."/user_files/$korisnik/mois100h.asc", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/rm_prev_data.sh"))
	{
		copy($WebDir."/userdefault/rm_prev_data.sh", $WebDir."/user_files/$korisnik/rm_prev_data.sh");
		chmod($WebDir."/user_files/$korisnik/rm_prev_data.sh", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/calculate_ros.sh"))
	{
		copy($WebDir."/userdefault/calculate_ros.sh", $WebDir."/user_files/$korisnik/calculate_ros.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_ros.sh", 0777);
	}
	

	if(!file_exists($WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tif"))
	{
		copy($WebDir."/userdefault/ros_base.tif", $WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tif");
		chmod($WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tif", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tfw"))
	{
		copy($WebDir."/userdefault/ros_base.tfw", $WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tfw");
		chmod($WebDir."/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tfw", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/calculate_spread_launch.sh"))
	{
		copy($WebDir."/userdefault/calculate_spread_launch.sh", $WebDir."/user_files/$korisnik/calculate_spread_launch.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_spread_launch.sh", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/mois_value.sh"))
	{
		copy($WebDir."/userdefault/mois_value.sh", $WebDir."/user_files/$korisnik/mois_value.sh");
		chmod($WebDir."/user_files/$korisnik/mois_value.sh", 0777);
	}
	
	if(!file_exists($WebDir."/user_files/$korisnik/mois_value_launch.sh"))
	{
		copy($WebDir."/userdefault/mois_value_launch.sh", $WebDir."/user_files/$korisnik/mois_value_launch.sh");
		chmod($WebDir."/user_files/$korisnik/mois_value_launch.sh", 0777);
	}
	
	if(!file_exists($WebDir."/user_files/$korisnik/averages_mois_launch.sh"))
	{
		copy($WebDir."/userdefault/mois_value_launch.sh", $WebDir."/user_files/$korisnik/averages_mois_launch.sh");
		chmod($WebDir."/user_files/$korisnik/averages_mois_launch.sh", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/animatedRT.map"))
	{
		copy($WebDir."/userdefault/animatedRT.map", $WebDir."/user_files/$korisnik/animatedRT.map");
		chmod($WebDir."/user_files/$korisnik/animatedRT.map", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/RTnumber.log"))
	{
		copy($WebDir."/userdefault/RTnumber.log", $WebDir."/user_files/$korisnik/RTnumber.log");
		chmod($WebDir."/user_files/$korisnik/RTnumber.log", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/fuelParametersAlbini.txt"))
	{
		copy($WebDir."/userdefault/fuelParametersAlbini.txt", $WebDir."/user_files/$korisnik/fuelParametersAlbini.txt");
		chmod($WebDir."/user_files/$korisnik/fuelParametersAlbini.txt", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/fuelParametersScott.txt"))
	{
		copy($WebDir."/userdefault/fuelParametersScott.txt", $WebDir."/user_files/$korisnik/fuelParametersScott.txt");
		chmod($WebDir."/user_files/$korisnik/fuelParametersScott.txt", 0777);
	}
	
		if(!file_exists($WebDir."/user_files/$korisnik/fuelParametersAlbiniDefault.txt"))
	{
		copy($WebDir."/userdefault/fuelParametersAlbini.txt", $WebDir."/user_files/$korisnik/fuelParametersAlbiniDefault.txt");
		chmod($WebDir."/user_files/$korisnik/fuelParametersAlbiniDefault.txt", 0777);
	}

	if(!file_exists($WebDir."/user_files/$korisnik/fuelParametersScottDefault.txt"))
	{
		copy($WebDir."/userdefault/fuelParametersScott.txt", $WebDir."/user_files/$korisnik/fuelParametersScottDefault.txt");
		chmod($WebDir."/user_files/$korisnik/fuelParametersScottDefault.txt", 0777);
	}
	
	if(!file_exists($WebDir."/user_files/$korisnik/reclass_Scott.r"))
	{
		copy($WebDir."/userdefault/reclass_Scott.r", $WebDir."/user_files/$korisnik/reclass_Scott.r");
		chmod($WebDir."/user_files/$korisnik/reclass_Scott.r", 0777);
	}
	
	if(!file_exists($WebDir."/user_files/$korisnik/reclass_customFuelMaps.r"))
	{
		copy($WebDir."/userdefault/reclass_customFuelMaps.r", $WebDir."/user_files/$korisnik/reclass_customFuelMaps.r");
		chmod($WebDir."/user_files/$korisnik/reclass_customFuelMaps.r", 0777);
	}
	
	if(!file_exists($WebDir."/user_files/$korisnik/reclass_Albini.r"))
	{
		copy($WebDir."/userdefault/reclass_Albini.r", $WebDir."/user_files/$korisnik/reclass_Albini.r");
		chmod($WebDir."/user_files/$korisnik/reclass_Albini.r", 0777);
	}
	
	if(!file_exists($WebDir."/files/reclass_Scott.r"))
	{
		copy($WebDir."/userdefault/reclass_Scott.r", $WebDir."/files/reclass_Scott.r");
		chmod($WebDir."/files/reclass_Scott.r", 0777);
	}
	
	if(!file_exists($WebDir."/files/reclass_Albini.r"))
	{
		copy($WebDir."/userdefault/reclass_Albini.r", $WebDir."/files/reclass_Albini.r");
		chmod($WebDir."/files/reclass_Albini.r", 0777);
	}
	
	
	if(!file_exists($WebDir."/user_files/$korisnik/toCalculateROS"))
	{
		copy($WebDir."/userdefault/toCalculateROS", $WebDir."/user_files/$korisnik/toCalculateROS");
		chmod($WebDir."/user_files/$korisnik/toCalculateROS", 0777);
	}
	
	if(!file_exists($WebDir."/user_files/$korisnik/getInfo.log"))
	{
		copy($WebDir."/userdefault/toCalculateROS", $WebDir."/user_files/$korisnik/getInfo.log");
		chmod($WebDir."/user_files/$korisnik/getInfo.log", 0777);
	}
	if(!file_exists($WebDir."/user_files/$korisnik/getInfo.sh"))
	{
		copy($WebDir."/userdefault/toCalculateROS", $WebDir."/user_files/$korisnik/getInfo.sh");
		chmod($WebDir."/user_files/$korisnik/getInfo.sh", 0777);
	}
	//if(!file_exists($WebDir."/user_files/$korisnik/getInfo_launch.sh"))
	{
		copy($WebDir."/userdefault/getInfo_launch.sh", $WebDir."/user_files/$korisnik/getInfo_launch.sh");
		chmod($WebDir."/user_files/$korisnik/getInfo_launch.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/getInfo_launch.sh", "WEBDIRSPREAD", "$WebDir");
	setIntoFile ($WebDir."/user_files/$korisnik/getInfo_launch.sh", "GRASSEXECUTABLE", $grassexecutable);
	setIntoFile ($WebDir."/user_files/$korisnik/getInfo_launch.sh", "GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/getInfo_launch.sh", "MAPSET", "$korisnik");
	setIntoFile ($WebDir."/user_files/$korisnik/getInfo_launch.sh", "KORISNIK", "$korisnik");


	full_copy( $WebDir."/userdefault/korisnik/", $WebDir_gisrc."/$korisnik/");
	//dircopy($WebDir."/userdefault/test/", $WebDir."/user_files/$korisnik/test/", 0);
	
	if(!is_dir( $grasslocation."/".$korisnik ))
	{
		full_copy($grasslocation."/KORISNIK", $grasslocation."/".$korisnik);
	}
	
	if(!is_dir( $grasslocation."/ERUPTIVE" ))
	{
		full_copy($grasslocation."/KORISNIK", $grasslocation."/ERUPTIVE");
	}
	
	if(!is_dir( $grasslocation."/AdriaFireRisk" ))
	{
		full_copy($grasslocation."/KORISNIK", $grasslocation."/AdriaFireRisk");
	}
	
	if(!file_exists($WebDir."/user_files/$korisnik/chosenFuelParameters.txt"))
	{
		copy($WebDir."/userdefault/chosenFuelParameters.txt", $WebDir."/user_files/$korisnik/chosenFuelParameters.txt");
		chmod($WebDir."/user_files/$korisnik/chosenFuelParameters.txt", 0777);
	}
	
	if(!file_exists($WebDir."/user_files/$korisnik/chosenIgnition.txt"))
	{
		copy($WebDir."/userdefault/chosenIgnition.txt", $WebDir."/user_files/$korisnik/chosenIgnition.txt");
		chmod($WebDir."/user_files/$korisnik/chosenIgnition.txt", 0777);
	}
	

	if(!file_exists($WebDir."/user_files/$korisnik/calculate_spread_launch.sh"))
	{
		copy($WebDir."/userdefault/calculate_spread_launch.sh", $WebDir."/user_files/$korisnik/calculate_spread_launch.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_spread_launch.sh", 0777);
	}
	
	
	if(!file_exists($WebDir."/user_files/$korisnik/exportModelsFromCorine_launch.sh"))
	{
		copy($WebDir."/userdefault/exportModelsFromCorine_launch.sh", $WebDir."/user_files/$korisnik/exportModelsFromCorine_launch.sh");
		chmod($WebDir."/user_files/$korisnik/exportModelsFromCorine_launch.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/exportModelsFromCorine_launch.sh", "WEBDIRSPREAD", "$WebDir");
	
	setIntoFile ($WebDir."/user_files/$korisnik/exportModelsFromCorine_launch.sh", 
	"KORISNIK", "$korisnik");
	setIntoFile ($WebDir."/user_files/$korisnik/exportModelsFromCorine_launch.sh", 
	"GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/exportModelsFromCorine_launch.sh", 
	"GRASSEXECUTABLE", $grassexecutable);
	
	
	if(!file_exists($WebDir."/user_files/$korisnik/exportModelsFromCorine.sh"))
	{
		copy($WebDir."/userdefault/exportModelsFromCorine.sh", $WebDir."/user_files/$korisnik/exportModelsFromCorine.sh");
		chmod($WebDir."/user_files/$korisnik/exportModelsFromCorine.sh", 0777);
	}
	
	
	//
	
	if(!file_exists($WebDir."/user_files/$korisnik/reclass_WindCorrection.r"))
	{
		copy($WebDir."/userdefault/reclass_WindCorrection.r", $WebDir."/user_files/$korisnik/reclass_WindCorrection.r");
		chmod($WebDir."/user_files/$korisnik/reclass_WindCorrection.r", 0777);
	}
	
	
	
	if(!file_exists($WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine_launch.sh"))
	{
		copy($WebDir."/userdefault/exportDefaultModelsFromCorine_launch.sh", $WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine_launch.sh");
		chmod($WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine_launch.sh", 0777);
	}
	setIntoFile ($WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine_launch.sh", "WEBDIRSPREAD", "$WebDir");
	
	setIntoFile ($WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine_launch.sh", 
	"KORISNIK", "$korisnik");
	setIntoFile ($WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine_launch.sh", 
	"GRASSLOCATION", "$grasslocation");
	setIntoFile ($WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine_launch.sh", 
	"GRASSEXECUTABLE", $grassexecutable);
	
	
	if(!file_exists($WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine.sh"))
	{
		copy($WebDir."/userdefault/exportModelsFromCorine.sh", $WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine.sh");
		chmod($WebDir."/user_files/$korisnik/exportDefaultModelsFromCorine.sh", 0777);
	}

	if(!file_exists($WebDir."/user_files/log.txt"))
	{
		copy($WebDir."/userdefault/log.txt", $WebDir."/user_files/log.txt");
		chmod($WebDir."/user_files/log.txt", 0777);
	}

	setIntoFile ($WebDir."/user_files/$korisnik/animatedRT.map", 
	"WEBDIRSPREAD", "$WebDir");

	setIntoFile ($map_file_user, 
	"  #Promijeniti raster u user folder
	  DATA", "  DATA $WebDir/user_files/$korisnik/raster/spread_rast.tif
	");

	setIntoFile ($map_file_user, 
	"  #Promijeniti vector u user folder
	  DATA ", "  DATA $WebDir/user_files/$korisnik/vector/spread_shape.shp
	");

		setIntoFile ($map_file_user, 
	"  #Promijeniti ros_base u user folder
	  DATA", "  DATA $WebDir/user_files/$korisnik/Layers/rast/ros_base_$korisnik.tif
	");
	
	
	//Generate crontab
	
	// // // // // // // // // // // $crontabTextOld="#CRONTAB file automatically generated using gis_functions
	
// // // // // // // // // // // #U ovoj verziji pretpostavka je da je crontab user holistic (root user dijelovi su ostali zakomentirani)
	
// // // // // // // // // // // #Pripaziti na foldere
// // // // // // // // // // // # Dohvacanje podataka sa DHMZ
// // // // // // // // // // // #00 0 * * * chmod 750 $meteoArchiveDir/dhmz_http_get
// // // // // // // // // // // #00 0 * * * chmod 750 $vjetarWMSDir/launch.sh

// // // // // // // // // // // #00 2,5 * * *  $meteoArchiveDir/dhmz_http_get -o fesb.wind.12
// // // // // // // // // // // #00 2,5 * * *  $meteoArchiveDir/dhmz_http_get -o fesb.prec.12
// // // // // // // // // // // #00 2,5 * * *  $meteoArchiveDir/dhmz_http_get -o fesb.TRH2m.12
// // // // // // // // // // // #01 2,5 * * *  php $meteoArchiveDir/meteo2asc.php fesb.wind.12
// // // // // // // // // // // #01 2,5 * * *  php $meteoArchiveDir/meteoPrec2asc.php fesb.prec.12
// // // // // // // // // // // #01 2,5 * * *  php $meteoArchiveDir/meteoTRH2m2asc.php fesb.TRH2m.12

// // // // // // // // // // // #00 8,11,14,17 * * *  $meteoArchiveDir/dhmz_http_get -o fesb.wind.00
// // // // // // // // // // // #00 8,11,14,17 * * *  $meteoArchiveDir/dhmz_http_get -o fesb.prec.00
// // // // // // // // // // // #00 8,11,14,17 * * *  $meteoArchiveDir/dhmz_http_get -o fesb.TRH2m.00
// // // // // // // // // // // #01 8,11,14,17 * * *  php $meteoArchiveDir/meteo2asc.php fesb.wind.00
// // // // // // // // // // // #01 8,11,14,17 * * *  php $meteoArchiveDir/meteoPrec2asc.php fesb.prec.00
// // // // // // // // // // // #01 8,11,14,17 * * *  php $meteoArchiveDir/meteoTRH2m2asc.php fesb.TRH2m.00

// // // // // // // // // // // #00 20,23 * * *  $meteoArchiveDir/dhmz_http_get -o fesb.wind.12
// // // // // // // // // // // #00 20,23 * * *  $meteoArchiveDir/dhmz_http_get -o fesb.prec.12
// // // // // // // // // // // #00 20,23 * * *  $meteoArchiveDir/dhmz_http_get -o fesb.TRH2m.12
// // // // // // // // // // // #01 20,23 * * *  php $meteoArchiveDir/meteo2asc.php fesb.wind.12
// // // // // // // // // // // #01 20,23 * * *  php $meteoArchiveDir/meteoPrec2asc.php fesb.prec.12
// // // // // // // // // // // #01 20,23 * * *  php $meteoArchiveDir/meteoTRH2m2asc.php fesb.TRH2m.12

// // // // // // // // // // // #00 16 * * *  $meteoArchiveDir/dhmz_http_get -a pozar.lis
// // // // // // // // // // // #01 16 * * *  php $meteoArchiveDir/get_FWI.php
// // // // // // // // // // // #01 16 * * *  php $meteoArchiveDir/get_mois_from_FFMC.php

// // // // // // // // // // // #Calculate mois_live
// // // // // // // // // // // 02 2,5,8,11,14,17,20,23 * * * $WebDir/files/calculate_mois_live_launch.sh

// // // // // // // // // // // #Calculate eruptive risk layer
// // // // // // // // // // // 03 2,5,8,11,14,17,20,23 * * * $WebDir/files/calculate_eruptive_risk_launch.sh

// // // // // // // // // // // #Calculate ROS
// // // // // // // // // // // #04 2,5,8,11,14,17,20,23 * * * $WebDir/files/calculate_ros_launch.sh

// // // // // // // // // // // #Calculate MIRIP
// // // // // // // // // // // 0 0 1 * * $WebDir/MIRIP/staticMIRIP_launch.sh
// // // // // // // // // // // 05 2,5,8,11,14,17,20,23 * * * $WebDir/MIRIP/dynamicMIRIP_launch.sh

// // // // // // // // // // // #Generiranje XML file-a za panele
// // // // // // // // // // // #HR_Split_Marjan_1
// // // // // // // // // // // #28 * * * * $WebDir/MIRIP/generateXML_launch.sh\
// // // // // // // // // // // #29 * * * * php \"$WebDir/MIRIP/generateXML.php\" \"$WebDir/MIRIP/HR_Split_Marjan_1.txt\" \"$WebDir/MIRIP/HR_Split_Marjan_1.xml\"



// // // // // // // // // // // ";


$crontabText="#CRONTAB file automatically generated using gis_functions
	
#Get wind, prec, TRH2m data
#AdriaFireGIS returns false results if started at 00
10,30 * * * * php $meteoArchiveDir/getMeteoDataHolistic.php
09,29 * * * * $meteoArchiveDir/corfu_launch.sh
10 */2 * * * php $meteoArchiveDir/getMeteoData4CorfuHolistic.php
00 14 * * * php \"$meteoArchiveDir/checkMeteoObtainWorksHolistic.php\"
#Calculate FWI components
12 2,5,8,11,14,17,20,23 * * * php $meteoArchiveDir/calculateFWI.php

#Calculate eruptive risk layer
20 2,5,8,11,14,17,20,23 * * * $WebDir/files/calculate_eruptive_risk_launch.sh

#Calculate MIRIP
0 0 1 * * $WebDir/MIRIP/staticMIRIP_launch.sh
30 1,4,7,10,13,16,19,22 * * * php $WebDir/MIRIP/obtainShapeFilesMIRIP.php
00 4 * * * $WebDir/MIRIP/midMIRIP_launch.sh
14 2,5,8,11,14,17,20,23 * * * $WebDir/MIRIP/dynamicMIRIP_launch.sh

#Generiranje XML file-a za panele
#HR_Split_Marjan_1
28 * * * * $WebDir/MIRIP/generateXML_launch.sh
29 * * * * php \"$WebDir/MIRIP/generateXML.php\" \"$WebDir/MIRIP/HR_Split_Marjan_1.txt\" \"$WebDir/MIRIP/HR_Split_Marjan_1.xml\"
#Ovo treba ic u root crontab
#29 * * * * php \"$WebDir/MIRIP/checkPaneIsWorking.php\"
#Nova verzija panela
00,15,30,45 * * * * php \"$WebDir/panels/generateShellForXML.php\"
01,16,31,46 * * * * $WebDir/panels/generateXML_launch.sh
02,17,32,47 * * * * php \"$WebDir/panels/generateXML.php\"

";

	if(!file_exists($WebDir."/files/crontab"))
	{
		copy($WebDir."/userdefault/crontab", $WebDir."/files/crontab");
		chmod($WebDir."/files/crontab", 0777);
	}
	
	$filename=$WebDir."/files/crontab";
	$fh = fopen($filename, 'w') or die("can't open file");
	fwrite($fh, $crontabText);
	fclose($fh);
	
	
	//Check if .gislock exists for too long
	$getLastModDir = filemtime("$grasslocation/$korisnik/.gislock");
	$timeNow = time();
	$differenceInTimes=$timeNow-$getLastModDir;
	if($differenceInTimes > 10000)
		unlink("$grasslocation/$korisnik/.gislock");
	
	
	//Generate calculate_ros_launch for current conditions
	if(!file_exists($WebDir."/files/calculate_ros.sh"))
	{
		copy($WebDir."/userdefault/calculate_ros.sh", $WebDir."/files/calculate_ros.sh");
		chmod($WebDir."/files/calculate_ros.sh", 0777);
	}
	
$textForROS="#!/bin/sh

#Start1
#g.remove rast=my_ros.max,my_ros.base,my_ros.maxdir,my_ros.spotdist,mois,mois_l,mois_l0,mois_l00,w_speed1,w_dir1
g.remove rast=mois,mois_l,mois_l0,mois_l00,w_speed1,w_dir1
#End1

echo
echo \"Calculate ROS:\"

g.region rast=$rastForRegion res=100

#Start2
r.in.arc input=$currentMeteoArchiveDir/wind_dir.asc output=w_dir1 type=FCELL mult=1.0
r.in.arc input=$currentMeteoArchiveDir/wind_speed.asc output=w_speed1 type=FCELL mult=1.0
#End2

#Start3
#smjer vjetra popravljen
r.mapcalc w_dir1=w_dir1-180
#preracunaj u km/h
r.mapcalc w_speed1=w_speed1*54.68
#End3

#Start4
	r.in.arc input=$currentMeteoArchiveDir/mois_live.asc output=mois type=FCELL mult=1.0
	r.in.arc input=$currentMeteoArchiveDir/mois1h.asc output=mois_l type=FCELL mult=1.0
	r.in.arc input=$currentMeteoArchiveDir/mois10h.asc output=mois_l0 type=FCELL mult=1.0
	r.in.arc input=$currentMeteoArchiveDir/mois100h.asc output=mois_l00 type=FCELL mult=1.0
#End4


#Start5
#r.ros -v model=modelAlbini moisture_live=mois moisture_1h=mois_l moisture_10h=mois_l0 moisture_100h=mois_l00 velocity=w_speed1 direction=w_dir1 slope=slope aspect=aspect elevation=el output=my_ros
#r.out.tiff input=my_ros.base output=\"$WebDir/files/ros_base\" compression=none -t 

r.ros -v model=modelAlbini moisture_live=mois moisture_1h=mois_l moisture_10h=mois_l0 moisture_100h=mois_l00 velocity=w_speed1 direction=w_dir1 slope=$rastForSlope aspect=$rastForAspect elevation=$rastForRegion output=my_ros_temp
r.out.tiff input=my_ros_temp.base output=\"$WebDir/files/ros_base\" compression=none -t 

g.remove rast=my_ros.max,my_ros.base,my_ros.maxdir,my_ros.spotdist
g.rename rast=my_ros_temp.max,my_ros.max
g.rename rast=my_ros_temp.base,my_ros.base
g.rename rast=my_ros_temp.maxdir,my_ros.maxdir
g.rename rast=my_ros_temp.spotdist,my_ros.spotdist

#End5";
	
	$filename=$WebDir."/files/calculate_ros.sh";
	$fh = fopen($filename, 'w') or die("can't open file");
	fwrite($fh, $textForROS);
	fclose($fh);

	
	
	if(!file_exists($WebDir."/files/calculate_ros_launch.sh"))
	{
		copy($WebDir."/userdefault/calculateros_launch.sh", $WebDir."/files/calculate_ros_launch.sh");
		chmod($WebDir."/files/calculate_ros_launch.sh", 0777);
	}
	
	
	$textForROS2="export GRASS_BATCH_JOB=$WebDir/files/calculate_ros.sh
$grassexecutable -text $grasslocation/$mapset";	

	$filename=$WebDir."/files/calculate_ros_launch.sh";
	$fh = fopen($filename, 'w') or die("can't open file");
	fwrite($fh, $textForROS2);
	fclose($fh);
	
	


	prepareLaunchUserData($WebDir, $WebDirGisData, $korisnik, $grasslocation, $mapset, $map_file_user, $map_file_userdefault, $WebDir_gisrc, $grassexecutable);

	
	//Check if problem with meteo data obtaining
	
	$problemMeteo = file_get_contents("$meteoArchiveDir/meteoProblem.log", true);
	if(trim($problemMeteo)=="1")
	{
		echo "<script> alert(\""._METEO_ERROR."\"); </script>";
	}
	
	
}

function click2map ($click_x, $click_y) {
    global $map;
    $e= &$map->extent; //Tip for saving type time
    $x_pct = ($click_x / $map->width);
    $y_pct = 1-($click_y / $map->height);
    $x_map = $e->minx + ( ($e->maxx - $e->minx) * $x_pct);
    $y_map = $e->miny + ( ($e->maxy - $e->miny) * $y_pct);


    return array($x_map, $y_map);
}

//Stara funkcija pokretanja procsa u linuxu u pozdarini
function run_in_background($Command, $Priority = 0)
{
    if($Priority)
        $PID = exec("nohup nice -n $Priority $Command 2> /dev/null & echo $!");
    else
	$PID = exec("nohup $Command > /dev/null 2> /dev/null & echo $!");
        //$PID = shell_exec("nohup $Command 2> /dev/null & echo $!");
	return($PID);
}

//Stara funkcija provjere izvodi li se proces
function is_process_running($PID)
{
    exec("ps $PID", $ProcessState);
    return(count($ProcessState) >= 2);
}

//Radi prebacivanja PHP nizova u JS nizove
class array_to_js {
    var $js_arrays;
    function error ($message, $stop = true) {
        echo "<b>array_to_js</b> - FATAL ERROR: ".$message;
        if ($stop) exit;
    }
    function add_array($myarray, $outputvarname, $level = 0) {
        if (isset($this->js_arrays[$outputvarname]))
            $this->error('This Array has been added more than once: "'.$outputvarname.'"');
        for ($i=0; $i<$level; $i++) $pre .= '    ';
        $this->js_arrays[$outputvarname] .= $pre.$outputvarname.' = new Object();'."\n";
        foreach ($myarray as $key => $value) {
            if (!is_int($key))
                $key = '"'.addslashes($key).'"';
            if (is_array($value))
                $this->add_array($value, $outputvarname.'['.$key.']', $level+1);
            else {
                $this->js_arrays[$outputvarname] .= $pre.'    '.$outputvarname.'['.$key.']'.' = ';

                if (is_int($value) or is_float($value))
                    $this->js_arrays[$outputvarname] .= $value;
                elseif (is_bool($value))
                    $this->js_arrays[$outputvarname] .= $value ? "true" : "false";
                elseif (is_string($value))
                    $this->js_arrays[$outputvarname] .= '"'.addslashes($value).'"';
                else
                    $this->error('Unknown Datatype for "'.$outputvarname.'['.$key.']"');
                $this->js_arrays[$outputvarname] .= ";\n";
            }
        }
    }
    function output_all($scripttag = true) {
        if ($scripttag) $outputstring = '<script language="JavaScript" type="text/javascript">'."\n";
        foreach ($this->js_arrays as $array)
            $outputstring .= $array;
        if ($scripttag) $outputstring .= '</script>'."\n";

        return $outputstring;
    }
} 




function killStartedSimulation($korisnik, $numberOfRepeats)
{
	
		$counter=1;
		$found=0;
		$stringToKill="ps axo pid,pgid,command,args | grep launch.sh";
		
		$out = array();
		exec($stringToKill, $out);
		//echo 'alert("'.$korisnik.'");';
		foreach($out as $line) {
			//echo 'alert("'.$line.'");';
			$line=trim($line);
			if (strpos($line, "les/".$korisnik."/") !== false)
			{
				
				//echo 'alert("'.$line.'");';
				
				$pidArray=array();
				$pidArray=explode(" ", $line);
				//$GpidToKill=$pidArray[1];
				$pidToKill=$pidArray[0];
				//$stringToKill2="kill -INT -".$GpidToKill;
				
				//Verzija sa pid, jer pgid je za sve korisnike skupa

		
				$stringToKill3="pgrep -P $pidToKill";
				$out3 = array();
				exec($stringToKill3, $out3);
				$pToBeKilled = array();
				
				foreach($out3 as $line3) 
				{
					$line3=trim($line3);
					$pidArray3=array();
					$pidArray3=explode(" ", $line3);
					array_push($pToBeKilled, $pidArray3[0]);
				}
				
			
				

				//kill children
				foreach($pToBeKilled as $kPid) 
				{
					//return $kPid;
					$stringToKill4="kill -9 ".$kPid;
					$output=exec($stringToKill4);
				}
				
				//kill main
				/*if($numberOfRepeats==$counter)
				{
					$stringToKill3="kill -9 ".$pidToKill;
					$output=exec($stringToKill3);
				}*/
				
				//return $stringToKill2;
				//echo 'alert("'.$stringToKill2.'");';
				$found=1;
				$counter++;
			}		
		}
	
	
	
		//bitno da se ugasi session da ne ostanu sleep radit
		session_write_close();
	
	return $found;
}



function checkIfStillRunningAnySimulations($korisnik)
{
		$found=0;
		$stringToKill="ps axo pid,pgid,command,args | grep launch.sh";
		$out = array();
		exec($stringToKill, $out);
		foreach($out as $line) {
			if (strpos($line, "les/".$korisnik."/") !== false)
			{
				$found=1;
			}		
		}
	
	return $found;
}

function checkIfStillRunningFuelPreparation($korisnik)
{
		$found=0;
		$stringToKill="ps axo pid,pgid,command,args | grep ModelsFromCorine_launch.sh";
		$out = array();
		exec($stringToKill, $out);
		foreach($out as $line) {
			if (strpos($line, "les/".$korisnik."/") !== false)
			{
				$found=1;
			}		
		}
	
	return $found;
}


function checkIfMeteoDataStillRunning($korisnik)
{
		$found=0;
		$stringToKill="ps axo pid,pgid,command,args | grep php";
		$out = array();
		exec($stringToKill, $out);
		foreach($out as $line) {
			if (strpos($line, "getMeteoDataHolistic") !== false)
			{
				
				if (strpos($line, $korisnik) !== false)
				{
					$found=1;
				}
			}
		}
		
		//ili
		
		$stringToKill="ps axo pid,pgid,command,args | grep launch";
		$out = array();
		exec($stringToKill, $out);
		foreach($out as $line) {
			if (strpos($line, "temp_$korisnik_launch") !== false)
			{
				$found=1;
			}
		}
	
	return $found;
}


function updateLanguageInDbForUser($korisnik, $newLanguage)
{
	$db=new db_func();
	$db->connect();
	$query = "SELECT language_id FROM languages WHERE language_code = '".$newLanguage."'";
	//return $query;
		$result = $db->query($query);
		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			foreach ($line as $col_value) {
				$newLanguageId=$col_value;
			}
		}

	// Free resultset
	pg_free_result($result);
	
	
	
	
	$query = "UPDATE users SET language_id =".$newLanguageId." WHERE username='".$korisnik."'";;
	//return $query;
		$result = $db->query($query);
	// Free resultset
	pg_free_result($result);
	
	
	$db->disconnect();
		
}




?>