<?php 
//ini_set('memory_limit', '512M');	
//ini_set('display_errors', 'On');
//error_reporting(E_ALL); 
session_start();
include_once("db_functions.php");
include_once("postavke_dir_gis.php");
require("rosUpdate.php");
require("./js/sajax-0.12/php/Sajax_fuel.php");

//starting SAJAX stuff
		//$sajax_request_type = "GET";
		sajax_init();
		sajax_export("resetFuelAlbiniFull","resetFuelScottFull", "parseFuelFile", "parseFuelText", "saveChangesToModel", "insertValueToCalculateROS");
		sajax_handle_client_request();

//Samo ukoliko je user uspješno logiran
		//if($korisnik!="") {	

?>

	

	<?php
		//Dohvati korisnika
		$korisnik=$_GET['kor'];
		
		
		//Kreni sa sajax		
				
		//Funkcije (PHP) koje koristi sajax
		function resetFuelAlbiniFull($WebDir,$korisnik)
		{
			
			copy($WebDir."/userdefault/fuelParametersAlbini.txt", $WebDir."/user_files/$korisnik/fuelParametersAlbini.txt");
			chmod($WebDir."/user_files/$korisnik/fuelParametersAlbini.txt", 0777);
			return ".albini";
		}
		
		function resetFuelScottFull($WebDir,$korisnik)
		{
			
			copy($WebDir."/userdefault/fuelParametersScott.txt", $WebDir."/user_files/$korisnik/fuelParametersScott.txt");
			chmod($WebDir."/user_files/$korisnik/fuelParametersScott.txt", 0777);
			return ".scott";
		}
		
		function parseFuelFile($filename)
		{
			//$filename="./user_files/$korisnik/fuelParametersAlbini.txt";
			$fh2 = fopen($filename, 'r') or die("can't open file");
			$stt3 = fread($fh2, filesize($filename));
			fclose($fh2);

			$pieces = explode("\n", $stt3);
			
			for($i=0;$i<10;$i++)
			{
				$part[$i]=explode(",", $pieces[$i]);
			}
			
			return json_encode($part);
		}

		function parseFuelText($inputText)
		{
			$pieces = explode("\n", $inputText);
			
			for($i=0;$i<10;$i++)
			{
				$part[$i]=explode(",", $pieces[$i]);
			}
			
			return json_encode($part);
		}
		
		function saveChangesToModel($filename, $content)
		{
			$fh2 = fopen($filename, 'r') or die("can't open file");
			file_put_contents($filename, $content);
			fclose($fh2);
			
			return $content;
		}
		


		
	
	?>
			
<html>			
<head>
	<title><?php echo _NATPIS_TITLE; ?></title><br />
	<!--<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<link rel="stylesheet" href="./css/ipnas.css" type="text/css">-->
	<link rel="stylesheet" href="./css/mixitup.css" type="text/css">
	<script src="./js/jquery-1.11.0.min.js"></script>
	<script src="./js/mixitup-master/build/jquery.mixitup.min.js"></script>
	<script src="./js/jquery.alphanum.js"></script>

	<script>
	
		var WebDir = "<?php echo $WebDir; ?>" ;
		var korisnik = "<?php echo $korisnik; ?>";
		<?php
			sajax_show_javascript();
        ?>
		
		function afterResetDisplayAlbini()
		{
			//Prikaži resetirane podatke
			getFuelDataFromFilesAlbini();
			displayLoadedFuelData(".albini");
			
			//Obavijesti i makni promjene
			$("#status").text("<?php echo _FUEL_STATUS_ALBINI_RESET; ?>");
			x_insertValueToCalculateROS(WebDir, korisnik, 1, "Albini_custom", function(){});
			$("div.albini table tr td input[type='text']").css( "background-color", "" );
        }
		
		function afterResetDisplayScott() 
		{	
			//Prikaži resetirane podatke
			getFuelDataFromFilesScott();
			displayLoadedFuelData(".scott");
			
			//Obavijesti i makni promjene
			$("#status").text("<?php echo _FUEL_STATUS_SCOTT_RESET; ?>");
			x_insertValueToCalculateROS(WebDir, korisnik, 1, "Scott_custom", function(){});
			$("div.scott table tr td input[type='text']").css( "background-color", "" );
        }
		
		function getFuelDataFromFilesAlbini()
		{
			x_parseFuelFile(filenameAlbini,prepareLoadedFuelAlbini);
		}
		
		function getFuelDataFromFilesScott()
		{
			x_parseFuelFile(filenameScott,prepareLoadedFuelScott);
		}
		
		function prepareLoadedFuelAlbini(result)
		{
			complexAlbini=jQuery.parseJSON(result);
			displayLoadedFuelData(".albini")
		}			
		function prepareLoadedFuelScott(result)
		{
			complexScott=jQuery.parseJSON(result);
			displayLoadedFuelData(".scott")
		}
		
		


	</script>

	
</head>

	<body>
	
		<?php

		
		if($_POST["fuel_submit"]!="")
		{
			$new_text="";
			
			for($i=0;$i<4;$i++)	
			{
				for($j=0;$j<14;$j++)
				{
					$values[$i][$j]=trim($_POST["fuel_".$i."_".$j]);
					$new_text=$new_text.$values[$i][$j];
					if($j<13 && $i<3) $new_text=$new_text.", ";
					if($j<12 && $i==3) $new_text=$new_text.", ";
				}	
				$new_text=$new_text."\n";
			}
			//echo $new_text;
			//print_r($values);	

			 $filename="./user_files/$korisnik/fuelParametersAlbini.txt";
			 $fh = fopen($filename, 'w') or die("can't open file");
			 fwrite($fh, $new_text);
			 fclose($fh);	
		}

		?>

		
		<h1 id="title"><?php echo _FUEL_MODEL_PARAMETERS; ?></h1>



		<form method="POST" action=<?php echo $PHP_SELF?>>
		<?php
		
			
			
			/*$filenameAlbini="./user_files/$korisnik/fuelParametersAlbini.txt";
			$filenameScott="./user_files/$korisnik/fuelParametersScott.txt";
			
			$partAlbini=parseFuelFile($filenameAlbini);
			$partScott=parseFuelFile($filenameScott);*/


			
			
		
		?>
				

		</form>



			
			<script>
			
			var filenameAlbini="./user_files/"+"<?php echo $korisnik;?>" +"/fuelParametersAlbini.txt";
			var filenameScott="./user_files/"+"<?php echo $korisnik;?>" +"/fuelParametersScott.txt";		
			var complexAlbini = "";    <!--<?php echo json_encode($partAlbini); ?>;-->
			var complexScott = "";    <!--<?php echo json_encode($partScott); ?>;-->
			
	
			jQuery(document).ready(function() {
				
						window.moveTo(0, 0);
						window.resizeTo(screen.availWidth, screen.availHeight);
				
						var offset = 220;
						var duration = 500;
						jQuery(window).scroll(function() {
							if (jQuery(this).scrollTop() > offset) {
								jQuery('.back-to-top').fadeIn(duration);
							} else {
								jQuery('.back-to-top').fadeOut(duration);
							}
						});
						
						jQuery('.back-to-top').click(function(event) {
							event.preventDefault();
							jQuery('html, body').animate({scrollTop: 0}, duration);
							return false;
						})
						
						$(".resetAllAlbini").click(function()
						{
							var r = confirm("<?php echo _FUEL_STATUS_RESET; ?>");
							if (r == true) {
								x_resetFuelAlbiniFull(WebDir, korisnik, afterResetDisplayAlbini);
							} else {
								$("#status").text("<?php echo _FUEL_STATUS_RESET_CANCELLED; ?>");
							}
						});
						
						$(".resetAllScott").click(function()
						{
							var r = confirm("<?php echo _FUEL_STATUS_RESET; ?>");
							if (r == true) {
								x_resetFuelScottFull(WebDir, korisnik, afterResetDisplayScott);
							} else {
								$("#status").text("<?php echo _FUEL_STATUS_RESET_CANCELLED; ?>");
							}
						});
						
						
						$(".exportAllAlbini").click(function()
						{
							downloadFuelFile(".albini");
						});
						
						$(".exportAllScott").click(function()
						{
							downloadFuelFile(".scott");
						});
						
						$(".loadAllAlbini").click(function()
						{
							loadFuelFile(".albini");
						});
						
						$(".loadAllScott").click(function()
						{
							loadFuelFile(".scott");
						});
						
						$(".saveAll").click(function()
						{
							var r = confirm("<?php echo _FUEL_STATUS_SAVE; ?>");
							if (r == true) {
								contentAlbini = prepareStringForSaveOrExport(".albini");
								contentScott = prepareStringForSaveOrExport(".scott");
								x_saveChangesToModel(filenameAlbini, contentAlbini, AftersaveChangesToModel);
								x_saveChangesToModel(filenameScott, contentScott, AftersaveChangesToModel);
								$("div.albini table tr td input[type='text']").css( "background-color", "" );
								$("div.scott table tr td input[type='text']").css( "background-color", "" );
								x_insertValueToCalculateROS(WebDir, korisnik, 1, "Albini_custom", function(){});
								x_insertValueToCalculateROS(WebDir, korisnik, 1, "Scott_custom", function(){});
								
							} else {
								$("#status").text("<?php echo _FUEL_STATUS_SAVE_CANCELLED; ?>");
							}
							
							
							
						});
						

						
						
						$("table tr td input[type='text']").change(function() {
						    $( this ).css( "background-color", "#F5F6CE" );
							$("#status").text("<?php echo _FUEL_STATUS_NOT_SAVED; ?>");
						});
						
					});
			
				$(function(){
					
					// Instantiate MixItUp:

					$('#Container').mixItUp({
						load: {
							filter: '.albini',
							sort: 'myorder:asc'
					}
					});

					getFuelDataFromFilesAlbini();
					getFuelDataFromFilesScott();
					
				});	
				
				function AftersaveChangesToModel(result)
				{
					$("#status").text("<?php echo _FUEL_STATUS_SAVED; ?>");
				}
				
				function displayLoadedFuelData(model)
				{
					//Ukoliko je riječ o Albini Anderson fuel modelu
					if(model==".albini" || model=="all")
					{
						
						for(i=0; i < complexAlbini.length; i++)
						{
							for(j=0; j < complexAlbini[i].length; j++)
							{
								complexAlbini[i][j]=complexAlbini[i][j].trim();
							}
						}

						for(var fuelCat=1; fuelCat <= 13; fuelCat++)
						{
							var _1hfuelValue=complexAlbini[0][fuelCat];
							var _10hfuelValue=complexAlbini[1][fuelCat];
							var _100hfuelValue=complexAlbini[2][fuelCat];
							var _liveloadHerbValue=complexAlbini[3][fuelCat]; 
							var _liveloadWoodyValue=complexAlbini[4][fuelCat]; 
							var _fuelbeddepthValue=complexAlbini[5][fuelCat];
							var _1hsurfavrValue=complexAlbini[6][fuelCat];
							var _liveherbsurfavrValue=complexAlbini[7][fuelCat];;
							var _livewoodysurfavrValue=complexAlbini[8][fuelCat];;
							var _deadfuelmoistValue=complexAlbini[9][fuelCat];
							var _deadfuelheatValue=8000;
							var _livefuelheatValue=8000;
							
							if(1/*ako treba preracunat jedinice*/)
							{
								_1hfuelValue=_1hfuelValue*21.78; //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_10hfuelValue=_10hfuelValue*21.78; //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_100hfuelValue=_100hfuelValue*21.78; //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_liveloadHerbValue=_liveloadHerbValue*21.78; //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_liveloadWoodyValue=_liveloadWoodyValue*21.78; //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_fuelbeddepthValue=_fuelbeddepthValue*1.00; //ne treba, oboje je u feet, 1.00 radi toFixed
								_deadfuelmoistValue=_deadfuelmoistValue*100.0;
							}
							
							$(".albini[data-myorder="+fuelCat+"] table input[name=1hfuel]").val(_1hfuelValue.toFixed(4));
							$(".albini[data-myorder="+fuelCat+"] table input[name=1hfuel]").attr("value", _1hfuelValue.toFixed(4));
							$(".albini[data-myorder="+fuelCat+"] table input[name=10hfuel]").val(_10hfuelValue.toFixed(4));
							$(".albini[data-myorder="+fuelCat+"] table input[name=10hfuel]").attr("value",_10hfuelValue.toFixed(4));
							$(".albini[data-myorder="+fuelCat+"] table input[name=100hfuel]").val(_100hfuelValue.toFixed(4));
							$(".albini[data-myorder="+fuelCat+"] table input[name=100hfuel]").attr("value",_100hfuelValue.toFixed(4));
							
							$(".albini[data-myorder="+fuelCat+"] table input[name=liveherb]").val(_liveloadHerbValue.toFixed(4));
							$(".albini[data-myorder="+fuelCat+"] table input[name=liveherb]").attr("value",_liveloadHerbValue.toFixed(4));
							$(".albini[data-myorder="+fuelCat+"] table input[name=liveherb]").prop('disabled', true);
							$(".albini[data-myorder="+fuelCat+"] table input[name=livewoody]").val(_liveloadWoodyValue.toFixed(4));
							$(".albini[data-myorder="+fuelCat+"] table input[name=livewoody]").attr("value",_liveloadWoodyValue.toFixed(4));
							$(".albini[data-myorder="+fuelCat+"] table input[name=livewoody]").prop('disabled', true);
							
							$(".albini[data-myorder="+fuelCat+"] table input[name=fuelbeddepth]").val(_fuelbeddepthValue.toFixed(4));
							$(".albini[data-myorder="+fuelCat+"] table input[name=fuelbeddepth]").attr("value",_fuelbeddepthValue.toFixed(4));
							
							$(".albini[data-myorder="+fuelCat+"] table input[name=1hsurfavr]").val(_1hsurfavrValue); //nema toFixed
							$(".albini[data-myorder="+fuelCat+"] table input[name=1hsurfavr]").attr("value",_1hsurfavrValue); //nema toFixed
							
							$(".albini[data-myorder="+fuelCat+"] table input[name=liveherbsurfavr]").val(_liveherbsurfavrValue); //nema toFixed
							$(".albini[data-myorder="+fuelCat+"] table input[name=liveherbsurfavr]").attr("value",_liveherbsurfavrValue); //nema toFixed
							$(".albini[data-myorder="+fuelCat+"] table input[name=liveherbsurfavr]").prop('disabled', true);
							$(".albini[data-myorder="+fuelCat+"] table input[name=livewoodysurfavr]").val(_livewoodysurfavrValue); //nema toFixed
							$(".albini[data-myorder="+fuelCat+"] table input[name=livewoodysurfavr]").attr("value",_livewoodysurfavrValue); //nema toFixed
							$(".albini[data-myorder="+fuelCat+"] table input[name=livewoodysurfavr]").prop('disabled', true);
							
							$(".albini[data-myorder="+fuelCat+"] table input[name=deadfuelmoist]").val(_deadfuelmoistValue);
							$(".albini[data-myorder="+fuelCat+"] table input[name=deadfuelmoist]").attr("value",_deadfuelmoistValue);
							
							
							$(".albini[data-myorder="+fuelCat+"] table input[name=deadfuelheat]").val(_deadfuelheatValue); //nema toFixed
							$(".albini[data-myorder="+fuelCat+"] table input[name=deadfuelheat]").attr("value",_deadfuelheatValue); //nema toFixed
							$(".albini[data-myorder="+fuelCat+"] table input[name=deadfuelheat]").prop('disabled', true);
							$(".albini[data-myorder="+fuelCat+"] table input[name=livefuelheat]").val(_livefuelheatValue); //nema toFixed
							$(".albini[data-myorder="+fuelCat+"] table input[name=livefuelheat]").attr("value",_livefuelheatValue); //nema toFixed
							$(".albini[data-myorder="+fuelCat+"] table input[name=livefuelheat]").prop('disabled', true);
							
						}
					}
					
					//Ukoliko je riječ o Scott Burgan fuel modelu
					if(model==".scott" || model=="all")
					{
					
						for(var fuelCat=1; fuelCat <= 40; fuelCat++)
						{
							
							for(i=0; i < complexScott.length; i++)
							{
								for(j=0; j < complexScott[i].length; j++)
								{
									complexScott[i][j]=complexScott[i][j].trim();
								}
							}
						
							var _1hfuelValue=complexScott[0][fuelCat];
							var _10hfuelValue=complexScott[1][fuelCat];
							var _100hfuelValue=complexScott[2][fuelCat];
							var _liveloadHerbValue=complexScott[3][fuelCat]; 
							var _liveloadWoodyValue=complexScott[4][fuelCat]; 
							var _fuelbeddepthValue=complexScott[5][fuelCat];
							var _1hsurfavrValue=complexScott[6][fuelCat];
							var _liveherbsurfavrValue=complexScott[7][fuelCat];
							var _livewoodysurfavrValue=complexScott[8][fuelCat];
							var _deadfuelmoistValue=complexScott[9][fuelCat];
							var _deadfuelheatValue=8000;
							var _livefuelheatValue=8000;
							
							if(1/*ako treba preracunat jedinice*/)
							{
								_1hfuelValue=_1hfuelValue*21.78; //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_10hfuelValue=_10hfuelValue*21.78; //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_100hfuelValue=_100hfuelValue*21.78; //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_liveloadHerbValue=_liveloadHerbValue*21.78; //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_liveloadWoodyValue=_liveloadWoodyValue*21.78; //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_fuelbeddepthValue=_fuelbeddepthValue*1.00; //ne treba, oboje je u feet, 1.00 radi toFixed
								_deadfuelmoistValue=_deadfuelmoistValue*100.0;
							}
							
							$(".scott[data-myorder="+fuelCat+"] table input[name=1hfuel]").val(_1hfuelValue.toFixed(4));
							$(".scott[data-myorder="+fuelCat+"] table input[name=1hfuel]").attr("value", _1hfuelValue.toFixed(4));
							$(".scott[data-myorder="+fuelCat+"] table input[name=10hfuel]").val(_10hfuelValue.toFixed(4));
							$(".scott[data-myorder="+fuelCat+"] table input[name=10hfuel]").attr("value",_10hfuelValue.toFixed(4));
							$(".scott[data-myorder="+fuelCat+"] table input[name=100hfuel]").val(_100hfuelValue.toFixed(4));
							$(".scott[data-myorder="+fuelCat+"] table input[name=100hfuel]").attr("value",_100hfuelValue.toFixed(4));
							
							//Zasad isključi liveload, i herb i woody
							$(".scott[data-myorder="+fuelCat+"] table input[name=liveherb]").val(_liveloadHerbValue.toFixed(4));
							$(".scott[data-myorder="+fuelCat+"] table input[name=liveherb]").attr("value",_liveloadHerbValue.toFixed(4));
							$(".scott[data-myorder="+fuelCat+"] table input[name=liveherb]").prop('disabled', true);
							$(".scott[data-myorder="+fuelCat+"] table input[name=livewoody]").val(_liveloadWoodyValue.toFixed(4));
							$(".scott[data-myorder="+fuelCat+"] table input[name=livewoody]").attr("value",_liveloadWoodyValue.toFixed(4));
							$(".scott[data-myorder="+fuelCat+"] table input[name=livewoody]").prop('disabled', true);

							
							$(".scott[data-myorder="+fuelCat+"] table input[name=fuelbeddepth]").val(_fuelbeddepthValue.toFixed(4));
							$(".scott[data-myorder="+fuelCat+"] table input[name=fuelbeddepth]").attr("value",_fuelbeddepthValue.toFixed(4));
							
							$(".scott[data-myorder="+fuelCat+"] table input[name=1hsurfavr]").val(_1hsurfavrValue); //nema toFixed
							$(".scott[data-myorder="+fuelCat+"] table input[name=1hsurfavr]").attr("value",_1hsurfavrValue); //nema toFixed
							
							$(".scott[data-myorder="+fuelCat+"] table input[name=liveherbsurfavr]").val(_liveherbsurfavrValue); //nema toFixed
							$(".scott[data-myorder="+fuelCat+"] table input[name=liveherbsurfavr]").attr("value",_liveherbsurfavrValue); //nema toFixed
							$(".scott[data-myorder="+fuelCat+"] table input[name=liveherbsurfavr]").prop('disabled', true);
							$(".scott[data-myorder="+fuelCat+"] table input[name=livewoodysurfavr]").val(_livewoodysurfavrValue); //nema toFixed
							$(".scott[data-myorder="+fuelCat+"] table input[name=livewoodysurfavr]").attr("value",_livewoodysurfavrValue); //nema toFixed
							$(".scott[data-myorder="+fuelCat+"] table input[name=livewoodysurfavr]").prop('disabled', true);
							
							$(".scott[data-myorder="+fuelCat+"] table input[name=deadfuelmoist]").val(_deadfuelmoistValue);
							$(".scott[data-myorder="+fuelCat+"] table input[name=deadfuelmoist]").attr("value",_deadfuelmoistValue);
							
							
							$(".scott[data-myorder="+fuelCat+"] table input[name=deadfuelheat]").val(_deadfuelheatValue); //nema toFixed
							$(".scott[data-myorder="+fuelCat+"] table input[name=deadfuelheat]").attr("value",_deadfuelheatValue); //nema toFixed
							$(".scott[data-myorder="+fuelCat+"] table input[name=deadfuelheat]").prop('disabled', true);
							$(".scott[data-myorder="+fuelCat+"] table input[name=livefuelheat]").val(_livefuelheatValue); //nema toFixed
							$(".scott[data-myorder="+fuelCat+"] table input[name=livefuelheat]").attr("value",_livefuelheatValue); //nema toFixed
							$(".scott[data-myorder="+fuelCat+"] table input[name=livefuelheat]").prop('disabled', true);
							
						}
					}
				}
				
				
				function downloadFuelFile(model)
				{
					
					content=prepareStringForSaveOrExport(model);
					
					//Ukoliko je riječ o Albini Anderson fuel modelu
					if(model==".albini")
					{
						var download_filename = prompt("<?php echo _FUEL_ENTER_FILENAME; ?>", "fuel_Albini.txt");

						if (download_filename != null) {
							download(download_filename,content);
							$("#status").text("<?php echo _FUEL_STATUS_EXPORT_DONE; ?>");
						}
						else
						{
							$("#status").text("<?php echo _FUEL_STATUS_EXPORT_CANCELLED; ?>");
						}
					}
					

					//Ukoliko je riječ o Scott Burgan fuel modelu
					if(model==".scott")
					{
						var download_filename = prompt("<?php echo _FUEL_ENTER_FILENAME; ?>", "fuel_Scott.txt");

						if (download_filename != null) {
							download(download_filename,content);
							$("#status").text("<?php echo _FUEL_STATUS_EXPORT_DONE; ?>");
						}
						else
						{
							$("#status").text("<?php echo _FUEL_STATUS_EXPORT_CANCELLED; ?>");
						}
					}
				}
				
				
				function x_saveAll()
				{
					
				}
				
				
				function prepareStringForSaveOrExport(model)
				{
					//Ukoliko je riječ o Albini Anderson fuel modelu
					if(model==".albini")
					{
						
						content ="";
						_1hfuelValueRow="0, ";
						_10hfuelValueRow="0, ";
						_100hfuelValueRow="0, ";
						_liveloadHerbValueRow="0, ";
						_liveloadWoodyValueRow="0, ";
						_fuelbeddepthValueRow="0, ";
						_1hsurfavrValueRow="0, ";
						_liveherbsurfavrValueRow="0, ";
						_livewoodysurfavrValueRow="0, ";
						_deadfuelmoistValueRow="0, ";
						_deadfuelheatValueRow="0, ";
						_livefuelheatValueRow="0, ";
						
						for(var fuelCat=1; fuelCat <= 13; fuelCat++)
						{
							var _1hfuelValue=$(".albini[data-myorder="+fuelCat+"] table input[name=1hfuel]").val();
							var _10hfuelValue=$(".albini[data-myorder="+fuelCat+"] table input[name=10hfuel]").val();
							var _100hfuelValue=$(".albini[data-myorder="+fuelCat+"] table input[name=100hfuel]").val();
							var _liveloadHerbValue=$(".albini[data-myorder="+fuelCat+"] table input[name=liveherb]").val();
							var _liveloadWoodyValue=$(".albini[data-myorder="+fuelCat+"] table input[name=livewoody]").val();
							var _fuelbeddepthValue=$(".albini[data-myorder="+fuelCat+"] table input[name=fuelbeddepth]").val();
							var _1hsurfavrValue=parseInt($(".albini[data-myorder="+fuelCat+"] table input[name=1hsurfavr]").val());
							var _liveherbsurfavrValue=parseInt($(".albini[data-myorder="+fuelCat+"] table input[name=liveherbsurfavr]").val());
							var _livewoodysurfavrValue=parseInt($(".albini[data-myorder="+fuelCat+"] table input[name=livewoodysurfavr]").val());
							var _deadfuelmoistValue=$(".albini[data-myorder="+fuelCat+"] table input[name=deadfuelmoist]").val();
							var _deadfuelheatValue=parseInt($(".albini[data-myorder="+fuelCat+"] table input[name=deadfuelheat]").val());
							var _livefuelheatValue=parseInt($(".albini[data-myorder="+fuelCat+"] table input[name=livefuelheat]").val());
							
							if(1/*ako treba preracunat jedinice*/)
							{
								_1hfuelValue=parseFloat(_1hfuelValue/21.78).toFixed(6); //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_10hfuelValue=parseFloat(_10hfuelValue/21.78).toFixed(6); //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_100hfuelValue=parseFloat(_100hfuelValue/21.78).toFixed(6); //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_liveloadHerbValue=parseFloat(_liveloadHerbValue/21.78).toFixed(6); //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_liveloadWoodyValue=parseFloat(_liveloadWoodyValue/21.78).toFixed(6); //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_fuelbeddepthValue=parseFloat(_fuelbeddepthValue/1.00).toFixed(6); //ne treba, oboje je u feet, 1.00 radi toFixed
								_deadfuelmoistValue=parseFloat(_deadfuelmoistValue/100.0).toFixed(4);
							}
							
							if(fuelCat < 13 ) 
							{
								_1hfuelValueRow+= _1hfuelValue + ", ";
								_10hfuelValueRow+= _10hfuelValue + ", ";
								_100hfuelValueRow+= _100hfuelValue + ", ";
								_liveloadHerbValueRow+= _liveloadHerbValue + ", ";
								_liveloadWoodyValueRow+= _liveloadWoodyValue + ", ";
								_fuelbeddepthValueRow+= _fuelbeddepthValue + ", ";
								_1hsurfavrValueRow+= _1hsurfavrValue + ", ";
								_liveherbsurfavrValueRow+= _liveherbsurfavrValue + ", ";
								_livewoodysurfavrValueRow+= _livewoodysurfavrValue + ", ";
								_deadfuelmoistValueRow+= _deadfuelmoistValue + ", ";
								_deadfuelheatValueRow+= _deadfuelheatValue + ", ";
								_livefuelheatValueRow+= _livefuelheatValue + ", ";
							}
							else
							{
								_1hfuelValueRow+= _1hfuelValue;
								_10hfuelValueRow+= _10hfuelValue;
								_100hfuelValueRow+= _100hfuelValue;
								_liveloadHerbValueRow+= _liveloadHerbValue;
								_liveloadWoodyValueRow+= _liveloadWoodyValue;
								_fuelbeddepthValueRow+= _fuelbeddepthValue;
								_1hsurfavrValueRow+= _1hsurfavrValue;
								_liveherbsurfavrValueRow+= _liveherbsurfavrValue;
								_livewoodysurfavrValueRow+= _livewoodysurfavrValue;
								_deadfuelmoistValueRow+= _deadfuelmoistValue;
								_deadfuelheatValueRow+= _deadfuelheatValue;
								_livefuelheatValueRow+= _livefuelheatValue;
							}
							
							
							
						}
						
						content = _1hfuelValueRow + "\n" + _10hfuelValueRow + "\n" + _100hfuelValueRow + "\n" + _liveloadHerbValueRow + "\n" + _liveloadWoodyValueRow + "\n" + _fuelbeddepthValueRow + "\n" + _1hsurfavrValueRow + "\n" + _liveherbsurfavrValueRow + "\n" + _livewoodysurfavrValueRow + "\n" + _deadfuelmoistValueRow + "\n" + _deadfuelheatValueRow + "\n" + _livefuelheatValueRow;

					}

					//Ukoliko je riječ o Scott Burgan fuel modelu
					if(model==".scott")
					{
											
						content ="";
						_1hfuelValueRow="0, ";
						_10hfuelValueRow="0, ";
						_100hfuelValueRow="0, ";
						_liveloadHerbValueRow="0, ";
						_liveloadWoodyValueRow="0, ";
						_fuelbeddepthValueRow="0, ";
						_1hsurfavrValueRow="0, ";
						_liveherbsurfavrValueRow="0, ";
						_livewoodysurfavrValueRow="0, ";
						_deadfuelmoistValueRow="0, ";
						_deadfuelheatValueRow="0, ";
						_livefuelheatValueRow="0, ";
						
						for(var fuelCat=1; fuelCat <= 40; fuelCat++)
						{
							var _1hfuelValue=$(".scott[data-myorder="+fuelCat+"] table input[name=1hfuel]").val();
							var _10hfuelValue=$(".scott[data-myorder="+fuelCat+"] table input[name=10hfuel]").val();
							var _100hfuelValue=$(".scott[data-myorder="+fuelCat+"] table input[name=100hfuel]").val();
							var _liveloadHerbValue=$(".scott[data-myorder="+fuelCat+"] table input[name=liveherb]").val();
							var _liveloadWoodyValue=$(".scott[data-myorder="+fuelCat+"] table input[name=livewoody]").val();
							var _fuelbeddepthValue=$(".scott[data-myorder="+fuelCat+"] table input[name=fuelbeddepth]").val();
							var _1hsurfavrValue=parseInt($(".scott[data-myorder="+fuelCat+"] table input[name=1hsurfavr]").val());
							var _liveherbsurfavrValue=parseInt($(".scott[data-myorder="+fuelCat+"] table input[name=liveherbsurfavr]").val());
							var _livewoodysurfavrValue=parseInt($(".scott[data-myorder="+fuelCat+"] table input[name=livewoodysurfavr]").val());
							var _deadfuelmoistValue=$(".scott[data-myorder="+fuelCat+"] table input[name=deadfuelmoist]").val();
							var _deadfuelheatValue=parseInt($(".scott[data-myorder="+fuelCat+"] table input[name=deadfuelheat]").val());
							var _livefuelheatValue=parseInt($(".scott[data-myorder="+fuelCat+"] table input[name=livefuelheat]").val());
							
							if(1/*ako treba preracunat jedinice*/)
							{
								_1hfuelValue=parseFloat(_1hfuelValue/21.78).toFixed(6); //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_10hfuelValue=parseFloat(_10hfuelValue/21.78).toFixed(6); //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_100hfuelValue=parseFloat(_100hfuelValue/21.78).toFixed(6); //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_liveloadHerbValue=parseFloat(_liveloadHerbValue/21.78).toFixed(6); //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_liveloadWoodyValue=parseFloat(_liveloadWoodyValue/21.78).toFixed(6); //iz lb/ft^2 u <?php echo _UNIT_TONS; ?>/acre je *21.78
								_fuelbeddepthValue=parseFloat(_fuelbeddepthValue/1.00).toFixed(6); //ne treba, oboje je u feet, 1.00 radi toFixed
								_deadfuelmoistValue=parseFloat(_deadfuelmoistValue/100.0).toFixed(4);
							}
							
							if(fuelCat < 40 ) 
							{
								_1hfuelValueRow+= _1hfuelValue + ", ";
								_10hfuelValueRow+= _10hfuelValue + ", ";
								_100hfuelValueRow+= _100hfuelValue + ", ";
								_liveloadHerbValueRow+= _liveloadHerbValue + ", ";
								_liveloadWoodyValueRow+= _liveloadWoodyValue + ", ";
								_fuelbeddepthValueRow+= _fuelbeddepthValue + ", ";
								_1hsurfavrValueRow+= _1hsurfavrValue + ", ";
								_liveherbsurfavrValueRow+= _liveherbsurfavrValue + ", ";
								_livewoodysurfavrValueRow+= _livewoodysurfavrValue + ", ";
								_deadfuelmoistValueRow+= _deadfuelmoistValue + ", ";
								_deadfuelheatValueRow+= _deadfuelheatValue + ", ";
								_livefuelheatValueRow+= _livefuelheatValue + ", ";
							}
							else
							{
								_1hfuelValueRow+= _1hfuelValue;
								_10hfuelValueRow+= _10hfuelValue;
								_100hfuelValueRow+= _100hfuelValue;
								_liveloadHerbValueRow+= _liveloadHerbValue;
								_liveloadWoodyValueRow+= _liveloadWoodyValue;
								_fuelbeddepthValueRow+= _fuelbeddepthValue;
								_1hsurfavrValueRow+= _1hsurfavrValue;
								_liveherbsurfavrValueRow+= _liveherbsurfavrValue;
								_livewoodysurfavrValueRow+= _livewoodysurfavrValue;
								_deadfuelmoistValueRow+= _deadfuelmoistValue;
								_deadfuelheatValueRow+= _deadfuelheatValue;
								_livefuelheatValueRow+= _livefuelheatValue;
							}
							
							
							
						}
						
						content = _1hfuelValueRow + "\n" + _10hfuelValueRow + "\n" + _100hfuelValueRow + "\n" + _liveloadHerbValueRow + "\n" + _liveloadWoodyValueRow + "\n" + _fuelbeddepthValueRow + "\n" + _1hsurfavrValueRow + "\n" + _liveherbsurfavrValueRow + "\n" + _livewoodysurfavrValueRow + "\n" + _deadfuelmoistValueRow + "\n" + _deadfuelheatValueRow + "\n" + _livefuelheatValueRow;

					}
					
					return content;
					
				}

			
				function loadFuelFile(model)
				{
					
					var fileToLoad = document.getElementById("fileToLoad").files[0];
					
					if (typeof fileToLoad == 'undefined') {
						$("#status").text("<?php echo _FUEL_STATUS_NO_FILE_CHOSEN;?>");
					}
					
					if (typeof fileToLoad != 'undefined') {

						var fileReader = new FileReader();
						fileReader.onload = function(fileLoadedEvent) 
						{
							var textFromFileLoaded = fileLoadedEvent.target.result;
							//alert(textFromFileLoaded);
							if(model==".albini")
							{
								x_parseFuelText(textFromFileLoaded, loadFuelFileContinuedAlbini);
							}
							if(model==".scott")
							{
								x_parseFuelText(textFromFileLoaded, loadFuelFileContinuedScott);
							}
						};
						fileReader.readAsText(fileToLoad, "UTF-8");
					}

				}
				
				function loadFuelFileContinuedAlbini(result)
				{
					complexAlbini=jQuery.parseJSON(result);
					
					
					if(complexAlbini.length==10 && complexAlbini[0].length==14)
					{
					
						displayLoadedFuelData(".albini");
						$("#status").text("<?php echo _FUEL_STATUS_FUEL_IMPORTED;?>");
						x_insertValueToCalculateROS(WebDir, korisnik, 1, "Albini_custom", function(){});
					}
					else
					{
						$("#status").text("<?php echo _FUEL_STATUS_ERROR_NUMBER_CAT;?>");
					}
					
				}
				
				function loadFuelFileContinuedScott(result)
				{
					complexScott=jQuery.parseJSON(result);
					
					
					if(complexScott.length==10 && complexScott[0].length == 41)
					{
						
						displayLoadedFuelData(".scott");
						$("#status").text("<?php echo _FUEL_STATUS_FUEL_IMPORTED;?>");
						x_insertValueToCalculateROS(WebDir, korisnik, 1, "Scott_custom", function(){});
					}
					else
					{
						$("#status").text("<?php echo _FUEL_STATUS_ERROR_NUMBER_CAT;?>");
					}
				}
				
				
			
			function download(filename, text) {
				var pom = document.createElement('a');
				pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
				pom.setAttribute('download', filename);
				pom.click();
			}
			


			</script>


		<div class="controls">
		  <label><?php echo _FILTER; ?></label>
		  
		  <!--<button class="filter" data-filter="all">All</button>-->
		  <button class="filter" data-filter=".albini"><?php echo _FUEL_ALBINI; ?></button>
		  <button class="filter" data-filter=".scott"><?php echo _FUEL_SCOTT; ?></button>
		  
		  <label><?php echo _SORT.":"; ?></label>
		  
		  <button class="sort" data-sort="myorder:asc" id="ascButton"><?php echo _ASCENDING.":" ?></button>
		  <button class="sort" data-sort="myorder:desc"><?php echo _DESCENDING.":" ?></button>
		  
		  
		  <label><?php echo _SAVE.":"; ?></label>
		  
		  <button class="saveAll"><?php echo _SAVE_ALL; ?></button>
		  
		  <label><?php echo _RESET.":" ?></label>
		  
		  <button class="resetAllAlbini"><?php echo _RESET." "._FUEL_ALBINI; ?></button>
		  <button class="resetAllScott"><?php echo _RESET." "._FUEL_SCOTT; ?></button>
	  
		  <br />
	  
		  <label><?php echo _IMPORT.":" ?></label>
		  
		  <input type="file" id="fileToLoad">
		  <button class="loadAllAlbini"><?php echo _IMPORT." "._FUEL_ALBINI; ?></button>
		  <button class="loadAllScott"><?php echo _IMPORT." "._FUEL_SCOTT; ?></button>
		  
		  <label><?php echo _EXPORT.":" ?>:</label>
		  
		  <button class="exportAllAlbini"><?php echo _EXPORT." "._FUEL_ALBINI; ?></button>
		  <button class="exportAllScott"><?php echo _EXPORT." "._FUEL_SCOTT; ?></button>
		  <br />
		  <span id="status">_</span>
		  
		</div>
		<div id="Container" class="container">

			<div class="mix albini" data-myorder="1">
				<header>
					<div class="left">21.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_01; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix albini" data-myorder="2">
				<header>
					<div class="left">22.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_02; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>

			
			<div class="mix albini" data-myorder="3">
				<header>
					<div class="left">23.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_03; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix albini" data-myorder="4">
				<header>
					<div class="left">24.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_04; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
		  
			<div class="mix albini" data-myorder="5">
				<header>
					<div class="left">25.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_05; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
		  
			<div class="mix albini" data-myorder="6">
				<header>
					<div class="left">26.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_06; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
		  
			<div class="mix albini" data-myorder="7">
				<header>
					<div class="left">27.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_07; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div> 
		  
			<div class="mix albini" data-myorder="8">
				<header>
					<div class="left">28.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_08; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div> 
		 
			<div class="mix albini" data-myorder="9">
				<header>
					<div class="left">29.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_09; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div> 
			
			
			<div class="mix albini" data-myorder="10">
				<header>
					<div class="left">30.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_10; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div> 
			
			<div class="mix albini" data-myorder="11">
				<header>
					<div class="left">31.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_11; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div> 
			
			<div class="mix albini" data-myorder="12">
				<header>
					<div class="left">32.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_12; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div> 
		  
			 <div class="mix albini" data-myorder="13">
				<header>
					<div class="left">33.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_13; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div> 
		  
			<!-- ----------------------------------------------------------------------  -->
			<!-- ----------------------------------------------------------------------  -->
			<!-- ----------------------------------------------------------------------  -->	
			<!-- ----------------------------------------------------------------------  -->
			<!-- ----------------------------------------------------------------------  -->
			<!-- ----------------------------------------------------------------------  -->	
		  
			<div class="mix scott" data-myorder="1">
				<header>
					<div class="left">41.</div>
					<div class="center"><?php echo _FUEL_SCOTT_01; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="2">
				<header>
					<div class="left">42.</div>
					<div class="center"><?php echo _FUEL_SCOTT_02; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="3">
				<header>
					<div class="left">43.</div>
					<div class="center"><?php echo _FUEL_SCOTT_03; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>


			<div class="mix scott" data-myorder="4">
				<header>
					<div class="left">44.</div>
					<div class="center"><?php echo _FUEL_SCOTT_04; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="5">
				<header>
					<div class="left">45.</div>
					<div class="center"><?php echo _FUEL_SCOTT_05; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="6">
				<header>
					<div class="left">46.</div>
					<div class="center"><?php echo _FUEL_SCOTT_06; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="7">
				<header>
					<div class="left">47.</div>
					<div class="center"><?php echo _FUEL_SCOTT_07; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="8">
				<header>
					<div class="left">48.</div>
					<div class="center"><?php echo _FUEL_SCOTT_08; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="9">
				<header>
					<div class="left">49.</div>
					<div class="center"><?php echo _FUEL_SCOTT_09; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="10">
				<header>
					<div class="left">50.</div>
					<div class="center"><?php echo _FUEL_SCOTT_10; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="11">
				<header>
					<div class="left">51.</div>
					<div class="center"><?php echo _FUEL_SCOTT_11; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="12">
				<header>
					<div class="left">52.</div>
					<div class="center"><?php echo _FUEL_SCOTT_12; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="13">
				<header>
					<div class="left">53.</div>
					<div class="center"><?php echo _FUEL_SCOTT_13; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="14">
				<header>
					<div class="left">54.</div>
					<div class="center"><?php echo _FUEL_SCOTT_14; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="15">
				<header>
					<div class="left">55.</div>
					<div class="center"><?php echo _FUEL_SCOTT_15; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="16">
				<header>
					<div class="left">56.</div>
					<div class="center"><?php echo _FUEL_SCOTT_16; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="17">
				<header>
					<div class="left">57.</div>
					<div class="center"><?php echo _FUEL_SCOTT_17; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="18">
				<header>
					<div class="left">58.</div>
					<div class="center"><?php echo _FUEL_SCOTT_18; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="19">
				<header>
					<div class="left">59.</div>
					<div class="center"><?php echo _FUEL_SCOTT_19; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
		  
			<div class="mix scott" data-myorder="20">
				<header>
					<div class="left">60.</div>
					<div class="center"><?php echo _FUEL_SCOTT_20; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="21">
				<header>
					<div class="left">61.</div>
					<div class="center"><?php echo _FUEL_SCOTT_21; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="22">
				<header>
					<div class="left">62.</div>
					<div class="center"><?php echo _FUEL_SCOTT_22; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
		  
			<div class="mix scott" data-myorder="23">
				<header>
					<div class="left">63.</div>
					<div class="center"><?php echo _FUEL_SCOTT_23; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="24">
				<header>
					<div class="left">64.</div>
					<div class="center"><?php echo _FUEL_SCOTT_24; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="25">
				<header>
					<div class="left">65.</div>
					<div class="center"><?php echo _FUEL_SCOTT_25; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Dynamic" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="26">
				<header>
					<div class="left">66.</div>
					<div class="center"><?php echo _FUEL_SCOTT_26; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="27">
				<header>
					<div class="left">67.</div>
					<div class="center"><?php echo _FUEL_SCOTT_27; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="28">
				<header>
					<div class="left">68.</div>
					<div class="center"><?php echo _FUEL_SCOTT_28; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="29">
				<header>
					<div class="left">69.</div>
					<div class="center"><?php echo _FUEL_SCOTT_29; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="30">
				<header>
					<div class="left">70.</div>
					<div class="center"><?php echo _FUEL_SCOTT_30; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="31">
				<header>
					<div class="left">71.</div>
					<div class="center"><?php echo _FUEL_SCOTT_31; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="32">
				<header>
					<div class="left">72.</div>
					<div class="center"><?php echo _FUEL_SCOTT_32; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="33">
				<header>
					<div class="left">73.</div>
					<div class="center"><?php echo _FUEL_SCOTT_33; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="34">
				<header>
					<div class="left">74.</div>
					<div class="center"><?php echo _FUEL_SCOTT_34; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="35">
				<header>
					<div class="left">75.</div>
					<div class="center"><?php echo _FUEL_SCOTT_35; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="36">
				<header>
					<div class="left">76.</div>
					<div class="center"><?php echo _FUEL_SCOTT_36; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="37">
				<header>
					<div class="left">77.</div>
					<div class="center"><?php echo _FUEL_SCOTT_37; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="38">
				<header>
					<div class="left">78.</div>
					<div class="center"><?php echo _FUEL_SCOTT_38; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="39">
				<header>
					<div class="left">79.</div>
					<div class="center"><?php echo _FUEL_SCOTT_39; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
			
			<div class="mix scott" data-myorder="40">
				<header>
					<div class="left">80.</div>
					<div class="center"><?php echo _FUEL_SCOTT_40; ?></div>
				</header>

				<table border="1">
					<tr>
						<td><?php echo _FUEL_MODEL_TYPE; ?></td><td> <input type="text" size="7" name="fuelmodeltype" value="Static" disabled /> </td><td></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="1hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_10H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="10hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_100H_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="100hfuel" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="liveherb" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_FUEL_LOAD; ?></td><td> <input type="text" size="7" name="livewoody" /> </td><td><span class="units"><?php echo _UNIT_TONS; ?>/<?php echo _UNIT_AC; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_1H_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="1hsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HERB_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="liveherbsurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_WOODY_SURFACE_AREAVOLUME_RATIO; ?></td><td> <input type="text" size="7" name="livewoodysurfavr" /> </td><td><span class="units"><?php echo _UNIT_FT; ?>^2/<?php echo _UNIT_FT; ?>^3</span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_BED_DEPTH; ?></td><td> <input type="text" size="7" name="fuelbeddepth" /> </td><td><span class="units"><?php echo _UNIT_FT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_MOIS_EXTINCT; ?></td><td> <input type="text" size="7" name="deadfuelmoist" /> </td><td><span class="units"><?php echo _UNIT_PERCENT; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_DEAD_HEAT_CONT; ?></td><td> <input type="text" size="7" name="deadfuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
					<tr>
						<td><?php echo _FUEL_LIVE_HEAT_CONT; ?></td><td> <input type="text" size="7" name="livefuelheat" /> </td><td><span class="units"><?php echo _UNIT_BTULIB; ?></span></td>
					</tr>
				</table>	
			</div>
		  
		  
		  
		  <div class="gap"></div>
		  <div class="gap"></div>
		</div>
		<a href="#" class="back-to-top"><?php echo _FUEL_BACK_TO_TOP; ?></a>
		
		
		
		
		<script type="text/javascript">

			$("table tr td input[type='text']").numeric({
				maxPreDecimalPlaces : 10,
				maxDecimalPlaces    : 4
			});

		</script>
	</body>
</html>
<?php 
/*}
	else {
	echo '<center><h2>AdriaFirePropagator</h2>'._NATPIS_NO_LOGIN.'</center>';
	} */
	?>