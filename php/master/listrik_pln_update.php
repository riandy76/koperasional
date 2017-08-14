<?php
 if (isset($_POST['pjenis_biaya']) && isset($_POST['pid_jenis'])) 
 {

    require '../../config/lib.php';
 
    $vnama_jenis = $_POST['pjenis_biaya'];
    $vid_jenis = $_POST['pid_jenis'];

    $object = new crudJenisBiaya();

    $object->updateJenis($vid_jenis, $vnama_jenis);
 }

?>