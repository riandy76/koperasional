<?php
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new CRUD();
$vbagian1 = 'PUSAT';
$vbagian2 = 'CABANG';
$vfrom_date = $_POST['ptggl_periode'];

$getSaldoAwalPeriodePusat = $object->getSaldoKasAwalPeriode($vbagian1);
$getSaldoAwalPeriodeCabang = $object->getSaldoKasAwalPeriode($vbagian2);

if (count($getSaldoAwalPeriodePusat) > 0 && count($getSaldoAwalPeriodeCabang) > 0) {
  $data = '<div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Informasi :</strong> Saldo Awal sudah di Setting.
           </div>';
    echo $data;
}

?>