<?php
if (isset($_POST['pfrom_date']) != "")
{
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new CRUD();
$vbagian = $_POST['pbagian'];
$totalUangMuka = 0;
$vfrom_date = $_POST['pfrom_date'];

//status 11 = uang muka.
$vstatus_kas = 11;

$timezone = "Asia/Makassar";
date_default_timezone_set($timezone);
$today = date("Y-m-d");

$getUangMuka = $object->getUangMuka($vbagian, $vfrom_date, $vstatus_kas);
$getClosing = json_decode($object->getSaldoKasClosing($vbagian, $vfrom_date));
 
// Design initial table header
$data = '<div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
            <tr>
             <th colspan="3">Tanggal : '. tanggal_indo($vfrom_date) .' </th>             
            </tr>
            <tr>
             <th>No</th>
             <th>Tanggal</th>
             <th>No. Bukti Kas</th>
             <th>Penerima</th>                       
             <th>Keterangan</th>
             <th>Jumlah</th>
             <th colspan="4" align="center">Aksi</th>
            </tr>';
 
if (count($getUangMuka) > 0) {
    $number = 1;
    foreach ($getUangMuka as $d) {
        $totalUangMuka = $totalUangMuka + $d['jumlah'];
        $data .= '
        <tr>
                <td>' . $number . '</td>
                <td>' . $d['tggl_kas'] . '</td>
                <td>' . $d['no_bukti_kas'] . '</td>
                <td>' . $d['namaPengguna'] . '</td>
                <td>' . $d['keterangan'] . '</td>
                <td>' . format_rupiah($d['jumlah']) . '</td>';

                if ($d['tggl_kas'] != $today OR  isset($getClosing->id_saldo_kas)) {
                    $data .= '
                    <td>
                    <button onclick="uangmukaUpdate(' . $d['id'] . ')" disabled="disabled" class="btn btn-warning">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Update</button>
                    </td>
                    <td>
                    <button onclick="uangmukaDelete(' . $d['id'] . ')" disabled="disabled" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>Delete</button>
                    </td>
                    ';
                }else {
                    $data .= '
                    <td>
                    <button id="btnUpdate" onclick="uangmukaUpdate(' . $d['id'] . ')" class="btn btn-warning">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Update</button>
                    </td>
                    <td>
                    <button id="btnDelete" onclick="uangmukaDelete(' . $d['id'] . ')" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>Delete</button>
                    </td>
                ';
                }
                $data .= '
                <td>
                    <button type="button" onclick="uangmukaRealisasi(' . $d['id'] . ')" class="btn btn-info">
                    <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>Realisasi</button>
                </td>
                <td>
                    <button onclick="CetakBuktiKas(' . $d['id'] . ')" class="btn btn-success">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>Cetak</button>
                </td>
        </tr>';            
        $number++;
    }
} else {
    // records not found
    $data .= '<tr><td colspan="10" class="danger">Tidak ada data yang dapat ditampilkan.</td></tr>';
}
 
$data .= '<tr>
            <th colspan="4"></th>
            <th>Total Uang Muka </th>
            <th> ' . format_rupiah($totalUangMuka) . '</th>
            <th colspan="4"></th>
        </tr>
        </table>
        </div>';
 
echo $data;
} 
?>