function download2(filename, text){
		var data = new FormData();
		data.append("data","robert");
		var xhr = new XMLHttpRequest(); 
		xhr.open("post",'download_export.php',true);
		xhr.onreadystatechange=stateChanged
		xhr.send(data);
	}
	function stateChanged() {
		if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {			
			alert("yes")
			window.top.location.href = 'download_export.php';
		}
	}
function download(filename, text) {
  	  var pom = document.createElement('a');
	  pom.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
	  pom.setAttribute('download', filename);
	  pom.style.display = 'none';
	  document.body.appendChild(pom);
	  pom.click();
  	  document.body.removeChild(pom);
}

