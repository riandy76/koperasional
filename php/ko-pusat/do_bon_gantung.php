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
  <style type="text/css">
    .no-close .ui-dialog-titlebar-close {
      display: none;
    }
  </style>
  <body>

<div class="container-fluid">
<h4 class="page-header">.:: Kas Operasional Pusat - Bon Gantung ::.</h4>
<div class="messageError"></div>
  <div class="row"> 
  <form class="navbar-form navbar-left">
    <div class="form-group">
      <label for="from_date">Pilih Tanggal</label>
      <input type="text" id="from_date" class="form-control"/>
      <input type="hidden" id="vbagian" value="PUSAT">
    </div>
    <button data-toggle="tooltip" title="Cari Data" type="button" id="filter" class="btn btn-info" onclick="readRecords()">
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Cari</button>
    <button data-toggle="modal" data-target="#add_new_record_modal" title="Buat Baru" type="button" id="bBaru" class="btn btn-success"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Baru</button>
<!--   <button title="Print Laporan Uang Muka" type="button" id="print-filter" class="btn btn-success" data-toggle="modal" data-target="#printFilter"><span class="fa fa-print" aria-hidden="true"></span> Cetak</button> -->
  </form>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="records_content">
    </div>
  </div>
</div>

<!-- Modal - Add New Record/User -->
<div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">.:: Buat Bon Gantung Baru ::.</h4>
            </div>
            <div class="modal-body">
   <form class="form-horizontal">
    <div class="form-group">
      <label for="vtggl_bon" class="col-sm-3 control-label">Tanggal Bon</label>
      <div class="col-sm-3">
        <input type="text" id="vtggl_bon" class="form-control" value="<?php echo $today; ?>" />      
      </div>
    </div>

    <div class="form-group">
      <label for="vjumlah" class="col-sm-3 control-label">Jumlah Bon</label>
      <div class="col-sm-3">
        <input type="text" id="vjumlah" placeholder="Jumlah Bon" class="form-control col-sm-2"/>
      </div>
    </div>

    <div class="form-group search-box">
      <label for="vpenerima" class="col-sm-3 control-label">Penerima</label>
      <div class="col-sm-3">
        <input type="text" id="vpenerima" placeholder="Penerima" class="form-control col-sm-2"/>
        <div class="result"></div>
      </div>
    </div>

    <div class="form-group">
      <label for="vketerangan" class="col-sm-3 control-label">Keterangan</label>
      <div class="col-sm-6">
        <textarea id="vketerangan" placeholder="Keterangan" class="form-control" rows="3"></textarea>
      </div>
    </div>

    <input type="hidden" id="dtggl_bon" value="<?php echo $today; ?>">
    <input type="hidden" id="dwaktu_bon" value="<?php echo $today2; ?>">
    <input type="hidden" id="vuser_kasir" value="<?php echo $user->idUserKasir; ?>">
    <input type="hidden" id="vbagian" value="PUSAT">
    <input type="hidden" id="vid_pegguna_get">

  </form>
</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
          <button type="button" id="ssaldoawal" class="btn btn-info" onclick="setBonGantung()">Simpan</button>
        </div>
      </div>
    </div>
</div>
<!-- // Modal -->

<!-- Modal - Update Data Kas Keluar -->
<div class="modal fade" id="update_bon_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">.:: Bon Gantung Update ::.</h4>
            </div>
            <div class="modal-body">
 
   <form class="form-horizontal">
    <div class="form-group">
      <label for="vtggl_bon_update" class="col-sm-3 control-label">Tanggal Bon</label>
      <div class="col-sm-3">
        <input disabled type="text" id="vtggl_bon_update" class="form-control" placeholder="Tanggal Bon" />      
      </div>
    </div>

    <div class="form-group">
      <label for="vjumlah_update" class="col-sm-3 control-label">Jumlah Bon</label>
      <div class="col-sm-3">
        <input type="text" id="vjumlah_update" placeholder="Jumlah Bon" class="form-control col-sm-2"/>
      </div>
    </div>

    <div class="form-group search-box">
      <label for="vpenerima_update" class="col-sm-3 control-label">Penerima</label>
      <div class="col-sm-3">
        <input type="text" id="vpenerima_update" class="form-control col-sm-2"/>
        <div class="result"></div>
      </div>
    </div>

    <div class="form-group">
      <label for="vketerangan_update" class="col-sm-3 control-label">Keterangan</label>
      <div class="col-sm-6">
        <textarea id="vketerangan_update" placeholder="Keterangan" class="form-control" rows="3"></textarea>
      </div>
    </div>
    
    <input type="hidden" id="vwaktu_bon_update" value="<?php echo $today2; ?>">
    <input type="hidden" id="vuser_kasir_update" value="<?php echo $user->idUserKasir; ?>">
    <input type="hidden" id="vid_update">                    
    <input type="hidden" id="vbagian_update">
  </form> 
</div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary" onclick="updateBonGantung()" >Update</button>
      
            </div>
        </div>
    </div>
</div>

<!-- Modal Print Out Bukti Kas Keluar -->
        <div class="modal fade" style="display:none" id="printModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cetak Bukti Bon Gantung</h4>
                    </div>

                    <div class="modalPrintBody">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- // Modal -->

<!-- Dialog Confirmation -->
<div id="dialog-confirm" title="Bayar Bon?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
  Apakah ingin Bayar Bon Gantung ini ?</p>
</div>

<div id="dialog-delete" title="Hapus Data?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
  Apakah data ini akan dihapus ?</p>
</div>
<!-- Dialog Confirmation -->

<script src="../assets/js/bon_gantung.js?v=<?php echo uniqid(); ?>"></script>
<script src="../assets/js/jquery.media.js"></script>
</body>
</html>