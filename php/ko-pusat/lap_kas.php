<?php
session_start();

if (!isset($_SESSION['user_id']))
{
  header("Location: ../../php/index.php"); 
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<h4 class="page-header">.:: Kas Operasional Pusat - Laporan Biaya Kas Operasional ::.</h4>

<form class="navbar-form navbar-left">
  <div class="form-group">
    <label for="from_date">Pilih Tanggal</label>
    <input type="text" id="from_date" class="form-control"/>
    <input type="hidden" id="vbagian" value="PUSAT">
  </div>
  <button type="button" id="printLaporan" class="btn btn-info" onclick="CetakBuktiKas()">
  <span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>
</form>

  <div class="records_content">
	</div>

<!-- Bootstrap Modals -->
  <!-- Modal Print Out Bukti Kas Keluar -->
        <div class="modal fade" style="display:none" id="printModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cetak Laporan Biaya Kas Operasional</h4>
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
  <!-- Modal Print Out Bukti Kas Keluar -->

<script src="../assets/js/lap_kas.js?v=<?php echo uniqid(); ?>"></script>
<script src="../assets/js/jquery.media.js"></script>
</body>
</html>