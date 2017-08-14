<?php
# file ini digunakan uang_muka.js
require '../../config/lib.php';
require '../../config/fungsi.php';
$object = new CRUD();
#ambil data $_POST
$vbagian = $_POST['pbagian'];
$vtggl_kas = $_POST['pfrom_date'];
$vbiaya = $_POST['pbiaya'];
#get tanggal sebelum.
$vtggl_sebelum = date('Y-m-d', strtotime($vtggl_kas.' -1 day'));

/**
ambil data debet dan kredit sesuai tanggal dari tabel kas_operasional
**/
$getDebetKredit = $object->getDebetKredit($vbagian, $vtggl_kas);

#get saldo kas masuk dan keluar hari ini
$getKasKeluar = $object->getKasKeluar($vbagian, $vtggl_kas);
$getKasMasuk = $object->getKasMasuk($vbagian, $vtggl_kas);

$kasKeluar_belum_closing = json_decode($object->getKasKeluar_belumClosing($vbagian, $vtggl_kas), true);
//echo 'Kas Keluar Belum Closing : '.$kasKeluar_belum_closing['jumlah'];
$kasMasuk_belum_closing = json_decode($object->getKasMasuk_belumClosing($vbagian, $vtggl_kas), true);
//echo ' Kas Masuk Belum Closing : '.$kasMasuk_belum_closing['jumlah'];

/**
Ambil data saldo akhir hari sebelum dari tabel saldo_kas
dengan status_saldo = 1 (status nya closing)
di hari sebelum, seperti laporan di file excel nya.
**/
$getSaldoKas = json_decode($object->getSaldoKasClosing($vbagian, $vtggl_sebelum), true);
# get data closing terakhir.
$getLastClosing = json_decode($object->getLastClosing($vbagian, $vtggl_kas), true);

if (!empty($getSaldoKas['saldo_akhir'])) {
    # code...
    $saldoawal = ($getSaldoKas['saldo_akhir'] + $kasMasuk_belum_closing['jumlah']) - $kasKeluar_belum_closing['jumlah'];
#echo ' -ini kondisi pertama';   
}
elseif (!empty($getLastClosing['saldo_akhir'])) {
    # code...
    $saldoawal = ($getLastClosing['saldo_akhir'] + $kasMasuk_belum_closing['jumlah']) - $kasKeluar_belum_closing['jumlah'];
#echo ' -ini kondisi kedua';
}

if (count($getDebetKredit) > 0) {
    foreach ($getDebetKredit as $d) {
        $saldoakhir = ($saldoawal + $d['totalDebet']) - $d['totalKredit'];
    }
}
/**
get saldo kas operasional
**/

if ($saldoakhir < $vbiaya) {
$data = '<div class="alert alert-danger alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<strong>Error :</strong> Uang kas tidak cukup. Saldo kas sisa : '.format_rupiah($saldoakhir).'
</div>';
    echo $data;
}
?>