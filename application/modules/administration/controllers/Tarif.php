<?php
 /**
 * fichier gestion ihm des tarifs
 *eriel@mediabox.bi
 *05-08-2025
 */

 class Tarif extends CI_Controller
 {
	public function __construct()
	{
		parent::__construct();

		$this->isAuth();
		require('fpdf184/fpdf.php');
	}


	//CHECK AUTHENTIFICATION
	public function isAuth()
	{
		if (empty($this->get_utilisateur())) 
		{
			redirect(base_url('Login'));
		}
	}

    //RECUPERATION DU LOGIN DE LA PERSONNE CONNECTEE
  public function get_utilisateur()
  {
    return $this->session->userdata('PMS_USER_ID');
  }

	public function index()
	{
	 $this->load->view('Tarif_list_view');
	}

	// recupere les informations dans la base
  public function list()
  {
      $var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
      $var_search=str_replace("'","\'",$var_search);
      $query_principal="SELECT
      pms_tarifs.TARIF_ID, 
	    pms_tarifs.DESCRIPTION_TARIF,
	    pms_tarifs.MONTANT_TARIF 
      FROM `pms_tarifs` 
      where 1 ";


      $limit = '';
      if (isset($_POST['length']) && $_POST['length'] != -1)
      {
          $limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
      }


      $order_by='';
      $order_column=array(1,'pms_tarifs.DESCRIPTION_TARIF',
      'pms_tarifs.MONTANT_TARIF');
      
      if ($order_by)
      {
        $order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY pms_tarifs.TARIF_ID ASC';
      }
      
      $search = !empty($_POST['search']['value']) ? (" AND (pms_tarifs.DESCRIPTION_TARIF LIKE '%$var_search%' OR pms_tarifs.MONTANT_TARIF LIKE '%$var_search%') ") : '';
      
      $critaire = '';
      
      $query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
      $query_filter = $query_principal.' '.$critaire.' '.$search;
      
      $fetch_data = $this->Model->datatable($query_secondaire);
      $data = array();
      $u=0;
    
      
      foreach ($fetch_data as $row)
      {
        $u++; 
        $sub_array=array(); 

        $sub_array[]= $u;
		    $sub_array[]= $row->DESCRIPTION_TARIF;	
		    $sub_array[]= number_format($row->MONTANT_TARIF,0,' ',' ').' fbu';	
        $sub_array[]='<a href="'.base_url('administration/Tarif/modifier/'.md5($row->TARIF_ID)).'" class="btn btn-info btn-sm"> Modifier </a>';
                   
        
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

  public function modifier($id)
  {   
      $data['infos']=$this->Model->getRequeteOne('SELECT pms_tarifs.TARIF_ID, 
      pms_tarifs.DESCRIPTION_TARIF,pms_tarifs.MONTANT_TARIF FROM `pms_tarifs`
      WHERE 1 and md5(TARIF_ID)="'.$id.'"');
     $this->load->view('Modifier_tarif_view',$data);      
  }

  public function enregistrer()
  {
    $this->form_validation->set_rules('MONTANT_TARIF','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champs tarif est obligatoire.</font>'));
    if($this->form_validation->run()==FALSE)
    {
      $data['data']=$this->input->post('TARIF_ID');

      $data['infos']=$this->Model->getRequeteOne('SELECT pms_tarifs.TARIF_ID, 
      pms_tarifs.DESCRIPTION_TARIF,pms_tarifs.MONTANT_TARIF FROM `pms_tarifs`
      WHERE 1 and TARIF_ID='.$data['data']);
     $this->load->view('Modifier_tarif_view',$data); 
    }
    else
    {
      $data['infos']=$this->Model->getRequeteOne('SELECT pms_tarifs.TARIF_ID, 
      pms_tarifs.DESCRIPTION_TARIF,pms_tarifs.MONTANT_TARIF FROM `pms_tarifs`
      WHERE 1 and TARIF_ID='.$this->input->post('TARIF_ID'));

      $data_historique=array('ANCIEN_MONTANT_TARIF' =>$data['infos']['MONTANT_TARIF'] ,'USER_ID'=>$this->session->userdata('PMS_USER_ID'));


      $this->Model->create('pms_tarifs_historique',$data_historique);

      $data=array('MONTANT_TARIF'=>$this->input->post('MONTANT_TARIF'));
      
      $this->Model->update('pms_tarifs',array('TARIF_ID'=>$this->input->post('TARIF_ID')),$data);
      

      $this->session->set_flashdata('message', 'La modification a été effectuée avec succès');

      redirect(base_url('administration/Tarif/')); 
    }    
  }

  public function add()
  {
    $this->load->view('Ajouter_tarif_view');
  }

  public function save()
  {
    $this->form_validation->set_rules('DESCRIPTION_TARIF','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champs est Obligatoire.</font>'));
    
    $this->form_validation->set_rules('MONTANT_TARIF','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champs est Obligatoire.</font>'));
    
   

    if($this->form_validation->run()==FALSE)
    {
      $this->load->view('Ajouter_tarif_view');
    }
    else
    {
      $data=array('DESCRIPTION_TARIF'=>$this->input->post('DESCRIPTION_TARIF'),'MONTANT_TARIF'=>$this->input->post('MONTANT_TARIF'));

      $this->Model->create('pms_tarifs',$data);

      $message['message']='<div class="alert alert-success text-center" id="message">L\'enregistrement a été effectué avec succès</div>';
            $this->session->set_flashdata($message);
      
      $this->session->set_flashdata('message', '<div class="alert alert-success text-center" id="message">L\'enregistrement a été effectué avec succès</div>');

      redirect(base_url('administration/Tarif/'));
    }
  }


 }

?>