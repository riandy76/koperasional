<?php
// digunakan oleh stok_kas.js
require '../../config/lib.php';
 
$object = new NomorKas();
$vbagian = $_POST['pbagian'];
$no_bukti = $object->no_kas_keluar($vbagian);
echo $no_bukti;
?>