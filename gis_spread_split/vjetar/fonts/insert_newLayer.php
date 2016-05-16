<?
/////////////Directoriji i imena fileova ////////////////////
$WebDir = "/var/www/gis_spread/mapfile_editor/";	/////
$MonImgName="monitor.png";				/////
$map_file="./kornat.map";				/////
$map_file_temp="./temp.map";				/////
/***********************************************************/


/******************************************************************/
// Ubacuje u Mapfile Layer
/******************************************************************/
function setIntoFile ($filename, $string_find, $string_replace) {

	$fh2 = fopen($filename, 'r') or die("can't open file");

	while (!feof($fh2)) {
  		$spreadData .= fread($fh2, 8192);
	}

	fclose($fh2);

	$new_text = str_replace($string_find, $string_replace, $spreadData);

	$fh = fopen($filename, 'w') or die("can't open file");
	fwrite($fh, $new_text);
	fclose($fh);
	
}


/******************************************************************/
//Priprema Layer ako je raster, vraca string koji treba ubaciti
/******************************************************************/
function prepareRaster($WebDir, $map_extent, $lName,$lGroup, $lStatus, $lMinscale, $lMaxscale, $lSymbolscale, $lTransp, $lOffisteR, $lOffisteG, $lOffisteB, $lData, $provjeraExtent)
{

	//Extenzija file-a u kojem je rasterski layer
	//Dozvoljeni samo fileovi sa .tif (.tiff) i .asc ekstenzijama
	$ext = substr($lData, strpos($lData,'.'), strlen($lData)-1);

	//Priprema stringova koji se upisuju u mapfile

	//NAME
	if($lName=="") return NULL;
	else $name="  NAME \"".$lName."\"
";
	//DATA
	if($lData=="" ) return NULL;
	else 
	{
		if($ext==".tif" || $ext==".tiff" || $ext==".asc") 
			$ldata="  DATA ".$lData."
";
		else return NULL;
	}
	//GROUP
	if($lGroup!="")	$group="  GROUP \"".$lGroup."\"
";
	else $group="";
	//MINSCALE
	if($lMinscale!="" && is_numeric($lMinscale)) $minscale="  MINSCALE ".$lMinscale."
";
	else $minscale ="";
	//MAXSCALE
	if($lMaxscale!="" && is_numeric($lMaxscale)) $maxscale="  MAXSCALE ".$lMaxscale."
";
	else $maxscale ="";
	//SYMBOLSCALE
	if($lSymbolscale!="" && is_numeric($lSymbolscale)) $symbolscale="  SYMBOLSCALE ".$lSymbolscale."
";
	else $symbolscale ="";
	//TRANSPARENCY
	if(is_numeric($lTransp) && $lTransp!="")
	{

		if($lTransp>100) $lTransp=100;
		if($lTransp<0) $lTransp=0;

		$transp="  TRANSPARENCY ".$lTransp."
";
	}
	else $transp ="  TRANSPARENCY 100
";
	//OFFSITE
	if($lOffisteR!="" && $lOffisteG!="" && $lOffisteB!="") $offsite="  OFFSITE $lOffisteR $lOffisteG $lOffisteB"."
";
	else $offsite ="";
	//STATUS
	if($lStatus!="") 
	{
		if($lStatus=="1")
		$status="  STATUS ON"."
";
		if($lStatus=="2")
		$status="  STATUS OFF"."
";
		if($lStatus=="3")
		$status="  STATUS DEFAULT"."
";
	}
	else $status="";

	// Ukoliko se uz pomoć Grassa želi provjeriti upada li barem dio ovog layera unutar extenta koji je postavljen u mapfile
	//Koristenjem unzoom se mozda i moze vidjeti layer, ali ovdje se usporeduje samo default extent iz mapfile
	if($lData!="" && ($ext==".tif" || $ext==".tiff" || $ext==".asc") && $provjeraExtent)
	{
			require("./Grass/grasslib.php");
			setgrassenv("$WebDir"."Grass",$MonImgName);
		
		//Ukoliko je riječ o .tif rasterskom file-u
		// r.in.gdal treba fnkcionirati u Grassu
		if($ext==".tif" || $ext==".tiff")
		{
			$regionFile=$WebDir."Grass/region.log";
			$errorFile=$WebDir."Grass/error.log";
			system("g.remove rast=newLayerRasterTemp > $errorFile");
			system("r.in.gdal input=$lData output=newLayerRasterTemp band=red -o");
			system("g.region -g rast=newLayerRasterTemp > $regionFile");
			system("g.remove rast=newLayerRasterTemp > $errorFile");
			 $fp = fopen($regionFile, 'r');
			if (!$fp) {
	   			echo 'Nije uspjesno otvoren region.log';	
			}
			require ("Grass/read_region.php");


			if(($e>=$map_extent->extent->minx && $e<=$map_extent->extent->maxx) || ($w>=$map_extent->extent->minx && $w<=$map_extent->extent->maxx) || ($n>=$map_extent->extent->miny && $n<=$map_extent->extent->maxy) || ($s>=$map_extent->extent->miny && $s<=$map_extent->extent->maxy) || 
				(
					$w<$map_extent->extent->minx && $e>$map_extent->extent->maxx && $n>$map_extent->extent->maxy && $s<$map_extent->extent->miny					
				) 
			  )
			{
				echo "<b>Layer (dio layera) se nalazi UNUTAR trenutnog extenta!</b><br />";
			}
			else
				echo "<b>Layer se NE nalazi unutar trenutnog extenta!</b><br />";
				
		}
		//Ukoliko je riječ o .asc rasterskom file-u
		if($ext==".asc")
		{
			$regionFile=$WebDir."Grass/region.log";
			$errorFile=$WebDir."Grass/error.log";
			system("g.remove rast=newLayerRasterTemp > $errorFile");
			system("r.in.arc input=$lData output=newLayerRasterTemp type=FCELL mult=1.0 ");
			system("g.region -g rast=newLayerRasterTemp > $regionFile");
			system("g.remove rast=newLayerRasterTemp > $errorFile");
			 $fp = fopen($regionFile, 'r');
			if (!$fp) {
	   			echo 'Nije uspjesno otvoren region.log';	
			}
			require ("Grass/read_region.php");


			if(($e>=$map_extent->extent->minx && $e<=$map_extent->extent->maxx) || ($w>=$map_extent->extent->minx && $w<=$map_extent->extent->maxx) || ($n>=$map_extent->extent->miny && $n<=$map_extent->extent->maxy) || ($s>=$map_extent->extent->miny && $s<=$map_extent->extent->maxy) || 
				(
					$w<$map_extent->extent->minx && $e>$map_extent->extent->maxx && $n>$map_extent->extent->maxy && $s<$map_extent->extent->miny					
				) 
			  )
			{
				echo "<b>Layer (dio layera) se nalazi UNUTAR trenutnog extenta!</b><br />";
			}
			else
				echo "<b>Layer se NE nalazi unutar trenutnog extenta!</b><br />";
				
		}
	}

//Formiranje glavnog stringa koji se unosi u mapfile i to na kraj (mora imati END # Map File inace nece funkcionirati)
	$rez="#Layer - ".$lName."
LAYER
$name"."$group  TYPE RASTER 
$minscale"."$maxscale"."$symbolscale"."$transp"."$offsite"."$status"."$ldata"."
END # end of layer $lName

END # Map File";

return $rez;
}
?>

<html>
<head>
<title>Mapfile Editor</title>
</head>

<body>

<?
/******************************************************************/
//Skripte radi dinamicke forme
/******************************************************************/
?>
<SCRIPT language=JavaScript>

/*
function reload(form){

var lName=form.lName.value;
var lGroup=form.lGroup.value;
var lType=form.lType.options[form.lType.options.selectedIndex].value;
var lStatus=form.lStatus.options[form.lStatus.options.selectedIndex].value;
var lMinscale=form.lMinscale.value;
var lMaxscale=form.lMaxscale.value;
var lSymbolscale=form.lSymbolscale.value;
var lTransp=form.lTransp.value;
//alert(document.getElementById('lUnosT').checked);
//test1=form.lUnosT.checked



if(lType==5)
{
var lOffisteR=form.lOffisteR.value;
var lOffisteG=form.lOffisteG.value;
var lOffisteB=form.lOffisteB.value;
}

var gets = new Array();

gets.push('?lName=' + lName);

if(lGroup!="")
	gets.push('&lGroup=' + lGroup);
if(lType!="")
	gets.push('&lType=' + lType);
if(lStatus!="")
	gets.push('&lStatus=' + lStatus);
if(lMinscale!="")
	gets.push('&lMinscale=' + lMinscale);
if(lMaxscale!="")
	gets.push('&lMaxscale=' + lMaxscale);
if(lSymbolscale!="")
	gets.push('&lSymbolscale=' + lSymbolscale);
if(lTransp!="")
	gets.push('&lTransp=' + lTransp);
if(lOffisteR!="" && lType==5)
	gets.push('&lOffisteR=' + lOffisteR);
if(lOffisteG!="" && lType==5)
	gets.push('&lOffisteG=' + lOffisteG);
if(lOffisteB!="" && lType==5)
	gets.push('&lOffisteB=' + lOffisteB);

var loc='insert_newLayer.php';


var i=0;
for(i=0;i<gets.length;i++)
{
	loc += gets[i];
}


self.location=loc;


}

function addHiddenFilenameField()
{
	lDataValue=document.getElementById("form_id").lData.value;
        elem = document.createElement("input");
        elem.id = lDataValue.toString();
	elem.type= "hidden";
        elem.name = "lDataValue";
        elem.value = lDataValue;

        formelem = document.getElementById("formelems");
        formelem.appendChild(elem);
} 
*/
</script>


<?print_r($_POST);?>

<form name="form1" id="form1" action="<?echo $_SERVER['PHP_SELF'];?>" method="POST">

Ime layera: <input type="textfield" name="lName" value="<?if($_GET['lName']!="") echo $_GET['lName'];?>"><br />
Grupa: <input type="textfield" name="lGroup" value="<?if($_GET['lGroup']!="") echo $_GET['lGroup'];?>"><br />
Status:
<select name='lStatus' onchange='submit()'>
<option value='1' <?if($_GET['lStatus']==1) echo "selected";?>>On</option>"
<option value='2' <?if($_GET['lStatus']==2) echo "selected";?>>Off</option>"
<option value='3' <?if($_GET['lStatus']==3) echo "selected";?>>Default</option>"
</select><br />
Type:
<select name='lType' id='lType' onchange='alert("ssss");form.submit();alert("ss");'>
<option value='1' <?if($_GET['lType']==1) echo "selected";?>>Point</option>"
<option value='2' <?if($_GET['lType']==2) echo "selected";?>>Line</option>"
<option value='3' <?if($_GET['lType']==3) echo "selected";?>>Polygon</option>"
<option value='4' <?if($_GET['lType']==4) echo "selected";?>>Circle</option>"
<option value='5' <?if($_GET['lType']==5) echo "selected";?>>Raster</option>"
</select><br />
<?//Ako je odabran POINT - POCETAK?>
<?
if($_GET['lType']== 1 || $_GET['lType']=="")
{?>
	<input type='checkbox' name='lUnosT' id='lUnosT' onchange='submit()' <?if($_GET['lUnosT']=="on") echo "checked";?>>Vlastiti unos tocaka klikom na kartu!<br />
<?}
?>
<?//Ako je odabran POINT - KRAJ?>
Minscale:<input type="textfield" name="lMinscale" value="<?if($_GET['lMinscale']!="") echo $_GET['lMinscale'];?>"><br />
Maxscale:<input type="textfield" name="lMaxscale" value="<?if($_GET['lMaxscale']!="") echo $_GET['lMaxscale'];?>"><br />
Symbolscale:<input type="textfield" name="lSymbolscale" value="<?if($_GET['lSymbolscale']!="") echo $_GET['lSymbolscale'];?>"><br />
Transparency:<input type="textfield" name="lTransp" value="<?if($_GET['lTransp']!="") echo $_GET['lTransp'];?>"><br />
<INPUT NAME="lData" TYPE="file" id="getFileName" onchange="addHiddenFilenameField();">
<?
 if($_GET['lDataValue']!="")
{
	echo $_GET['lDataValue'];
?>
	<input type="hidden" name="lDataValue" value="<?echo $_GET['lDataValue'];?>">
<? 
}
?>

<div id = "formelems"> </div>
<?//Ako je odabran RASTER POCETAK?>
<?if($_GET['lType']==5)
{
?>
Offsite:<br />
R
<select name='lOffisteR'>
<?
for($i=0;$i<256;$i++)
{
	?>
	<option value='<?echo $i?>' <?if($_GET['lOffisteR']==$i) echo "selected";?>><?echo $i?></option>"
	<?
}
?>
</select>
G
<select name='lOffisteG'>
<?
for($i=0;$i<256;$i++)
{
	?>
	<option value='<?echo $i?>' <?if($_GET['lOffisteG']==$i) echo "selected";?>><?echo $i?></option>"
	<?
}
?>
</select>
B
<select name='lOffisteB'>
<?
for($i=0;$i<256;$i++)
{
	?>
	<option value='<?echo $i?>' <?if($_GET['lOffisteB']==$i) echo "selected";?>><?echo $i?></option>"
	<?
}
?>
</select>

<?
}
else
{
?>
<input type="hidden" name="lOffisteR" value="">
<input type="hidden" name="lOffisteG" value="">
<input type="hidden" name="lOffisteB" value="">
<?
}
?>
<?//Ako je odabran raster KRAJ?>






<?$provjeraExtent=false;?>
<br /><br /><input type='checkbox' name="lProvjera" <?if($_GET['lProvjera']=="on") echo "checked";?>>Provjeri je li layer izvan granica?

<?if($_GET['lProvjera']=="on")
	$provjeraExtent=true;?>
<br />
<input type="submit" name="submit" value="Preview">
</form>


<?

echo $_FILES['wind_dir_asc_file']['name'];

if($_GET['submit']=="Preview")
{
	copy($map_file,$map_file_temp);

	if($provjeraExtent)
	{
		$map_extent = ms_newMapObj($map_file);
	}
	else
		$map_extent=NULL;

	$string=NULL;

	//POINT
	if($_GET['lType']==1)
	{
		$string="END # Map File";
	}
	
	//RASTER
	if($_GET['lType']==5)
	{
		$string=prepareRaster($WebDir, $map_extent, $_GET['lName'],$_GET['lGroup'], $_GET['lStatus'], $_GET['lMinscale'], $_GET['lMaxscale'], $_GET['lSymbolscale'], $_GET['lTransp'], $_GET['lOffisteR'], $_GET['lOffisteG'], $_GET['lOffisteB'], $_GET['lDataValue'], $provjeraExtent);
	}

	echo $string;

	if($string!=NULL)
	{
		setIntoFile($map_file_temp, "END # Map File", $string);

		$map = ms_newMapObj($map_file_temp);

	for ($i=0; $i<$map->numlayers; $i++)
		{
		$layers[$i]=$map->getLayer($i);
			if(isset($_POST["granice"]))
			{
				if(isset($_POST["layer$i"]))
					{
					$layers[$i]->set("status",MS_ON);
					}
				else
					{
					$layers[$i]->set("status",MS_OFF);
					}
			}
		}


		$map_granice = $map->extent->minx." ".$map->extent->miny." ".$map->extent->maxx." ".$map->extent->maxy;
		$image=$map->draw();
		$image_url=$image->saveWebImage();
	?>
	<center><table border="0">
		<tr>
  	<td width="10" valign="top">
 	<div id="content"><br><center><h3>Kornati</h3><br />
	
	<input type=IMAGE name="image" src="<?php echo $image_url?>">
	<table align="center" border="1" width=100% text-align="center"><tr><td align="left">

  	<b>SLOJEVI:</b><br>
  	<table align="center" border="0"><tr><td>

	<? for($i=0;$i<count($layers);$i++)
	{
	?>
	<?echo ($i+1).". ".$layers[$i]->name ?><br>
	<?
	}
	?>
	</table>
<?
	}
	else
	{
	echo "Pogresni podaci";
	}
}
?>
</body>
</html>