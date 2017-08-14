<?php
// Sertakan File Library //
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new crudMasterTagihan();

$getJenis = $object->readData();

// Design initial table header
$data = '<div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
            <tr>
             <th>No</th>
             <th>No Pelanggan</th>
             <th>Atas Nama</th>
             <th>Bagian</th>
             <th>Keterangan</th>
             <th colspan="2" align="center">Aksi</th>  
            </tr>';
 
if (count($getJenis) > 0) {
    $no = 1;
    foreach ($getJenis as $d) {
        $data .= '
        <tr>
            <td>' . $no . '</td>
            <td>' . $d['no_pelanggan'] . '</td>
            <td>' . $d['atas_nama'] . '</td>
            <td>' . $d['bagian'] . '</td>
            <td>' . $d['keterangan'] . '</td>
                <td>
                    <button onclick="detailsRecord(' . $d['id'] . ')" class="btn btn-warning">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Update</button>
                    </td>
                    <td>
                    <button onclick="deleteRecord(' . $d['id'] . ')" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>Delete</button>
                </td>

        </tr>';
        $no++;
    }
} else {
    // records not found
    $data .= '<tr><td colspan="7" class="bg-danger">Tidak ada data yang bisa ditampilkan.</td></tr>';
}

$data .= '</table></div>';
 
echo $data;
 
?>