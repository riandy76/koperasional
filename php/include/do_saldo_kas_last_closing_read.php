<?php
// digunakan oleh stok_kas.js
require '../../config/lib.php';
 
$object = new CRUD();
$vbagian = $_POST['pbagian'];
$vtggl = $_POST['pfrom_date'];

echo $object->getLastClosing($vbagian, $vtggl);
?>