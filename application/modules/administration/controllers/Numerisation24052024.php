<?php

/**
 * 
 */
class Numerisation extends Ci_Controller
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

	// redirection sur la page d'enregistrement
	public function index_old()
	{
  		$data['message'] = $this->session->flashdata('message');

    	$id = $this->uri->segment(4);

		$data['types_requerants']=$this->Model->getRequete('SELECT id,name FROM sf_guard_user_categories WHERE id in(1) ORDER BY name ASC');

		$data['nationalites']=$this->Model->getRequete('SELECT id,name FROM countries ORDER BY name ASC');

		$data['sexes']=$this->Model->getRequete('SELECT SEXE_ID,DESCRIPTION_SEXE FROM pms_sexe ORDER BY DESCRIPTION_SEXE ASC');

		$data['provinces_naissance']=$this->Model->getList('syst_provinces');

		$data['info_physique']="style='display:block;'";

		$data['info_morale']="style='display:none;'";

		$data['info_prov_naissance']="style='display:block;'";

		$data['info_com_naissance']="style='display:block;'";

	    $check_existence=$this->Model->getOne('sf_guard_user_profile',array('md5(id)'=>$id));

		if(empty($id))
		{
			$info=array('id'=>NULL,
				'type_requerant_id'=>NULL,
				'sexe_id'=>NULL,
				'nationalite_id'=>NULL,
				'LIEU_DELIVRANCE'=>NULL,
				'NOM_PRENOM_PROP'=>NULL,
				'DATE_NAISSANCE'=>NULL,
				'PHOTO_PASSEPORT_PROP'=>NULL,
				'SIGNATURE_PROP'=>NULL,
				'NUM_CNI_PROP'=>NULL,
				'CNI_IMAGE_PROP'=>NULL,
				'DATE_DELIVRANCE'=>NULL,
				'PROVINCE_ID'=>NULL,
				'COMMUNE_ID'=>NULL,
				'ZONE_ID'=>NULL,
				'COLLINE_ID'=>NULL,
				'EMAIL_PROP'=>NULL,
				'NUM_TEL_PROP'=>NULL,
				'NOM_PRENOM_PERE'=>NULL,
				'NOM_PRENOM_MERE'=>NULL);
			$data['communes']=array();
		}
		else
		{

			$dateString = $check_existence['date_delivrance'];
			$timestamp = strtotime($dateString);

			if ($timestamp !== false) {
				$formattedDate = date('Y-m-d', $timestamp);
			} else {
				$formattedDate = '';              
			}
	
	      $info=array('id'=>$id,
	      	'type_requerant_id'=>$check_existence['registeras'],
	      	'nationalite_id'=>$check_existence['country_code'],
			'sexe_id'=>$check_existence['sexe_id'],
	      	'LIEU_DELIVRANCE'=>$check_existence['lieu_delivrance_cni'],
	      	'NOM_PRENOM_PROP'=>$check_existence['fullname'],
	      	'DATE_NAISSANCE'=>$check_existence['date_naissance'],
	      	'PHOTO_PASSEPORT_PROP'=>$check_existence['profile_pic'],
	      	'SIGNATURE_PROP'=> $check_existence['path_signature'],
	      	'NUM_CNI_PROP'=>$check_existence['cni'],
	      	'CNI_IMAGE_PROP'=>$check_existence['path_cni'],
	      	'DATE_DELIVRANCE'=>$formattedDate,
	      	'PROVINCE_ID'=>$check_existence['provence_id'],
	      	'COMMUNE_ID'=>$check_existence['commune_id'],
	      	'ZONE_ID'=>$check_existence['zone_id'],
	      	'COLLINE_ID'=>$check_existence['colline_id'],
	      	'EMAIL_PROP'=>$check_existence['email'],
	      	'NUM_TEL_PROP'=>$check_existence['mobile'],
	      	'NOM_PRENOM_PERE'=>$check_existence['father_fullname'],
	      	'NOM_PRENOM_MERE'=>$check_existence['mother_fullname']);
	      $data['communes']=$this->Model->getList('communes',array('PROVINCE_ID'=>$check_existence['provence_id']));	
  	    }


	    $data['info']=$info;

	  $this->load->view('Numerisation_add_view',$data);
	}


	// fonction appeler automatiquement lorque le controlleur est executer
  public function index()
	{
  	$data['message'] = $this->session->flashdata('message');

    $id = $this->uri->segment(4);

		$data['types_requerants']=$this->Model->getRequete('SELECT id,name FROM sf_guard_user_categories WHERE id in(1) ORDER BY name ASC');

		$data['nationalites']=$this->Model->getRequete('SELECT id,name FROM countries ORDER BY name ASC');

		$data['sexes']=$this->Model->getRequete('SELECT SEXE_ID,DESCRIPTION_SEXE FROM pms_sexe ORDER BY DESCRIPTION_SEXE ASC');

		$data['provinces_naissance']=$this->Model->getList('syst_provinces');

		$data['info_physique']="style='display:block;'";

		$data['info_morale']="style='display:none;'";

		$data['info_prov_naissance']="style='display:block;'";

		$data['info_com_naissance']="style='display:block;'";

		$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
		$data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

		$data['provinces']=$this->Model->getList('syst_provinces');

		$this->load->view('Numeriser_add_view',$data);
	}



	// recuperation dynamique des communes par rapport a la province
	public	function get_commune_naissance($PROVINCE_ID=0)
	{
		$communes=$this->Model->getRequete('SELECT COMMUNE_ID,COMMUNE_NAME FROM communes WHERE PROVINCE_ID='.$PROVINCE_ID.' ORDER BY COMMUNE_NAME ASC');
		$html='<option value="">Sélectionner</option>';
		foreach ($communes as $commune)
		{
			$html.='<option value="'.$commune['COMMUNE_ID'].'">'.$commune['COMMUNE_NAME'].'</option>';

		}
		echo json_encode($html);
	}

    // recuperation dynamique des zones par rapport a la commune
	public function get_zone_parcelle($COMMUNE_ID=0)
	{
		$zones=$this->Model->getRequete('SELECT ZONE_ID,ZONE_NAME FROM pms_zones WHERE COMMUNE_ID='.$COMMUNE_ID.' ORDER BY ZONE_NAME ASC');


		$html='<option value="">Sélectionner</option>';
		foreach ($zones as $key)
		{
			$html.='<option value="'.$key['ZONE_ID'].'">'.$key['ZONE_NAME'].'</option>';

		}
		echo json_encode($html);
	}

  // recuperation dynamique des collines par rapport a la zone
	public function get_colline_parcelle($ZONE_ID=0)
	{
		$collines=$this->Model->getRequete('SELECT COLLINE_ID,COLLINE_NAME FROM collines WHERE ZONE_ID='.$ZONE_ID.' ORDER BY COLLINE_NAME ASC');

		$html='<option value="">Sélectionner</option>';
		foreach ($collines as $key)
		{
			$html.='<option value="'.$key['COLLINE_ID'].'">'.$key['COLLINE_NAME'].'</option>';

		}
		echo json_encode($html);
	}


	//PERMET L'UPLOAD DE LA SIGNATURE
	public function upload_file_signature($input_name)
	{
		$nom_file = $_FILES[$input_name]['tmp_name'];
		$nom_champ = $_FILES[$input_name]['name'];
		$ext=pathinfo($nom_champ, PATHINFO_EXTENSION);
		$repertoire_fichier = FCPATH . 'uploads/doc_scanner/';	
		$code=uniqid();
		$name=$code . 'SIGNATURE.' .$ext;
		$file_link = $repertoire_fichier . $name;


        // $fichier = basename($nom_champ);
		if (!is_dir($repertoire_fichier)) {
			mkdir($repertoire_fichier, 0777, TRUE);
		}
		move_uploaded_file($nom_file, $file_link);
		return $name;
	}

	//PERMET L'UPLOAD DE L'IMAGE CNI / PASSEPORT
	public function upload_file_cni($input_name)
	{
		$nom_file = $_FILES[$input_name]['tmp_name'];
		$nom_champ = $_FILES[$input_name]['name'];
		$ext=pathinfo($nom_champ, PATHINFO_EXTENSION);
		$repertoire_fichier = FCPATH . 'uploads/doc_scanner/';
		$code=uniqid();
		$name=$code . 'IMAGE_CNI.' .$ext;
		$file_link = $repertoire_fichier . $name;


    	// $fichier = basename($nom_champ);
		if (!is_dir($repertoire_fichier)) {
			mkdir($repertoire_fichier, 0777, TRUE);
		}
		move_uploaded_file($nom_file, $file_link);
		return $name;
	}

  //form validation sur la saisie du numero de cni  
  public function check_existence_num_cni()
  {
      $id = $this->input->post('user_id');
      $cni = $this->input->post('NUM_CNI_PROP');
	
      $test = TRUE;

	    $verify_info=$this->Model->getRequeteOne('SELECT * from sf_guard_user_profile WHERE md5(id)!="'.$id.'" AND cni="'.$cni.'" ');	  
      if(!empty($verify_info))
      {
        $test = FALSE;
        $this->form_validation->set_message('check_existence_num_cni', "<font color='red'>Le numero de cni saisi appartient à un autre.</font>");
      }
      return $test;
  }

  //form validation sur la saisie de l'adresse mail
  public function check_existence_email()
  {
      $id = $this->input->post('user_id');
      $email = $this->input->post('email');
	
      $test = TRUE;

	   $verify_info=$this->Model->getRequeteOne('SELECT * from sf_guard_user_profile WHERE md5(id)!="'.$id.'" AND email="'.$email.'" ');


      if(!empty($verify_info))
      {
        $test = FALSE;
        $this->form_validation->set_message('check_existence_email', "<font color='red'>L\'adresse mail saisi appartient à un autre.</font>");
      }
      return $test;
  }

	// function d'enregistrement des info d'un requerant
  public function add_info_requerant_OLD()
  {
    	$TYPE_REQUERANT_ID=$this->input->post('type_requerant_id');


    	$this->form_validation->set_rules('type_requerant_id','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));


    	if($this->input->post('type_requerant_id')==1)
    	{

    		if(!empty($this->input->post('user_id')))
    		{
    			$this->form_validation->set_rules('NUM_CNI_PROP','', 'trim|required|callback_check_existence_num_cni',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

    		}
    		else
    		{
    			$this->form_validation->set_rules('NUM_CNI_PROP','', 'trim|required|is_unique[sf_guard_user_profile.cni]',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>','is_unique'=>'le numero de cni saisie existe deja.'));
    		}

    		if(!empty($this->input->post('user_id')))
    		{
    			$this->form_validation->set_rules('EMAIL_PROP','', 'trim|required|callback_check_existence_email',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
    		}
    		else
    		{
    			$this->form_validation->set_rules('EMAIL_PROP','', 'trim|required|is_unique[sf_guard_user_profile.email]',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>','is_unique'=>'l\'email saisie existe deja.'));
    		}

    		$this->form_validation->set_rules('nationalite_id','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">La séléction est Obligatoire.</font>'));

    		$this->form_validation->set_rules('sexe_id','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">La séléction est Obligatoire.</font>'));

    		$this->form_validation->set_rules('NOM_PRENOM_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

    		$this->form_validation->set_rules('DATE_NAISSANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

    		$this->form_validation->set_rules('NUM_TEL_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

    		$this->form_validation->set_rules('NOM_PRENOM_PERE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

    		$this->form_validation->set_rules('NOM_PRENOM_MERE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

    		if($this->input->post('nationalite_id')==28)
    		{
    			$this->form_validation->set_rules('PROVINCE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
    			$this->form_validation->set_rules('COMMUNE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));          
    		}        

    		$this->form_validation->set_rules('DATE_DELIVRANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
    		$this->form_validation->set_rules('LIEU_DELIVRANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

		    // if(!isset($_FILES['PHOTO_PASSEPORT_PROP']) || empty($_FILES['PHOTO_PASSEPORT_PROP']['name']) && empty($this->input->post('user_id')) )
		      // {
		    //   $this->form_validation->set_rules('PHOTO_PASSEPORT_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">L\'upload est Obligatoire</font>'));
		        // }

    		if(!isset($_FILES['SIGNATURE_PROP']) || empty($_FILES['SIGNATURE_PROP']['name']) && empty($this->input->post('user_id')) )
    		{
    			$this->form_validation->set_rules('SIGNATURE_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">L\'upload est Obligatoire</font>'));
    		}

    		if(!isset($_FILES['CNI_IMAGE_PROP']) || empty($_FILES['CNI_IMAGE_PROP']['name']) && empty($this->input->post('user_id')))
    		{
    			$this->form_validation->set_rules('CNI_IMAGE_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">L\'upload est Obligatoire</font>'));
    		}       
    	}

    	if($this->input->post('type_requerant_id')==5)
    	{
    		$this->form_validation->set_rules('NOM_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
    		$this->form_validation->set_rules('NIF_RC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));        
    	}

    	if($this->form_validation->run()==FALSE)
    	{
    		$data['provinces_naissance']=$this->Model->getList('syst_provinces');

       		 // 1:type public; 5: type morale
    		$data['types_requerants']=$this->Model->getRequete('SELECT id,name FROM sf_guard_user_categories WHERE id in(1) ORDER BY name ASC');

    		$data['sexes']=$this->Model->getRequete('SELECT SEXE_ID,DESCRIPTION_SEXE FROM pms_sexe ORDER BY DESCRIPTION_SEXE ASC');


    		$data['nationalites']=$this->Model->getRequete('SELECT id,name FROM countries ORDER BY name ASC');


    		if($this->input->post('type_requerant_id')==1 || $this->input->post('type_requerant_id')=='')
    		{
    			$data['info_physique']="style='display:block;'";
    			$data['info_morale']="style='display:none;'";
    		}
    		elseif($this->input->post('type_requerant_id')==5)
    		{
    			$data['info_morale']="style='display:block;'";
    			$data['info_physique']="style='display:none;'";
    		}

    		if($this->input->post('nationalite_id')==28 || $this->input->post('nationalite_id')=='')
    		{
    			$data['info_prov_naissance']="style='display:block;'";
    			$data['info_com_naissance']="style='display:block;'";
    		}
    		else
    		{
    			$data['info_prov_naissance']="style='display:none;'";
    			$data['info_com_naissance']="style='display:none;'";
    		}


    		if(!empty($this->input->post('PROVINCE_ID')))
    		{
    			$data['communes']=$this->Model->getList('communes',array('PROVINCE_ID'=>$this->input->post('PROVINCE_ID')));			
    		}
    		else
    		{
    			$data['communes']=array();
    		}

    		if(!empty($this->input->post('COMMUNE_ID')))
    		{
    			$data['zones']=$this->Model->getList('pms_zones',array('COMMUNE_ID'=>$this->input->post('COMMUNE_ID')));     
    		}
    		else
    		{
    			$data['zones']=array();
    		}



    		if(!empty($this->input->post('COLLINE_ID')))
    		{
    			$data['collines']=$this->Model->getList('collines',array('COLLINE_ID'=>$this->input->post('COLLINE_ID')));     
    		}
    		else
    		{
    			$data['collines']=array();
    		}

    		$info=array('id'=>$this->input->post('user_id'),
    			'type_requerant_id'=>$TYPE_REQUERANT_ID,
    			'nationalite_id'=>$this->input->post('nationalite_id'),
    			'sexe_id'=>$this->input->post('sexe_id'),				
    			'LIEU_DELIVRANCE'=>$this->input->post('LIEU_DELIVRANCE'),
    			'NOM_PRENOM_PROP'=>$this->input->post('NOM_PRENOM_PROP'),
    			'DATE_NAISSANCE'=>$this->input->post('DATE_NAISSANCE'),
    			'PHOTO_PASSEPORT_PROP'=>$this->input->post('PHOTO_PASSEPORT_PROP'),
    			'SIGNATURE_PROP'=>$this->input->post('SIGNATURE_PROP'),
    			'NUM_CNI_PROP'=>$this->input->post('NUM_CNI_PROP'),
    			'CNI_IMAGE_PROP'=>$this->input->post('CNI_IMAGE_PROP'),
    			'DATE_DELIVRANCE'=>$this->input->post('DATE_DELIVRANCE'),
    			'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
    			'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
    			'ZONE_ID'=>$this->input->post('ZONE_ID'),
    			'COLLINE_ID'=>$this->input->post('COLLINE_ID'),
    			'EMAIL_PROP'=>$this->input->post('EMAIL_PROP'),
    			'NUM_TEL_PROP'=>$this->input->post('NUM_TEL_PROP'),
    			'NOM_PRENOM_PERE'=>$this->input->post('NOM_PRENOM_PERE'),
    			'NOM_PRENOM_MERE'=>$this->input->post('NOM_PRENOM_MERE'));

    		$data['info'] =$info;

    		$this->load->view('Numerisation_add_view',$data);
    	}
    	else
    	{
    		$user_id='';

    		$cni_nif=$this->input->post('NUM_CNI_PROP');


    		$message='<div class="alert alert-danger text-center" id="message">'.lang('requerant_existant').'</div>';

    		if(empty($this->input->post('user_id')))
    		{
    			$data_sf_guard_user_profile=array(
    				'email'=>$this->input->post('EMAIL_PROP'),
    				'fullname'=>$this->input->post('NOM_PRENOM_PROP'),
    				'sexe_id'=>$this->input->post('sexe_id'),
    				'username'=>$this->input->post('EMAIL_PROP'),
    				'password'=>'',
    				'date_naissance'=>$this->input->post('DATE_NAISSANCE'),
    				'mobile'=>$this->input->post('NUM_TEL_PROP'),
    				'registeras'=>$this->input->post('type_requerant_id'),
    				'date_delivrance'=>$this->input->post('DATE_DELIVRANCE'),
    				'country_code'=>$this->input->post('nationalite_id'),
    				'lieu_delivrance_cni'=>$this->input->post('LIEU_DELIVRANCE'),
    				'systeme_id'=>2,
    				'cni'=>$cni_nif,
    				'path_cni'=>$this->upload_file_cni('CNI_IMAGE_PROP'),
    				'profile_pic'=>$this->upload_file_cni('PHOTO_PASSEPORT_PROP'),
    				'numerise'=>1,
    				'provence_id'=>$this->input->post('PROVINCE_ID'),
    				'father_fullname'=>$this->input->post('NOM_PRENOM_PERE'),
    				'path_signature'=> $this->upload_file_signature('SIGNATURE_PROP'),
    				'mother_fullname'=>$this->input->post('NOM_PRENOM_MERE'),
    				'commune_id'=>$this->input->post('COMMUNE_ID')
    			);

    			$valeur=$this->Model->insert_last_id('sf_guard_user_profile',$data_sf_guard_user_profile); 

    			redirect(base_url('administration/Numerisation/info_parcelle/'.md5($valeur)));
    		}
    		else
    		{
    			$img_cni=$this->upload_file_signature('CNI_IMAGE_PROP');

    			if($this->input->post('CNI_IMAGE_PROP')=="")
    			{
    				$img_cni=$this->input->post('CNI_IMAGE_PROP_NEW');
    			}

    			$passport=$this->upload_file_cni('PHOTO_PASSEPORT_PROP');

    			if($this->input->post('PHOTO_PASSEPORT_PROP')=="")
    			{
    				$passport=$this->input->post('PHOTO_PASSEPORT_PROP_NEW');
    			}


    			$img_signature=$this->upload_file_signature('SIGNATURE_PROP');

    			if($this->input->post('SIGNATURE_PROP')=="")
    			{
    				$img_signature=$this->input->post('SIGNATURE_PROP_NEW');
    			}

    			$data_sf_guard_user_profile=array(
    				'email'=>$this->input->post('EMAIL_PROP'),
    				'username'=>$this->input->post('EMAIL_PROP'),	
    				'sexe_id'=>$this->input->post('sexe_id'),							
    				'fullname'=>$this->input->post('NOM_PRENOM_PROP'),
    				'date_naissance'=>$this->input->post('DATE_NAISSANCE'),
    				'mobile'=>$this->input->post('NUM_TEL_PROP'),
    				'registeras'=>$this->input->post('type_requerant_id'),
    				'date_delivrance'=>$this->input->post('DATE_DELIVRANCE'),
    				'country_code'=>$this->input->post('nationalite_id'),
    				'lieu_delivrance_cni'=>$this->input->post('LIEU_DELIVRANCE'),
    				'systeme_id'=>2,
    				'cni'=>$cni_nif,
    				'path_cni'=>$this->upload_file_cni('CNI_IMAGE_PROP'),
    				'profile_pic'=>$this->upload_file_cni('PHOTO_PASSEPORT_PROP'),
    				'numerise'=>1,
    				'provence_id'=>$this->input->post('PROVINCE_ID'),
    				'father_fullname'=>$this->input->post('NOM_PRENOM_PERE'),
    				'path_signature'=> $img_signature,
    				'mother_fullname'=>$this->input->post('NOM_PRENOM_MERE'),
    				'commune_id'=>$this->input->post('COMMUNE_ID')
    			);


    			$this->Model->update('sf_guard_user_profile',array('md5(id)'=>$this->input->post('user_id')),$data_sf_guard_user_profile);

    			redirect(base_url('administration/Numerisation/info_parcelle/'.md5($this->input->post('user_id'))));                      
    		}
    	}
  }

	// function d'enregistrement des info d'un requerant
	public function add_info_requerant()
	{
			$PROVINCE_ID1=$this->input->post('PROVINCE_ID1');
			$COMMUNE_ID1=$this->input->post('COMMUNE_ID1');
			$ZONE_ID1=$this->input->post('ZONE_ID1');
			$COLLINE_ID1=$this->input->post('COLLINE_ID1');

			$this->form_validation->set_rules('type_requerant_id','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('SEXE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">La selection est Obligatoire.</font>'));

			$this->form_validation->set_rules('NUM_CNI_PROP','', 'trim|required|is_unique[sf_guard_user_profile.cni]',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>','is_unique'=>'le numero de cni saisie existe deja.'));

			$this->form_validation->set_rules('EMAIL_PROP','', 'trim|required|is_unique[sf_guard_user_profile.email]',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>','is_unique'=>'l\'email saisie existe deja.'));

			$this->form_validation->set_rules('nationalite_id','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NOM_PRENOM_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('DATE_NAISSANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NUM_TEL_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NOM_PRENOM_PERE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NOM_PRENOM_MERE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

			if($this->input->post('nationalite_id')==28)
			{
				$this->form_validation->set_rules('PROVINCE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
				$this->form_validation->set_rules('COMMUNE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));          
			}

			$this->form_validation->set_rules('DATE_DELIVRANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('LIEU_DELIVRANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

			if(!isset($_FILES['SIGNATURE_PROP']) || empty($_FILES['SIGNATURE_PROP']['name']) && empty($this->input->post('user_id')) )
			{
				$this->form_validation->set_rules('SIGNATURE_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">L\'upload est Obligatoire</font>'));
			}

			if(!isset($_FILES['CNI_IMAGE_PROP']) || empty($_FILES['CNI_IMAGE_PROP']['name']) && empty($this->input->post('user_id')))
			{
				$this->form_validation->set_rules('CNI_IMAGE_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">L\'upload est Obligatoire</font>'));
			}

			if($this->input->post('type_requerant_id')==5)
			{
				$this->form_validation->set_rules('NOM_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
				$this->form_validation->set_rules('NIF_RC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));        
			}

			$this->form_validation->set_rules('NUM_PARCEL','', 'trim|required|is_unique[parcelle.NUMERO_PARCELLE]',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NATURE_DOC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NUMERO_SPECIAL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('VOLUME','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('FOLIO','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

			$this->form_validation->set_rules('SUPER_HA','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('SUPER_ARE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('SUPER_CA','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

			$this->form_validation->set_rules('PROVINCE_ID1','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('COMMUNE_ID1','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('ZONE_ID1','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('COLLINE_ID1','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

			$this->form_validation->set_rules('USAGE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NUM_CADASTRE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

			if($this->form_validation->run()==FALSE)
			{
				$data['provinces_naissance']=$this->Model->getList('syst_provinces');
	      
	      // 1:type public; 5: type morale			
				$data['types_requerants']=$this->Model->getRequete('SELECT id,name FROM sf_guard_user_categories WHERE id in(1) ORDER BY name ASC');
				
				$data['nationalites']=$this->Model->getRequete('SELECT id,name FROM countries ORDER BY name ASC');

				$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
				
				$data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');
				
				$data['sexes']=$this->Model->getRequete('SELECT SEXE_ID,DESCRIPTION_SEXE FROM pms_sexe ORDER BY DESCRIPTION_SEXE ASC');

				$data['provinces']=$this->Model->getList('syst_provinces');

				if($this->input->post('type_requerant_id')==1 || $this->input->post('type_requerant_id')=='')
				{
					$data['info_physique']="style='display:block;'";
					$data['info_morale']="style='display:none;'";
				}
				elseif($this->input->post('type_requerant_id')==5)
				{
					$data['info_morale']="style='display:block;'";
					$data['info_physique']="style='display:none;'";
				}

				if($this->input->post('nationalite_id')==28 || $this->input->post('nationalite_id')=='')
				{
					$data['info_prov_naissance']="style='display:block;'";
					$data['info_com_naissance']="style='display:block;'";
				}
				else
				{
					$data['info_prov_naissance']="style='display:none;'";
					$data['info_com_naissance']="style='display:none;'";
				}

				if(!empty($this->input->post('PROVINCE_ID')))
				{
					$data['communes']=$this->Model->getList('communes',array('PROVINCE_ID'=>$this->input->post('PROVINCE_ID')));      
				}
				else
				{
					$data['communes']=array();
				}

				if(!empty($this->input->post('PROVINCE_ID1')))
				{
					$data['communes_parcelles']=$this->Model->getList('communes',array('PROVINCE_ID'=>$PROVINCE_ID1));     
				}
				else
				{
					$data['communes_parcelles']=array();
				}




				if(!empty($this->input->post('COMMUNE_ID1')))
				{
					$data['zones_parcelles']=$this->Model->getList('pms_zones',array('COMMUNE_ID'=>$COMMUNE_ID1));     
				}
				else
				{
					$data['zones_parcelles']=array();
				}



				if(!empty($this->input->post('ZONE_ID1')))
				{
					$data['collines_parcelles']=$this->Model->getList('collines',array('ZONE_ID'=>$ZONE_ID1));     
				}
				else
				{
					$data['collines_parcelles']=array();
				}

				$this->load->view('Numeriser_add_view',$data);
			}
			else
			{
			  // Conversion factors
				$haToSqM = 10000;
				$acresToSqM = 100;
				$centiaresToSqM = 0.01;

				$ha = $this->input->post('SUPER_HA');
				$acres = $this->input->post('SUPER_ARE');
				$centiares = $this->input->post('SUPER_CA');

		    // Convert values to square meters
				$haSqM = $ha * $haToSqM;
				$acresSqM = $acres * $acresToSqM;
				$centiaresSqM = $centiares * $centiaresToSqM;

		    // Calculate total area
				$totalAreaSqM = $haSqM + $acresSqM + $centiaresSqM;

				//generation pwd
				$mot_de_passe=$this->password_generer();
				$hashedPassword=password_hash($mot_de_passe,PASSWORD_DEFAULT);

				$special_caractere=array('/','-','.','"',"'","*",'<','>','|',':','?');
				$avoid_slashes=str_replace($special_caractere,"-",$this->input->post('NUM_PARCEL'));
				$netoyage_avoid_slashes = preg_replace('/[^A-Za-z0-9\-]/', '', $avoid_slashes);

				$get_province_token=$this->Model->getOne('edrms_dossiers_processus_province',array('province_id'=>$this->input->post('PROVINCE_ID1'),'dossier_processus_id'=>$this->input->post('NATURE_DOC')));

				$result_alf=$this->pms_alfresco_lib->get_folder_content($get_province_token['token_dossiers_processus_province']);
	      // print_r($result_alf);
	      // exit();

				$result=$this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));

		    $token_repertoire_doc_box='';//le token du dossier de la parcelle
		    $nom_sous_repertoire_doc_box='';
		    $token_sous_repertoire_doc_box='';

		    if(json_decode($result)->detail_fold->nom_folder==$this->input->post('NUM_PARCEL'))
		    {
			    $token_repertoire_doc_box= json_decode($result)->detail_fold->fold_parrent_token; //le token du dossier de la parcelle
			    $nom_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->nom_folder;
			    $token_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->token;
			  }

			  $var='';
			  $id='';
			  $name='';
			  $foundMatchRepertoire = false;
			  $foundMatchSousRepertoire = false;

			  foreach ($result_alf as $entry)
			  {
			  	$entryName = $entry['name'];
	             // Remove special characters and spaces
			  	$cleanedEntryName = preg_replace('/[^A-Za-z0-9\-]/', '', $entryName);

			  	if (strcasecmp($cleanedEntryName, $netoyage_avoid_slashes) == 0)
			  	{
			  		$id = $entry['id'];
			  		$name = $entry['name'];
			  		$foundMatchRepertoire = true;
	           break; // Exit the loop after finding the matching entry
	         }
	      }

	      $result_token_sous_repertoire=$this->pms_alfresco_lib->get_folder_content($id); 

	      $nom_sous_repertoire_alf='';
	      $token_sous_repertoire_alf='';

	      foreach ($result_token_sous_repertoire as $entry)
	      {
	       	$entryName = $entry['name'];
	         // Remove special characters and spaces

	       	$token_sous_repertoire_alf = $entry['id'];
	       	$nom_sous_repertoire_alf = $entry['name'];
	       	$foundMatchSousRepertoire = true;
	         break; // Exit the loop after finding the matching entry
	      }

	      if((json_decode($var)->status==200) || ($foundMatchRepertoire==true && $foundMatchSousRepertoire==true))
	      {
	       	$data_sf_guard_user_profile=array(
	       		'email'=>$this->input->post('EMAIL_PROP'),
	       		'fullname'=>$this->input->post('NOM_PRENOM_PROP'),
	       		'sexe_id'=>$this->input->post('sexe_id'),
	       		'username'=>$this->input->post('EMAIL_PROP'),
	       		'password'=>$hashedPassword,
	       		'date_naissance'=>$this->input->post('DATE_NAISSANCE'),
	       		'mobile'=>$this->input->post('NUM_TEL_PROP'),
	       		'registeras'=>$this->input->post('type_requerant_id'),
	       		'date_delivrance'=>$this->input->post('DATE_DELIVRANCE'),
	       		'country_code'=>$this->input->post('nationalite_id'),
	       		'lieu_delivrance_cni'=>$this->input->post('LIEU_DELIVRANCE'),
	       		'systeme_id'=>2,
	       		'cni'=>$this->input->post('NUM_CNI_PROP'),
	       		'sexe_id'=>$this->input->post('SEXE_ID'),
	       		'path_cni'=>$this->upload_file_cni('CNI_IMAGE_PROP'),
	       		'profile_pic'=>$this->upload_file_cni('PHOTO_PASSEPORT_PROP'),
	       		'numerise'=>1,
	       		'provence_id'=>$this->input->post('PROVINCE_ID'),
	       		'father_fullname'=>$this->input->post('NOM_PRENOM_PERE'),
	       		'path_signature'=> $this->upload_file_signature('SIGNATURE_PROP'),
	       		'mother_fullname'=>$this->input->post('NOM_PRENOM_MERE'),
	       		'commune_id'=>$this->input->post('COMMUNE_ID')
	       	);

	       	$sf_guard_user_last_id=$this->Model->insert_last_id('sf_guard_user_profile',$data_sf_guard_user_profile); 

	       	$data_parcelle=array('NUMERO_PARCELLE'=>$this->input->post('NUM_PARCEL'),
	       		'SUPERFICIE'=>$totalAreaSqM,
	       		'PRIX'=>1000000,
	       		'STATUT_ID'=>3,
	       		'PROVINCE_ID'=>$this->input->post('PROVINCE_ID1'),
	       		'COMMUNE_ID'=>$this->input->post('COMMUNE_ID1'),
	       		'ZONE_ID'=>$this->input->post('ZONE_ID1'),
	       		'COLLINE_ID'=>$this->input->post('COLLINE_ID1')
	       	);

	       	$parcelle_last_id=$this->Model->insert_last_id('parcelle',$data_parcelle);

	       	$data_parcelle_attribution=array('ID_PARCELLE'=>$parcelle_last_id,
	       		'ID_REQUERANT'=>$sf_guard_user_last_id,
	       		'NUMERO_PARCELLE'=>$this->input->post('NUM_PARCEL'),
	       		'SUPERFICIE'=>$totalAreaSqM,
	       		'PRIX'=>1000000,
	       		'STATUT_ID'=>3,
	       		'SUPERFICIE_HA'=>$this->input->post('SUPER_HA'),
	       		'SUPERFICIE_ARE'=>$this->input->post('SUPER_ARE'),
	       		'SUPERFICIE_CA'=>$this->input->post('SUPER_CA'),
	       		'PROVINCE_ID'=>$this->input->post('PROVINCE_ID1'),
	       		'COMMUNE_ID'=>$this->input->post('COMMUNE_ID1'),
	       		'ZONE_ID'=>$this->input->post('ZONE_ID1'),
	       		'COLLINE_ID'=>$this->input->post('COLLINE_ID1'),
	       		'NUMERO_CADASTRAL'=>$this->input->post('NUM_CADASTRE'),
	       		'USAGE_ID'=>$this->input->post('USAGE'),
	       		'VOLUME'=>$this->input->post('VOLUME'),
	       		'FOLIO'=>$this->input->post('FOLIO'),
	       		'NUMERO_ORDRE_SPECIAL'=>$this->input->post('NUMERO_SPECIAL')
	       	);

	       	$result_parcelle_attribution=$this->Model->insert_last_id('parcelle_attribution',$data_parcelle_attribution);

	       	$result_parcelle_new=$this->Model->insert_last_id('edrms_repertoire_processus_parcelle_new',array('dossiers_processus_province_id'=>$get_province_token['id'],'parcelle_id'=>$parcelle_last_id,'numero_parcelle'=>$this->input->post('NUM_PARCEL'),'nom_repertoire_parcelle'=>$name,'token_dossiers_parcelle_processus'=>$id,'DOC_TOKEN'=>$token_repertoire_doc_box,'dossier_id'=>$this->input->post('NATURE_DOC'))
	       );

	       	$this->Model->create('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$result_parcelle_new,'parcelle_id'=>$parcelle_last_id,'nom_sous_repertoire'=>$nom_sous_repertoire_alf,'nom_sous_repertoire_doc'=>$nom_sous_repertoire_doc_box,'token_sous_repertoire'=>$token_sous_repertoire_alf,'DOC_REF_TOKEN'=>$token_sous_repertoire_doc_box,'statut_actualisation'=>1));

	       	$province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$this->input->post('PROVINCE_ID1')));

	       	$communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$this->input->post('COMMUNE_ID1').' ');
	       	$mailTo=$this->input->post('EMAIL_PROP');
	       	$subject='Information';

	       	$messages="Bonjour Mr/Mme ".$this->input->post('NOM_PRENOM_PROP').".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
	       	La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
	       	propriétaire de la parcelle numéro ".$this->input->post('NUM_PARCEL')." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.
	       	<br>Vous-trouverez ci-dessous vos identifiants de connexion vous permettant d’avoir accès à votre espace personnel et aux informations relatives à vos parcelles.
	       	<br>Lien :<a href=".base_url('/Login')." target='_blank'>Cliquez-ici</a>
	       	<br>Nom d'utilisateur : ".$mailTo."
	       	<br>Mot de passe : ".$hashedPassword." ";  

	       	$this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array()); 

	       	$message='<div class="alert alert-danger text-center" id="message">'.lang('enregistrement_succes').'</div>';     
	      }
	      else
	      {
	       	$message='<div class="alert alert-danger text-center" id="message">La parcelle n\'existe ni dans DocBox ou Alfresco</div>';               	
	      }
	      $this->session->set_flashdata('message',$message);
	      redirect(base_url('administration/Numerisation/list'));
	    }
	}


  // fonction qui appel la view qui affiche le formulaire
  public function info_parcelle($user_id)
  {
    	if(empty($user_id))
    	{
    		redirect(base_url('administration/Numerisation/list'));
    	}
    	else
    	{
    		$data['user_id']=$user_id;
    		$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
    		$data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

    		$data['provinces']=$this->Model->getList('syst_provinces');
    		$this->load->view('Parcelle_info_add_view',$data);
    	}
  }

  //fonction qui genere le mot de passe
  public function password_generer()
  {
    	$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
    	$length = 10;
    	$password = '';

    	$charCount = strlen($characters);
    	for ($i = 0; $i < $length; $i++) {
    		$password .= $characters[rand(0, $charCount - 1)];
    	}
    	return $password;
  }

	// verification et enregistrement des informations saisie
  public function add_info_parcelle()
  {
  		$user_id=$this->input->post('user_id');

  		$PROVINCE_ID=$this->input->post('PROVINCE_ID');
  		$COMMUNE_ID=$this->input->post('COMMUNE_ID');
  		$ZONE_ID=$this->input->post('ZONE_ID');
  		$COLLINE_ID=$this->input->post('COLLINE_ID');

  		// $this->form_validation->set_rules('NUM_PARCEL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		// $this->form_validation->set_rules('NATURE_DOC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		// $this->form_validation->set_rules('NUMERO_SPECIAL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		// $this->form_validation->set_rules('VOLUME','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		// $this->form_validation->set_rules('FOLIO','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

  		// $this->form_validation->set_rules('SUPER_HA','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		// $this->form_validation->set_rules('SUPER_ARE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		// $this->form_validation->set_rules('SUPER_CA','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

  		// $this->form_validation->set_rules('PROVINCE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		// $this->form_validation->set_rules('COMMUNE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		// $this->form_validation->set_rules('ZONE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		// $this->form_validation->set_rules('COLLINE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

  		// $this->form_validation->set_rules('USAGE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		// $this->form_validation->set_rules('NUM_CADASTRE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		if($this->form_validation->run()==TRUE)
  		{
  			$data['user_id']=$this->input->post('user_id');
  			$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
  			$data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');



  			$data['provinces']=$this->Model->getList('syst_provinces');

  			if(!empty($this->input->post('PROVINCE_ID')))
  			{
  				$data['communes']=$this->Model->getList('communes',array('PROVINCE_ID'=>$PROVINCE_ID));     
  			}
  			else
  			{
  				$data['communes']=array();
  			}



  			if(!empty($this->input->post('COMMUNE_ID')))
  			{
  				$data['zones']=$this->Model->getList('pms_zones',array('COMMUNE_ID'=>$COMMUNE_ID));     
  			}
  			else
  			{
  				$data['zones']=array();
  			}



  			if(!empty($this->input->post('COLLINE_ID')))
  			{
  				$data['collines']=$this->Model->getList('collines',array('COLLINE_ID'=>$COLLINE_ID));     
  			}
  			else
  			{
  				$data['collines']=array();
  			}
  			$this->load->view('Parcelle_info_add_view',$data);
  		}
  		else
  		{
  		  $message='<div class="alert alert-danger text-center" id="message">La parcelle existe déjà.</div>';	
		  
		    $prov_name=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$this->input->post('PROVINCE_ID')));

		    $check_existence_parcelle=$this->Model->getOne('parcelle',array('NUMERO_PARCELLE'=>$this->input->post('NUM_PARCEL')));

  		  if(empty($check_existence_parcelle))
  		  {
		 		  $var=$this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));

  	  	  $message='<div class="alert alert-danger text-center" id="message">La parcelle n\'existe pas dans les dossiers archivés</div>';	
	  		  
	  		  if(json_decode($var)->status==200 && !empty($this->input->post('user_id')))
	  		  {
	  		  	$token_parcelle='';
	  		  	$token_sous_dossier='';
	  		  	$mot_de_passe=$this->password_generer();
	  		  	$hashedPassword=password_hash($mot_de_passe,PASSWORD_DEFAULT);
	  		  	$this->Model->update('sf_guard_user_profile',array('md5(id)'=>$this->input->post('user_id')),array('password'=>$hashedPassword));
	  		  	$sf_guard_user_last_id=$this->Model->getOne('sf_guard_user_profile',array('md5(id)'=>$this->input->post('user_id')));
	  		  	$message='<div class="alert alert-danger text-center" id="message">Cette parcelle n\'exste pas dans Docbox</div>';
		  		  $result=$this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));

		  		  if(json_decode($result)->detail_fold->nom_folder==$this->input->post('NUM_PARCEL'))
		  		  {
		  		  	  $data_parcelle=array('NUMERO_PARCELLE'=>$this->input->post('NUM_PARCEL'),
		  		  		'SUPERFICIE'=>40,
		  		  		'PRIX'=>1000000,
		  		  		'STATUT_ID'=>3,
		  		  		'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
		  		  		'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
		  		  		'ZONE_ID'=>$this->input->post('ZONE_ID'),
		  		  		'COLLINE_ID'=>$this->input->post('COLLINE_ID')
		  		  	  );

		  		  	  $parcelle_last_id=$this->Model->insert_last_id('parcelle',$data_parcelle);

		  		  	  $data_parcelle_attribution=array('ID_PARCELLE'=>$parcelle_last_id,
		  		  		'ID_REQUERANT'=>$sf_guard_user_last_id['id'],
		  		  		'NUMERO_PARCELLE'=>$this->input->post('NUM_PARCEL'),
		  		  		'SUPERFICIE'=>40,
		  		  		'PRIX'=>1000000,
		  		  		'STATUT_ID'=>3,
		  		  		'SUPERFICIE_HA'=>$this->input->post('SUPER_HA'),
		  		  		'SUPERFICIE_ARE'=>$this->input->post('SUPER_ARE'),
		  		  		'SUPERFICIE_CA'=>$this->input->post('SUPER_CA'),
		  		  		'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
		  		  		'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
		  		  		'ZONE_ID'=>$this->input->post('ZONE_ID'),
		  		  		'COLLINE_ID'=>$this->input->post('COLLINE_ID'),
		  		  		'NUMERO_CADASTRAL'=>$this->input->post('NUM_CADASTRE'),
		  		  		'USAGE_ID'=>$this->input->post('USAGE'),
		  		  		'VOLUME'=>$this->input->post('VOLUME'),
		  		  		'FOLIO'=>$this->input->post('FOLIO'),
		  		  		'NUMERO_ORDRE_SPECIAL'=>$this->input->post('NUMERO_SPECIAL')
		  		  	  );

	                  $result_parcelle_attribution=$this->Model->insert_last_id('parcelle_attribution',$data_parcelle_attribution);

	     			  $result_parcelle_new=$this->Model->insert_last_id('edrms_repertoire_processus_parcelle_new',array('dossiers_processus_province_id'=>'',
	     				'parcelle_id'=>$parcelle_last_id,
	     				'numero_parcelle'=>$this->input->post('NUM_PARCEL'),
	     				'nom_repertoire_parcelle'=>$this->input->post('NUM_PARCEL'),
	     				'token_dossiers_parcelle_processus'=>json_decode($result)->detail_fold->fold_parrent_token,
	     				'dossier_id'=>$this->input->post('NATURE_DOC')));

	     			  $this->Model->create('edrms_repertoire_processus_sous_repertoire_new',array(
	     				'dossier_processus_parcelle_id'=>$result_parcelle_new,
	     				'parcelle_id'=>$parcelle_last_id,
	     				'nom_sous_repertoire'=>json_decode($result)->data->dossier[0]->nom_folder,
	     				'token_sous_repertoire'=>json_decode($result)->data->dossier[0]->token,
	     				'statut_actualisation'=>1));



	     			  $communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$this->input->post('COMMUNE_ID').' ');

	     			  $mailTo=$sf_guard_user_last_id['email'];
	     			  $pwd=$this->password_generer();


			
			          $province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$this->input->post('PROVINCE_ID')));

  	                  $communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$this->input->post('COMMUNE_ID').' ');


          			  $check_existence_requerant=$this->Model->getRequeteOne('SELECT COUNT(ID_PARCELLE) as value FROM parcelle_attribution WHERE md5(ID_REQUERANT)="'.$this->input->post('user_id').'"');

	     			  if(!empty($check_existence_requerant) && $check_existence_requerant['value']<=1)
	     			  {
	     			  	$subject='Information';

	     			  	$messages="Bonjour Mr/Mme ".$sf_guard_user_last_id['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
	     			  	La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
	     			  	propriétaire de la parcelle numéro ".$this->input->post('NUM_PARCEL')." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.
	     			  	<br>Vous-trouverez ci-dessous vos identifiants de connexion vous permettant d’avoir accès à votre espace personnel et aux informations relatives à vos parcelles.
	     			  	<br>Lien :<a href=".base_url('/Login')." target='_blank'>Cliquez-ici</a>
	     			  	<br>Nom d'utilisateur : ".$mailTo."
	     			  	<br>Mot de passe : ".$pwd." ";   
	     			  }
	     			  else
	     			  {
	     			  	$subject='Information';

	     			  	$messages="Bonjour Mr/Mme ".$sf_guard_user_last_id['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
	     			  	La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
	     			  	propriétaire de la parcelle numéro ".$this->input->post('NUM_PARCEL')." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.
	     			  	<br>Veuillez-vous connecter dans votre espace personnel et acceder aux informations relatives à vos parcelles.
	     			  	<br>Lien :<a href=".base_url('/Login')." target='_blank'>Cliquez-ici</a>";                 
	     			  }


	     			  $this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array()); 

	     			  $result=$this->Model->getRequeteOne('SELECT `id`, `email`, `username`, `password`, `fullname`, `validate`, `created_at`, `updated_at`, `mobile`, `registeras`, `siege`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `path_doc_notaire`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `date_naissance`, `systeme_id`, `nif`, `country_code`, `type_demandeur`, `type_document_id`, `sexe_id`, `new_buyer`, `father_fullname`, `mother_fullname`, `numerise`, `date_delivrance`,zone_id,colline_id,boite_postale,avenue FROM `sf_guard_user_profile` WHERE md5(id)="'.$this->input->post('user_id').'"');

	     			  $num_parcelle=$this->Model->getOne('parcelle_attribution',array('ID_REQUERANT'=>$result['id']));

	     			  $var=$this->pms_api->share_applicant($result['fullname'],$result['username'],$result['email'],$result['password'],$result['mobile'],$result['registeras'],$result['provence_id'],$result['commune_id'],$result['date_naissance'],$result['father_fullname'],$result['mother_fullname'],$result['lieu_delivrance_cni'],$result['date_delivrance'],$num_parcelle['NUMERO_PARCELLE'],$num_parcelle['SUPERFICIE'],$num_parcelle['USAGE_ID'],$result['cni'],$num_parcelle['PRIX'],$result['country_code'],$result['nif'],$result['zone_id'],$result['colline_id'],$result['sexe_id'],$result['boite_postale'],$result['avenue'],$result['profile_pic'],$result['path_signature'],$result['path_cni'],$num_parcelle['COLLINE_ID']);
	     			  if($var->success!=1) 
	     			  {
	     			  	$this->Model->update('parcelle_attribution',array('md5(ID_REQUERANT)'=>$this->input->post('user_id')),array('STATUT_ENVOI_BPS'=>0));
	     			  }


		  		    $message='<div class="alert alert-danger text-center" id="message">'.lang('enregistrement_succes').'</div>';
		  		  }
	  		  }


	  		  $this->session->set_flashdata('message',$message);
	  
	        redirect(base_url('administration/Numerisation/list'));
	      }	  			
	      $this->session->set_flashdata('message',$message);

	      redirect(base_url('administration/Numerisation/list'));
  		}    
  }

	public function getOne($user,$num_parcelle)
 	{
  		$data['user_id']=$user;
  		$data['num_parcelle1']=$num_parcelle;
  		$data['info']=$this->Model->getRequeteOne('SELECT parcelle_attribution.NUMERO_PARCELLE,
  			edrms_repertoire_processus_parcelle_new.dossier_id,
  			parcelle_attribution.VOLUME,
  			parcelle_attribution.FOLIO,
  			parcelle_attribution.NUMERO_ORDRE_SPECIAL,
  			parcelle_attribution.SUPERFICIE_HA,
  			parcelle_attribution.SUPERFICIE_ARE,
  			parcelle_attribution.SUPERFICIE_CA,
  			parcelle_attribution.PROVINCE_ID,
  			parcelle_attribution.COMMUNE_ID,
  			parcelle_attribution.COLLINE_ID,
  			parcelle_attribution.ZONE_ID,
  			parcelle_attribution.USAGE_ID,
  			parcelle_attribution.NUMERO_CADASTRAL
  			FROM `sf_guard_user_profile` 
  			LEFT JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user_profile.id 
  			LEFT JOIN edrms_repertoire_processus_parcelle_new ON edrms_repertoire_processus_parcelle_new.parcelle_id=parcelle_attribution.ID_PARCELLE
  			LEFT JOIN edrms_dossiers_processus on edrms_dossiers_processus.ID_DOSSIER=edrms_repertoire_processus_parcelle_new.dossier_id
  			WHERE md5(sf_guard_user_profile.id)="'.$user.'" AND md5(parcelle_attribution.NUMERO_PARCELLE)="'.$num_parcelle.'" ');

  		$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
  		$data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

  		$data['provinces']=$this->Model->getList('syst_provinces');
  		$data['communes']=$this->Model->getList('communes',array('PROVINCE_ID'=>$data['info']['PROVINCE_ID']));
  		$data['zones']=$this->Model->getList('pms_zones',array('COMMUNE_ID'=>$data['info']['COMMUNE_ID']));
  		$data['collines']=$this->Model->getList('collines',array('ZONE_ID'=>$data['info']['ZONE_ID']));
  		$this->load->view('Parcelle_info_update_view',$data);
 	}

 	// modification des informations saisie
 	public function update()
 	{
  		$user_id=$this->input->post('user_id');

  		$PROVINCE_ID=$this->input->post('PROVINCE_ID');
  		$COMMUNE_ID=$this->input->post('COMMUNE_ID');
  		$ZONE_ID=$this->input->post('ZONE_ID');
  		$COLLINE_ID=$this->input->post('COLLINE_ID');



  		$this->form_validation->set_rules('NUM_PARCEL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		$this->form_validation->set_rules('NATURE_DOC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		$this->form_validation->set_rules('NUMERO_SPECIAL','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		$this->form_validation->set_rules('VOLUME','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		$this->form_validation->set_rules('FOLIO','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

  		$this->form_validation->set_rules('SUPER_HA','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		$this->form_validation->set_rules('SUPER_ARE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		$this->form_validation->set_rules('SUPER_CA','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

  		$this->form_validation->set_rules('PROVINCE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		$this->form_validation->set_rules('COMMUNE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		$this->form_validation->set_rules('ZONE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
  		$this->form_validation->set_rules('COLLINE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));



  		$this->form_validation->set_rules('USAGE', '', 'required', array('required' => 'Le champ est obligatoire.'));

  		$this->form_validation->set_rules('NUM_CADASTRE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

  		if($this->form_validation->run()==FALSE)
  		{
  			$data['user_id']=$this->input->post('user_id');
  			$data['num_parcelle1']=$this->input->post('num_parcelle');
  			$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
  			$data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

  			$data['info']=$this->Model->getRequeteOne('SELECT parcelle_attribution.NUMERO_PARCELLE,
  				edrms_repertoire_processus_parcelle_new.dossier_id,
  				parcelle_attribution.VOLUME,
  				parcelle_attribution.FOLIO,
  				parcelle_attribution.NUMERO_ORDRE_SPECIAL,
  				parcelle_attribution.SUPERFICIE_HA,
  				parcelle_attribution.SUPERFICIE_ARE,
  				parcelle_attribution.SUPERFICIE_CA,
  				parcelle_attribution.PROVINCE_ID,
  				parcelle_attribution.COMMUNE_ID,
  				parcelle_attribution.COLLINE_ID,
  				parcelle_attribution.ZONE_ID,
  				parcelle_attribution.USAGE_ID,
  				parcelle_attribution.NUMERO_CADASTRAL
  				FROM `sf_guard_user_profile` 
  				LEFT JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user.id 
  				LEFT JOIN edrms_repertoire_processus_parcelle_new ON edrms_repertoire_processus_parcelle_new.parcelle_id=parcelle_attribution.ID_PARCELLE
  				LEFT JOIN edrms_dossiers_processus on edrms_dossiers_processus.ID_DOSSIER=edrms_repertoire_processus_parcelle_new.dossier_id
  				WHERE md5(sf_guard_user_profile.id)="'.$this->input->post('user_id').'" AND md5(parcelle_attribution.NUMERO_PARCELLE)="'.$this->input->post('num_parcelle').'" ');


  			$data['provinces']=$this->Model->getList('syst_provinces');

  			if(!empty($this->input->post('PROVINCE_ID')))
  			{
  				$data['communes']=$this->Model->getList('communes',array('PROVINCE_ID'=>$PROVINCE_ID));     
  			}
  			else
  			{
  				$data['communes']=array();
  			}



  			if(!empty($this->input->post('COMMUNE_ID')))
  			{
  				$data['zones']=$this->Model->getList('pms_zones',array('COMMUNE_ID'=>$COMMUNE_ID));     
  			}
  			else
  			{
  				$data['zones']=array();
  			}



  			if(!empty($this->input->post('COLLINE_ID')))
  			{
  				$data['collines']=$this->Model->getList('collines',array('COLLINE_ID'=>$COLLINE_ID));     
  			}
  			else
  			{
  				$data['collines']=array();
  			}

  			$this->load->view('Parcelle_info_update_view',$data);
  		}
  		else
  		{
  			$message ='<div class="alert alert-success text-center" id="message">La parcelle est déjà attribuée à une autre personne.</div>';

  			$check_existence_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(NUMERO_PARCELLE)'=>$this->input->post('NUM_PARCEL'),'md5(ID_REQUERANT)'=>!$this->input->post('user_id')));

  			$info=$this->Model->getRequeteOne('SELECT parcelle_attribution.NUMERO_PARCELLE,
  				edrms_repertoire_processus_parcelle_new.dossier_id,
  				parcelle_attribution.VOLUME,
  				parcelle_attribution.FOLIO,
  				parcelle_attribution.NUMERO_ORDRE_SPECIAL,
  				parcelle_attribution.SUPERFICIE_HA,
  				parcelle_attribution.SUPERFICIE_ARE,
  				parcelle_attribution.SUPERFICIE_CA,
  				parcelle_attribution.PROVINCE_ID,
  				parcelle_attribution.COMMUNE_ID,
  				parcelle_attribution.COLLINE_ID,
  				parcelle_attribution.ZONE_ID,
  				parcelle_attribution.USAGE_ID,
  				parcelle_attribution.NUMERO_CADASTRAL
  				FROM `sf_guard_user_profile` 
  				LEFT JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user_profile.id 
  				LEFT JOIN edrms_repertoire_processus_parcelle_new ON edrms_repertoire_processus_parcelle_new.parcelle_id=parcelle_attribution.ID_PARCELLE
  				LEFT JOIN edrms_dossiers_processus on edrms_dossiers_processus.ID_DOSSIER=edrms_repertoire_processus_parcelle_new.dossier_id
  				WHERE md5(sf_guard_user_profile.id)="'.$this->input->post('user_id').'" AND md5(parcelle_attribution.NUMERO_PARCELLE)="'.$this->input->post('num_parcelle').'" ');  

  			$var=$this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));        

  			if(empty($check_existence_parcelle))
  			{    
  				$message='<div class="alert alert-danger text-center" id="message">La parcelle n\'existe pas dans Alfresco</div>';	

  				if(json_decode($var)->status==200 && !empty($this->input->post('user_id')))
  				{
  					$token_parcelle='';

  					$token_sous_dossier='';

  					$sf_guard_user_last_id=$this->Model->getOne('sf_guard_user_profile',array('md5(id)'=>$this->input->post('user_id')));

  					$message='<div class="alert alert-danger text-center" id="message">Cette parcelle n\'exste pas dans Docbox</div>';

  					$result=$this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));

  					if(json_decode($result)->detail_fold->nom_folder==$this->input->post('NUM_PARCEL'))
  					{
  						$data_historique=array('NUMERO_PARCELLE'=> $info['NUMERO_PARCELLE'],
  							'DOSSIER_ID'=> $info['dossier_id'],
  							'VOLUME'=> $info['VOLUME'],
  							'FOLIO'=> $info['FOLIO'],
  							'NUMERO_ORDRE_SPECIAL'=> $info['NUMERO_ORDRE_SPECIAL'],
  							'SUPERFICIE_HA'=> $info['SUPERFICIE_HA'],
  							'SUPERFICIE_ARE'=> $info['SUPERFICIE_ARE'],
  							'SUPERFICIE_CA'=> $info['SUPERFICIE_CA'],
  							'PROVINCE_ID'=> $info['PROVINCE_ID'],
  							'COMMUNE_ID'=> $info['COMMUNE_ID'],
  							'COLLINE_ID'=> $info['COLLINE_ID'],
  							'ZONE_ID'=> $info['ZONE_ID'],
  							'USAGE_ID'=> $info['USAGE_ID'],
  							'NUMERO_CADASTRAL'=> $info['NUMERO_CADASTRAL'],
  							'USER_ID_CONNECTER'=>$this->session->userdata('PMS_USER_ID')
  						);

  						$this->Model->create('pms_histo_info_parcelle_requerant',$data_historique);

  						$sf_guard_user_last_id=$this->Model->getOne('sf_guard_user_profile',array('md5(id)'=>$this->input->post('user_id')));

  						$data_parcelle=array('NUMERO_PARCELLE'=>$this->input->post('NUM_PARCEL'),
  							'PROVINCE_ID'=>$this->input->post('PROVINCE_ID'),
  							'COMMUNE_ID'=>$this->input->post('COMMUNE_ID'),
  							'ZONE_ID'=>$this->input->post('ZONE_ID'),
  							'COLLINE_ID'=>$this->input->post('COLLINE_ID')
  						);


  						$this->Model->update('parcelle',array('md5(NUMERO_PARCELLE)'=>$this->input->post('num_parcelle')),$data_parcelle);

  						$data_repertoire_parcelle_new=array(
  							'dossiers_processus_province_id'=>"",
  							'dossier_id'=>$this->input->post('NATURE_DOC'),
  							'parcelle_id'=>$parcelle_last_id['ID_PARCELLE'],
  							'numero_parcelle'=>$this->input->post('NUM_PARCEL'),
  							'nom_repertoire_parcelle'=>$this->input->post('NUM_PARCEL'),
  							'token_dossiers_parcelle_processus'=>json_decode($result)->detail_fold->fold_parrent_token,
  							'dossier_id'=>$this->input->post('NATURE_DOC'));

  						$result_parcelle_new=$this->Model->update('edrms_repertoire_processus_parcelle_new',array('md5(numero_parcelle)'=>$this->input->post('num_parcelle')),$data_repertoire_parcelle_new);

  						$data_parcelle_id=$this->getOne('edrms_repertoire_processus_parcelle_new',array('md5(num_parcelle)'=>$this->input->post('num_parcelle')));

  						$data_sous_repertoire_parcelle_new=array(
  							'nom_sous_repertoire'=>json_decode($result)->data->dossier[0]->nom_folder,
  							'token_sous_repertoire'=>json_decode($result)->data->dossier[0]->token
  						);

  						if($var->message=="The response was successful")
  						{
  						
  						 $this->Model->update('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$data_parcelle_id['id']),$data_sous_repertoire_parcelle_new);

  							$message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';          
  						}
  						else
  						{
  							$message='<div class="alert alert-success text-center" id="message">Le requerant n\'à pas été créee avec succès dans BPS</div>';         
  						}


  						$message='<div class="alert alert-success text-center" id="message">La modification a été effectuée avec succès</div>';

  						$this->session->set_flashdata('message',$message);

  						redirect(base_url('administration/Numerisation/list'));
  					}
  					$this->session->set_flashdata('message',$message);

  					redirect(base_url('administration/Numerisation/list'));
  				}
  				$this->session->set_flashdata('message',$message);

  				redirect(base_url('administration/Numerisation/list'));
  			}
  			$this->session->set_flashdata('message',$message);

  			redirect(base_url('administration/Numerisation/list'));
  		}
 	}

 	// redirige sur la page d'affichage de la liste des informations
 	public function list()
 	{
  		$data['message'] = $this->session->flashdata('message');
  		$this->load->view('Numerisation_Liste_view',$data);      
 	}

 	// recupere les informations dans la base
 	public function listing()
 	{
  		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
  		$var_search=str_replace("'","\'",$var_search);
  		$query_principal="SELECT
  		sf_guard_user_profile.id,
  		sf_guard_user_profile.fullname,
  		sf_guard_user_profile.email,
  		sf_guard_user_profile.mobile,
  		sf_guard_user_profile.statut_api
  		FROM
  		`sf_guard_user_profile`
  		WHERE
  		sf_guard_user_profile.numerise =1";



  		$limit = '';
  		if (isset($_POST['length']) && $_POST['length'] != -1)
  		{
  			$limit = 'LIMIT ' . $_POST["start"] . ',' . $_POST["length"];
  		}


  		$order_by='';
  		$order_column=array(1,'sf_guard_user_profile.fullname',
  			'sf_guard_user_profile.email',
  			1,
  			1);

  		if ($order_by)
  		{
  			$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY sf_guard_user_profile.id ASC';
  		}

  		$search = !empty($_POST['search']['value']) ? (" AND (sf_guard_user_profile.fullname LIKE '%$var_search%' OR sf_guard_user_profile.email LIKE '%$var_search%' OR `EMAIL` LIKE '%$var_search%') ") : '';

  		$critaire = '';

  		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
  		$query_filter = $query_principal.' '.$critaire.' '.$search;

  		$fetch_users = $this->Model->datatable($query_secondaire);
  		$data = array();
  		$u=0;


  		foreach ($fetch_users as $row)
  		{
  			$nbr=$this->Model->getRequeteOne("SELECT COUNT(`NUMERO_PARCELLE`) nbr FROM `parcelle_attribution` WHERE STATUT_ID=3 AND ID_REQUERANT=".$row->id);
  			$u++; 
  			$sub_array=array(); 
  			$sub_array[]='<center><font color="#000000" size=2><label>'.$u.'</label></font> </center>';
  			$sub_array[]='<center><font color="#000000" size=2><label>'.$row->fullname.'</label></font> </center>';
  			$sub_array[]='<center><font color="#000000" size=2><label>'.$row->email.'</label></font> </center>';
  			$sub_array[]='<center><font color="#000000" size=2><label>'.lang('requerant').'</label></font> </center>';     
  			$sub_array[]='<center><font color="#000000" size=2><a href="#" onclick="show_list('.$row->id.');" class="btn btn-success">'.$nbr['nbr'].'</a></font> </center>';   

  			$button='<center><font color="#000000" size=2><a href="'.base_url('/administration/Numerisation/requerant_existant/'.md5($row->id)).'"  class="btn btn-success">'.lang('ajout_parcelle').'</a></font> </center> '; 			
  			if($row->statut_api==0)
  			{
  				$button.='<span data-toggle="tooltip" data-placement="top" style=color;  class="actionCust"><a href="'. base_url('administration/Numerisation/send_info_requerant/'.md5($row->id)) . '"><i class="fa fa-info-circle"></i>Envoyé requerant dans BPS</a></span>
  				<br>' ;   
  			}
  			
  			$sub_array[]=$button;
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

 	// recuperer les informations qui vont servir dans le modal precis des parcelle par rapport au requerant
 	public function listing1($id)
	{
  		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
  		$var_search=str_replace("'","\'",$var_search);
  		$query_principal="SELECT
  		syst_provinces.PROVINCE_NAME,
  		communes.COMMUNE_NAME,
  		pms_zones.ZONE_NAME,
  		collines.COLLINE_NAME,
  		usager_propriete.DESCRIPTION_USAGER_PROPRIETE,
  		parcelle_attribution.NUMERO_PARCELLE,
  		parcelle_attribution.ID_ATTRIBUTION,
  		parcelle_attribution.ID_REQUERANT
  		FROM
  		parcelle_attribution
  		LEFT JOIN syst_provinces ON syst_provinces.PROVINCE_ID = parcelle_attribution.PROVINCE_ID
  		LEFT JOIN communes ON communes.COMMUNE_ID = parcelle_attribution.COMMUNE_ID
  		LEFT JOIN pms_zones ON pms_zones.ZONE_ID = parcelle_attribution.ZONE_ID
  		LEFT JOIN collines ON collines.COLLINE_ID = parcelle_attribution.COLLINE_ID
  		LEFT JOIN usager_propriete ON usager_propriete.ID_USAGER_PROPRIETE = parcelle_attribution.USAGE_ID
  		WHERE
  		parcelle_attribution.STATUT_ID=3 
  		AND
  		parcelle_attribution.ID_REQUERANT =".$id;

  		$limit='LIMIT 0,10';
  		if(isset($_POST['length']) AND $_POST['length'] != -1)
  		{
  			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
  		}
  		{
  			$limit='LIMIT '.$_POST["start"].','.$_POST["length"];
  		}
  		$order_by='';
  		$order_column=array(1,1,1);

  		if ($order_by)
  		{
  			$order_by = isset($_POST['order']) ? ' ORDER BY '.$order_column[$_POST['order']['0']['column']] .'  '.$_POST['order']['0']['dir'] : ' ORDER BY parcelle_attribution.ID_ATTRIBUTION ASC';
  		}

  		$search = !empty($_POST['search']['value']) ? (" AND (parcelle_attribution.NUMERO_PARCELLE LIKE '%$var_search%') ") : '';

  		$critaire = '';

  		$query_secondaire=$query_principal.' '.$critaire.' '.$search.' '.$order_by.' '.$limit;
  		$query_filter = $query_principal.' '.$critaire.' '.$search;

  		$fetch_users = $this->Model->datatable($query_secondaire);
  		$data = array();
  		$u=0;


  		foreach ($fetch_users as $row)
  		{
  			$u++; 
  			$sub_array=array(); 
  			$sub_array[]='<center><font color="#000000" size=2><label>'.$u.'</label></font> </center>'; 
  			$sub_array[]='<center><font color="#000000" size=2><label>'.$row->NUMERO_PARCELLE.'</label></font> </center>';
  			$sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESCRIPTION_USAGER_PROPRIETE.'</label></font> </center>';
  			$sub_array[]='<center><font color="#000000" size=2><label>'.$row->PROVINCE_NAME.'-'.$row->COMMUNE_NAME.'-'.$row->ZONE_NAME.'-'.$row->COLLINE_NAME.'</label></font> </center>';

  			$sub_array[]= '  			
  			<span data-toggle="tooltip" data-placement="top" style=color;  class="actionCust"><a href="'. base_url('administration/Numerisation/details/'.md5($row->ID_REQUERANT)) . '"><i class="fa fa-info-circle"></i>'.lang('detail').'</a></span> 
  			<br> 

  			<span data-toggle="tooltip" data-placement="top" style=color; class="actionCust"><a href="'. base_url('administration/Numerisation/getOne/'.md5($row->ID_REQUERANT).'/'.md5($row->NUMERO_PARCELLE)) . '"><i class="fa fa-edit"></i>'.lang('btn_modification').'</a></span> '
  			;      

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

 	// affiche la page de detail des informations d'une parcelle
 	public function details($id=0)
 	{
  		$info_parcel=$this->Model->getRequeteOne("SELECT 
  			VOLUME,
  			FOLIO,
  			NUMERO_PARCELLE,
  			NUMERO_ORDRE_SPECIAL,
  			SUPERFICIE_HA,
  			SUPERFICIE_ARE,
  			SUPERFICIE_CA,
  			ID_PARCELLE,
  			DATE_INSERTION,
  			NUMERO_CADASTRAL,
  			usager_propriete.DESCRIPTION_USAGER_PROPRIETE 
  			FROM `parcelle_attribution` 
  			LEFT JOIN usager_propriete on usager_propriete.ID_USAGER_PROPRIETE=parcelle_attribution.USAGE_ID WHERE md5(ID_REQUERANT)='".$id."' ");

  		$ha=!empty($info_parcel['SUPERFICIE_HA']) ? $info_parcel['SUPERFICIE_HA'] : "ha";
  		$are=!empty($info_parcel['SUPERFICIE_ARE']) ? $info_parcel['SUPERFICIE_ARE'].' are' : "N/A";
  		$ca=!empty($info_parcel['SUPERFICIE_CA']) ? $info_parcel['SUPERFICIE_CA'].' ca' : "N/A";
  		$localite=$ha."-".$are."-".$ca;


  		$info_proprio=$this->Model->getRequeteOne("SELECT
  			sf_guard_user_profile.id,
  			sf_guard_user_profile.fullname,
  			sf_guard_user_profile.registeras,
  			sf_guard_user_profile.father_fullname,
  			sf_guard_user_profile.mother_fullname
  			FROM
  			`sf_guard_user_profile`
  			WHERE
  			md5(sf_guard_user_profile.id)='".$id."' and numerise=1 ");


  		$nature_dossier=$this->Model->getRequeteOne("SELECT edrms_dossiers_processus.DOSSIER 
  			FROM `edrms_repertoire_processus_parcelle_new` 
  			left JOIN parcelle_attribution on parcelle_attribution.ID_PARCELLE=edrms_repertoire_processus_parcelle_new.parcelle_id
  			LEFT JOIN edrms_dossiers_processus on edrms_dossiers_processus.ID_DOSSIER=edrms_repertoire_processus_parcelle_new.dossier_id
  			where edrms_repertoire_processus_parcelle_new.parcelle_id=".$info_parcel['ID_PARCELLE']);

  		$numero_dossier=$this->Model->getRequeteOne("SELECT edrms_repertoire_processus_sous_repertoire_new.nom_sous_repertoire
  			FROM `edrms_repertoire_processus_sous_repertoire_new` 
  			LEFT JOIN parcelle_attribution on 
  			parcelle_attribution.ID_PARCELLE=edrms_repertoire_processus_sous_repertoire_new.parcelle_id 
  			where edrms_repertoire_processus_sous_repertoire_new.parcelle_id=".$info_parcel['ID_PARCELLE']);

  		$data['date_insertion']="";
  		if(!empty($info_parcel))
  		{
  			$date = DateTime::createFromFormat('Y-m-d H:i:s', $info_parcel['DATE_INSERTION']);
  			$formatted_date = $date->format('d-m-Y');
  			$data['date_insertion']=$formatted_date;
  		}


  		$data['info']=$id;
  		$data['info_parcel']=$info_parcel;
  		$data['info_proprio']=$info_proprio;
  		$data['localite']=$localite;
  		$data['nature_dossier']=!empty($nature_dossier) ? $nature_dossier['DOSSIER'] : "N/A";
  		$data['numero_dossier']=!empty($numero_dossier) ? $numero_dossier['nom_sous_repertoire'] : "N/A";
  		$this->load->view('Numerisation_detail_view',$data);    
 	} 

 	public function send_info_requerant($id)
 	{	  
	   $result=$this->Model->getRequeteOne('SELECT `id`, `email`, `username`, `password`, `fullname`, `validate`, `created_at`, `updated_at`, `mobile`, `registeras`, `siege`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `path_doc_notaire`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `date_naissance`, `systeme_id`, `nif`, `country_code`, `type_demandeur`, `type_document_id`, `sexe_id`, `new_buyer`, `father_fullname`, `mother_fullname`, `numerise`, `date_delivrance`,zone_id,colline_id,boite_postale,avenue FROM `sf_guard_user_profile` WHERE md5(id)="'.$id.'"');

	   $num_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(ID_REQUERANT)'=>$id));


	   $var=$this->pms_api->share_applicant($result['fullname'],$result['username'],$result['email'],$result['password'],$result['mobile'],$result['registeras'],$result['provence_id'],$result['commune_id'],$result['date_naissance'],$result['father_fullname'],$result['mother_fullname'],$result['lieu_delivrance_cni'],$result['date_delivrance'],$num_parcelle['NUMERO_PARCELLE'],$num_parcelle['SUPERFICIE'],$num_parcelle['USAGE_ID'],$result['cni'],$num_parcelle['PRIX'],$result['country_code'],$result['nif'],$result['zone_id'],$result['colline_id'],$result['sexe_id'],$result['boite_postale'],$result['avenue'],$result['profile_pic'],$result['path_signature'],$result['path_cni'],$num_parcelle['COLLINE_ID']);

		  // print_r($var);
		  // exit();

		  if($var->success==1)
		  {
		  	$this->Model->update('sf_guard_user_profile',array('md5(id)'=>$id),array('statut_api'=>1));
		    $message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';          
		  }
			else
			{
				$message='<div class="alert alert-success text-center" id="message">Le requerant n\'à pas été créee avec succès dans BPS</div>';         
			}

			$this->session->set_flashdata('message',$message);

			redirect(base_url('administration/Numerisation/list'));
 	}
}
?>