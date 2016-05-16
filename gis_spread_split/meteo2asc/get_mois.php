<?php

function get_mois($temp,$mois)
{
	if($temp>-50 && $temp<=-1)
	{
		if($mois>=0 && $mois<5)
		{
			return 1;
		}
		if($mois>=5 && $mois<10)
		{
			return 2;		
		}
		if($mois>=10 && $mois<15)
		{
			return 2;		
		}
		if($mois>=15 && $mois<20)
		{
			return 3;		
		}
		if($mois>=20 && $mois<25)
		{
			return 4;
		}
		if($mois>=25 && $mois<30)
		{
			return 5;
		}
		if($mois>=30 && $mois<35)
		{
			return 5;
		}
		if($mois>=35 && $mois<40)
		{
			return 6;
		}
		if($mois>=40 && $mois<45)
		{
			return 7;
		}
		if($mois>=45 && $mois<50)
		{
			return 8;
		}
		if($mois>=50 && $mois<55)
		{
			return 8;
		}
		if($mois>=55 && $mois<60)
		{
			return 8;
		}
		if($mois>=60 && $mois<65)
		{
			return 9;
		}
		if($mois>=65 && $mois<70)
		{
			return 9;
		}
		if($mois>=70 && $mois<75)
		{
			return 10;
		}
		if($mois>=75 && $mois<80)
		{
			return 11;
		}
		if($mois>=80 && $mois<85)
		{
			return 12;
		}
		if($mois>=85 && $mois<90)
		{
			return 12;
		}
		if($mois>=90 && $mois<95)
		{
			return 13;
		}
		if($mois>=95 && $mois<100)
		{
			return 13;
		}
		if($mois==100)
		{
			return 14;
		}

	}
	if($temp>-1 && $temp<=10)
	{
		if($mois>=0 && $mois<5)
		{
			return 1;
		}
		if($mois>=5 && $mois<10)
		{
			return 2;		
		}
		if($mois>=10 && $mois<15)
		{
			return 2;		
		}
		if($mois>=15 && $mois<20)
		{
			return 3;		
		}
		if($mois>=20 && $mois<25)
		{
			return 4;
		}
		if($mois>=25 && $mois<30)
		{
			return 5;
		}
		if($mois>=30 && $mois<35)
		{
			return 5;
		}
		if($mois>=35 && $mois<40)
		{
			return 6;
		}
		if($mois>=40 && $mois<45)
		{
			return 7;
		}
		if($mois>=45 && $mois<50)
		{
			return 7;
		}
		if($mois>=50 && $mois<55)
		{
			return 7;
		}
		if($mois>=55 && $mois<60)
		{
			return 8;
		}
		if($mois>=60 && $mois<65)
		{
			return 9;
		}
		if($mois>=65 && $mois<70)
		{
			return 9;
		}
		if($mois>=70 && $mois<75)
		{
			return 10;
		}
		if($mois>=75 && $mois<80)
		{
			return 10;
		}
		if($mois>=80 && $mois<85)
		{
			return 11;
		}
		if($mois>=85 && $mois<90)
		{
			return 12;
		}
		if($mois>=90 && $mois<95)
		{
			return 13;
		}
		if($mois>=95 && $mois<100)
		{
			return 13;
		}
		if($mois==100)
		{
			return 13;
		}
	}
	if($temp>10 && $temp<=20)
	{
		if($mois>=0 && $mois<5)
		{
			return 1;
		}
		if($mois>=5 && $mois<10)
		{
			return 2;		
		}
		if($mois>=10 && $mois<15)
		{
			return 2;		
		}
		if($mois>=15 && $mois<20)
		{
			return 3;		
		}
		if($mois>=20 && $mois<25)
		{
			return 4;
		}
		if($mois>=25 && $mois<30)
		{
			return 5;
		}
		if($mois>=30 && $mois<35)
		{
			return 5;
		}
		if($mois>=35 && $mois<40)
		{
			return 6;
		}
		if($mois>=40 && $mois<45)
		{
			return 6;
		}
		if($mois>=45 && $mois<50)
		{
			return 7;
		}
		if($mois>=50 && $mois<55)
		{
			return 7;
		}
		if($mois>=55 && $mois<60)
		{
			return 8;
		}
		if($mois>=60 && $mois<65)
		{
			return 8;
		}
		if($mois>=65 && $mois<70)
		{
			return 9;
		}
		if($mois>=70 && $mois<75)
		{
			return 9;
		}
		if($mois>=75 && $mois<80)
		{
			return 10;
		}
		if($mois>=80 && $mois<85)
		{
			return 11;
		}
		if($mois>=85 && $mois<90)
		{
			return 12;
		}
		if($mois>=90 && $mois<95)
		{
			return 12;
		}
		if($mois>=95 && $mois<100)
		{
			return 12;
		}
		if($mois==100)
		{
			return 13;
		}
	}
	if($temp>20 && $temp<=31)
	{
		if($mois>=0 && $mois<5)
		{
			return 1;
		}
		if($mois>=5 && $mois<10)
		{
			return 1;		
		}
		if($mois>=10 && $mois<15)
		{
			return 2;		
		}
		if($mois>=15 && $mois<20)
		{
			return 2;		
		}
		if($mois>=20 && $mois<25)
		{
			return 3;
		}
		if($mois>=25 && $mois<30)
		{
			return 4;
		}
		if($mois>=30 && $mois<35)
		{
			return 5;
		}
		if($mois>=35 && $mois<40)
		{
			return 5;
		}
		if($mois>=40 && $mois<45)
		{
			return 6;
		}
		if($mois>=45 && $mois<50)
		{
			return 7;
		}
		if($mois>=50 && $mois<55)
		{
			return 7;
		}
		if($mois>=55 && $mois<60)
		{
			return 8;
		}
		if($mois>=60 && $mois<65)
		{
			return 8;
		}
		if($mois>=65 && $mois<70)
		{
			return 8;
		}
		if($mois>=70 && $mois<75)
		{
			return 9;
		}
		if($mois>=75 && $mois<80)
		{
			return 10;
		}
		if($mois>=80 && $mois<85)
		{
			return 10;
		}
		if($mois>=85 && $mois<90)
		{
			return 11;
		}
		if($mois>=90 && $mois<95)
		{
			return 12;
		}
		if($mois>=95 && $mois<100)
		{
			return 12;
		}
		if($mois==100)
		{
			return 13;
		}
	}
	if($temp>31 && $temp<=42)
	{
		if($mois>=0 && $mois<5)
		{
			return 1;
		}
		if($mois>=5 && $mois<10)
		{
			return 1;		
		}
		if($mois>=10 && $mois<15)
		{
			return 2;		
		}
		if($mois>=15 && $mois<20)
		{
			return 2;		
		}
		if($mois>=20 && $mois<25)
		{
			return 3;
		}
		if($mois>=25 && $mois<30)
		{
			return 4;
		}
		if($mois>=30 && $mois<35)
		{
			return 4;
		}
		if($mois>=35 && $mois<40)
		{
			return 5;
		}
		if($mois>=40 && $mois<45)
		{
			return 6;
		}
		if($mois>=45 && $mois<50)
		{
			return 7;
		}
		if($mois>=50 && $mois<55)
		{
			return 7;
		}
		if($mois>=55 && $mois<60)
		{
			return 8;
		}
		if($mois>=60 && $mois<65)
		{
			return 8;
		}
		if($mois>=65 && $mois<70)
		{
			return 8;
		}
		if($mois>=70 && $mois<75)
		{
			return 9;
		}
		if($mois>=75 && $mois<80)
		{
			return 10;
		}
		if($mois>=80 && $mois<85)
		{
			return 10;
		}
		if($mois>=85 && $mois<90)
		{
			return 11;
		}
		if($mois>=90 && $mois<95)
		{
			return 12;
		}
		if($mois>=95 && $mois<100)
		{
			return 12;
		}
		if($mois==100)
		{
			return 13;
		}
	}
	if($temp>42)
	{
		if($mois>=0 && $mois<5)
		{
			return 1;
		}
		if($mois>=5 && $mois<10)
		{
			return 1;		
		}
		if($mois>=10 && $mois<15)
		{
			return 2;		
		}
		if($mois>=15 && $mois<20)
		{
			return 2;		
		}
		if($mois>=20 && $mois<25)
		{
			return 3;
		}
		if($mois>=25 && $mois<30)
		{
			return 4;
		}
		if($mois>=30 && $mois<35)
		{
			return 4;
		}
		if($mois>=35 && $mois<40)
		{
			return 5;
		}
		if($mois>=40 && $mois<45)
		{
			return 6;
		}
		if($mois>=45 && $mois<50)
		{
			return 7;
		}
		if($mois>=50 && $mois<55)
		{
			return 7;
		}
		if($mois>=55 && $mois<60)
		{
			return 8;
		}
		if($mois>=60 && $mois<65)
		{
			return 8;
		}
		if($mois>=65 && $mois<70)
		{
			return 8;
		}
		if($mois>=70 && $mois<75)
		{
			return 9;
		}
		if($mois>=75 && $mois<80)
		{
			return 10;
		}
		if($mois>=80 && $mois<85)
		{
			return 10;
		}
		if($mois>=85 && $mois<90)
		{
			return 11;
		}
		if($mois>=90 && $mois<95)
		{
			return 12;
		}
		if($mois>=95 && $mois<100)
		{
			return 12;
		}
		if($mois==100)
		{
			return 12;
		}
	}


}

$WebDir= "/var/www/gis_spread/split_spread/meteo2asc/";	
$filename=$WebDir."pozar.lis";

	$fh2 = fopen($filename, 'r') or die("can't open file");
	$moisData="";

	for($i=0;!feof($fh2);$i++)
	{
		$moisData[$i] = fgets($fh2);
		$moisData[$i]=trim($moisData[$i]);
		$temp = explode(" ", $moisData[$i]);
		if($temp[0]=="Split")
		{
			$k=3;
			while($temp[$k]=="") $k++;
			$Split_temp=$temp[$k]; $k++;
			while($temp[$k]=="") $k++;
			$Split_mois=$temp[$k];
			$Split=2;
		}
		if($temp[0]=="Hvar")
		{
			$k=1;
			while($temp[$k]=="") $k++;
			$Hvar_temp=$temp[$k]; $k++;
			while($temp[$k]=="") $k++;
			$Hvar_mois=$temp[$k];
			$Hvar=3;
		}
		if($temp[0]=="Komiza")
		{
			$k=1;
			while($temp[$k]=="") $k++;
			$Komiza_temp=$temp[$k]; $k++;
			while($temp[$k]=="") $k++;
			$Komiza_mois=$temp[$k];
			$Komiza=4;
		}
		if($temp[0]=="Imotski")
		{
			$k=1;
			while($temp[$k]=="") $k++;
			$Imotski_temp=$temp[$k]; $k++;
			while($temp[$k]=="") $k++;
			$Imotski_mois=$temp[$k];
			$Imotski=5;
		}
		if($temp[0]=="Makarska")
		{
			$k=1;
			while($temp[$k]=="") $k++;
			$Makarska_temp=$temp[$k]; $k++;
			while($temp[$k]=="") $k++;
			$Makarska_mois=$temp[$k];
			$Makarska=6;
		}
		if($temp[0]=="Ploce")
		{
			$k=1;
			while($temp[$k]=="") $k++;
			$Ploce_temp=$temp[$k]; $k++;
			while($temp[$k]=="") $k++;
			$Ploce_mois=$temp[$k];
			$Ploce=7;
		}
		if($temp[0]=="Hvar")
		{
			$k=1;
			while($temp[$k]=="") $k++;
			$Korcula_temp=$temp[$k]; $k++;
			while($temp[$k]=="") $k++;
			$Korcula_mois=$temp[$k];
			$Korcula=8;
		}
	}

	echo "<br />"."Split:".$Split_temp." ".$Split_mois;
	echo "<br />"."Komiza:".$Komiza_temp." ".$Komiza_mois;
	echo "<br />"."Imotski:".$Imotski_temp." ".$Imotski_mois;
	echo "<br />"."Makarska:".$Makarska_temp." ".$Makarska_mois;
	echo "<br />"."Ploce:".$Ploce_temp." ".$Ploce_mois;
	echo "<br />"."Hvar:".$Hvar_temp." ".$Hvar_mois;
	echo "<br />"."Korcula:".$Korcula_temp." ".$Korcula_mois;


	$Split_result=get_mois($Split_temp,$Split_mois);
	$Komiza_result=get_mois($Komiza_temp,$Komiza_mois);
	$Imotski_result=get_mois($Imotski_temp,$Imotski_mois);
	$Makarska_result=get_mois($Makarska_temp,$Makarska_mois);
	$Ploce_result=get_mois($Ploce_temp,$Ploce_mois);
	$Hvar_result=get_mois($Hvar_temp,$Hvar_mois);
	$Korcula_result=get_mois($Korcula_temp,$Korcula_mois);

	echo "<br />"."Split:".$Split_result;
	echo "<br />"."Komiza:".$Komiza_result;
	echo "<br />"."Imotski:".$Imotski_result;
	echo "<br />"."Makarska:".$Makarska_result;
	echo "<br />"."Ploce:".$Ploce_result;
	echo "<br />"."Hvar:".$Hvar_result;
	echo "<br />"."Korcula:".$Korcula_result;



$prefix="ncols 53
nrows 57
xllcorner 6581415.36215435
yllcorner 4734654.20149751
cellsize 2973.921667
NODATA_value -9999

";

	$moisture_text="";
	$filename="/var/www/gis_spread/split_spread/userdefault/kopno.preasc";
	$fh2 = fopen($filename, 'r') or die("can't open file");


	while (!feof($fh2)) 
	{
		$moisture_text .= fgets($fh2);
	}

	$moisture_text = str_replace("Split", $Split_result, $moisture_text);
	$moisture_text = str_replace("Komiza", $Komiza_result, $moisture_text);
	$moisture_text = str_replace("Imotski", $Imotski_result, $moisture_text);
	$moisture_text = str_replace("Makarska", $Makarska_result, $moisture_text);
	$moisture_text = str_replace("Ploce", $Ploce_result, $moisture_text);
	$moisture_text = str_replace("Hvar", $Hvar_result, $moisture_text);
	$moisture_text = str_replace("Korcula", $Korcula_result, $moisture_text);


	$new_text2=$prefix.$moisture_text;

	$filename="/var/www/gis_spread/split_spread/files/mois_live.asc";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $new_text2);
				fclose($fh);
	$filename="/var/www/gis_spread/split_spread/files/mois1h.asc";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $new_text2);
				fclose($fh);

				if($Split_result>1) $Split_result--;
				if($Komiza_result>1) $Komiza_result--;
				if($Imotski_result>1) $Imotski_result--;
				if($Makarska_result>1) $Makarska_result--;
				if($Ploce_result>1) $Ploce_result--;
				if($Hvar_result>1) $Hvar_result--;
				if($Korcula_result>1) $Korcula_result--;

	$moisture_text="";
	$filename="/var/www/gis_spread/split_spread/userdefault/kopno.preasc";
	$fh2 = fopen($filename, 'r') or die("can't open file");


	while (!feof($fh2)) 
	{
		$moisture_text .= fgets($fh2);
	}

	$moisture_text = str_replace("Split", $Split_result, $moisture_text);
	$moisture_text = str_replace("Komiza", $Komiza_result, $moisture_text);
	$moisture_text = str_replace("Imotski", $Imotski_result, $moisture_text);
	$moisture_text = str_replace("Makarska", $Makarska_result, $moisture_text);
	$moisture_text = str_replace("Ploce", $Ploce_result, $moisture_text);
	$moisture_text = str_replace("Hvar", $Hvar_result, $moisture_text);
	$moisture_text = str_replace("Korcula", $Korcula_result, $moisture_text);


	$new_text2=$prefix.$moisture_text;

		$filename="/var/www/gis_spread/split_spread/files/mois10h.asc";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $new_text2);
				fclose($fh);
	$filename="/var/www/gis_spread/split_spread/files/mois100h.asc";
	$fh = fopen($filename, 'w') or die("can't open file");
				fwrite($fh, $new_text2);
				fclose($fh);

?>