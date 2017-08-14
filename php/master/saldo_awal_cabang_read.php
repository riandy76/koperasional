<?php
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new CRUD();
$vbagian2 = 'CABANG';
$vfrom_date = $_POST['ptggl_periode'];

$getSaldoAwalPeriodeCabang = $object->getSaldoKasAwalPeriode($vbagian2);

if (count($getSaldoAwalPeriodeCabang) == 0) {
  $data = '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Peringatan :</strong> Saldo Awal CABANG BELUM di Setting.
           </div>';
    echo $data;
}

?>