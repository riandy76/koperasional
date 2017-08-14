<?php
if (isset($_POST['pnama_dosen']))
{
    require '../../config/lib.php';
 
    $vnama_dosen = $_POST['pnama_dosen'];
/**
$vstatus_saldo = 0 bearti status uang_muka nya belum di closing harian di menu stok -> closing.
**/ 
    $object = new CRUD();
 
    $object->createDosen($vnama_dosen);
}
?>