<?php
if (isset($_POST['psaldo_awal']) && isset($_POST['pketerangan']) && isset($_POST['pbagian'])
    && isset($_POST['ptggl_periode']) && isset($_POST['pwaktu_tambah']) && isset($_POST['puser_kasir'])) 
{
    require '../../config/lib.php';
 
    $vsaldo_akhir = $_POST['psaldo_awal'];
    $vketerangan = $_POST['pketerangan']." Closing";
    $vbagian = $_POST['pbagian'];
    $vtggl_periode = $_POST['ptggl_periode'];
    //get tanggal sebelum, karena closing membaca ke hari sebelumnya.
    $vtggl_sebelum = date('Y-m-d', strtotime($vtggl_periode.' -1 day'));
    $vwaktu_update = $_POST['pwaktu_tambah'];
    $vuser_kasir = $_POST['puser_kasir'];
    //status_saldo di tabel saldo_kas (1 = closing, 0 = awal_periode)
    $vstatus_saldo = 1;
 
    $object = new CRUD();
 
 $object->setSaldoAwal($vsaldo_akhir, $vketerangan, $vtggl_sebelum, $vwaktu_update, $vbagian, $vuser_kasir, $vstatus_saldo);
}
?>