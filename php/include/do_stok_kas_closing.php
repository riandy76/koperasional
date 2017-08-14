<?php
if (isset($_POST['pketerangan']) && isset($_POST['ptotal_kas'])) 
{
    require '../../config/lib.php';
 
    $vsaldo_akhir = $_POST['ptotal_kas'];
    $vstatus_saldo = $_POST['pstatus_saldo'];

    $vbagian = $_POST['pbagian'];
    $vtggl_periode = $_POST['pfrom_date'];
    $vwaktu_update = $_POST['pwaktu_tambah'];
    $vketerangan = $_POST['pketerangan'];
    $vuser_kasir = $_POST['puser_kasir'];

    $object = new CRUD();
 
    $object->setSaldoAwal($vsaldo_akhir, $vketerangan, $vtggl_periode, $vwaktu_update, $vbagian, $vuser_kasir, $vstatus_saldo);
    $object->UpdateClosingKas($vbagian);
}
?>