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
  <h4 class="page-header">.:: Master Data Tagihan PLN, PDAM, TELKOM ::.</h4>
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
                <h4 class="modal-title" id="myModalLabel">.:: Masukan Data Tagihan PLN, PDAM, TELKOM Baru ::.</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                  <label for="vnopel">Nomor Pelanggan / Telpon</label>
                  <input type="text" id="vnopel" placeholder="Nomor Pelanggan / Telpon" class="form-control"/>
                </div>

                <div class="form-group">
                  <label for="vatas_nama">Atas Nama</label>
                  <input type="text" id="vatas_nama" placeholder="Atas Nama" class="form-control"/>
                </div>

                <div class="form-group">
                  <label for="vbagian">Bagian</label>
                  <select id="vbagian" class="form-control">
                    <option selected="selected" value="PUSAT">PUSAT</option>
                    <option value="CABANG">CABANG</option>                   
                  </select>   
                </div>

                <div class="form-group">
                  <label for="vjenis_biaya">Jenis Biaya</label>
                  <select id="vjenis_biaya" class="form-control">
                    <option value="pilih">.:: Pilih Jenis Biaya ::.</option>
                    <option value="6">PLN</option>
                    <option value="7">PDAM</option>
                    <option value="8">Internet</option>
                    <option value="9">Telepon</option>
                  </select>   
                </div>

                <div class="form-group">
                    <label for="vketerangan">Keterangan</label>
                    <textarea id="vketerangan" placeholder="Keterangan" class="form-control" rows="3"></textarea>
                </div>

            </div>
            <div class="modal-footer">
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
                <h4 class="modal-title" id="myModalLabel">.:: Update Jenis Biaya ::.</h4>
            </div>
            <div class="modal-body">
            
                <div class="form-group">
                  <label for="vjenis_update">Jenis Biaya</label>
                  <input type="text" id="vjenis_update" class="form-control"/>
                </div>

            </div>
            <div class="modal-footer">
            <input type="hidden" id="vid_update">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="updateJenis()">Update</button>
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

<script src="../assets/js/biaya_tagihan.js?v=<?php echo uniqid(); ?>"></script>
</body>
</html>