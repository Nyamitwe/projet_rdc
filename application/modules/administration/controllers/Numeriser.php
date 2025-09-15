<?php

/**
 * 
 */
class Numeriser extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		// $this->isAuth();
		require('fpdf184/fpdf.php');
	}

	// //CHECK AUTHENTIFICATION
	// public function isAuth()
	// {
	// 	if(empty($this->get_utilisateur()))
	// 	{
	// 		redirect(base_url('Login'));
	// 	}
	// }

    // //RECUPERATION DU LOGIN DE LA PERSONNE CONNECTEE
	// public function get_utilisateur()
	// {
	// 	return $this->session->userdata('PMS_USER_ID');
	// }

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


	// recuperation dynamique des communes par rapport a la province
	public  function get_commune_parcelle($PROVINCE_ID=0)
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
}