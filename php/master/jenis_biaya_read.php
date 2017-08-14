<?php
// Sertakan File Library //
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new crudJenisBiaya();

$getJenis = $object->readJenis();

// Design initial table header
$data = '<div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
            <tr>
             <th>ID</th>
             <th>Jenis Biaya</th>
             <th colspan="2" align="center">Aksi</th>  
            </tr>';
 
if (count($getJenis) > 0) {
    foreach ($getJenis as $d) {
        $data .= '
        <tr>
            <td>' . $d['id_jenis'] . '</td>
            <td>' . $d['nama_jenis'] . '</td>
                <td>
                    <button onclick="detailsJenis(' . $d['id_jenis'] . ')" class="btn btn-warning">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Update</button>
                    </td>
                    <td>
                    <button onclick="deleteJenis(' . $d['id_jenis'] . ')" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>Delete</button>
                </td>

        </tr>';
    }
} else {
    // records not found
    $data .= '<tr><td colspan="5" class="bg-danger">Tidak ada data user yang bisa ditampilkan.</td></tr>';
}

$data .= '</table></div>';
 
echo $data;
 
?>