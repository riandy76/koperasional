// Add Record
function setSaldoAwal() {
    // get values
    var gsaldo_awal = $("#v_saldo_awal").val();
    gsaldo_awal = gsaldo_awal.trim();

    var gketerangan = $("#vketerangan").val();
    gketerangan = gketerangan.trim();

    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();

    var gdtggl_periode = $("#v_tggl_periode").val();
    gdtggl_periode = gdtggl_periode.trim();

    var gdwaktu_tambah = $("#dwaktu_tambah").val();
    gdwaktu_tambah = gdwaktu_tambah.trim();

    var guser_kasir = $("#vuser_kasir").val();
    guser_kasir = guser_kasir.trim();
 
    if (gsaldo_awal == "") {
        alert("Saldo Awal is required!");
    }
    else if (gketerangan == "") {
        alert("Keterangan is required!");
    }
    else if (gbagian == "") {
        alert("Bagian is required!");
    }
    else if (gdtggl_periode == "") {
        alert("Tanggal Periode Awal is required!");
    }        
    else {
        // Add record
        $.post("../php/master/do_saldo_awal_set.php", {
            psaldo_awal: gsaldo_awal,
            pketerangan: gketerangan,
            pbagian: gbagian,
            ptggl_periode: gdtggl_periode,
            pwaktu_tambah: gdwaktu_tambah,
            puser_kasir: guser_kasir            
        }, function (data, status) {            
            // clear fields form
            // $("#v_saldo_awal").val("");
            // $("#vketerangan").val("");
            // read records again
            readRecords();
            getSaldoKasClosingSebelum();
        });
    }
}

/**
Fungsi ini untuk set saldo awal,
variable v_tggl_periode mengambil nilai datepicker yang terpilih (hari ini)
lalu di pass ke saldo_kas_closing_sebelum_set.php dan diubah ke tanggal sebelum,
karena modul uang muka membaca tanggal sebelumnya.
**/
function setClosing() {
    // get values
    var gsaldo_awal = $("#v_saldo_awal").val();
    gsaldo_awal = gsaldo_awal.trim();

    var gketerangan = $("#vketerangan").val();
    gketerangan = gketerangan.trim();

    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();

    var gdtggl_periode = $("#v_tggl_periode").val();
    gdtggl_periode = gdtggl_periode.trim();

    var gdwaktu_tambah = $("#dwaktu_tambah").val();
    gdwaktu_tambah = gdwaktu_tambah.trim();

    var guser_kasir = $("#vuser_kasir").val();
    guser_kasir = guser_kasir.trim();
 
    if (gsaldo_awal == "") {
        alert("Saldo Awal is required!");
    }
    else if (gketerangan == "") {
        alert("Keterangan is required!");
    }
    else if (gbagian == "") {
        alert("Bagian is required!");
    }
    else if (gdtggl_periode == "") {
        alert("Tanggal Periode Awal is required!");
    }        
    else {
        // Add record
        $.post("../php/master/saldo_kas_closing_sebelum_set.php", {
            psaldo_awal: gsaldo_awal,
            pketerangan: gketerangan,
            pbagian: gbagian,
            ptggl_periode: gdtggl_periode,
            pwaktu_tambah: gdwaktu_tambah,
            puser_kasir: guser_kasir            
        }, function (data, status) {            
            // read records again
            readRecords();
            $("#v_saldo_awal").val("");
            $("#vketerangan").val("");
        });
    }
}



// READ records
function readRecords() {
    //var v_tggl_periode = $('#v_tggl_periode').val();
      //if(from_date != '')
      //{
        $.post("../php/master/do_saldo_awal_read.php", 
        {
            //pfrom_date:from_date
        }, function (data, status) {
        $(".records_content").html(data);
        getSaldoKasAwalPusat();
        });
      //}else
      //{
       // alert("Please Select Date");
      //}
}

/**Read tabel saldo_kas, jika ada data closing di hari ini,
 maka disbale tombol Closing **/
function getSaldoKasClosingSebelum() {
    var vtggl_periode = $('#v_tggl_periode').val();
    var gbagian = $("#vbagian").val();
    gbagian = gbagian.trim();

      if(vtggl_periode != '')
      {
        $.post("../php/master/saldo_kas_closing_sebelum_read.php", 
        {
          ptggl_periode: vtggl_periode,
          pbagian: gbagian
        }, function (data, status) 
        {
          //Parse JSON data
          var kas = JSON.parse(data);
          if (kas == false)
          {
            setClosing();
            // clear fields form
            // $("#v_saldo_awal").val("");
            // $("#vketerangan").val("");
          }
        });
      }else
      {
        alert("Please Select Date");
      }
}

function getSaldoKasAwalPeriode() {
    var vtggl_periode = $('#v_tggl_periode').val();

      if(vtggl_periode != '')
      {
        $.post("../php/master/saldo_awal_read.php", 
        {
          ptggl_periode: vtggl_periode
        }, function (data, status) 
        {
        if ($.trim(data)){
            $(".messageError").html(data);
            $("#v_tggl_periode").prop("disabled", true);
            $("#v_saldo_awal").prop("disabled", true);
            $("#vketerangan").prop("disabled", true);
            $("#vbagian").prop("disabled", true);
            $("#ssaldoawal").prop("disabled", true);            
            }
        });
      }else
      {
        alert("Please Select Date");
      }
}

/**
Fungsi jika saldo awal pusat tidak ada
maka disable pilihan input dan set value nya menjadi PUSAT
**/
function getSaldoKasAwalPusat() {
    var vtggl_periode = $('#v_tggl_periode').val();

      if(vtggl_periode != '')
      {
        $.post("../php/master/saldo_awal_pusat_read.php", 
        {
          ptggl_periode: vtggl_periode
        }, function (data, status) 
        {
        if ($.trim(data)){
            $(".messageError").html(data);
            $("#vbagian").prop("disabled", true);
            $("#vbagian").val("PUSAT").prop('selected', true);
            }else{
                getSaldoKasAwalCabang();
            }
        });
      }else
      {
        alert("Please Select Date");
      }
}

function getSaldoKasAwalCabang() {
    var vtggl_periode = $('#v_tggl_periode').val();

      if(vtggl_periode != '')
      {
        $.post("../php/master/saldo_awal_cabang_read.php", 
        {
          ptggl_periode: vtggl_periode
        }, function (data, status) 
        {
        if ($.trim(data)){
            $(".messageError").html(data);
            $("#vbagian").prop("disabled", true);
            $("#vbagian").val("CABANG").prop('selected', true);
            }else{
                getSaldoKasAwalPeriode();
            }
        });
      }else
      {
        alert("Please Select Date");
      }
}

//Jika halaman sudah berhasil di load / di buka
$(document).ready(function() {
// READ records on page load
// calling function
readRecords();   
});
