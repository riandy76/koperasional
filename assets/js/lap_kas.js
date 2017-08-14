/**
Fungsi Cetak Laporan Kas Harian
**/
function CetakBuktiKas(){
  var gbagian = $("#vbagian").val();    
  gbagian = gbagian.trim();
  var vtgglLaporan = $('#from_date').val();
  vtgglLaporan = vtgglLaporan.trim();
    $.post("../php/include/lap_kas_harian_print.php", 
        {
            ptgglLaporan: vtgglLaporan,
            pbagian: gbagian
        }, function (data, status) {
            $("#printModal").modal('show');
            $(".modalPrintBody").html(data);
        });
}