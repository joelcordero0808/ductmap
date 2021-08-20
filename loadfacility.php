<?php 
include "library/DB.php";

$db = new DB( 'data.sqlite' );

$results = $db->queryAll("select * from tblobject where type=2;");

echo json_encode($results,JSON_PRETTY_PRINT);
?>