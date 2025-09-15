<?php


class PDF_CONFIG extends MC_TABLE
{
// function Header()
// {
// $this->SetFont('Arial','B',10);
   
//    	//$this->Image(''.base_url().'upload/banderole/socar.jpeg',35,5,30);
//    	$this->Image(''.base_url().'upload/banderole/socar.jpeg',35,5,30,10);
//    	$this->Ln(7); 
//    	$this->Cell(80,5,'SOCIETE COMMERCIALE',0,1,'C');
//    	$this->Cell(80,5,'D\'ASSURANCES DE RASSURANCE VIE S.A',0,0,'C');
//     // Saut de ligne
//     // $this->Ln(20);
//     // $this->SetY(45);
    
//     // $this->Line(40,50,40, 280);
// }
// Pied de page
// function Footer()
// {
//     // Positionnement à 1,5 cm du bas
//     $this->SetY(-20);
//     // Police Arial italique 8
//     $this->SetFont('Arial','I',8);
//     // Numéro de page
//     $this->Cell(0,10,$this->PageNo(),0,0,'C');
    
    
//  $this->Image(''.base_url().'upload/banderole/grandlogo.jpg',10,280,220);
// }

// function Footer(){
// 	$this->SetY(-20);
// 	$this->SetFont('Arial','B',10);
// 	$this->Cell(190,0,'',1,1,'C');
// 	$this->Cell(190,5,utf8_decode('Jonction Boulevard de l\'independance et Avenue d\'Italie. Tél:22279888, 69900400, 76999950, 75103000'),0,1,'C');
// 	$this->Cell(190,5,utf8_decode('Site Web: www.socarvie.bi, Email: info@socarvie.bi'),0,1,'C');
// 	$this->Cell(190,5,utf8_decode('Cpte:....:....'),0,1,'C');
// }

	 function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
        if (strpos($corners, '2')===false)
            $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($corners, '3')===false)
            $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($corners, '4')===false)
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($corners, '1')===false)
        {
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

}

?>