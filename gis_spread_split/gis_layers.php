<script type="text/javascript">

var debugMode=false;
var fesbFWI =true;

if(location.protocol == "https:")
{
	var BaseURL = "https://<?php echo $ip_https ?>/cgi-bin/mapserv?map=<?php echo $mapfile;?>&FORMAT=image%2Fpng&";
	var BaseURLRealtime = "https://<?php echo $ip_https ?>/cgi-bin/mapserv?map=<?php echo $map_file_user_realtime;?>&FORMAT=image%2Fpng&";
	//var IpZaWind="https://<?php echo $ip_https ?>/";
}
else
{
	var BaseURL = "http://<?php echo $ip_servera ?>/cgi-bin/mapserv?map=<?php echo $mapfile;?>&FORMAT=image%2Fpng&";
	var BaseURLRealtime = "http://<?php echo $ip_servera ?>/cgi-bin/mapserv?map=<?php echo $map_file_user_realtime;?>&FORMAT=image%2Fpng&";
	//var IpZaWind="http://<?php echo $ip_servera ?>/";
}

IpZaWind="";

var WebDir="<?php echo $WebDir; ?>";

//Kreiranje Google v3 slojeva
var google_phyV3 = new OpenLayers.Layer.Google(
	"<?php echo _GIS_GOOGLE_PHYSICAL ?>",
	{type: google.maps.MapTypeId.TERRAIN, numZoomLevels: 22}
);


var google_streetV3 = new OpenLayers.Layer.Google(
	"<?php echo _GIS_GOOGLE_STREETS_ ?>",
	{type: google.maps.MapTypeId.ROADMAP, numZoomLevels: 22}
);

var google_hybridV3 =  new OpenLayers.Layer.Google(
	"<?php echo _GIS_GOOGLE_HYBRID ?>",
	{type: google.maps.MapTypeId.HYBRID, numZoomLevels: 22}
);

var google_satteliteV3 =  new OpenLayers.Layer.Google(
	"<?php echo _GIS_GOOGLE_SATELLITE ?>",
	{type: google.maps.MapTypeId.SATELLITE, numZoomLevels: 22}
		)


var gmap = new OpenLayers.Layer.Google("Google Streets");



 var osm = new OpenLayers.Layer.OSM();  
		
		
/*kreiranje NASA WorldWind layera
ww2 = new OpenLayers.Layer.WMS( "NASA Global Mosaic", "http://wms.jpl.nasa.gov/wms.cgi",  {layers: "modis,global_mosaic"},{attribution:"Provided by NASA"});*/

// create OpenCycleMap layer
var osmcycle = new OpenLayers.Layer.OSM(
	"<?php echo _GIS_OSV_CYCLE ?>",
	"http://andy.sandbox.cloudmade.com/tiles/cycle/${z}/${x}/${y}.png",
	{'sphericalMercator': true, format: 'image/png', 'isBaseLayer':false }
);
	osmcycle.setVisibility(false);
	osmcycle.setOpacity(0.40);


// create OpenStreeatMap layer
var osmarender = new OpenLayers.Layer.OSM(
	"<?php echo _GIS_OSV_STREETS ?>",
	"http://tah.openstreetmap.org/Tiles/tile/${z}/${x}/${y}.png",
	{'sphericalMercator': true, format: 'image/png', 'isBaseLayer':false }
);
	osmarender.setVisibility(false);
	osmarender.setOpacity(0.40);
	
// definiranje raznih slojeva
	var reljef = new OpenLayers.Layer.WMS(
		"<?php echo _GIS_RELJEF ?>",
		BaseURL,
		{'layers': 'reljef'},
		{
			format: 'image/png','opacity': 0.4, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	reljef.setVisibility(false);

 var Aspect = new OpenLayers.Layer.WMS(
		"<?php echo _GIS_ASPEKT ?>",
		BaseURL,
		{'layers': 'Aspect'},
		{
			format: 'image/png','opacity': 0.4, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	Aspect.setVisibility(false);

 var Slope = new OpenLayers.Layer.WMS(
		"<?php echo _GIS_NAGIB ?>",
		BaseURL,
		{'layers': 'Slope'},
		{
			format: 'image/png','opacity': 0.4, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	Slope.setVisibility(false);

/****/
	 var model = new OpenLayers.Layer.WMS(
		"<?php echo 'model' ?>",
		BaseURL,
		{'layers': 'model'},
		{
			format: 'image/png','opacity': 0.4, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	model.setVisibility(false);
	/****/

 var Corine = new OpenLayers.Layer.WMS(
		"<?php echo _GIS_VEGETACIJA ?>",
		BaseURL,
		{'layers': 'corine_shape'},
		{
			format: 'image/png','opacity': 0.9, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	Corine.setVisibility(false);
	
	 var modelAlbini = new OpenLayers.Layer.WMS(
		"<?php echo _GIS_MODEL_ALBINI ?>",
		BaseURL,
		{'layers': 'modelAlbini'},
		{
			format: 'image/png','opacity': 0.9, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	modelAlbini.setVisibility(false);
	
	var modelScott = new OpenLayers.Layer.WMS(
		"<?php echo _GIS_MODEL_SCOTT ?>",
		BaseURL,
		{'layers': 'modelScott'},
		{
			format: 'image/png','opacity': 0.9, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	modelScott.setVisibility(false);
	
	
	
	var modelAlbiniDefault = new OpenLayers.Layer.WMS(
		"<?php echo _GIS_MODEL_ALBINI_DEFAULT ?>",
		BaseURL,
		{'layers': 'modelAlbiniDefault'},
		{
			format: 'image/png','opacity': 0.9, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	modelAlbiniDefault.setVisibility(false);
	
	var modelScottDefault = new OpenLayers.Layer.WMS(
		"<?php echo _GIS_MODEL_SCOTT_DEFAULT ?>",
		BaseURL,
		{'layers': 'modelScottDefault'},
		{
			format: 'image/png','opacity': 0.9, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	modelScottDefault.setVisibility(false);
	
	
	
	

	
 var MIRIP = new OpenLayers.Layer.WMS(
		"<?php echo _GIS_MIRIP ?>",
		BaseURL,
		{'layers': 'MIRIP'},
		{
			format: 'image/png','opacity': 0.8, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	MIRIP.setVisibility(false);
	
	
	
	 var EruptiveFireRisk = new OpenLayers.Layer.WMS(
		"<?php echo _GIS_ERUPTIVERISK ?>",
		BaseURL,
		{'layers': 'EruptiveFireRisk'},
		{
			format: 'image/png','opacity': 0.8, 'transparent': true, 
			'isBaseLayer': false
		}
	);
	EruptiveFireRisk.setVisibility(false);
	
//Za razliku od drugih, ovdje se otvara gis_cgi_wind_oo.php kojim se kontrolira trenutni vjetar

		//alert(korisnik);
		var trenutniWind = new OpenLayers.Layer.WMS(
		//"<?php echo _GIS_WIND_NOW ?> (<?php echo _GIS_SPLIT ?>)",
		"<?php echo _GIS_VJETAR_TRENUTNI ?>",
		IpZaWind+"vjetar/gis_cgi_wind_oo.php?map="+WebDir+"/vjetar/webgiszupanija.map&vjetar=trenutni&FORMAT=image%2Fpng&user_name="+korisnik+"&",
		{'layers': 'wind'},
		{
			format: 'image/png','opacity': 0.8, 'transparent': true, 
			'isBaseLayer': false, 'singleTile': true, 'ratio': 1
		}
		);
		trenutniWind.setVisibility(false);
		//Force redraw
		trenutniWind.events.register("visibilitychanged" , this,function(event){
			trenutniWind.mergeNewParams({ blah:Math.random() }); 
			trenutniWind.redraw(true);
		});
		
		

		
		var vlastitiWind = new OpenLayers.Layer.WMS(
				"<?php echo _GIS_VJETAR_VLASTITI ?>",
				IpZaWind+"vjetar/gis_cgi_wind_oo.php?map="+WebDir+"/vjetar/webgiszupanija.map&vjetar=vlastiti&FORMAT=image%2Fpng&user_name="+korisnik+"&",
				{'layers': 'wind'},
				{
					format: 'image/png','opacity': 0.8, 'transparent': true, 
					'isBaseLayer': false, 'singleTile': true, 'ratio': 1
				}
				);


		vlastitiWind.setVisibility(false);
		//Force redraw
		vlastitiWind.events.register("visibilitychanged" , this,function(event){
			vlastitiWind.mergeNewParams({ blah:Math.random() }); 
			vlastitiWind.redraw(true);
		});
		
		var regionTemp = new OpenLayers.Layer.WMS(
			"<?php echo "Region temp" ?>",
			BaseURL,
			{'layers': 'regionTemp'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		regionTemp.setVisibility(false);
		
		var FWITemp = new OpenLayers.Layer.WMS(
			"<?php echo "FWI (DHMZ)" ?>",
			BaseURL,
			{'layers': 'FWITemp'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		FWITemp.setVisibility(false); 
		
		var mois_liveTemp = new OpenLayers.Layer.WMS(
			"<?php echo _GIS_MOIS_LIVE ?>",
			BaseURL,
			{'layers': 'mois_liveTemp'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		mois_liveTemp.setVisibility(false); 
		
		var mois_live_customTemp = new OpenLayers.Layer.WMS(
			"<?php echo _GIS_MOIS_LIVE_CUSTOM ?>",
			BaseURL,
			{'layers': 'mois_live_customTemp'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		mois_live_customTemp.setVisibility(false); 
		
		var DalekovodiTemp = new OpenLayers.Layer.WMS(
			"<?php echo "Dalekovodi" ?>",
			BaseURL,
			{'layers': 'DalekovodiTemp'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		DalekovodiTemp.setVisibility(false); 
		
		var ObjektiTemp = new OpenLayers.Layer.WMS(
			"<?php echo "Objekti" ?>",
			BaseURL,
			{'layers': 'ObjektiTemp'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		ObjektiTemp.setVisibility(false); 
		
		var CesteTemp = new OpenLayers.Layer.WMS(
			"<?php echo "Ceste" ?>",
			BaseURL,
			{'layers': 'CesteTemp'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		CesteTemp.setVisibility(false); 
		
		var Padaline = new OpenLayers.Layer.WMS(
			"<?php echo _GIS_PRECIP ?>",
			BaseURL,
			{'layers': 'Padaline'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		Padaline.setVisibility(false); 
		
		var precModified = new OpenLayers.Layer.WMS(
			"<?php echo "precModified" ?>",
			BaseURL,
			{'layers': 'precModified'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		precModified.setVisibility(false); 
		
		
		var windAspect = new OpenLayers.Layer.WMS(
			"<?php echo "windAspect" ?>",
			BaseURL,
			{'layers': 'windAspect'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		windAspect.setVisibility(false); 
		
		var windSlope = new OpenLayers.Layer.WMS(
			"<?php echo "windSlope" ?>",
			BaseURL,
			{'layers': 'windSlope'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		windSlope.setVisibility(false); 
		
		
		var MIRIPvector = new OpenLayers.Layer.WMS(
			"<?php echo "AdriaFireRisk vector" ?>",
			BaseURL,
			{'layers': 'MIRIPvector'},
			{
				format: 'image/png','opacity': 0.9, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		MIRIPvector.setVisibility(false); 

		
		
		
		
		
		
		//FESB FWI,...
		var FWI_fesb = new OpenLayers.Layer.WMS(
			"<?php echo "FWI" ?>",
			BaseURL,
			{'layers': 'FWI_fesb'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		FWI_fesb.setVisibility(false);
		
		var FFMC_fesb = new OpenLayers.Layer.WMS(
			"<?php echo "FFMC" ?>",
			BaseURL,
			{'layers': 'FFMC_fesb'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		FFMC_fesb.setVisibility(false); 
		
		var DMC_fesb = new OpenLayers.Layer.WMS(
			"<?php echo "DMC" ?>",
			BaseURL,
			{'layers': 'DMC_fesb'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		DMC_fesb.setVisibility(false); 
		
		var DC_fesb = new OpenLayers.Layer.WMS(
			"<?php echo "DC" ?>",
			BaseURL,
			{'layers': 'DC_fesb'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		DC_fesb.setVisibility(false); 
		
		var ISI_fesb = new OpenLayers.Layer.WMS(
			"<?php echo "ISI" ?>",
			BaseURL,
			{'layers': 'ISI_fesb'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		ISI_fesb.setVisibility(false); 
		
		var BUI_fesb = new OpenLayers.Layer.WMS(
			"<?php echo "BUI" ?>",
			BaseURL,
			{'layers': 'BUI_fesb'},
			{
				format: 'image/png','opacity': 0.8, 'transparent': true, 
				'isBaseLayer': false
			}
		);
		BUI_fesb.setVisibility(false); 
		
		
		
		
		
		
		
		
		
		
		
		
		
		

		var spread_raster = new OpenLayers.Layer.WMS(
			"<?php echo _GIS_POZAR_RASTER ?>",
			BaseURL,
			{'layers': 'Pozar'},
			{
				format: 'image/png','opacity': 0.9, 'transparent': true, 
				'isBaseLayer': false
			}
		);

		spread_raster.setVisibility(true); 

		var spread_vector = new OpenLayers.Layer.WMS(
			"<?php echo _GIS_POZAR_VECTOR ?>",
			BaseURL,
			{'layers': 'Pozar_vector'},
			{
				format: 'image/png','opacity': 0.9, 'transparent': true, 
				'isBaseLayer': false
			}
		);

		spread_vector.setVisibility(true); 


		 layer = new OpenLayers.Layer.OSM( "<?php echo _GIS_OSMMAP ?>");
		 
		 
		 
		 
		 //Additional WMSs
		 
		 var DWD_FWI_Forecast  = new OpenLayers.Layer.WMS(
		"<?php echo "Fire Weather Index Forecast" ?>",
		"http://geohub.jrc.ec.europa.eu/forest/effis/mapserv/fwi?FORMAT=image%2Fpng&TRANSPARENT=true&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetMap&srs=EPSG:4326&format=image/jpeg",
		{'layers': 'fd_dwd25_FWI0'},
		{
			format: 'image/png','opacity': 0.9, 'transparent': true, 
			'isBaseLayer': false
		}
		);
		DWD_FWI_Forecast.setVisibility(false);
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		 
		
 function addDefinedLayers()
		{
			//Ground slojevi
			map.addLayers([layer, google_satteliteV3,google_phyV3, google_streetV3, google_hybridV3, google_satteliteV3]);
			//map.addLayers([osm, gmap]);
			
			//vidljivost
			//map.addLayer(visLayer);

			//Overlay slojevi
			//map.addLayers([trenutniWind, vlastitiWind, Padaline, Corine, modelAlbiniDefault, modelScottDefault, modelAlbini, modelScott, MIRIP, EruptiveFireRisk, spread_raster, spread_vector,  mois_live_customTemp, mois_liveTemp]);
			
			map.addLayers([DWD_FWI_Forecast]);
			
			if(fesbFWI)
			{
				map.addLayers([BUI_fesb, ISI_fesb ,DC_fesb, DMC_fesb, FFMC_fesb, FWI_fesb]);
			}
			
			map.addLayers([ mois_live_customTemp, mois_liveTemp, Padaline, trenutniWind, vlastitiWind, modelAlbini, modelScott, modelAlbiniDefault, modelScottDefault, Corine, EruptiveFireRisk, MIRIP, polygonLayerPerimeter /*Fire front*/, polygonLayer /*Fire barrier*/ ,spread_raster, spread_vector]);

			/*if(fesbFWI)
				map.addLayers([]);
			}*/
			
			if(debugMode)
			{
				map.addLayers([regionTemp, FWITemp, DalekovodiTemp, CesteTemp, ObjektiTemp, MIRIPvector, windSlope, windAspect, precModified]);
			}
				
		
		}
			
		
		
</script>
