/**
Fungsi Cetak Bukti Kas per data Uang Muka
**/
function CetakBonGantung(vid){

    $.post("../php/include/do_bon_gantung_print.php", 
        {
            pid: vid
        }, function (data, status) {
            $("#printModal").modal('show');
            $(".modalPrintBody").html(data);
        });
}

// READ records
function readRecords() {
    var from_date = $('#from_date').val();
    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();
    if(from_date != '')
    {
        $.post("../php/include/do_bon_gantung_read.php", 
        {
            pfrom_date:from_date,
            pbagian: gbagian
        }, function (data, status) {
        $(".records_content").html(data);
        });
    }
}

// Add Record
function setBonGantung() {
    // get values
    var gjumlah = $("#vjumlah").val();
    gjumlah = gjumlah.trim();

    var gketerangan = $("#vketerangan").val();
    gketerangan = gketerangan.trim();

    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();

    var gtggl_bon = $("#vtggl_bon").val();
    gtggl_bon = gtggl_bon.trim();

    var gdwaktu_bon = $("#dwaktu_bon").val();
    gdwaktu_bon = gdwaktu_bon.trim();

    var guser_kasir = $("#vuser_kasir").val();
    guser_kasir = guser_kasir.trim();

    var gpenerima = $("#vid_pegguna_get").val();
    gpenerima = gpenerima.trim();
 
    if (gjumlah == "") {
        alert("Jumlah is required!");
    }
    else if (gketerangan == "") {
        alert("Keterangan is required!");
    }
    else if (gpenerima == "") {
        alert("Penerima is required!");
    }        
    else {
        // Add record
        $.post("../php/include/do_bon_gantung_set.php", {
            pjumlah: gjumlah,
            pketerangan: gketerangan,
            pbagian: gbagian,
            ptggl_bon: gtggl_bon,
            pwaktu_bon: gdwaktu_bon,
            puser_kasir: guser_kasir,
            ppenerima: gpenerima           
        }, function (data, status) {
        // close the popup
        $("#add_new_record_modal").modal("hide");
        $("#vpenerima").val("");
        $("#vketerangan").val("");
        $("#vjumlah").val("");         
        readRecords();
        });
    }
}

/**
Fungsi untuk ambil data kas untuk di update nilainya.
**/
function getBonDetails(vid) {
    // Add User ID to the hidden field
    $("#vid_update").val(vid);
    $.post("../php/include/do_bon_gantung_details.php", {
            pid: vid
        },
        function (data, status) {
            // PARSE json data
            var kas = JSON.parse(data);
            //var tketerangan = "Pengembalian ";
            // Assign existing values to the modal popup fields
            $("#vtggl_bon_update").val(kas.tggl_bon);
            $("#vpenerima_update").val(kas.namaPengguna);
            $("#vjumlah_update").val(kas.jumlah);
            $("#vbagian_update").val(kas.bagian);
            $("#vketerangan_update").val(kas.keterangan);
        }
    );
    // Open modal popup
    $("#update_bon_modal").modal("show");
}

/**
Update data bon gantung nya
**/
function updateBonGantung() {
    // get values
    var vid_update = $("#vid_update").val();
    vid_update = vid_update.trim();

    var gjumlah = $("#vjumlah_update").val();
    gjumlah = gjumlah.trim();

    var gketerangan = $("#vketerangan_update").val();
    gketerangan = gketerangan.trim();

    var gbagian = $("#vbagian_update").val();
    gbagian = gbagian.trim();

    var gtggl_bon = $("#vtggl_bon_update").val();
    gtggl_bon = gtggl_bon.trim();

    var gdwaktu_bon = $("#vwaktu_bon_update").val();
    gdwaktu_bon = gdwaktu_bon.trim();

    var guser_kasir = $("#vuser_kasir_update").val();
    guser_kasir = guser_kasir.trim();

    var gpenerima = $("#vid_pegguna_get").val();
    gpenerima = gpenerima.trim();
 
    if (gjumlah == "") {
        alert("Jumlah is required!");
    }
    else if (gketerangan == "") {
        alert("Keterangan is required!");
    }
    else if (gpenerima == "") {
        alert("Penerima is required!");
    }        
    else {
        /**
        waktu_bon, penerima, keterangan, jumlah, user_kasir
        Add record **/
        $.post("../php/include/do_bon_gantung_update.php", {
            pid: vid_update,
            pjumlah: gjumlah,
            pketerangan: gketerangan,
            pwaktu_bon: gdwaktu_bon,
            puser_kasir: guser_kasir,
            ppenerima: gpenerima           
        }, function (data, status) {
        // close the popup
        $("#update_bon_modal").modal("hide");
        $("#vpenerima_update").val("");
        $("#vketerangan_update").val("");
        $("#vjumlah_update").val("");         
        readRecords();
        });
    }
}


/**
Fungsi Untuk Delete Record
**/
function UpdateBonBayar(vid) {
    var gtggl_bon = $("#dtggl_bon").val();
    gtggl_bon = gtggl_bon.trim();

    var gdwaktu_bon = $("#dwaktu_bon").val();
    gdwaktu_bon = gdwaktu_bon.trim();

    $( "#dialog-confirm" ).dialog({
      dialogClass: "no-close",
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Bayar": function() {
          // $( this ).dialog( "close" );
        $.post("../php/include/do_bon_gantung_bayar.php", {
                pid: vid,
                pwaktu_bon: gdwaktu_bon
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

/**
Fungsi Untuk Delete Record
**/
function bonDelete(vid) {

    $( "#dialog-delete" ).dialog({
      dialogClass: "no-close",
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Hapus": function() {
          // $( this ).dialog( "close" );
        $.post("../php/include/do_bon_gantung_delete.php", {
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

//Jika halaman sudah berhasil di load / di buka
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
        $( "#vpenerima_update" ).keyup(function() {
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

// calling function
readRecords();   
});
