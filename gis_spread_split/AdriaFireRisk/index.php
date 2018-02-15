<?php include 'baza2.php'; ?>
<!DOCTYPE html>
<html>
  <head> 
    <title>AdriaFireRisk</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="slova.css">
	<link rel="stylesheet" type="text/css" href="blink.css">
	<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.2.min.js"></script>
    <script src="http://openlayers.org/en/v3.14.2/build/ol.js"></script>  
	<link rel="stylesheet" href="http://openlayers.org/en/v3.14.2/css/ol.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="ol3-layerswitcher.css">
	<script src="./ol3-layerswitcher.js"></script>
    <style>
        #map {
          position: relative;
        }
	    #myDiv 
		{
		  height:104px;
		  width:70%;
		  position: absolute;
		  top: 20px;
		  left: 60px;
		}
		#myDiv img
		{
		  width: 490px;
		  height: 100px;
		  margin:auto;
		  display:inline;
		}
    </style>
  </head>
  <body>
   
    <div id="map" data-toggle="popover" class="map"><div id="popup" data-toggle="popover"></div></div>
	<div id="myDiv">
		<img src="../css/images/logo490x100.png" >
	</div>
    <script>
	
	function test(indexOpasnosti)
	{
		//alert(indexOpasnosti)
	}
	
	
	
	var content1 = ['<div class="slika">',
			'<h6>AdriaFireRisk</h6>',
			'<div class="container"  onclick=\'test("VERY LOW")\'>',
				'<div class="one"><div class="panel rizik1 blink_me_1"><h1>VERY LOW</h1></div></div>',
				'<div class="two"><div class="panel rizik2"><h2>LOW</h2></div></div>',
				'<div class="three"><div class="panel rizik3"><h3>MODERATE</h3></div></div>',
				'<div class="four"><div class="panel rizik4"><h4>&nbsp;&nbsp;&nbsp;HIGH</h4></div></div>',
				'<div class="five"><div class="panel rizik5"><h5>&nbsp;&nbsp;&nbsp;VERY HIGH</h5></div></div>',
			'</div>',
		'</div>',].join('');
	var content2 = ['<div class="slika">',
			'<h6>AdriaFireRisk</h6>',
			'<div class="container"  onclick=\'test("LOW")\' >',
				'<div class="one"><div class="panel rizik1"><h1>VERY LOW</h1></div></div>',
				'<div class="two"><div class="panel rizik2 blink_me_2"><h2>LOW</h2></div></div>',
				'<div class="three"><div class="panel rizik3"><h3>MODERATE</h3></div></div>',
				'<div class="four"><div class="panel rizik4"><h4>&nbsp;&nbsp;&nbsp;HIGH</h4></div></div>',
				'<div class="five"><div class="panel rizik5"><h5>&nbsp;&nbsp;&nbsp;VERY HIGH</h5></div></div>',
			'</div>',
		'</div>',].join('');
	var content3 = ['<div class="slika">',
			'<h6>AdriaFireRisk</h6>',
			'<div class="container"  onclick=\'test("MODERATE")\'>',
				'<div class="one"><div class="panel rizik1"><h1>VERY LOW</h1></div></div>',
				'<div class="two"><div class="panel rizik2"><h2>LOW</h2></div></div>',
				'<div class="three"><div class="panel rizik3 blink_me_3"><h3>MODERATE</h3></div></div>',
				'<div class="four"><div class="panel rizik4"><h4>&nbsp;&nbsp;&nbsp;HIGH</h4></div></div>',
				'<div class="five"><div class="panel rizik5"><h5>&nbsp;&nbsp;&nbsp;VERY HIGH</h5></div></div>',
			'</div>',
		'</div>',].join('');
	var content4 = ['<div class="slika">',
			'<h6>AdriaFireRisk</h6>',
			'<div class="container"  onclick=\'test("HIGH")\'">',
				'<div class="one"><div class="panel rizik1"><h1>VERY LOW</h1></div></div>',
				'<div class="two"><div class="panel rizik2"><h2>LOW</h2></div></div>',
				'<div class="three"><div class="panel rizik3"><h3>MODERATE</h3></div></div>',
				'<div class="four"><div class="panel rizik4 blink_me_4"><h4>&nbsp;&nbsp;&nbsp;HIGH</h4></div></div>',
				'<div class="five"><div class="panel rizik5"><h5>&nbsp;&nbsp;&nbsp;VERY HIGH</h5></div></div>',
			'</div>',
		'</div>',].join('');
	var content5 = ['<div class="slika">',
			'<h6>AdriaFireRisk</h6>',
			'<div class="container"   onclick=\'test("VERY HIGH")\'>',
				'<div class="one"><div class="panel rizik1"><h1>VERY LOW</h1></div></div>',
				'<div class="two"><div class="panel rizik2"><h2>LOW</h2></div></div>',
				'<div class="three"><div class="panel rizik3"><h3>MODERATE</h3></div></div>',
				'<div class="four"><div class="panel rizik4"><h4>&nbsp;&nbsp;&nbsp;HIGH</h4></div></div>',
				'<div class="five"><div class="panel rizik5 blink_me_5"><h5>&nbsp;&nbsp;&nbsp;VERY HIGH</h5></div></div>',
			'</div>',
		'</div>',].join('');
	var content = ['<div class="slika">',
			'<h6>AdriaFireRisk</h6>',
			'<div class="container">',
				'<div class="one"><div class="panel rizik1"><h1>VERY LOW</h1></div></div>',
				'<div class="two"><div class="panel rizik2"><h2>LOW</h2></div></div>',
				'<div class="three"><div class="panel rizik3"><h3>MODERATE</h3></div></div>',
				'<div class="four"><div class="panel rizik4"><h4>&nbsp;&nbsp;&nbsp;HIGH</h4></div></div>',
				'<div class="five"><div class="panel rizik5"><h5>&nbsp;&nbsp;&nbsp;VERY HIGH</h5></div></div>',
			'</div>',
		'</div>',].join('');
	var jArray1 = [<?php echo '"'.implode('","', $lat).'"' ?>];
	var jArray2= <?php echo json_encode($longi); ?>;
	var jArray3= <?php echo json_encode($risk); ?>;	
	var vectorSource=new ol.source.Vector({});
	

	  for(var i=0;i<<?php echo $x; ?>;i++){
		  switch(parseInt(jArray3[i])){
		  case 1:
		  var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([ parseFloat(jArray2[i]), parseFloat(jArray1[i])], 'EPSG:4326', 'EPSG:3857')),
	    'risk':content1,
		dog:1})
		vectorSource.addFeature(iconFeature);
		break;
		  case 2:
		  var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([ parseFloat(jArray2[i]), parseFloat(jArray1[i])], 'EPSG:4326', 'EPSG:3857')),
	  'risk':content2,
	  dog:2})
		vectorSource.addFeature(iconFeature);
		break;
		  case 3:
		  var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([ parseFloat(jArray2[i]), parseFloat(jArray1[i])], 'EPSG:4326', 'EPSG:3857')),
	  'risk':content3,
	  dog:3})
		vectorSource.addFeature(iconFeature);
		  break;
		case 4:
		  var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([ parseFloat(jArray2[i]), parseFloat(jArray1[i])], 'EPSG:4326', 'EPSG:3857')),
	    'risk':content4,
		dog:4})
		vectorSource.addFeature(iconFeature);
		break;
		case 5:
		  var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([ parseFloat(jArray2[i]), parseFloat(jArray1[i])], 'EPSG:4326', 'EPSG:3857')),
	    'risk':content5,
		dog:5})
		vectorSource.addFeature(iconFeature);
		break;
		default:
		var iconFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([ parseFloat(jArray2[i]), parseFloat(jArray1[i])], 'EPSG:4326', 'EPSG:3857')),
	    'risk':content,
		dog:2})
		vectorSource.addFeature(iconFeature);
		  }
      }
	  
	  var iconStyle = new ol.style.Style({
		  image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
			anchor: [0.5, 46],
			anchorXUnits: 'fraction',
			anchorYUnits: 'pixels',
			opacity: 0.75,
			src: 'data/risk-icon.png'
		  }))
		});
		
		iconFeature.setStyle(iconStyle);

		  
		var vectorLayer = new ol.layer.Vector({
		title: 'AdriaFireRisk panels',
        source:vectorSource,
		style:iconStyle  }); 
		
		var rasterLayer = new ol.layer.Tile({
            source: new ol.source.OSM(),
			})

		var AFR = new ol.layer.Tile({
			title: 'AdriaFireRisk',
			source: new ol.source.TileWMS(/** @type {olx.source.TileWMSOptions} */ ({
			  url: 'http://propagator.adriaholistic.eu/cgi-bin/mapserv?map=/home/holistic/webapp/gis_spread_split/user_files/admin/sd_zupanija.map&FORMAT=image%2Fpng&',
			  params: {'LAYERS': 'MIRIP', 'TILED': true}
			}))
		})
		
		
		
		
		var map = new ol.Map({
        layers: [
			
            new ol.layer.Tile({
                title: 'Base OSM layer',
                source: new ol.source.OSM() 
            }),
			AFR,
            vectorLayer
            ],
        target: document.getElementById('map'),
        controls: ol.control.defaults({
          attributionOptions: /** @type {olx.control.AttributionOptions} */ ({
            collapsible: false   })}),
        view: new ol.View({
          center: [0, 0],
          zoom: 6  })}); 
		  
		  // LayerSwitcher

		var layerSwitcher = new ol.control.LayerSwitcher({
			tipLabel: 'Legend' // Optional label for button
		});
		map.addControl(layerSwitcher);
		
		map.getView().setCenter(ol.proj.transform([16, 43], 'EPSG:4326', 'EPSG:3857'));
		

		
		if (ol.Map.prototype.hideLayer === undefined) {    
			ol.Map.prototype.hideLayer = function (id) {
				var layer;
				this.getLayers().forEach(function (lyr) {
					console.log(lyr);
					if (lyr.T.title == id) {
						lyr.T.visible=false;
					}            
				});
				return layer;
			}
		}
		
		var layer = this.map.hideLayer("AdriaFireRisk");
		
		
      /*var element = document.getElementById('popup');
      var popup = new ol.Overlay({
        element: element,
        positioning: 'bottom-center',
        stopEvent: true })
      map.addOverlay(popup);
      map.on('click',function(evt) {
		
        var feature = map.forEachFeatureAtPixel(evt.pixel,
            function(feature) {
              return feature;
            });
        if (feature) {
		  popup.setPosition(evt.coordinate);
          $('[data-toggle="popover"]').popover({
            placement: 'auto',
            html: true,
            content: feature.get('risk'),
          });
          $(element).popover('show');

		  
        } else {
          $(element).popover('destroy');
        }
      });*/
	  

		var element = document.getElementById('popup');
		var isVisible=false;

		var popup = new ol.Overlay({
		  element: element,
		  positioning: 'bottom-center',
		  stopEvent: false,
		  opacity: 0.2,
		});
		map.addOverlay(popup);

		// display popup on click
		map.on('click', function(evt) {
		  var feature = map.forEachFeatureAtPixel(evt.pixel,
			  function(feature, layer) {
				return feature;
			  });
		  if (feature && !isVisible) {
			var geometry = feature.getGeometry();
			var coord = geometry.getCoordinates();
			popup.setPosition(coord);
			$(element).popover({
			  'placement': 'top left',
			  'html': true,
			  'content': feature.get('risk')
			});
			$(element).popover('show');
			isVisible=true;
			$(".fade").css("opacity",1)
		  } else {
			$(element).popover('destroy');
			isVisible=false;
			$(".fade").css("opacity",0)
			//$(element).trigger("click");
		  }
		});

		// change mouse cursor when over marker
		map.on('pointermove', function(e) {
		  if (e.click) {
			$(element).popover('destroy');
			isVisible=false;
			return;
		  }
		  var pixel = map.getEventPixel(e.originalEvent);
		  var hit = map.hasFeatureAtPixel(pixel);
		  map.getTarget().style.cursor = hit ? 'pointer' : '';
		});
	  

	
    </script>
  </body>
</html>