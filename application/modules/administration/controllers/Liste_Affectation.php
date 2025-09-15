<?php

/**
* @	Edmond pro
* DATE  :12/04/2025
* contact: 71407706
* 
* 
*/


class Liste_Affectation extends CI_Controller
{
	
	public function __construct(){
		parent::__construct();
		require('fpdf184/fpdf.php');
		
	}
	
	function index()
	{		
		$PMS_USER_ID = $this->session->userdata('PMS_USER_ID');
		$PMS_POSTE = $this->session->userdata('PMS_POSTE_ID');
		$PMS_SERVICE_ID = $this->session->userdata('PMS_SERVICE_ID');

		
		$data['selecttoo']=$this->Model->getRequete("SELECT distinct `USER_BACKEND_ID`, CONCAT(NOM,' ',PRENOM) nom FROM `pms_user_backend` JOIN pms_designation_expert ON pms_designation_expert.ID_EXPERT=pms_user_backend.USER_BACKEND_ID WHERE 1");
		$data['userdef']=0;

       if (in_array($PMS_POSTE, [1,15, 12, 25, 7])) {
       $data['userdef']=2;
       }
		
		$this->load->view('Liste_Affectation_View',$data);
	}


	function liste()
	{
		

        $USER_BACKEND_ID=$this->input->post('USER_BACKEND_ID');
		$PMS_USER_ID = $this->session->userdata('PMS_USER_ID');
		$PMS_POSTE = $this->session->userdata('PMS_POSTE_ID');
		$PMS_SERVICE_ID = $this->session->userdata('PMS_SERVICE_ID');
		$cond = '';
       if (in_array($PMS_POSTE, [15, 12, 25, 7])) {
       $cond .= ' AND pms_poste_service.`ID_SERVICE`=' . $PMS_SERVICE_ID;
       }


       if ($USER_BACKEND_ID) {
       $cond .= ' AND USER_BACKEND_ID=' . $USER_BACKEND_ID;
       }

		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		
		$limit='LIMIT 0,10';
		
		if($_POST['length'] != -1) {
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		
		
		$query_principal="SELECT TELEPHONE,`USER_BACKEND_ID`,pms_designation_expert.ID_TRAITEMENT_DEMANDE,DATE_MODIFICATION,pms_poste_service.ID_POSTE, `NOM`,`PRENOM`,pms_poste_service.POSTE_DESCR,pms_designation_expert.CODE_TRAITEMENT,`DATE_VISITE` FROM `pms_user_backend` JOIN pms_user_poste ON pms_user_poste.ID_USER=pms_user_backend.USER_BACKEND_ID JOIN pms_poste_service ON pms_poste_service.ID_POSTE=pms_user_poste.ID_POSTE JOIN pms_designation_expert ON pms_designation_expert.ID_EXPERT=pms_user_backend.USER_BACKEND_ID WHERE pms_designation_expert.ID_TRAITEMENT_DEMANDE IN (SELECT `ID_TRAITEMENT_DEMANDE` FROM `pms_traitement_demande` WHERE 1 ".$cond.")";
		
		$order_column=array("pms_designation_expert.CODE_TRAITEMENT");
		
		$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY pms_designation_expert.CODE_TRAITEMENT  ASC';
		
		$search = !empty($_POST['search']['value']) ? (" AND (NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR pms_poste_service.POSTE_DESCR LIKE '%$var_search%' OR CODE_TRAITEMENT LIKE '%$var_search%' OR DATE_MODIFICATION LIKE '%$var_search%')") : '';
		
		
		$critaire="";
		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
		$query_filter = $query_principal.' '.$critaire.' '.$search;
		 
		$fetch_data= $this->Model->datatable($query_secondaire);
		 // print_r($fetch_data);die();
		$data = array();
		$u=0;
		
		foreach ($fetch_data as $row) {
	 $proc=$this->Model->getRequeteOne("SELECT `DESCRIPTION_PROCESS` FROM `pms_process` JOIN pms_traitement_demande ON pms_traitement_demande.PROCESS_ID=pms_process.PROCESS_ID WHERE pms_traitement_demande.ID_TRAITEMENT_DEMANDE=".$row->ID_TRAITEMENT_DEMANDE."");
		 $proc_v = ($proc && $proc['DESCRIPTION_PROCESS']) ? $proc['DESCRIPTION_PROCESS'] : 'N/A' ;
		
			$u++;
			$sub_array = array();
			$sub_array[]=$u;
			$sub_array[]= '<b>'.$row->CODE_TRAITEMENT.'</b>';
			$sub_array[]=$row->NOM.'  '.$row->PRENOM;
			$sub_array[]=$row->POSTE_DESCR;
			$sub_array[]=$row->TELEPHONE;
		   $sub_array[]=$proc_v; 
			$sub_array[]=$row->DATE_MODIFICATION;
			
			
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
	
	
	
}
