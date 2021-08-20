<?php 
include "library/DB.php";

$db = new DB( 'data.sqlite' );

$Name = trim($_POST['name']);


$results = $db->queryAll("select r.manhole1,r.lat1,r.lng1,r.manhole1,r.lat2,r.lng2,d.color,r.db,
	                  111.045 * DEGREES(ACOS(COS(RADIANS(r.lat2))
 * COS(RADIANS(r.lat1))
 * COS(RADIANS(r.lng1) - RADIANS(r.lng2))
 + SIN(RADIANS(r.lat2))
 * SIN(RADIANS(r.lat1))))
 AS distance 
from vwdbroute r  inner join tbldb d on r.db=d.name where db in ('".$Name."') ORDER BY parentid ASC");

echo json_encode($results,JSON_PRETTY_PRINT);
?>