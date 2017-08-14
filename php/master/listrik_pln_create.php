<?php
 if (isset($_POST['pjenis_biaya']) && isset($_POST['pbagian']) && isset($_POST['patas_nama']) && isset($_POST['pnopel']) && isset($_POST['pketerangan'])) 
 {
/**
            pjenis_biaya: gjenis_biaya,
            pbagian: gbagian,
            patas_nama: gatas_nama,
            pnopel: gnopel,
            pketerangan: gketerangan  
**/

    require '../../config/lib.php';
 
    $vnama_jenis = $_POST['pjenis_biaya'];
    $vketerangan = $_POST['pketerangan'];
    $vbagian = $_POST['pbagian'];
    $vatas_nama = $_POST['patas_nama'];
    $vnopel = $_POST['pnopel'];

    $object = new crudMasterTagihan();

    $object->createData($vatas_nama, $vnopel, $vbagian, $vketerangan, $vnama_jenis);
 }

?>