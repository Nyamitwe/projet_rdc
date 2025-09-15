<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
  * Dev par Martin KING
  Buja 28-04-2022
  */
 class Generatepdf
 {
 	
 	protected $CI;

	public function __construct()
	{
	  $this->CI = & get_instance();
	  // require('fpdf184/fpdf.php');
     
	}

 	 public function declaration_perte()
	{

		$pdf = new FPDF();
		$pdf->AddPage('P','A4');
		$pdf->SetY(3);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,25,'BUJUMBURA, le '.date('d/m/Y') ,0,1,'R');
		$pdf->SetFont('Times','B',10);
		$pdf->Ln(2);
		$pdf->SetY(3);
		$pdf->SetFont('Times','B',13);
		$pdf->MultiCell(187,20,utf8_decode(' REPUBLIQUE   DU  BURUNDI'),'','BU',false);
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,17,40,40);
		$pdf->SetY(47);
		$pdf->SetFont('Times','B',13);
		$pdf->Cell(185,20,'MINISTERE DE LA JUSTICE' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',13);
		$pdf->Cell(185,20,'ET DE LA PROTECTION CIVIQUE' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','BU',13);
		$pdf->Cell(185,20,'DIRECTION DES TITRES FONCIERS' ,0,0,'L');
		$pdf->Ln(20);
		$pdf->SetFont('Times','BU',13);
		$pdf->Cell(185,20,'DECLARATION DE PERTE' ,0,0,'C');
		$pdf->Ln(2);
		$pdf->SetFont('Times','B',12);
		$pdf->Ln(30);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,8,utf8_decode('Je soussigné...............................................................................................................................   Déclare par la présente que malgré mes recherches les plus actives, il m\'a été impossible de retrouver le certificat d\'enregistrement volume ..............................folio....................se rapportant à une propriété située à................................cadastrée sous le numéro.................................et être personnellement responsable des conséquences dommageables que la perte de ce document et la délivrance du nouveau certificat pourraient avoir vis-à vis des tiers .'),'','B',false);
		$pdf->Ln(50);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,5,'Fait à Bujumbura, le'.date('d/m/Y'),0,1,'R');
		$pdf->Ln(1);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,5,' sceau et Signature ',0,1,'R');
		$pdf->Ln(1);

		$pdf->Output('I');
	}


	public function Autolisation_morcellement($requerant='',$numero_dossier='')
	{
		$pdf = new FPDF();
		$pdf->AddPage('P','A4');
		$pdf->SetY(3);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,25,'BUJUMBURA, le '.date('d/m/Y') ,0,1,'R');
		$pdf->SetFont('Times','B',10);
		$pdf->Ln(2);
		$pdf->SetY(3);
		$pdf->SetFont('Times','B',13);
		$pdf->MultiCell(187,20,utf8_decode(' REPUBLIQUE   DU  BURUNDI'),'','BU',false);
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,17,40,40);
		$pdf->SetY(47);
		$pdf->SetFont('Times','B',13);
		$pdf->Cell(185,20,'MINISTERE DE LA JUSTICE' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',13);
		$pdf->Cell(185,20,'DIRECTION DES TITRES FONCIERS ' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','BU',13);
		$pdf->Cell(185,20,' ET DU CADASTRE NATIONAL' ,0,0,'L');
		$pdf->Ln(10);
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(187,20,utf8_decode('Réf : '.$numero_dossier.' '),'','',false);
		$pdf->Ln(2);
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(150,5,utf8_decode('OBJET : Autorisation de morcellement'),'','L',false);
		$pdf->Ln(1);
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(160,5,utf8_decode('               de la parcelle n° X'),'','L',false);
		$pdf->Ln(1);
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(160,5,utf8_decode('               située au quartier Y'),'','L',false);
		$pdf->SetY(77);
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(187,5,utf8_decode('A monsieur '.$requerant.' '),'','R',false);
		$pdf->Ln(3);
		$pdf->SetFont('Times','B',12);
		$pdf->MultiCell(150,3,utf8_decode('à'),'','R',false);
		$pdf->Ln(3);
		$pdf->SetFont('Times','U',12);
		$pdf->MultiCell(165,3,utf8_decode('BUJUMBURA'),'','R',false);
		$pdf->Ln(20);
		$pdf->SetFont('Times','BU',13);
		$pdf->Cell(185,3,'AUTORISATION DE MORCELLEMENT' ,0,0,'C');
		$pdf->Ln(2);
		$pdf->SetFont('Times','B',12);
		$pdf->MultiCell(175,5,utf8_decode("".lang('mr_mrs')."  ".lang('content_proforma_1')."  ".lang('content_proforma_2').""),0,0,FALSE);
		$pdf->Ln(15);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('Monsieur/Madame '.$requerant.','),'','',false);
		$pdf->Ln(3);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,8,utf8_decode('         Faisant suite à votre lettre  du ............... par laquelle vous demandez la réunification des parcelles identifiées  sus rubrique, j\'ai l\'honneur de porter à votre connaissance que je marque mon accord.'),'','',false);
		$pdf->Ln(3);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,8,utf8_decode('         Je vous demanderais par conséquent de me transmettre les procès-verbaux d\'arpentage et de bornage dressés postérieurement à la présente autorisation par la Direction du Cadastre National  pour permettre l\'enregistrement des  parcelles issues du morcellement.'),'','',false);
		$pdf->Ln(3);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(130,8,utf8_decode('           Veuillez agréer, Monsieur, l\'assurance de ma considération distinguée.'),'','',false);
		$pdf->Ln(35);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(187,5,utf8_decode('Le Directeur des Titres Fonciers.'),'','R',false);
		$pdf->Ln(3);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(173,5,utf8_decode('Nom et Prénom.'),'','R',false);
		$pdf->Ln(1);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(168,5,'Signature ',0,1,'R');
		$pdf->Ln(1);
		$pdf->Output('I');
	}

	function pv_de_bornage()
	{
		$pdf = new FPDF();
		$pdf->AddPage('P','A4');
		$pdf->SetY(3);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,25,'BUJUMBURA, le '.date('d/m/Y') ,0,1,'R');
		$pdf->SetFont('Times','B',10);
		$pdf->Ln(2);
		$pdf->SetY(3);
		$pdf->SetFont('Times','B',13);
		$pdf->MultiCell(187,20,utf8_decode(' REPUBLIQUE   DU  BURUNDI'),'','BU',false);
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,17,40,40);
		$pdf->SetY(47);
		$pdf->SetFont('Times','B',13);
		$pdf->Cell(185,20,'MINISTERE DE LA JUSTICE' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',13);
		$pdf->Cell(185,20,'DIRECTION DES TITRES FONCIERS ' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','BU',13);
		$pdf->Cell(185,20,' ET DU CADASTRE NATIONAL' ,0,0,'L');
		$pdf->Ln(20);
		$pdf->SetFont('Times','BU',13);
		$pdf->Ln(3);
		$pdf->Cell(185,3,'PROCES VERBAL DE BORNAGE' ,0,0,'C');
		$pdf->Ln(20);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Province.........(nom de la province)................Commune................................(nom de la commune)........................Zone..............(nom de la zone)........................Localité...........................(nom du quartier)...............................................'),'','L',false);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('Procès Verbal   d\'arpentage     et    de    bornage N°   .............................................................'),'','L',false);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('L\'an deux mille     ............................................. le .........................................................................'),'','L',false);
		$pdf->Ln(3);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Nous    .........................................................................................................................................'),'','L',false);
		$pdf->Ln(3);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Géomètre du cadastre    ......................................................................................................................'),'','L',false);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('Certifions avoir procédé au mesurage et au bornage de la parcelle décrite ci après, à la demande de      ...........................................................................................................................................'),'','L',false);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('La parcelle est située à      ...............................................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Elle est contiguë       ........................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Elle fait l\'objet de la parcelle cadastrée sous le N°        ...............................................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Et enregistrée sous le volume ................................................Folio........................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Elle provient du morcellement de la parcelle cadastrée sous le N°   .............................................................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Et enregistrée sous le volume   ............................................Folio..........................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Les constructions suivantes y sont érigées à ce jour  .........................................................................................................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->MultiCell(187,5,utf8_decode('Instruments employés pour le mesurage ..................................................................................................'),'','L',false);
		$pdf->Ln(4);
		// $u=7;

		// for ($i=1; $i <=$u ; $i++) { 
  // 	// code...
		// 	$pdf->SetFont('Arial','',12);
		// 	$pdf->MultiCell(187,5,utf8_decode('('.$i.')'.":"),'','L',false);

		// }
		$pdf->MultiCell(187,5,utf8_decode('(1)   	Réservé à l\'administration.'),'','L',false);
		$pdf->Ln(4);
		$pdf->MultiCell(187,5,utf8_decode('(2)   	Date de mesurage et bornage'),'','L',false);
		$pdf->Ln(4);
		$pdf->MultiCell(187,5,utf8_decode('(3)  	Nom, prénom et domicile'),'','L',false);
		$pdf->Ln(4);
		$pdf->MultiCell(187,5,utf8_decode('(4)  	Barrer l\'inscription qui ne convient pas'),'','L',false);
		$pdf->Ln(4);
		$pdf->MultiCell(187,5,utf8_decode('(5)  	Renseigner les propriétés contiguës au Nord, à l\'Est, au Sud et à l\'Ouest'),'','L',false);
		$pdf->Ln(4);
		$pdf->MultiCell(187,5,utf8_decode('(6)  	Barrer l\'annotation qui ne convient pas et, le cas échéant, les deux annotations'),'','L',false);
		$pdf->Ln(4);
		$pdf->MultiCell(187,5,utf8_decode('(7)  	Maisons d\'habitation, magasins ou annexes, etc.et nature des matériaux.'),'','L',false);
		$pdf->Ln(7);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('N.B. Aucune rature ni surcharge ne peuvent être faite au présent procès-verbal.'),'','L',false);
		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('  Les erreurs doivent être rectifiées par des annotations datées et signées par le géomètre-arpenteur..'),'','L',false);
		$pdf->Ln(15);
		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('  Eléments ayant servi au calcul de la superficie et à l\'établissement du croquis ci-contre de la parcelle.'),'','L',false);
		
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',12);
		$pdf->SetWidths(array('120','30','30'));
		$pdf->SetAligns(4);
		$pdf->SetWidths(array('30','30','30','60','20','20','20'));
		$pdf->Row(array(utf8_decode('Sommets du périmètre et leur description'),utf8_decode('Longueur des côtés réduite à l\'horizon (1)'),utf8_decode('Angles aux sommets Grades(2)(1)'),utf8_decode('Autres renseignements éventuels permettant le calcul de la superficie, l\'établissement, l\'orientation du croquis (azimut ou gisement ou orientation d\'un côté) ainsi que le repérage des sommets'),utf8_decode('Description des côtés'),utf8_decode('Tenants et aboutissants')));
		$pdf->SetWidths(array('30','30','30','30','30','20','20','20'));
		$pdf->SetAligns(4);
		$pdf->Row(array(utf8_decode('1   borne'),utf8_decode('111.88'),utf8_decode('760909.47'),utf8_decode('    '),utf8_decode('9623233.8'),utf8_decode('    '),utf8_decode('      ')));
		$pdf->Row(array(utf8_decode('    '),utf8_decode('41.70'),utf8_decode('  '),utf8_decode('  '),utf8_decode('     ')));
		$pdf->Row(array(utf8_decode(' 2  " '),utf8_decode(' '),utf8_decode(' 760898.08 '),utf8_decode(' 9623193.69 '),utf8_decode('     ')));
		$pdf->Row(array(utf8_decode('    '),utf8_decode('64.35'),utf8_decode('  '),utf8_decode('  '),utf8_decode('     ')));
		$pdf->Row(array(utf8_decode(' 3   "   '),utf8_decode('  '),utf8_decode(' 760840.22 '),utf8_decode(' 9623221.85 '),utf8_decode('     ')));
		$pdf->Row(array(utf8_decode('    '),utf8_decode('41.80'),utf8_decode('  '),utf8_decode('  '),utf8_decode('     ')));
		$pdf->Row(array(utf8_decode(' 4   "  '),utf8_decode('  '),utf8_decode('94.30  '),utf8_decode('760855.56'),utf8_decode(' 9623260.98 ')));
		$pdf->Row(array(utf8_decode(''),utf8_decode(' 60.35 '),utf8_decode(' '),utf8_decode(''),utf8_decode('  ')));
		$pdf->SetWidths(array('30','30','90'));
		$pdf->Row(array(utf8_decode('1  "'),utf8_decode(' 60.35 '),utf8_decode(' Déjà décrit ')));
		$pdf->SetWidths(array('30','30','30','30','30','20','20','20'));
		$pdf->Line('180','150','180','250');
		$pdf->Line('200','150','200','250');
        // $pdf->Line('180','20','100','20');
		$pdf->Row(array(utf8_decode(''),utf8_decode('  '),utf8_decode(' '),utf8_decode(''),utf8_decode('  ')));
		$pdf->Row(array(utf8_decode(''),utf8_decode('  '),utf8_decode(' '),utf8_decode(''),utf8_decode('  ')));
		$pdf->Row(array(utf8_decode(''),utf8_decode('  '),utf8_decode(' '),utf8_decode(''),utf8_decode('  ')));
		$pdf->Row(array(utf8_decode(''),utf8_decode('  '),utf8_decode(' '),utf8_decode(''),utf8_decode('  ')));
		$pdf->Row(array(utf8_decode(''),utf8_decode('  '),utf8_decode(' '),utf8_decode(''),utf8_decode('  ')));
		$pdf->Row(array(utf8_decode(''),utf8_decode('  '),utf8_decode(' '),utf8_decode(''),utf8_decode('  ')));
		$pdf->Row(array(utf8_decode(''),utf8_decode('  '),utf8_decode(' '),utf8_decode(''),utf8_decode('  ')));
		$pdf->Row(array(utf8_decode(''),utf8_decode('  '),utf8_decode(' '),utf8_decode(''),utf8_decode('  ')));

		$pdf->Row(array(utf8_decode(''),utf8_decode('  '),utf8_decode(' '),utf8_decode(''),utf8_decode('  '),utf8_decode('  '),utf8_decode('  ')));
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('1. D\'après mesures ou calculs'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('2. Barrer l\'inscription qui ne convient pas.'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',13);
		$pdf->MultiCell(187,5,utf8_decode('N.B. Les renseignements imposés par les colonnes 1, 2, 3,5 et 6  sont indispensables.'),'','L',false);
		
		$pdf->SetY(40);
		$pdf->SetFont('Arial','B',13);
		$pdf->MultiCell(187,5,utf8_decode('Croquis orienté de la parcelle des constructions et des servitudes'),'','L',false);
		$pdf->Ln(4);

		$pdf->SetFont('Arial','',13);
		$pdf->Image(base_url().'upload/logo/croquis.jpg',20,50,170,100);
		$pdf->Ln(10);
		$pdf->SetY(150);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('.....................................................................................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('a.	Relatives au bornage (4).........................................................................................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('a.	Autres observations(5) ..........................................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('Dressé en triple .................................le.............................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('(6)Le géomètre du cadastre..........................................................Le propriétaire ...............................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('(1) L\'échelle doit être choisie de manière à inclure clairement le croquis dans le cadre. Si ce n\'est pas possible, le croquis à plus grande échelle sera annexé au procès-verbal et le réservé au croquis devra mentionner les mots : voir plan annexé ci-joint.'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('(2) Superficie calculée numériquement en chiffres.(3) Superficie calculée numériquement en toutes lettres.'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('(4) Des bornes mitoyennes ont été placées aux sommets .............................................Des bornes mitoyennes existaient aux sommets..................................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('Impossibilité matérielle de placer une borne au sommet ..............................................  ; cause...................................................; repérage au Sommet non  borné .........................................................etc'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('(5) Servitudes éventuelles, discordance constatée, d\'après bornes existantes, entre côtés communs, etc.'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',13);
		$pdf->MultiCell(187,5,utf8_decode('(6) Barrer l\'inscription qui ne convient pas'),'','L',false);
		$pdf->LN(6);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('Renseignements du Conservateur des Titres Fonciers'),'','L',false);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Certificat d\'enregistrement établi à la suite du procès verbal'),'','L',false);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('numéro de volume.............................. numéro Folio...................................'),'','L',false);
		$pdf->Ln(6);
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(187,5,utf8_decode('Le Chef de  service du cadastre a.i Etudes et coordination'),'','R',false);
		$pdf->Ln(3);
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(187,5,utf8_decode('(Nom et Prénom)'),'','R',false);
		$pdf->Ln(20);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('Renseignements du Cadastre National'),'','L',false);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('A la suite du présent procès verbal, la parcelle est cadastrée sous le N° X'),'','L',false);
		$pdf->Ln(2);
		$pdf->SetFont('Times','B',12);
		$pdf->MultiCell(175,5,utf8_decode("".lang('mr_mrs')."  ".lang('content_proforma_1')."  ".lang('content_proforma_2').""),0,0,FALSE);

		$pdf->Ln(15);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(180,5,utf8_decode('Bujumbura, le....../......../2022.'),'','R',false);
		$pdf->Ln(3);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(187,5,utf8_decode('Le Directeur des Titres Fonciers'),'','R',false);
		$pdf->Ln(3);
		$pdf->SetFont('Arial','B',10);
		$pdf->MultiCell(175,5,utf8_decode('et du Cadastre National .'),'','R',false);
		

		$pdf->Output('I');


	}
	

	function Formulaire_Titre_Foncier()
	{
		$pdf = new FPDF();
		$pdf->AddPage('P','A4');
		$pdf->SetY(3);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,25,'BUJUMBURA, le '.date('d/m/Y') ,0,1,'R');
		$pdf->SetFont('Times','B',10);
		$pdf->Ln(2);
		$pdf->SetY(3);
		$pdf->SetFont('Times','B',13);
		$pdf->MultiCell(187,20,utf8_decode(' REPUBLIQUE   DU  BURUNDI'),'','BU',false);
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,17,40,40);
		$pdf->SetY(47);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'MINISTERE   DE   LA   JUSTICE ' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'DIRECTION DES TITRES  FONCIERS ' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,' ET  DU  CADASTRE   NATIONAL' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'CIRCONSCRIPTION   FONCIERE ' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,20,'ET   CADASTRALE   DE   BUJUMBURA' ,0,0,'L');
		$pdf->Ln(20);
		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,3,'FORMULAIRE DE TITRE FONCIER' ,0,0,'C');
		$pdf->Ln(20);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('Formulaire de demande d\'un titre foncier    N° DTF CN/........./20..........'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Motif (enregistrement original, transfert, morcellement, réunification, actualisation, déclaration de perte, etc.) :.........................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Date de dépôt :........................................................   Heure de dépôt :..................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Nom du déposant :......................................      Tél :...................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('CNI du déposant :......................    Lieu et date de délivrance:.............................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Nom et prénom du propriétaire  ou raison sociale :................................                Nom du représentant:........................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Nationalité :..................... Profession:..............................................................                '),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('N° CNI du propriétaire ou passeport  :............................................                  BP:................................Tél:...........................Adresse mail :..............................................    '),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Résidence du propriétaire (aho nyene itongo aba):.............................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Situation de l\'immeuble (aho itongo riri n\'ibiriranga):.........................................................................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('N° cadastral ou parcellaire :.................................................        Volume :.................................................Folio:..............................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Province: ...................................Commune: ....................................... Zone: ...........................colline/quartier:.............................................s/colline:.......................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('Documents déposés (inzandiko yashikirije) :'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('1.	......................................................                     3.   ...................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('2.	.......................................                                      4.     ................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,5,utf8_decode('Noms et prénoms  des limitrophes  (amazina y\'abo bahana urubibe) :'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('1.	......................................................                     3.   ...................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('2.	......................................................                        4.    ................................................'),'','L',false);
		$pdf->Ln(4);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Mode d\'acquisition/origine de la propriété (ingene yaronse iryo tongo) : Dévolution successorale, achat, cession domaniale, don, leg, jugement, décision de la CNTB, etc. : ........................................................................................    '),'','L',false);
		$pdf->Ln(4);
		
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Usage de la propriété/ico rikoreshwa n\'ibirimwo (agricole, résidentiel, commercial, équipement, industriel, minier, etc.) :................................................................'),'','L',false);
		$pdf->Ln(20);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode(' Signature du déposant                                    Nom et prénom et signature du réceptionniste'),'','L',false);
		$pdf->Ln(20);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('  .......................................                                                  ......................................'),'','L',false);
		$pdf->Ln(15);
		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(187,8,utf8_decode('NB/MENYA NEZA : Vous devez conserver soigneusement ce document et le présenter au secrétariat chaque fois que vous faites le suivi de votre dossier.  En cas de perte, faites une déclaration à la police. Musabwe kubika neza uru rupapuro no kurwibangikanya igihe cose muriko murakurikirana dosiye yanyu. Utaye uru rupapuro, wihute kubimenyesha inzego z\'igipolisi zibijejwe. '),'','L',false);
		$pdf->Output('I');

	}

	function Titre_Foncier()
	{
		$pdf = new FPDF();
		$pdf->AddPage('P','A4');
		$pdf->SetY(3);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,25,'BUJUMBURA, le '.date('d/m/Y') ,0,1,'R');
		$pdf->SetFont('Times','B',10);
		$pdf->Ln(2);
		$pdf->SetY(3);
		$pdf->SetFont('Times','B',13);
		$pdf->MultiCell(187,20,utf8_decode(' REPUBLIQUE   DU  BURUNDI'),'','BU',false);
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,17,40,40);
		$pdf->SetY(47);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'MINISTERE   DE   LA   JUSTICE ' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'DIRECTION DES TITRES  FONCIERS ' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,' ET  DU  CADASTRE   NATIONAL' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'CIRCONSCRIPTION   FONCIERE ' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,20,'ET   CADASTRALE   DE   BUJUMBURA' ,0,0,'L');
		$pdf->Ln(20);
		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,3,'CERTIFICAT D\'ENREGISTREMENT DU TITRE FONCIER' ,0,0,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode(' Livre d\'enregistrement'),'','L',false);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode(' Volume :............................................            Folio: ................................................................'),'','L',false);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Monsieur/Madame: ................................fils de ......................................et de: .................................................CNI no: .....................................delivré à Bujumbura le: ................................................'),'','L',false);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,8,utf8_decode('est enrgistré comme étant en vertu del\'ancien certificat d\'enregistrement volume:.................... Folio: ...................................annulé et contrat de vente immobilière passé le .............................................. devant le notaire à Bujumbura  et recu le .................................au registre journal sous les numéro d\'ordre général: .....................................et special:..................................................;   ...........................'),'','L',false);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,8,utf8_decode('propriétaire de l\'immeuble indiqué ci après; une pqrcelle de terre destinée à une usage residentiel située à :.........................contiguë au Nord à la parcelle numéro ...........................Division K, à l\' Est à la parcelle numéro .........................Division K, à l\' Est à la parcelle numéro .........................Division K, au Sud à la parcelle numéro .........................Division K et à l\' Ouest à un chemin public .   Une maison d\'habitaion emn materiaux durables y est exigée le jour du mesurage officiel.'),'','L',false);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Cette propriété est cadastre sous le numéro .....................Division k.......................................'),'','L',false);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('D\'après le procès verbal d\'arpentage et de bornage neméro ...............dressé le ............................................., elle est à une supérficie de .................................... et elle est représentanté par le croquis ci après '),'','L',false);
		$pdf->Ln(300);
		$pdf->SetFont('Arial','B',15);
		$pdf->MultiCell(187,5,utf8_decode('Croquis'),'','L',false);
		$pdf->Ln(4);

		$pdf->SetFont('Arial','',13);
		$pdf->Image(base_url().'upload/logo/croquis.jpg',20,30,170,100);

		$pdf->Ln(120);

		$pdf->SetFont('Arial','',12);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Les charges qui grèvent cette propriétaire d\'autre part'),'','L',false);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Délivré à.................................................................le..............................................................'),'','L',false);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Année de ....................................................................................'),'','L',false);
		$pdf->Ln(25);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Fait à Bujumbura, le....../...../20...'),'','R',false);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Directeur du titre foncier'),'','R',false);
		$pdf->Ln(1);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,5,' ',0,1,'R');

		$pdf->Output('I');

	}
	public function bon_reception()
	{


		$pdf = new FPDF();
		$pdf->AddPage('P','A4');
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(185,5,'REPUBLIQUE DU BURUNDI ' ,0,1,'L');
		$pdf->SetFont('Times','',10);
		$pdf->Ln(0);
		$pdf->Cell(185,5,'NO...., / '.date('Y') ,0,1,'R');
		
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,20,30, 30);
		$pdf->SetFont('Times','B',10);
		$pdf->Ln(30);
		$pdf->Cell(185,5,'MINISTERE DE LA JUSTICE ' ,0,1,'L');
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(185,5,'DIRECTION DE TITRE FONCIER ' ,0,1,'L');
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(185,5,'CIRCONSCRIPTION FONCIERE ' ,0,1,'L');
		$pdf->SetFont('Times','BU',10);
		$pdf->Cell(185,5,'DE BUJUMBURA, GITEGA,NGOZI ' ,0,1,'L');
		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,20,'BON DE RECEPTION DES DOCUMENTS CONTENANT UN TITRE FONCIER' ,0,0,'C');
		$pdf->Ln(40);
		$pdf->SetFont('Times','',10);
		$pdf->Line(110,85,110,280);
		$pdf->Ln(0);
		$pdf->SetFont('Times','',10);
		$pdf->MultiCell(100,5,utf8_decode("Nom et prénom du déposant :"),'C',false);

		$pdf->SetFont('Times','',10);
		$pdf->MultiCell(100,5,utf8_decode("Qualité du déposant :"),'C',false);
		$pdf->MultiCell(100,5,utf8_decode("Nom et prenom du propriataire :"),'C',false);
		$pdf->MultiCell(100,5,utf8_decode("Nom de l'acheur : "),'C',false);
		$pdf->MultiCell(100,5,utf8_decode("Dénomination de la banque :"),'C',false);
		$pdf->SetFont('Times','BU',10);
		$pdf->MultiCell(100,5,utf8_decode("Documents déposés"),'C',false);
		$pdf->SetFont('Times','',10);


		$u=15;
		for ($i=1; $i <=$u ; $i++) { 
  	// code...

			$pdf->MultiCell(100,5,utf8_decode($i.":"),'L',false);

		}

		$pdf->SetY(100);
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(160,5,utf8_decode('Transmis à la division enregistrement'),0,1,'R');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(120,5,utf8_decode('Expertise'),0,1,'R');
		$pdf->Ln(20);
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(160,5,utf8_decode('Transmis à la division enregistrement'),0,1,'R');
		$pdf->Ln(40);
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(130,5,utf8_decode('Retour secretariat'),0,1,'R');
		$pdf->Ln(60);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,5,utf8_decode('Fait à , le '.date('d/m/Y')),0,1,'L');
		$pdf->Ln(1);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,5,utf8_decode('Nom et prenom'),0,1,'L');
		$pdf->Ln(1);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,5,utf8_decode('du deposant et signature'),0,1,'L');
		$pdf->SetY(240);
		$pdf->Ln(1);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(100,5,utf8_decode('Fait à , le '.date('d/m/Y')),0,1,'R');
		$pdf->Ln(1);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(100,5,utf8_decode('sign.Nom et prenom'),0,1,'R');
		$pdf->Ln(1);
		
		

		$pdf->Output('I');
	}
	public function proforma()
	{


		$pdf = new FPDF();
		$pdf->AddPage('P','A4');
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(185,5,'REPUBLIQUE DU BURUNDI ' ,0,1,'L');
		$pdf->SetFont('Times','',10);
		$pdf->Ln(0);
		$pdf->Cell(185,5,'LOCALITE PROVINCE' ,0,1,'R');
		
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,20,30, 30);
		$pdf->SetFont('Times','B',10);
		$pdf->Ln(30);
		$pdf->Cell(185,5,'MINISTERE DE LA JUSTICE ' ,0,1,'L');
		$pdf->Cell(185,5,'COMMUNE: ' ,0,1,'R');
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(185,5,'DIRECTION DE TITRE FONCIER ' ,0,1,'L');
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(185,5,'CONSERVATION DE ' ,0,1,'L');
		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,20,'FACTURE PROFORMA NO' ,0,0,'C');
		$pdf->Ln(40);
		$pdf->SetFont('Times','',10);
		$pdf->Ln(20);
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(140,5,'LIBELLE',1,0,'L');
		$pdf->Cell(30,5,"MONTANT",1,1,'R');

		$pdf->SetFont('Times','',10);
		$pdf->Cell(140,5,utf8_decode('') ,1,0,'L');
		$pdf->Cell(30,5,'',1,1,'R');
		$pdf->Cell(170,5,utf8_decode('Montant en lettres :') ,1,0,'L');

		$pdf->Ln(30);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,5,'Valable jusqu\'au, le',0,1,'R');
		$pdf->Ln(0);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,5,'Le compable :',0,1,'L');
		$pdf->Ln(1);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,5,' Chef de la division demaire et recouvrement ',0,1,'R');
		$pdf->Ln(1);

		$pdf->Output('I');
	}
	public function attestation_non_possession()
	{


		$pdf = new FPDF();
		$pdf->AddPage('P','A4');
		$pdf->SetFont('Times','',10);
		$pdf->SetY(10);
		$pdf->MultiCell(110,5,utf8_decode(' REPUBLIQUE   DU  BURUNDI'),'','BU',false);
		$pdf->Ln(0);
		$pdf->SetY(3);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,25,'BUJUMBURA, le '.date('d/m/Y') ,0,1,'R');
		$pdf->SetFont('Times','B',10);
		$pdf->Ln(5);
		$pdf->SetY(10);
		$pdf->SetFont('Times','B',10);
		
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,15,40,40);
		$pdf->SetY(45);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'MINISTERE DE LA JUSTICE' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'DIRECTION DES TITRES FONCIERS' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,20,'ET DU CADASTRE NATIONAL  ' ,0,0,'L');
		$pdf->Ln(15);

		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,20,'ATTESTATION DE NON POSSESSION D\'IMMEUBLE 554/......./ANP/2022' ,0,0,'C');
		$pdf->SetFont('Times','BU',12);
		$pdf->Ln(15);
		$pdf->SetY(100);
		$pdf->SetFont('Times','B',12);
		//$pdf->MultiCell(175,5,utf8_decode("".lang('mr_mrs')."  ".lang('content_proforma_1')."  ".lang('content_proforma_2').""),0,0,FALSE);
		
		
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Je soussigné, ......................................................................................................................, Conservateur des Titres Fonciers du Burundi dans la Circonscription Foncière de Bujumbura, atteste par la présente que le nommé ................................... fils de ....................................................................... 
			et de ................................. né à ................................. Commune .................................. en Province ......................................., n\'est pas enregistré dans nos livres comme étant en possession d\'immeuble.

			La présente attestation lui est délivrée pour servir et faire valoir ce que de droit.
			.'),'','B',false);
		$pdf->Ln(50);


		$pdf->SetFont('Times','',10);
		$pdf->SetFont('Times','B',12);
		$pdf->MultiCell(175,5,utf8_decode('Fait à Bujumbura, le'.date('d/m/Y')
	),'','R',false);
		$pdf->Cell(185,5,' Le DIRECTEUR DES TITRES FONCIERS ET ',0,1,'R');
		$pdf->Cell(175,5,' DU CADASTRE NATIONAL ',0,1,'R');
		$pdf->Cell(170,5,' (.....................................)',0,1,'R');

		$pdf->Ln(1);
		$pdf->SetFont('Times','',10);

		$pdf->Ln(1);

		$pdf->Output('I');
	}

	public function attestation_possession()
	{


		$pdf = new FPDF();
		$pdf->AddPage('P','A4');
		$pdf->SetFont('Times','',10);
		$pdf->SetY(10);
		$pdf->MultiCell(110,5,utf8_decode(' REPUBLIQUE   DU  BURUNDI'),'','BU',false);
		$pdf->Ln(0);
		$pdf->SetY(3);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,25,'BUJUMBURA, le '.date('d/m/Y') ,0,1,'R');
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,15,40,40);
		$pdf->SetY(45);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'MINISTERE DE LA JUSTICE' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'DIRECTION DES TITRES FONCIERS' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,20,'ET DU CADASTRE NATIONAL  ' ,0,0,'L');
		$pdf->Ln(15);

		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,20,'ATTESTATION DE POSSESSION DE L\'UNIQUE IMMEUBLE 554/......../AP/2022 ' ,0,0,'C');
		$pdf->SetFont('Times','BU',12);
		$pdf->Ln(15);
		$pdf->SetY(100);
		$pdf->SetFont('Times','B',12);
		//$pdf->MultiCell(175,5,utf8_decode("".lang('mr_mrs')."  ".lang('content_proforma_1')."  ".lang('content_proforma_2').""),0,0,FALSE);
		
		
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Je soussigné, ..........................................................................................................................,
			Directeur des Titres Fonciers du Burundi à Bujumbura, atteste par le présent que la nommée ............................ fille de ..................................... et de ........................... née à ........................, Commune ............................., Province ........................... est inscrite en nos livres fonciers comme étant  propriétaire de l\'unique immeuble cadastré sous le numéro 2413/K sis à CIBITOKE et  enregistré  sous le Volume E CCCXXXV folio 155.

			Il est toutefois indiqué que la présente attestation ne compromettra pas les vérifications qui pourraient être faites auprès des circonscriptions foncières de Gitega et Ngozi.

			La présente attestation lui est délivrée pour servir et valoir ce que de droit.

			.'),'','B',false);
		$pdf->Ln(50);


		$pdf->SetFont('Times','',10);
		$pdf->SetFont('Times','B',12);
		$pdf->MultiCell(175,5,utf8_decode('Fait à Bujumbura, le'.date('d/m/Y')),'','R',false);
		$pdf->Cell(180,5,' Le Directeur des Titres Fonciers et ',0,1,'R');
		$pdf->Cell(170,5,' du Cadastre National ',0,1,'R');
		$pdf->Cell(170,5,' (...............................)',0,1,'R');

		$pdf->Ln(1);
		$pdf->SetFont('Times','',10);

		$pdf->Ln(1);

		$pdf->Output('I');
	}










	public function attestation_inscription_hypithecaire()
	{
		$pdf = new FPDF();
		$pdf->AddPage('P','A4');
		$pdf->SetFont('Times','',10);
		$pdf->SetY(10);
		$pdf->MultiCell(110,5,utf8_decode(' REPUBLIQUE   DU  BURUNDI'),'','BU',false);
		$pdf->Ln(0);
		$pdf->SetY(3);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,25,'BUJUMBURA, le '.date('d/m/Y') ,0,1,'R');
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,15,40,40);
		$pdf->SetY(45);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'MINISTERE DE LA JUSTICE' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(185,20,'DIRECTION DES TITRES FONCIERS' ,0,0,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,20,'CIRCONSCRIPTION DE BUJUMBURA' ,0,0,'L');
		$pdf->Ln(20);
		$pdf->SetFont('Times','BU',12);
		$pdf->Cell(185,20,'ATTESTATION  D\'INSCRIPTION HYPOTHECAIRE 554/......./ANP/2022' ,0,0,'C');
		$pdf->SetFont('Times','BU',12);
		
		$pdf->SetY(100);
		$pdf->SetFont('Times','B',12);
		//$pdf->MultiCell(175,5,utf8_decode("".lang('mr_mrs')."  ".lang('content_proforma_1')."  ".lang('content_proforma_2').""),0,0,FALSE);

		$pdf->Ln(10);
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(187,5,utf8_decode('Nous, ........................................................................, Conservateur des Titres Fonciers de Bujumbura, attestons que nous avons procédé à l\'inscription hypothécaire sur l\'immeuble enregistré sous le volume....................................folio........ ............................à la conservation des Titres Fonciers du Burundi à Bujumbura ; sous le numéro d\'ordre général..................................et spécial hypothèque.................................et reçu le...... /......./20.......

			L\'hypothèque est consentie pour une somme de........francs burundais (.........Fbu) et l\'inscription est valide pour une durée de ......mois.

			Elle doit éventuellement être renouvelée avant le ..............


			- Débiteur : ......................................

			- Créancier :......................................

			.'),'','B',false);
		$pdf->Ln(20);


		$pdf->SetFont('Times','',10);
		$pdf->SetFont('Times','B',12);
		
		$pdf->MultiCell(175,5,utf8_decode(' Le Chef de la Circonscription Foncière '	),'','R',false);
		$pdf->MultiCell(140,5,utf8_decode(' à'	),'','R',false);
		$pdf->Cell(155,5,'  BUJUMBURA ',0,1,'R');	
		$pdf->Ln(1);	
		$pdf->Cell(160,5,' (...............................)',0,1,'R');

		
		$pdf->SetFont('Times','',10);



		$pdf->Output('I');
		
	}


	public function autorisation_reunification()
	{

		$pdf = new FPDF();
    // $pdf->AddPage();
    // $pdf->Image(base_url().'upload/background_image/Permit_bg.png',0,0,210, 297);

		$pdf->AddPage('P','A4');

		$pdf->SetFont('Times','B',12);
		$pdf->Cell(60,25,'REPUBLIQUE DU  BURUNDI' ,0,1,'R');
		$pdf->Image(base_url().'upload/logo/logo_pms_document.jpg',20,25,40, 30);
		$pdf->SetY(45);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(60,25,'MINISTERE DE LA JUSTICE ' ,0,1,'R');
		$pdf->SetY(50);
		$pdf->Cell(76,25,'DIRECTION DES TITRES FONCIERS ' ,0,1,'R');


		$pdf->SetY(10);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(185,25,'BUJUMBURA, le '.date('d/m/Y') ,0,1,'R');

		$pdf->SetY(80);
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(8,10,utf8_decode('Réf'),'','R',false);
    // $pdf->Cell(11,10,'Réf' ,0,0,'R');
		$pdf->SetY(80);
		$pdf->SetFont('Times','',10);
		$pdf->Cell(38,10,': 554/        /2012/M ' ,0,0,'R');

		$pdf->SetY(100);
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(170,10,utf8_decode('A Madame NDABAHAGAMYE Christine'),'','R',false);
		$pdf->SetY(105);
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(150,10,utf8_decode('à'),'','R',false);
		$pdf->SetY(110);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(160,10,'BUJUMBURA' ,0,0,'R');
		$pdf->SetY(120);


		$pdf->SetY(125);
		$pdf->SetFont('Times','B',12);
		$pdf->Cell(20,10,'OBJET : ' ,0,0,'R');
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(52,10,utf8_decode('Autorisation de réunification'),'','R',false);
		$pdf->SetY(130);
		$pdf->MultiCell(63,10,utf8_decode('de la parcelle n° 01/1154'),'','R',false);

		$pdf->SetY(135);
		$pdf->MultiCell(70,10,utf8_decode('située à GIKUNGU-RURAL'),'','R',false);

		$pdf->SetY(165);
		$pdf->SetFont('Times','',12);
		$pdf->Cell(20,10,'Madame,' ,0,0,'R');

		$pdf->Ln(15);
		$pdf->SetFont('Times','',12);
		$pdf->MultiCell(187,5,utf8_decode('Faisant suite à votre lettre  du 21/11/2011 par laquelle vous acceptez nos propositions de réunification de vos parcelles pour bien réussir à votre projet, nous avons l\'honneur de porter à votre connaissance que nous marquons notre accord pour ladite réunification.'),'','B',false);

		$pdf->Ln(5);
		$pdf->MultiCell(187,5,utf8_decode('Nous vous demanderions par conséquent de nous transmettre les procès-verbaux d\'arpentage et de bornage dressés postérieurement à la présente autorisation par la Direction du Cadastre National avec approbation de la Direction Générale de l\'Urbanisme et de l\'Habitat pour permettre l\'enregistrement de la parcelle issue de la réunification.'),'','B',false);

		$pdf->Ln(5);
		$pdf->MultiCell(187,5,utf8_decode('Veuillez agréer, Madame, l\'assurance de notre considération distinguée.'),'','B',false);

		$pdf->Ln(30);
		$pdf->SetFont('Times','B',10);
		$pdf->Cell(185,5,'LE DIRECTEUR DES TITRES FONCIERS',0,1,'R');
		$pdf->Ln(5);
		$pdf->SetFont('Times','B',10);
		$pdf->MultiCell(170,5,utf8_decode('Grégoire NKESHIMANA'),'','R',false);
    // $pdf->Cell(170,5,'Grégoire NKESHIMANA',0,1,'R');
		$pdf->Ln(1);

		$pdf->Output('I');
	}


 } 


 ?>