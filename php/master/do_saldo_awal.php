<?php
session_start();

  if (!isset($_SESSION['user_id']))
  {
    header("Location: ../../php/index.php"); 
  }

    //Panggil file yang berisi library fungsi-fungsi
    require ('../../config/lib.php');
    $app  = new AturLogin();
    $user = $app->UserDetails($_SESSION['user_id']);    

  $timezone = "Asia/Makassar";
  date_default_timezone_set($timezone);
  $today = date("Y-m-d");
  $today2 = date("Y-m-d H:i:s");

?>

<!DOCTYPE html>
<html lang="en">  
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  </head>
  <body>	
  <h4 class="page-header">.:: Saldo Awal Kas ::.</h4>

   <div class="messageError"></div>

<div class="container-fluid">
<div class="row">
  <form class="form-horizontal">
    <div class="form-group">
      <label for="v_tggl_periode" class="col-sm-2 control-label">Tanggal Periode Awal</label>
      <div class="col-sm-2">
        <input type="text" id="v_tggl_periode" class="form-control" />      
      </div>
    </div>

    <div class="form-group">
      <label for="v_saldo_awal" class="col-sm-2 control-label">Saldo Awal</label>
      <div class="col-sm-3">
        <input type="text" id="v_saldo_awal" placeholder="Saldo Awal" class="form-control col-sm-2"/>
      </div>
    </div>

    <div class="form-group">
      <label for="vketerangan" class="col-sm-2 control-label">Keterangan</label>
      <div class="col-sm-3">
        <textarea id="vketerangan" placeholder="Keterangan" class="form-control" rows="3"></textarea>
      </div>
    </div>

    <div class="form-group">
      <label for="vbagian" class="col-sm-2 control-label">Bagian</label>
      <div class="col-sm-3">
        <select id="vbagian" class="form-control">
          <option selected="selected" value="PUSAT">PUSAT</option>
          <option value="CABANG">CABANG</option>                    
        </select>
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-3">
    </div>
    <div class="col-md-4">     
     <button type="button" id="ssaldoawal" class="btn btn-info" onclick="setSaldoAwal()">Simpan</button>
    </div>
    </div>

    <input type="hidden" id="dwaktu_tambah" value="<?php echo $today2; ?>">
    <input type="hidden" id="vuser_kasir" name="vuser_kasir" value="<?php echo $user->idUserKasir; ?>">
  </form>
</div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="records_content">
    </div>
  </div>
</div>

<script src="../assets/js/saldo_awal.js"></script>
</body>
</html>