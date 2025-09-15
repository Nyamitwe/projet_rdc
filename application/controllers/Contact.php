<?php 

	/**
	Prosper
	prosper@mediabox.bi
	79659162
	du 16/11 au 16/11/2022
	 * 
	 */
	//traitement des contact
	class Contact extends CI_Controller
	{
		
		function __construct()
		{
			# code...
			parent::__construct();
		}


		function index(){

			$data['contact']=$this->Model->getRequete("SELECT * FROM `pms_contact`");

			$this->load->view('includes_ep/Contact_View',$data);
		}
           // liste des contacts
		function liste($value='')
		{

			$this->load->view('includes/Contact_list_view');
		}

		function get_info($value='')
		{

            $critaire="";
			$var_search = !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
			$var_search=str_replace("'", "\'", $var_search);  

				$query_principal="SELECT CONTACT_ID, NOM, MAIL, TELEPHONE ,MESSAGE FROM `pms_contact` WHERE 1  ";

			$group="";
			$critaire="";
			$limit='LIMIT 0,10';
			if($_POST['length'] != -1){
				$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
			}
			$order_by=' ORDER BY CONTACT_ID DESC';			
			
			   $search = !empty($_POST['search']['value']) ? (" AND (CONTACT_ID LIKE '%$var_search%' OR NOM LIKE '%$var_search%' OR TELEPHONE LIKE '%$var_search%' OR MAIL  LIKE '%$var_search%'  OR MESSAGE LIKE '%$var_search%') ") : '';

			$query_secondaire=$query_principal.'  '.$critaire.' '.$search.' '.$group.' '.$order_by.'   '.$limit;
			$query_filter=$query_principal.' '.$critaire.' '.$search.' '.$group;
			$fetch_data = $this->Model->datatable($query_secondaire);

			$u=1;
			$data = array();
			foreach ($fetch_data as $row) {


				$sub_array = array();
				$sub_array[]=$u++;

				$sub_array[]=$row->NOM;
				$sub_array[]=$row->MAIL;
				$sub_array[]=$row->TELEPHONE;
				$sub_array[]=$row->MESSAGE;			

				$data[]=$sub_array;
			}     
			$output = array("draw" => intval($_POST['draw']),
				"recordsTotal" =>$this->Model->all_data($query_principal.' '.$group),
				"recordsFiltered" => $this->Model->filtrer($query_filter),
				"data" => $data);
			echo json_encode($output);
		}

           //ajout d'un nouveau contact
		public function ajouter()
		{
			$NOM=$this->input->post('NOM');
			$MAIL=$this->input->post('MAIL');
			$TELEPHONE=$this->input->post('TELEPHONE');
			$MESSAGE=$this->input->post('MESSAGE');

			$this->form_validation->set_rules('NOM','','trim|required',array('required'=>'<font style="font-size:15px;">*Le champ est Obligatoire</font>'));

			 $this->form_validation->set_rules('TELEPHONE','','required|is_unique[pms_utilisateurs.TELEPHONE]|min_length[8]',array(
          'required'=>'<font style="font-size:15px;">*Veuillez entrer le téléphone</font>',
          
          'min_length'=>'<font style="font-size:15px;">*Le téléphone doit contenir au minimum 8 chiffres</front>'));
			$this->form_validation->set_rules('MESSAGE','','trim|required',array('required'=>'<font style="font-size:15px;">*Le champ est Obligatoire</font>'));

			if ($this->form_validation->run()==false) {
			
				$this->index(); 
			}else{


				$contact=array(
					'NOM' =>$NOM, 
					'MAIL' =>$MAIL, 
					'TELEPHONE' =>$TELEPHONE, 
					'MESSAGE' =>$MESSAGE, 
				);

				$this->Model->create('pms_contact',$contact);
				redirect(base_url('Contact/liste'));

			}
		}
	}
	?>