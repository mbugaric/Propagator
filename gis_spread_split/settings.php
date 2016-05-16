<?php
function changeSettings2($WebDir, $rastForRegion ,$max_resolution, $korisnik, $spread_lag, $spread_step, $spread_slider, $chosenFuelModel, $chosenIgnition)
{
	$_POST['spread_vrijeme']=$spread_lag;
	$_POST['spread_korak']=$spread_step;
	$_POST['spread_slider']=$spread_slider;
	//$_POST['chosenFuelModel']=$chosenFuelModel;
	$external_param_file = $chosenFuelModel;

	

	
	$myFile_spread = "$WebDir/user_files/$korisnik/calculate_spread_ctd.sh";
	$spread_lag=getFromFile($myFile_spread, ' ', '=', 'lag');
	$spread_step=getFromFile($myFile_spread,' ', '=', 'step');
	$spread_cdens=getFromFile($myFile_spread,' ', '=', 'comp_dens');

	$myFile_spread_res = "$WebDir/user_files/$korisnik/calculate_spread_res.sh";
	$spread_res=getFromFile($myFile_spread_res, ' ', '=', 'res');
	
	$myFile_slider = "$WebDir/user_files/$korisnik/slider.log";
	$spread_slider=getFromFile($myFile_slider, ' ', '=', 'slider');
	
		
	if($_POST['spread_vrijeme']!=$spread_lag && isset($_POST['spread_vrijeme']) && is_numeric($_POST['spread_vrijeme']))
	{
	
		$string_find="lag=".$spread_lag;
		$string_replace="lag=".$_POST['spread_vrijeme'];
		setIntoFile($myFile_spread, $string_find, $string_replace);
		//return $string_find;
		$string_find="maxlevel=".$spread_lag;
		$string_replace="maxlevel=".$_POST['spread_vrijeme'];
		setIntoFile($myFile_spread, $string_find, $string_replace);
		$spread_lag=$_POST['spread_vrijeme'];
		
	}

	if($_POST['spread_korak']!=$spread_step && isset($_POST['spread_korak']) && is_numeric($_POST['spread_korak']))
	{
		$string_find="step=".$spread_step;
		$string_replace="step=".$_POST['spread_korak'];
		setIntoFile($myFile_spread, $string_find, $string_replace);
		$spread_step=$_POST['spread_korak'];
	}
	
	if($_POST['spread_slider']!=$spread_slider && isset($_POST['spread_slider']) && is_numeric($_POST['spread_slider']))
	{
		$string_find="slider=".$spread_slider;
		$string_replace="slider=".$_POST['spread_slider'];
		//return $string_find."     ".$string_replace;
		setIntoFile($myFile_slider, $string_find, $string_replace);
		$spread_slider=$_POST['spread_slider'];
		
	}
	
	if($chosenFuelModel=="Albini_custom" || $chosenFuelModel=="Scott_custom" || $chosenFuelModel=="Albini_default" || $chosenFuelModel=="Scott_default")
	{
		$filename=$WebDir."/user_files/$korisnik/chosenFuelParameters.txt";
		$fh = fopen($filename, 'w') or die("can't open file $filename ");
		fwrite($fh, $chosenFuelModel);
		fclose($fh);
	}
	
	if($chosenIgnition=="pointIgnition" || $chosenIgnition=="perimeterIgnition")
	{
		$filename=$WebDir."/user_files/$korisnik/chosenIgnition.txt";
		$fh = fopen($filename, 'w') or die("can't open file $filename ");
		fwrite($fh, $chosenIgnition);
		fclose($fh);
	}
	
	
	
}

function priorSettings2($WebDir, $rastForRegion ,$max_resolution, $korisnik)
{
	
	
	
	
	$_POST['spread_vrijeme']=400;
	$_POST['spread_korak']=40;
		
	//echo "<script type='text/javascript'>alert('test');</script>";
	
	

	$myFile_spread = "$WebDir/user_files/$korisnik/calculate_spread_ctd.sh";
	$spread_lag=getFromFile($myFile_spread, ' ', '=', 'lag');
	$spread_step=getFromFile($myFile_spread,' ', '=', 'step');
	$spread_cdens=getFromFile($myFile_spread,' ', '=', 'comp_dens');
	//Ako je greska
	if($spread_lag=="" || $spread_step=="" || $spread_cdens =="")
	{
		copy($WebDir."/userdefault/calculate_spread_ctd.sh", $WebDir."/user_files/$korisnik/calculate_spread_ctd.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_spread_ctd.sh", 0777);
		$myFile_spread = "$WebDir/user_files/$korisnik/calculate_spread_ctd.sh";
		$spread_lag=getFromFile($myFile_spread, ' ', '=', 'lag');
		$spread_step=getFromFile($myFile_spread,' ', '=', 'step');
		$spread_cdens=getFromFile($myFile_spread,' ', '=', 'comp_dens');
	}

	
	$myFile_spread_res = "$WebDir/user_files/$korisnik/calculate_spread_res.sh";
	$spread_res=getFromFile($myFile_spread_res, ' ', '=', 'res');
	//Ako je greska
	if($spread_res=="")
	{
		copy($WebDir."/userdefault/calculate_spread_res.sh", $WebDir."/user_files/$korisnik/calculate_spread_res.sh");
		chmod($WebDir."/user_files/$korisnik/calculate_spread_res.sh", 0777);
		$spread_res=getFromFile($myFile_spread_res, ' ', '=', 'res');
	}
	
	$myFile_slider = "$WebDir/user_files/$korisnik/slider.log";
	$spread_slider=getFromFile($myFile_slider, ' ', '=', 'slider');
	//Ako je greska
	if($spread_slider=="")
	{
		copy($WebDir."/userdefault/slider.log", $WebDir."/user_files/$korisnik/slider.log");
		chmod($WebDir."/user_files/$korisnik/slider.log", 0777);
		$spread_slider=getFromFile($myFile_slider, ' ', '=', 'slider');
	}
	
	
	$filename=$WebDir."/user_files/$korisnik/chosenFuelParameters.txt";
	$fh2 = fopen($filename, 'r') or die("can't open file");
	$chosenFuelModel = fread($fh2, filesize($filename));
	fclose($fh2);
	//Ako je greska
	if($chosenFuelModel=="")
	{
		copy($WebDir."/userdefault/chosenFuelParameters.txt", $WebDir."/user_files/$korisnik/chosenFuelParameters.txt");
		chmod($WebDir."/user_files/$korisnik/chosenFuelParameters.txt", 0777);
		$chosenFuelModel = fread($fh2, filesize($filename));
	}
	
	
	
	$filename=$WebDir."/user_files/$korisnik/chosenIgnition.txt";
	$fh2 = fopen($filename, 'r') or die("can't open file");
	$chosenIgnition = fread($fh2, filesize($filename));
	fclose($fh2);
	//Ako je greska
	if($chosenIgnition=="")
	{
		copy($WebDir."/userdefault/chosenIgnition.txt", $WebDir."/user_files/$korisnik/chosenIgnition.txt");
		chmod($WebDir."/user_files/$korisnik/chosenIgnition.txt", 0777);
		$chosenIgnition = fread($fh2, filesize($filename));
	}
	
	

	//file_put_contents("$WebDir/user_files/$korisnik/tempFileNow", $spread_lag." ".$spread_step." ".$spread_cdens." ".$spread_res." ".$spread_slider." ".$chosenFuelModel." ".$chosenIgnition);
	return $spread_lag." ".$spread_step." ".$spread_cdens." ".$spread_res." ".$spread_slider." ".$chosenFuelModel." ".$chosenIgnition;
}

//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//
//   Postavke prilikom racunanja Spread, po potrebi se moze dodati jos puno toga		     //
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//
//***************************************************************************************************//

function settings_prior($WebDir, $rastForRegion ,$max_resolution, $korisnik)
{
	
	$myFile_spread = "$WebDir/user_files/$korisnik/calculate_spread_ctd.sh";
	$spread_lag=getFromFile($myFile_spread, ' ', '=', 'lag');
	$spread_step=getFromFile($myFile_spread,' ', '=', 'step');
	$spread_cdens=getFromFile($myFile_spread,' ', '=', 'comp_dens');

	$myFile_spread_res = "$WebDir/user_files/$korisnik/calculate_spread_res.sh";
	$spread_res=getFromFile($myFile_spread_res, ' ', '=', 'res');


	if($_POST['spread_vrijeme']!=$spread_lag && isset($_POST['spread_vrijeme']) && is_numeric($_POST['spread_vrijeme']))
	{
		$string_find="lag=".$spread_lag;
		$string_replace="lag=".$_POST['spread_vrijeme'];
		setIntoFile($myFile_spread, $string_find, $string_replace);
		$string_find="maxlevel=".$spread_lag;
		$string_replace="maxlevel=".$_POST['spread_vrijeme'];
		setIntoFile($myFile_spread, $string_find, $string_replace);
		$spread_lag=$_POST['spread_vrijeme'];
	}

	if($_POST['spread_korak']!=$spread_step && isset($_POST['spread_korak']) && is_numeric($_POST['spread_korak']))
	{
		$string_find="step=".$spread_step;
		$string_replace="step=".$_POST['spread_korak'];
		setIntoFile($myFile_spread, $string_find, $string_replace);
		$spread_step=$_POST['spread_korak'];
	}


if(!isset($_POST['slider_value'])) $_POST['slider_value']=5;

if($_POST['slider_value']>=0 && $_POST['slider_value']<5)
{
	$_POST['spread_comp']=0.1;
}
if($_POST['slider_value']>=5 && $_POST['slider_value']<15)
{
	$_POST['spread_comp']=0.2;
}
if($_POST['slider_value']>=15 && $_POST['slider_value']<=20)
{
	$_POST['spread_comp']=0.2;
}


	if(isset($_POST['spread_comp']) )
	{
		if($_POST['spread_comp']>0.5) $_POST['spread_comp']=0.5;
		if($_POST['spread_comp']<0.0) $_POST['spread_comp']=0.0;
		$_POST['spread_comp']=round($_POST['spread_comp'],1);
		$string_find="comp_dens=".$spread_cdens;
		$string_replace="comp_dens=".$_POST['spread_comp'];
		setIntoFile($myFile_spread, $string_find, $string_replace);
		$spread_cdens=$_POST['spread_comp'];
	}


}

function updateDefaultView($WebDir, $korisnik, $lat,$lon,$zoom)
{
	/*$string="$lat
$lon
$zoom";*/
		$string="$lat|$lon|$zoom";

		/*$filename=$WebDir."/user_files/$korisnik/defaultView.txt";
		$fh = fopen($filename, 'w') or die("can't open file $filename ");
		fwrite($fh, $string);
		fclose($fh);*/
		
	$db=new db_func();
	$db->connect();
	$query = "UPDATE users SET defaultview ='".$string."' WHERE username='".$korisnik."'";

	$result = $db->query($query);
	// Closing connection
	$db->disconnect();
}


function settings($WebDir, $rastForRegion ,$max_resolution, $korisnik)
{
?>

<script language="JavaScript" src="./slider/slider.js"></script>
<script language="JavaScript" src="./js/wz_jsgraphics.js"></script>
<div style="background-color:#FFFFCC;" valign="top">
<input type='radio' style="visibility: hidden;" name="hidden_radio" value="hidden_radio">
<b>POSTAVKE POZARA</b><hr></div>
<?php
	$myFile_spread = "$WebDir/user_files/$korisnik/calculate_spread_ctd.sh";
	$spread_lag=getFromFile($myFile_spread, ' ', '=', 'lag');
	$spread_step=getFromFile($myFile_spread,' ', '=', 'step');
	$spread_cdens=getFromFile($myFile_spread,' ', '=', 'comp_dens');

	$myFile_spread_res = "$WebDir/user_files/$korisnik/calculate_spread_res.sh";
	$spread_res=getFromFile($myFile_spread_res, ' ', '=', 'res');


	if($_POST['spread_vrijeme']!=$spread_lag && isset($_POST['spread_vrijeme']) && is_numeric($_POST['spread_vrijeme']))
	{
		$string_find="lag=".$spread_lag;
		$string_replace="lag=".$_POST['spread_vrijeme'];
		//setIntoFile($myFile_spread, $string_find, $string_replace);
		$string_find="maxlevel=".$spread_lag;
		$string_replace="maxlevel=".$_POST['spread_vrijeme'];
		//setIntoFile($myFile_spread, $string_find, $string_replace);
		$spread_lag=$_POST['spread_vrijeme'];
	}

	if($_POST['spread_korak']!=$spread_step && isset($_POST['spread_korak']) && is_numeric($_POST['spread_korak']))
	{
		$string_find="step=".$spread_step;
		$string_replace="step=".$_POST['spread_korak'];
		//setIntoFile($myFile_spread, $string_find, $string_replace);
		$spread_step=$_POST['spread_korak'];
	}


if(!isset($_POST['slider_value'])) $_POST['slider_value']=5;

if($_POST['slider_value']>=0 && $_POST['slider_value']<5)
{
	$_POST['spread_comp']=0.1;
}
if($_POST['slider_value']>=5 && $_POST['slider_value']<15)
{
	$_POST['spread_comp']=0.2;
}
if($_POST['slider_value']>=15 && $_POST['slider_value']<=20)
{
	$_POST['spread_comp']=0.2;
}


	if(isset($_POST['spread_comp']) )
	{
		if($_POST['spread_comp']>0.5) $_POST['spread_comp']=0.5;
		if($_POST['spread_comp']<0.0) $_POST['spread_comp']=0.0;
		$_POST['spread_comp']=round($_POST['spread_comp'],1);
		$string_find="comp_dens=".$spread_cdens;
		$string_replace="comp_dens=".$_POST['spread_comp'];
		//setIntoFile($myFile_spread, $string_find, $string_replace);
		$spread_cdens=$_POST['spread_comp'];
	}


	?>
<table cellpadding=0" cellspacing="0" border="0" width="100%">
<tr><td align="center"><?php echo _TIME_MIN;?></td><td align="center"><?php echo _TIMESTEP_MIN;?></td></tr>
<tr><td align="center"><input type="text" size="3" autocomplete="off" name="spread_vrijeme" value="<?php echo $spread_lag?>"></td><td align="center"><input type="text" size="3" autocomplete="off" name="spread_korak" value="<?php echo $spread_step?>"></td></tr>
</table>
<!--
<div style="float:left" >Vrijeme=<input type="text" size="3" autocomplete="off" name="spread_vrijeme" value="<?php echo $spread_lag?>">min</div>
<div style="float:right">Korak=<input type="text" size="3" autocomplete="off" name="spread_korak" value="<?php echo $spread_step?>">min<br /></div><br/>
-->
</div>
<table cellpadding=0" cellspacing="0" border="0" width="90%" align="center">
<tr><td align="left"> &nbsp;&nbsp;&nbsp;&nbsp;Brzina</td><td align="right">Kvaliteta</td></tr></table>
<div style="margin-left:25%; width:50%">
<!--<div style="float:left" >Brzina</div>
<div style="float:right">Kvaliteta</div>
<br />-->
<input name="slider_value" id="slider_value" type="hidden" size="3" value="<?php echo $_POST['slider_value'];?>">
<div  style="text-align:left;">
<script language="JavaScript">
	var A_TPL = {
		'b_vertical' : false,
		'b_watch': true,
		'n_controlWidth': 150,
		'n_controlHeight': 14,
		'n_sliderWidth': 15,
		'n_sliderHeight': 16,
		'n_pathLeft' : 1,
		'n_pathTop' : 1,
		'n_pathLength' : 130,
		's_imgControl': './slider/img/slider4bg.gif',
		's_imgSlider': './slider/img/sldr1v_sl.gif',
		'n_zIndex': 1
	}
	var A_INIT = {
		's_form' : 0,
		's_name': 'slider_value',
		'n_minValue' : 1,
		'n_maxValue' : 20,
		'n_value' : 20,
		'n_step' : 1
	}

	new slider(A_INIT, A_TPL);
</script>
</div>
</div>

</td><td width=30% style="vertical-align: top">

<?php
}
?>