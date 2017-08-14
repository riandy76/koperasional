<?php
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new CRUD();

$getDosen = $object->getDosen();
 
// Design initial table header
$data = '<div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
            <tr>
            <th>No</th>
             <th>Nama Dosen</th>
             <th align="center">Aksi</th>
            </tr>';
 
if (count($getDosen) > 0) {
    $number = 1;
    foreach ($getDosen as $d) {
        $data .= '
        <tr>
                <td>' . $number . '</td>
                <td>' . $d['nama_dosen'] . '</td>
                    <td>
                    <button onclick="dosenDelete(' . $d['nama_dosen'] . ')" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>Delete</button>
                    </td>
                    ';
                }            
        $number++;
    }
 else {
    // records not found
    $data .= '<tr><td colspan="3" class="danger">Tidak ada data dosen yang dapat ditampilkan.</td></tr>';
}
 
$data .= '
        </table>
        </div>';
 
echo $data;
?>