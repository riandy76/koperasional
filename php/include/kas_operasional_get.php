<?php
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new CRUD();
$vbagian = $_POST['pbagian'];
$saldoawal = 0;
$saldoakhir = 0;
$vtggl_kas = $_POST['pfrom_date'];

//get tanggal sebelum, karena closing membaca ke hari sebelumnya.
$vtggl_sebelum = date('Y-m-d', strtotime($vtggl_kas.' -1 day'));
/**
**/
$getKasKeluar = $object->getKasKeluar($vbagian, $vtggl_kas);
$getKasMasuk = $object->getKasMasuk($vbagian, $vtggl_kas);
#data di hari sebelum yang belum closing
$kasKeluar_belum_closing = json_decode($object->getKasKeluar_belumClosing($vbagian, $vtggl_kas), true);
//echo 'Kas Keluar : '.$kasKeluar_belum_closing['jumlah'];
#data di hari sebelum yang belum closing
$kasMasuk_belum_closing = json_decode($object->getKasMasuk_belumClosing($vbagian, $vtggl_kas), true);
//echo ' Kas Masuk : '.$kasMasuk_belum_closing['jumlah'];

/**
Ambil data saldo akhir hari sebelum dari tabel saldo_kas
dengan status_saldo = 1 (status nya closing)
di hari sebelum, seperti laporan di file excel nya.
**/
$getSaldoKas = json_decode($object->getSaldoKasClosing($vbagian, $vtggl_sebelum), true);
$getLastClosing = json_decode($object->getLastClosing($vbagian, $vtggl_kas), true);

if (!empty($getSaldoKas['saldo_akhir'])) {
    # code...
    $saldoawal = ($getSaldoKas['saldo_akhir'] + $kasMasuk_belum_closing['jumlah']) - $kasKeluar_belum_closing['jumlah'];
    //echo ' -ini kondisi pertama';   
}
elseif (!empty($getLastClosing['saldo_akhir'])) {
    # code...
    $saldoawal = ($getLastClosing['saldo_akhir'] + $kasMasuk_belum_closing['jumlah']) - $kasKeluar_belum_closing['jumlah'];
    //echo ' -ini kondisi kedua';
}

/**
ambil data debet sesuai tanggal dari tabel kas_masuk
ambil data kredit sesuai tanggal dari tabel kas_keluar
**/
$getDebetKredit = $object->getDebetKredit($vbagian, $vtggl_kas);
if (count($getDebetKredit) > 0) {
    foreach ($getDebetKredit as $d) {
        $saldoakhir = ($saldoawal + $d['totalDebet']) - $d['totalKredit'];
    }
}

// Design initial table header
$data = '<div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
            <tr>
             <th colspan="3">Saldo awal tanggal '. tanggal_indo($vtggl_kas) .'</th>
             <th>' . format_rupiah($saldoawal) . '</th>
            </tr>
            <tr>
             <th>No. Bukti Kas</th>
             <th>Penerima</th>                       
             <th>Keterangan</th>
             <th>Jumlah</th>  
            </tr>';
 
if (count($getKasMasuk) > 0) {
    foreach ($getKasMasuk as $d) {
        $data .= '
        <tr>
                <td class="text-primary success">' . $d['no_bukti_kas'] . '</td>
                <td class="success">' . $d['namaPengguna'] . '</td>
                <td class="success">' . $d['keterangan'] . '</td>
                <td class="success">' . format_rupiah($d['jumlah']) . '</td>              
        </tr>';
    }
} else {
    // records not found
    $data .= '<tr><td colspan="4" class="danger">Tidak ada data Kas Masuk yang dapat ditampilkan.</td></tr>';
}

if (count($getKasKeluar) > 0) {
    foreach ($getKasKeluar as $d) {
        $data .= '
        <tr>
                <td class="text-danger active">' . $d['no_bukti_kas'] . '</td>
                <td class="active">' . $d['namaPengguna'] . '</td>
                <td class="active">' . $d['keterangan'] . '</td>
                <td class="active">' . format_rupiah($d['jumlah']) . '</td>
        </tr>';
    }
} else {
    // records not found
    $data .= '<tr><td colspan="4" class="danger">Tidak ada data Kas Keluar yang dapat ditampilkan.</td></tr>';
}
 
$data .= '<tr>
            <th colspan="3" class="info">Saldo Akhir '. tanggal_indo($vtggl_kas) .'</th>
            <th class="info">' . format_rupiah($saldoakhir) . '</th>
        </tr>
        </table></div>';
 
echo $data;
 
?>