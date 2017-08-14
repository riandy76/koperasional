<?php
if (isset($_POST)) {
    require '../../config/lib.php';
 
    $vid = $_POST['pid'];
    $vpenerima = $_POST['ppenerima'];
    $vjumlah_realisasi = $_POST['pjumlah_realisasi'];
    $vjumlah_keluar = $_POST['pjumlah_keluar'];
    $vjenis_biaya = $_POST['pjenis_biaya'];
    $vketerangan = $_POST['pketerangan'];
/**
$vketerangan2 digunakan untuk insert ke tabel kas keluar dengan keterangan Biaya atau Pengembalian
keterangan Uang Muka atau pengembalian dihilangkan.
**/
    $vketerangan2 = $_POST['pketerangan2'];
/** 
**/   
    $vwaktu_tambah = $_POST['pwaktu_tambah'];
    $vuser_kasir = $_POST['puser_kasir'];
    $vtggl_kas = $_POST['ptggl_kas'];

    $vbagian = $_POST['pbagian'];
    $vstatus_kas = 4; //biaya
    $vstatus_kas_realisasi = 5; //realisasi
    $status_closing = 10; //belum closing
    $vjenis_biaya_km = 17; //realisasi
    /**
    $vstatus_kas_realisasi = 5 , bearti statusnya adalah Realisasi
    $status_kas = 4, biaya
    **/
 
    $object = new CRUD();
    $obj_2 = new NomorKas();
    $vno_bukti_kas_masuk = $obj_2->no_kas_masuk($vbagian);
    $vno_bukti_kas_keluar = $obj_2->no_kas_keluar($vbagian);

$object->setKasMasuk($vno_bukti_kas_masuk, $vpenerima, $vjumlah_keluar, $vketerangan, $vjenis_biaya_km, $vbagian, $vtggl_kas, $vwaktu_tambah, $vuser_kasir, $vstatus_kas_realisasi, $status_closing);
$object->UpdateUangMukaRealisasi($vid, $vwaktu_tambah, $vuser_kasir);
$object->setUangMuka($vno_bukti_kas_keluar, $vpenerima, $vjumlah_realisasi, $vketerangan2, $vjenis_biaya, $vbagian, $vtggl_kas, $vwaktu_tambah, $vuser_kasir, $vstatus_kas, $status_closing);
}