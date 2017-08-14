<?php
session_start();

  if (!isset($_SESSION['user_id']))
  {
    header("Location: ../../php/index.php"); 
  }
/**
Panggil file yang berisi library fungsi-fungsi
**/
require ('../../config/lib.php');
$app = new AturLogin();
$user = $app->UserDetails($_SESSION['user_id']);   
$timezone = "Asia/Makassar";
date_default_timezone_set($timezone);
$today = date("Y-m-d");
$today2 = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html lang="en">  
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <style type="text/css">
    .no-close .ui-dialog-titlebar-close {
      display: none;
    }
  </style>
<body> 

<div class="container-fluid">
  <div class="row"> 
  <h4 class="page-header">.:: Master Pengguna Kas ::.</h4>
  <form class="navbar-form navbar-left">
    <div class="form-group">
    </div>
  <button title="Buat Baru" type="button" id="bBaru" class="btn btn-success" data-toggle="modal" data-target="#modalBaru"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Baru</button>
  </form>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="records_content">
    </div>
  </div>
</div>

<!--Modal Print-->
<!-- Bootstrap Modals -->
<!-- Modal - Add New Record/User -->
<div class="modal fade" id="modalBaru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">.:: Input Data Pengguna Kas Baru ::.</h4>
            </div>
            <div class="modal-body">
<!-- 
nama_pengguna
alamat_pengguna
nomor_telp
tggl_tambah
id_user_kasir
 -->
                <div class="form-group">
                  <label for="vnama_pengguna"></label>
                  <input type="text" id="vnama_pengguna" placeholder="Nama Pengguna Kas" class="form-control"/>
                </div>

                <div class="form-group">
                  <label for="valamat_pengguna"></label>
                  <input type="text" id="valamat_pengguna" placeholder="Alamat Pengguna Kas" class="form-control"/>
                </div>
                <div class="form-group">
                  <label for="vnomor_telp"></label>
                  <input type="text" id="vnomor_telp" placeholder="Nomor Telpon" class="form-control"/>
                </div>                                                

            </div>
            <div class="modal-footer">
                <input type="hidden" id="tggl_tambah" value="<?php echo $today; ?>">
                <input type="hidden" id="id_user_kasir" value="<?php echo $user->idUserKasir; ?>">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="addRecord()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->

<!-- Modal - Update Record/User -->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">.:: Update Data Pengguna ::.</h4>
            </div>
            <div class="modal-body">
            
                <div class="form-group">
                  <label for="vnama_pengguna_update"></label>
                  <input type="text" id="vnama_pengguna_update" placeholder="Nama Pengguna Kas" class="form-control"/>
                </div>

                <div class="form-group">
                  <label for="valamat_pengguna_update"></label>
                  <input type="text" id="valamat_pengguna_update" placeholder="Alamat Pengguna Kas" class="form-control"/>
                </div>
                <div class="form-group">
                  <label for="vnomor_telp_update"></label>
                  <input type="text" id="vnomor_telp_update" placeholder="Nomor Telpon" class="form-control"/>
                </div>

            </div>
            <div class="modal-footer">
              <input type="hidden" id="vid_update">
              <input type="hidden" id="id_user_kasir_update" value="<?php echo $user->idUserKasir; ?>">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateRecord()">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->
<!-- Modal Print -->

<!-- Dialog Confirmation -->
<div id="dialog-confirm" title="Hapus Data?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
  Data Akan Dihapus. Apakah anda yakin?</p>
</div>
<!-- Dialog Confirmation -->

<script src="../assets/js/pengguna_kas.js?v=<?php echo uniqid(); ?>"></script>
</body>
</html>