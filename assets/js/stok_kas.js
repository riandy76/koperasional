function sums(){
  var vval_100i, vval_50i, vval_20i, vval_10i, vval_5i, vval_2i, vval_1i,
      vl_1000i, vl_500i, vl_200i, vl_100i,
      v100n, v50n, v20n, v10n, v5n, v2n, v1n,
      vl1000n, vl500n, vl200n, vl100n, vval_total_bon,
      sum100, sum50, sum20, sum10, sum5, sum2, sum1,
      suml1000, suml500, suml200, suml100, 
      sum_total, sumtotal_k, sumtotal_l, sum_bon_fisik, vv_total_kas, sumtotal_bon ;    
    //console.log('testtest');

    vval_100i =  parseInt($( "#vval_100" ).val());
    vval_50i =  parseInt($( "#vval_50" ).val());
    vval_20i =  parseInt($( "#vval_20" ).val());
    vval_10i =  parseInt($( "#vval_10" ).val());
    vval_5i =  parseInt($( "#vval_5" ).val());
    vval_2i =  parseInt($( "#vval_2" ).val());  
    vval_1i =  parseInt($( "#vval_1" ).val());

    vl_1000i =  parseInt($( "#vl_1000" ).val());
    vl_500i =  parseInt($( "#vl_500" ).val());
    vl_200i =  parseInt($( "#vl_200" ).val());
    vl_100i =  parseInt($( "#vl_100" ).val());

    v100n =  parseInt($( "#v100n" ).val());
    v50n =  parseInt($( "#v50n" ).val());
    v20n =  parseInt($( "#v20n" ).val());
    v10n =  parseInt($( "#v10n" ).val());
    v5n =  parseInt($( "#v5n" ).val());
    v2n =  parseInt($( "#v2n" ).val());
    v1n =  parseInt($( "#v1n" ).val());

    vl1000n =  parseInt($( "#v1n" ).val());
    vl500n =  parseInt($( "#vl500n" ).val());
    vl200n =  parseInt($( "#vl200n" ).val());
    vl100n =  parseInt($( "#vl100n" ).val());

    vval_total_bon = parseInt($( "#v_total_bon" ).val());
    vv_total_kas = parseInt($( "#v_total_kas" ).val());
    

    //console.log(v100n);


    // operator = $( ".operator" ).html();     
    sum100 = (vval_100i / v100n);
    sum50 = (vval_50i / v50n);
    sum20 = (vval_20i / v20n);
    sum10 = (vval_10i / v10n);
    sum5 = (vval_5i / v5n);
    sum2 = (vval_2i / v2n);
    sum1 = (vval_1i / v1n);
    sumtotal_k = (vval_100i + vval_50i + vval_20i + vval_10i + vval_5i + vval_2i + vval_1i);

    suml1000 = (vl_1000i / vl1000n);
    suml500 = (vl_500i / vl500n);
    suml200 = (vl_200i / vl200n);
    suml100 = (vl_100i / vl100n);
    sumtotal_l = (vl_1000i + vl_500i + vl_200i + vl_100i);

    sum_total = (sumtotal_k + sumtotal_l);

    sum_bon_fisik = (sum_total + vval_total_bon);
    sumtotal_bon = (sum_bon_fisik - vv_total_kas);
        
     $( "#vn_100" ).val(sum100);
     $( "#vn_50" ).val(sum50);
     $( "#vn_20" ).val(sum20);
     $( "#vn_10" ).val(sum10);
     $( "#vn_5" ).val(sum5);
     $( "#vn_2" ).val(sum2);
     $( "#vn_1" ).val(sum1);

     $( "#vnL_1000" ).val(suml1000);
     $( "#vnL_500" ).val(suml500);
     $( "#vnL_200" ).val(suml200);
     $( "#vnL_100" ).val(suml100);

     $("#vtotal_k").val(sumtotal_k);
     $("#vtotal_l").val(sumtotal_l);
     $("#v_total_stok").val(sum_total);

     $("#v_bon_fisik").val(sum_bon_fisik);
     $("#v_selisih").val(sumtotal_bon);         
     
}

/** Kumpulan Fungsi Read Records **/

/**
get saldo Kas Operasional Hari ini dan set ke #v_total_kas valuenya
**/
function getSaldoKasOperasional() {    
    var from_date = $('#from_date').val();
    var gbagian = $("#vbagian").val();    
    gbagian = gbagian.trim();
      if(from_date != '')
      {
        $.post("../php/include/do_stok_kas_get_saldo_KO.php", 
        {
          pfrom_date:from_date,
          pbagian: gbagian
        }, function (data, status) {
          $("#v_total_kas").val(data);
          sums();
        });
      }else
      {
        alert("Please Select Date");
      }
}

function getBonGantung() {    
    var from_date = $('#from_date').val();
    var gbagian = $("#vbagian").val();    
    gbagian = gbagian.trim();
      if(from_date != '')
      {
        $.post("../php/include/do_stok_kas_get_bon_gantung.php", 
        {
          pfrom_date:from_date,
          pbagian: gbagian
        }, function (data, status) {
          $("#v_total_bon").val(data);
          sums();
        });
      }else
      {
        alert("Please Select Date");
      }
}

/**Read tabel saldo_kas, 
 jika ada data closing di hari ini,
 maka disable tombol Closing **/
function readSaldoKasClosing() {
var from_date = $('#from_date').val();
var gbagian = $("#vbagian").val();
if(from_date != '')
{
  $.post("../php/include/do_saldo_kas_closing_read.php", 
  {
    pfrom_date:from_date,
    pbagian: gbagian
  }, function (data, status) {
  //Parse JSON data
  var kas = JSON.parse(data);
    if (kas == false){
      //enable button Closing
      $("#btnClosing").prop("disabled", false);
      /**
      Cek saldo closing hari ini dulu, kalau tidak ada muncul kan error warning
      **/
      $(".messageError").html("<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">\
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\
      <span aria-hidden=\"true\">&times;</span>\
      </button>\
      <strong>Error :</strong> Tanggal "+from_date+" Belum Closing !!!</div>");
    }else{
      //disable button Closing, jika ada data Closing hari terpilih
      $("#vid_saldo_kas").val(kas.id_saldo_kas);
      $("#btnClosing").prop("disabled", true);
      $(".messageError").html("<div class=\"alert alert-success alert-dismissible\" role=\"alert\">\
      <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\
      <span aria-hidden=\"true\">&times;</span>\
      </button>\
      <strong>Informasi :</strong> Tanggal "+from_date+" Sudah Closing...</div>");
    }
  });
}else
{
alert("Please Select Date");
}
}

//read last closing
function readLastClosing() {
    var from_date = $('#from_date').val();
    var gbagian = $("#vbagian").val();    
    gbagian = gbagian.trim();
        $.post("../php/include/do_saldo_kas_last_closing_read.php", 
        {
          pbagian: gbagian,
          pfrom_date: from_date
        }, function (data, status) {
          //Parse JSON data
          var kas = JSON.parse(data);
          $(".messageInfo").html("<div class=\"alert alert-info alert-dismissible\" role=\"alert\">\
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\
                     <span aria-hidden=\"true\">&times;</span>\
                    </button>\
                    <strong>Closing Sebelumnya Tanggal :</strong> "+kas.tggl_periode+"</div>");
        });
}

function readRecords() {
    var from_date = $('#from_date').val();
    var gbagian = $("#vbagian").val();    
    gbagian = gbagian.trim();
      if(from_date != '')
      {
        $.post("../php/include/do_stok_kas_read.php", 
        {
          pfrom_date:from_date,
          pbagian: gbagian
        }, function (data, status) {
          //Parse JSON data
          var kas = JSON.parse(data);
          /**
          Jika tidak ada data stok kas harian di tabel stok_kas
          **/
          if (kas == false){
          $("#vval_100").val("0");
          $("#vval_50").val("0");
          $("#vval_20").val("0");
          $("#vval_10").val("0");
          $("#vval_5").val("0");
          $("#vval_2").val("0");
          $("#vval_1").val("0");
          $("#vl_1000").val("0");
          $("#vl_500").val("0");
          $("#vl_200").val("0");
          $("#vl_100").val("0");
          $("#vketerangan").val("");
          $("#label_kas").html("Stok Kas Operasional PUSAT "+from_date);
          //enable button Simpan
          //$("#ssaldoawal").prop("disabled", false);
          /**cek data closing di table saldo_kas, 
          jika ada maka disable button Closing**/
          readSaldoKasClosing();
          readLastClosing();
          // readSaldoKasClosingSebelum();
          //disable button Update
          $("#ssaldoawalupdate").prop("disabled", true);
          //disable button Cetak
          $("#printStok").prop("disabled", true);
          /**
          Get Saldo Operasional dan bon gantung Hari terpilih
          **/
          getSaldoKasOperasional();
          getBonGantung(); 
        }else{
          $("#vval_100").val(kas.kertas100);
          $("#vval_50").val(kas.kertas50);
          $("#vval_20").val(kas.kertas20);
          $("#vval_10").val(kas.kertas10);
          $("#vval_5").val(kas.kertas5);
          $("#vval_2").val(kas.kertas2);
          $("#vval_1").val(kas.kertas1);
          $("#vl_1000").val(kas.logam1000);
          $("#vl_500").val(kas.logam500);
          $("#vl_200").val(kas.logam200);
          $("#vl_100").val(kas.logam100);
          $("#vketerangan").val(kas.keterangan);
          $("#label_kas").html("Stok Kas Operasional PUSAT "+from_date);
          //disable button Simpan
          //$("#ssaldoawal").prop("disabled", true);
          /**cek data closing di table saldo_kas, 
          jika ada maka disable button Closing**/
          readSaldoKasClosing();
          readLastClosing();
          // readSaldoKasClosingSebelum();
          //enable button Update
          $("#ssaldoawalupdate").prop("disabled", false);
          //enable button Print
          $("#printStok").prop("disabled", false);
          /**
          Get Saldo Operasional Hari terpilih
          **/
          getSaldoKasOperasional();
          getBonGantung();        
        }
        });
      }else
      {
        alert("Please Select Date");
      }
}

/** Kumpulan Fungsi Add Record **/
function closingHarian() {
/**
variable
bagian, saldo_akhir, tggl_periode, waktu_update, keterangan, user_kasir, status_saldo

catatan :
status_saldo di tabel saldo_kas (1 = closing, 2 = awal_periode)
**/
  var gstatus_saldo = 1;
  
  var gtotal_kas = $("#v_total_kas").val();
  gtotal_kas = gtotal_kas.trim();

  var gbagian = $("#vbagian").val();    
  gbagian = gbagian.trim();

/**
Tanggal terpilih.
**/
  var gfrom_date = $('#from_date').val();
  gfrom_date = gfrom_date.trim();

  var gdwaktu_tambah = $("#dwaktu_tambah").val();
  gdwaktu_tambah = gdwaktu_tambah.trim();

  var gketerangan = $("#vketerangan").val();
  gketerangan = gketerangan.trim();

  var guser_kasir = $("#vuser_kasir").val();
  guser_kasir = guser_kasir.trim();

  if (gketerangan == "") {
    alert("Keterangan Belum di isi !");
  }else{
    $.post("../php/include/do_stok_kas_closing.php", {
            ptotal_kas: gtotal_kas,
            pstatus_saldo: gstatus_saldo,
            pbagian: gbagian,
            pfrom_date: gfrom_date,
            pwaktu_tambah: gdwaktu_tambah,
            puser_kasir: guser_kasir,
            pketerangan: gketerangan          
        }, function (data, status) {

        });
    setStokKas();
  }
}


function setStokKas() {
    // get values
    var gkertas_100 = $("#vval_100").val();
    gkertas_100 = gkertas_100.trim();

    var gkertas_50  = $("#vval_50").val();
    gkertas_50 = gkertas_50.trim();
    
    var gkertas_20 = $("#vval_20").val();
    gkertas_20 = gkertas_20.trim();

    var gkertas_10  = $("#vval_10").val();
    gkertas_10 = gkertas_10.trim();

    var gkertas_5 = $("#vval_5").val();
    gkertas_5 = gkertas_5.trim();

    var gkertas_2  = $("#vval_2").val();
    gkertas_2 = gkertas_2.trim();

    var gkertas_1  = $("#vval_1").val();
    gkertas_1 = gkertas_1.trim();

    var glogam_1000 = $("#vl_1000").val();
    glogam_1000 = glogam_1000.trim();    

    var glogam_500 = $("#vl_500").val();
    glogam_500 = glogam_500.trim(); 

    var glogam_200 = $("#vl_200").val();
    glogam_200 = glogam_200.trim(); 

    var glogam_100 = $("#vl_100").val();
    glogam_100 = glogam_100.trim(); 

//========== Selain Kas Logam ==========//
    var gbagian  = $("#vbagian").val();    
    gbagian = gbagian.trim();

/**
Tanggal terpilih.
**/
  var gfrom_date = $('#from_date').val();
  gfrom_date = gfrom_date.trim();

  var gdwaktu_tambah = $("#dwaktu_tambah").val();
  gdwaktu_tambah = gdwaktu_tambah.trim();

    var guser_kasir = $("#vuser_kasir").val();
    guser_kasir = guser_kasir.trim();

    var gketerangan = $("#vketerangan").val();
    gketerangan = gketerangan.trim();
 
    if (gkertas_100 == "") {
        alert("Uang 100 Ribu Belum di isi!");
    }
    else if (gkertas_50 == "") {
        alert("Uang 50 Ribu Belum di isi");
    }
    else if (gkertas_20 == "") {
        alert("Uang 20 Ribu Belum di isi");
    }
    else if (gkertas_10 == "") {
        alert("Uang 10 Ribu Belum di isi");
    }
    else if (gkertas_5 == "") {
        alert("Uang 5 Ribu Belum di isi");
    }
    else if (gkertas_2 == "") {
        alert("Uang 2 Ribu Belum di isi");
    }
    else if (gkertas_1 == "") {
        alert("Uang Seribu Belum di isi");
    }
    else if (glogam_1000 == "") {
        alert("Uang Seribu Logam Belum di isi");
    }
    else if (glogam_500 == "") {
        alert("Uang 500 Logam Belum di isi");
    }
    else if (glogam_200 == "") {
        alert("Uang 200 Logam Belum di isi");
    }
    else if (glogam_100 == "") {
        alert("Uang 100 Logam Belum di isi");
    }
    else if (gketerangan == "") {
        alert("Keterangan Belum di isi");
    }                
    else {
        // Add record
        $.post("../php/include/do_stok_kas_create.php", {
            pkertas_100: gkertas_100,
            pkertas_50: gkertas_50,
            pkertas_20: gkertas_20,
            pkertas_10: gkertas_10,
            pkertas_5: gkertas_5,
            pkertas_2: gkertas_2,
            pkertas_1: gkertas_1,
            plogam_1000: glogam_1000,
            plogam_500: glogam_500,
            plogam_200: glogam_200,
            plogam_100: glogam_100,
            pbagian: gbagian,
            ptggl_kas: gfrom_date,
            pwaktu_tambah: gdwaktu_tambah,
            puser_kasir: guser_kasir,
            pketerangan: gketerangan          
        }, function (data, status) {
            // read records again
            readRecords();
        });
    }
}

function setSaldoKasUpdate() {
    // get values
  var gid_saldo_kas = $("#vid_saldo_kas").val();
    var gkertas_100 = $("#vval_100").val();
    gkertas_100 = gkertas_100.trim();

    var gkertas_50  = $("#vval_50").val();
    gkertas_50 = gkertas_50.trim();
    
    var gkertas_20 = $("#vval_20").val();
    gkertas_20 = gkertas_20.trim();

    var gkertas_10  = $("#vval_10").val();
    gkertas_10 = gkertas_10.trim();

    var gkertas_5 = $("#vval_5").val();
    gkertas_5 = gkertas_5.trim();

    var gkertas_2  = $("#vval_2").val();
    gkertas_2 = gkertas_2.trim();

    var gkertas_1  = $("#vval_1").val();
    gkertas_1 = gkertas_1.trim();

    var glogam_1000 = $("#vl_1000").val();
    glogam_1000 = glogam_1000.trim();    

    var glogam_500 = $("#vl_500").val();
    glogam_500 = glogam_500.trim(); 

    var glogam_200 = $("#vl_200").val();
    glogam_200 = glogam_200.trim(); 

    var glogam_100 = $("#vl_100").val();
    glogam_100 = glogam_100.trim(); 

//========== Selain Kas Logam ==========//
    var gbagian  = $("#vbagian").val();    
    gbagian = gbagian.trim();

/**
Tanggal terpilih.
**/
  var gfrom_date = $('#from_date').val();
  gfrom_date = gfrom_date.trim();

  var gdwaktu_tambah = $("#dwaktu_tambah").val();
  gdwaktu_tambah = gdwaktu_tambah.trim();

    var guser_kasir = $("#vuser_kasir").val();
    guser_kasir = guser_kasir.trim();

    var gketerangan = $("#vketerangan").val();
    gketerangan = gketerangan.trim();
 
    if (gkertas_100 == "") {
        alert("Uang 100 Ribu Belum di isi!");
    }
    else if (gkertas_50 == "") {
        alert("Uang 50 Ribu Belum di isi");
    }
    else if (gkertas_20 == "") {
        alert("Uang 20 Ribu Belum di isi");
    }
    else if (gkertas_10 == "") {
        alert("Uang 10 Ribu Belum di isi");
    }
    else if (gkertas_5 == "") {
        alert("Uang 5 Ribu Belum di isi");
    }
    else if (gkertas_2 == "") {
        alert("Uang 2 Ribu Belum di isi");
    }
    else if (gkertas_1 == "") {
        alert("Uang Seribu Belum di isi");
    }
    else if (glogam_1000 == "") {
        alert("Uang Seribu Logam Belum di isi");
    }
    else if (glogam_500 == "") {
        alert("Uang 500 Logam Belum di isi");
    }
    else if (glogam_200 == "") {
        alert("Uang 200 Logam Belum di isi");
    }
    else if (glogam_100 == "") {
        alert("Uang 100 Logam Belum di isi");
    }
    else if (gketerangan == "") {
        alert("Keterangan Belum di isi");
    }                
    else {
        // Add record
        $.post("../php/include/do_stok_kas_update.php", {
            pid_saldo_kas: gid_saldo_kas,
            pkertas_100: gkertas_100,
            pkertas_50: gkertas_50,
            pkertas_20: gkertas_20,
            pkertas_10: gkertas_10,
            pkertas_5: gkertas_5,
            pkertas_2: gkertas_2,
            pkertas_1: gkertas_1,
            plogam_1000: glogam_1000,
            plogam_500: glogam_500,
            plogam_200: glogam_200,
            plogam_100: glogam_100,
            pbagian: gbagian,
            ptggl_kas: gfrom_date,
            pwaktu_tambah: gdwaktu_tambah,
            puser_kasir: guser_kasir,
            pketerangan: gketerangan          
        }, function (data, status) {
            // read records again
            readRecords();
        });
    }
}

/**
Fungsi print record ke bentuk PDF
 **/
function printStokKas() {
    // get values
    var gkertas_100 = $("#vval_100").val();
    gkertas_100 = gkertas_100.trim();

    var gkertas_50  = $("#vval_50").val();
    gkertas_50 = gkertas_50.trim();
    
    var gkertas_20 = $("#vval_20").val();
    gkertas_20 = gkertas_20.trim();

    var gkertas_10  = $("#vval_10").val();
    gkertas_10 = gkertas_10.trim();

    var gkertas_5 = $("#vval_5").val();
    gkertas_5 = gkertas_5.trim();

    var gkertas_2  = $("#vval_2").val();
    gkertas_2 = gkertas_2.trim();

    var gkertas_1  = $("#vval_1").val();
    gkertas_1 = gkertas_1.trim();

    var glogam_1000 = $("#vl_1000").val();
    glogam_1000 = glogam_1000.trim();    

    var glogam_500 = $("#vl_500").val();
    glogam_500 = glogam_500.trim(); 

    var glogam_200 = $("#vl_200").val();
    glogam_200 = glogam_200.trim(); 

    var glogam_100 = $("#vl_100").val();
    glogam_100 = glogam_100.trim(); 

//========== Selain Kas Logam ==========//
    var gbagian  = $("#vbagian").val();    
    gbagian = gbagian.trim();

    var gdtggl_kas = $("#dtggl_kas").val();
    gdtggl_kas = gdtggl_kas.trim();

    var gdwaktu_tambah = $("#dwaktu_tambah").val();
    gdwaktu_tambah = gdwaktu_tambah.trim();

    var guser_kasir = $("#vuser_kasir").val();
    guser_kasir = guser_kasir.trim();

    var from_date = $('#from_date').val();

     var gvn_100 = $( "#vn_100" ).val();
     gvn_100 = gvn_100.trim();

     var gvn_50 = $( "#vn_50" ).val();
     gvn_50 = gvn_50.trim();

     var gvn_20 = $( "#vn_20" ).val();
     gvn_20 = gvn_20.trim();

     var gvn_10 = $( "#vn_10" ).val();
     gvn_10 = gvn_10.trim();

     var gvn_5 = $( "#vn_5" ).val();
     gvn_5 = gvn_5.trim();

     var gvn_2 = $( "#vn_2" ).val();
     gvn_2 = gvn_2.trim();

     var gvn_1 = $( "#vn_1" ).val();
     gvn_1 = gvn_1.trim();

     var gnL_1000 = $( "#vnL_1000" ).val();
     gnL_1000 = gnL_1000.trim();

     var gnL_500 = $( "#vnL_500" ).val();
     gnL_500 = gnL_500.trim();

     var gnL_200 = $( "#vnL_200" ).val();
     gnL_200 = gnL_200.trim();

     var gnL_100 = $( "#vnL_100" ).val();
     gnL_100 = gnL_100.trim();

     var gtotal_k = $("#vtotal_k").val();
     gtotal_k = gtotal_k.trim();

     var gtotal_l = $("#vtotal_l").val();
     gtotal_l = gtotal_l.trim();

     var gtotal_stok = $("#v_total_stok").val();
     gtotal_stok = gtotal_stok.trim();

     var gtotal_bon = $("#v_total_bon").val();
     gtotal_bon = gtotal_bon.trim();

     var gbon_fisik = $("#v_bon_fisik").val();
     gbon_fisik = gbon_fisik.trim();

     var gtotal_kas = $("#v_total_kas").val();
     gtotal_kas = gtotal_kas.trim();

     var gselisih = $("#v_selisih").val();
     gselisih = gselisih.trim();

     var guser_kasir = $("#vuser_kasir").val();
     guser_kasir = guser_kasir.trim();

      if(from_date != '')
      {
        $.post("../php/include/do_stok_kas_print.php", 
        {
            pkertas_100: gkertas_100,
            pkertas_50: gkertas_50,
            pkertas_20: gkertas_20,
            pkertas_10: gkertas_10,
            pkertas_5: gkertas_5,
            pkertas_2: gkertas_2,
            pkertas_1: gkertas_1,
            plogam_1000: glogam_1000,
            plogam_500: glogam_500,
            plogam_200: glogam_200,
            plogam_100: glogam_100,
            pbagian: gbagian,
            ptggl_kas: gdtggl_kas,
            pwaktu_tambah: gdwaktu_tambah,
            puser_kasir: guser_kasir,
            pfrom_date: from_date,
            pvn_100: gvn_100,
            pvn_50: gvn_50,
            pvn_20: gvn_20,
            pvn_10: gvn_10,
            pvn_5: gvn_5,
            pvn_2: gvn_2,
            pvn_1: gvn_1,
            pnL_1000: gnL_1000,
            pnL_500: gnL_500,
            pnL_200: gnL_200,
            pnL_100: gnL_100,
            ptotal_k: gtotal_k,
            ptotal_l: gtotal_l,
            ptotal_stok: gtotal_stok,
            ptotal_bon: gtotal_bon,
            pbon_fisik: gbon_fisik,
            ptotal_kas: gtotal_kas,
            pselisih: gselisih,
            puser_kasir: guser_kasir
        }, function (data, status) {
        $("#printModal").modal('show');
        $(".modalPrintBody").html(data);
        });
      }else
      {
        alert("Please Select Date");
      }
}

/**
Jika halaman web sudah berhasil di load
**/
$(document).ready(function() {
  var vval_100, vval_50, vval_20, vval_10, vval_5, vval_2, vval_1,
      vl_1000, vl_500, vl_200, vl_100, v_total_bon;

/**>>>>>>>>> MULAI PENGECEKAN EVENT OnKeyUp <<<<<<<<<<<<**/
  $( "#vval_100" ).keyup(function() {
    vval_100 = $( "#vval_100" ).val();            
    if(vval_100.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });

  $( "#vval_50" ).keyup(function() {
    vval_50 = $( "#vval_50" ).val();            
    if(vval_50.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });

  $( "#vval_20" ).keyup(function() {
    vval_20 = $( "#vval_20" ).val();            
    if(vval_20.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });

  $( "#vval_10" ).keyup(function() {
    vval_10 = $( "#vval_10" ).val();            
    if(vval_10.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });  
  
  $( "#vval_5" ).keyup(function() {
    vval_5 = $( "#vval_5" ).val();            
    if(vval_5.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });

  $( "#vval_2" ).keyup(function() {
    vval_2 = $( "#vval_2" ).val();            
    if(vval_2.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });  

  $( "#vval_1" ).keyup(function() {
    vval_1 = $( "#vval_1" ).val();            
    if(vval_1.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });

  $( "#vl_1000" ).keyup(function() {
    vl_1000 = $( "#vl_1000" ).val();            
    if(vl_1000.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });  

  $( "#vl_500" ).keyup(function() {
    vl_500 = $( "#vl_500" ).val();            
    if(vl_500.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });  

  $( "#vl_200" ).keyup(function() {
    vl_200 = $( "#vl_200" ).val();            
    if(vl_200.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });  

  $( "#vl_100" ).keyup(function() {
    vl_100 = $( "#vl_100" ).val();            
    if(vl_100.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });

  $( "#v_total_bon" ).keyup(function() {
    v_total_bon = $( "#v_total_bon" ).val();            
    if(v_total_bon.match(/^\d+$/)){
      $('.messageError').html('');
      sums();           
    }else{
      $('.messageError').html('sorry number only for the first value');           
    }         
  });                

//>>>>>>>> END CHECK Event OnKeyUp <<<<<<<<<< 
/**
Jalankan fungsi baca record...
**/
readRecords();
});