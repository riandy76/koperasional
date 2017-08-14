<?php
// Sertakan File Library //
require '../../config/lib.php';
 
$object = new CRUD();
$vbagian = $_POST['pbagian'];
$vtggl_bon = $_POST['pfrom_date'];
$vTotalBon = 0;

$getBonPusat = $object->getBonGantung($vbagian, $vtggl_bon);
 
if (count($getBonPusat) > 0) {
    foreach ($getBonPusat as $d) {
    $vTotalBon = $vTotalBon + $d['jumlah'];   
    }
} else {
    $vTotalBon = 0;
}
 
echo $vTotalBon;

?>