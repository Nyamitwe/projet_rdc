<?php

/**
* @Niyongabo Claude
* DATE  :30/04/2024
* contact: 69641375/niyongaboclaude316@gmail.com
* 
* updated by Nadvaxe2024 on the 04th June 2024
*/


class Liste_Demande_Rdv extends CI_Controller
{
	
	public function __construct(){
		parent::__construct();
		require('fpdf184/fpdf.php');
		// require('fpdf184/fpdf.php');
		// include APPPATH.'third_party/fpdf/pdfinclude/fpdf/mc_table.php';
		// include APPPATH.'third_party/fpdf/pdfinclude/fpdf/pdf_config.php';
	}
	
	function index()
	{		
		
		$this->load->view('Liste_Demande_Rdv_View');
	}


	function liste()
	{
		
		
		$PMS_USER_ID = $this->session->userdata('PMS_USER_ID');
		
		
		$info_user = $this->Model->getOne('pms_user_backend',['USER_BACKEND_ID'=>$PMS_USER_ID]);
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		
		$limit='LIMIT 0,10';
		
		if($_POST['length'] != -1) {
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		
		
		$query_principal="SELECT
		pms_demandeur_audience.`ID_DEMANDEUR_AUDIENCE`,
		pms_demandeur_audience.`NOM_PRENOM`,
		pms_demandeur_audience.`TELEPHONE`,
		pms_demandeur_audience.`EMAIL`,
		pms_demandeur_audience.`NUM_CNI`,
		pms_demandeur_audience.CATHEGORIE_DEMANDEUR,
		profession.DESCR_PROFESSION,
		pms_type_demande_audience.DESC_TYPE_DEMANDE_AUDIENCE,
		pms_demandeur_audience.TYPE_INITIATION_DEMANDE,
		pms_demandeur_audience.RAISON_SOCIALE,
		pms_demandeur_audience.RC
		FROM
		`pms_demandeur_audience`
		LEFT JOIN pms_type_demande_audience ON pms_demandeur_audience.ID_OBJET_VISITE = pms_type_demande_audience.ID_TYPE_DEMANDE_AUDIENCE
		LEFT JOIN profession ON pms_demandeur_audience.ID_FONCTION = profession.ID_PROFESSION
		WHERE
		1
		AND pms_demandeur_audience.TYPE_INITIATION_DEMANDE !=1";
		// $query_principal="SELECT * FROM pms_demandeur_audience";
		
		$order_column=array("NOM_PRENOM","TELEPHONE","EMAIL","NUM_CNI","DESCR_PROFESSION","DESC_TYPE_DEMANDE_AUDIENCE");
		
		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY trait_demande.ID_DEMANDEUR_AUDIENCE  ASC';
		
		
		$search = !empty($_POST['search']['value']) ? (" AND (NOM_PRENOM LIKE '%$var_search%' OR TELEPHONE LIKE '%$var_search%' OR EMAIL LIKE '%$var_search%' OR NUM_CNI LIKE '%$var_search%' OR DESCR_PROFESSION LIKE '%$var_search%' OR DESC_TYPE_DEMANDE_AUDIENCE LIKE '%$var_search%')") : '';
		
		
		$critaire="";
		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;
		
		$fetch_data= $this->Model->datatable($query_secondaire);
		 // print_r($fetch_data);die();
		$data = array();
		$u=0;
		
		foreach ($fetch_data as $row) {
		$rdv_donne=$this->Model->getRequete("SELECT `ID_TRAITEMENT_AUDIENCE` FROM `pms_traitement_audience` WHERE ID_DEMANDEUR_AUDEINCE='".$row->ID_DEMANDEUR_AUDIENCE."'");
		 // if (empty($rdv_donne)) {
		
			$u++;
			$sub_array = array();
			$sub_array[]=$u;
			
			$sub_array[]= '<b>RDV-0'.$row->ID_DEMANDEUR_AUDIENCE.'</b>';
			$nom_prenom="N/A";
			$contact="N/A";
			if ($row->CATHEGORIE_DEMANDEUR==1) {
				$nom_prenom=$row->NOM_PRENOM;
				$contact=$row->TELEPHONE.'<br>'.$row->NUM_CNI;
			}elseif ($row->CATHEGORIE_DEMANDEUR==5) {
				$nom_prenom=$row->RAISON_SOCIALE;
				$contact=$row->TELEPHONE.'<br>'.$row->RC;
			}
			$sub_array[]=$nom_prenom;
			$sub_array[]=$row->DESC_TYPE_DEMANDE_AUDIENCE;
			$sub_array[]=$contact; 
			
			$option = '<a  href="'.base_url('administration/Liste_Demande_Rdv/detail/'.md5($row->ID_DEMANDEUR_AUDIENCE)).'" class="btn btn-info btn-sm">'.lang('titre_table_btn_view').' <span class="fa fa-eye"></span></a>';
			
			
			$sub_array[]=$option;    
			
			$data[] = $sub_array;
		// }
		}
		
		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" =>$this->Model->all_data($query_principal),
			"recordsFiltered" => $this->Model->filtrer($query_filter),
			"data" => $data
		);
		
		echo json_encode($output);
	}
	
	function detail($id)
	{
		
	$data['infos']=$this->Model->getRequeteOne('SELECT
    pms_demandeur_audience.`ID_DEMANDEUR_AUDIENCE`,
    pms_demandeur_audience.`NOM_PRENOM`,
    pms_demandeur_audience.`TELEPHONE`,
    pms_demandeur_audience.`EMAIL`,
    pms_demandeur_audience.`NUM_CNI`,
    pms_demandeur_audience.`ADRESSE_PHYSIQUE`,
    profession.DESCR_PROFESSION,
    pms_type_demande_audience.DESC_TYPE_DEMANDE_AUDIENCE,
    pms_demandeur_audience.`MOTIF_URGENCE`,
    pms_demandeur_audience.`DISPOSITION_TITRE`,
    pms_demandeur_audience.`VOLUME`,
    pms_demandeur_audience.`FOLIO`,
    pms_demandeur_audience.NUMERO_PARCELLE,
    pms_demandeur_audience.DOC_PDF_TITRE,
    pms_demandeur_audience.DATE_INSERTION,
    pms_type_demandeur_visite.DESC_TYPE_VISITE,
    sf_guard_user_categories.name AS PROFILESS
FROM
    `pms_demandeur_audience`
JOIN pms_type_demande_audience ON pms_demandeur_audience.ID_OBJET_VISITE = pms_type_demande_audience.ID_TYPE_DEMANDE_AUDIENCE
LEFT JOIN profession ON pms_demandeur_audience.ID_FONCTION = profession.ID_PROFESSION
JOIN pms_type_demandeur_visite ON pms_demandeur_audience.ID_TYPE_DEMANDEUR_AUDIENCE = pms_type_demandeur_visite.ID_TYPE_VISITE
LEFT JOIN sf_guard_user_categories ON sf_guard_user_categories.id = pms_demandeur_audience.CATHEGORIE_DEMANDEUR
WHERE
    1  
     and md5(ID_DEMANDEUR_AUDIENCE)="'.$id.'"');
	$rdv_donne=$this->Model->getRequete("SELECT `ID_TRAITEMENT_AUDIENCE` FROM `pms_traitement_audience` WHERE md5(ID_DEMANDEUR_AUDEINCE)='".$id."'");


		$data['rdv_deja_donne']=0;
		if (!empty($rdv_donne)) {
			$data['rdv_deja_donne']=0;
		}else{
			$data['rdv_deja_donne']=0;
		}
		
		
		$this->load->view('Detail_Demande_Rdv_View',$data);
		
	}
	
	public function tache($value='')
	{
		
		$data['service']=$this->Model->getRequete('SELECT * from pms_service order by DESCRIPTION');

		$data['demand']=$this->Model->getRequeteOne('SELECT ID_DEMANDEUR_AUDIENCE, date_format(DATE_INSERTION,"%d-%m-%Y") as DATE_INSERTIONN  from pms_demandeur_audience where md5(ID_DEMANDEUR_AUDIENCE)="'.$value.'"');

		$data['DATE_DEMANDE'] = $data['demand']['DATE_INSERTIONN']; 
		$rdv_donne=$this->Model->getRequete("SELECT `ID_TRAITEMENT_AUDIENCE` FROM `pms_traitement_audience` WHERE md5(ID_DEMANDEUR_AUDEINCE)='".$value."'");

		$data['rdv_deja_donne']=0;
		if (!empty($rdv_donne)) {
			$data['rdv_deja_donne']=1;
		}else{
			$data['rdv_deja_donne']=0;
		}
 
			
		$this->load->view('Rdv_Rdv_View',$data);
		
	}
	
	public function get_poste($value='')
	{
		$ID_SERVICE=$this->input->post('SERVICE_ID');
		//   $PROCESS_ID=$this->input->post('PROCESS_ID');
		
		$poste=$this->Model->getRequete('SELECT * from pms_poste_service where ID_SERVICE='.$ID_SERVICE.' order by POSTE_DESCR');
		
		$html='<option>Séléctionner</option>';
		
		foreach ($poste as $key => $value) 
		{
			
			$html.='<option value="'.$value['ID_POSTE'].'">'.$value['POSTE_DESCR'].'</option>';
		}
		echo $html;
	}
	
	
	
	public function traiter_rdv()
	{
		
		$SERVICE_ID=$this->input->post('SERVICE_ID');
		$ID_POSTE=$this->input->post('ID_POSTE');
		$RDV_DATE=$this->input->post('RDV_DATE');
		$ID_DEMANDEUR_AUDIENCE=$this->input->post('ID_DEMANDEUR_AUDIENCE');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('ID_POSTE','','trim|required',array('required'=>'<font style="color:red;font-size:14px;">Le poste est obligatoire</font>'));
	
		if (empty($ID_POSTE)) 
		{ 
			$this->tache(md5($ID_DEMANDEUR_AUDIENCE));
		}else{
		$formattedDate = date("Y-m-d", strtotime($RDV_DATE));
		$test=$this->Model->getRequeteOne('SELECT count(*) as nbr_rdv from pms_traitement_audience where JOUR_AUDIENCE="'.$formattedDate.'" and ID_POSTE='.$ID_POSTE.'');
		 // print_r($test['nbr_rdv']);die();
		
		if ($test['nbr_rdv'] < 40) {
			if ($test['nbr_rdv'] < 21) {
				$heure="8H00";
			}else if ($test['nbr_rdv'] > 20 AND $test['nbr_rdv'] < 31){
				$heure="9H30";
			}else{
				$heure="11H00";
			}
			$array_tosave=array('ID_DEMANDEUR_AUDEINCE'=>$ID_DEMANDEUR_AUDIENCE,'JOUR_AUDIENCE'=>$formattedDate,'HEURE_AUDIENCE '=>$heure,'SERVICE_ID'=>$SERVICE_ID,'ID_POSTE'=>$ID_POSTE);
			$id=$this->Model->insert_last_id('pms_traitement_audience',$array_tosave);
			$req = $this->Model->getRequeteOne('SELECT NOM_PRENOM, EMAIL,CATHEGORIE_DEMANDEUR,RAISON_SOCIALE FROM pms_demandeur_audience  WHERE ID_DEMANDEUR_AUDIENCE='.$ID_DEMANDEUR_AUDIENCE.'');
			if ($req['CATHEGORIE_DEMANDEUR']==5) 
			{
				$nom=$req['RAISON_SOCIALE'];
			} else {
				$nom=$req['NOM_PRENOM'];
			}

			$subject = "Confirmation de votre demande de rendez-vous";
			$message = 'Monsieur/Madame <b> '.trim($nom).'</b>,<br><br>
			Votre rendez-vous a été programmé pour le '.date('d-m-Y', strtotime($RDV_DATE)).' à '.$heure.'<br><br>
			Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br>
			Veuillez télécharger votre certificat de demande d’audience en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.md5($id)).'">Document à télécharger</a>.<br><br>
			Cordialement.';

			$mailTo = $req['EMAIL'];
			$sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);

			if ($sending) {
			    $data['message'] = '<div class="alert alert-success text-center" id="message">L\'Opération faite et message envoyé avec succès.</div>';
			} else {
			    $data['message'] = '<div class="alert alert-danger text-center" id="message">L\'Opération faite et message échoué.</div>';
			}

			$this->session->set_flashdata($data);

			redirect(base_url('administration/Liste_Demande_Rdv'));
			
		}else{
			
			$data['message']='<div class="alert alert-danger text-center" id="message">Le nombre de rdv pour le '.$RDV_DATE.' a atteint son maximum. <br> Veuillez choisir une autre date. </div>';
			$this->session->set_flashdata($data);
			
			$this->tache(md5($ID_DEMANDEUR_AUDIENCE));
			
		} 
		  }
			
	}

	    //certificat de demande de rdv
		public function Document_Pdf($id)
		{ 
			$red=$this->Model->getRequeteOne("SELECT pms_traitement_audience.ID_TRAITEMENT_AUDIENCE,pms_traitement_audience.DATE_LECTURE,pms_traitement_audience.STATUT_MAIL FROM `pms_traitement_audience` WHERE md5(ID_TRAITEMENT_AUDIENCE)='".$id."'");
			if (empty($red['DATE_LECTURE']) && $red['STATUT_MAIL']!=2) 
			{
			     $donnee = array(
				'STATUT_MAIL' => 2,
				'DATE_LECTURE' => date('Y-m-d h:i:s')
			     );


			  $updating = $this->Model->update('pms_traitement_audience', array('md5(ID_TRAITEMENT_AUDIENCE)' => $id), $donnee);
			}
		$req_infos=$this->Model->getRequeteOne('SELECT pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE,pms_process.DESCRIPTION_PROCESS, pms_traitement_audience.ID_TRAITEMENT_AUDIENCE,pms_demandeur_audience.CATHEGORIE_DEMANDEUR,pms_demandeur_audience.RAISON_SOCIALE,genre.GENRE, pms_demandeur_audience.NOM_PRENOM,pms_demandeur_audience.TELEPHONE,pms_demandeur_audience.EMAIL,pms_traitement_audience.JOUR_AUDIENCE ,pms_traitement_audience.HEURE_AUDIENCE,pms_demandeur_audience.TYPE_INITIATION_DEMANDE,pms_traitement_audience.STATUT_SCANNER,pms_demandeur_audience.DATE_INSERTION FROM `pms_demandeur_audience`LEFT JOIN pms_traitement_audience on pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE LEFT JOIN pms_process ON pms_process.PROCESS_ID=pms_demandeur_audience.ID_OBJET_VISITE left JOIN genre ON genre.GENRE_ID=pms_demandeur_audience.SEXE_ID WHERE md5(pms_traitement_audience.ID_TRAITEMENT_AUDIENCE)="'.$id.'" ');
		
			if ($req_infos['CATHEGORIE_DEMANDEUR']==5) 
			{
				$nom=$req_infos['RAISON_SOCIALE'];
			} 
			else 
			{
				$nom=$req_infos['NOM_PRENOM'];
			}

			if (empty($req_infos)) {
		     	  redirect(base_url('Rendez_vous/absolete'));
		     }else {
		  $dateString = $req_infos['JOUR_AUDIENCE'];
		  $date = DateTime::createFromFormat('Y-m-d', $dateString);
		  // $formattedDate = date_format($date, 'd-m-Y');
		  $formattedDate = date_format($date, 'd-m-Y').' à '.$req_infos['HEURE_AUDIENCE'];

		 // $formattedDate = "2024-05-14";

		 $pdf = new FPDF();
		 $pdf->AddPage();
	
		 $src_file = 'uploads/rdv/';
	   
		 if(!is_dir($src_file)){
		  mkdir($src_file ,0777 ,TRUE);
		 }

		//  print_r($req_infos);die();

		 if ($req_infos['CATHEGORIE_DEMANDEUR']==1) 
		 {	
		 	if ($req_infos['STATUT_SCANNER'] == 0 && $req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		 	 {
		 	  //nvlle audiance  
		 	   $pdf->Image(FCPATH.'uploads/logo/certi_audi_pour_physique.jpg',0,0,210, 297);
		      
		      } else if($req_infos['STATUT_SCANNER'] == 2 && $req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_report_audi_pour_physique.jpg',0,0,210, 297);
		 	//report audiance
		      } else if ($req_infos['STATUT_SCANNER'] == 0 && $req_infos['TYPE_INITIATION_DEMANDE'] == 2) 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_rdv_pour_physique.jpg',0,0,210, 297);
		 	//nvlle rdv
		      } else 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_report_rdv_pour_physique.jpg',0,0,210, 297);
		 	//report rdv
		      }


		 $pdf->Ln(5);
		 $pdf->SetFont('Times','B',12);
		 $pdf->Cell(175,6,'Bujumbura le,'.date('d/m/Y') ,0,1,'R');
		 //,strtotime($passport['datecreation'])
		 $pdf->SetFont('Times','B',12);
		 $pdf->Ln(42);
		 $pdf->SetX(20);
		 $pdf->SetTextColor(255,255,255);
	   
		 $pdf->SetTextColor(0,0,0);
		 $pdf->SetFont('Times','',10);
	
	
		 $pdf->Ln(80);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,50,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,-55,utf8_decode("".$nom.""),'C',false);
		 
		 $pdf->Ln(26);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(101,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,2,utf8_decode("RDV-".$req_infos['ID_DEMANDEUR_AUDIENCE'].""),'C',false);
	
		 $pdf->Ln(26);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(305,2,utf8_decode("".$req_infos['GENRE'].""),'C',false);


		 $pdf->Ln(-16); 

		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(305,2,utf8_decode("".$req_infos['EMAIL'].""),'C',false);

		 $pdf->Ln(12);
		 if ($req_infos['CATHEGORIE_DEMANDEUR']==1) 
		 {
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(305,2,utf8_decode("".$req_infos['GENRE'].""),'C',false);
		 }
		 $pdf->Ln(13);

		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(305,2,utf8_decode("".$req_infos['HEURE_AUDIENCE'].""),'C',false);

		 $pdf->Ln(25);
		 $i=0;
		 // $info_qrcode='NOM ET PRENOM : '.$nom."\n".'E-MAIL : '.$req_infos['EMAIL']."\n".'CODE DEMANDE :  '.$req_infos['ID_DEMANDEUR_AUDIENCE']."\n".'OBJET :  '.$req_infos['DESCRIPTION_PROCESS']."\n".' '.'DATE RENDEZ VOUS :  '.$req_infos['JOUR_AUDIENCE'].'  '.'HEURE:'.$req_infos['HEURE_AUDIENCE'].'';

		 $info_qrcode=base_url('Infos_qrcode_rdv/index/'.$id.'');

		 $val= $req_infos['ID_DEMANDEUR_AUDIENCE'];
		 $this->notifications->generateQrcode($info_qrcode,$val);
		 // $val= $val++;
		 $qrcode_name = $val.'.png';
		 if(file_exists(FCPATH . 'uploads/qrcode/'.$qrcode_name))
		 {
		 	$pdf->Image(FCPATH . 'uploads/qrcode/'.$qrcode_name,73,168,65,0);
		 }
		 $pdf->Ln(-56);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(101,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,5,utf8_decode("".$req_infos['TELEPHONE'].""),'C',false);

		  $pdf->Ln(9);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(101,7,utf8_decode(""),0,'C');
		 // $pdf->MultiCell(300,5,utf8_decode("".$req_infos['JOUR_AUDIENCE'].""),'C',false);
		 $pdf->MultiCell(300, 5, utf8_decode(date('d-m-Y', strtotime($req_infos['DATE_INSERTION']))) , 'C', false);

		 $pdf->Ln(9);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(101,7,utf8_decode(""),0,'C');
		 // $pdf->MultiCell(300,5,utf8_decode("".$req_infos['JOUR_AUDIENCE'].""),'C',false);
		 $pdf->MultiCell(300, 5, utf8_decode(date('d-m-Y', strtotime($req_infos['JOUR_AUDIENCE']))) , 'C', false);

		 

		 $pdf->Ln(101);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(94,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,5,utf8_decode("".$req_infos['ID_DEMANDEUR_AUDIENCE']."-"."".$req_infos['JOUR_AUDIENCE'].""),'C',false);
		 if ($req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		 {
		 	$name_file = "AUD-" . $req_infos['ID_DEMANDEUR_AUDIENCE'] . "confirmed.pdf";
		 }
		 else
		 {
		 	$name_file = "RDV-" . $req_infos['ID_DEMANDEUR_AUDIENCE'] . "confirmed.pdf";
		 }
		
		 
		  $this->Model->update('pms_traitement_audience',array('md5(ID_TRAITEMENT_AUDIENCE)'=>$id),array('DOC_CERTIFICAT_RENDEZ_VOUS'=>$name_file));	

			 $pdf->Output('I');
		 
		}
		 else
		{
		 	if ($req_infos['STATUT_SCANNER'] == 0 && $req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		 	 {
		 	  //nvlle audiance
		 	   $pdf->Image(FCPATH.'uploads/logo/certi_audi_pour_morale.jpg',0,0,210, 297);
		      } else if($req_infos['STATUT_SCANNER'] == 2 && $req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_report_audi_pour_morale.jpg',0,0,210, 297);
		 	//report audiance
		      } else if ($req_infos['STATUT_SCANNER'] == 0 && $req_infos['TYPE_INITIATION_DEMANDE'] == 2) 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_rdv_pour_morale.jpg',0,0,210, 297);
		 	//nvlle rdv
		      } else 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_report_rdv_pour_morale.jpg',0,0,210, 297);
		 	//report rdv
		      }
		  $pdf->Ln(5);
		 $pdf->SetFont('Times','B',12);
		 $pdf->Cell(175,6,'Bujumbura le,'.date('d/m/Y') ,0,1,'R');
		 //,strtotime($passport['datecreation'])
		 $pdf->SetFont('Times','B',12);
		 $pdf->Ln(40);
		 $pdf->SetTextColor(255,255,255);
	   
		 $pdf->SetTextColor(0,0,0);
		 $pdf->SetFont('Times','',10);
	
	
		 $pdf->Ln(82);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,50,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,-55,utf8_decode("".$nom.""),'C',false);
		 
		 $pdf->Ln(26);
		 $pdf->SetX($pdf->GetX() + 20);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(82,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,2,utf8_decode("RDV-".$req_infos['ID_DEMANDEUR_AUDIENCE'].""),'C',false);
	
		 $pdf->Ln(12);
		//  $pdf->SetFont('Times','B',14);
		//  $pdf->Cell(20,7,utf8_decode(""),0,'C');
		//  $pdf->MultiCell(305,2,utf8_decode(""),'C',false);

		//  $pdf->Ln(-16); 

		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(305,2,utf8_decode("".$req_infos['EMAIL'].""),'C',false);

		 $pdf->Ln(12);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C'); 
		 $pdf->MultiCell(305,4,utf8_decode("".$req_infos['HEURE_AUDIENCE'].""),'C',false);
		 
		 $pdf->Ln(-60);

		//  $pdf->SetFont('Times','B',14);
		//  $pdf->Cell(20,7,utf8_decode(""),0,'C');
		//  $pdf->MultiCell(305,2,utf8_decode(""),'C',false);

		//  $pdf->Ln(25);
		 $i=0;
		 // $info_qrcode='NOM ET PRENOM : '.$nom."\n".'E-MAIL : '.$req_infos['EMAIL']."\n".'CODE DEMANDE :  '.$req_infos['ID_DEMANDEUR_AUDIENCE']."\n".'OBJET :  '.$req_infos['DESCRIPTION_PROCESS']."\n".' '.'DATE RENDEZ VOUS :  '.$req_infos['JOUR_AUDIENCE'].'  '.'HEURE:'.$req_infos['HEURE_AUDIENCE'].'';

		 $info_qrcode=base_url('Infos_qrcode_rdv/index/'.$id.'');


		 $val= $req_infos['ID_DEMANDEUR_AUDIENCE'];
		 $this->notifications->generateQrcode($info_qrcode,$val);
		 // $val= $val++;
		 $qrcode_name = $val.'.png';
		 if(file_exists(FCPATH . 'uploads/qrcode/'.$qrcode_name))
		 {
		 	$pdf->Image(FCPATH . 'uploads/qrcode/'.$qrcode_name,74,170,61,0);
		 }
		 $pdf->Ln(40);
		 $pdf->SetX($pdf->GetX() + 20);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(82,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,5,utf8_decode("".$req_infos['TELEPHONE'].""),'C',false);

		 $pdf->Ln(10);
		 $pdf->SetX($pdf->GetX() + 20);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(82,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300, 5, utf8_decode(date('d-m-Y', strtotime($req_infos['DATE_INSERTION']))) , 'C', false);

		 $pdf->Ln(10);
		 $pdf->SetX($pdf->GetX() + 20);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(82,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300, 5, utf8_decode(date('d-m-Y', strtotime($req_infos['JOUR_AUDIENCE']))) , 'C', false);

		 $pdf->Ln(101);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(94,7,utf8_decode(""),0,'C');
         $pdf->MultiCell(300,5,utf8_decode("".$req_infos['ID_DEMANDEUR_AUDIENCE']."".date('Ymd', strtotime($req_infos['JOUR_AUDIENCE']))),'C',false);		 if ($req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		 {
		 	$name_file = "AUD-" . $req_infos['ID_DEMANDEUR_AUDIENCE'] . "confirmed.pdf";
		 }
		 else
		 {
		 	$name_file = "RDV-" . $req_infos['ID_DEMANDEUR_AUDIENCE'] . "confirmed.pdf";
		 }
		
		 
		  $this->Model->update('pms_traitement_audience',array('md5(ID_TRAITEMENT_AUDIENCE)'=>$id),array('DOC_CERTIFICAT_RENDEZ_VOUS'=>$name_file));	

			 $pdf->Output('I');

		}
	
}
}
	  public function Document_Pdf_V($id)
		{
			$red=$this->Model->getRequeteOne("SELECT pms_traitement_audience.ID_TRAITEMENT_AUDIENCE,pms_traitement_audience.DATE_LECTURE,pms_traitement_audience.STATUT_MAIL FROM `pms_traitement_audience` WHERE md5(ID_TRAITEMENT_AUDIENCE)='".$id."'");
			if (empty($red['DATE_LECTURE']) && $red['STATUT_MAIL']!=2) 
			{
			     $donnee = array(
				'STATUT_MAIL' => 2,
				'DATE_LECTURE' => date('Y-m-d h:i:s')
			     );


			  $updating = $this->Model->update('pms_traitement_audience', array('md5(ID_TRAITEMENT_AUDIENCE)' => $id), $donnee);
			}
		$req_infos=$this->Model->getRequeteOne('SELECT pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE,pms_process.DESCRIPTION_PROCESS, pms_traitement_audience.ID_TRAITEMENT_AUDIENCE,pms_demandeur_audience.CATHEGORIE_DEMANDEUR,pms_demandeur_audience.RAISON_SOCIALE,genre.GENRE, pms_demandeur_audience.NOM_PRENOM,pms_demandeur_audience.TELEPHONE,pms_demandeur_audience.EMAIL,pms_traitement_audience.JOUR_AUDIENCE ,pms_traitement_audience.HEURE_AUDIENCE,pms_demandeur_audience.TYPE_INITIATION_DEMANDE,pms_traitement_audience.STATUT_SCANNER,pms_demandeur_audience.DATE_INSERTION FROM `pms_demandeur_audience`LEFT JOIN pms_traitement_audience on pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE LEFT JOIN pms_process ON pms_process.PROCESS_ID=pms_demandeur_audience.ID_OBJET_VISITE left JOIN genre ON genre.GENRE_ID=pms_demandeur_audience.SEXE_ID WHERE md5(pms_traitement_audience.ID_TRAITEMENT_AUDIENCE)="'.$id.'" ');
		
			if ($req_infos['CATHEGORIE_DEMANDEUR']==5) 
			{
				$nom=$req_infos['RAISON_SOCIALE'];
			} 
			else 
			{
				$nom=$req_infos['NOM_PRENOM'];
			}

			if (empty($req_infos)) {
		     	  redirect(base_url('Rendez_vous/absolete'));
		     }else {
		  $dateString = $req_infos['JOUR_AUDIENCE'];
		  $date = DateTime::createFromFormat('Y-m-d', $dateString);
		  // $formattedDate = date_format($date, 'd-m-Y');
		  $formattedDate = date_format($date, 'd-m-Y').' à '.$req_infos['HEURE_AUDIENCE'];

		 // $formattedDate = "2024-05-14";

		 $pdf = new FPDF();
		 $pdf->AddPage();
	
		 $src_file = 'uploads/rdv/';
	   
		 if(!is_dir($src_file)){
		  mkdir($src_file ,0777 ,TRUE);
		 }

		//  print_r($req_infos);die();

		 if ($req_infos['CATHEGORIE_DEMANDEUR']==1) 
		 {	
		 	if ($req_infos['STATUT_SCANNER'] == 0 && $req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		 	 {
		 	  //nvlle audiance  
		 	   $pdf->Image(FCPATH.'uploads/logo/certi_audi_pour_physique.jpg',0,0,210, 297);
		      
		      } else if($req_infos['STATUT_SCANNER'] == 2 && $req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_report_audi_pour_physique.jpg',0,0,210, 297);
		 	//report audiance
		      } else if ($req_infos['STATUT_SCANNER'] == 0 && $req_infos['TYPE_INITIATION_DEMANDE'] == 2) 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_rdv_pour_physique.jpg',0,0,210, 297);
		 	//nvlle rdv
		      } else 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_report_rdv_pour_physique.jpg',0,0,210, 297);
		 	//report rdv
		      }


		 $pdf->Ln(5);
		 $pdf->SetFont('Times','B',12);
		 $pdf->Cell(175,6,'Bujumbura le,'.date('d/m/Y') ,0,1,'R');
		 //,strtotime($passport['datecreation'])
		 $pdf->SetFont('Times','B',12);
		 $pdf->Ln(42);
		 $pdf->SetX(20);
		 $pdf->SetTextColor(255,255,255);
	   
		 $pdf->SetTextColor(0,0,0);
		 $pdf->SetFont('Times','',10);
	
	
		 $pdf->Ln(80);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,50,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,-55,utf8_decode("".$nom.""),'C',false);
		 
		 $pdf->Ln(26);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(101,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,2,utf8_decode("RDV-".$req_infos['ID_DEMANDEUR_AUDIENCE'].""),'C',false);
	
		 $pdf->Ln(26);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(305,2,utf8_decode("".$req_infos['GENRE'].""),'C',false);


		 $pdf->Ln(-16); 

		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(305,2,utf8_decode("".$req_infos['EMAIL'].""),'C',false);

		 $pdf->Ln(12);
		 if ($req_infos['CATHEGORIE_DEMANDEUR']==1) 
		 {
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(305,2,utf8_decode("".$req_infos['GENRE'].""),'C',false);
		 }
		 $pdf->Ln(13);

		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(305,2,utf8_decode("".$req_infos['HEURE_AUDIENCE'].""),'C',false);

		 $pdf->Ln(25);
		 $i=0;
		 // $info_qrcode='NOM ET PRENOM : '.$nom."\n".'E-MAIL : '.$req_infos['EMAIL']."\n".'CODE DEMANDE :  '.$req_infos['ID_DEMANDEUR_AUDIENCE']."\n".'OBJET :  '.$req_infos['DESCRIPTION_PROCESS']."\n".' '.'DATE RENDEZ VOUS :  '.$req_infos['JOUR_AUDIENCE'].'  '.'HEURE:'.$req_infos['HEURE_AUDIENCE'].'';

		 $info_qrcode=base_url('Infos_qrcode_rdv/index/'.$id.'');

		 $val= $req_infos['ID_DEMANDEUR_AUDIENCE'];
		 $this->notifications->generateQrcode($info_qrcode,$val);
		 // $val= $val++;
		 $qrcode_name = $val.'.png';
		 if(file_exists(FCPATH . 'uploads/qrcode/'.$qrcode_name))
		 {
		 	$pdf->Image(FCPATH . 'uploads/qrcode/'.$qrcode_name,73,168,65,0);
		 }
		 $pdf->Ln(-56);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(101,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,5,utf8_decode("".$req_infos['TELEPHONE'].""),'C',false);

		  $pdf->Ln(9);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(101,7,utf8_decode(""),0,'C');
		 // $pdf->MultiCell(300,5,utf8_decode("".$req_infos['JOUR_AUDIENCE'].""),'C',false);
		 $pdf->MultiCell(300, 5, utf8_decode(date('d-m-Y', strtotime($req_infos['DATE_INSERTION']))) , 'C', false);

		 $pdf->Ln(9);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(101,7,utf8_decode(""),0,'C');
		 // $pdf->MultiCell(300,5,utf8_decode("".$req_infos['JOUR_AUDIENCE'].""),'C',false);
		 $pdf->MultiCell(300, 5, utf8_decode(date('d-m-Y', strtotime($req_infos['JOUR_AUDIENCE']))) , 'C', false);

		 

		 $pdf->Ln(101);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(94,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,5,utf8_decode("".$req_infos['ID_DEMANDEUR_AUDIENCE']."-"."".$req_infos['JOUR_AUDIENCE'].""),'C',false);
		 if ($req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		 {
		 	$name_file = "AUD-" . $req_infos['ID_DEMANDEUR_AUDIENCE'] . "confirmed.pdf";
		 }
		 else
		 {
		 	$name_file = "RDV-" . $req_infos['ID_DEMANDEUR_AUDIENCE'] . "confirmed.pdf";
		 }
		
		 
		  $this->Model->update('pms_traitement_audience',array('md5(ID_TRAITEMENT_AUDIENCE)'=>$id),array('DOC_CERTIFICAT_RENDEZ_VOUS'=>$name_file));	

			 $pdf->Output('I');
		 
		}
		 else
		{
		 	if ($req_infos['STATUT_SCANNER'] == 0 && $req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		 	 {
		 	  //nvlle audiance
		 	   $pdf->Image(FCPATH.'uploads/logo/certi_audi_pour_morale.jpg',0,0,210, 297);
		      } else if($req_infos['STATUT_SCANNER'] == 2 && $req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_report_audi_pour_morale.jpg',0,0,210, 297);
		 	//report audiance
		      } else if ($req_infos['STATUT_SCANNER'] == 0 && $req_infos['TYPE_INITIATION_DEMANDE'] == 2) 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_rdv_pour_morale.jpg',0,0,210, 297);
		 	//nvlle rdv
		      } else 
		      {
		      	$pdf->Image(FCPATH.'uploads/logo/certi_report_rdv_pour_morale.jpg',0,0,210, 297);
		 	//report rdv
		      }
		  $pdf->Ln(5);
		 $pdf->SetFont('Times','B',12);
		 $pdf->Cell(175,6,'Bujumbura le,'.date('d/m/Y') ,0,1,'R');
		 //,strtotime($passport['datecreation'])
		 $pdf->SetFont('Times','B',12);
		 $pdf->Ln(40);
		 $pdf->SetTextColor(255,255,255);
	   
		 $pdf->SetTextColor(0,0,0);
		 $pdf->SetFont('Times','',10);
	
	
		 $pdf->Ln(82);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,50,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,-55,utf8_decode("".$nom.""),'C',false);
		 
		 $pdf->Ln(26);
		 $pdf->SetX($pdf->GetX() + 20);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(82,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,2,utf8_decode("RDV-".$req_infos['ID_DEMANDEUR_AUDIENCE'].""),'C',false);
	
		 $pdf->Ln(12);
		//  $pdf->SetFont('Times','B',14);
		//  $pdf->Cell(20,7,utf8_decode(""),0,'C');
		//  $pdf->MultiCell(305,2,utf8_decode(""),'C',false);

		//  $pdf->Ln(-16); 

		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(305,2,utf8_decode("".$req_infos['EMAIL'].""),'C',false);

		 $pdf->Ln(12);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(20,7,utf8_decode(""),0,'C'); 
		 $pdf->MultiCell(305,4,utf8_decode("".$req_infos['HEURE_AUDIENCE'].""),'C',false);
		 
		 $pdf->Ln(-60);

		//  $pdf->SetFont('Times','B',14);
		//  $pdf->Cell(20,7,utf8_decode(""),0,'C');
		//  $pdf->MultiCell(305,2,utf8_decode(""),'C',false);

		//  $pdf->Ln(25);
		 $i=0;
		 // $info_qrcode='NOM ET PRENOM : '.$nom."\n".'E-MAIL : '.$req_infos['EMAIL']."\n".'CODE DEMANDE :  '.$req_infos['ID_DEMANDEUR_AUDIENCE']."\n".'OBJET :  '.$req_infos['DESCRIPTION_PROCESS']."\n".' '.'DATE RENDEZ VOUS :  '.$req_infos['JOUR_AUDIENCE'].'  '.'HEURE:'.$req_infos['HEURE_AUDIENCE'].'';

		 $info_qrcode=base_url('Infos_qrcode_rdv/index/'.$id.'');


		 $val= $req_infos['ID_DEMANDEUR_AUDIENCE'];
		 $this->notifications->generateQrcode($info_qrcode,$val);
		 // $val= $val++;
		 $qrcode_name = $val.'.png';
		 if(file_exists(FCPATH . 'uploads/qrcode/'.$qrcode_name))
		 {
		 	$pdf->Image(FCPATH . 'uploads/qrcode/'.$qrcode_name,74,170,61,0);
		 }
		 $pdf->Ln(40);
		 $pdf->SetX($pdf->GetX() + 20);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(82,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,5,utf8_decode("".$req_infos['TELEPHONE'].""),'C',false);

		 $pdf->Ln(10);
		 $pdf->SetX($pdf->GetX() + 20);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(82,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300, 5, utf8_decode(date('d-m-Y', strtotime($req_infos['DATE_INSERTION']))) , 'C', false);

		 $pdf->Ln(10);
		 $pdf->SetX($pdf->GetX() + 20);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(82,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300, 5, utf8_decode(date('d-m-Y', strtotime($req_infos['JOUR_AUDIENCE']))) , 'C', false);

		 $pdf->Ln(101);
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(94,7,utf8_decode(""),0,'C');
         $pdf->MultiCell(300,5,utf8_decode("".$req_infos['ID_DEMANDEUR_AUDIENCE']."".date('Ymd', strtotime($req_infos['JOUR_AUDIENCE']))),'C',false);		 if ($req_infos['TYPE_INITIATION_DEMANDE'] == 1) 
		 {
		 	$name_file = "AUD-" . $req_infos['ID_DEMANDEUR_AUDIENCE'] . "confirmed.pdf";
		 }
		 else
		 {
		 	$name_file = "RDV-" . $req_infos['ID_DEMANDEUR_AUDIENCE'] . "confirmed.pdf";
		 }
		
		 
		  $this->Model->update('pms_traitement_audience',array('md5(ID_TRAITEMENT_AUDIENCE)'=>$id),array('DOC_CERTIFICAT_RENDEZ_VOUS'=>$name_file));	

			 $pdf->Output('I');

		}
	
}}
}

