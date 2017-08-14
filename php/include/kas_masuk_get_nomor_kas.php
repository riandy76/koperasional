<?php
// digunakan oleh stok_kas.js
require '../../config/lib.php';
 
$object = new NomorKas();
$vbagian = $_POST['pbagian'];
$no_bukti = $object->no_kas_masuk($vbagian);
echo $no_bukti;
?>