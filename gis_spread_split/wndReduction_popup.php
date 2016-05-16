<?php 
//ini_set('memory_limit', '512M');	
//ini_set('display_errors', 'On');
//error_reporting(E_ALL); 
session_start();
include_once("db_functions.php");
include_once("postavke_dir_gis.php");
require("./js/sajax-0.12/php/Sajax_windRed.php");

//starting SAJAX stuff
		//$sajax_request_type = "GET";
		sajax_init();
		sajax_export("resetDataFull", "parseDataFile", "parseFuelText", "saveChangesToWind");
		sajax_handle_client_request();

//Samo ukoliko je user uspješno logiran
		//if($korisnik!="") {	

?>

	

	<?php
		//Dohvati korisnika
		$korisnik=$_GET['kor'];
		
		
		//Kreni sa sajax		
				
		//Funkcije (PHP) koje koristi sajax
		function resetDataFull($WebDir,$korisnik)
		{
			
			copy($WebDir."/userdefault/reclass_WindCorrection.r", $WebDir."/user_files/$korisnik/reclass_WindCorrection.r");
			chmod($WebDir."/user_files/$korisnik/reclass_WindCorrection.r", 0777);
			return ".mix";
		}
		
		
		function parseDataFile($filename)
		{
			$fh2 = fopen($filename, 'r') or die("can't open file");
			$stt3 = trim(fread($fh2, filesize($filename)));
			fclose($fh2);

			$pieces = explode("\n", $stt3);
			
			/*for($i=0;$i<10;$i++)
			{
				$part[$i]=explode(",", $pieces[$i]);
			}*/
			
			return json_encode($pieces);
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
		
		function saveChangesToWind($filename, $content)
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
			//sajax_debug_mode=true;
        ?>
		
		
		
		
		
		function afterResetDisplayData()
		{
			//Prikaži resetirane podatke
			getDataFromFiles();
			displayLoadedData(".albini");
			
			//Obavijesti i makni promjene
			$("#status").text("<?php echo _WIND_STATUS_RESET_COMPLETE; ?>");
			$("div.albini table tr td input[type='text']").css( "background-color", "" );
        }
		
		
		
		function getDataFromFiles()
		{
			x_parseDataFile(filenameWindReduction,function(result){
				complexData = jQuery.parseJSON(result);
				displayLoadedData();
			});
			
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

		
		<h1 id="title"><?php echo _GIS_PARAMETRI_WIND_REDUCTION; ?></h1>



		<form method="POST" action=<?php echo $PHP_SELF?>>
		</form>



			
			<script>
			
			var filenameWindReduction="./user_files/"+"<?php echo $korisnik;?>" +"/reclass_WindCorrection.r";
			var complexData = "";    <!--<?php echo json_encode($partAlbini); ?>;-->
			
	
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
						
						$(".resetAll").click(function()
						{
							//alert("not yet supported");
							var r = confirm("<?php echo _WIND_STATUS_RESET; ?>");
							if (r == true) {
								x_resetDataFull(WebDir, korisnik, afterResetDisplayData);
							} else {
								$("#status").text("<?php echo _FUEL_STATUS_RESET_CANCELLED; ?>");
							}
						});
						
						
						
						
												
						$(".saveAll").click(function()
						{
							//alert("not yet supported");
							var r = confirm("<?php echo _WIND_STATUS_SAVE; ?>");
							if (r == true) {
								
								if($("#HellmanInputValue")[0].checkValidity()) {
									contentWindReduction=prepareStringForSaveOrExport();
									$("div.albini table tr td input[type='text']").css( "background-color", "" );
									x_saveChangesToWind(filenameWindReduction, contentWindReduction, AftersaveChangesToWind);
								} else {
									$("#status").text("<?php echo _FUEL_STATUS_SAVE_CANCELLED; ?>");
								}				
								
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
							filter: '.mix',
							sort: 'myorder:asc'
					}
					});

					getDataFromFiles();

					
				});	
				
				function AftersaveChangesToWind(result)
				{
					$("#status").text("<?php echo _FUEL_STATUS_SAVED; ?>");
				}
				
				function displayLoadedData()
				{			
				
					for(i=0; i < complexData.length; i++)
					{
						complexData[i]=complexData[i].trim();
						var temp = complexData[i].split("=");
						code = temp[0].trim();
						value = Number(temp[1].trim())/100;
						$(".albini[data-myorder="+code+"] table input[name=wndReductValue]").val(value);
					}
					
					
					
					var temp = complexData[complexData.length-1].split("=");
					HellmanValue = (Number(temp[1].trim())).toFixed(2);
					$("#HellmanInputValue").val(HellmanValue);
					
					
				}
				
				
				
				
				
				function x_saveAll()
				{
					
				}
				
	
				
				function prepareStringForSaveOrExport()
				{
					
					content ="";
					
					fuelNumbers = new Array( 0 /*skip*/ , 
						1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,
						21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33,
						41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80,
						101, 102, 103, 104, 105, 106, 107, 108, 109, 121, 122, 123, 124, 141, 142, 143, 144, 145, 146, 147, 148, 149, 161, 162, 163, 164, 165, 181, 182, 183, 184, 185, 186, 187, 188, 189, 201, 202, 203, 204 					
					);
					
					
					for(var counter=1; counter < fuelNumbers.length; counter++)
					{
						var _reductionValue=$(".albini[data-myorder="+fuelNumbers[counter]+"] table input[name=wndReductValue]").val();
						_reductionValue=(_reductionValue*100).toFixed(3);
						
						content += (fuelNumbers[counter] + " = " + _reductionValue ) + "\n";
					}
					
					content += "99999 = " + $("#HellmanInputValue").val();
					
					return content;
					

				}
				

				
				
			

			


			</script>


		<div class="controls">
		  <label><?php echo _SORT.":"; ?></label>
		  
		  <button class="sort" data-sort="myorder:asc" id="ascButton"><?php echo _ASCENDING ?></button>
		  <button class="sort" data-sort="myorder:desc"><?php echo _DESCENDING ?></button>
		  
		  
		  <label><?php echo _SAVE.":"; ?></label>
		  
		  <button class="saveAll"><?php echo _SAVE; ?></button>
		  
		  <label><?php echo _RESET.":" ?></label>
		  
		  <button class="resetAll"><?php echo _RESET; ?></button>
	  
		  <br />
		  
		  <span id="statusHellman"><?php echo _GIS_HEMMLAN; ?> &alpha; = <input type="number" id="HellmanInputValue" min="0.000" max="1.000" step="0.01" ></span>
 
		<span id="status">_</span>
		</div>
		<div id="Container" class="container">

			<!-- Albini default -->
			<div class="mix albini" data-myorder="1">
				<header>
					<div class="left">1.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_01; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="2">
				<header>
					<div class="left">2.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_02; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="3">
				<header>
					<div class="left">3.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_03; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="4">
				<header>
					<div class="left">4.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_04; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="5">
				<header>
					<div class="left">5.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_05; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="6">
				<header>
					<div class="left">6.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_06; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="7">
				<header>
					<div class="left">7.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_07; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="8">
				<header>
					<div class="left">8.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_08; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="9">
				<header>
					<div class="left">9.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_09; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="10">
				<header>
					<div class="left">10.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_10; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="11">
				<header>
					<div class="left">11.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_11; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="12">
				<header>
					<div class="left">12.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_12; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="13">
				<header>
					<div class="left">13.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_13; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			
			
			<!-- Albini custom -->
			
			<div class="mix albini" data-myorder="21">
				<header>
					<div class="left">21.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_01." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="22">
				<header>
					<div class="left">22.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_02." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="23">
				<header>
					<div class="left">23.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_03." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="24">
				<header>
					<div class="left">24.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_04." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="25">
				<header>
					<div class="left">25.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_05." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="26">
				<header>
					<div class="left">26.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_06." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="27">
				<header>
					<div class="left">27.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_07." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="28">
				<header>
					<div class="left">28.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_08." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="29">
				<header>
					<div class="left">29.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_09." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="30">
				<header>
					<div class="left">30.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_10." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="31">
				<header>
					<div class="left">31.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_11." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="32">
				<header>
					<div class="left">32.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_12." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="33">
				<header>
					<div class="left">33.</div>
					<div class="center"><?php echo _FUEL_ANDERSON_13." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			
			<!-- Scott default -->
			
			<div class="mix albini" data-myorder="101">
				<header>
					<div class="left">101.</div>
					<div class="center"><?php echo _FUEL_SCOTT_01; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="102">
				<header>
					<div class="left">102.</div>
					<div class="center"><?php echo _FUEL_SCOTT_02; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="103">
				<header>
					<div class="left">103.</div>
					<div class="center"><?php echo _FUEL_SCOTT_03; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="104">
				<header>
					<div class="left">104.</div>
					<div class="center"><?php echo _FUEL_SCOTT_04; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="105">
				<header>
					<div class="left">105.</div>
					<div class="center"><?php echo _FUEL_SCOTT_05; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="106">
				<header>
					<div class="left">106.</div>
					<div class="center"><?php echo _FUEL_SCOTT_06; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="107">
				<header>
					<div class="left">107.</div>
					<div class="center"><?php echo _FUEL_SCOTT_07; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="108">
				<header>
					<div class="left">108.</div>
					<div class="center"><?php echo _FUEL_SCOTT_08; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="109">
				<header>
					<div class="left">109.</div>
					<div class="center"><?php echo _FUEL_SCOTT_09; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="121">
				<header>
					<div class="left">121.</div>
					<div class="center"><?php echo _FUEL_SCOTT_10; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="122">
				<header>
					<div class="left">122.</div>
					<div class="center"><?php echo _FUEL_SCOTT_11; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="123">
				<header>
					<div class="left">123.</div>
					<div class="center"><?php echo _FUEL_SCOTT_12; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="124">
				<header>
					<div class="left">124.</div>
					<div class="center"><?php echo _FUEL_SCOTT_13; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="141">
				<header>
					<div class="left">141.</div>
					<div class="center"><?php echo _FUEL_SCOTT_14; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="142">
				<header>
					<div class="left">142.</div>
					<div class="center"><?php echo _FUEL_SCOTT_15; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="143">
				<header>
					<div class="left">143.</div>
					<div class="center"><?php echo _FUEL_SCOTT_16; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="144">
				<header>
					<div class="left">144.</div>
					<div class="center"><?php echo _FUEL_SCOTT_17; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="145">
				<header>
					<div class="left">145.</div>
					<div class="center"><?php echo _FUEL_SCOTT_18; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="146">
				<header>
					<div class="left">146.</div>
					<div class="center"><?php echo _FUEL_SCOTT_19; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="147">
				<header>
					<div class="left">147.</div>
					<div class="center"><?php echo _FUEL_SCOTT_20; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="148">
				<header>
					<div class="left">148.</div>
					<div class="center"><?php echo _FUEL_SCOTT_21; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="149">
				<header>
					<div class="left">149.</div>
					<div class="center"><?php echo _FUEL_SCOTT_22; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="161">
				<header>
					<div class="left">161.</div>
					<div class="center"><?php echo _FUEL_SCOTT_23; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="162">
				<header>
					<div class="left">162.</div>
					<div class="center"><?php echo _FUEL_SCOTT_24; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="163">
				<header>
					<div class="left">163.</div>
					<div class="center"><?php echo _FUEL_SCOTT_25; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="164">
				<header>
					<div class="left">164.</div>
					<div class="center"><?php echo _FUEL_SCOTT_26; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="165">
				<header>
					<div class="left">165.</div>
					<div class="center"><?php echo _FUEL_SCOTT_27; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="181">
				<header>
					<div class="left">181.</div>
					<div class="center"><?php echo _FUEL_SCOTT_28; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="182">
				<header>
					<div class="left">182.</div>
					<div class="center"><?php echo _FUEL_SCOTT_29; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="183">
				<header>
					<div class="left">183.</div>
					<div class="center"><?php echo _FUEL_SCOTT_30; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="184">
				<header>
					<div class="left">184.</div>
					<div class="center"><?php echo _FUEL_SCOTT_31; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="185">
				<header>
					<div class="left">185.</div>
					<div class="center"><?php echo _FUEL_SCOTT_32; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="186">
				<header>
					<div class="left">186.</div>
					<div class="center"><?php echo _FUEL_SCOTT_33; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="187">
				<header>
					<div class="left">187.</div>
					<div class="center"><?php echo _FUEL_SCOTT_34; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="188">
				<header>
					<div class="left">188.</div>
					<div class="center"><?php echo _FUEL_SCOTT_35; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="189">
				<header>
					<div class="left">189.</div>
					<div class="center"><?php echo _FUEL_SCOTT_36; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="201">
				<header>
					<div class="left">201.</div>
					<div class="center"><?php echo _FUEL_SCOTT_37; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="202">
				<header>
					<div class="left">202.</div>
					<div class="center"><?php echo _FUEL_SCOTT_38; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="203">
				<header>
					<div class="left">203.</div>
					<div class="center"><?php echo _FUEL_SCOTT_39; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="204">
				<header>
					<div class="left">204.</div>
					<div class="center"><?php echo _FUEL_SCOTT_40; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			
		  <!-- Scott custom -->
		  
		  <div class="mix albini" data-myorder="41">
				<header>
					<div class="left">41.</div>
					<div class="center"><?php echo _FUEL_SCOTT_01." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="42">
				<header>
					<div class="left">42.</div>
					<div class="center"><?php echo _FUEL_SCOTT_02." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="43">
				<header>
					<div class="left">43.</div>
					<div class="center"><?php echo _FUEL_SCOTT_03." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="44">
				<header>
					<div class="left">44.</div>
					<div class="center"><?php echo _FUEL_SCOTT_04." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="45">
				<header>
					<div class="left">45.</div>
					<div class="center"><?php echo _FUEL_SCOTT_05." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="46">
				<header>
					<div class="left">46.</div>
					<div class="center"><?php echo _FUEL_SCOTT_06." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="47">
				<header>
					<div class="left">47.</div>
					<div class="center"><?php echo _FUEL_SCOTT_07." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="48">
				<header>
					<div class="left">48.</div>
					<div class="center"><?php echo _FUEL_SCOTT_08." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="49">
				<header>
					<div class="left">49.</div>
					<div class="center"><?php echo _FUEL_SCOTT_09." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="50">
				<header>
					<div class="left">50.</div>
					<div class="center"><?php echo _FUEL_SCOTT_10." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="51">
				<header>
					<div class="left">51.</div>
					<div class="center"><?php echo _FUEL_SCOTT_11." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="52">
				<header>
					<div class="left">52.</div>
					<div class="center"><?php echo _FUEL_SCOTT_12." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="53">
				<header>
					<div class="left">53.</div>
					<div class="center"><?php echo _FUEL_SCOTT_13." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="54">
				<header>
					<div class="left">54.</div>
					<div class="center"><?php echo _FUEL_SCOTT_14." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="55">
				<header>
					<div class="left">55.</div>
					<div class="center"><?php echo _FUEL_SCOTT_15." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="56">
				<header>
					<div class="left">56.</div>
					<div class="center"><?php echo _FUEL_SCOTT_16." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="57">
				<header>
					<div class="left">57.</div>
					<div class="center"><?php echo _FUEL_SCOTT_17." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="58">
				<header>
					<div class="left">58.</div>
					<div class="center"><?php echo _FUEL_SCOTT_18." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="59">
				<header>
					<div class="left">59.</div>
					<div class="center"><?php echo _FUEL_SCOTT_19." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="60">
				<header>
					<div class="left">60.</div>
					<div class="center"><?php echo _FUEL_SCOTT_20." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="61">
				<header>
					<div class="left">61.</div>
					<div class="center"><?php echo _FUEL_SCOTT_21." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="62">
				<header>
					<div class="left">62.</div>
					<div class="center"><?php echo _FUEL_SCOTT_22." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="63">
				<header>
					<div class="left">63.</div>
					<div class="center"><?php echo _FUEL_SCOTT_23." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="64">
				<header>
					<div class="left">64.</div>
					<div class="center"><?php echo _FUEL_SCOTT_24." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="65">
				<header>
					<div class="left">65.</div>
					<div class="center"><?php echo _FUEL_SCOTT_25." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="66">
				<header>
					<div class="left">66.</div>
					<div class="center"><?php echo _FUEL_SCOTT_26." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="67">
				<header>
					<div class="left">67.</div>
					<div class="center"><?php echo _FUEL_SCOTT_27." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="68">
				<header>
					<div class="left">68.</div>
					<div class="center"><?php echo _FUEL_SCOTT_28." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="69">
				<header>
					<div class="left">69.</div>
					<div class="center"><?php echo _FUEL_SCOTT_29." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="70">
				<header>
					<div class="left">70.</div>
					<div class="center"><?php echo _FUEL_SCOTT_30." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="71">
				<header>
					<div class="left">71.</div>
					<div class="center"><?php echo _FUEL_SCOTT_31." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="72">
				<header>
					<div class="left">72.</div>
					<div class="center"><?php echo _FUEL_SCOTT_32." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="73">
				<header>
					<div class="left">73.</div>
					<div class="center"><?php echo _FUEL_SCOTT_33." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="74">
				<header>
					<div class="left">74.</div>
					<div class="center"><?php echo _FUEL_SCOTT_34." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="75">
				<header>
					<div class="left">75.</div>
					<div class="center"><?php echo _FUEL_SCOTT_35." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="76">
				<header>
					<div class="left">76.</div>
					<div class="center"><?php echo _FUEL_SCOTT_36." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="77">
				<header>
					<div class="left">77.</div>
					<div class="center"><?php echo _FUEL_SCOTT_37." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="78">
				<header>
					<div class="left">78.</div>
					<div class="center"><?php echo _FUEL_SCOTT_38." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="79">
				<header>
					<div class="left">79.</div>
					<div class="center"><?php echo _FUEL_SCOTT_39." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
					</tr>
				</table>	
			</div>
			<div class="mix albini" data-myorder="80">
				<header>
					<div class="left">80.</div>
					<div class="center"><?php echo _FUEL_SCOTT_40." ("._GIS_CUSTOM.")"; ?></div>
				</header>
				<table border="1">
					<tr>
						<td style="width:75%"><?php echo _GIS_WIND_REDUCTION_VALUE; ?></td><td> <input type="text" size="7" name="wndReductValue" value=""  /> </td>
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