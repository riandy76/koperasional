<?php
// Sertakan File Library //
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new AturUser();

$getUser = $object->readUser();

// Design initial table header
$data = '<div class="table-responsive">
            <table class="table table-bordered table-striped table-condensed">
            <tr>
             <th>ID User</th>
             <th>Nama</th>
             <th>User Name</th>
             <th>Login terakhir</th>
             <th>Foto</th>
             <th colspan="2" align="center">Aksi</th>  
            </tr>';
 
if (count($getUser) > 0) {
    foreach ($getUser as $d) {
        $data .= '
        <tr>
            <td>' . $d['idUserKasir'] . '</td>
            <td>' . $d['nama'] . '</td>
            <td>' . $d['user_name'] . '</td>
            <td>' . $d['last_login'] . '</td>
            <td>
            <img src="../assets/images/'.$d['pic'].'" class="img-rounded" width="60px" height="60px">
            </td>
            <td>
                    <button onclick="detailsUser(' . $d['idUserKasir'] . ')" class="btn btn-warning">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>Update</button>
                    </td>
                    <td>
                    <button onclick="deleteUser(' . $d['idUserKasir'] . ')" class="btn btn-danger">
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