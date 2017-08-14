<?php
 if (isset($_POST['pjenis_biaya'])) 
 {

    require '../../config/lib.php';
 
    $vnama_jenis = $_POST['pjenis_biaya'];

    $object = new crudJenisBiaya();

    $object->createJenis($vnama_jenis);
 }

?>