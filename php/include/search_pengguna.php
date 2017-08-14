<?php
 // require 'lib.php';
require '../../config/lib.php';
 
$object = new crudPengguna();
$vterm = $_GET['pterm'];

$getData = $object->searchData($vterm);
$data = [];

// Design initial table header
 
if (count($getData) > 0) {
    foreach ($getData as $d) {

// tampilkan data 
$data = '<p>'. $d['namaPengguna'] .'</p>
<input type="hidden" id="vid_pengguna" value='. $d['idPengguna'] .'>
';
    }
echo $data;
}
 else{
echo '<p>Tidak ada Data</p>';
}

?>