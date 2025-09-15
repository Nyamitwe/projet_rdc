<?php 

/**
* @author Nadvaxe2024
* created on the 25th april 2024
* DEMANDE DES AUDIENCES
* advaxe@mediabox.bi
*/
class Pv extends CI_Controller
{
  function __construct()
  {
    # code...
    parent::__construct();
    require('fpdf184/fpdf.php');
  }
  
  //Fonction principale
  
  // function index()
  // {
  


  //   $lien_sauvegarder = FCPATH.'uploads/doc_generer/';
  //   if(!is_dir($lien_sauvegarder)){
  //     mkdir($lien_sauvegarder,0777,TRUE); 
  //   }

  //   $pdf = new FPDF();
  //   // 'L' spécifie le format paysage (horizontal)
  //   $pdf->AddPage('L', 'A3');
  //   // $pdf->SetFont('Times','',10);
  //   // $pdf->MultiCell(0, 0, 'Données pour la première partie', 1, 'L');
  //   // $pdf->MultiCell(0, 0, 'Autres données pour la deuxième partie', 1, 'R');
    
  //   $pdf->SetFont('Times','',10);
  //   $pdf->SetX(50); // Définir la position X de départ pour centrer les éléments
  //   $pdf->SetFont('Arial','B',12);
  //   $pdf->Cell(200,20,'Renseignements du Conservateur des Titres Fonciers',0,1,'L');
  //   $pdf->Ln(20);
  //   $pdf->SetX(30); 
  //   $pdf->MultiCell(130,5,utf8_decode('Certificat d\'enregistrement établi à la suite du procès-verbal'),1,'R');
  //   // Ajout de deux "champs de texte" simulés sur la même ligne
  //   $pdf->Ln(20);
  //   $pdf->SetFont('Arial', '', 12);

  //   $pdf->SetX(50);
  //   $pdf->Cell(30, 8, 'Vol', 0, 0, 'L');
  //   $pdf->SetDrawColor(0, 0, 0);
  //   $pdf->Cell(20, 8, '', 1, 0, 'L');
  
  //   $pdf->Cell(20, 8, 'Fo', 0, 0, 'L');  // Label pour le deuxième champ
  //   $pdf->Cell(20, 8, '', 1, 0, 'L');

  //   $pdf->Ln(10);
  //   $pdf->SetFont('Arial','BU',12);
  //   $pdf->SetX(70);
  //   $pdf->Cell(130,5,utf8_decode('BUJUMBURA, le ../../....'),0,1,'L');
  //   $pdf->SetFont('Arial','',12);

  //   $pdf->Ln(10);
  //   $pdf->SetX(50);
  //   $pdf->MultiCell(130,5,utf8_decode('Le Chef de service du cadastre, étude et coordination'),'','L',false);



  //   $pdf->Ln(5);
  //   $pdf->SetX(70);
  //   $pdf->Cell(130,5,utf8_decode('Ing. NIYONKINDI Lionel'),0,1,'L');

  //   $pdf->Ln(20);
  //   $pdf->SetX(50);
  //   $pdf->Cell(130,5,utf8_decode('Renseignements du Cadastre National'),0,1,'L');

  //   $pdf->Ln(10);
  //   $pdf->SetX(30);
  //   $pdf->Cell(130,5,utf8_decode('A la suite du présent procès-verbal, la parcelle est cadastrée sous le N°:'),0,1,'L');

  //   $pdf->Ln(10);
  //   $pdf->SetX(70);
  //   $pdf->Cell(130,5,utf8_decode('BUJUMBURA, le ../../....'),0,1,'L');
  //   $pdf->SetFont('Arial','',12);
    
  //   $pdf->Ln(10);
  //   $pdf->SetX(50);
  //   $pdf->Cell(130,5,utf8_decode('Le Directeur des Titres Fonciers et du Cadastre National'),0,1,'L');
  //   $pdf->SetFont('Arial','',12);

  //   $pdf->Ln(10);
  //   $pdf->SetFont('Arial','B',12);
  //   $pdf->SetX(70);
  //   $pdf->Cell(130,5,utf8_decode('NIBIGIRA Salomon'),0,1,'L');
  //   $pdf->SetFont('Arial','',12);
 
  //   $pdf->SetFont('Times','',10);

  //   // $PATH_AUTORISATION='AUTORISATIONMORCELLEMENT.pdf';
      

  //   // $pdf->Output($lien_sauvegarder.$PATH_AUTORISATION,'F');
  //   $pdf->Output('I');


  // }

  function index()
{
    $lien_sauvegarder = FCPATH . 'uploads/doc_generer/';
    if(!is_dir($lien_sauvegarder)) {
        mkdir($lien_sauvegarder, 0777, TRUE); 
    }

    $pdf = new FPDF();
    $pdf->AddPage('L', 'A3');

    // Partie de gauche
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(10, 10); // Position pour la partie de gauche
    $pdf->SetX(50);
    $pdf->MultiCell(130, 20, utf8_decode('Renseignements du Conservateur des Titres Fonciers'), 0, 'L');
    $pdf->Ln(20);
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetXY(10, 10);
    $pdf->SetX(30); 
    $pdf->MultiCell(130,50,utf8_decode('Certificat d\'enregistrement établi à la suite du procès-verbal'),0,'L');
    $pdf->Ln(20);
    $pdf->SetFont('Arial', '', 12);

    $pdf->SetX(50);
    $pdf->Cell(30, 8, 'Vol', 0, 0, 'L');
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Cell(20, 8, '', 1, 0, 'L');
  
    $pdf->Cell(20, 8, 'Fo', 0, 0, 'L');  // Label pour le deuxième champ
    $pdf->Cell(20, 8, '', 1, 0, 'L');

    $pdf->Ln(10);
    $pdf->SetFont('Arial','BU',12);
    $pdf->SetX(70);
    $pdf->Cell(130,5,utf8_decode('BUJUMBURA, le ../../....'),0,1,'L');
    $pdf->SetFont('Arial','',12);

    $pdf->Ln(10);
    $pdf->SetX(50);
    $pdf->MultiCell(130,5,utf8_decode('Le Chef de service du cadastre, étude et coordination'),'','L',false);



    $pdf->Ln(5);
    $pdf->SetX(70);
    $pdf->Cell(130,5,utf8_decode('Ing. NIYONKINDI Lionel'),0,1,'L');

    $pdf->Ln(20);
    $pdf->SetX(50);
    $pdf->Cell(130,5,utf8_decode('Renseignements du Cadastre National'),0,1,'L');

    $pdf->Ln(10);
    $pdf->SetX(30);
    $pdf->Cell(130,5,utf8_decode('A la suite du présent procès-verbal, la parcelle est cadastrée sous le N°:'),0,1,'L');

    $pdf->Ln(10);
    $pdf->SetX(70);
    $pdf->Cell(130,5,utf8_decode('BUJUMBURA, le ../../....'),0,1,'L');
    $pdf->SetFont('Arial','',12);
    
    $pdf->Ln(10);
    $pdf->SetX(50);
    $pdf->Cell(130,5,utf8_decode('Le Directeur des Titres Fonciers et du Cadastre National'),0,1,'L');
    $pdf->SetFont('Arial','',12);

    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetX(70);
    $pdf->Cell(130,5,utf8_decode('NIBIGIRA Salomon'),0,1,'L');
    $pdf->SetFont('Arial','',12);
 
    $pdf->SetFont('Times','',10);

    // Partie de droite
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetXY(200, 10); // Position pour la partie de droite
    $pdf->MultiCell(130, 20, utf8_decode('République du Burundi'), 0, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetXY(200, 15); 
    
    $pdf->Cell(30, 25, 'Province', 0, 0, 'L');
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Cell(20, 8, '', 1, 0, 'L');
  
    $pdf->Cell(20, 25, 'Commune', 0, 0, 'L'); 
    $pdf->Cell(20, 8, '', 1, 0, 'L');
    // $pdf->Ln(10);
    
    // $pdf->SetFont('Arial', '', 12);
    // $pdf->SetXY(200, 20); 
    
    // $pdf->Cell(30, 30, 'Zone', 0, 0, 'L');
    // $pdf->SetDrawColor(0, 0, 0);
    // $pdf->Cell(20, 30, '', 1, 0, 'L');
  
    // $pdf->Cell(20, 30, 'Localité', 0, 0, 'L');
    // $pdf->Cell(20, 30, '', 1, 0, 'L');

    // Génération du PDF
    $pdf->Output('I');
}

}