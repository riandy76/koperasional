<?php
if (isset($_POST['pid']) && isset($_POST['pid']) != "") {
    require '../../config/lib.php';
    $vid = $_POST['pid'];
 
    $object = new crudPengguna();
 
    echo $object->detailsPengguna($vid);
}
?>