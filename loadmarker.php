<?php 
include "library/DB.php";

$db = new DB( 'data.sqlite' );

$Name = trim($_POST['name']);

$prefix = substr($Name,0,2);

if ($prefix=="DB" || $prefix=="SS" || $prefix=="CB") {
    $results = $db->queryAll("SELECT O.manhole,O.lat,O.lng, BC.parentid,BC.DB,O.type
                          FROM tblBackboneConnect BC INNER JOIN tblObject O ON BC.id = O.id
                          WHERE BC.DB IN ('".$Name."');");
} else {
    $results = $db->queryAll("select id,manhole,lat,lng,type from tblObject Where manhole IN ('".$Name."');");	
}
echo json_encode($results,JSON_PRETTY_PRINT);
?>