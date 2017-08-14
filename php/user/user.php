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
  <h4 class="page-header">.:: Halaman Atur User ::.</h4>
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
                <h4 class="modal-title" id="myModalLabel">.:: Masukan Data User Baru ::.</h4>
            </div>
            <div class="modal-body">
            
<form id="data_baru" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="vid_user">ID User</label>
                  <input type="text" id="vid_user" name="vid_user" placeholder="ID User" class="form-control">
                </div>

                <div class="form-group">
                  <label for="vlevel">User Name</label>
                  <input type="text" id="vlevel" name="vuser_name" placeholder="Username untuk login" class="form-control">
                </div>
 
                <div class="form-group">
                  <label for="vnama_user">Nama</label>
                  <input type="text" id="vnama_user" name="vnama_user" placeholder="Nama User" class="form-control">
                </div>

                <div class="form-group">
                    <label for="vpassword">Password <span id="icon" class="fa fa-eye-slash"></span> </label>
                    <input type="password" id="vpassword" name="vpassword" placeholder="Password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="vfoto">Foto</label>
                    <input type="file" id="vfoto" name="vfoto">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="addRecord()">Simpan</button>
            </div>
</form>

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
                <h4 class="modal-title" id="myModalLabel">.:: Update Data User ::.</h4>
            </div>
            <div class="modal-body">

<form id="data_update" method="post" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="vid_user">ID User</label>
                  <input type="text" id="vid_user_update" name="vid_user_update" class="form-control" readonly>
                  <input type="hidden" id="vfoto_details" name="vfoto_details">
                </div>

                <div class="form-group">
                  <label for="vlevel">User Name</label>
                  <input type="text" id="vlevel_update" name="vlevel_update" class="form-control">
                </div>
 
                <div class="form-group">
                  <label for="vnama_user">Nama</label>
                  <input type="text" id="vnama_user_update" name="vnama_user_update" class="form-control">
                </div>

                <div class="form-group">
                    <label for="vpassword">Password <span id="icon_update" class="fa fa-eye-slash"></span> </label>
                    <input type="password" id="vpassword_update" name="vpassword_update" placeholder="Password Baru" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="vfoto_update">Foto</label>
                    <input type="file" id="vfoto_update" name="vfoto_update">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateUser()">Update</button>
            </div>
</form>
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

<script src="../assets/js/atur_user.js?v=<?php echo uniqid(); ?>"></script>
<script src="../assets/js/jquery.media.js"></script>
</body>
</html>