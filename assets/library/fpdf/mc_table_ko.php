<?php
require('fpdf.php');

class PDF extends FPDF
{
var $widths;
var $aligns;

	// Page header
    function Header()
    {
    	if ($this->page == 1)
        {
        global $alamat, $judul;
    
    // Logo
        $this->Image('../../assets/images/logo.jpg',130,5,30);
        $this->Ln(4);
    // Arial bold 15
        $this->SetFont('Times','',10);        
        $w = $this->GetStringWidth($alamat)+6;
        $this->SetX((290-$w)/2);
        $this->Cell($w, 9, $alamat, 'C', true);

        $this->SetFont('Times','B',14);    
    // Calculate width of title and position
        $w = $this->GetStringWidth($judul)+6;
        $this->SetX((290-$w)/2);
    // Colors of frame, background and text
        $this->SetDrawColor(10,30,120);
        $this->SetFillColor(135, 206, 235);
        $this->SetTextColor(255, 30, 30);
    // Thickness of frame (1 mm)
        $this->SetLineWidth(0.5);
    // Title    
        $this->Cell($w, 9, $judul, 'C', true);
    /**
    //  Line break
    //  $this->Ln(2);
    **/
		}
    }

    // Page footer
    function Footer()
    {
        global $vtanggal2;
    // Position at 1.5 cm from bottom
        $this->SetY(-15);
    // Arial italic 8
        $this->SetFont('Arial','I',8);
    // Page number
        $this->Cell(20,10,'Dicetak pada : ',0,0,'L');
        $this->Cell(25,10, $vtanggal2, 0, 0, 'L');
        $this->SetX(15);
        $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'C');
    }

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=6*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		$this->Rect($x,$y,$w,$h);
		//Print the text
		$this->MultiCell($w,6,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}
}
?>
