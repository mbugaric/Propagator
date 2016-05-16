<script type="text/javascript">
// map kao globalna varijabla
var map, drawControls;
var panelZoomBox;
var polygonLayer;
var polygonLayerPerimeter;
var hoverControl;
var LayerSwitcher;


OpenLayers.Control.Hover = OpenLayers.Class(OpenLayers.Control, 
{                
	defaultHandlerOptions: {
		'delay': 500,
		'pixelTolerance': null,
		'stopMove': false
	},

	initialize: function(options) {
		this.handlerOptions = OpenLayers.Util.extend(
			{}, this.defaultHandlerOptions
		);
		OpenLayers.Control.prototype.initialize.apply(
			this, arguments
		); 
		this.handler = new OpenLayers.Handler.Hover(
			this,
			{'pause': this.onPause, 'move': this.onMove},
			this.handlerOptions
		);
	}, 

	onPause: function(evt) {
		var latlonMER = map.getLonLatFromViewPortPx(evt.xy);
		x_getInfo(latlonMER.lon,latlonMER.lat, korisnik, WebDir, grassmapset, function(res){
			
			$("#getInfo").html(res);
			//alert(res);
			
		});
	},

	onMove: function(evt) {
		//alert("ASD2");
		// if this control sent an Ajax request (e.g. GetFeatureInfo) when
		// the mouse pauses the onMove callback could be used to abort that
		// request.
	}
});

//divname - ime div koji sluzi za prikaz mape
//panel - panel koji je definiran u measure tool OL_Measure.js
// imena div-ova: scalebar i mouseposition
function createMap(divname, panel)
{
	if(!panel) panel=new OpenLayers.Control.Panel();

	//Referentna karta
   var ol = new OpenLayers.Layer.WMS(
		"OpenLayers WMS", 
		"http://labs.metacarta.com/wms/vmap0",
		{layers: 'basic'}
	);
	
	//finalno
	var selected_polygon_style_barrier = {
		strokeWidth: 2,
		strokeColor: '#1C9EBF',
		fillColor: '#9BE8FC',
		fillOpacity: 0.7
	};
	
	//za vrijeme crtanja
	var drawOptionsBarrier =	{
		'handlerOptions': {
			'style': {
				'strokeColor': '#1C9EBF',
				'strokeOpacity': 1,
				'strokeWidth': 2,
				'fillColor': '#9BE8FC',
				'fillOpacity': 0.5,
				'pointRadius': 3
			}
		}
	};
	
	polygonLayer = new OpenLayers.Layer.Vector("<?php echo _GIS_FIREBARRIER?>");
	polygonLayer.style = selected_polygon_style_barrier;
	
	//finalno
	var selected_polygon_style = {
		strokeWidth: 2,
		strokeColor: '#862A08',
		fillColor: '#F15D25',
		fillOpacity: 0.7
	};
	
	//za vrijeme crtanja
	var drawOptionsPerimeters =	{
		'handlerOptions': {
			'style': {
				'strokeColor': '#862A08',
				'strokeOpacity': 1,
				'strokeWidth': 2,
				'fillColor': '#F15D25',
				'fillOpacity': 0.5,
				'pointRadius': 3
			}
		}
	};
	
	polygonLayerPerimeter = new OpenLayers.Layer.Vector("<?php echo _GIS_FIREPERIMETER?>");
	polygonLayerPerimeter.style = selected_polygon_style;
	

	// Opcije za referentnu kartu
	var options1 = {layers: [ol]};

					//Creation of a custom panel with a ZoomBox control with the alwaysZoom option sets to true				
				OpenLayers.Control.CustomNavToolbar = OpenLayers.Class(OpenLayers.Control.Panel, {
	
				    /**
				     * Constructor: OpenLayers.Control.NavToolbar 
				     * Add our two mousedefaults controls.
				     *
				     * Parameters:
				     * options - {Object} An optional object whose properties will be used
				     *     to extend the control.
				     */
					
					
				    initialize: function(options) {
				        OpenLayers.Control.Panel.prototype.initialize.apply(this, [options]);
				        this.addControls([
				          new OpenLayers.Control.Navigation(),
						  //Here it come
				          new OpenLayers.Control.ZoomBox({alwaysZoom:true})
				        ]);
						// To make the custom navtoolbar use the regular navtoolbar style
						this.displayClass = 'olControlNavToolbar'
				    },
					
					
				
				    /**
				     * Method: draw 
				     * calls the default draw, and then activates mouse defaults.
				     */
				    draw: function() {
				        var div = OpenLayers.Control.Panel.prototype.draw.apply(this, arguments);
                        this.defaultControl = this.controls[0];
				        return div;
				    }
				});
				
					
	LayerSwitcher = new OpenLayers.Control.LayerSwitcher({'ascending':false});
					
	//Opcije za glavnu kartu
	var options = {
		div: divname,
		projection: new OpenLayers.Projection("EPSG:900913"), //EPSG:900913 je Google-ova projekcija
		displayProjection: new OpenLayers.Projection("EPSG:900913"),
		eventListeners: {
            "changelayer": mapLayerChanged
		},
		controls: [
					new OpenLayers.Control.Navigation(),
					new OpenLayers.Control.PanZoomBar(),
					LayerSwitcher,
					panel,
					//new OpenLayers.Control.Permalink(),
					new OpenLayers.Control.ScaleLine
									(
										{
											div: document.getElementById("scalebar"),
											minWidth: 150,
											maxWidth: 250,
											displaySystem: "metric"
										}
									),
					new OpenLayers.Control.MousePosition
									(
										{
											div: document.getElementById("mouseposition"),
											prefix: "<?php echo _GIS_LAT_LON_KOORDINATE?>: (", separator: ",", suffix: ")",
											displayProjection: new OpenLayers.Projection("EPSG:4326")  // EPSG:4326 je latlon projekcija
										}
									),
					new OpenLayers.Control.OverviewMap({maximized: false }),
					new OpenLayers.Control.KeyboardDefaults()
				],
		units: "m",
		
		numZoomLevels: 18,
		maxResolution: 16543.0339,
		maxExtent: new OpenLayers.Bounds(<?php echo $max_extend_west ?>, <?php echo $max_extend_south ?>, <?php echo $max_extend_east ?>, <?php echo $max_extend_north ?>).transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913")) 
		//Ovdje se samo odreduju krajnje granice, extent se postavlja kasnije
	};

	map = new OpenLayers.Map('map', options);

	panelZoomBox = new OpenLayers.Control.CustomNavToolbar();

	
	

	
	drawControls = {
                    polygon: new OpenLayers.Control.DrawFeature(polygonLayer,
                        OpenLayers.Handler.Polygon, drawOptionsBarrier)
                      
                };
				
	drawControlsPerimeter = {
                    polygon: new OpenLayers.Control.DrawFeature(polygonLayerPerimeter,
                        OpenLayers.Handler.Polygon, drawOptionsPerimeters)
                      
                };
				
	hoverControl =  new OpenLayers.Control.Hover({
                        handlerOptions: {
                            'delay': 1000
                        }
                    })
	
	map.addControl(hoverControl);
	hoverControl.activate();

	map.addControl(drawControls.polygon);
	map.addControl(drawControlsPerimeter.polygon);
	map.addControl(panelZoomBox);
	
	drawControls.polygon.handler.freehandToggle=null;
	drawControlsPerimeter.polygon.handler.freehandToggle=null;

	//drawControls.polygon.activate();
	
	
	return map;

}
</script>