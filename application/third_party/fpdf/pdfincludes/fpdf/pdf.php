<?php
require('fpdf.php');



class PDF extends FPDF
{
function Header()
{
$this->SetFont('Arial','B',12);
   
   // $this->Image('uploads/entete.jpg',20,5,150); 
    // Saut de ligne
    $this->Ln(10);
    $this->SetY(45);
    
    $this->Line(40,50,40, 280);
}
// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-20);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,$this->PageNo(),0,0,'C');
    
    
 // $this->Image('uploads/pied.jpg',10,280,220);
}

}
?>