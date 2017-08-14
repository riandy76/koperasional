<?php
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new CRUD();
$vbagian = $_POST['pbagian'];
$vtggl_kas = $_POST['pfrom_date'];

echo $object->getStokKas($vbagian, $vtggl_kas);
?>