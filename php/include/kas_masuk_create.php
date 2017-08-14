<?php
if (isset($_POST['pno_bukti_kas']) && isset($_POST['ppenerima']) && isset($_POST['pjumlah'])
    && isset($_POST['pketerangan']) && isset($_POST['pjenis_biaya']) && isset($_POST['pbagian'])
    && isset($_POST['ptggl_kas']) && isset($_POST['pwaktu_tambah']) && isset($_POST['puser_kasir'])) 
{
    require '../../config/lib.php';
 
    $vno_bukti_kas = $_POST['pno_bukti_kas'];
    $vpenerima = $_POST['ppenerima'];
    $vjumlah = $_POST['pjumlah'];
    $vketerangan = $_POST['pketerangan'];
    $vjenis_biaya = $_POST['pjenis_biaya'];
    $vbagian = $_POST['pbagian'];
    $vtggl_kas = $_POST['ptggl_kas'];
    $vwaktu_tambah = $_POST['pwaktu_tambah'];
    $vuser_kasir = $_POST['puser_kasir'];
    $vstatus_closing = 10;//status saldo = 10 , bearti dana belum closing
    $vstatus_saldo = 12;//status saldo = 12 , bearti kas masuk
 
    $object = new CRUD();
 
    $object->setKasMasuk($vno_bukti_kas, $vpenerima, $vjumlah, $vketerangan, $vjenis_biaya, $vbagian, $vtggl_kas, $vwaktu_tambah, $vuser_kasir, $vstatus_saldo, $vstatus_closing);
}
?>