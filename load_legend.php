<?php 

include "library/DB.php";

$Name = $_POST['name'];

$db = new DB( 'data.sqlite' );

$results = $db->queryAll("select * from tbldb where name in ('".$Name."') ORDER BY id ASC");

echo json_encode($results,JSON_PRETTY_PRINT);
?>