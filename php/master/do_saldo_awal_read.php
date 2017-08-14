<?php
// Sertakan File Library //
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new CRUD();
$vbagian1 = 'PUSAT';
$vbagian2 = 'CABANG';

$getSaldoPusat = $object->getSaldoKasAwalPeriode($vbagian1);
$getSaldoCabang = $object->getSaldoKasAwalPeriode($vbagian2);

// Design initial table header
$data = '<div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
            <tr>
             <th>Bagian</th>
             <th>Saldo Akhir</th>
             <th>Keterangan</th>
             <th>Tanggal</th>
             <th>User</th>   
            </tr>';
 
if (count($getSaldoPusat) > 0) {
    foreach ($getSaldoPusat as $d) {
        $data .= '
        <tr>
            <td>' . $d['bagian'] . '</td>
            <td>' . $d['saldo_akhir'] . '</td>
            <td>' . $d['keterangan'] . '</td>
            <td>' . $d['tggl_periode'] . '</td>
            <td>' . $d['nama'] . '</td>
        </tr>';
    }
} else {
    // records not found
    $data .= '<tr><td colspan="5" class="bg-danger">Tidak ada data saldo awal periode di bagian PUSAT yang dapat ditampilkan.</td></tr>';
}

if (count($getSaldoCabang) > 0) {
    foreach ($getSaldoCabang as $d) {
        $data .= '
        <tr>
            <td>' . $d['bagian'] . '</td>
            <td>' . $d['saldo_akhir'] . '</td>
            <td>' . $d['keterangan'] . '</td>
            <td>' . $d['tggl_periode'] . '</td>
            <td>' . $d['nama'] . '</td>
        </tr>';
    }
} else {
    // records not found
    $data .= '<tr><td colspan="6" class="bg-danger">Tidak ada data saldo awal periode di bagian CABANG yang dapat ditampilkan.</td></tr>';
} 
$data .= '</table></div>';
 
echo $data;
 
?>