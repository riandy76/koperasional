<?php
session_start();
require '../../config/lib.php';
require '../../config/fungsi.php';
// require '../../assets/library/fpdf/fpdf.php';
require '../../assets/library/fpdf/mc_table.php';

//Data Dari Mysql
$object = new CRUD();

$gid = $_POST['pid'];
$getKasMasuk = $object->DetailsKasMasukPrint($gid);

$app = new AturLogin();
$user = $app->UserDetails($_SESSION['user_id']);

        $timezone = "Asia/Makassar";
        date_default_timezone_set($timezone);
        $today = date("Y-m-d");
        $vtanggal2 = date("Y-m-d H:i:s");
        $vtanggal = tanggal_indo($today);
        $vtgl = date("Y-m-d_H-i-s");

if (count($getKasMasuk) > 0)
$number = 1; 
{
    foreach ($getKasMasuk as $d) {

        $number;
        $vno_bukti_kas = $d['no_bukti_kas'];
        $vtggl_kas = $d['tggl_kas'];
        $vpenerima = $d['namaPengguna'];
        $vketerangan = $d['keterangan'];
        $vjumlah = $d['jumlah'];
        //$vuser_kasir = $d['user_kasir'];
        //$vtanggal2 = tanggal_indo($today2);
    }
}

// Instanciation of inherited class
//array(widht, height)
//default FPDF('P','mm',A4)
$pdf = new PDF('L','mm',array(215.9,139.7));
$judul = 'BUKTI KAS MASUK';
$pdf->SetTitle($judul);
$pdf->SetAuthor('Riandy Fedrianto');
$pdf->AliasNbPages();
$pdf->AddPage();

// $pdf->SetFillColor(47, 79, 79);
// $pdf->SetTextColor(255);
// $pdf->SetDrawColor(225, 180, 135);
$pdf->SetFont('Times','',12);
//$pdf->Ln(5);

//data    

$pdf->Cell(40,6,'Diterima dari  : ');
$pdf->Cell(30, 6, $vpenerima, 0, 1);
$pdf->Cell(40,6,'Sejumlah (Rp.) : ');
$pdf->Cell(30, 6, format_rupiah($vjumlah), 0, 1);
$pdf->Ln();

//tabel isi data
$pdf->Cell(10,6,'No',1,0,'C');
$pdf->Cell(150,6,'Keterangan',1,0,'C');
$pdf->Cell(40,6,'Jumlah (Rp.)',1,1,'C');

//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10,150,40));
$pdf->Row(array($number,$vketerangan,format_rupiah($vjumlah)));

$pdf->SetX(140);
$pdf->Cell(30,6,'Total',1,0,'C');

$pdf->Cell(40, 6, format_rupiah($vjumlah), 1, 1);

// $pdf->SetY(97);
$pdf->Ln(20);

$pdf->Cell(30,6,'Yang menyerahkan', 'C');
$pdf->SetX(60);
$pdf->Cell(30,6,'Diperiksa', 'C');
$pdf->SetX(120);
$pdf->Cell(30,6,'Diketahui', 'C');
$pdf->SetX(175);
$pdf->Cell(30,6,'Dibuat', 0, 1, 'C');
$pdf->Ln(10);
// $pdf->SetY(-15);

$pdf->Cell(30,6,'..............................', 'C');
$pdf->SetX(60);
$pdf->Cell(30,6,'...............', 'C');
$pdf->SetX(120);
$pdf->Cell(30,6,'...............', 'C');
$pdf->SetX(180);
$pdf->Cell(30,6,'('.$user->nama.')', 'C');
// $pdf->SetY(-15);

$pdf->Output('LaporanBuktiKasMasuk'.$vtgl.'.pdf', 'F');

$data = '<a class="mediaShow" href="include/LaporanBuktiKasMasuk'.$vtgl.'.pdf"></a>
 
<script type="text/javascript">
    $(function () {
        $(".mediaShow").media({width: 868});
    });
</script>';

echo $data;

?>