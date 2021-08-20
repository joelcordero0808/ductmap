<?php 
require_once 'library/meekrodb.2.3.class.php';

$name=$_POST['name'];
$lat=$_POST['lat'];
$lng=$_POST['lng'];
$type=$_POST['type'];

$results = DB::insert('tblobject', [
  'manhole' => $name,
  'lat' => $lat,
  'lng' => $lng,
  'type' => $type
]);


echo $results;
?>