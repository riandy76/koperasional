<!-- 
pid: gid,
            pnama_pengguna: gnama_pengguna,
            palamat_pengguna: galamat_pengguna,
            pnomor_telp: gnomor_telp
 -->
<?php
 if (isset($_POST['pid']) && isset($_POST['pnama_pengguna']) && isset($_POST['palamat_pengguna']) && isset($_POST['pnomor_telp'])) 
 {

    require '../../config/lib.php';
 
    $vid = $_POST['pid'];
    $vnama_pengguna = $_POST['pnama_pengguna'];
	$valamat = $_POST['palamat_pengguna'];
    $vtelp = $_POST['pnomor_telp'];

    $object = new crudPengguna();

    $object->updateData($vid, $vnama_pengguna, $valamat, $vtelp);
 }

?>