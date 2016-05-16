<script type="text/javascript">
var panel;

//Geometrijski oblici
var sketchSymbolizers = {
	"Point": {
		pointRadius: 4,
		graphicName: "square",
		fillColor: "white",
		fillOpacity: 1,
		strokeWidth: 1,
		strokeOpacity: 1,
		strokeColor: "#FFFF00"
	},
	"Line": {
		strokeWidth: 3,
		strokeOpacity: 1,
		strokeColor: "#FFFF00",
		strokeDashstyle: "longdash"
	},
	"Polygon": {
		strokeWidth: 2,
		strokeOpacity: 1,
		strokeColor: "#FFFF00",
		fillColor: "red",
		fillOpacity: 0.3
	}
};


//Kreiranje stila
var style = new OpenLayers.Style();
style.addRules([
	new OpenLayers.Rule({symbolizer: sketchSymbolizers})
]);
var styleMap = new OpenLayers.StyleMap({"default": style});


//Ispis rezultata measure tool-a
//Ime div-a je output
function handleMeasurements(event) {
	var geometry = event.geometry;
	var units = event.units;
	var order = event.order;
	var measure = event.measure;
	var element = document.getElementById('measure');
	var out = "";
	if(order == 1) {
		out += "<?php echo _GIS_UDALJENOST ?>: " + measure.toFixed(3) + " " + units;
	} else {
		out += "<?php echo _GIS_POVRSINA ?>: " + measure.toFixed(3) + " " + units + "<sup>2</" + "sup>";
	}
	element.innerHTML = out;
}

//Uključivanje/isključivanje measure toola
//geodesic uključen 
function toggleMeasureControl(element) {
	
	for(key in measureControls) {
		var control = measureControls[key];
		if(element.value == key && element.checked) {
			control.activate();
			control.geodesic = "true";
		} else {
			control.deactivate();
		}
	}
}
        

//kreiranje kotrola za measure tool (UI)
var optionsLine = {
    handlerOptions: {
        persist: true,
        layerOptions: {styleMap: styleMap}
    },
    displayClass: "olControlMeasureDistance",
    title: "<?php echo _GIS_UDALJENOST ?>"
};

var optionsPolygon = {
    handlerOptions: {
        persist: true,
        layerOptions: {styleMap: styleMap}
    },
    displayClass: "olControlMeasureArea",
    title: "<?php echo _GIS_POVRSINA ?>"
};

measureControls = {
    line: new OpenLayers.Control.Measure(
      OpenLayers.Handler.Path, 
      optionsLine 
    ),
    polygon: new OpenLayers.Control.Measure(
        OpenLayers.Handler.Polygon, 
        optionsPolygon
    )
};

for(var key in measureControls) {
    control = measureControls[key];
    control.events.on({
        "measure": handleMeasurements,
        "measurepartial": handleMeasurements
    });
}     



//Funkcija koja se poziva u init() main php file-a
//var panel = createPanel();
//Kreiramo panel za prikaz measure tool-a
//Panel se sastoji od kotrole za pomak, kotrole za zoom (kvadrat), te dvije measure kontrole, line i area
//a,b pozicioniranje
function createPanel(a, b)
{
	var pomak = new OpenLayers.Control.DragPan({title:'Pomak', displayClass: 'olControlPanMap'});

	var panel = new OpenLayers.Control.Panel({ defaultControl: pomak,
												position: new OpenLayers.Pixel(a,b) });

	panel.addControls([
		pomak,
		new OpenLayers.Control.ZoomBox({alwaysZoom:true, title:'Zoom', displayClass: 'olControlZoomBox'}),
		measureControls.line,
		measureControls.polygon
		]);

	return panel;
}
</script>