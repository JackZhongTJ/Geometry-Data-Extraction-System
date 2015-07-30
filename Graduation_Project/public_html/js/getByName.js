var xmlHttp2

	function test(keyword) {
		xmlHttp2 = GetXmlHttpObject()
		if (xmlHttp2 == null) {
			alert("Browser does not support HTTP Request")
			return
		}
		
		if(keyword == '') {
			var txt = "<div  style='background: rgba(255,255,255,0.8);box-shadow: 0 0 15px rgba(0,0,0,0.2);border-radius: 5px; min-height: 700px; width: 250px;'>"
			var txt = txt +"<div style:'margin-top: 20px' class ='result_table_head'> 请输入要查询的地点名称 </div>";
			document.getElementById("txtHint").innerHTML = txt;
			return
		}

		var url="connectdb.php"
		url=url+"?keyword="+keyword
		url=url+"&sid="+Math.random()
		xmlHttp2.onreadystatechange=stateChanged 
		xmlHttp2.open("GET",url,true)
		xmlHttp2.send(null)

		/*	
		var send_string = "search=" + search;
		send_string = encodeURI(send_string)

		xmlHttp.onreadystatechange = stateChanged
		xmlHttp.open("POST", "../api/v1_0/point/getByName.php", true);
		xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlHttp.send(send_string)
		*/

	}

	function stateChanged() {
		if (xmlHttp2.readyState == 4 || xmlHttp2.readyState == "complete") {			
			var json = eval("(" + xmlHttp2.responseText + ")");
			var dealing = json[0];
			if (dealing["message"] == 'ok') {
				if (dealing["success"] == 'true') {
					var data = dealing["data"][0];
					var dealing_len = data["listCount"];
					//var txt = "<div id='container'>"+"<div id='wn'>"+"<div id='lyr1'>"+"<p>Result:"
					var txt = "<div  style='background: rgba(255,255,255,0.8);box-shadow: 0 0 15px rgba(0,0,0,0.2);border-radius: 2px; min-height: 710px; width: 250px;'>"
					var txt = txt +"<div style:'margin-top: 20px' class ='result_table_head'>"+ dealing_len+'个候选地点</div>';
					//var txt = txt + "<table border='0.2'>" + "<tr>" + "<th>Lontitude</th>"+"<th>Latitude</th>" + "<th>Text</th>" + "</tr>"
					//var txt = txt + "<table border='0.2';>" + "<tr>" + "<th>Text</th>" + "</tr>"
					var i = 0;
					var a,b,c,d,datatxt,e,x,m,n;

					while (i < dealing_len) {
						a = data["Item"][i]["point"].split('POINT(');
						b = a[1].split(' ');
						c = b[1].split(')');
						x = Mercator2lonLat(b[0],c[0]);
						datatxt = data["Item"][i]["Text"]

						//document.getElementById("hiddendata").value = datatxt;
						//txt = txt + "<tr onclick=jumptoview("+x[1]+","+x[0]+","+i+")>" + "<td>" + x[0] + "</td>" + "<td>" + x[1] + "</td>" + "<td>" + datatxt + "</td>" + "</tr>";
						txt = txt + "<div onclick=jumptoview("+x[1]+","+x[0]+","+i+") class='result_table'>"  + datatxt + "</div>";
						m = x[1];
						n = x[0];
						arr[i] = L.marker([m,n]).addTo(map).bindPopup(datatxt);

						if(i==0)
						{
							d = x[1];
							e = x[0];
						}

						i = i + 1;

						
					}
					txt = txt + "</table></div>";
					//txt = txt + "</div>"+"</p>"+"</div>"+"</div>"+"<div id='scrollbar'>"+"</div>"+"</div>";
					//txt = txt + "<div>adssadasd</div></br>";
					document.getElementById("txtHint").innerHTML = txt;
				} else
					document.getElementById("txtHint").innerHTML = "查询失败!";
				
			} else
				document.getElementById("txtHint").innerHTML = "连接数据库失败!";
			/*
			var arr = xmlHttp.responseText.split('POINT(');
			var b,c,txt,x;
			txt = '有'+(arr.length-1)+'个候选地点<br>';
			for(var i=1;i<arr.length;i++)
			{
				b = arr[i].split(' ');
				c = b[1].split(')');
				x = Mercator2lonLat(b[0],c[0])
				txt = txt + i + '.经度(lon):'+x[0] + ' 纬度(lat):'+x[1]+'<br>';
			}
			document.getElementById("txtHint").innerHTML = txt;
			*/
			
    		//.bindPopup('123')
   			//.openPopup();
   			map.setView([d,e],15);
   			arr[0].openPopup();
		}
	}

	function jumptoview(a,b,c){
		map.reset = true;
		map.setView([a,b],15);
		arr[c].openPopup();
		//L.openPopup();
			//var info = data["Item"][i]["Text"];
			//L.marker([a,b]).addTo(map)
    		//.bindPopup('test')
   			//.openPopup();
   			//var v;
   			//v = d[0]["Text"];
   			
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

	function Mercator2lonLat(mercatorX,mercatorY)
	{
		var xy = new Array();
		var x = mercatorX/20037508.34*180;
		var y = mercatorY/20037508.34*180;
		y= 180/Math.PI*(2*Math.atan(Math.exp(y*Math.PI/180))-Math.PI/2);
		xy[0] = x;
		xy[1] = y;
		return xy;
	}

	function lonLat2Mercator(lon,Lat)
	{
		var mn = new Array();
		var m = lon *20037508.34/180;
		var n = Math.log(Math.tan((90+Lat)*Math.PI/360))/(Math.PI/180);
		n = n * 20037508.34/180;
		mn[0] = m;
		mn[1] = n;
		return mn;
	}
