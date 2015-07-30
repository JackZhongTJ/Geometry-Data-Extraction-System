<?php
/*
	header('Content-type: application/json');

// It will be called downloaded.pdf
	header('Content-Disposition: attachment; filename="file.json"');

// The PDF source is in original.pdf
	readfile('newfile.txt');

*/
$format = $_GET['format'];
$file_format_name;
$file_format_size;
if($format == "csv") {
	$file_format_name = "file.csv";
	$file_format_size = "newfile.csv";
}
else if($format == "json") {
	$file_format_name = "file.json";
	$file_format_size = "newfile.txt";

}
else {
	$file_format_name = "file.xml";
	$file_format_size = "newfile.xml";
}
/*
echo $format;
echo $file_format_name;
echo $file_format_size;*/

header('Content-Disposition: attachment; filename= "'.$file_format_name.'"');    
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Description: File Transfer");             
header("Content-Length: " . filesize($file_format_size));
flush(); // this doesn't really matter.

$fp = fopen($file_format_size, "r"); 
while (!feof($fp))
{
    echo fread($fp, filesize($file_format_size)); 
    flush(); // this is essential for large downloads
}  
fclose($fp);
?>