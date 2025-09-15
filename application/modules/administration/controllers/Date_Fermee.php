<?php
/**
* @author Nadvaxe2024
* created on the 12th june 2024
* DEMANDE DES AUDIENCES
* advaxe@mediabox.bi
*/
class Date_Fermee extends Ci_Controller
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
          redirect(base_url('Login/Backend'));
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
        $data['process']=$this->Model->getRequete('SELECT pms_process.PROCESS_ID,pms_process.DESCRIPTION_PROCESS FROM `pms_process` WHERE IS_ACTIVE=1 ORDER BY pms_process.DESCRIPTION_PROCESS ASC;');
        $this->load->view('Date_Fermee_view',$data);
    }



    // pour enregistrer les information
    public function enregistrer()
    {
            $JRDV = date('Y-m-d', strtotime($this->input->post('DATE_CONGE')));
            $data=array('DATE_CONGE'=>$JRDV,
                        'DESC_CONGE'=>$this->input->post('MOTIF'),
                        'IS_OFFICIAL'=>$this->input->post('IS_OFFICIAL'));
            $this->Model->create('pms_date_fermees',$data);
            $data['message']='<div class="alert alert-success text-center " id="message">Enregistrement effectué avec succès</div>';
            redirect(base_url('administration/Date_Fermee/listing'));
    }
        // pour afficher la liste
    public function listing()
    {
     $this->load->view('Date_Fermee_list_view');
    }

    function liste()
    {   
        $var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
        $limit='LIMIT 0,10';
        if( isset($_POST['length']) && $_POST['length'] != -1) {
            $limit='LIMIT '.$_POST["start"].','.$_POST["length"];
        }
        $query_principal="SELECT `ID_CONGE`, `DATE_CONGE`, `DESC_CONGE`, `IS_OFFICIAL`, `STATUS` FROM `pms_date_fermees` WHERE 1";
 
        $order_column=array("ID_CONGE","DATE_CONGE","DESC_CONGE","STATUS","");
        
        $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER  BY ID_CONGE DESC';
        $search = !empty($_POST['search']['value']) ? (" AND (ID_CONGE LIKE '%$var_search%' OR DATE_CONGE LIKE '%$var_search%' OR STATUS LIKE '%$var_search%' OR DESC_CONGE LIKE '%$var_search%')") : '';
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
            $sub_array[]=$row->DESC_CONGE;
            $sub_array[] = date("d-m", strtotime($row->DATE_CONGE));
            if ($row->IS_OFFICIAL == 1) 
            {
                $sub_array[] = 'Officiel';
            } 
            else 
            {
                $sub_array[] = 'Particulier';
            }

            $options="<button class='btn-danger' data-toggle='modal' 
            data-target='#mydelete" . $row->ID_CONGE . "'>Supprimer</button> 
            <br>
            <br>
            <button class='btn-primary' data-toggle='modal' 
            data-target='#myactive" . $row->ID_CONGE . "'>Desactiver</button>";

            
            $options.= " </ul>
            </div>
            <div class='modal fade' id='mydelete" .$row->ID_CONGE. "'>
            <div class='modal-dialog'>
            <div class='modal-content'>

            <div class='modal-body'>
            <center><h5><strong>Voulez-vous supprimer le congé du </strong> : <b><i style='color:green;'>" . $row->DATE_CONGE."</i></b>  pour  <b><i style='color:green;'>" . $row->DESC_CONGE."</i></b>?</h5></center>
            </div>
            <div class='modal-footer'>
            <a class='btn btn-danger btn-md' href='" . base_url('administration/Date_Fermee/delete/'. $row->ID_CONGE) . "'>Supprimer</a>
            <button class='btn btn-warning btn-md' data-dismiss='modal'>Quitter</button>
            </div>
            </div>
            </div>
            </div>";
            $options.= " </ul>
            </div>
            <div class='modal fade' id='myactive" .$row->ID_CONGE. "'>
            <div class='modal-dialog'>
            <div class='modal-content'>
            <div class='modal-body'>
            <center><h5><strong>VOULEZ-VOUS DESACTIVER LE CONGE</strong> : <b><i style='color:green;'>" . $row->DESC_CONGE."</i></b>  FIXE AU <b><i style='color:green;'>" . $row->DESC_CONGE."</i></b>?</h5></center>
            </div>
            <div class='modal-footer'>
            <a class='btn btn-danger btn-md' href='" . base_url('administration/Date_Fermee/desactiver/'. $row->ID_CONGE) . "'>Desactiver</a>
            <button class='btn btn-warning btn-md' data-dismiss='modal'>Fermer</button>
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
            "data" => $data);
            
        echo json_encode($output);
    }
    


    // pour la suppression d'un enregsitrement
    public function delete()
    {
        $id=$this->uri->segment(4);

        $delete=$this->Model->delete('pms_date_fermees',array('ID_CONGE '=>$id));

        $message['message']='<div class="alert alert-success text-center" id="message">La suppression a été effectuée avec succès</div>';
        $this->session->set_flashdata($message);
        
        redirect(base_url('administration/Date_Fermee/listing'));  
    }

        // pour la changer de status 
    public function desactiver()
    {
        $id=$this->uri->segment(4);
        $New_status=2;
        $update=$this->Model->update('pms_date_fermees',array('ID_CONGE'=>$id),array('STATUS'=>$New_status));
        $message['message']='<div class="alert alert-danger text-center" id="message">La désactivation de votre congé a été effectuée avec succès</div>';
        $this->session->set_flashdata($message);
        redirect(base_url('administration/Date_Fermee/listing'));  
    }

}
?>
