<?php 
include "library/DB.php";

$db = new DB( 'data.sqlite' );

$strlat = $_POST['lat'];
$strlng = $_POST['lng'];

$results = $db->queryAll("SELECT id, manhole, lat, lng, 111.045 * DEGREES(ACOS(COS(RADIANS(".$strlat."))
 * COS(RADIANS(lat))
 * COS(RADIANS(lng) - RADIANS(".$strlng."))
 + SIN(RADIANS(".$strlat."))
 * SIN(RADIANS(lat))))
 AS distance_in_km
FROM tblobject where type=1
ORDER BY distance_in_km ASC
LIMIT 0,5;");

echo json_encode($results,JSON_PRETTY_PRINT);
?>