<?php
require '../../config/lib.php';
require '../../config/fungsi.php';
 
$object = new CRUD();
$vbagian1 = 'PUSAT';
$vfrom_date = $_POST['ptggl_periode'];

$getSaldoAwalPeriodePusat = $object->getSaldoKasAwalPeriode($vbagian1);

if (count($getSaldoAwalPeriodePusat) == 0) {
  $data = '<div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Peringatan :</strong> Saldo Awal PUSAT BELUM di Setting.
           </div>';
    echo $data;
}
?>