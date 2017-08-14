<?php
if (isset($_POST['pnama_dosen'])){
    require '../../config/lib.php';
    $vnama_dosen = $_POST['pnama_dosen'];
 
    $object = new CRUD();
    
    $object->DeleteDosen($vnama_dosen);
}
?>