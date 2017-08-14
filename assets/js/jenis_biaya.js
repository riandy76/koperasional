// Add Record
function addRecord() {
    // get values
    var gjenis_biaya = $("#vjenis_biaya").val();
    gjenis_biaya = gjenis_biaya.trim();

    if (gjenis_biaya == "") {
        alert("Jenis biaya tidak boleh kosong !");
    }       
    else {
        // Add record
        $.post("../php/master/jenis_biaya_create.php", {
            pjenis_biaya: gjenis_biaya       
        }, function (data, status) {
            // close the popup
            $("#modalBaru").modal("hide");            
            // clear fields from the popup
            $("#vjenis_biaya").val("");
            // read records again
            readRecords();
        });
    }
}

function detailsJenis(vid) {

  // Open modal popup
  $("#modalUpdate").modal("show");
  $("#vid_update").val(vid);
    
$.post("../php/master/jenis_biaya_details.php", {
            pid: vid
        },
        function (data, status) {
            // PARSE json data
            var j = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#vjenis_update").val(j.nama_jenis);
        }
    );
}

// Update User
function updateJenis() {
    // get values
    var gid_jenis = $("#vid_update").val();
    gid_jenis = gid_jenis.trim();

    var gjenis_biaya = $("#vjenis_update").val();
    gjenis_biaya = gjenis_biaya.trim();
 
    if (gjenis_biaya == "") {
        alert("Jenis Biaya tidak boleh kosong!");
    }   
    else {
        // Add record
        $.post("../php/master/jenis_biaya_update.php", {
            pjenis_biaya: gjenis_biaya,
            pid_jenis: gid_jenis        
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
function deleteJenis(vid) {
    $( "#dialog-confirm" ).dialog({
      dialogClass: "no-close",
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Delete": function() {
          // $( this ).dialog( "close" );
        $.post("../php/master/jenis_biaya_delete.php", {
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
        $.post("../php/master/jenis_biaya_read.php", function (data, status) {
          $(".records_content").html(data);
        });
}


$(document).ready(function() {
// Baca data user
readRecords();
});