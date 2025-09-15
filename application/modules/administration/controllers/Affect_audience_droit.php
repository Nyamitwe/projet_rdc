<?php
// developper par eriel@mediabox.bi
// le 15-05-2024
// ce controlleur permet l'affichage et l'affectation d'un processus à un service concerné et un post concerné
class Affect_audience_droit extends Ci_Controller
{
    public function __construct()
    {
	parent::__construct();
        $this->isAuth();        
    }

    //CHECK AUTHENTIFICATION
    public function isAuth()
    {
        if(empty($this->get_utilisateur()))
        {
          redirect(base_url('Login'));
        }
    } 
    
    //RECUPERATION DU LOGIN DE LA PERSONNE CONNECTEE
    public function get_utilisateur()
    {
        return $this->session->userdata('PMS_USER_ID');
    }

    // redirection sur la page d'insertion
    public function index()
    {
        $data['services']=$this->Model->getList('pms_service');
        $data['postes']=array();
        $data['process']=$this->Model->getRequete('SELECT pms_process.PROCESS_ID,pms_process.DESCRIPTION_PROCESS FROM `pms_process` WHERE IS_ACTIVE=1 ORDER BY pms_process.DESCRIPTION_PROCESS ASC;');
        $this->load->view('Affect_audience_droit_view',$data);
    }

    // recuperation dynamique du poste par rapport au service
    function get_poste($ID_SERVICE=0)
    {
        $communes=$this->Model->getRequete('SELECT ID_POSTE,POSTE_DESCR FROM pms_poste_service WHERE ID_SERVICE='.$ID_SERVICE.' ORDER BY POSTE_DESCR ASC');
        $html='<option value="">Séléctionner</option>';
        foreach ($communes as $key)
        {
            $html.='<option value="'.$key['ID_POSTE'].'">'.$key['POSTE_DESCR'].'</option>';
        }
        echo json_encode($html);
    }

    //function appeller en callback pour checking si un processus a deja ete attribue a un meme profil
    public function check_service_id($service_id)
    {
        $check = $this->Model->getOne('pms_process_affectation_droit', array(
            'ID_PROCESSUS' => $this->input->post('PROCESS_ID'),
            'ID_SERVICE' => $service_id,
            'ID_POSTE' => $this->input->post('ID_POSTE')
        ));

        // print_r($check);
        // exit();

        if ($check)
        {
            $this->form_validation->set_message('check_service_id', '<font style="color:red;font-size:15px">Le processus lui a déjà été attribué</font>');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    // pour enregistrer les information
    public function save()
    {
        $this->form_validation->set_rules('SERVICE_ID','','required|callback_check_service_id',array('required'=>'<font style="color:red;font-size:15px">Le service  est obligatoire</font>')); 
        $this->form_validation->set_rules('ID_POSTE','','required',array('required'=>'<font style="color:red;font-size:15px">Le poste  est obligatoire</font>'));
        $this->form_validation->set_rules('PROCESS_ID','','required',array('required'=>'<font style="color:red;font-size:15px">Le processus  est obligatoire</font>'));
        if ($this->form_validation->run()==FALSE)
        {
            $data['services']=$this->Model->getList('pms_service');
            $data['process']=$this->Model->getRequete('SELECT pms_process.PROCESS_ID,pms_process.DESCRIPTION_PROCESS FROM `pms_process` WHERE IS_ACTIVE=1 ORDER BY pms_process.DESCRIPTION_PROCESS ASC;');


            if(!empty($this->input->post('SERVICE_ID')))
            {
              $data['postes']=$this->Model->getList('pms_poste_service',array('ID_SERVICE'=>$this->input->post('SERVICE_ID')));      
            }
            else
            {
              $data['postes']=array();
            }

            $this->load->view('Affect_audience_droit_view',$data);     
        }
        else
        {
            $data=array('ID_PROCESSUS'=>$this->input->post('PROCESS_ID'),
                        'ID_SERVICE'=>$this->input->post('SERVICE_ID'),
                        'ID_POSTE'=>$this->input->post('ID_POSTE'));
            $this->Model->create('pms_process_affectation_droit',$data);
            $data['message']='<div class="alert alert-success text-center " id="message">Enregistrement effectué avec succès</div>';
            $this->load->view('Affect_audience_droit_view',$data);

            redirect(base_url('administration/Affect_audience_droit/listing'));
        }
    }

    // pour recuperer les infos a afficher de la bd
    public function list()
    {
        $query_principal="SELECT pms_process_affectation_droit.ID_PROCESS_AFFECTATION_DROIT,pms_process.DESCRIPTION_PROCESS,pms_service.DESCRIPTION,pms_poste_service.POSTE_DESCR FROM `pms_process_affectation_droit` JOIN pms_service on pms_service.SERVICE_ID=pms_process_affectation_droit.ID_SERVICE JOIN pms_poste_service on pms_poste_service.ID_POSTE=pms_process_affectation_droit.ID_POSTE JOIN pms_process on pms_process.PROCESS_ID=pms_process_affectation_droit.ID_PROCESSUS WHERE 1";
        // print_r($query_principal);
        // exit();
        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;

		$limit='LIMIT 0,10';

		if($_POST['length'] != -1) {
			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
		}
		$order_column=array("ID_PROCESS_AFFECTATION_DROIT","pms_process.DESCRIPTION_PROCESS","pms_service.DESCRIPTION","pms_poste_service.POSTE_DESCR","");

        $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : 'ORDER  BY ID_PROCESS_AFFECTATION_DROIT  DESC';
        
		 $search = !empty($_POST['search']['value']) ? (" AND (pms_process.DESCRIPTION_PROCESS LIKE '%$var_search%' OR pms_service.DESCRIPTION LIKE '%$var_search%' OR pms_poste_service.POSTE_DESCR LIKE '%$var_search%')") : '';

         $critaire="";

         $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.'   '.$limit;

         $query_filter = $query_principal.' '.$critaire.' '.$search;

         $fetch_data= $this->Model->datatable($query_secondaire);

         $data = array();
         $u=0;
         foreach ($fetch_data as $row)
        {
			$u++;
			$sub_array = array();
			$sub_array[]= '<b>'.$u.'</b>';
			$sub_array[]=$row->DESCRIPTION_PROCESS;
			$sub_array[]=$row->DESCRIPTION;
			$sub_array[]=$row->POSTE_DESCR;

            $options="<button class='btn-primary' data-toggle='modal' 
            data-target='#mydelete" . $row->ID_PROCESS_AFFECTATION_DROIT . "'>Supprimer</button>";
			
            $options.= " </ul>
            </div>
            <div class='modal fade' id='mydelete" .$row->ID_PROCESS_AFFECTATION_DROIT. "'>
            <div class='modal-dialog'>
            <div class='modal-content'>

            <div class='modal-body'>
            <center><h5><strong>VOULEZ-VOUS EFFECTUE LA SUPPRESSION DU DROIT DU SERVICE</strong> : <b><i style='color:green;'>" . $row->DESCRIPTION."</i></b>  AYANT COMME PROFILE <b><i style='color:green;'>" . $row->POSTE_DESCR."</i></b> SUR LE PROCESSUS DE <b> <i style='color:green;'>" . $row->DESCRIPTION_PROCESS."</i></b>?</h5></center>
            </div>

            <div class='modal-footer'>
            <a class='btn btn-danger btn-md' href='" . base_url('administration/Affect_audience_droit/delete/'. $row->ID_PROCESS_AFFECTATION_DROIT) . "'>Supprimer</a>
            <button class='btn btn-warning btn-md' data-dismiss='modal'>Quitter</button>
            </div>

            </div>
            </div>
            </div>";

            $sub_array[]=$options;

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

    // pour afficher la liste
    public function listing()
    {
     $this->load->view('Affect_audience_droit_list_view');
    }

    // pour la suppression d'un enregsitrement
    public function delete()
    {
        $id=$this->uri->segment(4);

        $delete=$this->Model->delete('pms_process_affectation_droit',array('ID_PROCESS_AFFECTATION_DROIT '=>$id));

        $message['message']='<div class="alert alert-success text-center" id="message">La suppression a été effectuée avec succès</div>';
        $this->session->set_flashdata($message);
        
        redirect(base_url('administration/Affect_audience_droit/listing'));  
    }

}
?>
