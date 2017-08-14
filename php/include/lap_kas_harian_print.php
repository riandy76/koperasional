<?php
session_start();
require '../../config/lib.php';
require '../../config/fungsi.php';
require '../../assets/library/fpdf/mc_table_kas.php';
    $timezone = "Asia/Makassar";
    date_default_timezone_set($timezone);
    $vtanggal2 = date("Y-m-d H:i:s");
    $vbagian = $_POST['pbagian'];
    $vtgl = date("Y-m-d_H-i-s");

#Data Dari Mysql#
$object = new CRUD();
$obj_user = new AturLogin();

    $gtgglLaporan = $_POST['ptgglLaporan'];
    #dapat kan jumlah hari di tanggal pilihan
    $d = new DateTime($gtgglLaporan); 
    //echo $d->format( 't' );
    //$jumlahHari = date("t",strtotime($gtgglLaporan));
    $jumlahHari = $d->format('t');
    $data_LapKas = $object->LaporanKasHarianPrint($gtgglLaporan, $vbagian);
    //$data_LapKas2 = $object->LaporanKasHarianPrint($gtgglLaporan);
    /**
    Untuk tamplikan nama user, awali dengan session_start()
    **/
    $user = $obj_user->UserDetails($_SESSION['user_id']);
    $vuser_kasir = $user->nama;

/**
Kantor
Bonus
Gaji_Lembur
Dinas
BBM
PLN
PDAM
Internet
Telpon
Entertain
BudgetOperasional
Hutang
**/

if (count($data_LapKas) > 0){
    foreach ($data_LapKas as $d => $nilai) {
        $tgl_kas = date('j', strtotime($nilai['tggl_kas']));
        $ref_kas[$tgl_kas] = $d;
    }
}

/******************************
Instanciation of inherited class
array(widht, height)
default FPDF('P','mm',A4)
*******************************/
$pdf = new PDF('L', 'mm', 'A4');
$judul = 'LAPORAN BIAYA KAS OPERASIONAL ' .$vbagian.'';
$bulan = bulan($gtgglLaporan);
$alamat = 'Jl. Jenderal A.Yani KM.02 RT.16 No.14 Telp.(0511) 3270948 Fax.(0511) 3270949 Banjarmasin';
$pdf->SetTitle($judul);
$pdf->SetAuthor('Riandy Fedrianto');
$pdf->SetMargins(0, 10);
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',12);
$pdf->SetFillColor(65, 150, 250);
$pdf->Ln(2);

#Membuat tabel dari sini*******************#
$pdf->Cell(6,6,'Tgl',1,0,'C',true);
$pdf->Cell(20,6,'Kantor',1,0,'C',true);
$pdf->Cell(20,6,'Bonus',1,0,'C',true);
$pdf->Cell(26,6,'Gaji / Lembur',1,0,'C',true);
$pdf->Cell(20,6,'Dinas',1,0,'C',true);
$pdf->Cell(20,6,'BBM',1,0,'C',true);
$pdf->Cell(20,6,'PLN',1,0,'C',true);
$pdf->Cell(20,6,'PDAM',1,0,'C',true);
$pdf->Cell(20,6,'Internet',1,0,'C',true);
$pdf->Cell(20,6,'Telpon',1,0,'C',true);
$pdf->Cell(20,6,'Entertain',1,0,'C',true);
$pdf->Cell(20,6,'Hutang',1,0,'C',true);
$pdf->Cell(34,6,'Budget Operasional',1,0,'C',true);
$pdf->Cell(31,6,'Jumlah Biaya',1,0,'C',true);
$pdf->Ln();

// Atur lebar kolom nya************************
$pdf->SetWidths(array(6,20,20,26,20,20,20,20,20,20,20,34,31));

/*******************************
Menampilkan data dari table MySQL
********************************/
$pdf->SetFont('Times','',10);
$pdf->SetFillColor(200, 220, 200);
$fill = false;

// if (count($data_LapKas2) > 0){

// for ($i=1; $i <= $jumlahHari; $i++) { 
//     # code...
// $fill = !$fill;
// $pdf->Cell(6,6, $i ,1,1,'C',$fill);
// }

// }



#Cek apakah sudah ada data laporannya
$total_biaya = 0;

if (count($data_LapKas) > 0){

// for ($i=1; $i <= $jumlahHari; $i++) { 
//     # code...
// $fill = !$fill;
// $pdf->Cell(6,6, $i ,1,1,'C',$fill);
// }

for ($i=1; $i <= $jumlahHari; $i++) {       
        if (array_key_exists($i, $ref_kas))
            {
            $pdf->Cell(6,6, $i ,1,0,'C',$fill);
            $pdf->Cell(20,6, $data_LapKas[$ref_kas[$i]]['Kantor'] ,1,0,'C',$fill);
            $pdf->Cell(20,6,$data_LapKas[$ref_kas[$i]]['Bonus'],1,0,'C',$fill);
            $pdf->Cell(26,6,$data_LapKas[$ref_kas[$i]]['Gaji_Lembur'],1,0,'C',$fill);
            $pdf->Cell(20,6,$data_LapKas[$ref_kas[$i]]['Dinas'],1,0,'C',$fill);
            $pdf->Cell(20,6,$data_LapKas[$ref_kas[$i]]['BBM'],1,0,'C',$fill);
            $pdf->Cell(20,6,$data_LapKas[$ref_kas[$i]]['PLN'],1,0,'C',$fill);
            $pdf->Cell(20,6,$data_LapKas[$ref_kas[$i]]['PDAM'],1,0,'C',$fill);
            $pdf->Cell(20,6,$data_LapKas[$ref_kas[$i]]['Internet'],1,0,'C',$fill);
            $pdf->Cell(20,6,$data_LapKas[$ref_kas[$i]]['Telpon'],1,0,'C',$fill);
            $pdf->Cell(20,6,$data_LapKas[$ref_kas[$i]]['Entertain'],1,0,'C',$fill);
            $pdf->Cell(20,6,$data_LapKas[$ref_kas[$i]]['Hutang'],1,0,'C',$fill);
            $pdf->Cell(34,6,$data_LapKas[$ref_kas[$i]]['BudgetOperasional'],1,0,'C',$fill);
            $pdf->Cell(31,6,$data_LapKas[$ref_kas[$i]]['Jumlah'],1,0,'C',$fill);
            $total_biaya = $total_biaya + $data_LapKas[$ref_kas[$i]]['Jumlah'];
            $pdf->Ln();
            } 
            else
            {
$pdf->Cell(6,6, $i ,1,0,'C',$fill);               
$pdf->Cell(20,6,'0',1,0,'C',$fill);
$pdf->Cell(20,6,'0',1,0,'C',$fill);
$pdf->Cell(26,6,'0',1,0,'C',$fill);
$pdf->Cell(20,6,'0',1,0,'C',$fill);
$pdf->Cell(20,6,'0',1,0,'C',$fill);
$pdf->Cell(20,6,'0',1,0,'C',$fill);
$pdf->Cell(20,6,'0',1,0,'C',$fill);
$pdf->Cell(20,6,'0',1,0,'C',$fill);
$pdf->Cell(20,6,'0',1,0,'C',$fill);
$pdf->Cell(20,6,'0',1,0,'C',$fill);
$pdf->Cell(20,6,'0',1,0,'C',$fill);
$pdf->Cell(34,6,'0',1,0,'C',$fill);
$pdf->Cell(31,6,'0',1,0,'C',$fill);
$pdf->Ln();
            }
        }

    }
else
{
    $pdf->SetFillColor(247, 64, 64);
    $pdf->Cell(297, 6, 'TIDAK ADA DATA BIAYA KAS HARIAN', 'LRB', 0, 'L', true);
    $pdf->Ln();
}


$pdf->SetX(232);
$pdf->Cell(34,6,'TOTAL',1 ,0, 'C');
$pdf->Cell(34,6, format_rupiah($total_biaya),1 ,0, 'C');

$pdf->Ln(20);

$pdf->SetX(250);
$pdf->Cell(30,6,'Dibuat Oleh,', 'C');
$pdf->Ln(15);
$pdf->SetX(250);
$pdf->Cell(30,6,'('.$vuser_kasir.')', 'C');

$pdf->Output('LaporanBiayaKasOperasional'.$vtgl.'.pdf', 'F');

$data = '<a class="mediaShow" href="include/LaporanBiayaKasOperasional'.$vtgl.'.pdf"></a>
 
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