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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <style type="text/css">
    .no-close .ui-dialog-titlebar-close {
      display: none;
    }
  </style>
  <body>

  

<!-- Tombol fungsi -->
<div class="container-fluid">
<h4 class="page-header">.:: Kas Operasional Cabang - Uang Muka ::.</h4>
  <div class="checkSaldoAwal">
    <!-- Pesan Error -->
  </div>
  <div class="messageError">
    <!-- Pesan Error -->
  </div> 
  <div class="row"> 
  <form class="navbar-form navbar-left">
    <div class="form-group">
      <label for="from_date">Pilih Tanggal</label>
      <input type="text" id="from_date" class="form-control"/>
    </div>
  <button title="Cari Data" type="button" id="filter" class="btn btn-info" onclick="readRecords()"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Cari</button>
  <button title="Buat Baru" type="button" id="bBaru" class="btn btn-success" data-toggle="modal" data-target="#modalBaru"><span class="glyphicon glyphicon-saved" aria-hidden="true"></span> Baru</button>
  <button title="Print Laporan Uang Muka" type="button" id="print-filter" class="btn btn-success" onclick="CetakUangMuka()" data-toggle="modal" data-target="#printFilter"><span class="fa fa-print" aria-hidden="true"></span> Cetak</button>
  </form>
  </div>
</div>
<!-- Tabel isi -->
<div class="container-fluid">
  <div class="row">
    <div class="records_content">
    </div>
  </div>
</div>

<!-- Bootstrap Modals -->
<!-- Modal - Add New Record/User -->
<div class="modal fade" id="modalBaru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">.:: Uang Muka Cabang Baru ::.</h4>
            </div>
            <div class="modal-body">
 
                <div class="form-group">
                  <label for="vno_bukti_kas">No. Bukti Kas</label>
                  <input type="text" disabled id="vno_bukti_kas" class="form-control"/>
                </div>
 
                <div class="form-group search-box">
                    <label for="vpenerima">Penerima</label>
                    <input type="text" id="vpenerima" placeholder="Penerima" class="form-control"/>
                    <div class="result"></div>
                </div>
 
                <div class="form-group">
                    <label for="vjumlah">Jumlah Uang</label>
                    <input type="text" id="vjumlah" placeholder="Jumlah Uang" class="form-control"/>
                </div>

                <div class="form-group">
                  <label for="vjenis_biaya">Jenis Biaya</label>
                  <select id="vjenis_biaya" class="form-control">
                    <option>.:: Pilih Jenis Biaya ::.</option>
                    <option value="1">Kantor</option>
                    <option value="2">Bonus</option>
                    <option value="3">Gaji / Lembur</option>
                    <option value="4">Dinas</option>
                    <option value="5">BBM</option>
                    <option value="6">PLN</option>
                    <option value="7">PDAM</option>
                    <option value="8">Internet</option>
                    <option value="9">Telepon</option>
                    <option value="10">Entertain</option>
                    <option value="11">Hutang</option>
                    <option value="12">Budget Operasional</option>
                  </select>   
                </div>

                <div class="form-group">
                    <label for="vketerangan">Keterangan</label>
                    <textarea id="vketerangan" placeholder="Keterangan" class="form-control" rows="3"></textarea>
                </div>

        <input type="hidden" id="vstatus" value="11">
        <input type="hidden" id="vid_pegguna_get">
        <input type="hidden" id="vbagian" value="CABANG">
        <input type="hidden" id="dtggl_kas" value="<?php echo $today; ?>">
        <input type="hidden" id="dwaktu_tambah" value="<?php echo $today2; ?>">
        <input type="hidden" id="vuser_kasir" value="<?php echo $user->idUserKasir; ?>">
 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="readSaldoKas()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->

<!-- Modal - Update Data Kas Keluar -->
<div class="modal fade" id="update_kas_pusat_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">.:: Uang Muka Cabang Update ::.</h4>
            </div>
            <div class="modal-body">
 
                <div class="form-group">
                  <label for="vno_bukti_kas-update">No. Bukti Kas</label>
                  <input disabled type="text" id="vno_bukti_kas-update" placeholder="No. Bukti Kas" class="form-control"/>
                </div>

                <div class="form-group search-box">
                    <label for="vpenerima-update">Penerima</label>
                    <input type="text" id="vpenerima-update" placeholder="Penerima" class="form-control"/>
                    <div class="result"></div>
                </div>
 
                <div class="form-group">
                    <label for="vjumlah-update">Jumlah Uang</label>
                    <input type="text" id="vjumlah-update" placeholder="Jumlah Uang" class="form-control"/>
                </div>

        <div class="form-group">
        <label for="vjenis_biaya-update">Jenis Biaya</label>
          <select id="vjenis_biaya-update" name="vjenis_biaya-update" class="form-control">
                    <option>.:: Pilih Jenis Biaya ::.</option>
                    <option value="1">Kantor</option>
                    <option value="2">Bonus</option>
                    <option value="3">Gaji / Lembur</option>
                    <option value="4">Dinas</option>
                    <option value="5">BBM</option>
                    <option value="6">PLN</option>
                    <option value="7">PDAM</option>
                    <option value="8">Internet</option>
                    <option value="9">Telepon</option>
                    <option value="10">Entertain</option>
                    <option value="11">Hutang</option>
                    <option value="12">Budget Operasional</option>
				  </select>
        </div>
 
                <div class="form-group">
                    <label for="vket">Keterangan</label>
                    <input type="text" id="vketerangan-update" name="vketerangan-update" placeholder="Keterangan" class="form-control"/>
                </div>

                <div class="form-group">
                  <label for="vstatus_update">Status</label>
                  <select id="vstatus_update" class="form-control">
                    <option selected="selected" value="11">Uang Muka</option>
                    <option value="4">Biaya</option>                    
                  </select>
                </div>
 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary" onclick="UpdateUangMuka()" >Update</button>
         
        <input type="hidden" id="vid">                    
        <input type="hidden" id="vbagian-update" value="CABANG">
        <input type="hidden" id="dwaktu_tambah-update" value="<?php echo $today2; ?>">
        <input type="hidden" id="vuser_kasir-update" value="<?php echo $user->idUserKasir; ?>">

            </div>
        </div>
    </div>
</div>

<!-- Modal - Realisasi Uang Muka Pusat -->
<div class="modal fade" id="realisasi_kas_pusat_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">.:: Realisasi Uang Muka Cabang ::.</h4>
            </div>
            <div class="modal-body">
 
                <div class="form-group">
                  <label for="vno_bukti_kas-realisasi">No. Bukti Kas</label>
                  <input value="" type="text" id="vno_bukti_kas-realisasi" name="vno_bukti_kas" placeholder="No. Bukti Kas" class="form-control" readonly />
                </div>

 
                <div class="form-group">
                    <label for="vjumlah-realisasi-keluar">Jumlah Uang Keluar</label>
                    <input type="text" id="vjumlah-realisasi-keluar" name="vjumlah-realisasi-keluar" placeholder="Jumlah Uang Keluar" class="form-control" readonly />
                </div>

                <div class="form-group">
                    <label for="vjumlah-realisasi">Jumlah Uang Realisasi</label>
                    <input type="text" id="vjumlah-realisasi" name="vjumlah-realisasi" placeholder="Jumlah Uang Realisasi" class="form-control"/>
                </div>

                <div class="form-group">
                    <label for="vketerangan-realisasi">Keterangan</label>
                    <input type="text" id="vketerangan-realisasi" name="vketerangan-realisasi" placeholder="Keterangan" class="form-control"/>
                </div>
 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-primary" onclick="UpdateUangMukaRealisasi()" >Realisasi</button>
         
        <input type="hidden" id="vid-realisasi">  
        <input type="hidden" id="vjenis_biaya-realisasi">  
        <input type="hidden" id="vpenerima-realisasi">
        <input type="hidden" id="vketerangan-realisasi-2">                      
        <input type="hidden" id="vbagian-realisasi" value="CABANG">
        <input type="hidden" id="dtggl_kas-realisasi" value="<?php echo $today; ?>">
        <input type="hidden" id="dwaktu_tambah-realisasi" value="<?php echo $today2; ?>">
        <input type="hidden" id="vuser_kasir-realisasi" value="<?php echo $user->idUserKasir; ?>">

            </div>
        </div>
    </div>
</div>

        <!-- Modal Print Out Bukti Kas Keluar -->
        <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cetak Bukti Uang Muka</h4>
                    </div>

                    <div class="modalPrintBody">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Print Out Bukti Kas Keluar -->
        <div class="modal fade" id="printModal_Lap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cetak Laporan Uang Mukaa</h4>
                    </div>

                    <div class="modalPrintBody_Lap">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- // Modal -->

<div id="dialog-delete" title="Hapus Data?" style="display:none;">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
  Apakah data ini akan dihapus ?</p>
</div>
<!-- Dialog Confirmation -->

<script src="../assets/js/uang_muka.js?v=<?php echo uniqid(); ?>"></script>
<script type="text/javascript" src="../assets/js/jquery.media.js"></script>
</div>
</body>
</html>