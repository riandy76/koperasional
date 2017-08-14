<?php
session_start();

  if (!isset($_SESSION['user_id']))
  {
    header("Location: ../../php/index.php"); 
  }

    //Panggil file yang berisi library fungsi-fungsi
    require ('../../config/lib.php');
    require ('../../config/fungsi.php');
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
<style type="text/css">
.modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  overflow: hidden;
}

.modal-dialog {
  position: fixed;
  margin: 0;
  width: 100%;
  height: 100%;
  padding: 0;
}

.modal-content {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  border: 2px solid #3c7dcf;
  border-radius: 0;
  box-shadow: none;
}

.modal-header {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  height: 50px;
  padding: 10px;
  background: #6598d9;
  border: 0;
}

.modal-title {
  font-weight: 300;
  font-size: 2em;
  color: #ffffff;
  line-height: 30px;
}

.modal-body {
  position: absolute;
  top: 50px;
  bottom: 60px;
  width: 100%;
  font-weight: 300;
  overflow: auto;
}

.modal-footer {
  position: absolute;
  right: 0;
  bottom: 0;
  left: 0;
  height: 60px;
  padding: 10px;
  background: #f1f3f5;
}
</style>
  <body>	

<div class="container-fluid">
<h4 class="page-header">.:: Kas Operasional Cabang - Stok KAS Harian ::.</h4>
 <div class="messageError"></div>
 <div class="messageInfo"></div>
  <div class="row"> 
  <form class="navbar-form navbar-left">
    <div class="form-group">
      <label for="from_date">Pilih Tanggal</label>
      <input type="text" id="from_date" class="form-control"/>
      <input type="hidden" id="vbagian" value="CABANG">
    </div>
    <button data-toggle="tooltip" title="Cari Data" type="button" id="filter" class="btn btn-info" onclick="readRecords()"><span class="glyphicon glyphicon-search" aria-hidden="true"></span>Cari</button>
  </form>
  </div>
</div>

<form class="form-horizontal">
  <div class="row">
    <div class="form-group">
      <label class="col-sm-2 control-label">Uang Kertas</label>
      <div class="col-sm-2">
        <input type="text" id="v_100" value="<?php echo format_rupiah('100000'); ?>" class="form-control "/>
        <input type="text" id="v_50" value="<?php echo format_rupiah('50000'); ?>" class="form-control "/>
        <input type="text" id="v_20" value="<?php echo format_rupiah('20000'); ?>" class="form-control "/>
        <input type="text" id="v_10" value="<?php echo format_rupiah('10000'); ?>" class="form-control "/>
        <input type="text" id="v_5" value="<?php echo format_rupiah('5000'); ?>" class="form-control "/>
        <input type="text" id="v_2" value="<?php echo format_rupiah('2000'); ?>" class="form-control "/>
        <input type="text" id="v_1" value="<?php echo format_rupiah('1000'); ?>" class="form-control "/>
      </div>
      <div class="col-sm-1">
        <input type="text" id="vn_100" value="0" class="form-control "/>
        <input type="text" id="vn_50" value="0" class="form-control "/>
        <input type="text" id="vn_20" value="0" class="form-control "/>
        <input type="text" id="vn_10" value="0" class="form-control "/>
        <input type="text" id="vn_5" value="0" class="form-control "/>
        <input type="text" id="vn_2" value="0" class="form-control "/>
        <input type="text" id="vn_1" value="0" class="form-control "/>        
      </div>
      <div class="col-sm-2">
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vval_100" class="form-control">

        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vval_50" class="form-control">
 
        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vval_20" class="form-control">
        
        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vval_10" class="form-control">
         
        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vval_5" class="form-control">
         
        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vval_2" class="form-control">
         
        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vval_1" class="form-control">
       
        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vtotal_k" class="form-control">
       
        </div>    
      </div>
    </div>
  </div>


<!-- Uang Logam-->

<div class="row">
    <div class="form-group">
      <label for="vno_bukti_kas" class="col-sm-2 control-label">Uang LOGAM</label>
      <div class="col-sm-2">
        <input type="text" id="L_1000" value="<?php echo format_rupiah('1000'); ?>" class="form-control "/>
        <input type="text" id="L_500" value="<?php echo format_rupiah('500'); ?>" class="form-control "/>
        <input type="text" id="L_200" value="<?php echo format_rupiah('200'); ?>" class="form-control "/>
        <input type="text" id="L_100" value="<?php echo format_rupiah('100'); ?>" class="form-control "/>        
      </div>
      <div class="col-sm-1">
        <input type="text" id="vnL_1000" value="0" class="form-control "/>
        <input type="text" id="vnL_500" value="0" class="form-control "/>
        <input type="text" id="vnL_200" value="0" class="form-control "/>
        <input type="text" id="vnL_100" value="0" class="form-control "/>      
      </div>
      <div class="col-sm-2">
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vl_1000" class="form-control">

        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vl_500" class="form-control">
 
        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vl_200" class="form-control">
        
        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vl_100" class="form-control">
         
        </div>
        <div class="input-group">
          <span class="input-group-addon">Rp</span>
            <input type="text" value="0" id="vtotal_l" class="form-control">
       
        </div>  
      </div>
    </div>
  </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Total Fisik Uang Kas</label>
      <div class="col-sm-3">
      </div>
      <div class="col-sm-2">
      <div class="input-group">
      <span class="input-group-addon">Rp</span>      
        <input type="text" id="v_total_stok" class="form-control" placeholder="Total" />
      </div>      
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-2 control-label">Bon Gantung</label>
      <div class="col-sm-3">
      </div>
      <div class="col-sm-2">
      <div class="input-group">
      <span class="input-group-addon">Rp</span>        
        <input type="text" value="0" id="v_total_bon" class="form-control" placeholder="Bon Gantung" />
      </div>      
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Total Uang Fisik + Bon Gantung</label>
      <div class="col-sm-2">
      </div>
      <div class="col-sm-2">
      <div class="input-group">
      <span class="input-group-addon">Rp</span>        
        <input type="text" id="v_bon_fisik" class="form-control" placeholder="Total Uang Fisik & Bon Gantung" /> 
      </div>     
      </div>
    </div>

    <div class="form-group">
      <label id="label_kas" class="col-sm-4 control-label"></label>
      <div class="col-sm-1">
      </div>
      <div class="col-sm-2">
      <div class="input-group">
      <span class="input-group-addon">Rp</span>        
        <input type="text" value="0" id="v_total_kas" class="form-control" placeholder="Stok Kas Operasional Cabang" /> 
      </div>     
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">SELISIH KURANG ( ) / LEBIH</label>
      <div class="col-sm-2">
      </div>
      <div class="col-sm-2">
      <div class="input-group">
      <span class="input-group-addon">Rp</span>       
        <input type="text" id="v_selisih" class="form-control" placeholder="Selisih Kurang ( ) / Lebih " /> 
      </div>     
      </div>
    </div>

    <div class="form-group">
      <label for="vketerangan" class="col-sm-2 control-label">Keterangan</label>
      <div class="col-sm-3">
      </div>
      <div class="col-sm-3">
        <textarea id="vketerangan" placeholder="Keterangan" class="form-control" rows="3"></textarea>
      </div>
    </div>

    <div class="form-group">
      <div class="col-md-4">
    </div>
    <div class="col-md-4">     
    <!--  <button type="button" id="ssaldoawal" class="btn btn-info" onclick="setStokKas()">Simpan</button> -->
<!--      <button type="button" id="ssaldoawalupdate" class="btn btn-success" onclick="setSaldoKasUpdate()">
     <span class="fa fa-plus-square" aria-hidden="true"></span> Update 
     </button> -->
     <button id="printStok" onclick="printStokKas()" class="btn btn-success">
      <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak
     </button>
     <button id="btnClosing" onclick="closingHarian()" class="btn btn-success">
      <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Closing
     </button>
     
    </div>
    
    <input type="hidden" id="vbagian" value="CABANG">
    <input type="hidden" id="dtggl_kas" value="<?php echo $today; ?>">
    <input type="hidden" id="dwaktu_tambah" value="<?php echo $today2; ?>">
    <input type="hidden" id="vuser_kasir" value="<?php echo $user->idUserKasir; ?>">

    <input type="hidden" id="v100n" value="100000">
    <input type="hidden" id="v50n" value="50000">
    <input type="hidden" id="v20n" value="20000">
    <input type="hidden" id="v10n" value="10000">
    <input type="hidden" id="v5n" value="5000">
    <input type="hidden" id="v2n" value="2000">
    <input type="hidden" id="v1n" value="1000">
    <input type="hidden" id="vl500n" value="500">
    <input type="hidden" id="vl200n" value="200">
    <input type="hidden" id="vl100n" value="100">

</form>

<div class="records_content">
</div>

<!--Print Modal -->
        <div class="modal fade" style="display:none" id="printModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Stok Kas Harian Operasional CABANG</h4>
                    </div>

      <div class="modal-body">
        <div class="modalPrintBody">
        </div>
      </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<!-- Print Modal -->
<script src="../assets/js/stok_kas.js?v=<?php echo uniqid(); ?>"></script>
<script type="text/javascript" src="../assets/js/jquery.media.js"></script>
</body>
</html>