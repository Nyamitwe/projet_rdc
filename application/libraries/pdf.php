<?php
require('fpdf.php');



class PDF extends FPDF
{
function Header()
{
$this->SetFont('Arial','B',12);
   
    /*$this->Cell(100,6,"CENTRE MEDICO-ORTHOPEDIQUE",0,1,'L');
  	 $this->Cell(100,6,"DE BUJUMBURA(CEMOBU)",0,1,'L');
	 $this->Cell(100,6,"BP 6884 Bujumbura",0,1,'L');
	 $this->Cell(100,6,"TEL : 69 230 127/71 299 152",0,1,'L');
	 $this->Cell(100,6,"E-mail : ginkhat@yahoo.com",0,1,'L');
     $this->SetFont('Arial','',12);
	
 
   */
   
    // Saut de ligne
    $this->Ln(10);
}
// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

}

}
?>