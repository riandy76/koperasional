<?php
// Sertakan File Library //
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new CRUD();
$vbagian = $_POST['pbagian'];

$vtotalBonPusat = 0;
$vtotalBonCabang = 0;
$vtggl_bon = $_POST['pfrom_date'];

$timezone = "Asia/Makassar";
date_default_timezone_set($timezone);
$today = date("Y-m-d");

$getBonPusat = $object->getBon($vbagian, $vtggl_bon);

// Design initial table header
$data = '<div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
            <tr>
             <th colspan="3">Tanggal : '. tanggal_indo($vtggl_bon) .' </th>             
            </tr>
            <tr>
             <th>Tanggal</th>
             <th>Bagian</th>
             <th>Penerima</th>
             <th>Keterangan</th>
             <th>Jumlah</th>
             <th>Tanggal Bayar</th>
             <th>Status</th>
             <th colspan="4">Aksi</th>   
            </tr>';
 
if (count($getBonPusat) > 0) {
    foreach ($getBonPusat as $d) {
    $vtotalBonPusat = $vtotalBonPusat + $d['jumlah'];
        $data .= '
        <tr>
            <td>' . $d['tggl_bon'] . '</td>
            <td>' . $d['bagian'] . '</td>
            <td>' . $d['namaPengguna'] . '</td>
            <td>' . $d['keterangan'] . '</td>
            <td>' . format_rupiah($d['jumlah']) . '</td>
            <td>' . $d['tggl_bayar'] . '</td>';
            //status 9 = belum bayar.
            if ($d['status_bon'] == 9) {
                $data .= '
                <td class="bg-danger">Belum Bayar</td>
                <td>
                    <button onclick="UpdateBonBayar(' . $d['id'] . ')" class="btn btn-info">
                    <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>Bayar</button>
                </td>
                <td>
                    <button onclick="getBonDetails(' . $d['id'] . ')" class="btn btn-warning">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Update</button>
                </td>
                <td>
                    <button onclick="bonDelete(' . $d['id'] . ')" disabled="disabled" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>Delete</button>
                </td>';
            }else {
                $data .= '
                <td class="bg-success">Sudah Dibayar</td>
                <td>
            <button onclick="UpdateBonBayar(' . $d['id'] . ')" disabled="disabled" class="btn btn-info">
            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>Bayar</button>
                </td>
                <td>
        <button onclick="getBonDetails(' . $d['id'] . ')" disabled="disabled" class="btn btn-warning">
        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Update</button>
                </td>
                <td>
            <button onclick="bonDelete(' . $d['id'] . ')" class="btn btn-danger">
            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>Delete</button>
                </td>';
            }

        $data .= '
                <td>
                    <button onclick="CetakBonGantung(' . $d['id'] . ')" class="btn btn-success">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>Cetak</button>
                </td>
        </tr>';
    }
        $data .= '
        <tr>
            <th colspan="3"></th>
            <th>Total Bon Gantung Pusat </th>
            <th> ' . format_rupiah($vtotalBonPusat) . '</th>
            <th colspan="5"></th>
        </tr>';
} else {
    // records not found
    $data .= '<tr><td colspan="10" class="bg-danger">Tidak ada data bon gantung di bagian ' . $vbagian . ' yang dapat ditampilkan.</td></tr>';
}
 
$data .= '</table></div>';
 
echo $data;
 
?>