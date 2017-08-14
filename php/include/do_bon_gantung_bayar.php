<?php
if (isset($_POST['pid']) && isset($_POST['pid']) != "") {
    require '../../config/lib.php';
    $vid = $_POST['pid'];
    $vtggl_bayar = $_POST['pwaktu_bon'];
 
    $object = new CRUD();
    
    $object->UpdateBonBayar($vid, $vtggl_bayar);
}
?>