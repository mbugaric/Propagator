<?php
//ini_set('display_errors','On');
?>

<?php

/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

/*ini_set('max_input_time', 60);
ini_set('max_execution_time', 60);
sleep(45);

//echo ini_get('max_execution_time');
echo '<script>alert("radi");</script>';

*/
session_start();
include_once("db_functions.php");
include_once("postavke_dir_gis.php");
//Samo ukoliko je user uspješno logiran
if($korisnik!="")
{
	include_once("gis_functions.php");
	require("pozar.php");
	require("rosanddelete.php");
	require("rosUpdate.php");
	require("settings.php");
	require("generateFuelModels.php");
	require("getInfo.php");
	require("./js/sajax-0.12/php/Sajax.php");
	//SAJAX sluzi za pozivanje PHP funkcija putem AJAX-a
	sajax_init();
	sajax_export("fire2");
	sajax_export("priorSettings2");
	sajax_export("changeSettings2");
	sajax_export("updateDefaultView");
	sajax_export("calculateROS2");
	sajax_export("eRealTime");
	sajax_export("getRTrangeFromFile");
	sajax_export("needToCalculateROS");
	sajax_export("insertValueToCalculateROS");
	sajax_export("generateScriptForDefaultModels");
	sajax_export("generateScriptForCustomModels");
	sajax_export("checkIfDefaultFuelModelVectorsExist");
	sajax_export("checkIfCustomFuelModelVectorsExist");
	sajax_export("killStartedSimulation");
	sajax_export("checkIfStillRunningAnySimulations");
	sajax_export("checkIfStillRunningFuelPreparation");
	sajax_export("checkIfMeteoDataStillRunning");
	sajax_export("checkIfFireExistsWithoutRandAndWithoutGRASS");
	sajax_export("updateLanguageInDbForUser");
	sajax_export("getInfo");
	sajax_handle_client_request();
	
?>
	<head>
		<!-- Uključivanje zaglavlja, meta podaci i postavke_dir_gis uključeni unutar headera -->
		<?php include_once("header.php");?>


		
		<link rel="stylesheet" href="./css/google.css" type="text/css" />
		<link rel="stylesheet" href="./css/style.css" type="text/css" />
		<link rel="stylesheet" href="./css/jquery.contextmenu.css" type="text/css" />
		<link rel="stylesheet" href="./css/mixitup_gis.css" type="text/css">
		
		
		<script type="text/javascript" src="./js/jquery-1.11.0.min.js"></script>
		<script src="./js/jquery-ui.min.js" language="JavaScript"></script>
		<script src="./js/ucitavanje_stranica.js"></script>

		
		<!--<script src="./js/OpenLayers.js"></script>-->
		<script src="./js/OpenLayers_Fixed.js"></script>
		<script src="./js/ScaleBar.js" language="JavaScript"></script>
		<script src="./js/wz_jsgraphics.js" language="JavaScript"></script>
		<script src="./js/jquery.contextmenu.js" language="JavaScript"></script>
		<script src="./js/jquery.qtip.min.js" language="JavaScript"></script>
		<script src="./js/sweetalert.min.js" language="JavaScript"></script>
		<!--<script src="http://maps.google.com/maps/api/js?v=3.5&amp;sensor=false"></script>-->
		<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script src="./js/mixitup-master/build/jquery.mixitup.min.js"></script>
		<script src="./js/jquery.alphanum.js"></script>
		
		<link rel="stylesheet" href="./css/google.css" type="text/css" />
		<link rel="stylesheet" href="./css/style.css" type="text/css" />
		<link rel="stylesheet" href="./css/jquery.contextmenu.css" type="text/css" />
		<link rel="stylesheet" href="./css/jquery.qtip.min.css" type="text/css" />
		<link rel="stylesheet" href="./css/sweetalert.css" type="text/css" />

		<?php 
			// Uključen realtime preko postavki?
			if(isset($_POST["realTimeCheckbox"]))
			{
				$_POST["realTimeCheckbox"]=1;
			}
			else
			{
				$_POST["realTimeCheckbox"]=0;
			}
			

			include_once("gis_popups.php"); 
			
			
			
			
			
			//Define fuel parameters file
			
			/*$filename=$WebDir."/user_files/$korisnik/chosenFuelParameters.txt";
			$fh2 = fopen($filename, 'r') or die("can't open file");
			$chosenFuelParameters = fread($fh2, filesize($filename));
			fclose($fh2);
			
			if($enableFuelParameters && $chosenFuelParameters=="Albini")
				$external_param_file=$WebDir."/user_files/$korisnik/$fuelParametersFileAlbini"; 						//External parameters file; measurements of 13 fuel models
			else if($enableFuelParameters && $chosenFuelParameters=="Scott")
				$external_param_file=$WebDir."/user_files/$korisnik/$fuelParametersFileScott"; 						//External parameters file; measurements of 40 fuel models
			else
				$external_param_file="";*/
			

			?>


			
			
			

		<script>
		
			
		
			if(location.protocol == "https:")
			{
				var BaseURL = "https://<?php echo $ip_https ?>/cgi-bin/mapserv?map=<?php echo $mapfile;?>&FORMAT=image%2Fpng&";
				var BaseURLRealtime = "https://<?php echo $ip_https ?>/cgi-bin/mapserv?map=<?php echo $map_file_user_realtime;?>&FORMAT=image%2Fpng&";
			}
			else
			{
				var BaseURL = "http://<?php echo $ip_servera ?>/cgi-bin/mapserv?map=<?php echo $mapfile;?>&FORMAT=image%2Fpng&";
				var BaseURLRealtime = "http://<?php echo $ip_servera ?>/cgi-bin/mapserv?map=<?php echo $map_file_user_realtime;?>&FORMAT=image%2Fpng&";
			}
			
			
			//Radi problema sa CSS-om popupa
			OpenLayers.Popup.MyFramedCloudPopupClass =
			OpenLayers.Class(OpenLayers.Popup.FramedCloud, {
				'contentDisplayClass': ' myOwnStyleForFramedCloudPopupContent'
			});
		</script>


		<!-- Openlayers računanje udaljenosti i povrina -->
		<?php include_once("ol_measure.php") ?>

		<!-- Openlayers slojevi -->
		<?php include_once("ol_default.php") ?>




		<script>
		var map;
		// Realtime varijable, funkcije i metode služe za animirani prikaz razvoja požara
		var showRealtime=<?php echo $_POST["realTimeCheckbox"]; ?>;
		//s ovime se moze iskljuciti funkcionalnost Realtime, samo postavit u enableREALTIME=0;
		var enableREALTIME=<?php echo $_POST["realTimeCheckbox"]; ?>;
		//step se odnosi na realtime korake (svako koliko minuta će se napraviti frame za animiranje realtime-a
		//var step=20;
		
		//alert(enableREALTIME);
		
		var clickControl;
		
		/*//Privremeno
		var chosenFuelModel="";
		var chosenIgnition="";
		var modelNameShort="";
		var ignitionShort="";*/
		
		var WebDir, rastForRegion, MonImgName, max_resolution;
		
		var isRunning=0;
		var forceDisableIsRunning=0;
		var isROScalculated=1;
		var context_menu_one;
		var TextDisplayCoord="0";
		var waitForExecution=false;
		jQuery('#inProgress').hide();


		if(enableREALTIME)
		{
			//Realtime pozari
			var allRealTimeloaded = new Array();
			var RTpozar = new Array();
			var numberOfRealTimers=10;
			var isRTready=0;
		}

		

		//provjerava izvrsava li se nesto u pozadini (ili simulacija, ili racunanje ROS-a), i ako zakljuci da je onda prikazuje animirani krug
		setInterval(function() {
		if(isRunning)
		{
			jQuery('#inProgress').fadeTo(1000,1.0);
			spread_raster.mergeNewParams({'foo': Math.random()});
			spread_vector.mergeNewParams({'foo': Math.random()});
			hoverControl.deactivate();
			jQuery('#getInfo').fadeTo(1000,0.5);
		}
		else
		{
			//jQuery('#inProgress').fadeOut(1000);
			//alert("Sad bi se ugasilo");
			/*if(!forceDisableIsRunning)
			{
				forceDisableIsRunning=0;
				setTimeout(callback(), 6000);				
			}
			forceDisableIsRunning=0;*/
			
			setTimeout(callback(), 2000);
			
			
			
		}
		
		
		function callback(){
			return function(){
				
				if(!isRunning && jQuery('#inProgress').is(":visible"))
				{
					//alert("gasi se");
					jQuery('#inProgress').fadeOut(1000);
					jQuery('#isRunningText').text("<?php echo _GIS_RUNNING?>");
					$("#inProgress").css("width", parseFloat(90) + parseFloat( $("#isRunningText").css("width")));
					hoverControl.activate();
					jQuery('#getInfo').fadeTo(1000,0.9);
				}
			}
		}
		}, 5000)
		
		setInterval(function() {	
			var kvbr=Math.floor(spread_sliderValue/20*100);
			
			
			
			if(chosenFuelModel=="Albini_custom")
				modelNameShort="<?php echo _GIS_MODEL_SHORT_ALBINI_CSTM?>";
			else if(chosenFuelModel=="Scott_custom")
				modelNameShort="<?php echo _GIS_MODEL_SHORT_SCOTT_CSTM?>";
			else if(chosenFuelModel=="Albini_default")
				modelNameShort="<?php echo _GIS_MODEL_SHORT_ALBINI_DFLT?>";
			else if(chosenFuelModel=="Scott_default")	
				modelNameShort="<?php echo _GIS_MODEL_SHORT_SCOTT_DFLT?>";
			
			if(chosenIgnition=="pointIgnition")
			{
				ignitionShort="<?php echo _GIS_POINT_IGNITION ?>";
			}
			else if(chosenIgnition=="perimeterIgnition")
			{
				ignitionShort="<?php echo _GIS_PERIMETER_IGNITION_SHORT ?>";
			}
		
			
			jQuery('#settingstip').html("<?php echo _GIS_VRIJEME ?>: "+spread_lag+" min&nbsp;&nbsp;&nbsp;&nbsp; <br /><?php echo _GIS_KORAK ?>: "+spread_step+" min<br /><?php echo _GIS_QUA_SPEED ?>: "+kvbr+"%<br /><?php echo _GIS_CHOSEN_FUEL_MODEL_SHORT ?>: "+modelNameShort+"<br /><?php echo _GIS_IGNITION_TYPE ?>: "+ignitionShort);
		}, 1000)


		//Realtime prikaz, 1fps (1000ms)
		if(enableREALTIME)
		{
			setInterval(function() {
				temp=0;
				for(rtcnt=0;rtcnt<numberOfRealTimers;rtcnt++)
				{			
					temp+=RTpozar[rtcnt].numLoadingTiles;

					RTpozar[rtcnt].setVisibility(false);
					RTpozar[rtcnt].setOpacity(0.000);			
				}

				temp=spread_raster.numLoadingTiles;

				isRTready++;
				if(isRTready>numberOfRealTimers)
				{
					isRTready=1;
				}
					if(showRealtime)
					{
						RTpozar[isRTready].mergeNewParams({'random':Math.random()});
						RTpozar[isRTready].setVisibility(true);
						RTpozar[isRTready].setOpacity(0.900);
					}

			}, 3000)
		}

		
		
		
		//Postavke
		var spread_lag;
		var spread_step;
		var spread_cdens;
		var spread_res;
		var spread_comp;
		var spread_sliderValue;
		



		//Poneke PHP varijable se moraju prebaciti u JS varijable radi sajax-a
		WebDir = "<?php echo $WebDir; ?>" ;
		WebDirGisData = "<?php echo $WebDirGisData; ?>" ;
		grassmapset = "<?php echo $mapset; ?>" ;
		rastForRegion = "<?php echo $rastForRegion; ?>";
		rastForAspect = "<?php echo $rastForAspect; ?>";
		rastForSlope = "<?php echo $rastForSlope; ?>";
		rastForModel = "";
		rastForModelAlbini="<?php echo $rastForModelAlbini; ?>";
		rastForModelScott="<?php echo $rastForModelScott; ?>";
		external_param_file = "";
		external_param_file_AlbiniCustom="<?php echo $fuelParametersFileAlbini; ?>";
		external_param_file_ScottCustom="<?php echo $fuelParametersFileScott; ?>";
		external_param_file_AlbiniDefault="<?php echo $fuelParametersFileAlbiniDefault; ?>";
		external_param_file_ScottDefault="<?php echo $fuelParametersFileScottDefault; ?>";		
		MonImgName = "<?php echo $MonImgName; ?>";
		max_resolution = "<?php echo $max_resolution; ?>";
		korisnik = "<?php echo $korisnik; ?>";
		corine = "<?php echo $corine; ?>";
		corineRulesFilenameAlbini = '<?php echo "$WebDir/user_files/$korisnik/$corineRulesFilenameAlbini"; ?>';
		corineRulesFilenameScott = '<?php echo "$WebDir/user_files/$korisnik/$corineRulesFilenameScott"; ?>';
		corineRulesFilenameAlbiniDefault = '<?php echo "$WebDir/files/$corineRulesFilenameAlbini"; ?>';
		corineRulesFilenameScottDefault = '<?php echo "$WebDir/files/$corineRulesFilenameScott"; ?>';
		corineRulesNewForCustomFuelMaps = '<?php echo "$WebDir/user_files/$korisnik/$corineRulesNewForCustomFuelMaps"; ?>';
		corineAttributeName = "<?php echo $corineAttributeName; ?>";
		customFuelMapsAttributeName = "<?php echo $customFuelMapsAttributeName; ?>";
		meteoArchiveDir = "<?php echo $meteoArchiveDir; ?>";
		calculate_ROS_enabled = "<?php echo $calculate_ROS_enabled; ?>";
		
	
		<?php
		sajax_show_javascript();
		?>
		

		//
		
		
		
		
		function doAfterCheckIfDefaultFuelModelVectorsExist(result)
		{
			
			//fuels need to be recalculated
			//Uncomment this to force fuel recalculation
			//result=false;
			
			
			if(result==false)
			{
				swal({
					title: "<?php echo _GIS_ARESURE; ?>",
					text: "<?php echo _GIS_FUEL_DIALOG_DEFAULT; ?>",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "<?php echo _GIS_OK; ?>",
					cancelButtonText: "<?php echo _GIS_CANCEL; ?>",
					closeOnConfirm: true,
					closeOnCancel: true 
					}, function(isConfirm){
						if (isConfirm) {
								isRunning=1;
								//alert(context_menu_one);
								context_menu_one[2]["<?php echo _GIS_TRENUTNA_SIMULACIJA;?>"].disabled=true;
								//context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=true;
								x_generateScriptForDefaultModels(WebDir, korisnik, rastForModelAlbini, rastForModelScott, corine, corine, corineRulesFilenameAlbiniDefault, corineRulesFilenameScottDefault, corineAttributeName, grassmapset, WebDirGisData, function(){});
							} 
					});
				
				
				/*if (confirm('<?php echo _GIS_FUEL_DIALOG_DEFAULT; ?>'))
				{
					isRunning=1;
					//alert(context_menu_one);
					context_menu_one[2]["<?php echo _GIS_TRENUTNA_SIMULACIJA;?>"].disabled=true;
					//context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=true;
					x_generateScriptForDefaultModels(WebDir, korisnik, rastForModelAlbini, rastForModelScott, corine, corine, corineRulesFilenameAlbiniDefault, corineRulesFilenameScottDefault, corineAttributeName, grassmapset, WebDirGisData, function(){});

				}*/
				context_menu_one[2]["<?php echo _GIS_TRENUTNA_SIMULACIJA;?>"].disabled=true;
				//context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=true;
			}
			else{
				context_menu_one[2]["<?php echo _GIS_TRENUTNA_SIMULACIJA;?>"].disabled=false;
				//context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=false;
			}
			
			
			//check if custom fuel models need to be regenerated
			x_checkIfCustomFuelModelVectorsExist(WebDir, korisnik, rastForModelAlbini, rastForModelScott, doAfterCheckIfCustomFuelModelVectorsExist);

		}
		
		
		
		function doAfterCheckIfCustomFuelModelVectorsExist(result)
		{
			//alert(result)
			//fuels need to be recalculated
			//Uncomment this to force fuel recalculation
			//result=false;
			
			
			if(result==false)
			{
				
				
				x_checkIfStillRunningFuelPreparation(korisnik, function(result){
				  
				  if(result)
				  {
					alert('<?php echo _GIS_FUEL_STILL_RUNNING ?>');
				  }
				  else
				  {
					  swal({
							title: "<?php echo _GIS_ARESURE; ?>",
							text: "<?php echo _GIS_FUEL_DIALOG; ?>",
							type: "warning",
							showCancelButton: true,
							confirmButtonColor: "#DD6B55",
							confirmButtonText: "<?php echo _GIS_OK; ?>",
							cancelButtonText: "<?php echo _GIS_CANCEL; ?>",
							closeOnConfirm: true,
							closeOnCancel: true 
							}, function(isConfirm){
								if (isConfirm) {
										isRunning=1;
										//alert(context_menu_one);
										//context_menu_one[2]["<?php echo _GIS_TRENUTNA_SIMULACIJA;?>"].disabled=true;
										//context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=true;
										x_generateScriptForCustomModels(WebDir, korisnik, rastForModelAlbini, rastForModelScott, corineRulesFilenameAlbini, corineRulesFilenameScott, corineRulesNewForCustomFuelMaps, customFuelMapsAttributeName, rastForRegion, grassmapset, WebDirGisData, doAfterFuelModelsGenerated);

									} 
							});
					  
					   /* if (confirm('<?php echo _GIS_FUEL_DIALOG; ?>'))
						{
							isRunning=1;
							//alert(context_menu_one);
							//context_menu_one[2]["<?php echo _GIS_TRENUTNA_SIMULACIJA;?>"].disabled=true;
							//context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=true;
							x_generateScriptForCustomModels(WebDir, korisnik, rastForModelAlbini, rastForModelScott, corineRulesFilenameAlbini, corineRulesFilenameScott, customFuelMapsAttributeName, rastForRegion, grassmapset, WebDirGisData, doAfterFuelModelsGenerated);

						}*/
						//context_menu_one[2]["<?php echo _GIS_TRENUTNA_SIMULACIJA;?>"].disabled=true;
						//context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=true;
				  }
				});
				
					
			}
			else{
				//context_menu_one[2]["<?php echo _GIS_TRENUTNA_SIMULACIJA;?>"].disabled=false;
				//context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=false;
			}
		}
		
		
		
		function doAfterFuelModelsGenerated(z)
		{
			isRunning=0;
			context_menu_one[2]["<?php echo _GIS_TRENUTNA_SIMULACIJA;?>"].disabled=false;
			context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=false;
			//alert(context_menu_one);
		}

		</script>
		<!-- Openlayers slojevi -->
		<?php include_once("gis_layers.php") ?>
		
		<script>
		//Opcenito za sajax vrijedi da je ovaj z u biti ono sto php funkcija vrati, a funkcije oblika do_xxx se pozovu kad xxx zavrsi, ipak ovo je samo princip ne mora imenovanje nuzno bit takvo	
		function do_afterFire(z) {
			//alert("Kraj");
			//isRunning=0;
			//jQuery('#inProgress').fadeTo(1000, 0.01);
			spread_raster.mergeNewParams({'foo': Math.random()});
			spread_vector.mergeNewParams({'foo': Math.random()});
			if(enableREALTIME) 
			{
				x_eRealTime(WebDir, korisnik, spread_step,  do_afterRealTime);
				//alert("realtime");
			}
		}


		function do_afterRealTime(z)
		{
			//il treba procitat kolko je realtime frameova iz filea, ili nakon simulacije prominit taj broj... ovdje je rijec o slucaju kad minjamo broj
			numberOfRealTimers=z;
		}

		//a ovdje je rijec o dohvatu iz file-a
		function do_aftergetRTrangeFromFile(z)
		{
			numberOfRealTimers=z;
				//Realtime rasteri

				for(brojacRT=0;brojacRT<numberOfRealTimers;brojacRT++)
				{
					RTpozar[brojacRT] = new OpenLayers.Layer.WMS(
						"x"+brojacRT,
						BaseURLRealtime,
						{'layers': 'Pozar'+brojacRT},
						{
							ingleTile: true,
							format: 'image/png','opacity': 0.9, 'transparent': true, 
							'isBaseLayer': false
						}
					);


					RTpozar[brojacRT].opacity=0.9;
					RTpozar[brojacRT].displayInLayerSwitcher=false;


					RTpozar[brojacRT].events.register("loadend", RTpozar[brojacRT], function() {
						allRealTimeloaded[brojacRT]=1;});
					RTpozar[brojacRT].events.register("loadstart", RTpozar[brojacRT], function() {
						allRealTimeloaded[brojacRT]=0;});

					map.addLayers([RTpozar[brojacRT]]);

				}
		}


		//Postavke return values = z
		function do_afterPriorSettings(z) {
				var values=z.split(" ");
				spread_lag = values[0];
				spread_step = values[1];
				spread_cdens = values[2];
				spread_res = values[3];
				spread_sliderValue= values[4];
				chosenFuelModel=values[5];
				chosenIgnition=values[6];

		}
		
		function makeAllCustomROSRed()
		{
			x_insertValueToCalculateROS(WebDir, korisnik, 1, "Albini_custom", function(){});
			x_insertValueToCalculateROS(WebDir, korisnik, 1, "Scott_custom", function(){});
			x_insertValueToCalculateROS(WebDir, korisnik, 1, "Albini_default", function(){});
			x_insertValueToCalculateROS(WebDir, korisnik, 1, "Scott_default", function(){});
		}
		

		function do_afterROScalculation(z) {
			isROScalculated=1;
			//isRunning=0;
			//context_menu_one.items[3].enabled=true;
			context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=false;
			
			//Upisati 0 u toCalculateROS
			x_insertValueToCalculateROS(WebDir, korisnik, 0, chosenFuelModel, function(){});
			
			//Vidjeti treba li zacrvenjeti ROS
			x_needToCalculateROS(WebDir, korisnik, chosenFuelModel, doAfterneedToCalculateROS);
		}
		
		
		function prepareModelAndParamFileData()
		{
			if(chosenFuelModel=="Albini_custom")
			{
				external_param_file=external_param_file_AlbiniCustom;
				rastForModel=rastForModelAlbini;
			}
			else if (chosenFuelModel=="Scott_custom")
			{
				external_param_file=external_param_file_ScottCustom;
				rastForModel=rastForModelScott;
			}
			else if (chosenFuelModel=="Albini_default")
			{
				external_param_file=external_param_file_AlbiniDefault;
				rastForModel=rastForModelAlbini;
			}
			else if (chosenFuelModel=="Scott_default")
			{
				external_param_file=external_param_file_ScottDefault;
				rastForModel=rastForModelScott;
			}
		}
		
		
		function calculateROSJS()
		{
			if(calculate_ROS_enabled)
			{
				prepareModelAndParamFileData();		
				
				var barriers=getListOfPointsForFireBarrier();

			
				//alert("asd "+rastForModel+" "+external_param_file+" " +chosenFuelModel);
				x_calculateROS2(WebDir, korisnik, rastForRegion, rastForAspect, rastForSlope, rastForModel, grassmapset, external_param_file, chosenFuelModel, barriers ,do_afterROScalculation);		
				isRunning=1;
				isROScalculated=0;
				//context_menu_one.items[3].enabled=false;
				context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=true;
			}
		}
		

		// Nakon izvođenja changeSettings2
			function do_afterSettingsChange(z) {
		}
		
		 //alert(WebDir+" "+rastForRegion+" "+max_resolution+" "+korisnik);
		 x_priorSettings2(WebDir, rastForRegion ,max_resolution, korisnik, do_afterPriorSettings); 
		

		

		function do_startFire(coodr1,coodr2, type) {
			// get the folder name
			
			//alert("start");

			var perimeters=getListOfPointsForFirePerimeter();
			//alert(perimeters);
			//fire($map,$WebDir,$rastForRegion,$MonImgName, $max_resolution, $korisnik);
			isRunning=1;
			
			//Prepare rastForModel
			prepareModelAndParamFileData();	
			
			var barriers=getListOfPointsForFireBarrier();
			
			//alert(WebDir + " " +rastForRegion + " " +MonImgName + " " +max_resolution + " " +korisnik + " " +coodr1 + " " +coodr2 + " " +type + " " +spread_lag + " " +spread_sliderValue + " " +spread_cdens + " " +step + " " +grassmapset + " " +chosenFuelModel + " perimeters: " +perimeters + " chosen: " +chosenIgnition);
			
			
			
			//Prilikom postavljanja novog servera, cesto ne radi x_fire2 jer nije osposobljen mapscript
			x_checkIfStillRunningAnySimulations(korisnik, function(result){
				if(result==1)
				{
					alert('<?php echo _GIS_PREVIOUSSIMSERROR; ?>');
				}
				else
				{
					
					isRunning=1;
					x_fire2(WebDir, rastForRegion, MonImgName, max_resolution, korisnik, coodr1, coodr2, type, spread_lag, spread_sliderValue, spread_cdens, spread_step, grassmapset, chosenFuelModel, perimeters, chosenIgnition, waitForExecution, meteoArchiveDir, external_param_file_AlbiniDefault, external_param_file_ScottDefault, external_param_file_AlbiniCustom, external_param_file_ScottCustom, barriers, calculate_ROS_enabled, rastForModel, rastForAspect, rastForSlope, do_afterFire);
					isRunning=1;
				}
			});
		}
		

		
		
		function doAfterneedToCalculateROS(result)
		{
			if(calculate_ROS_enabled)
			{
				if(result==1)
					$('#rosSpan').css("color","red");
				else
					$('#rosSpan').css("color","black");
			}
		}
		
		
		function recalculateCustomFuelMaps()
		{
			
				swal({
					title: "Are you sure?",
					text: "<?php echo _GIS_FUEL_DIALOG_MANUAL; ?>",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "<?php echo _GIS_OK; ?>",
					cancelButtonText: "<?php echo _GIS_CANCEL; ?>",
					closeOnConfirm: true,
					closeOnCancel: true 
					}, function(isConfirm){
						if (isConfirm) {
								isRunning=1;
								//alert(context_menu_one);
								//context_menu_one[2]["<?php echo _GIS_TRENUTNA_SIMULACIJA;?>"].disabled=true;
								context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=true;
								x_generateScriptForCustomModels(WebDir, korisnik, rastForModelAlbini, rastForModelScott, corineRulesFilenameAlbini, corineRulesFilenameScott, corineRulesNewForCustomFuelMaps, customFuelMapsAttributeName, rastForRegion, grassmapset,  WebDirGisData, doAfterFuelModelsGenerated);

							} 
					});
			
			context_menu_one[3]["<?php echo _GIS_VLASTITA_SIMULACIJA;?>"].disabled=true;
		}
		
		
		</script>



		<?php

		$Wind_dirAsc="./user_files/$korisnik/wind_dir.asc"; 		/////
		$Wind_speedAsc="./user_files/$korisnik/wind_speed.asc";		/////

		$Wind_dir_default_Asc="./files/wind_dir.asc"; 		/////
		$Wind_speed_default_Asc="./files/wind_speed.asc";		/////


		//priprema svih datoteka za pojedinog useraa
		prepareAllUserData($WebDir, $WebDirGisData, $korisnik, $grasslocation, $mapset, $map_file_user, $map_file_userdefault, $WebDir_gisrc, $grassexecutable, $rastForRegion, $currentMeteoArchiveDir, $meteoArchiveDir, $vjetarWMSDir, $linuxUser, $rastForAspect, $rastForSlope);


		?>
		
		
		
		
		<script type="text/javascript">
		
		function roundNumber(num, dec) {
			var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
			return result;
		}

		var latlonMER;
		var contextLat, contextLon;
		var latlonLat, latlonLon;
		function handleMapClick(evt) {
			
	
			if(evt.which==3)
			{
				
				var latlonMER = map.getLonLatFromViewPortPx(evt.xy);
				var EPSG4326 = new OpenLayers.Projection("EPSG:4326");
				var EPSG900913 = new OpenLayers.Projection("EPSG:900913");
				latlon = latlonMER.transform(EPSG900913, EPSG4326);
				contextLat = latlon.lat;
				contextLon = latlon.lon;
				latlonLat = latlon.lat;
				latlonLon = latlon.lon;
				
			
				
				//context_menu_one.items[0].label = "<?php echo _GIS_KOORDINATE_TOCKE;?><br \>&nbsp;&nbsp;&nbsp;&nbsp;" + roundNumber(latlon.lat,2) + "<?php echo _GIS_KOORDINATE_SJEVER;?> &nbsp;&nbsp;" + roundNumber(latlon.lon,2) + "<?php echo _GIS_KOORDINATE_ISTOK;?> ";
				TextDisplayCoord="<?php echo _GIS_KOORDINATE_TOCKE;?><br \>&nbsp;&nbsp;&nbsp;&nbsp;" + roundNumber(latlon.lat,2) + "<?php echo _GIS_KOORDINATE_SJEVER;?> &nbsp;&nbsp;" + roundNumber(latlon.lon,2) + "<?php echo _GIS_KOORDINATE_ISTOK;?> ";
			
				 typewatch(function () {
					if(!$('.context-menu').is(":visible"))
					{
						$('.context-menu').show();
						$('.context-menu-shadow').show();				
					}
				  }, 150);
				
			}						
		} 
		
		var typewatch = (function(){
		  var timer = 0;
		  return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		  };
		})();

		OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {

			defaultHandlerOptions: {
				'single': true,
				'double': true,
				'pixelTolerance': 0,
				'stopSingle': false,
				'stopDouble': true
			},

			initialize: function(options) {
				this.handlerOptions = OpenLayers.Util.extend(
					{}, this.defaultHandlerOptions
				);
				OpenLayers.Control.prototype.initialize.apply(
					this, arguments
				); 
				this.handler = new OpenLayers.Handler.Click(
					this, {
						'click': this.onClick,
						'dblclick': this.onDblclick 
					}, this.handlerOptions
				);
			},
			onClick: function(event) {
				//alert("single click");
				if($('.context-menu').is(":visible"))
				{
					$('.context-menu').hide();
					$('.context-menu-shadow').hide();
				}
			},
			onDblclick: function(event) {  
				//alert("double click");
				drawControls.polygon.finishSketch();
				drawControls.polygon.deactivate();
				
			}   
		});
		
		OpenLayers.Control.ClickPerimeter = OpenLayers.Class(OpenLayers.Control, {

			defaultHandlerOptions: {
				'single': false,
				'double': true,
				'pixelTolerance': 0,
				'stopSingle': false,
				'stopDouble': true
			},

			initialize: function(options) {
				this.handlerOptions = OpenLayers.Util.extend(
					{}, this.defaultHandlerOptions
				);
				OpenLayers.Control.prototype.initialize.apply(
					this, arguments
				); 
				this.handler = new OpenLayers.Handler.Click(
					this, {
						'click': this.onClick,
						'dblclick': this.onDblclick 
					}, this.handlerOptions
				);
			},
			onClick: function(event) {
				//alert("single click");
			},
			onDblclick: function(event) {  
				//alert("double click");
				drawControlsPerimeter.polygon.finishSketch();
				drawControlsPerimeter.polygon.deactivate();
				
			}   
		});

		//Glavna funkcija
			function init(){
				
			/*	//opcije za map
				var options = {
				div: "map",
				projection: new OpenLayers.Projection("EPSG:900913"),
				displayProjection: new OpenLayers.Projection("EPSG:900913"),
				units: "m",
				numZoomLevels: 16,
				maxResolution: 16543.0339,
				maxExtent: new OpenLayers.Bounds(13.00, 40.00, 19.1, 46.52).transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913")) //Ovdje se samo odreduju krajnje granice, extent se postavlja kasnije
				
			};
				
				map = new OpenLayers.Map('map', options);*/
				
				
				
				var panel = createPanel(5,400);
				map=createMap("map", panel);
				addDefinedLayers();

				if(enableREALTIME)
				{
					//Poziva se ovdje da bi imali pristup "map"
					x_getRTrangeFromFile(WebDir, korisnik, do_aftergetRTrangeFromFile);
				}
				
				
				//document.onmousedown=handleMapClick;
				map.events.register('mousedown', map, handleMapClick); 
				
				context_menu_one = [
				{'0':{
				  onclick:function(menuItem,menu) { alert("You clicked me!"); },
				  className:'context_menu_one-alert-item',
				  //hoverClassName:'context_menu_one-custom-item-hover',
				  //title:'This is the hover title',
				  disabled:true
				}
			  },
			  {'-------------------- <?php echo _GIS_SIMULACIJA;?>':{
				  onclick:function(menuItem,menu) {  },
				  //icon:'delete_icon.gif',
				  disabled:true
				}
			  },
			  {'<?php echo _GIS_TRENUTNA_SIMULACIJA;?>':{
				  onclick:function(menuItem,menu) { 
						hoverControl.deactivate();
						x_checkIfMeteoDataStillRunning(korisnik, function(result){
					  if(result==0)
					  {
						  do_startFire(latlonLat,latlonLon, 1);
					  }
					  else
					  {
						  alert('<?php echo _GIS_PREVIOUSMETEOCALCSERROR;?>');
					  }
					  }); 
					},
				  icon:'./css/PropagatorIcons/fire.png',
				  disabled:false
				}
			  },
			  {'<?php echo _GIS_VLASTITA_SIMULACIJA;?>':{
				  onclick:function(menuItem,menu) { 
					hoverControl.deactivate();
					x_checkIfMeteoDataStillRunning(korisnik, function(result){
					  
					  if(result==0)
					  {
						  do_startFire(latlonLat,latlonLon, 2);
					  }
					  else
					  {
						  alert('<?php echo _GIS_PREVIOUSMETEOCALCSERROR;?>');
					  }
					  }); 
					},
				   icon:'./css/PropagatorIcons/fire--pencil.png',
				  disabled:false
				}
			  },		  
			  {'---------------------<?php echo _GIS_POSTAVKE_S;?>':{
				  onclick:function(menuItem,menu) {  },
				  //icon:'delete_icon.gif',
				  disabled:true
				}
			  },
			  {'<?php echo _GIS_POSTAVKE_SIMULACIJE;?>':{
				  onclick:function(menuItem,menu) { addSettingsPopup(latlonLat,latlonLon); },
				  icon:'./css/PropagatorIcons/gear.png',
				  disabled:false
				}
			  },
			  {'<?php echo _GIS_VLASTITI_PARAM_VJETAR;?>':{
				  onclick:function(menuItem,menu) { x_checkIfMeteoDataStillRunning(korisnik, function(result){
				  if(result==0)
				  {
					window.open("vjetar_popup.php?kor="+korisnik,"Vjetar","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=500, height=520");
				  }
				  else
				  {
					  alert('<?php echo _GIS_PREVIOUSCALCSERROR;?>');
				  }
				}); },
				   icon:'./css/PropagatorIcons/weather-wind.png',
				  disabled:false
				}
			  },
			  {'<?php echo _GIS_VLASTITI_PARAM_VLAGA;?>':{
				  onclick:function(menuItem,menu) { x_checkIfMeteoDataStillRunning(korisnik, function(result){
				  if(result==0)
				  {
					window.open("vlaga_popup.php?kor="+korisnik,"Vlaga","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=500, height=520"); 
				  }
				  else
				  {
					   alert('<?php echo _GIS_PREVIOUSCALCSERROR;?>');
				  }
				}); },
				  icon:'./css/PropagatorIcons/water.png',
				  disabled:false
				}
			  },
			  {'<?php echo _GIS_KONTROLA_PROZIRNOSTI_SLOJEVA;?>':{
				  onclick:function(menuItem,menu) { addOpacityPopup(map); },
				  icon:'./css/PropagatorIcons/maps-stack.png',
				  disabled:false
				}
			  },
			  {'---------------------------------':{
				  onclick:function(menuItem,menu) { },
				  //icon:'delete_icon.gif',
				  disabled:true
				}
			  },
			  {'<?php echo _GIS_PARAMETRI_GORIVA;?>':{
				  onclick:function(menuItem,menu) {window.open("fuel_popup.php?kor="+korisnik,"Fuel","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, height=" + screen.height + ",width=" + screen.width); },
				  icon:'./css/PropagatorIcons/leaf-red-pencil.png',
				  disabled:true
				}
			  },
			  {'<?php echo _GIS_FUEL_MAP_MANAGE;?>':{
				  onclick:function(menuItem,menu) { x_checkIfStillRunningAnySimulations(korisnik, function(result){
				if(result==1)
				{
					alert('<?php echo _GIS_PREVIOUSSIMSERROR; ?>');
				}
				else
				{
					recalculateCustomFuelMaps()
				}
			});},
				  icon:'./css/PropagatorIcons/leaf-red.png',
				  disabled:false
				}
			  },
			  {'<span id="rosSpan"><?php echo _GIS_CALCROS_VLATITI;?><span>':{
				  onclick:function(menuItem,menu) { calculateROSJS(); },
				  icon:'./css/PropagatorIcons/thermometer--pencil.png',
				  disabled:false
				}
			  },
			  {'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo _GIS_POZARNAFRONTA_START;?>':{
				  onclick:function(menuItem,menu) { showRealtime=1; },
				  //icon:'delete_icon.gif',
				  disabled:true
				}
			  },
					  {'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo _GIS_POZARNAFRONTA_STOP;?>':{
				  onclick:function(menuItem,menu) { showRealtime=0; },
				  //icon:'delete_icon.gif',
				  disabled:true
				}
			  },
			  {'<?php echo _GIS_PARAMETRI_WIND_REDUCTION;?>':{
				  onclick:function(menuItem,menu) {window.open("wndReduction_popup.php?kor="+korisnik,"Fuel","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, height=" + screen.height + ",width=" + screen.width); },
				  icon:'./css/PropagatorIcons/windReduction.png',
				  disabled:false
				}
			  }
			];
			
			
			/*
			
						x_checkIfStillRunningAnySimulations(korisnik, function(result){
				if(result==1)
				{
					alert('<?php echo _GIS_PREVIOUSSIMSERROR; ?>');
				}
				else
				{
					x_fire2(WebDir, rastForRegion, MonImgName, max_resolution, korisnik, coodr1, coodr2, type, spread_lag, spread_sliderValue, spread_cdens, spread_step, grassmapset, chosenFuelModel, perimeters, chosenIgnition, waitForExecution, meteoArchiveDir, external_param_file_AlbiniDefault, external_param_file_ScottDefault, external_param_file_AlbiniCustom, external_param_file_ScottCustom, barriers, calculate_ROS_enabled, rastForModel, rastForAspect, rastForSlope, do_afterFire);
				}
			});
			*/
			
			//Izbaci ako nema realtime
			if(!enableREALTIME)
			{
				context_menu_one.splice(13,2);
			}
			
			if(!calculate_ROS_enabled)
			{
				context_menu_one.splice(12,1);
			}
			
			//Ukljuci fuel ako treba
			//if(external_param_file!="")
				context_menu_one[10]["<?php echo _GIS_PARAMETRI_GORIVA;?>"].disabled=false;
				
			
			
			
			$(function() {
			  $('#map').contextMenu(context_menu_one,  {
				// Ručno srediti dynamic menu
				  beforeShow: function() { 
					
					//Prvo srediti enabled/disabled
					for(br=0;br<context_menu_one.length;br++)
					{
						for( var k in context_menu_one[br])
						{
							if(context_menu_one[br][k].disabled==true)
							{
								$(this.menu).find('.context-menu-item').find('.context-menu-item-inner').each(function(){
									if($(this).html()==k)
									{
										$(this).parent().addClass("context-menu-item-disabled");
									}
								});
							}
							else
							{
								$(this.menu).find('.context-menu-item').find('.context-menu-item-inner').each(function(){
									if($(this).html()==k)
									{
										$(this).parent().removeClass("context-menu-item-disabled");
									}
								});
							}
						}
					
					}
					
					//Prvo mijenjanje coordinate alerta
					$(this.menu).find('.context_menu_one-alert-item').find('.context-menu-item-inner').html(TextDisplayCoord);
					
					
					//Vidjeti treba li zacrvenjeti ROS
					x_needToCalculateROS(WebDir, korisnik, chosenFuelModel, doAfterneedToCalculateROS);

				  }
			  } );
			  
			  

			});
			
			



				var tParams = { format: 'image/png'};
				reljef.mergeNewParams(tParams);
				trenutniWind.mergeNewParams({'foo': Math.random()});
			
				

				//map.setCenter( new OpenLayers.LonLat(16.47,43.59).transform(new OpenLayers.Projection("EPSG:4326"), map.projection),10);
				map.setCenter( new OpenLayers.LonLat(<?php echo $lon0?>,<?php echo $lat0?>).transform(new OpenLayers.Projection("EPSG:4326"), map.projection),<?php echo $zoom0?>);


				
				addDefinedSettings(map);
				addDefinedOpacity(map);
				
				
				clickControl = new OpenLayers.Control.Click();
				map.addControl(clickControl);
				clickControl.activate();
				
				clickControlPerimeter = new OpenLayers.Control.ClickPerimeter();
				map.addControl(clickControlPerimeter);
				clickControlPerimeter.activate();
				
				//Najpametnije je natjerat da se računa ROS
				makeAllCustomROSRed();
			
				//check if default fuel models need to be regenerated
				x_checkIfDefaultFuelModelVectorsExist(WebDir, korisnik, rastForModelAlbini, rastForModelScott, WebDirGisData, grassmapset, doAfterCheckIfDefaultFuelModelVectorsExist);
				
				
				//Provjer odmah je li radi ista od prije
				x_checkIfStillRunningAnySimulations(korisnik, function(result){
				  
				  isRunning=result;
				  //alert(result);
				});
				
				x_checkIfMeteoDataStillRunning(korisnik, function(result){
				  if(isRunning==0)
					isRunning=result;
				 // alert(result);
				});
				
				
				$('#palettestip').mixItUp();
				
			
			}
			
			//Broj elemenata u MixItUp na početku
			var numberOfMixDIVs=0;
			
			function mapLayerChanged(event) {
				//dodavanje i micanje paleta
				addOrDestroyMixItUpElement(Padaline, "precPalette", "<?php echo _GIS_PRECIP ?>: (mm/3h)");
				addOrDestroyMixItUpElement(MIRIP, "AFRPalette","<?php echo _GIS_MIRIP ?>");
				addOrDestroyMixItUpElement(BUI_fesb, "BUIPalette","BUI");
				addOrDestroyMixItUpElement(ISI_fesb, "ISIPalette","ISI");
				addOrDestroyMixItUpElement(DC_fesb, "DCPalette","DC");
				addOrDestroyMixItUpElement(DMC_fesb, "DMCPalette","DMC");
				addOrDestroyMixItUpElement(FFMC_fesb, "FFMCPalette","FFMC");
				addOrDestroyMixItUpElement(FWI_fesb, "FWIPalette","FWI");
				addOrDestroyMixItUpElement(EruptiveFireRisk, "eruptivePalette","<?php echo _GIS_ERUPTIVERISK ?>");
				addOrDestroyMixItUpElement(mois_liveTemp, "moisPalette","<?php echo _GIS_MOISTURE_GENERAL ?>");
				addOrDestroyMixItUpElement(mois_live_customTemp, "moisPalette","<?php echo _GIS_MOISTURE_GENERAL ?>");
				
			}
			
			
			function addOrDestroyMixItUpElement(element, id, string)
			{
				if(element.getVisibility() == true && !$("#"+id).length)
				{	
					
					if((element==mois_liveTemp && !$("#moisPalette").length) || (element==mois_live_customTemp && !$("#moisPalette").length) || (element!=mois_liveTemp && element!=mois_live_customTemp) )
					{
						if($(".mix").length<8)
						{
							
							$('#palettestip').mixItUp('destroy');
							var mixDiv = $('<div class="mix" id="'+id+'">'+string+': <img src="./icons/palletes/'+id+'.jpg" /></div>')
								.attr({ "data-myorder" : numberOfMixDIVs })
								.addClass("mix");
							$("#palettestip").append(mixDiv);
							$('#palettestip').mixItUp();
							console.log(string);
						}
					}						
				}
				else if(element.getVisibility() == false && $("#"+id).length)
				{
					if((element==mois_liveTemp && mois_live_customTemp.getVisibility() == false) || (element==mois_live_customTemp && mois_liveTemp.getVisibility() == false) || (element!=mois_liveTemp && element!=mois_live_customTemp))
					{
						$("#"+id).fadeOut(300,function(){
							$('#palettestip').mixItUp('destroy');
							$("#"+id).remove();
							$("#palettestip").append(mixDiv);
							numberOfMixDIVs++;
							$('#palettestip').mixItUp();
						});
					}
				}
			}
			
			
			
			
	//Vidljivosti za pojedniu lokaciju
			function visibility_on(lokacija)
			{
				lokacija = lokacija.replace(/^\s+|\s+$/g, '') ;
			
				if(visLayer.visibility==false)
					visLayer.setVisibility(true);
				else
					visLayer.setVisibility(false);

					visLayer.destroy();
					visLayer = new OpenLayers.Layer.WMS(
					"visLayer",
					"http://<?php echo $ip_servera ?>/cgi-bin/mapserv?map=<?php echo $mapfile;?>&FORMAT=image%2Fpng&",
					{'layers': lokacija},
					{
						format: 'image/png','opacity': 0.8, 'transparent': true, 
						'isBaseLayer': false,
						'displayInLayerSwitcher': false

					}
				);
				map.addLayers([visLayer]);
				visLayer.setZIndex(1);
				visLayer.setVisibility(true);			

			}

			function visibility_off()
			{
					visLayer.setVisibility(false);
			}

			
			function addFireBarrier()
			{
				panelZoomBox.deactivate();
				panelZoomBox.activate();
				drawControlsPerimeter.polygon.deactivate();
				drawControls.polygon.deactivate();
				drawControls.polygon.activate();
				clickControl = new OpenLayers.Control.Click();
				map.addControl(clickControl);
				clickControl.activate();
				makeAllCustomROSRed();
			}
			
			function clearFireBarrier()
			{
				/*drawControls.polygon.activate();
				clickControl = new OpenLayers.Control.Click();
				map.addControl(clickControl);
				clickControl.activate();*/
				polygonLayer.removeAllFeatures()
				makeAllCustomROSRed();
			}
			
			
			function addFirePerimeter()
			{
				panelZoomBox.deactivate();
				panelZoomBox.activate();
				drawControlsPerimeter.polygon.deactivate();
				drawControls.polygon.deactivate();
				drawControlsPerimeter.polygon.activate();
				clickControlPerimeter = new OpenLayers.Control.ClickPerimeter();
				map.addControl(clickControlPerimeter);
				clickControlPerimeter.activate();
			}
			
			function clearFirePerimeter()
			{
				/*drawControls.polygon.activate();
				clickControl = new OpenLayers.Control.Click();
				map.addControl(clickControl);
				clickControl.activate();*/
				polygonLayerPerimeter.removeAllFeatures()
			}
			
			function getListOfPointsForFireBarrier()
			{
				//var result=new Array();
				var result = "";
				var ft = polygonLayer.features;
				for(var i=0; i< ft.length; i++){
					var vertices = polygonLayer.features[i].geometry.getVertices();
					
					if(vertices.length>0)
					{
						result+="A\n";
						for(var j=0; j< vertices.length; j++){
							
							result+=vertices[j].x + " " + vertices[j].y;
							if ( j != vertices.length-1) 
								result+="\n";
						}
						
						result+="\n=255 fire_barrier\n";
						
					}
				}
				return result;
				
			}
			
			function getListOfPointsForFirePerimeter()
			{
				//var result=new Array();
				var result = "";
				var ft = polygonLayerPerimeter.features;
				for(var i=0; i< ft.length; i++){
					var vertices = polygonLayerPerimeter.features[i].geometry.getVertices();
					
					if(vertices.length>0)
					{
						result+="A\n";
						for(var j=0; j< vertices.length; j++){
							
							result+=vertices[j].x + " " + vertices[j].y;
							if ( j != vertices.length-1) 
								result+="\n";
						}
						
						result+="\n=255 fire_perimeter\n";
						
					}
				}
				return result;
				
			}
			
			function setAsDefaultView()
			{
				var latlonMER = new OpenLayers.LonLat(map.center.lon,map.center.lat);
				var EPSG4326 = new OpenLayers.Projection("EPSG:4326");
				var EPSG900913 = new OpenLayers.Projection("EPSG:900913");
				latlon = latlonMER.transform(EPSG900913, EPSG4326);
				latlonLat = latlon.lat;
				latlonLon = latlon.lon;
				zoom=map.zoom;
				
				x_updateDefaultView(WebDir, korisnik, latlonLat,latlonLon,zoom, doAftersetDefaultView);
				//alert(latlonLat + " " + latlonLon + " " + zoom);
				
			}
			
			function doAftersetDefaultView(z)
			{
				alert("Default view updated");
			}
			
			
			window.setInterval(function(){
			  //spread_raster.mergeNewParams({'foo': Math.random()});
			  //spread_vector.mergeNewParams({'foo': Math.random()});
			  regionTemp.mergeNewParams({'foo': Math.random()});
			  regionTemp.mergeNewParams({'foo': Math.random()});
			  
			  
			  x_checkIfStillRunningAnySimulations(korisnik, function(result){
				  
				  isRunning=result;
				 // alert(result);
			  }); 
			  
			  x_checkIfMeteoDataStillRunning(korisnik, function(result){
					//Provjeri samo ako je prvi 0
				  if(isRunning==0)
					isRunning=result;
			  });
			  
			 // alert(korisnik);
			 x_checkIfFireExistsWithoutRandAndWithoutGRASS(WebDir, korisnik, function(result){
				 if(result==-1 || result=="-1")
				 {
					alert("<?php echo _GIS_NORESULTS_SIMULATION;?>");
				 }
				 //alert(result);
			 });
			  
			  
			  
			}, 5000);
			
			function doAfterkill(result)
			{
			//	if(result==1)
				//alert(result);
				isRunning=0;
				forceDisableIsRunning=1;
			}
			
			function terminateCalcs()
			{
				var txt;
				var numberOfRepeats=10;
				
				swal({
					title: "<?php echo _GIS_ARESURE; ?>",
					text: "<?php echo _GIS_STOPPREVIOUSCALCS_QUES; ?>",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "<?php echo _GIS_OK; ?>",
					cancelButtonText: "<?php echo _GIS_CANCEL; ?>",
					closeOnConfirm: true
					}, function(){
						for(brojac=0;brojac<numberOfRepeats;brojac++)
						{
							x_killStartedSimulation(korisnik, numberOfRepeats, doAfterkill);
							pausecomp(1000);
						}
					});
				
				
			}
			
			function pausecomp(millis)
			 {
			  var date = new Date();
			  var curDate = null;
			  do { curDate = new Date(); }
			  while(curDate-date < millis);
			}
			
			
			
			function refreshAllLayers()
			{
				for ( var i in map.layers )
				{
					map.layers[i].redraw({force:true});
				}
					
				
			}
			
			function afterLangUpdate(result)
			{
				top.window.location.href = "gis.php";

				//Ovo radi samo prvi put jer nakon refresha prozora pogubi reference prema otvorenim prozorima
				if (MyWindow && MyWindow.open && !MyWindow.closed) 
				{
					link = MyWindow.location.href;
					MyWindow.location.href = link;
				}
			}
			
		</script>
	</head>

	 <body onload="init();">
		
	<!-- <div id="tags"></div>
	<div id="map" style="width: 930px;height: 800px;border: 1px solid #ccc; border: 2px solid black; ">-->
			<div id="map" >
			<div id="inProgress">
				<!--<img src="./gif/inProgress2.gif" style="float:left;"  /> <span><?php //echo _GIS_RUNNING?></span>-->
				<div class="label-image"> <img src="./gif/inProgress2.gif" style="float:left;"  /></div><div id="isRunningText"><?php echo _GIS_RUNNING_FIRST.$korisnik."! "._GIS_RUNNING?></div>
			</div>
		</div>
		
		<script>
			$("#inProgress").css("width", parseFloat(90) + parseFloat( $("#isRunningText").css("width")));
		</script>
		
		<div id="bottom-bar">
		<div id="logo-holistic"><img src="gif/holistic_logo.png" bodrer="0" height="80"></div>
		<div id ="logo-ipa"><img src="gif/ipa_logo.png" bodrer="0" height="80"></div>
		<div id="menu">
		<nav id="main-menu">
			 <ul class="nav-bar">
				  <li class="nav-button-terminate"><a href="javascript:terminateCalcs()"><?php echo _GIS_STOPPREVIOUSCALCS?></a></li>
				  <li class="nav-button-refresh"><a href="javascript:refreshAllLayers()"><?php echo _GIS_REFRESHALLLAYERS?></a></li>
				  <li class="nav-button-prozirnost"><a href="javascript:addOpacityPopup(map)"><?php echo _GIS_KONTROLA_PROZIRNOSTI?></a></li>
				  <li class="nav-button-corine"><a href="javascript:helpCorine()"><?php echo _GIS_CORINE_LEGENDA?></a></li>
				  <li class="nav-button-defaultview"><a href="javascript:setAsDefaultView()"><?php echo _GIS_SETDEFAULTVIEW?></a></li>
				  <li class="nav-button-logout"><a href="logout.php"><?php echo _GIS_LOGOUT?></a></li>
				<div class="newline-nav-bar"></div>
				  <li class="nav-button-fbarrier"><a href="javascript:addFireBarrier()"><?php echo _GIS_ADDFIREBARRIER?></a></li>
				  <li class="nav-button-clearbarrier"><a href="javascript:clearFireBarrier()"><?php echo _GIS_CLEARIREBARRIER?></a></li>
				  <li class="nav-button-fperimeter"><a href="javascript:addFirePerimeter()"><?php echo _GIS_ADDPERIMETER?></a></li>
				  <li class="nav-button-clearperimeter"><a href="javascript:clearFirePerimeter()"><?php echo _GIS_CLEARPERIMETER?></a></li>
				
				<table align="center"><tr>
				<td width="150px">&nbsp;</td>			
				<td align="right">
				<div id="EU-tekst">
					<table align="center" class="tekst-mali"><tr><td><img src="gif/EU_flag.png" border="0" height="30"></td>
					<td><?php echo _NATPIS_EU?></td></tr></table>
				</div>
				</td>
				<td width="50">&nbsp;</td>
				<td align="right" class="tekst-mali-2"><?php echo _GIS_LANGUAGE_CHANGE?>
				<br/><? if($editableLanguage!="NUL") { ?>
	&nbsp;&nbsp;<a href="Translator/index.php" target="_blank"><?php if(_GIS_LANGUAGE_EDIT != "" ) echo _GIS_LANGUAGE_EDIT; else echo "Edit language";?></a>
	<? } ?>
				</td>
		<td align="right">
<div name="UiLanguage1" id="UiLanguage1">
<table style="width:100%">
<tr>
    <td>
       <!--<select id="uiLanguage" name="uiLanguage" style="width:100%" onchange="ajaxHandleLanguageChanged()">-->
       <select id="uiLanguage" name="uiLanguage" style="width:100%" onchange="x_updateLanguageInDbForUser(korisnik, this.value, afterLangUpdate)">
			<option value="<?echo $chosenLanguage;?>" selected="yes">&nbsp;&nbsp;<?echo $chosenLanguage;?>&nbsp;&nbsp;</option>
			<?php
			foreach ($languagesList as &$language) {
				if(strlen($language)==3 && $language != $chosenLanguage)
				{
					?>
					<option value="<?echo $language;?>">&nbsp;&nbsp;<?echo $language;?>&nbsp;&nbsp;</option>
					<?php
				}
			}
			?>
        </select>
    </td>
</tr>
</table>
</div> 
</td>
<td class="tekst-mali-3" >
	
	<?php echo _GIS_USER?>: <b><?php echo $korisnik; ?></b>
	
	<? if($adminuser=="1") { ?>
	&nbsp;&nbsp;<a href="AdminUser/index.php" target="_blank"><?php echo _GIS_USER_ADMIN?></a>
	<? } ?>
</td>

</tr></table>
			 </ul>
		</nav>
		</div>
		</div>

		<script>
		$('.nav-button-refresh').qtip({ 
			content: {
				text: '<?php echo _GIS_REFRESHALLLAYERS_DESCRIPTION?>'
				},
			position: {
				my: 'bottom middle',  
				at: 'top middle'
					}         		
			})
			
		$('.nav-button-prozirnost').qtip({ 
			content: {
				text: '<?php echo _GIS_KONTROLA_PROZIRNOSTI_DESCRIPTION?>'
			},
			position: {
				my: 'bottom middle',  
				at: 'top middle'
			}
		})
		$('.nav-button-corine').qtip({ 
			content: {
				text: '<?php echo _GIS_CORINE_LEGENDA_DESCRIPTION?>'
			},
			position: {
				my: 'bottom middle',  
				at: 'top middle'
			}
		})
		$('.nav-button-fbarrier').qtip({ 
			content: {
				text: '<?php echo _GIS_ADDFIREBARRIER_DESCRIPTION?>'
			},
			position: {
				my: 'bottom middle',  
				at: 'top middle'
			}
		})
		$('.nav-button-clearbarrier').qtip({ 
			content: {
				text: '<?php echo _GIS_CLEARIREBARRIER_DESCRIPTION?>'
			},
			position: {
				my: 'bottom middle',  
				at: 'top middle'
			}
		})
		$('.nav-button-fperimeter').qtip({ 
			content: {
				text: '<?php echo _GIS_ADDPERIMETER_DESCRIPTION?>'
			},
			position: {
				my: 'bottom middle',  
				at: 'top middle'
			}
		})
		$('.nav-button-clearperimeter').qtip({ 
			content: {
				text: '<?php echo _GIS_CLEARPERIMETER_DESCRIPTION?>'
			},
			position: {
				my: 'bottom middle',  
				at: 'top middle'
			}
		})
		$('.nav-button-terminate').qtip({ 
			content: {
				text: '<?php echo _GIS_STOPPREVIOUSCALCS_DESCRIPTION?>'
			},
			position: {
				my: 'bottom middle',  
				at: 'top middle'
			}
		})
		$('.nav-button-defaultview').qtip({ 
			content: {
				text: '<?php echo _GIS_SETDEFAULTVIEW_DESCRIPTION?>'
			},
			position: {
				my: 'bottom middle',  
				at: 'top middle'
			}
		})
		$('.nav-button-logout').qtip({ 
			content: {
				text: '<?php echo _GIS_LOGOUT?>'
			},
			position: {
				my: 'bottom middle',  
				at: 'top middle'
			}
		})
		
		window.alert = function(str) {
			//do something additional
			swal({  title: "Notification!",  text: str,   type: "warning",   confirmButtonText: "<?php echo _GIS_OK?>" });

			//super.alert(str) // How do I do this bit?
		}
		

		
		
		
		$(document).keyup(function(e) {
		  if (e.keyCode == 27) 
		  {
			if($('.context-menu').is(":visible"))
			{
				$('.context-menu').hide();
				$('.context-menu-shadow').hide();
			}
		  }
		});

		
		</script>
		
		<div id="palettestip"></div> 
		
		<div id="settingstip"></div> 

		<div id="mouseposition"></div>
		
		<div id="getInfo"><?php echo _GIS_MIRIP.": X/255, "._GIS_FWI."=X <br />
			"._GIS_MOISTURE_GENERAL.": X,X,X,X (%) <br />
			"._GIS_WIND_GENERAL.": X (km/h), X ("._GIS_DEGREES_SHORT.") <br />
			"._GIS_SLOPE.": X ("._GIS_DEGREES_SHORT."), aspect=X ("._GIS_DEGREES_SHORT.") <br />
			"._GIS_ROSBASE.": X cm/min <br />
			"._GIS_ROSMAX.": X cm/min <br />
			"._GIS_ROSMAXDIR.": X ("._GIS_DEGREES_SHORT.") <br />			
			
			";?></div>
		
		
		<div id="scalebar"></div>

		
		<!--<form id="myform" action="" method="post" enctype="multipart/form-data" name="myform">-->		
		<!--</form>-->
	</body>
</html>

<?php
}
else {
	echo '<center><h2>AdriaFirePropagator</h2>'._NATPIS_NO_LOGIN.'</center>';
	}
?>
