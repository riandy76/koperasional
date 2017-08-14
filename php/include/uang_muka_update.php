<?php
if (isset($_POST)) {
    require '../../config/lib.php';
 
    $vid = $_POST['pid'];
    $vpenerima = $_POST['ppenerima'];
    $vjumlah = $_POST['pjumlah'];
    $vjenis_biaya = $_POST['pjenis_biaya'];
    $vketerangan = $_POST['pketerangan'];
    $vwaktu_tambah = $_POST['pwaktu_tambah'];
    $vuser_kasir = $_POST['puser_kasir'];

    $vstatus_kas = $_POST['pstatus'];
 
    $object = new CRUD();
 
    $object->UpdateUangMuka($vid, $vpenerima, $vjumlah
    	, $vjenis_biaya, $vketerangan, $vwaktu_tambah, $vuser_kasir, $vstatus_kas);
}