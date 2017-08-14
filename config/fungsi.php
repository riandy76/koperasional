<?php
function format_rupiah($rp) {
	$hasil = "Rp " . number_format($rp, 0, "", ".") . ",00";
	return $hasil;
}

function tanggal_indo($tanggal)
{
// format mysql yyyy-mm-dd
    $bulan = array (1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
    $split = explode('-', $tanggal);
    return $split[2] . '-' . $bulan[ (int)$split[1] ] . '-' . $split[0];
}

function bulan($tanggal)
{
// format mysql yyyy-mm-dd
    $bulan = array (1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
    $split = explode('-', $tanggal);
    return $bulan[ (int)$split[1] ];
}

?>