<?php
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new CRUD();
$vbagian = $_POST['pbagian'];
$vtggl_periode = $_POST['ptggl_periode'];

//get tanggal sebelum, karena closing membaca ke hari sebelumnya.
$vtggl_sebelum = date('Y-m-d', strtotime($vtggl_periode.' -1 day'));

echo $object->getSaldoKasClosing($vbagian, $vtggl_sebelum); 
?>