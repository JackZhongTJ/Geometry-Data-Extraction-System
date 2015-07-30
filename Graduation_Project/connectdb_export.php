<?php
//header('Content-Disposition: attachment; filename="text.json"');
//download.php
//content type

//read from server and write to buffer 
$left = isset($_GET['left']) ? $_GET['left'] : '13520676.106734566';
$bottom = isset($_GET['bottom']) ? $_GET['bottom'] : '3660312.0923110996';
$right = isset($_GET['right']) ? $_GET['right'] : '13527477.72762109';
$ttop = isset($_GET['ttop']) ? $_GET['ttop'] : '3663787.8365148474';
$selector = isset($_GET['selector']) ? $_GET['selector'] : 'all';
$format = isset($_GET['format']) ? $_GET['format'] : 'xml';
//$access = isset($_GET['access']) ? $_GET['access'] : '0';
//$housename = isset($_GET['housename']) ? $_GET['housename'] : '0';
//$housenumber = isset($_GET['housenumber']) ? $_GET['housenumber'] : '0';
//$admin_level = isset($_GET['admin_level']) ? $_GET['admin_level'] : '0';
//$aerialway = isset($_GET['aerialway']) ? $_GET['aerialway'] : '0';

//echo $format;
$query_array = array(
    "osm_id" => isset($_GET['osm_id']) ? $_GET['osm_id'] : false,
    "access" => isset($_GET['access']) ? $_GET['access'] : false,
    "addr:housename" => isset($_GET['addr_housename']) ? $_GET['addr_housename'] : false,
    "addr:housenumber" => isset($_GET['addr_housenumber']) ? $_GET['addr_housenumber'] : false,
    "addr:interpolation" => isset($_GET['addr_interpolation']) ? $_GET['addr_interpolation'] : false,
    "admin_level" => isset($_GET['admin_level']) ? $_GET['admin_level'] : false,
    "aerialway" => isset($_GET['aerialway']) ? $_GET['aerialway'] : false,
    "aeroway" => isset($_GET['aeroway']) ? $_GET['aeroway'] : false,
    "amenity" => isset($_GET['amenity']) ? $_GET['amenity'] : false,
    "area" => isset($_GET['area']) ? $_GET['area'] : false,
    "barrier" => isset($_GET['barrier']) ? $_GET['barrier'] : false,
    "bicycle" => isset($_GET['bicycle']) ? $_GET['bicycle'] : false,
    "brand" => isset($_GET['brand']) ? $_GET['brand'] : false,
    "bridge" => isset($_GET['bridge']) ? $_GET['bridge'] : false,
    "boundary" => isset($_GET['boundary']) ? $_GET['boundary'] : false,
    "building" => isset($_GET['building']) ? $_GET['building'] : false,
    "capital" => isset($_GET['capital']) ? $_GET['capital'] : false,
    "construction" => isset($_GET['construction']) ? $_GET['construction'] : false,
    "covered" => isset($_GET['covered']) ? $_GET['covered'] : false,
    "culvert" => isset($_GET['culvert']) ? $_GET['culvert'] : false,
    "cutting" => isset($_GET['cutting']) ? $_GET['cutting'] : false,
    "denomination" => isset($_GET['denomination']) ? $_GET['denomination'] : false,
    "disused" => isset($_GET['disused']) ? $_GET['disused'] : false,
    "ele" => isset($_GET['ele']) ? $_GET['ele'] : false,
    "embankment" => isset($_GET['embankment']) ? $_GET['embankment'] : false,
    "foot" => isset($_GET['foot']) ? $_GET['foot'] : false,
    "generator:source" => isset($_GET['generator_source']) ? $_GET['generator_source'] : false,
    "harbour" => isset($_GET['harbour']) ? $_GET['harbour'] : false,
    "highway" => isset($_GET['highway']) ? $_GET['highway'] : false,
    "historic" => isset($_GET['historic']) ? $_GET['historic'] : false,
    "horse" => isset($_GET['horse']) ? $_GET['horse'] : false,
    "intermittent" => isset($_GET['intermittent']) ? $_GET['intermittent'] : false,
    "junction" => isset($_GET['junction']) ? $_GET['junction'] : false,
    "landuse" => isset($_GET['landuse']) ? $_GET['landuse'] : false,
    "layer" => isset($_GET['layer']) ? $_GET['layer'] : false,
    "leisure" => isset($_GET['leisure']) ? $_GET['leisure'] : false,
    "lock" => isset($_GET['lock']) ? $_GET['lock'] : false,
    "man_made" => isset($_GET['man_made']) ? $_GET['man_made'] : false,
    "military" => isset($_GET['military']) ? $_GET['military'] : false,
    "motorcar" => isset($_GET['motorcar']) ? $_GET['motorcar'] : false,
    "name" => isset($_GET['name']) ? $_GET['name'] : false,
    "natural" => isset($_GET['natural']) ? $_GET['natural'] : false,
    "office" => isset($_GET['office']) ? $_GET['office'] : false,
    "oneway" => isset($_GET['oneway']) ? $_GET['oneway'] : false,
    "operator" => isset($_GET['operator']) ? $_GET['operator'] : false,
    "place" => isset($_GET['place']) ? $_GET['place'] : false,
    "poi" => isset($_GET['poi']) ? $_GET['poi'] : false,
    "population" => isset($_GET['population']) ? $_GET['population'] : false,
    "power" => isset($_GET['power']) ? $_GET['power'] : false,
    "power_source" => isset($_GET['power_source']) ? $_GET['power_source'] : false,
    "public_transport" => isset($_GET['public_transport']) ? $_GET['public_transport'] : false,
    "railway" => isset($_GET['railway']) ? $_GET['railway'] : false,
    "ref" => isset($_GET['ref']) ? $_GET['ref'] : false,
    "religion" => isset($_GET['religion']) ? $_GET['religion'] : false,
    "route" => isset($_GET['route']) ? $_GET['route'] : false,
    "service" => isset($_GET['service']) ? $_GET['service'] : false,
    "shop" => isset($_GET['shop']) ? $_GET['shop'] : false,
    "sport" => isset($_GET['sport']) ? $_GET['sport'] : false,
    "surface" => isset($_GET['surface']) ? $_GET['surface'] : false,
    "toll" => isset($_GET['toll']) ? $_GET['toll'] : false,
    "tourism" => isset($_GET['tourism']) ? $_GET['tourism'] : false,
    "tower:type" => isset($_GET['tower_type']) ? $_GET['tower_type'] : false,
    "tracktype" => isset($_GET['tracktype']) ? $_GET['tracktype'] : false,
    "tunnel" => isset($_GET['tunnel']) ? $_GET['tunnel'] : false,
    "water" => isset($_GET['water']) ? $_GET['water'] : false,
    "waterway" => isset($_GET['waterway']) ? $_GET['waterway'] : false,
    "wetland" => isset($_GET['wetland']) ? $_GET['wetland'] : false,
    "width" => isset($_GET['width']) ? $_GET['width'] : false,
    "wood" => isset($_GET['wood']) ? $_GET['wood'] : false,
    "z_order" => isset($_GET['z_order']) ? $_GET['z_order'] : false,
    "way_area" => isset($_GET['way_area']) ? $_GET['way_area'] : false,
    "tags" => isset($_GET['tags']) ? $_GET['tags'] : false,
    "way" => isset($_GET['way']) ? $_GET['way'] : false,
    "way_area" => isset($_GET['way_area']) ? $_GET['way_area'] : false,
);


$conn_string  =  "host=dmb.tongji.edu.cn port=5432 dbname=osm user=postgres password=429jhguan" ; 

$dbconn = pg_connect($conn_string);

if (!$dbconn) 
    die (json_encode(array("message"=>"failed")));

$query = generate_sql($query_array);
if( $selector != 'All')
{
    $query = $query."from planet_osm_".$selector." Where ST_within(way,ST_MakeEnvelope(".$left.",".$bottom.",".$right.",".$ttop.",900913));";
}
else
{
   //echo "coming soon...";
  /*此处写所有数据一起导出时的语句*/
}

//$query = "Select * from query_to_xml(Select ST_Astext(way) as point from planet_osm_point Where ST_within(way,ST_MakeEnvelope(".$left.",".$bottom.",".$right.",".$ttop.",900913)),true,false,'')";
//$query = "Select ST_Astext(way) as point from planet_osm_point Where ST_within(way,ST_MakeEnvelope(".$left.",".$bottom.",".$right.",".$ttop.",900913))";

//echo $query;

$result = pg_query($query);

$arr = array();
$data = array();
$Item = array();
$Column = array();
$resultCount = 0;

if (!$result) {
    $data[] = array('listCount' => $resultCount, 'Item' => $Item);
    $arr[] = array("message"=>"ok", "success"=>"false","data"=>$data);
} 
else {
    while ($result_arr = pg_fetch_array($result, null, PGSQL_ASSOC))
    {
        $resultCount = $resultCount + 1;
        $Column['point'] = $result_arr["point"];

        foreach ($query_array as $key => $value) {
            if($value == "true")
            $Column[$key] = $result_arr[$key];
        }

        $Item[$resultCount-1] = $Column;
    }
    $data[] = array('listCount' => $resultCount, 'Item' => $Item);
    $arr[] = array("message"=>"ok", "success"=>"true","data"=>$data);
}
/*
EVAL() WRONG!!!!
 $itemstr = "array(";
    foreach ($query_array as $key => $value) {
            if($value == "true")
            $itemstr = $itemstr.$key. "=>" .$result_arr[$key]. ",";
            //array_push($Item[$resultCount-1], $key => $result_arr[$key]);
        }
        $itmstr = $itmstr.")";
        echo $itmstr;

        $Item[] = eval($itmstr);


ARRAY_PUSH() WRONG!!!!
  foreach ($query_array as $key => $value) {
  if($value == "true")
  //array_push($Item[$resultCount-1], $key => $result_arr[$key]);
}
*/

if($format == 'json'){

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
fwrite($myfile, $txt);
fclose($myfile);
}

else if($format == 'xml'){

// creating object of SimpleXMLElement
$xml_info = new SimpleXMLElement("<?xml version=\"1.0\" encoding=\"UTF-8\"?><Records></Records>");
// function call to convert array to xml
array_to_xml($data,$xml_info);
$xml_info->formatOutput = true;
/* code to format generated XML*/
$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml_info->asXML());
$dom->save('newfile.xml');
}

else{
/* convert Array to CSV*/
$myfile_csv = fopen('newfile.csv', 'w') or die("Unable to open file!");
foreach ($Item as $file) {
    $result = [];
    array_walk_recursive($file, function($item) use (&$result) {
        $result[] = $item;
    });
    fputcsv($myfile_csv, $result);
}
fclose($myfile_csv);
/*---------------------*/
}

echo $format;
//echo json_encode($arr); 


function generate_sql($query_array){


$query = "Select ST_Astext(way) as point,";

foreach ($query_array as $key => $value) {
    if($value == "true")
        if($key == "addr:housename" || $key == "addr:housenumber" || $key == "addr:interpolation" || $key == "generator:source" || $key == "tower:type" || $key == "natural" )
          $query = $query . '"'. $key . '"' . ",";
        else 
          $query = $query . $key . ",";
}
$query[strlen($query)-1] = " ";
return $query;
}

/* convert Array to XML */
function array_to_xml($data, &$xml_info) {
    foreach($data as $key => $value) {
        if(is_array($value)) {
            $key = is_numeric($key) ? "Record$key" : $key;
            $subnode = $xml_info->addChild("$key");
            array_to_xml($value, $subnode);
        }
        else {
            if($value!="null"& $value!=""){
            $key = is_numeric($key) ? "Record$key" : $key;
            $xml_info->addChild("$key","$value");}
        }
    }
}


pg_free_result($result);
pg_close($dbconn);

?>
