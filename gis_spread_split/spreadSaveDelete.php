<?php
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//
//   PSpremanje i brisanje temp izracunatog Spread, kako u mapfile tako i samih fileova 	     //
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//

//***************************************************************************************************//

//	Funkcija koja stvara 2 nova layera (temeljeno na vremenu) u mapfile, jedan shape i jedan rast
//	Takodjer, svi se fileovi smjestaju na odgovarajuce mjesto u folderima,kako bi se kasnije mogli
//	koristiti.

//***************************************************************************************************//
function saveSpread($WebDir,$filename_prefix,$map_file,$l_name, $korisnik)
{
$time_var=date('Y-m-d  h:m:s');

$file1 = "$WebDir/user_files/$korisnik/raster/spread_rast.tif";
$newfile1 = "$WebDir/user_files/$korisnik/Layers/rast/$l_name.tif";
$file2 = "$WebDir/user_files/$korisnik/raster/spread_rast.tfw";
$newfile2 = "$WebDir/user_files/$korisnik/Layers/rast/$l_name.tfw";

$file3 = "$WebDir/user_files/$korisnik/vector/spread_shape.shp";
$newfile3 = "$WebDir/user_files/$korisnik/Layers/shape/$l_name.shp";
$file4 = "$WebDir/user_files/$korisnik/vector/spread_shape.dbf";
$newfile4 = "$WebDir/user_files/$korisnik/Layers/shape/$l_name.dbf";
//$file5 = "$WebDir/user_files/$korisnik/vector/spread_shape.prj";
//$newfile5 = "$WebDir/user_files/$korisnik/Layers/shape/$l_name.prj";
$file6 = "$WebDir/user_files/$korisnik/vector/spread_shape.shx";
$newfile6 = "$WebDir/user_files/$korisnik/Layers/shape/$l_name.shx";


if (!copy($file1, $newfile1)) {
    echo "failed to copy $file1...\n";
}
if (!copy($file2, $newfile2)) {
    echo "failed to copy $file2...\n";
}
if (!copy($file3, $newfile3)) {
    echo "failed to copy $file3...\n";
}
if (!copy($file4, $newfile4)) {
    echo "failed to copy $file4...\n";
}
//if (!copy($file5, $newfile5)) {
  //  echo "failed to copy $file5...\n";
//}
if (!copy($file6, $newfile6)) {
    echo "failed to copy $file6...\n";
}


	setIntoFile($map_file, "END # Map File", 

"#Layer - $l_name(r)#\n
#$l_name(r) erasable: YES\n
#time created $time_var\n
LAYER\n
  NAME \"$l_name(r)\"\n
  TYPE RASTER\n
  OFFSITE  255 255 0\n
  TRANSPARENCY  75\n
STATUS ON\n
  DATA \"$WebDir/user_files/$korisnik/Layers/rast/$l_name.tif\"\n
END # end of layer $l_name(r)#\n

#Layer - $l_name(v)#\n
#$l_name(v) erasable: YES\n
#time created $time_var\n
LAYER\n
NAME \"$l_name(v)\"\n
TYPE LINE\n
STATUS ON\n
DATA \"$WebDir/user_files/$korisnik/Layers/shape/$l_name.shp\"\n
CLASS\n
COLOR 0 0 0\n
END # end of class\n
END # end of layer $l_name(v)#\n


END # Map File");

}

//***************************************************************************************************//

//	Funkcija koja brise selektirane layere iz mapfile, ali takodjer brise i fileove.
//	Pomocu $skipFirst se ne dozvoljava brisanje prvih nekoliko layera, ovo treba rijesiti drugacije,
//	odnosno, da se provjerava po imenu layera 

//***************************************************************************************************//
function substring_between($haystack,$start,$end) {
     if (strpos($haystack,$start) === false || strpos($haystack,$end) === false) {
         return false;
     } else {
         $start_position = strpos($haystack,$start)+strlen($start);
         $end_position = strpos($haystack,$end);
         return substr($haystack,$start_position,$end_position-$start_position);
     }
 }

//***************************************************************************************************//
// NE RADI OVO, OSTAVLJENO SAMO RADI DOKUMENTACIJE
//	Funkcija koja brise selektirane layere iz mapfile, ali takodjer brise i fileove.
//	Pomocu $skipFirst se ne dozvoljava brisanje prvih nekoliko layera, ovo treba rijesiti drugacije,
//	odnosno, da se provjerava po imenu layera 

//***************************************************************************************************//
/*
function deleteSpread($map, $WebDir,$filename_prefix,$map_file)
{

	echo $map_file;
	$skipFirst=3;

	for ($i=$skipFirst; $i<$map->numlayers; $i++)
	{
		$layers[$i]=$map->getLayer($i);
		

		if(isset($_POST["layer$i"]))
			{

				$fh2 = fopen($map_file, 'r') or die("can't open file");

				$deleteData="";
				while (!feof($fh2)) {
  				$deleteData .= fread($fh2, 8192);
				}
				fclose($fh2);

				$string_find_1="#".$layers[$i]->name;
				$string_find_2="END # end of layer ".$layers[$i]->name;
				
				$text=substring_between($deleteData,$string_find_1,$string_find_2);
				$final_text=$string_find_1."".$text."".$string_find_2;
				
				$new_text = str_replace($final_text, "", $deleteData);
				$new_text=preg_replace("/\n[^\w]*\n/","\n\n",$new_text); 


				$fh = fopen($map_file, 'w') or die("can't open file");
				fwrite($fh, $new_text);
				fclose($fh);

				$stringType=explode(" ", $string_find_1);
				$string_type=substr($stringType[1], 0, -10);
				
				if($string_type=="raster")
				{
					$fileDelete1="$WebDir/rast/$filename_prefix"."_"."$stringType[1]".".tif";
					$fileDelete2="$WebDir/rast/$filename_prefix"."_"."$stringType[1]".".tfw";
				unlink($fileDelete1);
				unlink($fileDelete2);
				}
				if($string_type=="shape")
				{
					$fileDelete3="$WebDir/shape/$filename_prefix"."_"."$stringType[1]".".shp";
					$fileDelete4="$WebDir/shape/$filename_prefix"."_"."$stringType[1]".".dbf";
					$fileDelete5="$WebDir/shape/$filename_prefix"."_"."$stringType[1]".".shx";
					$fileDelete6="$WebDir/shape/$filename_prefix"."_"."$stringType[1]".".prj";
				unlink($fileDelete3);
				unlink($fileDelete4);
				unlink($fileDelete5);
				unlink($fileDelete6);
				}
			}	
	}
}
*/
?>