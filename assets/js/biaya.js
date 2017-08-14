function GetNomorKas() {
    // Add User ID to the hidden field
    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();

    $.post("../php/include/kas_keluar_get_nomor_kas.php", {
            pbagian: gbagian
        },
        function (data) {
            $('#vno_bukti_kas').val(data);
        }
    );
}

/**
Fungsi Cetak Bukti Kas per data Uang Muka
**/
function CetakBuktiKas(vid){

    $.post("../php/include/biaya_print_bukti_kas.php", 
        {
            pid: vid
        }, function (data, status) {
            $("#printModal").modal('show');
            $(".modalPrintBody").html(data);
        });
}

// Add Record
function addRecord() {
    // get values
    var gno_bukti_kas = $("#vno_bukti_kas").val();
    gno_bukti_kas = gno_bukti_kas.trim();

    var gpenerima = $("#vid_pegguna_get").val();
    gpenerima = gpenerima.trim();

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

    var gstatus = $("#vstatus").val();
    gstatus = gstatus.trim();
 
    if (gpenerima == "") {
        alert("Nama Penerima is required!");
    }
    else if (gjumlah == "") {
        alert("Jumlah Uang is required!");
    }
    else if (gketerangan == "") {
        alert("Keterangan is required!");
    }
    else if (gjenis_biaya == "") {
        alert("Jenis Biaya is required!");
    }
    else if (gstatus == "") {
        alert("Status is required!");
    }        
    else {
        // Add record
        $.post("../php/include/uang_muka_create.php", {
            pno_bukti_kas: gno_bukti_kas,
            ppenerima: gpenerima,
            pjumlah: gjumlah,
            pketerangan: gketerangan,
            pjenis_biaya: gjenis_biaya,
            pbagian: gbagian,
            ptggl_kas: gdtggl_kas,
            pwaktu_tambah: gdwaktu_tambah,
            puser_kasir: guser_kasir,
            pstatus: gstatus            
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");            
            // clear fields from the popup
            $("#vpenerima").val("");
            $("#vjumlah").val("");
            $("#vketerangan").val("");
            $("#vjenis_biaya").val(".:: Pilih Jenis Biaya ::.");
            // read records again
            readRecords();
        });
    }
}

// READ records
function readRecords() {
    var from_date = $('#from_date').val();
    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();

      if(from_date != '')
      {
        $.post("../php/include/biaya_read.php", 
        {
            pfrom_date:from_date,
            pbagian: gbagian
        }, function (data, status) {
        GetNomorKas();
        $(".records_content").html(data);
        $("#vketerangan").val("Biaya ");
        });
      }else
      {
        alert("Please Select Date");
      }
}

/**
Fungsi untuk cek apakah sudah closing di hari sebelum dan hari ini ?
**/
function readSaldoKas() {
    var gjumlah = $("#vjumlah").val();

    var gpenerima = $("#vid_pegguna_get").val();

    var gbagian = $("#vbagian").val();

    var gjumlah = $("#vjumlah").val();

    var gjenis_biaya = $("#vjenis_biaya").val();
    
    var from_date = $('#from_date').val();

    if (gpenerima == '') {
        alert("Penerima tidak boleh kosong");
    }
    else if (gjumlah == '') {
        alert("Jumlah tidak boleh kosong");
    }    
    else if (gjenis_biaya == ".:: Pilih Jenis Biaya ::.") {
        alert("Jenis Biaya is required!");
    }
    else if (from_date != '') {
        $.post("../php/include/readSaldoKas.php", 
        {
            pfrom_date: from_date,
            pbagian: gbagian,
            pbiaya: gjumlah
        }, function (data, status) {
        if ($.trim(data)){
            $(".checkSaldoAwal").html(data);
            // close the popup
            $("#add_new_record_modal").modal("hide");            
            // clear fields from the popup
            $("#vpenerima").val("");
            $("#vid_pegguna_get").val("");
            $("#vjumlah").val("");
            $("#vketerangan").val("Biaya ");
            $("#vjenis_biaya").val(".:: Pilih Jenis Biaya ::.");
            readRecords();
        }else{
            addRecord();
        }
        });
      }else
      {
        alert("Please Select Date");
      }
}

/**
Fungsi untuk ambil data kas untuk di update nilainya.
**/
function uangmukaUpdate(vid) {
    // Add User ID to the hidden field
    $("#vid_update").val(vid);
    $.post("../php/include/uang_muka_details.php", {
            pid: vid
        },
        function (data, status) {
            // PARSE json data
            var kas = JSON.parse(data);
            //var tketerangan = "Pengembalian ";
            // Assign existing values to the modal popup fields
            $("#vno_bukti_kas-update").val(kas.no_bukti_kas);
            $("#vpenerima-update").val(kas.namaPengguna);
            $("#vid_pegguna_get_update").val(kas.penerima);
            $("#vjumlah-update").val(kas.jumlah);
            $("#vjenis_biaya-update").val(kas.jenis_biaya);
            $("#vketerangan-update").val(kas.keterangan);            
            //$("#vuser_kasir-update").val(kas.user_kasir);
        }
    );
    // Open modal popup
    $("#update_kas_pusat_modal").modal("show");
}

function UpdateUangMuka() {
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

    var gstatus = $("#vstatus_update").val();
    gstatus = gstatus.trim();

 
    if (gpenerima == "") {
        alert("First name field is required!");
    }
    else if (gjumlah == "") {
        alert("Last name field is required!");
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
        $.post("../php/include/uang_muka_update.php", {
                pid: gid,
                ppenerima: gpenerima,
                pjumlah: gjumlah,
                pjenis_biaya: gjenis_biaya,
                pketerangan: gketerangan,
                pwaktu_tambah: gwaktu_tambah,
                puser_kasir: guser_kasir,
                pstatus: gstatus
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

/**
Fungsi Untuk Delete Record
**/
function uangmukaDelete(vid) {
    // var conf = confirm("Apakah data ini akan di hapus ?");
    // if (conf == true) {
    //     $.post("../php/include/uang_muka_delete.php", {
    //             pid: vid
    //         },
    //         function (data, status) {
    //             // reload Users by using readRecords();
    //             readRecords();
    //         }
    //     );
    // }

    $( "#dialog-delete" ).dialog({
      dialogClass: "no-close",
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Hapus": function() {
          // $( this ).dialog( "close" );
        $.post("../php/include/uang_muka_delete.php", {
                pid: vid
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();                
            }
        );
          $( this ).dialog( "close" );
        },
        Batal: function() {
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

                    // Display the returned data in browser pakai .html() kalau pakai .append() betambah banyak

                    resultDropdown.html(data);
                    var getID = $("#vid_pengguna").val();
                    $("#vid_pegguna_get").val(getID);

                });

            } else{

                resultDropdown.empty();

            }

        });

// fungsi live search pengguna_kas

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

                    // Display the returned data in browser pakai .html() kalau pakai .append() betambah banyak

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
// calling function
readRecords();
});
