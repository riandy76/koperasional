<?php
session_start();
require '../../config/lib.php';
require '../../config/fungsi.php';
// require '../../assets/library/fpdf/fpdf.php';
require '../../assets/library/fpdf/mc_table_bon.php';

//Data Dari Mysql
$object = new CRUD();

$gid = $_POST['pid'];
$dataBongantung = $object->DetailsBonGantungPrint($gid);

$app = new AturLogin();
$user = $app->UserDetails($_SESSION['user_id']);
        $timezone = "Asia/Makassar";
        date_default_timezone_set($timezone);
        $today = date("Y-m-d");
        $vtanggal2 = date("Y-m-d H:i:s");
        $vtgl = date("Y-m-d_H-i-s");
        $vtanggal = tanggal_indo($today);
// $pdf->SetFillColor(245, 222, 179); //warna dalam kolom data
// $pdf->SetTextColor(0); //warna tulisan hitam
// $pdf->SetFont('Times','',12);
/**
tabel bon_gantung
id int 11
tggl_bon date
waktu_bon datetime
penerima varchar 20
keterangan text
jumlah int 11
tggl_bayar datetime
bagian char 6
status_bon int 1
user_kasir varchar 20
**/
if (count($dataBongantung) > 0)
$number = 1; 
{
    foreach ($dataBongantung as $d) {

        $number;
        $vtggl_bon = $d['tggl_bon'];
        $vtggl_bayar = $d['tggl_bayar'];
        $vwaktu_bon = $d['waktu_bon'];
        $vpenerima = $d['namaPengguna'];
        $vketerangan = $d['keterangan'];
        $vjumlah = $d['jumlah'];
        //$vuser_kasir = $d['user_kasir'];
        $vbagian = $d['bagian'];
        //$vtanggal2 = tanggal_indo($today2);
    }
}

// Instanciation of inherited class
//array(widht, height)
//default FPDF('P','mm',A4)
$pdf = new PDF('L','mm',array(215.9,139.7));
$judul = 'BUKTI BON GANTUNG';
$pdf->SetTitle($judul);
$pdf->SetAuthor('Riandy Fedrianto');
$pdf->AliasNbPages();
$pdf->AddPage();

// $pdf->SetFillColor(47, 79, 79);
// $pdf->SetTextColor(255);
// $pdf->SetDrawColor(225, 180, 135);
$pdf->SetFont('Times','',12);
//$pdf->Ln(5);

// $pdf->SetX(140);
// $pdf->Cell(30,6,'No. Kas : ', 1);
// $pdf->Cell(40, 6, $d['no_bukti_kas'], 1, 1);
// $pdf->SetX(140);
// $pdf->Cell(30,6,'Tanggal', 1);
// $pdf->Cell(40, 6, $vtanggal, 1, 1);

//data    

$pdf->Cell(40,6,'Dibayarkan Kepada  : ');
$pdf->Cell(30, 6, $vpenerima, 0, 1);
$pdf->Cell(40,6,'Sejumlah (Rp.)         : ');
$pdf->Cell(30, 6, format_rupiah($vjumlah), 0, 1);
$pdf->Ln(10);

//tabel isi data
$pdf->Cell(10,6,'No',1,0,'C');
$pdf->Cell(150,6,'Keterangan',1,0,'C');
$pdf->Cell(40,6,'Jumlah (Rp.)',1,1,'C');

//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10,150,40));
$pdf->Row(array($number,$vketerangan,format_rupiah($vjumlah)));

//$pdf->SetX(30);
// $pdf->Cell(10, 6, $number, 1);
//$pdf->MultiCell(150, 6, $vketerangan, 1);
// $pdf->Cell(150, 6, $vketerangan, 1);
// $pdf->Cell(40, 6, format_rupiah($vjumlah), 1, 1);

// $pdf->SetX(140);
// $pdf->Cell(30,6,'Total',1,0,'C');
// $pdf->Cell(40, 6, format_rupiah($vjumlah), 1, 1);
// $pdf->Ln(20);
$pdf->SetX(140);
$pdf->Cell(30,6,'Total',1,0,'C');

$pdf->Cell(40, 6, format_rupiah($vjumlah), 1, 1);

// $pdf->SetY(97);
$pdf->Ln(20);

$pdf->Cell(30,6,'Diterima', 'C');
$pdf->SetX(60);
$pdf->Cell(30,6,'Diperiksa', 'C');
$pdf->SetX(120);
$pdf->Cell(30,6,'Diketahui', 'C');
$pdf->SetX(180);
$pdf->Cell(30,6,'Dibuat', 0, 1, 'C');
$pdf->Ln(10);

$pdf->Cell(30,6,'...............', 'C');
$pdf->SetX(60);
$pdf->Cell(30,6,'...............', 'C');
$pdf->SetX(120);
$pdf->Cell(30,6,'...............', 'C');
$pdf->SetX(180);
$pdf->Cell(30,6,'('.$user->nama.')', 'C');

$pdf->Output('LaporanBuktiBonGantung'.$vtgl.'.pdf', 'F');

$data = '<a class="mediaShow" href="include/LaporanBuktiBonGantung'.$vtgl.'.pdf"></a>
 
<script type="text/javascript">
    $(function () {
        $(".mediaShow").media({width: 868});
    });
</script>';

echo $data;

?>