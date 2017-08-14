<?php
require '../../config/lib.php';
 
$object = new CRUD();
$vbagian = $_POST['pbagian'];
$saldoawal = 0;
$saldoakhir = 0;
$vtggl_kas = $_POST['pfrom_date'];

//get tanggal sebelum, karena closing membaca ke hari sebelumnya.
$vtggl_sebelum = date('Y-m-d', strtotime($vtggl_kas.' -1 day'));

$kasKeluar_belum_closing = json_decode($object->getKasKeluar_belumClosing($vbagian, $vtggl_kas), true);

$kasMasuk_belum_closing = json_decode($object->getKasMasuk_belumClosing($vbagian, $vtggl_kas), true);

$getSaldoKas = json_decode($object->getSaldoKasClosing($vbagian, $vtggl_sebelum), true);
$getLastClosing = json_decode($object->getLastClosing($vbagian, $vtggl_kas), true);
#Mulai Hitung Kas Operasional
if (!empty($getSaldoKas['saldo_akhir'])) {
    # code...
    $saldoawal = ($getSaldoKas['saldo_akhir'] + $kasMasuk_belum_closing['jumlah']) - $kasKeluar_belum_closing['jumlah'];
    //echo 'ini kondisi pertama';   
}
elseif (!empty($getLastClosing['saldo_akhir'])) {
    # code...
    $saldoawal = ($getLastClosing['saldo_akhir'] + $kasMasuk_belum_closing['jumlah']) - $kasKeluar_belum_closing['jumlah'];
    //echo 'ini kondisi kedua';
}

$getDebetKredit = $object->getDebetKredit($vbagian, $vtggl_kas);
if (count($getDebetKredit) > 0) {
    foreach ($getDebetKredit as $d) {
        $saldoakhir = ($saldoawal + $d['totalDebet']) - $d['totalKredit'];
    }
}
 
echo $saldoakhir;
 
?>