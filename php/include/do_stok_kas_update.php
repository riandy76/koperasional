<?php
if (isset($_POST['pkertas_100']) && isset($_POST['pkertas_50']) && isset($_POST['pkertas_20'])
    && isset($_POST['pkertas_10']) && isset($_POST['pkertas_5']) && isset($_POST['pkertas_2'])
    && isset($_POST['pkertas_1']) && isset($_POST['plogam_1000']) && isset($_POST['plogam_500'])
    && isset($_POST['plogam_200']) && isset($_POST['plogam_100'])) 
{
    require '../../config/lib.php';
 
    $vkertas_100 = $_POST['pkertas_100'];
    $vkertas_50 = $_POST['pkertas_50'];
    $vkertas_20 = $_POST['pkertas_20'];
    $vkertas_10 = $_POST['pkertas_10'];
    $vkertas_5 = $_POST['pkertas_5'];
    $vkertas_2 = $_POST['pkertas_2'];
    $vkertas_1 = $_POST['pkertas_1'];
    $vlogam_1000 = $_POST['plogam_1000'];
    $vlogam_500 = $_POST['plogam_500'];
    $vlogam_200 = $_POST['plogam_200'];
    $vlogam_100 = $_POST['plogam_100'];

    $vbagian = $_POST['pbagian'];
    $vtggl_kas = $_POST['ptggl_kas'];
    $vwaktu_update = $_POST['pwaktu_tambah'];
    $vketerangan = $_POST['pketerangan'];
    $vuser_kasir = $_POST['puser_kasir'];

    $object = new CRUD();
 
    $object->updateStokKas($vkertas_100, $vkertas_50, $vkertas_20, $vkertas_10, $vkertas_5, $vkertas_2,
    $vkertas_1, $vlogam_1000, $vlogam_500, $vlogam_200, $vlogam_100, $vbagian, $vtggl_kas, $vwaktu_update, $vketerangan, $vuser_kasir);
}
?>