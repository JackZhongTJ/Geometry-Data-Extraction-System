<?php

#$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '同济大学';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '同济大学';

$conn_string  =  "host=dmb.tongji.edu.cn port=5432 dbname=osm user=postgres password=429jhguan" ; 

$dbconn = pg_connect($conn_string);

if (!$dbconn) 
    die (json_encode(array("message"=>"failed")));

$query = "SELECT ST_Astext (way) AS point, name FROM planet_osm_point WHERE name LIKE '%".$keyword."%';";
$result = pg_query($query);

$arr = array();
$data = array();
$Item = array();
$resultCount = 0;

if (!$result) {
    $data[] = array('listCount' => $resultCount, 'Item' => $Item);
    $arr[] = array("message"=>"ok", "success"=>"false","data"=>$data);
} else {
    while ($result_arr = pg_fetch_array($result, null, PGSQL_ASSOC))
    {
        $resultCount = $resultCount + 1;
        $Item[] = array('point' => $result_arr["point"], 'Text' => $result_arr["name"]);

        /*
        foreach ($result_arr as $col_value)
        {
            echo $col_value;
        }
        */
    }
    $data[] = array('listCount' => $resultCount, 'Item' => $Item);
    $arr[] = array("message"=>"ok", "success"=>"true","data"=>$data);
}
echo json_encode($arr);

pg_free_result($result);
pg_close($dbconn);

?>
