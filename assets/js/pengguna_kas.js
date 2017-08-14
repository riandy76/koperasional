/**
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
 **/
// Add Record
function addRecord() {
    // get values
    var gnama_pengguna = $("#vnama_pengguna").val();
    gnama_pengguna = gnama_pengguna.trim();

    var galamat_pengguna = $("#valamat_pengguna").val();
    galamat_pengguna = galamat_pengguna.trim();

    var gnomor_telp = $("#vnomor_telp").val();
    gnomor_telp = gnomor_telp.trim();

    var gtggl_tambah = $("#tggl_tambah").val();
    gtggl_tambah = gtggl_tambah.trim();

    var gid_user = $("#id_user_kasir").val();
    gid_user = gid_user.trim();

    if (gnama_pengguna == "") {
        alert("Nama pengguna tidak boleh kosong !");
    }
    else if (galamat_pengguna == "") {
        alert("Alamat pengguna tidak boleh kosong !");
    }
    else if (gnomor_telp == "") {
        alert("Nomor telpon pengguna tidak boleh kosong !");
    }      
    else {
        // Add record
        $.post("../php/master/pengguna_create.php", {
            pnama_pengguna: gnama_pengguna,
            palamat_pengguna: galamat_pengguna,
            pnomor_telp: gnomor_telp,
            p_tggl: gtggl_tambah,
            pid_user: gid_user       
        }, function (data, status) {
            // close the popup
            $("#modalBaru").modal("hide");            
            // clear fields from the popup
            $("#vnama_pengguna").val("");
            $("#valamat_pengguna").val("");
            $("#vnomor_telp").val("");
            // read records again
            readRecords();
        });
    }
}
/**
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
**/
function detailsData(vid) {

  // Open modal popup
  $("#modalUpdate").modal("show");
  $("#vid_update").val(vid);
    
$.post("../php/master/pengguna_details.php", {
            pid: vid
        },
        function (data, status) {
            // PARSE json data
            var j = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#vnama_pengguna_update").val(j.namaPengguna);
            $("#valamat_pengguna_update").val(j.alamatPengguna);
            $("#vnomor_telp_update").val(j.nomorTelpon);
        }
    );
}

// updateRecord
function updateRecord() {
    // get values
    var gid = $("#vid_update").val();
    gid = gid.trim();

    var gnama_pengguna = $("#vnama_pengguna_update").val();
    gnama_pengguna = gnama_pengguna.trim();

    var galamat_pengguna = $("#valamat_pengguna_update").val();
    galamat_pengguna = galamat_pengguna.trim();

    var gnomor_telp = $("#vnomor_telp_update").val();
    gnomor_telp = gnomor_telp.trim();

    if (gnama_pengguna == "") {
        alert("Nama pengguna tidak boleh kosong!");
    }
    else if (galamat_pengguna == "") {
        alert("Alamat pengguna tidak boleh kosong");
    }
    else if (gnomor_telp == "") {
        alert("Nomor telepon tidak boleh kosong");
    }
    else {
        // Add record
        $.post("../php/master/pengguna_update.php", {
            pid: gid,
            pnama_pengguna: gnama_pengguna,
            palamat_pengguna: galamat_pengguna,
            pnomor_telp: gnomor_telp                    
        }, function (data, status) {
            // close the popup
            $("#modalUpdate").modal("hide");
            // read records again
            readRecords();
        });
    }
}


/**
Fungsi Untuk Delete Record
**/
function deleteData(vid) {
    $( "#dialog-confirm" ).dialog({
      dialogClass: "no-close",
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Delete": function() {
          // $( this ).dialog( "close" );
        $.post("../php/master/pengguna_delete.php", {
                pid: vid
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();                
            }
        );
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
}

// READ records
function readRecords() {
        $.post("../php/master/pengguna_read.php", function (data, status) {
          $(".records_content").html(data);
        });
}


$(document).ready(function() {
// Baca data user
readRecords();
});