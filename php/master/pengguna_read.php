<?php
// Sertakan File Library //
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new crudPengguna();

$getData = $object->readData();

// Design initial table header
$data = '<div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
            <tr>
             <th>Nama</th>
             <th>Alamat</th>
             <th>Nomor Telepon</th>
             <th colspan="2" align="center">Aksi</th>  
            </tr>';
 
if (count($getData) > 0) {
    foreach ($getData as $d) {
        $data .= '
        <tr>
            <td>' . $d['namaPengguna'] . '</td>
            <td>' . $d['alamatPengguna'] . '</td>
            <td>' . $d['nomorTelpon'] . '</td>
                <td>
                    <button onclick="detailsData(' . $d['idPengguna'] . ')" class="btn btn-warning">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Update</button>
                    </td>
                    <td>
                    <button onclick="deleteData(' . $d['idPengguna'] . ')" class="btn btn-danger">
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