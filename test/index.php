<?php

include "DB.php";

$db = new DB( 'sample.sqlite3' );

$users = $db->queryAll( "SELECT * FROM tblusers" );

echo json_encode($users,JSON_PRETTY_PRINT);
?>