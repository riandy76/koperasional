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
$total = 0;
$vstatus_kas = 11;//uang muka
    /**
    Untuk tamplikan nama user, awali dengan session_start()
    **/
    $user = $obj_user->UserDetails($_SESSION['user_id']);
    $vuser_kasir = $user->nama;

$getUangMuka = $object->getUangMuka($vbagian, $vtggl_kas, $vstatus_kas);

#get tanggal sebelum, karena closing membaca ke hari sebelumnya.
//$vtggl_sebelum = date('Y-m-d', strtotime($vtggl_kas.' -1 day'));

$timezone = "Asia/Makassar";
date_default_timezone_set($timezone);
$vtanggal2 = date("Y-m-d H:i:s");
$vtgl = date("Y-m-d_H-i-s");

/******************************
Instanciation of inherited class
array(widht, height)
default FPDF('P','mm',A4)
*******************************/
$pdf = new PDF('L', 'mm', 'A4');
$judul = 'LAPORAN UANG MUKA KAS OPERASIONAL ' .$vbagian.'';
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
$pdf->Cell(30,6,'Tanggal',1,0,'C',true);
$pdf->Cell(30,6,'Penerima',1,0,'C',true);
$pdf->Cell(100,6,'Keterangan',1,0,'C',true);
$pdf->Cell(30,6,'Jumlah',1,0,'C',true);
$pdf->Ln();

#Atur lebar kolom data nya************************
$pdf->SetWidths(array(34,30,30,100,30));

/*******************************
Menampilkan data dari table MySQL
********************************/
$pdf->SetFont('Times','',10);
$pdf->SetFillColor(200, 220, 200);
$fill = false;

if (count($getUangMuka) > 0) 
{
    foreach ($getUangMuka as $d) 
    {
        $pdf->Row(array($d['no_bukti_kas'],$d['tggl_kas'], $d['namaPengguna'],
            $d['keterangan'], format_rupiah($d['jumlah'])));
        $total = $total + $d['jumlah'];      
        $fill = !$fill;
    }
}else{
    $pdf->SetFillColor(247, 64, 64);
    $pdf->Cell(224, 6, 'Tidak ada data ', 'LRB', 0, 'L', true);
    $pdf->Ln();
}

$pdf->SetFillColor(197, 221, 216);
$pdf->Cell(194,6, 'Total',1,0,'C',true);
$pdf->Cell(30,6, format_rupiah($total),1,0);
$pdf->Ln(20);

$pdf->SetX(215);
$pdf->Cell(30,6,'Dibuat', 'C');
$pdf->Ln(15);
$pdf->SetX(207);
$pdf->Cell(30,6,'('.$vuser_kasir.')', 'C');

$pdf->Output('LaporanUangMukaOperasional'.$vtgl.'.pdf', 'F');

$data = '<a class="mediaShow" href="include/LaporanUangMukaOperasional'.$vtgl.'.pdf"></a>
 
<script type="text/javascript">
    $(function () {
        var x = screen.width;
        var y = screen.height;
$(".mediaShow").media({width: 868});
    });
</script>';

echo $data;

?>