<?php
if (isset($_POST)) {
    require '../../config/lib.php';
 
    $vid = $_POST['pid'];
    $vpenerima = $_POST['ppenerima'];
    $vjumlah = $_POST['pjumlah'];
    $vwaktu_bon = $_POST['pwaktu_bon'];
    $vketerangan = $_POST['pketerangan'];
    $vuser_kasir = $_POST['puser_kasir'];
 
    $object = new CRUD();
 
    $object->UpdateBonGantung($vid, $vwaktu_bon, $vpenerima, $vketerangan, $vjumlah, $vuser_kasir);
}