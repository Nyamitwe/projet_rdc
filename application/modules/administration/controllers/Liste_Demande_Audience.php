<?php

/**
* @NTWARI Raoul
* DATE  :26/04/2024
* contact: 71246149/rantwari@gmail.com
* 
* Cette class a pour role de lister toute les demandes d'audience
*/
class Liste_Demande_Audience extends CI_Controller
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
		
		$this->load->view('Liste_Demande_Audience_View');
	}
	
	
	
	function liste()
	{
		
		
		$PMS_USER_ID = $this->session->userdata('PMS_USER_ID');
		
		
		$info_user = $this->Model->getOne('pms_user_backend',['USER_BACKEND_ID'=>$PMS_USER_ID]);
		$service_conn=$info_user['SERVICE_ID'];
		$profil_conn=$info_user['PROFIL_ID'];
		  // print_r($info_user);die();
		
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		
		$limit='LIMIT 0,10';
		
		if($_POST['length'] != -1) {
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}

			// $critaire_serv= "";
		    // $critaire_prof= "";
		    // if ($TYPE_SOURCE == 2) {
		    //   $critaire_pro = ' AND pnd_projets.ID_UNITE_GESTION=' . $ID_UGP_CONNECTED . '';
		    // } else if ($TYPE_SOURCE == 3) {
		    //   $critaire_pro = ' AND pnd_projets.ID_UNITE_GESTION_MEMBRE=' . $SOURCE . '';
		    // } else if ($TYPE_SOURCE == 4) {
		    //   $critaire_progra = ' AND pnd_projets.ID_PROGRAMME_BUDGETAIRE=' . $ID_MINISTERE . '';
		    // }

		$query_principal="SELECT
		pms_demandeur_audience.`ID_DEMANDEUR_AUDIENCE`,
		pms_demandeur_audience.`NOM_PRENOM`,
		pms_demandeur_audience.`TELEPHONE`,
		pms_demandeur_audience.`EMAIL`,
		pms_demandeur_audience.`NUM_CNI`,
		profession.DESCR_PROFESSION,
		pms_type_demande_audience.DESC_TYPE_DEMANDE_AUDIENCE
		FROM
		`pms_demandeur_audience`
		JOIN pms_type_demande_audience ON pms_demandeur_audience.ID_OBJET_VISITE = pms_type_demande_audience.ID_TYPE_DEMANDE_AUDIENCE
		JOIN profession ON pms_demandeur_audience.ID_FONCTION = profession.ID_PROFESSION
		WHERE
		1";
		
		$order_column=array("NOM_PRENOM","TELEPHONE","EMAIL","NUM_CNI","DESCR_PROFESSION","DESC_TYPE_DEMANDE_AUDIENCE");
		
		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY trait_demande.ID_DEMANDEUR_AUDIENCE  ASC';
		
		
		$search = !empty($_POST['search']['value']) ? (" AND (NOM_PRENOM LIKE '%$var_search%' OR TELEPHONE LIKE '%$var_search%' OR EMAIL LIKE '%$var_search%' OR NUM_CNI LIKE '%$var_search%' OR DESCR_PROFESSION LIKE '%$var_search%' OR DESC_TYPE_DEMANDE_AUDIENCE LIKE '%$var_search%')") : '';
		
		
		$critaire="";
		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;
		
		$fetch_data= $this->Model->datatable($query_secondaire);
		
		$data = array();
		$u=0;
		
		foreach ($fetch_data as $row) {
			
			
			$u++;
			$sub_array = array();
			
			
			$order_column=array("NOM_PRENOM","TELEPHONE","EMAIL","NUM_CNI","DESCR_PROFESSION","DESC_TYPE_DEMANDE_AUDIENCE");
			
			$sub_array[]= '<b>00'.$row->ID_DEMANDEUR_AUDIENCE.'</b>';
			$sub_array[]='<font><b style="color:AUD-00'.$row->ID_DEMANDEUR_AUDIENCE.'</b><br>'.'<span class="badge badge-light"> 5'.lang('days').'</span><br><span style="font-size:9px;color:gray;"></span></font>';
			$sub_array[]=$row->NOM_PRENOM;
			$sub_array[]=$row->DESC_TYPE_DEMANDE_AUDIENCE;
			$sub_array[]=$row->DESCR_PROFESSION; 
			$sub_array[]=$row->TELEPHONE.'<br>'.$row->EMAIL; 
			$sub_array[]=$row->NUM_CNI; 
			
			$option = '<a  href="'.base_url('administration/Liste_Demande_Audience/detail/'.md5($row->ID_DEMANDEUR_AUDIENCE)).'" class="btn btn-info btn-sm">'.lang('titre_table_btn_view').' <span class="fa fa-eye"></span></a>';
			
			
			$sub_array[]=$option;    
			
			$data[] = $sub_array;
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
		pms_traitement_audience.JOUR_AUDIENCE,
		pms_demandeur_audience.ID_OBJET_VISITE,
		pms_demandeur_audience.MOTIF_URGENCE
		FROM
		`pms_demandeur_audience`
		JOIN pms_type_demande_audience ON pms_demandeur_audience.ID_OBJET_VISITE = pms_type_demande_audience.ID_TYPE_DEMANDE_AUDIENCE
		JOIN profession ON pms_demandeur_audience.ID_FONCTION = profession.ID_PROFESSION
		JOIN pms_type_demandeur_visite ON pms_demandeur_audience.ID_TYPE_DEMANDEUR_AUDIENCE = pms_type_demandeur_visite.ID_TYPE_VISITE
		LEFT JOIN pms_traitement_audience on pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE
		WHERE 1 and md5(ID_DEMANDEUR_AUDIENCE)="'.$id.'"');
			
		$this->load->view('Detail_Demande_Audience_View',$data);
		
	}
	
	public function tache($value='')
	{
		
		$data['service']=$this->Model->getRequete('SELECT * from pms_service order by DESCRIPTION');
		$data['demand']=$this->Model->getRequeteOne('SELECT ID_DEMANDEUR_AUDIENCE from pms_demandeur_audience where md5(ID_DEMANDEUR_AUDIENCE)="'.$value.'"');
		
		
		
		$this->load->view('Rdv_Audience_View',$data);
		
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
		
		$formattedDate = date("Y-m-d", strtotime($RDV_DATE));

		$test=$this->Model->getRequeteOne('SELECT count(*) as nbr_rdv from pms_traitement_audience where JOUR_AUDIENCE="'.$formattedDate.'" and ID_POSTE='.$ID_POSTE.'');
		
		if ($test['nbr_rdv'] < 40) {
			
			$array_tosave=array('ID_DEMANDEUR_AUDEINCE'=>$ID_DEMANDEUR_AUDIENCE,'JOUR_AUDIENCE'=>$formattedDate,'SERVICE_ID'=>$SERVICE_ID,'ID_POSTE'=>$ID_POSTE);
			$id=$this->Model->insert_last_id('pms_traitement_audience',$array_tosave);
			
			$req=$this->Model->getRequeteOne('SELECT NOM_PRENOM,EMAIL FROM pms_demandeur_audience where ID_DEMANDEUR_AUDIENCE='.$ID_DEMANDEUR_AUDIENCE.'');
			
			
			
			
			
			$subject = "DTFCN - Confirmation de votre demande de rendez-vous por audience.";
			$message = 'Monsieur/Madame' . "<b>" . trim($req['NOM_PRENOM'])."</b>" . ",<br><br>
			Votre rendez-vous pour audience a été programmé pour le " . date('d-m-Y', strtotime($RDV_DATE)) . "<br><br>
			Il vous est demandé de vous présenter physiquement aux bureaux de la Direction
			des Titres Fonciers<br>
			
			Veuillez télécharger votre certificat de RDV en cliquant sur le lien ci-après:<br><br>
			<a href=" . base_url('administration/Liste_Demande_Audience/Document_Pdf/' . md5($id)) . ">" . base_url('administration/Liste_Demande_Audience/Document_Pdf/' . md5($id)) . "</a>
			<br><br>
			Toute sorte de retard n'est pas permit";	
			$mailTo = $req['EMAIL'];
			$this->notifications->send_mail($mailTo, $subject, [], $message, []);
			
			
			$data['message']='<div class="alert alert-success text-center" id="message">Opération réussi. </div>';
			$this->session->set_flashdata($data);
			
			redirect(base_url('administration/Liste_Demande_Audience'));
			
		}else{
			
			$data['message']='<div class="alert alert-success text-center" id="message">Le nombre de rdv pour le '.$RDV_DATE.' a atteint son maximum. <br> Veuillez choisir une autre date. </div>';
			$this->session->set_flashdata($data);
			
			$this->tache(md5($ID_DEMANDEUR_AUDIENCE));
			
		} 	
	}
	
	    //certificat de demande de rdv
		public function Document_Pdf($id)
		{
		  $req_infos=$this->Model->getRequeteOne('SELECT pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE,pms_demandeur_audience.NOM_PRENOM,pms_demandeur_audience.TELEPHONE,pms_demandeur_audience.EMAIL,pms_traitement_audience.JOUR_AUDIENCE FROM `pms_demandeur_audience` join pms_traitement_audience on pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE WHERE md5(pms_traitement_audience.ID_TRAITEMENT_AUDIENCE)="'.$id.'"');
	
	
	   
		  $dateString = $req_infos['JOUR_AUDIENCE'];
		  $date = DateTime::createFromFormat('Y-m-d', $dateString);
		  $formattedDate = date_format($date, 'd-m-Y');

		 $pdf = new FPDF();
		 $pdf->AddPage();
	
		 $src_file = 'uploads/rdv/';
	   
		 if(!is_dir($src_file)){
		  mkdir($src_file ,0777 ,TRUE);
		 }
	
	
			//  $pdf->Image(base_url().'uploads/logo/certificat_dtfcn-04.jpg',0,0,210, 297);
		 $pdf->Image(base_url().'uploads/logo/certificat_dtfcnc-04.jpg',0,0,210, 297);
		
		 $pdf->Ln(5);
		 $pdf->SetFont('Times','B',12);
		 $pdf->Cell(175,6,''.date('d/m/Y') ,0,1,'R');
		 //,strtotime($passport['datecreation'])
		 $pdf->SetFont('Times','B',12);
		 $pdf->Ln(40);
		 $pdf->SetTextColor(255,255,255);
	   
		 $pdf->SetTextColor(0,0,0);
		 $pdf->SetFont('Times','',10);
	
	
		 $pdf->Ln(100);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(75,50,utf8_decode(""),0,'C');
		 $pdf->MultiCell(500,-55,utf8_decode("".$req_infos['NOM_PRENOM'].""),'C',false);
		 
		 $pdf->Ln(65);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(70,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,2,utf8_decode("".$req_infos['EMAIL'].""),'C',false);
	
			//  $pdf->Ln(18);
	
			//  $pdf->SetFont('Times','B',14);
			//  $pdf->Cell(85,7,utf8_decode(""),0,'C');
			//  $pdf->MultiCell(305,2,utf8_decode("Homme"),'C',false);
	
		 $pdf->Ln(20);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(85,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,5,utf8_decode("AUD-".$req_infos['ID_DEMANDEUR_AUDIENCE'].""),'C',false);
	
		 $pdf->Ln(25);
	
		 $pdf->SetFont('Times','B',14);
		 $pdf->Cell(78,7,utf8_decode(""),0,'C');
		 $pdf->MultiCell(300,6,utf8_decode("".$req_infos['TELEPHONE'].""),'C',false);
	
			//  $pdf->Ln(18);
	
			//  $pdf->SetFont('Times','B',14);
			//  $pdf->Cell(85,7,utf8_decode(""),0,'C');
			//  $pdf->MultiCell(300,6,utf8_decode("".$req_infos['NUMERO_PARCELLE'].""),'C',false);
	
			//  $bs=base_url().'transferts/Scanner_certificat/rdv/'.$id;
			//  $val=$req_infos['CODE_DEMANDE'];
			//  $this->notifications->generateQrcode(utf8_decode($bs),$val);
			//  $qrcode_name = $req_infos['CODE_DEMANDE'].'png';
		
	
		 //  if(file_exists(FCPATH . 'uploads/qrcode/'.$qrcode_name)){
		 //   $pdf->Image(FCPATH . 'uploads/qrcode/'.$qrcode_name,90,238,31,0);
		  // $this->db->set('qrcode_path',$qrcode_name);
		  // $this->db->where('id',$passport['id']);
		  // $this->db->update('doc_document');
		 //  }
	
	
	
	
		 $pdf->Ln(30);
		 $pdf->Cell(80,7,utf8_decode(''),0,'L');
		 $pdf->SetFont('Times','B',11);
		 $pdf->Cell(120,7,utf8_decode("".$formattedDate.""),0,'C');
		 $pdf->SetFont('Times','',10);
		 $pdf->Cell(50,7,utf8_decode(''),0,'R');
	

		 $name_file = "CONFIRM_RDV_TEST.pdf";
		 $this->Model->update('pms_traitement_audience',array('md5(ID_TRAITEMENT_AUDIENCE)'=>$id),array('DOC_CERTIFICAT_RENDEZ_VOUS'=>$name_file));
		 //  $pdf->Output($src_file.'/'.$name_file, 'F');
	

			 $pdf->Output('I');
		 
		}
	
}
?>