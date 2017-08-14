/**
Fungsi Cetak Bukti Kas per data Uang Muka
**/
function CetakBuktiKas(vid){

    $.post("../php/include/uang_muka_print_bukti_kas.php", 
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
    var gnama_dosen = $("#vnama_dosen").val();
 
    if (gnama_dosen == "") {
        alert("Nama Dosen is required!");
    }    
    else {
        // Add record
        $.post("../php/include/data_dosen_create.php", {
            pnama_dosen : gnama_dosen          
        }, function (data, status) {
            // close the popup
            $("#add_new_record_modal").modal("hide");            
            // clear fields from the popup
            $("#vnama_dosen").val("");
            // read records again
            readRecords();
        });
    }
}

// READ records
function readRecords() {

        $.post("../php/include/data_dosen_read.php", 
        {}, function (data, status) {
        $(".records_content").html(data);
        });
}

/**
Fungsi untuk cek apakah sudah closing di hari sebelum dan hari ini ?
**/
function readSaldoKas() {
    // $("#from_date").datepicker().datepicker("setDate", new Date());
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
            $("#from_date").prop("disabled", true);
            $("#filter").prop("disabled", true);
            $("#print-filter").prop("disabled", true);
            $("#bBaru").prop("disabled", true);
        }else{
            readRecords();
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
    $("#vid").val(vid);
    $.post("../php/include/uang_muka_details.php", {
            pid: vid
        },
        function (data, status) {
            // PARSE json data
            var kas = JSON.parse(data);
            //var tketerangan = "Pengembalian ";
            // Assign existing values to the modal popup fields
            $("#vno_bukti_kas-update").val(kas.no_bukti_kas);
            $("#vpenerima-update").val(kas.penerima);
            $("#vjumlah-update").val(kas.jumlah);
            $("#vjenis_biaya-update").val(kas.jenis_biaya);
            $("#vketerangan-update").val(kas.keterangan);            
            $("#vuser_kasir-update").val(kas.user_kasir);
        }
    );
    // Open modal popup
    $("#update_kas_pusat_modal").modal("show");
}

/**
Fungsi untuk ambil data yang akan di realisasi
**/
function uangmukaRealisasi(vid) {
    // Add User ID to the hidden field
    $("#vid-realisasi").val(vid);
    $.post("../php/include/uang_muka_details.php", {
            pid: vid
        },
        function (data, status) {
            // PARSE json data
            var kas = JSON.parse(data);
            // Assign existing values to the modal popup fields
            $("#vno_bukti_kas-realisasi").val(kas.no_bukti_kas);
            $("#vpenerima-realisasi").val(kas.penerima);
            $("#vjumlah-realisasi-keluar").val(kas.jumlah);
            $("#vjenis_biaya-realisasi").val(kas.jenis_biaya);
            $("#vketerangan-realisasi-2").val(kas.keterangan.replace("Uang muka", ""));
            $("#vketerangan-realisasi").val(kas.keterangan.replace("Uang muka", "Pengembalian UM")+" (via UM tanggal "+kas.tggl_kas+")");
            $("#vuser_kasir-realisasi").val(kas.user_kasir);
        }
    );
    // Open modal popup
    $("#realisasi_kas_pusat_modal").modal("show");
}

function UpdateUangMukaRealisasi() {
    // body...
    var gpenerima = $("#vpenerima-realisasi").val();
    gpenerima = gpenerima.trim();

    var gjumlah_realisasi = $("#vjumlah-realisasi").val();
    gjumlah_realisasi = gjumlah_realisasi.trim();

    var gjumlah_keluar = $("#vjumlah-realisasi-keluar").val();
    gjumlah_keluar = gjumlah_keluar.trim();

    var gjenis_biaya = $("#vjenis_biaya-realisasi").val();
    gjenis_biaya = gjenis_biaya.trim();

    var gketerangan = $("#vketerangan-realisasi").val();
    gketerangan = gketerangan.trim();

    var gketerangan2 = $("#vketerangan-realisasi-2").val();
    gketerangan2 = gketerangan2.trim();
    
    var gwaktu_tambah = $("#dwaktu_tambah-realisasi").val();
    gwaktu_tambah = gwaktu_tambah.trim();

    var gdtggl_kas = $("#dtggl_kas-realisasi").val();
    gdtggl_kas = gdtggl_kas.trim();

    var guser_kasir = $("#vuser_kasir-realisasi").val();
    guser_kasir = guser_kasir.trim();

    var gbagian = $("#vbagian-realisasi").val();
    gbagian = gbagian.trim();

 
    if (gpenerima == "") {
        alert("Penerima tidak boleh kosong!");
    }
    else if (gjumlah_realisasi == "") {
        alert("Jumlah tidak boleh kosong!");
    }
    else if (gjenis_biaya == "") {
        alert("Email field is required!");
    }
    else if (gketerangan == "") {
        alert("Email field is required!");
    }
    else {
        // get hidden field value
        var gid = $("#vid-realisasi").val();
 
        // Update the details by requesting to the server using ajax
        $.post("../php/include/uang_muka_realisasi.php", {
                pid: gid,
                ppenerima: gpenerima,
                pjumlah_keluar: gjumlah_keluar,
                pjumlah_realisasi: gjumlah_realisasi,
                pjenis_biaya: gjenis_biaya,
                pketerangan: gketerangan,
                pketerangan2: gketerangan2,
                pwaktu_tambah: gwaktu_tambah,
                puser_kasir: guser_kasir,
                ptggl_kas: gdtggl_kas,
                pbagian: gbagian
            },
            function (data, status) {
                // hide modal popup
                $("#realisasi_kas_pusat_modal").modal("hide");
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

function UpdateUangMuka() {
    // get values
    var gpenerima = $("#vpenerima-update").val();
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
        var gid = $("#vid").val();
 
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
function dosenDelete(vnama_dosen) {
    var conf = confirm("Apakah data dosen ini akan di hapus ?");
    if (conf == true) {
        $.post("../php/include/data_dosen_delete.php", 
        {
            pnama_dosen: vnama_dosen
        },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

//load jika halaman sudah ready
$(document).ready(function() {
//Panggil Fungsi readSaldoKas()
readRecords();
});