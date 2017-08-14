/**
Fungsi Cetak Bukti Kas per data Uang Muka
**/
function CetakBuktiKas(vid){

    $.post("../php/include/kas_masuk_print_bukti_kas.php", 
        {
            pid: vid
        }, function (data, status) {
            $("#printModal").modal('show');
            $(".modalPrintBody").html(data);
        });
}

function GetNomorKas() {
    // Add User ID to the hidden field
    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();

    $.post("../php/include/kas_masuk_get_nomor_kas.php", {
            pbagian: gbagian
        },
        function (data) {
            $('#vno_bukti_kas').val(data);
        }
    );
}

// Add Record
function addRecord() {
    // get values
    var gno_bukti_kas = $("#vno_bukti_kas").val();
    gno_bukti_kas = gno_bukti_kas.trim();

    var gid_penerima = $("#vid_pegguna_get").val();
    gid_penerima = gid_penerima.trim();

    var gjumlah = $("#vjumlah").val();
    gjumlah = gjumlah.trim();

    var gketerangan = $("#vketerangan").val();
    gketerangan = gketerangan.trim();

    var gjenis_biaya = $("#vjenis_biaya").val();
    gjenis_biaya = gjenis_biaya.trim();

    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();

    var gdtggl_kas = $("#dtggl_kas").val();
    gdtggl_kas = gdtggl_kas.trim();

    var gdwaktu_tambah = $("#dwaktu_tambah").val();
    gdwaktu_tambah = gdwaktu_tambah.trim();

    var guser_kasir = $("#vuser_kasir").val();
    guser_kasir = guser_kasir.trim();
 
    if (gid_penerima == "") {
        alert("Penerima belum di isi !");
    }
    else if (gjumlah == "") {
        alert("Jumlah Uang belum di isi !");
    }
    else if (gketerangan == "") {
        alert("Keterangan belum di isi !");
    }
    else if (gjenis_biaya == "") {
        alert("Jenis Biaya belum di isi !");
    }    
    else {
        // Add record
        $.post("../php/include/kas_masuk_create.php", {
            pno_bukti_kas: gno_bukti_kas,
            ppenerima: gid_penerima,
            pjumlah: gjumlah,
            pketerangan: gketerangan,
            pjenis_biaya: gjenis_biaya,
            pbagian: gbagian,
            ptggl_kas: gdtggl_kas,
            pwaktu_tambah: gdwaktu_tambah,
            puser_kasir: guser_kasir            
        }, function (data, status) {
            // close the popup
            $("#modalBaru").modal("hide");
 
            // read records again
            readRecords();
 
            // clear fields from the popup
            // $("#vno_bukti_kas").val("");
            $("#vpenerima").val("");
            $("#vjumlah").val("");
            $("#vketerangan").val("");
        });
    }
}

/*********** 
READ records
************/
function readRecords() {
    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();
    
    var from_date = $('#from_date').val();
      if(from_date != '')
      {
        $.post("../php/include/kas_masuk_read.php", 
        {
            pfrom_date:from_date,
            pbagian: gbagian
        }, function (data, status) {
        $(".records_content").html(data);
        GetNomorKas();
        });
      }else
      {
        alert("Pilih tanggal terlebih dahulu...");
      }
}

/**
Fungsi untuk cek apakah sudah closing di hari sebelum dan hari ini ?
**/
function readSaldoKas() {
    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();
    
    var from_date = $('#from_date').val();
      if(from_date != '')
      {
        $.post("../php/include/readSaldoKas.php", 
        {
            pfrom_date:from_date,
            pbagian: gbagian
        }, function (data, status) {
        if ($.trim(data)){
            $(".checkSaldoAwal").html(data);
            $("#from_date").datepicker('disable');
            $("#filter").prop("disabled", true);
            $("#print-filter").prop("disabled", true);
            $("#newData").prop("disabled", true);
        }else{
            readRecords();
        }
        });
      }else
      {
        alert("Please Select Date");
      }
}

function GetKasDetails(vid) {
    // Add User ID to the hidden field
    $("#vid_update").val(vid);
    $.post("../php/include/kas_masuk_details.php", {
            pid: vid
        },
        function (data, status) {
            // PARSE json data
            var kas = JSON.parse(data);
            // Assign existing values to the modal popup fields
            // $("select[name=foo] option[value=bar]).attr('selected','selected');
            // $("#gate option[value='Gateway 2']").prop('selected', true);
            $("#vno_bukti_kas-update").val(kas.no_bukti_kas);
            $("#vpenerima-update").val(kas.namaPengguna);
            $("#vjumlah-update").val(kas.jumlah);
            $("#vjenis_biaya-update").val(kas.jenis_biaya);
            $("#vketerangan-update").val(kas.keterangan);            
        }
    );
    // Open modal popup
    $("#update_kas_pusat_modal").modal("show");
}

function UpdateKasMasuk() {
    // get values
    var gpenerima = $("#vid_pegguna_get").val();
    gpenerima = gpenerima.trim();

    var gjumlah = $("#vjumlah-update").val();
    gjumlah = gjumlah.trim();

    var gjenis_biaya = $("#vjenis_biaya-update").val();
    gjenis_biaya = gjenis_biaya.trim();

    var gketerangan = $("#vketerangan-update").val();
    gketerangan = gketerangan.trim();
    
    var gwaktu_tambah = $("#dwaktu_tambah-update").val();
    gwaktu_tambah = gwaktu_tambah.trim();

    var guser_kasir = $("#vuser_kasir-update").val();
    guser_kasir = guser_kasir.trim();

 
    if (gpenerima == "") {
        alert("Penerima belum di isi !");
    }
    else if (gjumlah == "") {
        alert("Jumlah field is required!");
    }
    else if (gjenis_biaya == "") {
        alert("Email field is required!");
    }
    else if (gketerangan == "") {
        alert("Email field is required!");
    }
    else {
        // get hidden field value
        var gid = $("#vid_update").val();
 
        // Update the details by requesting to the server using ajax
        $.post("../php/include/kas_masuk_update.php", {
                pid: gid,
                ppenerima: gpenerima,
                pjumlah: gjumlah,
                pjenis_biaya: gjenis_biaya,
                pketerangan: gketerangan,
                pwaktu_tambah: gwaktu_tambah,
                puser_kasir: guser_kasir
            },
            function (data, status) {
                // hide modal popup
                $("#update_kas_pusat_modal").modal("hide");
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

function DeleteKasMasuk(vid) {

    $( "#dialog-confirm" ).dialog({
      dialogClass: "no-close",
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Delete": function() {
          // $( this ).dialog( "close" );
        $.post("../php/include/kas_masuk_delete.php", {
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

//jika halaman sudah berhasil di load / di buka
$(document).ready(function() {
// fungsi live search pengguna_kas 

        // $('.search-box input[type="text"]').on("keyup input", function(){
        $( "#vpenerima" ).keyup(function() {
            /* Get input value on change */

            var inputVal = $(this).val();

            var resultDropdown = $(this).siblings(".result");
            // var resultHidden = $(this).siblings(".hidden_field");

            if(inputVal.length){

                $.get("../php/include/search_pengguna.php", {
                    pterm: inputVal
                }).done(function(data){

                    // Display the returned data in browser

                    resultDropdown.html(data);
                    var getID = $("#vid_pengguna").val();
                    $("#vid_pegguna_get").val(getID);

                });

            } else{

                resultDropdown.empty();

            }

        });

        // $('.search-box input[type="text"]').on("keyup input", function(){
        $( "#vpenerima-update" ).keyup(function() {
            /* Get input value on change */

            var inputVal = $(this).val();

            var resultDropdown = $(this).siblings(".result");
            // var resultHidden = $(this).siblings(".hidden_field");

            if(inputVal.length){

                $.get("../php/include/search_pengguna.php", {
                    pterm: inputVal
                }).done(function(data){

                    // Display the returned data in browser

                    resultDropdown.html(data);
                    var getID = $("#vid_pengguna").val();
                    $("#vid_pegguna_get").val(getID);

                });

            } else{

                resultDropdown.empty();

            }

        });
        

        // Set search input value on click of result item

        $(document).on("click", ".result p", function(){
        //$('.result p').click(function(){

            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());

            $(this).parent(".result").empty();

        });

// READ records on page load
readRecords(); // calling function	
});
