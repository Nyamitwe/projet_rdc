<?php

/**
* @author Nadvaxe2024
* DATE  :30/04/2024
* contact: 69898947/advaxe@mediabox.bi 
* 
* Cette class a pour role de lister toute les demandes d'audience
*/
class Liste_Audiences extends CI_Controller
{
	
	public function __construct(){
		parent::__construct();
		
		// require('fpdf184/fpdf.php');
		// include APPPATH.'third_party/fpdf/pdfinclude/fpdf/mc_table.php';
		// include APPPATH.'third_party/fpdf/pdfinclude/fpdf/pdf_config.php';
	}
	
	function index()
	{		
		
		$this->load->view('Liste_Audiences_view');
	}
	
	
	
	function liste($id)
	{	
		// echo $id;die();
		// $id=0;
		$PMS_USER_ID = $this->session->userdata('PMS_USER_ID');
		$service_conn = $this->session->userdata('PMS_SERVICE_ID');
		$poste_conn = $this->session->userdata('PMS_POSTE_ID');
		
		$info_user = $this->Model->getOne('pms_user_backend',['USER_BACKEND_ID'=>$PMS_USER_ID]);
			$critaire_serv= "";
		    $critaire_poste= "";
		    if ($service_conn != 19 && $service_conn != 1) {
		      $critaire_serv = ' AND pms_traitement_audience.SERVICE_ID=' . $service_conn . '';
		      $critaire_serv = ' AND pms_traitement_audience.ID_POSTE=' . $poste_conn . '';
		    }
		   // print_r($info_user);die();
		
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		
		$limit='LIMIT 0,10';
		
		if($_POST['length'] != -1) {
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
					$query_principal='SELECT
			    `ID_TRAITEMENT_AUDIENCE`,
			    pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE,
			    pms_demandeur_audience.NOM_PRENOM,
			    pms_demandeur_audience.TELEPHONE,
			    pms_demandeur_audience.EMAIL,
			    pms_demandeur_audience.CATHEGORIE_DEMANDEUR,
			    pms_demandeur_audience.RAISON_SOCIALE,
			    pms_demandeur_audience.MOTIF_URGENCE,
			    pms_traitement_audience.STATUT_MAIL,
			    `JOUR_AUDIENCE`,
			    HEURE_AUDIENCE,
			    `STATUT_SCANNER`,
			    pms_demandeur_audience.MOTIF_URGENCE
			FROM
			    `pms_traitement_audience`
			LEFT JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE = pms_traitement_audience.ID_DEMANDEUR_AUDEINCE
			WHERE
			    STATUT_SCANNER ='.$id.' AND pms_demandeur_audience.TYPE_INITIATION_DEMANDE=1';
		
		$order_column=array("NOM_PRENOM","TELEPHONE","MOTIF_URGENCE","EMAIL","JOUR_AUDIENCE","ID_TRAITEMENT_AUDIENCE");
		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY ID_TRAITEMENT_AUDIENCE  ASC';
		$search = !empty($_POST['search']['value']) ? (" AND (NOM_PRENOM LIKE '%$var_search%' OR TELEPHONE LIKE '%$var_search%' OR EMAIL LIKE '%$var_search%'  OR JOUR_AUDIENCE LIKE '%$var_search%')") : '';
		$critaire="";
		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;
		
		$fetch_data= $this->Model->datatable($query_secondaire);
		// print_r($fetch_data);die();
		
		$data = array();
		$u=0;
		
		foreach ($fetch_data as $row) {
			
			
			$u++;
			$sub_array = array();		
			$order_column=array("NOM_PRENOM","TELEPHONE","EMAIL","JOUR_AUDIENCE");
			$sub_array[]= $u;
			$sub_array[]= '<b>AUD-'.$row->ID_TRAITEMENT_AUDIENCE.'</b>';
			$nom='';
				if (!empty($row->NOM_PRENOM)) 
				{
					$nom=$row->NOM_PRENOM;
				}	
				else 
				{
					$nom=$row->RAISON_SOCIALE;
				}			
      $sub_array[]=$nom;
			$sub_array[]=$row->MOTIF_URGENCE;
			$sub_array[]=$row->TELEPHONE;
			// $sub_array[]=$row->EMAIL; 
			$sub_array[]=$row->JOUR_AUDIENCE.' à '.$row->HEURE_AUDIENCE;
			$service_conn = $this->session->userdata('PMS_SERVICE_ID');
			if ($service_conn == 1 && ($row->STATUT_SCANNER == 1 || $row->STATUT_SCANNER == 3)) {
			$option = '<a href="'.base_url('administration/Liste_Audiences/detail/'.md5($row->ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-info btn-sm">Détails <span class="fa fa-eye"></span></a>';
			$option .= ' <a href="'.base_url('administration/Liste_Audiences/delete/'.md5($row->ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-danger btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet enregistrement ?\')">Supprimer <span class="fa fa-trash"></span></a>';
			} 
      else if (($service_conn == 1 || $service_conn == 31) && $row->STATUT_SCANNER == 0 && $row->STATUT_MAIL == 1)
      {
				$option = '
				<div class="d-flex justify-content-end">
				<a href="'.base_url('administration/Liste_Audiences/detail/'.md5($ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-primary btn-sm mr-2">
				<i class="fa fa-eye"></i>
				</a>
				<a href="'.base_url('administration/Rdv/renvoyer/'.md5($ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-warning btn-sm" onclick="return confirm(\'Êtes-vous sûr de vouloir renvoyer le message ?\')">
				<i class="fa fa-reply"></i>
				</a>
				</div>';
			}
			else 
			{
				$option = '<a href="'.base_url('administration/Liste_Audiences/detail/'.md5($row->ID_TRAITEMENT_AUDIENCE)).'" class="btn btn-info btn-sm">Détails <span class="fa fa-eye"></span></a>';
			}		
			
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
			    `ID_TRAITEMENT_AUDIENCE`,
			    pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE,
			    pms_demandeur_audience.NOM_PRENOM,
			    pms_demandeur_audience.TELEPHONE,
			    pms_demandeur_audience.EMAIL,
			    pms_demandeur_audience.MOTIF_URGENCE,
			    pms_demandeur_audience.NUM_CNI,
			    pms_demandeur_audience.`DISPOSITION_TITRE`,
			    pms_type_demandeur_visite.DESC_TYPE_VISITE,
			    `JOUR_AUDIENCE`,
				pms_demandeur_audience.`DISPOSITION_TITRE`,
				pms_demandeur_audience.`VOLUME`,
				pms_demandeur_audience.`FOLIO`,
				pms_demandeur_audience.NUMERO_PARCELLE,
				pms_demandeur_audience.DOC_PDF_TITRE,
			    `STATUT_SCANNER`,
			    pms_demandeur_audience.MOTIF_URGENCE
			FROM
			    `pms_traitement_audience`
			LEFT JOIN pms_demandeur_audience ON pms_demandeur_audience.ID_DEMANDEUR_AUDIENCE = pms_traitement_audience.ID_DEMANDEUR_AUDEINCE
			LEFT JOIN pms_type_demande_audience ON pms_demandeur_audience.ID_OBJET_VISITE = pms_type_demande_audience.ID_TYPE_DEMANDE_AUDIENCE
			LEFT JOIN pms_type_demandeur_visite ON pms_demandeur_audience.ID_TYPE_DEMANDEUR_AUDIENCE = pms_type_demandeur_visite.ID_TYPE_VISITE
			WHERE
			     1 and md5(ID_TRAITEMENT_AUDIENCE)="'.$id.'"');
			
		$this->load->view('Details_Audiences_view',$data);
		
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
    redirect(base_url('administration/Liste_Audiences'));
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
	
}
?>