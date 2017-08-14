<?php
// digunakan oleh stok_kas.js readSaldoKasClosing()
require '../../config/lib.php';
 
$object = new CRUD();
$vbagian = $_POST['pbagian'];
$vtggl_periode = $_POST['pfrom_date'];

echo $object->getSaldoKasClosing($vbagian, $vtggl_periode);
?>