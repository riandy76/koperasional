<?php
if (isset($_POST['pjumlah']) && isset($_POST['pketerangan']) && isset($_POST['pbagian'])
    && isset($_POST['ptggl_bon']) && isset($_POST['pwaktu_bon']) && isset($_POST['ppenerima'])) 
{
    require '../../config/lib.php';
 
    $vjumlah = $_POST['pjumlah'];
    $vketerangan = $_POST['pketerangan'];
    $vbagian = $_POST['pbagian'];
    $vtggl_bon = $_POST['ptggl_bon'];
    $vwaktu_bon = $_POST['pwaktu_bon'];
    $vuser_kasir = $_POST['puser_kasir'];
    $vpenerima = $_POST['ppenerima'];

    /**
    status_bon di tabel bon_gantung
    (1 = sudah bayar, 0 = belum bayar)
    **/
    $vstatus_bon = 9;
 
    $object = new CRUD();
 
    $object->setBonGantung($vjumlah, $vketerangan, $vpenerima, $vtggl_bon, $vwaktu_bon, $vbagian, $vuser_kasir, $vstatus_bon);
}
?>