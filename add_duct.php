<?php 
require_once 'library/meekrodb.2.3.class.php';

 $duct_no = $_POST['ductno'];
 $from_mh = $_POST['frommh'];
  $to_mh = $_POST['tomh'];
 $from_loc = $_POST['fromloc'];
 $to_loc = $_POST['toloc'];
 $diameter = $_POST['diameter'];

$frommh = explode("|", $from_mh);
$tomh = explode("|", $to_mh);
for ($i=1;$i<=$duct_no;$i++) {

    $results = DB::insert('tblducts', [
                          'duct_no' => $i,
                          'from_mh' => $frommh[0],
                          'from_loc' => $from_loc,
                          'to_mh' => $tomh[0],
                          'to_loc' => $to_loc,
                          'diameter' => $diameter
                          ]);

}


echo $results;

?>