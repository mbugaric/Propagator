<script type="text/javascript">

var popup_opacity;
var popup_settings;
var maxOpacity=1.0;
var minOpacity=0.0;

// promjena prozirnosti, na temelju informacije iz popupa se promijeni prozirnost
function changeOpacity(byOpacity, layerid) {
	for ( var i in map.layers )
	{
		if( map.layers[i].id == layerid)
		{

			if(OpenLayers.Util.getElement('opacity'+i).value=="null") {OpenLayers.Util.getElement('opacity'+i).value=0.9;}
			var newOpacity = (parseFloat(OpenLayers.Util.getElement('opacity'+i).value) + byOpacity).toFixed(1);
			newOpacity = Math.min(maxOpacity,
								  Math.max(minOpacity, newOpacity));
			OpenLayers.Util.getElement('opacity'+i).value = newOpacity;
			map.layers[i].setVisibility(true);
			map.layers[i].setOpacity(newOpacity);
		}
	}
 
}
//postavi vidljivost layera 
function turnLayerOn(layerid) {
	for ( var i in map.layers )
	{
		if( map.layers[i].id == layerid)
		{
			map.layers[i].setVisibility(true);
		}
	}
 
}
//postavi vidljivost layera 				
function turnLayerOff(layerid) {
	for ( var i in map.layers )
	{
		if( map.layers[i].id == layerid)
		{
			map.layers[i].setVisibility(false);
		}
	}
 
}
//kad se ugasi popup (vrijedi za neke popupe)
function onPopupClose(evt) {
	/*selectControl.unselectAll();
	selectControl2.unselectAll();
	selectControl3.unselectAll();
	selectControl4.unselectAll();
	selectControl5.unselectAll();
	selectControl6.unselectAll();*/
	popup_opacity.hide();
}
function onPopupCloseSettings(evt) {
	popup_settings.hide();
}

function addDefinedOpacity(map)
{    
	popup_opacity = new OpenLayers.Popup.MyFramedCloudPopupClass("chicken", 
                                     map.getCenter(),
                                     new OpenLayers.Size(1,1), //zanemarivo
                                     "asd",
                                     null, true, onPopupClose);

	map.addPopup(popup_opacity);
	popup_opacity.autoSize=false;
	popup_opacity.setSize(new OpenLayers.Size(1,1)); //ovdje se definira prava vrijednost
	popup_opacity.hide();
}

function addDefinedSettings(map)
{    
	popup_settings = new OpenLayers.Popup.MyFramedCloudPopupClass("chicken", 
                                     map.getCenter(),
                                     new OpenLayers.Size(1,1), //zanemarivo
                                     "asd",
                                     null, true, onPopupCloseSettings);
			map.addPopup(popup_settings);			 
			popup_settings.autoSize=false;
            popup_settings.setSize(new OpenLayers.Size(1,1)); //ovdje se definira prava vrijednost
			popup_settings.hide();
}
	

 function addOpacityPopup(map) {  


  var content_opacity = "<div style='border:double 7px #000000;-moz-border-radius: 21px;-webkit-border-radius: 21px;border-radius: 21px; padding:3px; background-color:#DFF2BF;'><h1 style=\"font-size:12px;text-align:center\"><?php echo _GIS_KONTROLA_PROZIRNOSTI ?></h1>";



	content_opacity += "<div style=\"width:100%;height:400px; overflow-y:scroll; padding:0px;\"><table style=\"margin: 0 auto; border: 0px !important;  \">";

	for ( var i in map.layers )
	{
		if(!(map.layers[i].isBaseLayer) && map.layers[i].displayInLayerSwitcher)
		{
			var prozirnost = map.layers[i].opacity;
			if (map.layers[i].opacity=="null" || map.layers[i].opacity==null)
			{
				prozirnost = 0.9;
			}

			content_opacity += "<tr><td style=\"background-color:#cccccc;padding:5px;font-size:5px;\">" + map.layers[i].name + "</td><td style=\"text-align: center;background-color:#eeeeee;padding:5px;\">  <a title=\"decrease opacity\" style=\"padding:5px;\" href=\"javascript: changeOpacity(-0.1, '" +  map.layers[i].id +"');\">&lt;&lt;</a><input id=\"opacity" + i +"\" type=\"text\" value=\"" + prozirnost + "\" size=\"3\" disabled=\"true\" /><a title=\"increase opacity\" style=\"padding:5px;\" href=\"javascript: changeOpacity(0.1, '" +  map.layers[i].id +"');\">&gt;&gt;</a></td><td style=\"text-align: center;background-color:#eeeeee;padding:5px\"><a title=\"on\" href=\"javascript: turnLayerOn('" +  map.layers[i].id +"');\"><?php echo _GIS_UKLJUCI ?></a></td><td style=\"text-align: center;background-color:#eeeeee;padding:5px\"><a title=\"on\" href=\"javascript: turnLayerOff('" +  map.layers[i].id +"');\"><?php echo _GIS_ISKLJUCI ?></a></td></tr>";
		}
	}

	content_opacity += "</table></div></div>";
	
		latlon=map.getCenter();

		/*var EPSG4326 = new OpenLayers.Projection("EPSG:4326");
		var EPSG900913 = new OpenLayers.Projection("EPSG:900913");
		var latlon = pos.transform(EPSG4326,EPSG900913);*/

		popup_opacity.lonlat=latlon;
		popup_opacity.updatePosition(latlon);	
		popup_opacity.setSize(new OpenLayers.Size(450,500));
		$(".myOwnStyleForFramedCloudPopupContent").css("border","0px");
		$(".myOwnStyleForFramedCloudPopupContent").css("background-color","rgba(0,0,0,0)");
		$(".myOwnStyleForFramedCloudPopupContent").css("height","");
		$(".myOwnStyleForFramedCloudPopupContent").css("margin","1px");
		$("#chicken_FrameDecorationDiv_0").remove();
		$("#chicken_FrameDecorationDiv_1").remove();
		$("#chicken_FrameDecorationDiv_2").remove();
		$("#chicken_FrameDecorationDiv_3").remove();
		$("#chicken_FrameDecorationDiv_4").remove();
		popup_opacity.setContentHTML(content_opacity);
		popup_opacity.show();	

		
	/*popup_opacity.autoSize=false;
	popup_opacity.setSize(new OpenLayers.Size(450,500));
	popup_opacity.setContentHTML(content_opacity);
	popup_opacity.show();
		//.myOwnStyleForFramedCloudPopupContent
			$(".myOwnStyleForFramedCloudPopupContent").css("border","0px");
			$(".myOwnStyleForFramedCloudPopupContent").css("background-color","rgba(0,0,0,0)");
			$(".myOwnStyleForFramedCloudPopupContent").css("height","");
			$(".myOwnStyleForFramedCloudPopupContent").css("margin","1px");
			$("#chicken_FrameDecorationDiv_0").remove();
			$("#chicken_FrameDecorationDiv_1").remove();
			$("#chicken_FrameDecorationDiv_2").remove();
			$("#chicken_FrameDecorationDiv_3").remove();
			$("#chicken_FrameDecorationDiv_4").remove();
*/
													 
}

//Kad se odabere corine
function onFeatureSelect(event) {
	
	var feature = event.feature;
	var content = "<h2>"+feature.attributes.name + "</h2>" + feature.attributes.description;
//	alert(event.feature.attributes);

/*    if (content.search("<script") != -1) {
		content = "Content contained Javascript! Escaped content below.<br />" + content.replace(/</g, "&lt;");
	}*/

   popup_corine = new OpenLayers.Popup.MyFramedCloudPopupClass("chicken", 
							 feature.geometry.getBounds().getCenterLonLat(),
							 new OpenLayers.Size(400,250), //zanemarivo
							 content,
							 null, true, onPopupClose);
	popup_corine.autoSize=false;
	popup_corine.setSize(new OpenLayers.Size(400,250)); //ovdje se definira prava vrijednost
	feature.popup_corine = popup_corine;
	map.addPopup(popup_corine);
}

		function changeSettings()
		{
			if(document.getElementById('fuelModelAlbini').checked)
			{
				chosenFuelModel="Albini_custom";
				external_param_file=external_param_file_AlbiniCustom;
				rastForModel=rastForModelAlbini;
			}
			else if (document.getElementById('fuelModelScott').checked)
			{
				chosenFuelModel="Scott_custom";
				external_param_file=external_param_file_ScottCustom;
				rastForModel=rastForModelScott;
			}
			else if (document.getElementById('fuelModelAlbiniDefault').checked)
			{
				chosenFuelModel="Albini_default";
				external_param_file=external_param_file_AlbiniDefault;
				rastForModel=rastForModelAlbini;
			}
			else if (document.getElementById('fuelModelScottDefault').checked)
			{
				chosenFuelModel="Scott_default";
				external_param_file=external_param_file_ScottDefault;
				rastForModel=rastForModelScott;
			}
			
			if(document.getElementById('pointIgnition').checked)
			{
				chosenIgnition="pointIgnition";
			}
			else if(document.getElementById('perimeterIgnition').checked)
			{
				chosenIgnition="perimeterIgnition";
			}
			
			
			spread_lag=document.getElementById("spread_vrijeme").value;
			spread_step=document.getElementById("spread_korak").value;
			
			if(!isNumeric(spread_lag)) {
				spread_lag=120;
				document.getElementById("spread_vrijeme").value=120;
			}
			
			if(!isNumeric(spread_step)) {
				spread_step=30;
				document.getElementById("spread_korak").value=30;
			}
			
			x_needToCalculateROS(WebDir, korisnik, chosenFuelModel, doAfterneedToCalculateROS);
			
			x_changeSettings2(WebDir, rastForRegion ,max_resolution, korisnik, spread_lag, spread_step, spread_sliderValue, chosenFuelModel, chosenIgnition, do_afterSettingsChange);
		}
		
		function isNumeric(n) {
		  return !isNaN(parseFloat(n)) && isFinite(n);
		}
		
		
		//stvaranje opacity popupa u centar trenutnog pogleda
		 function addSettingsPopup(lat,lon) {   
			//Postavke html content
			var content_settings = "<div style='border:double 7px #000000;-moz-border-radius: 21px;-webkit-border-radius: 21px;border-radius: 21px; padding:6px; background-color:#DFF2BF;'><br /> <span style=\"font-size:12pt;color:green;\"><?php echo _GIS_POSTAVKE_SIMULACIJE;?></style><br /><br /><span style=\"display:block;margin:2px;font-size:10pt;\"><?php echo _TIME_MIN;?><span style='display:block;float:right;width:42%;margin-left:20px;'><?php echo _TIMESTEP_MIN;?></span><br /><input type='text' size='3' autocomplete='off' name='spread_vrijeme' id='spread_vrijeme' value='"+spread_lag+"' onchange='changeSettings()'><input type='text' size='3' autocomplete='off' name='spread_korak' id='spread_korak' value='"+spread_step+"' onchange='changeSettings()' style='display:block;float:right;width:30%;margin-left:10px;'><br /><span style=\"display:block;margin:10px;\"><?php echo _SIMULATION_SPEED;?><span style='display:block;float:right;width:30%;margin-left:10px;'><?php echo _SIMULATION_QUALITY;?></span></p><div id='sliderWrapper'><input type=\"range\" name=\"slider\" id=\"slider\" min=\"1\" max=\"20\" style=\"width: 80%;\" onchange='onChangeOfSlider(this.value);'></div><br /><span><?php echo _GIS_IGNITION_TYPE;?></span><br /><form><input type='radio' name='IgnitionType' id='pointIgnition' value='pointIgnition' onchange='changeSettings()' checked><?php echo _GIS_POINT_IGNITION;?>&nbsp;&nbsp;<input type='radio' name='IgnitionType' id='perimeterIgnition' value='perimeterIgnition' onchange='changeSettings()'><?php echo _GIS_PERIMETER_IGNITION;?><br /></form><span><?php echo _GIS_CHOSEN_FUEL_MODEL;?></span> <form><input type='radio' name='fuelModel' id='fuelModelAlbini' value='Albini_custom' onchange='changeSettings()' checked><?php echo _GIS_ALBINI_CUSTOM;?><br /> <input type='radio' name='fuelModel' id='fuelModelAlbiniDefault' value='Albini_default' onchange='changeSettings()'><?php echo _GIS_ALBINI_DEFAULT;?><br /> <input type='radio' name='fuelModel' id='fuelModelScott' value='Scott_custom' onchange='changeSettings()'><?php echo _GIS_SCOTT_CUSTOM;?><br /> <input type='radio' name='fuelModel' id='fuelModelScottDefault' value='Scott_default' onchange='changeSettings()'><?php echo _GIS_SCOTT_DEFAULT;?></form>                   <form action='' method='POST' id='rTimeForm'><!--<input type=\"checkbox\" name=\"realTimeCheckbox\" onchange=\"enableRealTimeAndRefresh(this.checked)\" <?php if(($_POST["realTimeCheckbox"])==1) echo "checked"?>><span style=\"font-size:9pt;\"><?php echo _SIMULATION_ANIMATION_QUE;?></span>--></form></div>";
			
			pos=new OpenLayers.LonLat(lon,lat);

			var EPSG4326 = new OpenLayers.Projection("EPSG:4326");
			var EPSG900913 = new OpenLayers.Projection("EPSG:900913");
			var latlon = pos.transform(EPSG4326,EPSG900913);

			popup_settings.lonlat=latlon;
		    popup_settings.updatePosition(latlon);	
			popup_settings.setSize(new OpenLayers.Size(275,350));
			$(".myOwnStyleForFramedCloudPopupContent").css("border","0px");
			$(".myOwnStyleForFramedCloudPopupContent").css("background-color","rgba(0,0,0,0)");
			$(".myOwnStyleForFramedCloudPopupContent").css("height","");
			$(".myOwnStyleForFramedCloudPopupContent").css("margin","1px");
			$("#chicken_FrameDecorationDiv_0").remove();
			$("#chicken_FrameDecorationDiv_1").remove();
			$("#chicken_FrameDecorationDiv_2").remove();
			$("#chicken_FrameDecorationDiv_3").remove();
			popup_settings.setContentHTML(content_settings);
			popup_settings.show();
			
			if(chosenFuelModel=="Albini_custom")
			{
				document.getElementById("fuelModelAlbini").checked = true;
				document.getElementById("fuelModelScott").checked = false;
				document.getElementById("fuelModelAlbiniDefault").checked = false;
				document.getElementById("fuelModelScottDefault").checked = false;
			}
			else if(chosenFuelModel=="Scott_custom")
			{
				document.getElementById("fuelModelAlbini").checked = false;
				document.getElementById("fuelModelScott").checked = true;
				document.getElementById("fuelModelAlbiniDefault").checked = false;
				document.getElementById("fuelModelScottDefault").checked = false;
			}
			else if(chosenFuelModel=="Albini_default")
			{
				document.getElementById("fuelModelAlbini").checked = false;
				document.getElementById("fuelModelScott").checked = false;
				document.getElementById("fuelModelAlbiniDefault").checked = true;
				document.getElementById("fuelModelScottDefault").checked = false;
			}
			else if(chosenFuelModel=="Scott_default")
			{
				document.getElementById("fuelModelAlbini").checked = false;
				document.getElementById("fuelModelScott").checked = false;
				document.getElementById("fuelModelAlbiniDefault").checked = false;
				document.getElementById("fuelModelScottDefault").checked = true;
			}
			
			//Ignition_point
			if(chosenIgnition=="pointIgnition")
			{
				document.getElementById("pointIgnition").checked = true;
				document.getElementById("perimeterIgnition").checked = false;
			}
			else if(chosenIgnition=="perimeterIgnition")
			{
				document.getElementById("pointIgnition").checked = false;
				document.getElementById("perimeterIgnition").checked = true;
			}
			
			
			
			document.querySelector("#slider").value=spread_sliderValue;
                                                      
        }
		
		function onChangeOfSlider(z)
		{
			spread_comp=0.1;
			if(z>=0 && z<5)
			{
				spread_comp=0.1;
			}
			if(z>=5 && z<15)
			{
				spread_comp=0.2;
			}
			if(z>=15 && z<=20)
			{
				spread_comp=0.2;
			}

			spread_sliderValue=z;
			changeSettings();
		}
		
		function enableRealTimeAndRefresh(checked)
		{
			document.getElementById("rTimeForm").submit();
		}


		//Vlastita vlaga
		function addVlastitaVlagaPopup(lat,lon) {
				//Postavke html content
		  var content_settings = "xxx";

			pos=new OpenLayers.LonLat(lon,lat);

			var EPSG4326 = new OpenLayers.Projection("EPSG:4326");
			var EPSG900913 = new OpenLayers.Projection("EPSG:900913");
			var latlon = pos.transform(EPSG4326,EPSG900913);

			popup_settings.lonlat=latlon;
		    popup_settings.updatePosition(latlon);	
			popup_settings.setSize(new OpenLayers.Size(300,300));
			popup_settings.setContentHTML(content_settings);
			popup_settings.show();
			jQuery("#slider").slider();
			jQuery("#slider").slider('option', 'max', 20);
			jQuery("#slider").slider('option', 'min', 1);
			jQuery("#slider").slider('option', 'step', 1);
			jQuery("#slider").slider('option', 'value', spread_sliderValue);
			jQuery("#slider").bind('slidechange', function(event, ui) {
	
			spread_comp=0.1;
			if(jQuery("#slider").slider('option', 'value')>=0 && jQuery("#slider").slider('option', 'value')<5)
			{
				spread_comp=0.1;
			}
			if(jQuery("#slider").slider('option', 'value')>=5 && jQuery("#slider").slider('option', 'value')<15)
			{
				spread_comp=0.2;
			}
			if(jQuery("#slider").slider('option', 'value')>=15 && jQuery("#slider").slider('option', 'value')<=20)
			{
				spread_comp=0.2;
			}

			spread_sliderValue=jQuery("#slider").slider('option', 'value');
			changeSettings();
			//alert(spread_comp);
			});

                                                             
        }


</script>