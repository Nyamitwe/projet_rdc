<?php

/**
* @author Claude
* DATE  :02/05/2024
* contact: 69641375/claude@mediabox.bi 
* 
* Cette class a pour role de lister toute les demandes de rendez vous attribués
*/
class Rdv extends CI_Controller
{
	
	public function __construct(){
		parent::__construct();
		
		// require('fpdf184/fpdf.php');
		// include APPPATH.'third_party/fpdf/pdfinclude/fpdf/mc_table.php';
		// include APPPATH.'third_party/fpdf/pdfinclude/fpdf/pdf_config.php'; Liste_Audiences
	}
	
	function index()
	{		
		
		$this->load->view('Rdv_View');
	}
		
	
	function liste($id)
	{
		$PMS_USER_ID = $this->session->userdata('PMS_USER_ID');
		 $filtre=$this->input->post('FILTRE');
		 $cnond='';
		 if (!empty($filtre)) 
		 {
		 	$cnond.=" AND date_format( pms_traitement_audience.JOUR_AUDIENCE,'%Y-%m-%d') ='".$filtre."'";
		 }

		$info_user = $this->Model->getOne('pms_user_backend',['USER_BACKEND_ID'=>$PMS_USER_ID]);	
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$limit='LIMIT 0,10';
		if($_POST['length'] != -1) {
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		$query_principal="SELECT
			    `ID_TRAITEMENT_AUDIENCE`,
			    pms_demandeur_audience.DATE_INSERTION,
			    pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE,
			    pms_demandeur_audience.NOM_PRENOM,
                pms_process.DESCRIPTION_PROCESS,
			    profession.DESCR_PROFESSION,
			    pms_demandeur_audience.TELEPHONE,
			    pms_demandeur_audience.MOTIF_URGENCE,
			    pms_demandeur_audience.EMAIL,
			    pms_demandeur_audience.CATHEGORIE_DEMANDEUR,
			    pms_demandeur_audience.MOTIF_URGENCE,
			    pms_demandeur_audience.ID_OBJET_VISITE,
			    pms_demandeur_audience.RAISON_SOCIALE,
			    pms_demandeur_audience.DATE_INSERTION,
			    `JOUR_AUDIENCE`,
			    HEURE_AUDIENCE,
			    `STATUT_SCANNER`,
			    STATUT_MAIL,
			    MOTIF
			FROM
			    `pms_traitement_audience`
			LEFT JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE = pms_traitement_audience.ID_DEMANDEUR_AUDEINCE
			LEFT JOIN profession ON profession.ID_PROFESSION = pms_demandeur_audience.ID_FONCTION
      LEFT JOIN pms_process ON pms_process.PROCESS_ID=pms_demandeur_audience.ID_OBJET_VISITE
      LEFT JOIN pms_process_affectation_droit on pms_process_affectation_droit.ID_PROCESSUS=pms_demandeur_audience.ID_OBJET_VISITE
			WHERE STATUT_SCANNER =".$id."
			 AND pms_demandeur_audience.TYPE_INITIATION_DEMANDE=2 
			  ".$cnond."
			 AND pms_process_affectation_droit.ID_SERVICE=".$this->session->userdata('PMS_SERVICE_ID')." 
			 AND pms_process_affectation_droit.ID_POSTE=".$this->session->userdata('PMS_POSTE_ID');


		$order_column=array("NOM_PRENOM","TELEPHONE","MOTIF_URGENCE","EMAIL","ID_TRAITEMENT_AUDIENCE","DESCR_PROFESSION","JOUR_AUDIENCE","",);
		
		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY pms_traitement_audience.ID_TRAITEMENT_AUDIENCE ASC';
		
		
		$search = !empty($_POST['search']['value']) ? (" AND (NOM_PRENOM LIKE '%$var_search%' OR TELEPHONE LIKE '%$var_search%' OR EMAIL LIKE '%$var_search%' OR DESCR_PROFESSION LIKE '%$var_search%' OR JOUR_AUDIENCE LIKE '%$var_search%')") : '';
		$critaire="";
		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;
		
		$fetch_data= $this->Model->datatable($query_secondaire);
		
		$data = array();
		$u=0;
		
		foreach ($fetch_data as $row) 
		{
			$u++;
			$ID_TRAITEMENT_AUDIENCE=$row->ID_TRAITEMENT_AUDIENCE;
			$sub_array = array();
			$order_column=array("NOM_PRENOM","TELEPHONE","EMAIL","DESCR_PROFESSION","JOUR_AUDIENCE");
			$sub_array[]= $u;
			$sub_array[]= '<b>RDV-'.$row->ID_DEMANDEUR_AUDIENCE.'</b>';	
			$cath=$row->CATHEGORIE_DEMANDEUR;
			if ($cath==1)
			{
				$sub_array[]=$row->NOM_PRENOM;
			}
			else
			{
				$sub_array[]=$row->RAISON_SOCIALE;
			}	
			$sub_array[]=$row->DESCRIPTION_PROCESS;
			$sub_array[] = date('d-m-Y', strtotime($row->JOUR_AUDIENCE)) . ' à ' . $row->HEURE_AUDIENCE;
			$sub_array[] = date('d-m-Y', strtotime($row->DATE_INSERTION));


			$service_conn = $this->session->userdata('PMS_SERVICE_ID');
			if ($service_conn == 1 && ($row->STATUT_SCANNER == 1 || $row->STATUT_SCANNER == 3))
		  {
				$option = '<a href="'.base_url('administration/Rdv/detail/'.md5($row->ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-info btn-sm">Détailss <span class="fa fa-eye"></span></a>';
				$option .= ' <a href="'.base_url('administration/Rdv/delete/'.md5($row->ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-danger btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet enregistrement ?\')">Supprimer <span class="fa fa-trash"></span></a>';
			// } else if ($service_conn == 1 && $row->STATUT_SCANNER == 0 AND $row->STATUT_MAIL == 0 AND date('Y-m-d', strtotime($row->DATE_INSERTION)) < date('Y-m-d')){
 
			} else if (($service_conn == 1 || $service_conn == 31) && $row->STATUT_SCANNER == 0 AND $row->STATUT_MAIL == 1){
				$option = '
				<div class="d-flex justify-content-end">
				<a href="'.base_url('administration/Rdv/detail/'.md5($ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-primary btn-sm mr-2">
				<i class="fa fa-eye"></i>
				</a>
				<a href="'.base_url('administration/Rdv/renvoyer/'.md5($ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-warning btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir renvoyer le message ?\')">
				<i class="fa fa-reply"></i>
				</a>
                                <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf_V/'.md5($ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-primary btn-sm mr-2">
				<i class="fa fa-file-pdf-o"></i>
				</a>
				</div>';
			}	else
			{
				$option = '<a href="'.base_url('administration/Rdv/detail/'.md5($row->ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-info btn-sm">Détails <span class="fa fa-eye"></span></a>';
				
				$option .= '<a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf_V/'.md5($row->ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-info btn-sm"><span class="fa fa-file-pdf-o"></span></a>';
			}

			$sub_array[]=$option;  
			
			$data[] = $sub_array;
		}
		$output = array(
			"draw" => intval($_POST['draw']),
			"recordsTotal" =>$this->Model->all_data($query_principal),
			"recordsFiltered" => $this->Model->filtrer($query_filter),
			"data" => $data);
			
		echo json_encode($output);
	}
	
	function detail($id)
	{
		
		$data['infos']=$this->Model->getRequeteOne('SELECT
			    `ID_TRAITEMENT_AUDIENCE`,
			    pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE,
			    pms_demandeur_audience.NOM_PRENOM,
			    pms_demandeur_audience.RAISON_SOCIALE,
			    pms_demandeur_audience.CATHEGORIE_DEMANDEUR,
			    profession.DESCR_PROFESSION,
			    pms_process.DESCRIPTION_PROCESS,
			    pms_demandeur_audience.TELEPHONE,
			    pms_demandeur_audience.EMAIL,
			    pms_demandeur_audience.MOTIF_URGENCE,
			    pms_demandeur_audience.NUM_CNI,
			    pms_demandeur_audience.`DISPOSITION_TITRE`,
			    pms_type_demandeur_visite.DESC_TYPE_VISITE,
			    `JOUR_AUDIENCE`,MOTIF,
				pms_demandeur_audience.`DISPOSITION_TITRE`,
				pms_demandeur_audience.`VOLUME`,
				pms_demandeur_audience.`FOLIO`,
				pms_demandeur_audience.NUMERO_PARCELLE,
				pms_demandeur_audience.DOC_PDF_TITRE,
			    `STATUT_SCANNER`  ,
			  pms_traitement_audience.JOUR_AUDIENCE,
              sf_guard_user_categories.name AS PROFILESS
			FROM
			    `pms_traitement_audience`
			LEFT JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE = pms_traitement_audience.ID_DEMANDEUR_AUDEINCE
			 LEFT JOIN profession ON profession.ID_PROFESSION = pms_demandeur_audience.ID_FONCTION
			LEFT JOIN pms_type_demandeur_visite ON pms_demandeur_audience.ID_TYPE_DEMANDEUR_AUDIENCE = pms_type_demandeur_visite.ID_TYPE_VISITE
			LEFT JOIN sf_guard_user_categories ON sf_guard_user_categories.id = pms_demandeur_audience.CATHEGORIE_DEMANDEUR
			 LEFT JOIN pms_process ON pms_process.PROCESS_ID=pms_demandeur_audience.ID_OBJET_VISITE

			WHERE
			     1 and md5(ID_TRAITEMENT_AUDIENCE)="'.$id.'"');
			
		$this->load->view('Details_Rdv_view',$data);
		
	} 

		public function report($value='')
	{
		$id=$this->Model->getRequeteOne("SELECT `ID_DEMANDEUR_AUDEINCE` FROM `pms_traitement_audience` WHERE md5(ID_TRAITEMENT_AUDIENCE)='".$value."'");
		$data['demand']=$this->Model->getRequeteOne('SELECT ID_DEMANDEUR_AUDIENCE, date_format(DATE_INSERTION,"%d-%m-%Y") as DATE_INSERTIONN  from pms_demandeur_audience where ID_DEMANDEUR_AUDIENCE="'.$id['ID_DEMANDEUR_AUDEINCE'].'"');
		$data['DATE_DEMANDE'] = $data['demand']['DATE_INSERTIONN']; 
		$data['rdv_donne']=$this->Model->getRequeteOne("SELECT `ID_TRAITEMENT_AUDIENCE` FROM `pms_traitement_audience` WHERE md5(ID_TRAITEMENT_AUDIENCE)='".$value."'");
		 // print_r($data['rdv_donne']);die();
		$data['rdv_deja_donne']=0;
		if (!empty($data['rdv_donne'])) {
			$data['rdv_deja_donne']=1;
		}else{
			$data['rdv_deja_donne']=0;
		}
 
			
		$this->load->view('Report_view',$data);
		
	}
		public function Motifs($ID_DEMANDEUR_AUDIENCE)
	{
	$data['MOTIFS'] = $this->Model->getRequete("
    SELECT `MOTIF`, DATE_INSERTION 
    FROM `pms_historique_traitement_audience` 
    WHERE md5(ID_DEMANDEUR_AUDEINCE)='".$ID_DEMANDEUR_AUDIENCE."'
    ORDER BY DATE_INSERTION DESC
");			
		$this->load->view('Motifs_view',$data);
		
	}
	public function reporter_rdv()
	{
		$ID_TRAITEMENT_AUDIENCE=$this->input->post('ID_TRAITEMENT_AUDIENCE');
		$RDV_DATE=$this->input->post('RDV_DATE');
		$formattedDate = date("Y-m-d", strtotime($RDV_DATE));
		$HEURE=$this->input->post('HEURE');
		$MOTIF=$this->input->post('MOTIF');
			$array_toUpdate = array(
				'JOUR_AUDIENCE'=>$formattedDate,
				'MOTIF'=>$MOTIF,
				'STATUT_SCANNER'=>2,
				'HEURE_AUDIENCE '=>$HEURE);

			$data1=$this->Model->getRequeteOne("SELECT * FROM `pms_traitement_audience` WHERE ID_TRAITEMENT_AUDIENCE='".$ID_TRAITEMENT_AUDIENCE."'");

			$array_toinsert=array('
				ID_DEMANDEUR_AUDEINCE'=>$data1['ID_DEMANDEUR_AUDEINCE'],
				'JOUR_AUDIENCE'=>$data1['JOUR_AUDIENCE'],
				'HEURE_AUDIENCE'=>$data1['HEURE_AUDIENCE'],
				'MOTIF'=>$MOTIF,
				'USER_ID '=>$this->session->userdata('PMS_USER_ID'));

			$inserting=$this->Model->insert_last_id('pms_historique_traitement_audience',$array_toinsert);
			$updating = $this->Model->update('pms_traitement_audience',array('ID_TRAITEMENT_AUDIENCE'=>$ID_TRAITEMENT_AUDIENCE),$array_toUpdate); 



			$req = $this->Model->getRequeteOne('SELECT NOM_PRENOM, EMAIL,CATHEGORIE_DEMANDEUR,RAISON_SOCIALE,SEXE_ID,TYPE_INITIATION_DEMANDE FROM pms_demandeur_audience WHERE ID_DEMANDEUR_AUDIENCE='.$data1['ID_DEMANDEUR_AUDEINCE'].'');
			              if ($req['SEXE_ID']==1) 
              {
                $genre="Madame";
              }
              else if ($req['SEXE_ID']==2)
              {
               $genre="Monsieur"; 
              }
              else
              {
               $genre="Cher responsable de"; 
              }

               if ($req['CATHEGORIE_DEMANDEUR']==5) 
              {
                $nom=$req['RAISON_SOCIALE'];
              } else 
              { 
                $nom=$req['NOM_PRENOM'];
              }
              $greeting=$genre.''.$nom;
			$subject = "Reprogrammation de votre rendez-vous";
			$message = '<b>'.trim($greeting).'</b>,<br><br>
			Votre rendez-vous a été reprogrammé pour le '.date('d-m-Y', strtotime($RDV_DATE)).' à '.$HEURE.'<br><br>
			Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br><br>
			Motif de report: '.trim($MOTIF).'<br><br>
			Veuillez télécharger votre certificat actualisé en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.md5($ID_TRAITEMENT_AUDIENCE)).'">Document à télécharger</a>.<br><br>
			Cordialement.';
			$mailTo = $req['EMAIL'];
			$sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);
			if ($sending) {
			$data['message'] = '<div class="alert alert-success text-center" id="message">L\'Opération faite et message envoyé avec succès.</div>';
			} else {
				$data['message'] = '<div class="alert alert-danger text-center" id="message">Le message n\'est pas envoyé.</div>';
			}
			$this->session->set_flashdata($data);
			if ($req['TYPE_INITIATION_DEMANDE'] == 2) {
				redirect(base_url('administration/Rdv'));
			} else {
				redirect(base_url('administration/Liste_Audiences'));
			}	
	}
		public function tache($id,$statut)
	{
		$data['service']=$this->Model->getRequete('SELECT * from pms_service order by DESCRIPTION');
		$data['demand']=$this->Model->getRequeteOne('SELECT ID_DEMANDEUR_AUDIENCE from pms_demandeur_audience where md5(ID_DEMANDEUR_AUDIENCE)="'.$value.'"');		
		$this->load->view('Rdv_Audience_View',$data);
	
	}

function statut($id,$stat)
  {
    // $value = ($stat==1) ? 0 : 1 ;
    $this->Model->update('pms_traitement_audience',array('ID_TRAITEMENT_AUDIENCE'=>$id),array('STATUT_SCANNER'=>$stat));
        $message = "<div class='alert alert-success text-center'>Opération  a été faite avec succès.</div>";
      $this->session->set_flashdata(array('message'=>$message));
    redirect(base_url('administration/Rdv'));
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
	
      public function delete($id)
      {
        $delete_trait=$this->Model->delete('pms_traitement_audience',array('md5(ID_DEMANDEUR_AUDEINCE)'=>$id));
       $delete_dde=$this->Model->delete('pms_demandeur_audience',array('md5(ID_DEMANDEUR_AUDIENCE)'=>$id));
        if ($delete_trait && $delete_dde)
        {
          $data['message']='<div class="alert alert-success text-center" id="message">La suppression a été faite avec succès</div>';
          $this->session->set_flashdata($data);
          redirect(base_url('administration/Rdv'));
        }
        else
        {
          $data['message']='<div class="alert alert-danger text-center" id="message">La suppression a échouée</div>';
          $this->session->set_flashdata($data);
          redirect(base_url('administration/Rdv'));

        }
        
      }

       public function renvoyer($id)
      {

       $req = $this->Model->getRequeteOne('SELECT NOM_PRENOM, EMAIL,CATHEGORIE_DEMANDEUR,RAISON_SOCIALE,TYPE_INITIATION_DEMANDE,SEXE_ID,pms_traitement_audience.JOUR_AUDIENCE,pms_traitement_audience.HEURE_AUDIENCE,pms_traitement_audience.STATUT_SCANNER FROM pms_demandeur_audience JOIN pms_traitement_audience ON pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE WHERE md5(ID_TRAITEMENT_AUDIENCE)="'.$id.'"');
       	$donnee = array(
				'STATUT_MAIL'=>1);
			$updating = $this->Model->update('pms_traitement_audience',array('md5(ID_TRAITEMENT_AUDIENCE)'=>$id),$donnee);
			         if ($req['SEXE_ID']==1) 
              {
                $genre="Madame";
              }
              else if ($req['SEXE_ID']==2)
              {
               $genre="Monsieur"; 
              }
              else
              {
               $genre="Cher responsable de"; 
              }

               if ($req['CATHEGORIE_DEMANDEUR']==5) 
              {
                $nom=$req['RAISON_SOCIALE'];
              } else 
              { 
                $nom=$req['NOM_PRENOM'];
              }
              $greeting=$genre.' '.$nom;

			$subject = "Confirmation de votre demande de rendez-vous";
			$message = '<b>'.trim($greeting).'</b>,<br><br>
			Votre rendez-vous a été programmé pour le '.date('d-m-Y', strtotime($req['JOUR_AUDIENCE'])).' à '.$req['HEURE_AUDIENCE'].'<br><br>
			Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br><br>
			Veuillez télécharger votre certificat actualisé en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.$id).'">Document à télécharger</a>.<br><br>
			Cordialement.';
			$mailTo = $req['EMAIL'];
			$sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);
			if ($sending && $updating) {
			$data['message'] = '<div class="alert alert-success text-center" id="message">L\'Opération faite et message envoyé avec succès.</div>';
			} else {
				$data['message'] = '<div class="alert alert-danger text-center" id="message">Le message n\'est pas envoyé.</div>';
			}
			$this->session->set_flashdata($data);
			if ($req['TYPE_INITIATION_DEMANDE'] == 2) {
				redirect(base_url('administration/Rdv'));
			} else {
				redirect(base_url('administration/Liste_Audiences'));
			}	
        
      }

      public function renvoyer_mail()
  {

      	$mail_non_recu=$this->Model->getRequete('SELECT pms_traitement_audience.ID_TRAITEMENT_AUDIENCE FROM pms_demandeur_audience JOIN pms_traitement_audience on pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE WHERE pms_demandeur_audience.DATE_INSERTION >= "2024-07-25 08:00:00" and pms_traitement_audience.STATUT_MAIL=1 AND pms_traitement_audience.JOUR_AUDIENCE>="2024-07-31" AND pms_traitement_audience.ID_DEMANDEUR_AUDEINCE NOT IN (14004,14011) ORDER BY pms_traitement_audience.JOUR_AUDIENCE DESC');

      	foreach ($mail_non_recu as $key => $value)
      	{
          $req = $this->Model->getRequeteOne('SELECT NOM_PRENOM, EMAIL,CATHEGORIE_DEMANDEUR,RAISON_SOCIALE,TYPE_INITIATION_DEMANDE,SEXE_ID,pms_traitement_audience.JOUR_AUDIENCE,pms_traitement_audience.HEURE_AUDIENCE,pms_traitement_audience.STATUT_SCANNER FROM pms_demandeur_audience JOIN pms_traitement_audience ON pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE WHERE ID_TRAITEMENT_AUDIENCE="'.$value['ID_TRAITEMENT_AUDIENCE'].'"');

       	$donnee = array(
				'STATUT_MAIL'=>1,'RENOTIFICATION'=>1);
			   $updating = $this->Model->update('pms_traitement_audience',array('ID_TRAITEMENT_AUDIENCE'=>$value['ID_TRAITEMENT_AUDIENCE']),$donnee);
			         if ($req['SEXE_ID']==1) 
              {
                $genre="Madame";
              }
              else if ($req['SEXE_ID']==2)
              {
               $genre="Monsieur"; 
              }
              else
              {
               $genre="Cher responsable de"; 
              }

               if ($req['CATHEGORIE_DEMANDEUR']==5) 
              {
                $nom=$req['RAISON_SOCIALE'];
              } else 
              { 
                $nom=$req['NOM_PRENOM'];
              }
              $greeting=$genre.' '.$nom;

			$subject = "Confirmation de votre demande de rendez-vous";
			$message = '<b>'.trim($greeting).'</b>,<br><br>
			Votre rendez-vous a été programmé pour le '.date('d-m-Y', strtotime($req['JOUR_AUDIENCE'])).' à '.$req['HEURE_AUDIENCE'].'<br><br>
			Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br><br>
			Veuillez télécharger votre certificat actualisé en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.$id).'">Document à télécharger</a>.<br><br>
			Cordialement.';
			$mailTo = $req['EMAIL'];
			$sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);
		}	
	}

	function changeDateNotify()
         {    
              $SAMEDI = '2024-07-30';

              $LUNDI = '2024-08-07';

              $formattedDate = date("Y-m-d", strtotime($SAMEDI));

              $formattedLundi = date("Y-m-d", strtotime($LUNDI));

              $data = $this->Model->getRequete('SELECT ID_TRAITEMENT_AUDIENCE, JOUR_AUDIENCE FROM pms_traitement_audience JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_TRAITEMENT_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE!=0 AND JOUR_AUDIENCE="'.$formattedDate.'"');
               print_r($data);die();
              foreach ($data as $key => $value)
              {
                $id_update=$value['ID_TRAITEMENT_AUDIENCE'];
                $array_toUpdate = array(
                'JOUR_AUDIENCE'=>$formattedLundi,
                'STATUT_MAIL'=>1);
              $updating = $this->Model->update('pms_traitement_audience',array('ID_TRAITEMENT_AUDIENCE'=>$id_update),$array_toUpdate); 

              $req = $this->Model->getRequeteOne('SELECT pms_demandeur_audience.NOM_PRENOM,pms_traitement_audience.ID_TRAITEMENT_AUDIENCE,pms_demandeur_audience.RAISON_SOCIALE,pms_demandeur_audience.CATHEGORIE_DEMANDEUR,pms_traitement_audience.JOUR_AUDIENCE,pms_traitement_audience.HEURE_AUDIENCE, pms_demandeur_audience.EMAIL FROM pms_demandeur_audience JOIN pms_traitement_audience ON pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE WHERE pms_traitement_audience.ID_TRAITEMENT_AUDIENCE='.$id_update.'');
                if ($req['CATHEGORIE_DEMANDEUR']==5) 
                {
                  $nom=$req['RAISON_SOCIALE'];
                } 
                else 
                {
                  $nom=$req['NOM_PRENOM'];
                }
                $ID_TRAITEMENT_AUDIENCE=$req['ID_TRAITEMENT_AUDIENCE'];
              $subject = "Confirmation de votre demande de rendez-vous";
              $message = 'Monsieur/Madame <b>'.trim($nom).'</b>,<br><br>
              Votre rendez-vous a été programmé pour le '.date('d-m-Y', strtotime($req['JOUR_AUDIENCE'])).' à '.$req['HEURE_AUDIENCE'].'<br><br>
              Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br>
              Veuillez télécharger votre certificat de demande d’audience en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.md5($ID_TRAITEMENT_AUDIENCE)).'">Document à télécharger</a>.<br><br>
              Cordialement.';
              $mailTo = $req['EMAIL'];
              $sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);
             }
						}

		// function nouveau_report()
  //     {    
  //            // $SAMEDI = '2024-07-30';

  //            //  $LUNDI = '2024-08-06';

  //            //  $formattedDate = date("Y-m-d", strtotime($SAMEDI));

  //            //  $formattedLundi = date("Y-m-d", strtotime($LUNDI));

  //            // $data = $this->Model->getRequete('SELECT ID_TRAITEMENT_AUDIENCE, JOUR_AUDIENCE FROM pms_traitement_audience JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE=0 AND JOUR_AUDIENCE="'.$formattedDate.'"');
  //             //print_r($data);die();


  //             // $DayFrom = '2024-07-26';
	 //      // $DayFrom = '0000-00-00';
  //       //       $DayTo = '2024-08-09';
  //       //       $formattedFrom = date("Y-m-d", strtotime($DayFrom));
  //       //       $formattedTo = date("Y-m-d", strtotime($DayTo));

  //       //        $data = $this->Model->getRequete('SELECT ID_TRAITEMENT_AUDIENCE, JOUR_AUDIENCE FROM pms_traitement_audience WHERE pms_traitement_audience.STATUT_MAIL=1 AND JOUR_AUDIENCE="'.$DayFrom.'"');

  //             $DayTo = '2024-08-05';
  //             // $formattedFrom = date("Y-m-d", strtotime($DayFrom));
  //             $formattedTo = date("Y-m-d", strtotime($DayTo));

  //              // $data = $this->Model->getRequete("SELECT pms_traitement_audience.ID_TRAITEMENT_AUDIENCE, pms_traitement_audience.JOUR_AUDIENCE, pms_process.DESCRIPTION_PROCESS FROM pms_demandeur_audience JOIN pms_traitement_audience ON pms_traitement_audience.ID_DEMANDEUR_AUDEINCE = pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE JOIN pms_process ON pms_process.PROCESS_ID = pms_demandeur_audience.ID_OBJET_VISITE WHERE pms_demandeur_audience.ID_OBJET_VISITE IN (5,6,7,8,9,11,13,14,18,20,21,22,23,26,28) AND DATE_FORMAT(pms_demandeur_audience.DATE_INSERTION, '%m-%Y')='07-2024' AND DAY(pms_demandeur_audience.DATE_INSERTION)=30");

  //              $data=$this->Model->getRequete("SELECT pms_traitement_audience.ID_TRAITEMENT_AUDIENCE, pms_process.DESCRIPTION_PROCESS, pms_traitement_audience.JOUR_AUDIENCE,pms_traitement_audience.HEURE_AUDIENCE,pms_demandeur_audience.DATE_INSERTION FROM `pms_traitement_audience` JOIN pms_demandeur_audience on pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE JOIN pms_process on pms_process.PROCESS_ID=pms_demandeur_audience.ID_OBJET_VISITE WHERE `JOUR_AUDIENCE` = '0000-00-00'");

	 //      // print_r($data);die();
  //             foreach ($data as $key => $value)
  //             {
  //               $id_update=$value['ID_TRAITEMENT_AUDIENCE'];
  //               $array_toUpdate = array(
  //               'JOUR_AUDIENCE'=>$formattedTo,
  //               'STATUT_MAIL'=>1,
  //                'RENOTIFICATION'=>9);
  //             $updating = $this->Model->update('pms_traitement_audience',array('ID_TRAITEMENT_AUDIENCE'=>$id_update),$array_toUpdate);
  //             $req = $this->Model->getRequeteOne('SELECT pms_demandeur_audience.NOM_PRENOM,pms_traitement_audience.ID_TRAITEMENT_AUDIENCE,pms_demandeur_audience.RAISON_SOCIALE,pms_demandeur_audience.CATHEGORIE_DEMANDEUR,pms_traitement_audience.JOUR_AUDIENCE,pms_traitement_audience.HEURE_AUDIENCE, pms_demandeur_audience.EMAIL FROM pms_demandeur_audience JOIN pms_traitement_audience ON pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE WHERE pms_traitement_audience.ID_TRAITEMENT_AUDIENCE='.$id_update.'');
  //               if ($req['CATHEGORIE_DEMANDEUR']==5) 
  //               {
  //                 $nom=$req['RAISON_SOCIALE'];
  //               } 
  //               else 
  //               {
  //                 $nom=$req['NOM_PRENOM'];
  //               }
  //               $ID_TRAITEMENT_AUDIENCE=$req['ID_TRAITEMENT_AUDIENCE'];
  //             $subject = "Confirmation de votre demande de rendez-vous";
  //             $message = 'Monsieur/Madame <b>'.trim($nom).'</b>,<br><br>
  //             Votre rendez-vous a été programmé pour le '.date('d-m-Y', strtotime($req['JOUR_AUDIENCE'])).' à '.$req['HEURE_AUDIENCE'].'<br><br>
  //             Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br>
  //             Veuillez télécharger votre certificat de demande d’audience en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.md5($ID_TRAITEMENT_AUDIENCE)).'">Document à télécharger</a>.<br><br>
  //             Cordialement.';
  //             $mailTo = $req['EMAIL'];
  //             $sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);
  //         }
  //     }

	function nouveau_report()
      {    
             // $SAMEDI = '2024-07-30';

             //  $LUNDI = '2024-08-06';

             //  $formattedDate = date("Y-m-d", strtotime($SAMEDI));

             //  $formattedLundi = date("Y-m-d", strtotime($LUNDI));

             // $data = $this->Model->getRequete('SELECT ID_TRAITEMENT_AUDIENCE, JOUR_AUDIENCE FROM pms_traitement_audience JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE=pms_traitement_audience.ID_DEMANDEUR_AUDEINCE WHERE pms_demandeur_audience.ID_OBJET_VISITE=0 AND JOUR_AUDIENCE="'.$formattedDate.'"');
              //print_r($data);die();


              // $DayFrom = '2024-07-26';
	      // $DayFrom = '0000-00-00';
        //       $DayTo = '2024-08-09';
        //       $formattedFrom = date("Y-m-d", strtotime($DayFrom));
        //       $formattedTo = date("Y-m-d", strtotime($DayTo));

        //        $data = $this->Model->getRequete('SELECT ID_TRAITEMENT_AUDIENCE, JOUR_AUDIENCE FROM pms_traitement_audience WHERE pms_traitement_audience.STATUT_MAIL=1 AND JOUR_AUDIENCE="'.$DayFrom.'"');

              $DayTo = '2024-08-16';
              // $formattedFrom = date("Y-m-d", strtotime($DayFrom));
              $formattedTo = date("Y-m-d", strtotime($DayTo));

               // $data = $this->Model->getRequete("SELECT pms_traitement_audience.ID_TRAITEMENT_AUDIENCE, pms_traitement_audience.JOUR_AUDIENCE, pms_process.DESCRIPTION_PROCESS FROM pms_demandeur_audience JOIN pms_traitement_audience ON pms_traitement_audience.ID_DEMANDEUR_AUDEINCE = pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE JOIN pms_process ON pms_process.PROCESS_ID = pms_demandeur_audience.ID_OBJET_VISITE WHERE pms_demandeur_audience.ID_OBJET_VISITE IN (5,6,7,8,9,11,13,14,18,20,21,22,23,26,28) AND DATE_FORMAT(pms_demandeur_audience.DATE_INSERTION, '%m-%Y')='07-2024' AND DAY(pms_demandeur_audience.DATE_INSERTION)=30");

               $data=$this->Model->getRequete("SELECT ID_TRAITEMENT_AUDIENCE, JOUR_AUDIENCE FROM pms_demandeur_audience JOIN pms_traitement_audience ON pms_traitement_audience.ID_DEMANDEUR_AUDEINCE = pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE  WHERE 1 AND DATE_FORMAT(pms_traitement_audience.JOUR_AUDIENCE, '%m-%Y')='08-2024' AND DAY(pms_traitement_audience.JOUR_AUDIENCE)=15");

             
               

	      // print_r($data);die();

              foreach ($data as $key => $value)
              {
                $id_update=$value['ID_TRAITEMENT_AUDIENCE'];
                $req_hh = $this->Model->getRequeteOne("SELECT pms_traitement_audience.ID_TRAITEMENT_AUDIENCE, pms_traitement_audience.JOUR_AUDIENCE, pms_traitement_audience.HEURE_AUDIENCE FROM pms_demandeur_audience JOIN pms_traitement_audience ON pms_traitement_audience.ID_DEMANDEUR_AUDEINCE = pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE JOIN pms_process ON pms_process.PROCESS_ID = pms_demandeur_audience.ID_OBJET_VISITE WHERE pms_traitement_audience.ID_TRAITEMENT_AUDIENCE=".$id_update." AND TIME_FORMAT(pms_traitement_audience.HEURE_AUDIENCE, '%H:%i')>'12:30'");
                if ($req_hh) {
                	if (! empty($req_hh['ID_TRAITEMENT_AUDIENCE'])) {
               $DateTime = DateTime::createFromFormat('H:i', '10:40');
                $Hour = $DateTime->format('H:i'); 
                $array_toUpdate = array(
                'JOUR_AUDIENCE'=>$formattedTo,
                'STATUT_MAIL'=>1,
                'HEURE_AUDIENCE' => $Hour,
                 'RENOTIFICATION'=>9);
                	}else{
                		$array_toUpdate = array(
                'JOUR_AUDIENCE'=>$formattedTo,
                'STATUT_MAIL'=>1,
                 'RENOTIFICATION'=>9);
                	}
                }else{
                $array_toUpdate = array(
                'JOUR_AUDIENCE'=>$formattedTo,
                'STATUT_MAIL'=>1,
                 'RENOTIFICATION'=>9);
                }
                
              $updating = $this->Model->update('pms_traitement_audience',array('ID_TRAITEMENT_AUDIENCE'=>$id_update),$array_toUpdate);
              $req = $this->Model->getRequeteOne('SELECT pms_demandeur_audience.NOM_PRENOM,pms_traitement_audience.ID_TRAITEMENT_AUDIENCE,pms_demandeur_audience.RAISON_SOCIALE,pms_demandeur_audience.CATHEGORIE_DEMANDEUR,pms_traitement_audience.JOUR_AUDIENCE,pms_traitement_audience.HEURE_AUDIENCE, pms_demandeur_audience.EMAIL FROM pms_demandeur_audience JOIN pms_traitement_audience ON pms_traitement_audience.ID_DEMANDEUR_AUDEINCE=pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE WHERE pms_traitement_audience.ID_TRAITEMENT_AUDIENCE='.$id_update.'');
                if ($req['CATHEGORIE_DEMANDEUR']==5) 
                {
                  $nom=$req['RAISON_SOCIALE'];
                } 
                else 
                {
                  $nom=$req['NOM_PRENOM'];
                }
                $ID_TRAITEMENT_AUDIENCE=$req['ID_TRAITEMENT_AUDIENCE'];
              $subject = "En raison du congé de la fête religieuse de l'Assomption, votre rendez-vous a été reporté. Veuillez trouver les détails de votre nouveau rendez-vous dans le certificat";
              $message = 'Monsieur/Madame <b>'.trim($nom).'</b>,<br><br>
              Votre rendez-vous a été programmé pour le '.date('d-m-Y', strtotime($req['JOUR_AUDIENCE'])).' à '.$req['HEURE_AUDIENCE'].'<br><br>
              Il vous est demandé de vous présenter physiquement aux bureaux du secrétariat de la Direction des Titres Foncier et du Cadastre National, en apportant vos documents en rapport avec votre demande.<br><br>
              Veuillez télécharger votre certificat de demande d’audience en cliquant sur le <a href="'.base_url('administration/Liste_Demande_Rdv/Document_Pdf/'.md5($ID_TRAITEMENT_AUDIENCE)).'">Document à télécharger</a>.<br><br>
              Cordialement.';
              $mailTo = $req['EMAIL'];
              $sending = $this->notifications->send_mail($mailTo, $subject, [], $message, []);
          }
      }
}
?>
