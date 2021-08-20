<?php 
include "library/DB.php";

$db = new DB( 'data.sqlite' );

$Name = trim($_POST['name']);


$results = $db->queryAll("select name,color,line_type from tbldb where name in ('".$Name."') ORDER BY name ASC");

echo json_encode($results,JSON_PRETTY_PRINT);
?>