<?php
if (isset($_POST['pid']) && isset($_POST['pid']) != "") {
    require '../../config/lib.php';
    $vid = $_POST['pid'];
 
    $object = new CRUD();
 
    echo $object->DetailsKasMasuk($vid);
}
?>