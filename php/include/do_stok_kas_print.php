<?php
session_start();
require '../../config/lib.php';
require '../../config/fungsi.php';
require '../../assets/library/fpdf/fpdf.php';

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        global $alamat, $judul;
    
    // Logo
        $this->Image('../../assets/images/logo.jpg',90,5,30);
        $this->Ln(4);
    // Arial bold 15
        $this->SetFont('Times','',10);        
        $w = $this->GetStringWidth($alamat)+6;
        $this->SetX((215-$w)/2);
        $this->Cell($w, 9, $alamat, 'C', true);
        $this->Ln(3);

        $this->SetFont('Times','B',14);    
    // Calculate width of title and position
        $w = $this->GetStringWidth($judul)+6;
        $this->SetX((215-$w)/2);
    // Colors of frame, background and text
        $this->SetDrawColor(10,30,120);
        $this->SetFillColor(135, 206, 235);
        $this->SetTextColor(255, 30, 30);
    // Thickness of frame (1 mm)
        $this->SetLineWidth(0.5);
    // Title    
        $this->Cell($w, 9, $judul, 'C', true);
    /**
    nomor kas
        $this->SetX(140);
        $this->SetFont('Times','',10);
        $this->Cell(20,6,'No. Kas : ', 1);
        $this->Cell(40, 6, $vno_bukti_kas, 1, 1);
        $this->SetX(140);
        $this->Cell(20,6,'Tanggal : ', 1);
        $this->Cell(40, 6, $vtanggal, 1, 1);
    //  Line break
    //  $this->Ln(2);
    **/
    }

    // Page footer
    function Footer()
    {
        global $vtggl_cetak;
    // Position at 1.5 cm from bottom
        $this->SetY(-15);
    // Arial italic 8
        $this->SetFont('Arial','I',8);
    // Page number
        $this->Cell(20,10,'Dicetak pada : ',0,0,'L');
        $this->Cell(25,10, $vtggl_cetak, 0, 0, 'L');
        $this->SetX(15);
        $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'C');
    }

}

/**
Kumpulan data yang akan dibuat untuk Laporan PDF
**/
  $timezone = "Asia/Makassar";
  date_default_timezone_set($timezone);
  $vtggl = date("Y-m-d");
  $vtggl_cetak = date("Y-m-d H:i:s");
  $vtgl = date("Y-m-d_H-i-s");

$app = new AturLogin();
$user = $app->UserDetails($_SESSION['user_id']);

$vkertas_100 = $_POST['pkertas_100'];
$vkertas_50 = $_POST['pkertas_50'];
$vkertas_20 = $_POST['pkertas_20'];
$vkertas_10 = $_POST['pkertas_10'];
$vkertas_5 = $_POST['pkertas_5'];
$vkertas_2 = $_POST['pkertas_2'];
$vkertas_1 = $_POST['pkertas_1'];
$vlogam_1000 = $_POST['plogam_1000'];
$vlogam_500 = $_POST['plogam_500'];
$vlogam_200 = $_POST['plogam_200'];
$vlogam_100 = $_POST['plogam_100'];

$vbagian = $_POST['pbagian'];
$vtggl_kas = $_POST['ptggl_kas'];
$vwaktu_tambah = $_POST['pwaktu_tambah'];
$vfrom_date = $_POST['pfrom_date'];

$v_vn_100 = $_POST['pvn_100'];
$v_vn_50 = $_POST['pvn_50'];
$v_vn_20 = $_POST['pvn_20'];
$v_vn_10 = $_POST['pvn_10'];
$v_vn_5 = $_POST['pvn_5'];
$v_vn_2 = $_POST['pvn_2'];
$v_vn_1 = $_POST['pvn_1'];

$v_vnL_1000 = $_POST['pnL_1000'];
$v_vnL_500 = $_POST['pnL_500'];
$v_vnL_200 = $_POST['pnL_200'];
$v_vnL_100 = $_POST['pnL_100'];

$vtotal_k = $_POST['ptotal_k'];
$vtotal_l = $_POST['ptotal_l'];
$vtotal_stok = $_POST['ptotal_stok'];
$vtotal_bon = $_POST['ptotal_bon'];
$vbon_fisik = $_POST['pbon_fisik'];
$vtotal_kas = $_POST['ptotal_kas'];
$vselisih = $_POST['pselisih'];
$vuser_kasir = $_POST['puser_kasir'];

/**
Instanciation of inherited class
array(widht, height)
default FPDF('P','mm',A4)
**/
// $pdf = new PDF('P','mm',array(215.9,139.7));
$pdf = new PDF('P', 'mm', 'A4');
$judul = 'STOK KAS HARIAN OPERASIONAL ' .$vbagian.'';
$alamat = 'Jl. Jenderal A.Yani KM.02 RT.16 No.14 Telp.(0511) 3270948 Fax.(0511) 3270949 Banjarmasin';
$pdf->SetTitle($judul);
$pdf->SetAuthor('Riandy Fedrianto');
$pdf->AliasNbPages();
$pdf->AddPage();

// $pdf->SetFillColor(47, 79, 79);
// $pdf->SetTextColor(255);
// $pdf->SetDrawColor(225, 180, 135);
$pdf->SetFont('Times','',12);
$pdf->Ln(3);

// $pdf->SetX(140);
// $pdf->Cell(30,6,'No. Kas : ', 1);
// $pdf->Cell(40, 6, $d['no_bukti_kas'], 1, 1);
// $pdf->SetX(140);
// $pdf->Cell(30,6,'Tanggal', 1);
// $pdf->Cell(40, 6, $vtanggal, 1, 1);

/**
data    

$pdf->Cell(40,6,'Uang Kertas  : ');
$pdf->Cell(30, 6, $vpenerima, 0, 1);
$pdf->Cell(40,6,'Sejumlah (Rp.)         : ');
$pdf->Cell(30, 6, format_rupiah($vjumlah), 0, 1);
$pdf->Ln(10);

**/
$pdf->Cell(30, 6, 'Uang Kertas    :');

$pdf->Cell(35, 6, 'Rp. 100.000,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vn_100 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vkertas_100) . '', 0, 1);
$pdf->SetX(40);

$pdf->Cell(35, 6, 'Rp. 50.000,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vn_50 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vkertas_50) . '', 0, 1);
$pdf->SetX(40);

$pdf->Cell(35, 6, 'Rp. 20.000,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vn_20 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vkertas_20) . '', 0, 1);
$pdf->SetX(40);

$pdf->Cell(35, 6, 'Rp. 10.000,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vn_10 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vkertas_10) . '', 0, 1);
$pdf->SetX(40);

$pdf->Cell(35, 6, 'Rp. 5.000,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vn_5 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vkertas_5) . '', 0, 1);
$pdf->SetX(40);

$pdf->Cell(35, 6, 'Rp. 2.000,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vn_2 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vkertas_2) . '', 0, 1);
$pdf->SetX(40);

$pdf->Cell(35, 6, 'Rp. 1.000,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vn_1 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vkertas_1) . '', 0, 1);

$pdf->SetX(85);
$pdf->Cell(15, 6, 'Total');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vtotal_k) . '', 0, 1);

/**
Uang Logam
**/
$pdf->Cell(30, 6, 'Uang Logam    :');

$pdf->Cell(35, 6, 'Rp. 1000,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vnL_1000 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vlogam_1000) . '', 0, 1);
$pdf->SetX(40);

$pdf->Cell(35, 6, 'Rp. 500,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vnL_500 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vlogam_500) . '', 0, 1);
$pdf->SetX(40);

$pdf->Cell(35, 6, 'Rp. 200,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vnL_200 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vlogam_200) . '', 0, 1);
$pdf->SetX(40);

$pdf->Cell(35, 6, 'Rp. 100,00');
$pdf->Cell(10, 6, 'x', 0, 0, 'C');
$pdf->Cell(15, 6, '' . $v_vnL_100 . '', 0, 0, 'C');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vlogam_100) . '', 0, 1);

$pdf->SetX(85);
$pdf->Cell(15, 6, 'Total');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vtotal_l) . '', 0, 1);

$pdf->SetX(36);
$pdf->Cell(64, 6, 'Total Uang Kertas + Uang Logam');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->SetTextColor(255, 30, 30);
$pdf->Cell(40, 6, '' . format_rupiah($vtotal_stok) . '', 0, 1);

$pdf->SetFont('Times','',12);
$pdf->SetTextColor(30, 30, 30);
$pdf->SetX(36);
$pdf->Cell(64, 6, 'Bon Gantung');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vtotal_bon) . '', 0, 1);

$pdf->SetX(36);
$pdf->Cell(64, 6, 'Total Uang Fisik & Bon Gantung');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vbon_fisik) . '', 0, 1);

$pdf->SetX(6);
$pdf->Cell(94, 6, 'Stok Kas Operasional '. $vbagian .' tanggal '. tanggal_indo($vfrom_date) .'');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vtotal_kas) . '', 0, 1);

$pdf->SetX(36);
$pdf->Cell(64, 6, 'Selisih Kurang ( ) / Lebih');
$pdf->Cell(10, 6, '=', 0, 0, 'C');
$pdf->Cell(40, 6, '' . format_rupiah($vselisih) . '', 0, 1);

$pdf->Ln(4);

$pdf->SetX(85);
$pdf->Cell(60, 6, 'Banjarmasin, ' .tanggal_indo($vfrom_date). '', 0, 1, 'C');
$pdf->SetX(100);
$pdf->Cell(30, 6, 'Diterima', 0, 0, 'C');
$pdf->Ln(15);
// $pdf->Cell(40, 6, 'Rp. ' . $vselisih . '', 0, 1);
$pdf->SetX(100);
$pdf->Cell(30,6,'('.$user->nama.')', 'C');

$pdf->Output('LaporanStokKasHarian'.$vtgl.'.pdf', 'F');

$data = '<a class="mediaShow" href="include/LaporanStokKasHarian'.$vtgl.'.pdf"></a>
 
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