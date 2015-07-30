
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MAP POI DATA EXPORT</title>

<!-- Bootstrap -->
    <link href="public_html/css/bootstrap.min.css" rel="stylesheet">
    <link href="public_html/css/bootstrap-theme.min.css" rel="stylesheet">
    

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="public_html/css/common.css" rel="stylesheet">


<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
<script src="public_html/js/getByName.js"></script>
<script src="public_html/js/Export.js"></script>
<script src="public_html/js/togeojson.js"></script>
<script src="public_html/js/leaflet.filelayer.js"></script>
<script src="public_html/js/Edit.SimpleShape.js"></script>
<script src="public_html/js/Edit.Rectangle.js"></script>
<script src="public_html/js/FunctionButton.js"></script>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="public_html/js/jquery-1.11.2.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="public_html/js/bootstrap.min.js"></script>
    <script src="public_html/js/npm.js"></script>

<style>
div#container {width: 200px; height: 650px; margin-left: 1200px; margin-top: -750px; position:absolute; padding: 6px 8px;
			font: 16px/18px Arial, Helvetica, sans-serif;
			background: white;
			background: rgba(255,255,255,0.8);
			box-shadow: 0 0 15px rgba(0,0,0,0.2);
			border-radius: 5px;
   			overflow:hidden;
   			} 


html, body { height: 100%; }
#map { height: 93%; }
.leaflet-edit-move { cursor: move; }
.leaflet-edit-resize { cursor: pointer; }

		.info {
			height: 680px;
			width: 170px;
			padding: 6px 8px;
			font: 16px/18px Arial, Helvetica, sans-serif;
			background: white;
			background: rgba(255,255,255,0.8);
			box-shadow: 0 0 15px rgba(0,0,0,0.2);
			border-radius: 5px;
			overflow: auto;
		}
		

		.legend {
			text-align: left;
			line-height: 18px;
			color: #555;
		}
		.legend i {
			width: 18px;
			height: 18px;
			float: left;
			margin-right: 8px;
			opacity: 0.7;
		}
table {
	 padding:-10px;
	 font-size:14px;
	 border-spacing: 10px;
}

</style>
</head>
<body>
<div id="map"></div>
<div class="shapeformat">
<div>
	&nbsp;&nbsp;&nbsp;Format: <select id="format" onchange="javascript: updateFormat();"><option value="A4">A4</option><option value="A5" selected>A5</option><option value="A6">A6</option></select>
	<input type="text" size="3" id="width" value="">×<input type="text" size="3" id="height" value="">
	&nbsp;Margins: <select id="margin"><option value="0">0</option><option value="5">5</option><option value="7">7</option><option value="10" selected>10</option><option value="15">15</option></select>
	<input type="button" value="Fit" class="fit_button"onclick="javascript:fit();">
	<input type="checkbox" id="force" onclick="javascript:updateRect();"><span for="force"> use size</span>
</div>
<div id="bbox" style="font-family: monospace;"></div>
<div>



<div id="searchContainer">
<form> 
<input type="text" id="keyword" name="keyword">
<div id="delete"><span id="x">x</span></div>
<input type="button" name="submit" id="submit" onclick="test(document.getElementById('keyword').value)">
</form>
</div>


<div id="txtHint" style="overflow:auto; height: 710px; width: 250px; position: absolute; right:10px; top:10px;"></div>
<input id="hiddendata" type="hidden">

<!-- Large modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" style="position:absolute; right: 20px; top:760px">Export</button>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">EXPORT OPTION</h4>
      </div>
      <div class="modal-body">
        
     
    <div id="table_div">   
	    <label>Source Table</label>
	    <div>
	    <select id="export_format" onchange="javascript: updateexportFormat();">
	    <option value="Point" selected="selected">Point</option>
	    <option value="Line">Line</option>
	    <option value="Polygon">Polygon</option>
	    <option value="Roads">Roads</option>
	    </select>
		</div>
	</div>
    
  </br>

<FORM>

<div id="format_div">
<label>File Format</label>
<div><INPUT TYPE="radio" id="File_Format_csv" Name="File_Format" value="csv" checked="true" >          CSV file (*.csv)</div>
<div><INPUT TYPE="radio" id="File_Format_json" Name="File_Format" value="json" >          JSON file (*.json)</div>
<div><INPUT TYPE="radio" id="File_Format_xml" Name="File_Format" value="xml" >          XML file (*.xml)</div>
</div>

<div id="column_div">
<label>Column</label>
<div style="height: 280px; width:250px; overflow:auto;" id="select_div">
<div><INPUT TYPE=CHECKBOX id="osm_id" checked="true" name="foo">osm_id</div>
<div><INPUT TYPE=CHECKBOX id="access" checked="true" name="foo">access</div>
<div><INPUT TYPE=CHECKBOX id="addr:housename" checked="true" name="foo">addr:housename</div>
<div><INPUT TYPE=CHECKBOX id="addr:housenumber" checked="true" name="foo">addr:housenumber</div>
<div><INPUT TYPE=CHECKBOX id="addr:interpolation" checked="true" name="foo">addr:interpolation</div>
<div><INPUT TYPE=CHECKBOX id="admin_level" checked="true" name="foo">admin_level</div>
<div><INPUT TYPE=CHECKBOX id="aerialway" checked="true" name="foo">aerialway</div>
<div><INPUT TYPE=CHECKBOX id="aeroway" checked="true" name="foo">aeroway</div>
<div><INPUT TYPE=CHECKBOX id="amenity" checked="true" name="foo">amenity</div>
<div><INPUT TYPE=CHECKBOX id="area" checked="true" name="foo">area</div>
<div><INPUT TYPE=CHECKBOX id="barrier" checked="true" name="foo">barrier</div>
<div><INPUT TYPE=CHECKBOX id="bicycle" checked="true" name="foo">bicycle</div>
<div><INPUT TYPE=CHECKBOX id="brand" checked="true" name="foo">brand</div>
<div><INPUT TYPE=CHECKBOX id="bridge" checked="true" name="foo">bridge</div>
<div><INPUT TYPE=CHECKBOX id="boundary" checked="true" name="foo">boundary</div>
<div><INPUT TYPE=CHECKBOX id="building" checked="true" name="foo">building</div>
<div id="capitaldiv"><INPUT TYPE=CHECKBOX id="capital" checked="true" name="foo">capital</div>
<div><INPUT TYPE=CHECKBOX id="construction" checked="true" name="foo">construction</div>
<div><INPUT TYPE=CHECKBOX id="covered" checked="true" name="foo">covered</div>
<div><INPUT TYPE=CHECKBOX id="culvert" checked="true" name="foo">culvert</div>
<div><INPUT TYPE=CHECKBOX id="cutting" checked="true" name="foo">cutting</div>
<div><INPUT TYPE=CHECKBOX id="denomination" checked="true" name="foo">denomination</div>
<div><INPUT TYPE=CHECKBOX id="disused" checked="true" name="foo">disused</div>
<div id="elediv"><INPUT TYPE=CHECKBOX id="ele" checked="true" name="foo">ele</div>
<div><INPUT TYPE=CHECKBOX id="embankment" checked="true" name="foo">embankment</div>
<div><INPUT TYPE=CHECKBOX id="foot" checked="true" name="foo">foot</div>
<div><INPUT TYPE=CHECKBOX id="generator:source" checked="true" name="foo">generator:source</div>
<div><INPUT TYPE=CHECKBOX id="harbor" checked="true" name="foo">harbor</div>
<div><INPUT TYPE=CHECKBOX id="highway" checked="true" name="foo">highway</div>
<div><INPUT TYPE=CHECKBOX id="historic" checked="true" name="foo">historic</div>
<div><INPUT TYPE=CHECKBOX id="horse" checked="true" name="foo">horse</div>
<div><INPUT TYPE=CHECKBOX id="intermittent" checked="true" name="foo">intermittent</div>
<div><INPUT TYPE=CHECKBOX id="junction" checked="true" name="foo">junction</div>
<div><INPUT TYPE=CHECKBOX id="landuse" checked="true" name="foo">landuse</div>
<div><INPUT TYPE=CHECKBOX id="layer" checked="true" name="foo">layer</div>
<div><INPUT TYPE=CHECKBOX id="leisure" checked="true" name="foo">leisure</div>
<div><INPUT TYPE=CHECKBOX id="lock" checked="true" name="foo">lock</div>
<div><INPUT TYPE=CHECKBOX id="man_made" checked="true" name="foo">man_made</div>
<div><INPUT TYPE=CHECKBOX id="military" checked="true" name="foo">military</div>
<div><INPUT TYPE=CHECKBOX id="motorcar" checked="true" name="foo">motocar</div>
<div><INPUT TYPE=CHECKBOX id="name" checked="true" name="foo">name</div>
<div><INPUT TYPE=CHECKBOX id="natural" checked="true" name="foo">natural</div>
<div><INPUT TYPE=CHECKBOX id="office" checked="true" name="foo">office</div>
<div><INPUT TYPE=CHECKBOX id="oneway" checked="true" name="foo">oneway</div>
<div><INPUT TYPE=CHECKBOX id="operator" checked="true" name="foo">operator</div>
<div><INPUT TYPE=CHECKBOX id="place" checked="true" name="foo">place</div>
<div id="poidiv"><INPUT TYPE=CHECKBOX id="poi" checked="true" name="foo">poi</div>
<div><INPUT TYPE=CHECKBOX id="population" checked="true" name="foo">population</div>
<div><INPUT TYPE=CHECKBOX id="power" checked="true" name="foo">power</div>
<div><INPUT TYPE=CHECKBOX id="power_source" checked="true" name="foo">power_source</div>
<div><INPUT TYPE=CHECKBOX id="public_transport" checked="true" name="foo">public_transport</div>
<div><INPUT TYPE=CHECKBOX id="railway" checked="true" name="foo">railway</div>
<div><INPUT TYPE=CHECKBOX id="ref" checked="true" name="foo">ref</div>
<div><INPUT TYPE=CHECKBOX id="religion" checked="true" name="foo">religion</div>
<div><INPUT TYPE=CHECKBOX id="route" checked="true" name="foo">route</div>
<div><INPUT TYPE=CHECKBOX id="service" checked="true" name="foo">service</div>
<div><INPUT TYPE=CHECKBOX id="shop" checked="true" name="foo">shop</div>
<div><INPUT TYPE=CHECKBOX id="sport" checked="true" name="foo">sport</div>
<div><INPUT TYPE=CHECKBOX id="surface" checked="true" name="foo">surface</div>
<div><INPUT TYPE=CHECKBOX id="toll" checked="true" name="foo">toll</div>
<div><INPUT TYPE=CHECKBOX id="tourism" checked="true" name="foo">tourism</div>
<div><INPUT TYPE=CHECKBOX id="tower:type" checked="true" name="foo">tower:type</div>
<div id="tracktypediv"><INPUT TYPE=CHECKBOX id="tracktype" checked="true" name="foo">tracktype</div>
<div><INPUT TYPE=CHECKBOX id="tunnel" checked="true" name="foo">tunnel</div>
<div><INPUT TYPE=CHECKBOX id="water" checked="true" name="foo">water</div>
<div><INPUT TYPE=CHECKBOX id="waterway" checked="true" name="foo">waterway</div>
<div><INPUT TYPE=CHECKBOX id="wetland" checked="true" name="foo">wetland</div>
<div><INPUT TYPE=CHECKBOX id="width" checked="true" name="foo">width</div>
<div><INPUT TYPE=CHECKBOX id="wood" checked="true" name="foo">wood</div>
<div><INPUT TYPE=CHECKBOX id="z_order" checked="true" name="foo">z_order</div>
<div id="way_areadiv"><INPUT TYPE=CHECKBOX id="way_area" checked="true" name="foo">way_area</div>
<div><INPUT TYPE=CHECKBOX id="tags" checked="true" name="foo">tags</div>
<div id="bottom"><INPUT TYPE=CHECKBOX id="way" checked="true" name="foo">way</div>
</div>
</div>
<input type="checkbox" id="select_all" checked="true" onchange="javascript: selectall(this);"> select all </input>

      <div class="modal-footer" style=" margin-top: 25px">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="button" class="btn btn-primary" onclick="javascript:pass();" value="Export"></button>
      </div>
      </FORM>
  		</div>
    </div>
  </div>
</div>

<script type="text/javascript">
var arr = new Array()

function pass()
{
	updateexportFormat();
	var osm_id = document.getElementById("osm_id").checked;
	var	access = document.getElementById("access").checked;
	var	addr_housename = document.getElementById("addr:housename").checked;
	var	addr_housenumber = document.getElementById("addr:housenumber").checked;
	
	var	addr_interpolation = document.getElementById("addr:interpolation").checked;
	var	admin_level = document.getElementById("admin_level").checked;
	var	aerialway = document.getElementById("aerialway").checked;
	var	aeroway = document.getElementById("aeroway").checked;
	var	amenity = document.getElementById("amenity").checked;
	var	area = document.getElementById("area").checked;
	var	barrier = document.getElementById("barrier").checked;
	var	bicycle = document.getElementById("bicycle").checked;
	var	brand = document.getElementById("brand").checked;
	var	bridge = document.getElementById("bridge").checked;
	var	boundary = document.getElementById("boundary").checked;
	var	building = document.getElementById("building").checked;
	var	capital = document.getElementById("capital").checked;
	var	construction = document.getElementById("construction").checked;
	var	covered = document.getElementById("covered").checked;
	var	culvert = document.getElementById("culvert").checked;
	var	cutting = document.getElementById("cutting").checked;
	var	denomination = document.getElementById("denomination").checked;
	var	disused = document.getElementById("disused").checked;
	var	ele = document.getElementById("ele").checked;
	var	embankment = document.getElementById("embankment").checked;
	var	foot = document.getElementById("foot").checked;
	var	generator_source = document.getElementById("generator:source").checked;
	var	harbor = document.getElementById("harbor").checked;
	var	highway = document.getElementById("highway").checked;
	var	historic = document.getElementById("historic").checked;
	var	horse = document.getElementById("horse").checked;
	var	intermittent = document.getElementById("intermittent").checked;
	var	junction = document.getElementById("junction").checked;
	var	landuse = document.getElementById("landuse").checked;
	var	layer = document.getElementById("layer").checked;
	var	leisure = document.getElementById("leisure").checked;
	var	lock = document.getElementById("lock").checked;
	var	man_made = document.getElementById("man_made").checked;
	var	military = document.getElementById("military").checked;
	var	motorcar = document.getElementById("motorcar").checked;
	var	name = document.getElementById("name").checked;
	var	natural = document.getElementById("natural").checked;
	var	office = document.getElementById("office").checked;
	var	oneway = document.getElementById("oneway").checked;
	var	operator = document.getElementById("operator").checked;
	var	place = document.getElementById("place").checked;
	var	poi = document.getElementById("poi").checked;
	var	population = document.getElementById("population").checked;
	var	power = document.getElementById("power").checked;
	var	power_source = document.getElementById("power_source").checked;
	var	public_transport = document.getElementById("public_transport").checked;
	var	railway = document.getElementById("railway").checked;
	var	ref = document.getElementById("ref").checked;
	var	religion = document.getElementById("religion").checked;
	var	route = document.getElementById("route").checked;
	var	service = document.getElementById("service").checked;
	var	shop = document.getElementById("shop").checked;
	var	sport = document.getElementById("sport").checked;
	var	surface = document.getElementById("surface").checked;
	var	toll = document.getElementById("toll").checked;
	var	tourism = document.getElementById("tourism").checked;
	var	tower_type = document.getElementById("tower:type").checked;
	var	tracktype = document.getElementById("tracktype").checked;
	var	tunnel = document.getElementById("tunnel").checked;
	var	water = document.getElementById("water").checked;
	var	waterway = document.getElementById("waterway").checked;
	var	wetland = document.getElementById("wetland").checked;
	var	width = document.getElementById("width").checked;
	var	wood = document.getElementById("wood").checked;
	var	z_order = document.getElementById("z_order").checked;
	var	tags = document.getElementById("tags").checked;
	var	way = document.getElementById("way").checked;
	var	way_area = document.getElementById("way_area").checked;

	var selector = document.getElementById("export_format").value;

	var File_Format;
	if(document.getElementById("File_Format_csv").checked == true)
		File_Format = document.getElementById("File_Format_csv").value;
	else if(document.getElementById("File_Format_json").checked == true)
		File_Format = document.getElementById("File_Format_json").value;
	else File_Format = document.getElementById("File_Format_xml").value;
	//alert(File_Format);

	var bbox = rect.getBounds(),
		left = L.Util.formatNum(bbox.getWest(), 4),
		right = L.Util.formatNum(bbox.getEast(), 4),
		ttop = L.Util.formatNum(bbox.getNorth(), 4),
		bottom = L.Util.formatNum(bbox.getSouth(), 4),
		bboxStr;

		left = lonLat2Mercator(left,ttop)[0];
		ttop = lonLat2Mercator(left,ttop)[1];
		right = lonLat2Mercator(right,bottom)[0];
		bottom = lonLat2Mercator(right,bottom)[1];
		bboxStr = left + ' ' + bottom + ' ' + right + ' ' + ttop;
		
		pass_coordinate(File_Format,selector,left,bottom,right,ttop,osm_id,access,addr_housename,addr_housenumber,addr_interpolation,admin_level,aerialway,aeroway,amenity,area,barrier,bicycle,brand,bridge,boundary,building,capital,construction,covered,culvert,cutting,denomination,disused,ele,embankment,foot,generator_source,harbor,highway,historic,horse,intermittent,junction,landuse,layer,leisure,lock,man_made,military,motorcar,name,natural,office,oneway,operator,place,poi,population,power,power_source,public_transport,railway,ref,religion,route,service,shop,sport,surface,toll,tourism,tower_type,tracktype,tunnel,water,waterway,wetland,width,wood,z_order,tags,way,way_area);
}




var map = L.map('map').setView([31.2253441, 121.4888922], 14);
//var veloroad = L.tileLayer('http://tile.osmz.ru/veloroad/{z}/{x}/{y}.png', { attribution: 'Map &copy; OpenStreetMap' });
var osmlayer = L.tileLayer('http://tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: 'Map &copy; OpenStreetMap' });
var mbAttr = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
				'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
				'Imagery © <a href="http://mapbox.com">Mapbox</a>',
	mbUrl = 'https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png';

var grayscale   = L.tileLayer(mbUrl, {id: 'examples.map-20v6611k', attribution: mbAttr}),
	streets  = L.tileLayer(mbUrl, {id: 'examples.map-i875mjb7',   attribution: mbAttr});

map.addLayer(osmlayer);
var baseLayers = {
			"OSM": osmlayer,
			"Grayscale": grayscale,
			"Streets": streets
		};

//var filter_map = L.control.layers({'Grayscale': grayscale, "Streets":streets, 'OSM': osmlayer });
L.control.layers(baseLayers, null, {position: 'topleft'}).addTo(map);
//filter_map.addTo(map);
//filter_map.setPosition('topLeft');

var rect = L.rectangle([[ 31.2135,121.463], [31.2374,121.514]], {weight: 3});
var unique = 0;
//---//
var select_area = {content:'select area', callback: function(){
map.addLayer(rect);

rect.editing.enable();
var fload = L.Control.fileLayerLoad({ fileSizeLimit: 10240, layerOptions: { style: { color: '#012d64', opacity: 1, width: 4 } } });
var width4 = map.getSize().x / 4, /* Returns the current size of the map container.*/
		height4 = map.getSize().y / 4,
		center = map.latLngToLayerPoint(map.getCenter()), /* return the centre point of the map */
		ll1 = map.layerPointToLatLng(L.point(center.x - width4, center.y - height4)),
		ll2 = map.layerPointToLatLng(L.point(center.x + width4, center.y + height4));
	

if(unique==0)
{
	rect.editing._setSize([ll1, ll2]);
	//fload.addTo(map);
	unique+=1;
}
//fload.loader.on('data:error', function(e) { alert(e.error); });
var btnMove = { content: 'Move area here', callback: function() {
	var width4 = map.getSize().x / 4,
		height4 = map.getSize().y / 4,
		center = map.latLngToLayerPoint(map.getCenter()),
		ll1 = map.layerPointToLatLng(L.point(center.x - width4, center.y - height4)),
		ll2 = map.layerPointToLatLng(L.point(center.x + width4, center.y + height4));
	rect.editing._setSize([ll1, ll2]);
}};

if(unique==1)
{
map.addControl(L.functionButtons([btnMove], { position: 'topleft' }));
unique+=1;
}


rect.on('edit', updateRect);
map.on('zoomend', updateRect);


updateFormat();


//-------
/*
var download = { content: 'show coordinate', callback: function() {
	var bbox = rect.getBounds(),
		left = L.Util.formatNum(bbox.getWest(), 4),
		right = L.Util.formatNum(bbox.getEast(), 4),
		ttop = L.Util.formatNum(bbox.getNorth(), 4),
		bottom = L.Util.formatNum(bbox.getSouth(), 4),

		bboxStr;
		left = lonLat2Mercator(left,ttop)[0];
		ttop = lonLat2Mercator(left,ttop)[1];
		right = lonLat2Mercator(right,bottom)[0];
		bottom = lonLat2Mercator(right,bottom)[1];
		bboxStr = left + ' ' + bottom + ' ' + right + ' ' + ttop;
		pass_coordinate(left,bottom,right,ttop);
}};
if(unique==2)
{
map.addControl(L.functionButtons([download], { position: 'topleft' }));
unique+=1;
}1*/

}};



map.addControl(L.functionButtons([select_area],{position:'bottomleft'}));

function updateFormat() {
	var fmt = document.getElementById('format').value,
		width = 0; height = 0;
	if( fmt == 'A4' ) { width = 297; height = 210; }
	else if( fmt == 'A5' ) { width = 210; height = 148; }
	else if( fmt == 'A6' ) { width = 148; height = 105; }
	if( width && height ) {
		document.getElementById('width').value = width;
		document.getElementById('height').value = height;
	}
}

function updateRect() {
	var bbox = rect.getBounds(),
		left = L.Util.formatNum(bbox.getWest(), 4),
		right = L.Util.formatNum(bbox.getEast(), 4),
		ttop = L.Util.formatNum(bbox.getNorth(), 4),
		bottom = L.Util.formatNum(bbox.getSouth(), 4),
		bboxStr = left + ' ' + bottom + ' ' + right + ' ' + ttop;
	var margins = document.getElementById('margin').value,
		width = document.getElementById('width').value,
		height = document.getElementById('height').value,
		force = document.getElementById('force').checked,
		sizeStr = !force || width < 10 || height < 10 ? ' -z ' + map.getZoom() : ' -m ' + margins + ' -d ' + width + ' ' + height;
	document.getElementById('bbox').innerHTML = '-coordinate ' + bboxStr + ' -size' + sizeStr;
}

function fit() {
	var margins = document.getElementById('margin').value,
		width = document.getElementById('width').value - margins * 2,
		height = document.getElementById('height').value - margins * 2;
	if( width < 10 || height < 10 )
		return;
	var topLeft = map.project(rect.getBounds().getNorthWest(), 18), /*Projects the given geographical coordinates to absolute pixel coordinates for the current zoom level 18.*/
		bottomRight = map.project(rect.getBounds().getSouthEast(), 18),
		bwidth2 = (bottomRight.x - topLeft.x) / 2,
		bheight2 = (bottomRight.y - topLeft.y) / 2,
		bcenter = L.point((topLeft.x + bottomRight.x) / 2, (topLeft.y + bottomRight.y) / 2), //Represents a point with x and y coordinates in pixels.
	//	bprop = bwidth2 / bheight2,
		prop = width / height;
	/*if( bwidth2 < bheight2 ) // set the prop of the new box to the same level to the former box.
		prop = 1 / prop;

	if( bprop < prop ) {
		// increase width
		bwidth2 = bheight2 * prop;
	} else {
		// increase height
		bheight2 = bwidth2 / prop;
	}*/

	/* 
	when the weight is larger than height, new box is according to the weight and vice versa. 
	*/
	var cwidth,cheight;  

	if( bwidth2 > bheight2)
	{
		cwidth = bwidth2;
		cheight = cwidth / prop;
	}
	else
	{
		cheight = bheight2;
		cwidth = cheight * prop;
	}


	//var ll1 = map.unproject(L.point(bcenter.x - bwidth2, bcenter.y + bheight2), 18), //Projects the given absolute pixel coordinates to geographical coordinates for the current zoom level 18.
	//	ll2 = map.unproject(L.point(bcenter.x + bwidth2, bcenter.y - bheight2), 18);
	var ll1 = map.unproject(L.point(bcenter.x - cwidth, bcenter.y + cheight), 18), //Projects the given absolute pixel coordinates to geographical coordinates for the current zoom level 18.
		ll2 = map.unproject(L.point(bcenter.x + cwidth, bcenter.y - cheight), 18);
	
	rect.editing._setSize([ll1, ll2]);
}

function updateexportFormat() {
  var fmt = document.getElementById('export_format').value;
  if( fmt == 'All' ) {

  }
  else if( fmt == 'Point' ) { 
    document.getElementById("poi").setAttribute("checked"," ");
    document.getElementById("ele").setAttribute("checked"," ");
    document.getElementById("capital").setAttribute("checked"," ");

    document.getElementById("poidiv").style.display= '';
    document.getElementById("elediv").style.display= '';
    document.getElementById("capitaldiv").style.display= '';
    document.getElementById("way_areadiv").style.display= 'none';
    document.getElementById("tracktypediv").style.display= 'none';

    document.getElementById("way_area").removeAttribute("checked");
    document.getElementById("tracktype").removeAttribute("checked");

    }
  else if( fmt == 'Line' ) {

    document.getElementById("way_area").setAttribute("checked"," ");
    document.getElementById("tracktype").setAttribute("checked"," ");

    document.getElementById("poidiv").style.display= 'none';
    document.getElementById("elediv").style.display= 'none';
    document.getElementById("capitaldiv").style.display= 'none';
    document.getElementById("way_areadiv").style.display= '';
    document.getElementById("tracktypediv").style.display= '';

    document.getElementById("poi").removeAttribute("checked");
    document.getElementById("ele").removeAttribute("checked");
    document.getElementById("capital").removeAttribute("checked");
  }
  else if( fmt == 'Polygon' ) {
    document.getElementById("way_area").setAttribute("checked"," ");
    document.getElementById("tracktype").setAttribute("checked"," ");

    document.getElementById("poidiv").style.display= 'none';
    document.getElementById("elediv").style.display= 'none';
    document.getElementById("capitaldiv").style.display= 'none';
    document.getElementById("way_areadiv").style.display= '';
    document.getElementById("tracktypediv").style.display= '';

    document.getElementById("poi").removeAttribute("checked");
    document.getElementById("ele").removeAttribute("checked");
    document.getElementById("capital").removeAttribute("checked");
  }
  else if( fmt == 'Roads' ) {
    document.getElementById("way_area").setAttribute("checked"," ");
    document.getElementById("tracktype").setAttribute("checked"," ");

    document.getElementById("poidiv").style.display= 'none';
    document.getElementById("elediv").style.display= 'none';
    document.getElementById("capitaldiv").style.display= 'none';
    document.getElementById("way_areadiv").style.display= '';
    document.getElementById("tracktypediv").style.display= '';

    document.getElementById("poi").removeAttribute("checked");
    document.getElementById("ele").removeAttribute("checked");
    document.getElementById("capital").removeAttribute("checked");
  }
  
}

function selectall(source){
	var checkboxes = document.getElementsByName("foo");
	
	for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

$(document).ready(function() {
	// if text input field value is not empty show the "X" button
	$("#keyword").keyup(function() {
		$("#x").fadeIn();
		if ($.trim($("#keyword").val()) == "") {
			$("#x").fadeOut();
		}
	});
	// on click of "X", delete input field value and hide "X"
	$("#x").click(function() {
		$("#keyword").val("");
		$(this).hide();
	});
});

</script>
</body>
</html>
