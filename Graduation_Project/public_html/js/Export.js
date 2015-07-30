var xmlHttp


	function pass_coordinate(format,selector,left,bottom,right,ttop,osm_id,access,addr_housename,addr_housenumber,addr_interpolation,admin_level,aerialway,aeroway,amenity,area,barrier,bicycle,brand,bridge,boundary,building,capital,construction,covered,culvert,cutting,denomination,disused,ele,embankment,foot,generator_source,harbor,highway,historic,horse,intermittent,junction,landuse,layer,leisure,lock,man_made,military,motorcar,name,natural,office,oneway,operator,place,poi,population,power,power_source,public_transport,railway,ref,religion,route,service,shop,sport,surface,toll,tourism,tower_type,tracktype,tunnel,water,waterway,wetland,width,wood,z_order,tags,way,way_area){
		var bboxStr = left + ' ' + bottom + ' ' + right + ' ' + ttop;
		/*alert(bboxStr);*/
		xmlHttp = GetXmlHttpObject()
		if (xmlHttp == null) {
			alert("Browser does not support HTTP Request")
			return
		}
		
		/*此处判断坐标是否超出可查询范围
		if(left, buttom, right, ttop) {
			document.getElementById("Export").innerHTML = "坐标溢出,请重新选择区域”;
			return
		}*/
		var url="connectdb_export.php"
		url=url+"?left="+left
		url=url+"&bottom="+bottom
		url=url+"&right="+right
		url=url+"&ttop="+ttop
		url=url+"&selector="+selector
		url=url+"&format="+format
		url=url+"&osm_id="+osm_id+"&access="+access+"&addr_housename="+addr_housename+"&addr_housenumber="+addr_housenumber+"&addr_interpolation="+addr_interpolation+"&admin_level="+admin_level+"&aerialway="+aerialway+"&aeroway="+aeroway+"&amenity="+amenity+"&area="+area+"&barrier="+barrier+"&bicycle="+bicycle+"&brand="+brand+"&bridge="+bridge+"&boundary="+boundary+"&building="+building+"&capital="+capital+"&construction="+construction+"&covered="+covered+"&culvert="+culvert+"&cutting="+cutting+"&denomination="+denomination+"&disused="+disused+"&ele="+ele+"&embankment="+embankment+"&foot="+foot+"&generator_source="+generator_source+"&harbor="+harbor+"&highway="+highway+"&historic="+historic+"&horse="+horse+"&intermittent="+intermittent+"&junction="+junction+"&landuse="+landuse+"&layer="+layer+"&leisure="+leisure+"&lock="+lock+"&man_made="+man_made+"&military="+military+"&motorcar="+motorcar+"&name="+name+"&natural="+natural+"&office="+office+"&oneway="+oneway+"&operator="+operator+"&place="+place+"&poi="+poi+"&population="+population+"&power="+power+"&power_source="+power_source+"&public_transport="+public_transport+"&railway="+railway+"&ref="+ref+"&religion="+religion+"&route="+route+"&service="+service+"&shop="+shop+"&sport="+sport+"&surface="+surface+"&toll="+toll+"&tourism="+tourism+"&tower_type="+tower_type+"&tracktype="+tracktype+"&tunnel="+tunnel+"&water="+water+"&waterway="+waterway+"&wetland="+wetland+"&width="+width+"&wood="+wood+"z_order&="+z_order+"&tags="+tags+"&way="+way+"&way_area="+way_area
		url=url+"&sid="+Math.random()
		//alert(url);
		xmlHttp.onreadystatechange=stateChanged_export 
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)
	}

	function stateChanged_export() {
		if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {			
			//var json = eval("(" + xmlHttp.responseText + ")");
			//var dealing = json[0];
			//var ad = JSON.stringify(dealing, null, 2);

			//alert(ad);
			var format = xmlHttp.responseText;
			var url="download_export.php";
			url=url+"?format="+format;
			//alert(url);
    		window.open(url);
			/*优化json文件格式*/
			//download2('test.json',ad);
			//alert(ad);
		}
	}

	function GetXmlHttpObject() {
		var xmlHttp = null;
		try {
			// Firefox, Opera 8.0+, Safari
			xmlHttp = new XMLHttpRequest();
		} catch (e) {
			//Internet Explorer
			try {
				xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		return xmlHttp;
	}

	