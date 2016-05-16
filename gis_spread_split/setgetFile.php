<?php
//***************************************************************************************************//
//	Zamjenuje string pronadjen u file, sa drugim stringom
//***************************************************************************************************//
function setIntoFile ($filename, $string_find, $string_replace) {

	$fh2 = fopen($filename, 'r') or die("can't open file $filename");

	while (!feof($fh2)) {
  		$spreadData .= fread($fh2, 8192);
	}

	fclose($fh2);

	$new_text = str_replace($string_find, $string_replace, $spreadData);


	$fh = fopen($filename, 'w') or die("can't open file $filename ");
	fwrite($fh, $new_text);
	fclose($fh);
	
}

//***************************************************************************************************//

//	Pomocu 2 explode (" ", pa "=" npr pronalazi se vrijednost od $string1 (tj. $string1=1 -- 
//	vraca 1

//***************************************************************************************************//
function getFromFile ($filename, $explode1, $explode2, $string1) {

	$fh2 = fopen($filename, 'r') or die("can't open file");
	$spreadData = fread($fh2, filesize($filename));
	fclose($fh2);

	$glistarray = explode($explode1, $spreadData);

	for($i = 0; $i < count($glistarray); $i++){
		$glistarray2 = explode($explode2, $glistarray[$i]);
		for($j = 0; $j < count($glistarray2); $j++){
			if($glistarray2[$j]==$string1)
				$info=$glistarray2[$j+1];
		}

	}

    return $info;
}

?>