<?php
/**
            pnama_pengguna: gnama_pengguna,
            palamat_pengguna: galamat_pengguna,
            pnomor_telp: gnomor_telp,
            p_tggl: tggl_tambah,
            pid_user: gid_user
**/
 if (isset($_POST['pnama_pengguna']) && isset($_POST['palamat_pengguna']) && isset($_POST['pnomor_telp']) && isset($_POST['p_tggl']) && isset($_POST['pid_user'])) 
 {

    require '../../config/lib.php';
 
    $vnama_pengguna = $_POST['pnama_pengguna'];
    $valamat = $_POST['palamat_pengguna'];
    $vtelp = $_POST['pnomor_telp'];
    $vtggl = $_POST['p_tggl'];
    $vid_user = $_POST['pid_user'];

    $object = new crudPengguna();

    $object->createPengguna($vnama_pengguna, $valamat, $vtelp, $vtggl, $vid_user);
 }

?>