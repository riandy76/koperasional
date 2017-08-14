<?php
session_start();
require '../../config/lib.php';
require '../../config/fungsi.php';
require '../../assets/library/fpdf/mc_table_ko.php';

//Data Dari Mysql
$object = new CRUD();
$obj_user = new AturLogin();
$vbagian = $_POST['pbagian'];
$vtggl_kas = $_POST['pfrom_date'];
$saldoawal = 0;
$saldoakhir = 0;

    /**
    Untuk tamplikan nama user, awali dengan session_start()
    **/
    $user = $obj_user->UserDetails($_SESSION['user_id']);
    $vuser_kasir = $user->nama;

#get tanggal sebelum, karena closing membaca ke hari sebelumnya.
$vtggl_sebelum = date('Y-m-d', strtotime($vtggl_kas.' -1 day'));

$timezone = "Asia/Makassar";
date_default_timezone_set($timezone);
// $today = date("Y-m-d");
$vtanggal2 = date("Y-m-d H:i:s");
$vtgl = date("Y-m-d_H-i-s");
// $vtanggal = tanggal_indo($today);


$getKasKeluar = $object->getKasKeluar($vbagian, $vtggl_kas);
$getKasMasuk = $object->getKasMasuk($vbagian, $vtggl_kas);

/**
Ambil data dari tabel saldo_kas
dengan status_saldo = 1 (status nya closing)
**/
// $getSaldoHariSebelum = $object->getSaldoHariSebelum($vbagian, $vtggl_sebelum);
// if (count($getSaldoHariSebelum) > 0) {
//     foreach ($getSaldoHariSebelum as $d) {
//         $saldoawal = $d['saldo_akhir'];
//     }
// }

$kasKeluar_belum_closing = json_decode($object->getKasKeluar_belumClosing($vbagian, $vtggl_kas), true);
// echo 'Kas Keluar : '.$kasKeluar_belum_closing['jumlah'];

$kasMasuk_belum_closing = json_decode($object->getKasMasuk_belumClosing($vbagian, $vtggl_kas), true);
// echo ' Kas Masuk : '.$kasMasuk_belum_closing['jumlah'];
//echo (10+3) - 3;
/**
Ambil data saldo akhir hari sebelum dari tabel saldo_kas
dengan status_saldo = 1 (status nya closing)
di hari sebelum, seperti laporan di file excel nya.
**/
$getSaldoKas = json_decode($object->getSaldoKasClosing($vbagian, $vtggl_sebelum), true);
$getLastClosing = json_decode($object->getLastClosing($vbagian, $vtggl_kas), true);

if (!empty($getSaldoKas['saldo_akhir'])) {
    # code...
    $saldoawal = ($getSaldoKas['saldo_akhir'] + $kasMasuk_belum_closing['jumlah']) - $kasKeluar_belum_closing['jumlah'];
    //echo 'ini kondisi pertama';   
}
elseif (!empty($getLastClosing['saldo_akhir'])) {
    # code...
    $saldoawal = ($getLastClosing['saldo_akhir'] + $kasMasuk_belum_closing['jumlah']) - $kasKeluar_belum_closing['jumlah'];
    //echo 'ini kondisi kedua';
}
/**
ambil data debet sesuai tanggal dari tabel kas_masuk
ambil data kredit sesuai tanggal dari tabel kas_keluar
**/
$getDebetKredit = $object->getDebetKredit($vbagian, $vtggl_kas);
if (count($getDebetKredit) > 0) {
    foreach ($getDebetKredit as $d) {
        $saldoakhir = ($saldoawal + $d['totalDebet']) - $d['totalKredit'];
        $vtotalKredit = $d['totalKredit'];
        $vtotalDebet = $saldoawal + $d['totalDebet'];
       // $vtotalAkhir = $vtotalDebet - $vtotalKredit;
    }
}

/******************************
Instanciation of inherited class
array(widht, height)
default FPDF('P','mm',A4)
*******************************/
$pdf = new PDF('L', 'mm', 'A4');
$judul = 'LAPORAN KAS OPERASIONAL ' .$vbagian.'';
$alamat = 'Jl. Jenderal A.Yani KM.02 RT.16 No.14 Telp.(0511) 3270948 Fax.(0511) 3270949 Banjarmasin';
$pdf->SetTitle($judul);
$pdf->SetAuthor('Riandy Fedrianto');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',12);
$pdf->SetFillColor(65, 150, 250);
$pdf->Ln(2);

#Membuat tabel dari sini*******************#
$pdf->Cell(34,6,'No Bukti Kas',1,0,'C',true);
$pdf->Cell(30,6,'Penerima',1,0,'C',true);
$pdf->Cell(100,6,'Keterangan',1,0,'C',true);
$pdf->Cell(30,6,'Jumlah',1,0,'C',true);
$pdf->Cell(30,6,'Debet',1,0,'C',true);
$pdf->Cell(30,6,'Kredit',1,0,'C',true);
$pdf->Cell(30,6,'Saldo',1,0,'C',true);
$pdf->Ln();

#Atur lebar kolom data nya************************
$pdf->SetWidths(array(34,30,100,30,30,30,30));

#Saldo Awal
$pdf->Cell(194,6,'Saldo Awal',1,0,'C');
$pdf->Cell(30,6, format_rupiah($saldoawal),1,0,'C');
$pdf->Cell(30,6,'',1,0,'C');
$pdf->Cell(30,6, format_rupiah($saldoawal),1,0,'C');
$pdf->Ln(6);
#Saldo Awal

/*******************************
Menampilkan data dari table MySQL
********************************/
$pdf->SetFont('Times','',10);
$pdf->SetFillColor(200, 220, 200);
$fill = false;

if (count($getKasMasuk) > 0) 
{
    foreach ($getKasMasuk as $d) 
    {
        $pdf->Row(array($d['no_bukti_kas'],$d['namaPengguna'], $d['keterangan'],
            format_rupiah($d['jumlah']),format_rupiah($d['jumlah']), '', ''));        
        $fill = !$fill;
    }
}else{
    $pdf->SetFillColor(247, 64, 64);
    $pdf->Cell(283, 6, 'Tidak ada data kas masuk', 'LRB', 0, 'L', true);
    $pdf->Ln();
}

if (count($getKasKeluar) > 0) 
{
    foreach ($getKasKeluar as $d) 
    {
        $pdf->Row(array($d['no_bukti_kas'],$d['namaPengguna'], $d['keterangan'],
            format_rupiah($d['jumlah']), '', format_rupiah($d['jumlah']), ''));        
        $fill = !$fill;
    }
}else{
    $pdf->SetFillColor(247, 64, 64);
    $pdf->Cell(283, 6, 'Tidak ada data kas keluar', 'LRB', 0, 'L');   
    $pdf->Ln();
}
$pdf->SetFillColor(197, 221, 216);
$pdf->Cell(194,6, 'Total',1,0,'C',true);
$pdf->Cell(30,6, format_rupiah($vtotalDebet),1,0);
$pdf->Cell(30,6, format_rupiah($vtotalKredit),1,0);
$pdf->Cell(30,6, format_rupiah($saldoakhir),1,0);
$pdf->Ln(6);

$pdf->Cell(194,6, 'Saldo Akhir',1,0,'C',true);
$pdf->Cell(30,6, format_rupiah($saldoakhir),1,0);

$pdf->Ln(20);

$pdf->Cell(250);
$pdf->Cell(30,6,'Dibuat', 'C');
$pdf->Ln(15);
$pdf->Cell(250);
$pdf->Cell(30,6,'('.$vuser_kasir.')', 'C');

$pdf->Output('LaporanKasOperasional'.$vtgl.'.pdf', 'F');

$data = '<a class="mediaShow" href="include/LaporanKasOperasional'.$vtgl.'.pdf"></a>
 
<script type="text/javascript">
    $(function () {
        var x = screen.width;
        var y = screen.height;
        $(".mediaShow").media({
            width: x,
            height: y
        });
    });
</script>';

echo $data;

?>