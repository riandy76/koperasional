<?php
session_start();

  if (!isset($_SESSION['user_id']))
  {
    header("Location: ../../php/index.php"); 
  }

    //Panggil file yang berisi library fungsi-fungsi
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  </head>
  <style type="text/css">
    .no-close .ui-dialog-titlebar-close {
      display: none;
    }
  </style>
  <body>

<div class="container-fluid">
<h4 class="page-header">.:: Kas Operasional Pusat - Kas Masuk ::.</h4>
  <div class="checkSaldoAwal">
    <!-- Pesan Error -->
  </div>
  <div class="row"> 
  <form class="navbar-form navbar-left">
    <div class="form-group">
      <label for="from_date">Pilih Tanggal</label>
      <input type="text" id="from_date" class="form-control"/>
    </div>
    <button data-toggle="tooltip" title="Cari Data" type="button" id="filter" class="btn btn-info" onclick="readRecords()">
    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Cari</button>
    <button data-toggle="modal" data-target="#modalBaru" title="Buat Baru" type="button" id="newData" class="btn btn-success"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Baru</button>
<!-- <button title="Print Laporan Uang Muka" type="button" id="print-filter" class="btn btn-success" data-toggle="modal" data-target="#printFilter"><span class="fa fa-print" aria-hidden="true"></span> Cetak</button> -->
  </form>
  </div>
</div>
  
<div class="container-fluid">
  <div class="row">
    <div class="records_content">
    </div>
  </div>
</div>

<!-- Bootstrap Modals -->
<!-- Modal - Add New Record/User -->
<div class="modal fade" id="modalBaru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">.:: Data Kas Masuk Pusat Baru ::.</h4>
            </div>
            <div class="modal-body">
 
                <div class="form-group">
                  <label for="vno_bukti_kas">No. Bukti Kas</label>
                  <input type="text" id="vno_bukti_kas" placeholder="No. Bukti Kas" class="form-control"/>
                </div>
 
                <div class="form-group search-box">
                    <label for="vpenerima">Diterima Dari</label>
                    <input type="text" id="vpenerima" placeholder="Diterima Dari" class="form-control"/>
                    <div class="result"></div>
                </div>
 
                <div class="form-group">
                    <label for="vjumlah">Jumlah Uang</label>
                    <input type="text" id="vjumlah" placeholder="Jumlah Uang" class="form-control"/>
                </div>

                <div class="form-group">
                  <label for="vjenis_biaya">Jenis Kas Masuk</label>
                  <select id="vjenis_biaya" class="form-control">
                    <option selected="selected" value="15">Dropping</option>
                    <option value="16">Setoran</option>                   
                  </select>   
                </div>

                <div class="form-group">
                    <label for="vketerangan">Keterangan</label>
                    <textarea id="vketerangan" placeholder="Keterangan" class="form-control" rows="3"></textarea>
                </div>

        <input type="hidden" id="vbagian" value="PUSAT">
        <input type="hidden" id="vid_pegguna_get">
        <input type="hidden" id="dtggl_kas" value="<?php echo $today; ?>">
        <input type="hidden" id="dwaktu_tambah" value="<?php echo $today2; ?>">
        <input type="hidden" id="vuser_kasir" value="<?php echo $user->idUserKasir; ?>">
 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="addRecord()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->

<!-- Modal - Update User details -->
<div class="modal fade" id="update_kas_pusat_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">.:: Data Kas Masuk Pusat Update ::.</h4>
            </div>
            <div class="modal-body">
 
                <div class="form-group">
                  <label for="vno_bukti_kas-update">No. Bukti Kas</label>
                  <input value="" type="text" id="vno_bukti_kas-update" placeholder="No. Bukti Kas" class="form-control" readonly/>
                </div>

                <div class="form-group search-box">
                    <label for="vpenerima-update">Diterima Dari</label>
                    <input type="text" id="vpenerima-update" placeholder="Diterima dari" class="form-control"/>
                    <div class="result"></div>
                </div>
 
                <div class="form-group">
                    <label for="vjumlah-update">Jumlah Uang</label>
                    <input type="text" id="vjumlah-update" name="vjumlah-update" placeholder="Last Name" class="form-control"/>
                </div>

        <div class="form-group">
        <label for="vjenis_biaya-update">Jenis Kas Masuk</label>
          <select id="vjenis_biaya-update" disabled="true" class="form-control">
            <option value="15">Dropping</option>
            <option value="16">Setoran</option>
            <option value="17">Realisasi</option> 
				  </select>
        </div>
 
                <div class="form-group">
                <label for="vketerangan-update">Keterangan</label>
                <textarea id="vketerangan-update" placeholder="Keterangan" class="form-control" rows="3"></textarea>
                </div>
 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary" onclick="UpdateKasMasuk()" >Update</button>
         
        <input type="hidden" id="vid_update">                    
        <input type="hidden" id="dwaktu_tambah-update" value="<?php echo $today2; ?>">
        <input type="hidden" id="vuser_kasir-update" value="<?php echo $user->idUserKasir; ?>">

            </div>
        </div>
    </div>
</div>

<!--Print Modal -->
        <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cetak Bukti Kas Masuk</h4>
                    </div>

                    <div class="modalPrintBody">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- Print Modal -->

<!-- Dialog Confirmation -->
<div id="dialog-confirm" title="Hapus Data?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
  Data Akan Dihapus. Apakah anda yakin?</p>
</div>
<!-- Dialog Confirmation -->
<script src="../assets/js/kas_masuk.js?v=<?php echo uniqid(); ?>"></script>
<script src="../assets/js/jquery.media.js"></script>
</body>
</html>