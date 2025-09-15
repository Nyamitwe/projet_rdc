<?php 
/**
 * le 15/07/2025
 * dushime.romeo@medaibox.bi
 * Dushime Romeo
 * Historique de designation
 */
class Affectation extends CI_Controller
{
	
	function __construct()
	{
		// code...
		parent::__construct();
	}

	function check_session() {

		if ($this->session->userdata('PMS_USER_ID')<1 || empty($this->session->userdata('PMS_USER_ID'))) {
	       // code...
	      redirect(base_url());
	    }
	}

	function index()
	{

		$this->check_session();

    $data['proces']=$this->Model->getRequete('SELECT `PROCESS_ID`,`DESCRIPTION_PROCESS` FROM `pms_process` WHERE 1 ORDER BY DESCRIPTION_PROCESS ASC');

		$data['title'] = 'Historique de désignation';
		$this->load->view('Affectation_View',$data);
	}

	function liste()
	{
		$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';

		if($_POST['length'] != -1) {
		    $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}

		$USER_ID=$this->session->userdata('PMS_USER_ID');
		$PROCESS_ID = $this->input->post('PROCESS_ID');
		$cond ="";
		if ($PROCESS_ID) {
		 	$cond = " AND pms_process.PROCESS_ID =".$PROCESS_ID;
		}
		$designateur=$this->Model->getRequeteOne("SELECT pms_user_poste.ID_POSTE,pms_poste_service.POSTE_DESCR FROM pms_user_poste JOIN pms_poste_service on pms_poste_service.ID_POSTE=pms_user_poste.ID_POSTE WHERE pms_user_poste.ID_USER=".$USER_ID);
		$desi="";
		if ($designateur['ID_POSTE']==12) {
		 	$desi = " AND pms_designation_expert.ID_POSTE = 14";
		}

		$query_principal="SELECT `ID_DESIGNATION_EXPERT`,`ID_EXPERT`,pms_designation_expert.`ID_TRAITEMENT_DEMANDE`,`DATE_VISITE`,pms_traitement_demande.CODE_DEMANDE,pms_designation_expert.`ID_POSTE`,concat(pms_user_backend.NOM,' ',pms_user_backend.PRENOM) as NOM_PRENOM,pms_poste_service.POSTE_DESCR,pms_process.DESCRIPTION_PROCESS FROM pms_designation_expert JOIN pms_traitement_demande on pms_designation_expert.ID_TRAITEMENT_DEMANDE=pms_traitement_demande.ID_TRAITEMENT_DEMANDE JOIN pms_user_backend on pms_user_backend.USER_BACKEND_ID=pms_designation_expert.ID_EXPERT JOIN pms_user_poste on pms_user_poste.ID_USER=pms_user_backend.USER_BACKEND_ID join pms_poste_service on pms_poste_service.ID_POSTE=pms_user_poste.ID_POSTE JOIN pms_process on pms_process.PROCESS_ID=pms_traitement_demande.PROCESS_ID WHERE 1 ".$cond." ".$desi." ";
 
	    $order_column=array('pms_traitement_demande.CODE_DEMANDE','DESCRIPTION_PROCESS','NOM','PRENOM','POSTE_DESCR','DATE_VISITE');
	    $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY ID_DESIGNATION_EXPERT ASC';

	    $search = !empty($_POST['search']['value']) ? (" AND (pms_traitement_demande.CODE_DEMANDE LIKE '%$var_search%' OR pms_process.DESCRIPTION_PROCESS LIKE '%$var_search%' OR POSTE_DESCR LIKE '%$var_search%' OR NOM LIKE '%$var_search%' OR PRENOM LIKE '%$var_search%' OR DATE_VISITE LIKE '%$var_search%')") : '';

	  $critaire="";
	  $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;
	  $query_filter = $query_principal.' '.$critaire.' '.$search;
	  $fetch_data= $this->Model->datatable($query_secondaire);
	  $data = array();
	  $u=0;

	  foreach ($fetch_data as $row) {
	 $u++;
	 $sub_array = array();
	 $option ="";
		$sub_array[]=$row->CODE_DEMANDE;
		$sub_array[]=$row->DESCRIPTION_PROCESS;
		$sub_array[]=$row->NOM_PRENOM;
		$sub_array[]=$row->POSTE_DESCR;
		$sub_array[]=$row->DATE_VISITE;

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
}
 ?>
