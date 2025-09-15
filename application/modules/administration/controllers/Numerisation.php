<?php
ini_set('memory_limit', '8192M');
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



	// fonction appeler automatiquement lorque le controlleur est executer
	public function index()
	{
		$data['message'] = $this->session->flashdata('message');

		$id = $this->uri->segment(4);

		$data['types_requerants']=$this->Model->getRequete('SELECT id,name FROM sf_guard_user_categories WHERE id in(1,5) ORDER BY name ASC');

		$data['nationalites']=$this->Model->getRequete('SELECT id,name FROM countries ORDER BY name ASC');

		$data['sexes']=$this->Model->getRequete('SELECT SEXE_ID,DESCRIPTION_SEXE FROM pms_sexe ORDER BY DESCRIPTION_SEXE ASC');

		$data['provinces_naissance']=$this->Model->getList('syst_provinces');

		$data['info_physique']="style='display:block;'";

		$data['info_nationalite']="style='display:block;'";


		$data['info_morale']="style='display:none;'";

		$data['info_prov_naissance']="style='display:block;'";

		$data['info_com_naissance']="style='display:block;'";
		
		$data['info_zon_naissance']="style='display:block;'";
		
		$data['info_col_naissance']="style='display:block;'";

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


    //PERMET L'UPLOAD DE L'IMAGE CNI / PASSEPORT
	public function upload_file_sign_morale($input_name)
	{
		$nom_file = $_FILES[$input_name]['tmp_name'];
		$nom_champ = $_FILES[$input_name]['name'];
		$ext=pathinfo($nom_champ, PATHINFO_EXTENSION);
		$repertoire_fichier = FCPATH . 'uploads/signatures/';
		$code=uniqid();
		$name=$code . 'MORALE_SIGINATURE.' .$ext;
		$file_link = $repertoire_fichier . $name;


       // $fichier = basename($nom_champ);
		if (!is_dir($repertoire_fichier)) {
			mkdir($repertoire_fichier, 0777, TRUE);
		}
		move_uploaded_file($nom_file, $file_link);
		return $name;
	}



	// function d'enregistrement des info d'un requerant
	public function add_info_requerant()
	{
		$PROVINCE_ID1=$this->input->post('PROVINCE_ID1');
		$COMMUNE_ID1=$this->input->post('COMMUNE_ID1');
		$ZONE_ID1=$this->input->post('ZONE_ID1');
		$COLLINE_ID1=$this->input->post('COLLINE_ID1');

		$this->form_validation->set_rules('type_requerant_id','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire9.</font>'));

		if($this->input->post('nationalite_id')==28)
		{
			$this->form_validation->set_rules('PROVINCE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('COMMUNE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>')); 
			$this->form_validation->set_rules('ZONE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('COLLINE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));          
		}

		if($this->input->post('type_requerant_id')==1)
		{
			$this->form_validation->set_rules('SEXE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">La selection est Obligatoire.</font>'));

			$this->form_validation->set_rules('NUM_CNI_PROP','', 'trim|required|is_unique[sf_guard_user_profile.cni]',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>','is_unique'=>'le numero de cni saisie existe deja.'));

			$this->form_validation->set_rules('EMAIL_PROP','', 'trim|required|is_unique[sf_guard_user_profile.email]|valid_email',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>','is_unique'=>'l\'email saisie existe deja.','valid_email'=>'l\'email a un format incorrect.'));

			$this->form_validation->set_rules('nationalite_id','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NOM_PRENOM_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('DATE_NAISSANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NUM_TEL_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NOM_PRENOM_PERE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NOM_PRENOM_MERE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

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
		}

		if($this->input->post('type_requerant_id')==5)
		{
			$this->form_validation->set_rules('NOM_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire1.</font>'));
			$this->form_validation->set_rules('NIF_RC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire2.</font>'));  
			$this->form_validation->set_rules('NOM_ENTREPRISE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire3.</font>'));  
			$this->form_validation->set_rules('NOM_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire4.</font>'));  
			$this->form_validation->set_rules('EMAIL_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire5.</font>'));  
			$this->form_validation->set_rules('TELEPHONE_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire6.</font>'));  
			$this->form_validation->set_rules('NIF_RC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire7.</font>'));     
			if(!isset($_FILES['SIGNATURE_REPRESENTANT']) || empty($_FILES['SIGNATURE_REPRESENTANT']['name']) && empty($this->input->post('user_id')))
			{
				$this->form_validation->set_rules('SIGNATURE_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">L\'upload est Obligatoire8</font>'));
			}   
		}

		$this->form_validation->set_rules('NUM_PARCEL', '', 'trim|required|is_unique[parcelle.NUMERO_PARCELLE]', array('required' => '<font style="color:red; size:2px;">Le champ est Obligatoire.</font>', 'is_unique' => '<font style="color:red; size:2px;">La parcelle existe déjà.</font>'));

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
			$data['types_requerants']=$this->Model->getRequete('SELECT id,name FROM sf_guard_user_categories WHERE id in(1,5) ORDER BY name ASC');

			$data['nationalites']=$this->Model->getRequete('SELECT id,name FROM countries ORDER BY name ASC');

			$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');

			$data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

			$data['sexes']=$this->Model->getRequete('SELECT SEXE_ID,DESCRIPTION_SEXE FROM pms_sexe ORDER BY DESCRIPTION_SEXE ASC');

			$data['provinces']=$this->Model->getList('syst_provinces');

			$data['info_nationalite']="style='display:none;'";


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
				$data['info_zon_naissance']="style='display:block;'";
				$data['info_col_naissance']="style='display:block;'";
			}
			else
			{
				$data['info_prov_naissance']="style='display:none;'";
				$data['info_com_naissance']="style='display:none;'";
				$data['info_zon_naissance']="style='display:none;'";
				$data['info_col_naissance']="style='display:none;'";
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

			if(!empty($this->input->post('ZONE_ID')))
			{
				$data['collines']=$this->Model->getList('collines',array('ZONE_ID'=>$this->input->post('ZONE_ID')));      
			}
			else
			{
				$data['collines']=array();
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


			$result=$this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));


			    $token_repertoire_doc_box='';//le token du dossier de la parcelle
			    $nom_sous_repertoire_doc_box='';
			    $token_sous_repertoire_doc_box='';

			    $response = json_decode($result, true); // Pass true to get an associative array instead of an object
			    if(isset($response['detail_fold']) && isset($response['detail_fold']['nom_folder']))
			    {
			    	if ($response['detail_fold']['nom_folder'] == $this->input->post('NUM_PARCEL')) 
			    	{
	            	    $token_repertoire_doc_box= json_decode($result)->detail_fold->fold_parrent_token; //le token du dossier de la parcelle
	            	    $nom_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->nom_folder;
	            	    $token_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->token;
	            	}
	            }
	            else
	            {
	                 // Handle the case where the expected properties don't exist in the response
	                // You can log the error, display a user-friendly message, or perform another action
			       // echo "The expected data structure is not present in the response.";
			       $token_repertoire_doc_box='';//le token du dossier de la parcelle
			       $nom_sous_repertoire_doc_box='';
			       $token_sous_repertoire_doc_box='';
			   }

			    // if(json_decode($result)->detail_fold->nom_folder==$this->input->post('NUM_PARCEL'))
			    // {
				//     $token_repertoire_doc_box= json_decode($result)->detail_fold->fold_parrent_token; //le token du dossier de la parcelle
				//     $nom_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->nom_folder;
				//     $token_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->token;
				// }

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

		     if(($response['status']==200) || ($foundMatchRepertoire==true && $foundMatchSousRepertoire==true))
		     {
		     	$data_sf_guard_user_profile=array(
		     		'email'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('EMAIL_PROP') : $this->input->post('EMAIL_REPRESENTANT'),
		     		'fullname'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('NOM_PRENOM_PROP') : $this->input->post('NOM_REPRESENTANT'),
		     		'nom_entreprise'=>($this->input->post('type_requerant_id')==5) ? $this->input->post('NOM_ENTREPRISE') : "",
		     		'sexe_id'=>$this->input->post('sexe_id'),
		     		'username'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('EMAIL_PROP') : $this->input->post('EMAIL_REPRESENTANT'),
		     		'password'=>$hashedPassword,
		     		'date_naissance'=>$this->input->post('DATE_NAISSANCE'),
		     		'mobile'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('NUM_TEL_PROP') : $this->input->post('TELEPHONE_REPRESENTANT'),
		     		'registeras'=>$this->input->post('type_requerant_id'),
		     		'date_delivrance'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('DATE_DELIVRANCE') : "",
		     		'country_code'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('nationalite_id') : $this->input->post('nationalite_id'),
		     		'lieu_delivrance_cni'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('LIEU_DELIVRANCE') : "",
		     		'systeme_id'=>2,
		     		'cni'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('NUM_CNI_PROP') : "",
		     		'rc'=>($this->input->post('type_requerant_id')==5) ?$this->input->post('NIF_RC') : "",
		     		'sexe_id'=>$this->input->post('SEXE_ID'),
		     		'path_cni'=>($this->input->post('type_requerant_id')==1) ? $this->upload_file_cni('CNI_IMAGE_PROP') : "" ,
		     		'profile_pic'=>($this->input->post('type_requerant_id')==1) ? $this->upload_file_cni('PHOTO_PASSEPORT_PROP') : "" ,
		     		'numerise'=>1,
		     		'father_fullname'=>$this->input->post('NOM_PRENOM_PERE'),
		     		'path_signature'=>($this->input->post('type_requerant_id')==5) ? $this->upload_file_sign_morale('SIGNATURE_REPRESENTANT'): $this->upload_file_signature('SIGNATURE_PROP'),
		     		'provence_id'=>$this->input->post('PROVINCE_ID'),	       		
		     		'mother_fullname'=>$this->input->post('NOM_PRENOM_MERE'),
		     		'commune_id'=>$this->input->post('COMMUNE_ID'),
		     		'zone_id'=>$this->input->post('ZONE_ID'),
		     		'colline_id'=>$this->input->post('COLLINE_ID')
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

		     	$mailTo=($this->input->post('type_requerant_id')==1) ? $this->input->post('EMAIL_PROP') : $this->input->post('EMAIL_REPRESENTANT');   

		     	$subject='Information';

		     	$messages="Bonjour Mr/Mme ".$this->input->post('NOM_PRENOM_PROP').".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
		     	La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
		     	propriétaire de la parcelle numéro ".$this->input->post('NUM_PARCEL')." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.
		     	<br>Vous-trouverez ci-dessous vos identifiants de connexion vous permettant d’avoir accès à votre espace personnel et aux informations relatives à vos parcelles.
		     	<br>Lien :<a href=".base_url('/Login')." target='_blank'>Cliquez-ici</a>
		     	<br>Nom d'utilisateur : ".$mailTo."
		     	<br>Mot de passe : ".$mot_de_passe." ";  

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

			$this->form_validation->set_rules('NUM_PARCEL','', 'trim|required|is_unique[parcelle.NUMERO_PARCELLE]',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
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

			$this->form_validation->set_rules('USAGE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NUM_CADASTRE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			if($this->form_validation->run()==FALSE)
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
				$message='';
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


				$special_caractere=array('/','-','.','"',"'","*",'<','>','|',':','?');
				$avoid_slashes=str_replace($special_caractere,"-",$this->input->post('NUM_PARCEL'));
				$netoyage_avoid_slashes = preg_replace('/[^A-Za-z0-9\-]/', '', $avoid_slashes);

				$get_province_token=$this->Model->getOne('edrms_dossiers_processus_province',array('province_id'=>$this->input->post('PROVINCE_ID'),'dossier_processus_id'=>$this->input->post('NATURE_DOC')));

				$result_alf=$this->pms_alfresco_lib->get_folder_content($get_province_token['token_dossiers_processus_province']);


				$result=$this->pms_api->get_folder_content($this->input->post('NUM_PARCEL'));


			$token_repertoire_doc_box='';//le token du dossier de la parcelle
			$nom_sous_repertoire_doc_box='';
			$token_sous_repertoire_doc_box='';

			$response = json_decode($result, true); // Pass true to get an associative array instead of an object
			if(isset($response['detail_fold']) && isset($response['detail_fold']['nom_folder']))
			{
				if ($response['detail_fold']['nom_folder'] == $this->input->post('NUM_PARCEL')) 
				{
				           $token_repertoire_doc_box= json_decode($result)->detail_fold->fold_parrent_token; //le token du dossier de la parcelle
				           $nom_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->nom_folder;
				           $token_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->token;
				       }
				   }
				   else
				   {
				// Handle the case where the expected properties don't exist in the response
				// You can log the error, display a user-friendly message, or perform another action
				// echo "The expected data structure is not present in the response.";
				$token_repertoire_doc_box='';//le token du dossier de la parcelle
				$nom_sous_repertoire_doc_box='';
				$token_sous_repertoire_doc_box='';
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

			if(($response['status']==200) || ($foundMatchRepertoire==true && $foundMatchSousRepertoire==true))
			{

				$sf_guard_user_last_id=$this->Model->getOne('sf_guard_user_profile',array('md5(id)'=>$this->input->post('user_id')));

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

				$result_parcelle_new=$this->Model->insert_last_id('edrms_repertoire_processus_parcelle_new',array('dossiers_processus_province_id'=>$get_province_token['id'],'parcelle_id'=>$parcelle_last_id,'numero_parcelle'=>$this->input->post('NUM_PARCEL'),'nom_repertoire_parcelle'=>$name,'token_dossiers_parcelle_processus'=>$id,'DOC_TOKEN'=>$token_repertoire_doc_box,'dossier_id'=>$this->input->post('NATURE_DOC')));

				$this->Model->create('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$result_parcelle_new,'parcelle_id'=>$parcelle_last_id,'nom_sous_repertoire'=>$nom_sous_repertoire_alf,'nom_sous_repertoire_doc'=>$nom_sous_repertoire_doc_box,'token_sous_repertoire'=>$token_sous_repertoire_alf,'DOC_REF_TOKEN'=>$token_sous_repertoire_doc_box,'statut_actualisation'=>1));

				$province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$this->input->post('PROVINCE_ID')));

				$communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$this->input->post('COMMUNE_ID').' ');


				$check_existence_requerant=$this->Model->getRequeteOne('SELECT COUNT(ID_PARCELLE) as value FROM parcelle_attribution WHERE md5(ID_REQUERANT)="'.$this->input->post('user_id').'"');

				$subject='Information';

				$messages="Bonjour Mr/Mme ".$sf_guard_user_last_id['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
				La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
				propriétaire de la parcelle numéro ".$this->input->post('NUM_PARCEL')." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.
				<br>Veuillez-vous connecter dans votre espace personnel et acceder aux informations relatives à vos parcelles.
				<br>Lien :<a href=".base_url('/Login')." target='_blank'>Cliquez-ici</a>";

				$this->notifications->send_mail($sf_guard_user_last_id['email'],$subject,$cc_emails=array(),$messages,$attach=array()); 
				$num_parcelle=$this->Model->getOne('parcelle_attribution',array('ID_REQUERANT'=>$result['id']));

				//$var=$this->pms_api->share_applicant($result['fullname'],$result['username'],$result['email'],$result['password'],$result['mobile'],$result['registeras'],$result['provence_id'],$result['commune_id'],$result['date_naissance'],$result['father_fullname'],$result['mother_fullname'],$result['lieu_delivrance_cni'],$result['date_delivrance'],$num_parcelle['NUMERO_PARCELLE'],$num_parcelle['SUPERFICIE'],$num_parcelle['USAGE_ID'],$result['cni'],$num_parcelle['PRIX'],$result['country_code'],$result['nif'],$result['zone_id'],$result['colline_id'],$result['sexe_id'],$result['boite_postale'],$result['avenue'],$result['profile_pic'],$result['path_signature'],$result['path_cni'],$num_parcelle['COLLINE_ID']);
				
				// if($var->success==1) 
				// {
				// 	$this->Model->update('sf_guard_user_profile',array('md5(id)'=>$this->input->post('user_id')),array('statut_api'=>1));
				// }

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
		$PERSON=$this->input->post('PERSON');
		$condi='';
		if (! empty($PERSON)) {
		$condi=' AND sf_guard_user_categories.id='.$PERSON;
		}
		$var_search= !empty($_POST['search']['value']) ? $_POST['search']['value'] : null;
		$var_search=str_replace("'","\'",$var_search);
		$query_principal="SELECT
		sf_guard_user_profile.id,
		sf_guard_user_profile.fullname,
		sf_guard_user_profile.email,
		sf_guard_user_profile.mobile,
		sf_guard_user_profile.statut_api,
		sf_guard_user_profile.registeras,
		sf_guard_user_profile.nom_entreprise
		FROM
		`sf_guard_user_profile` LEFT JOIN sf_guard_user_categories ON sf_guard_user_categories.id=sf_guard_user_profile.registeras
		WHERE
		sf_guard_user_profile.numerise =1 ".$condi."";



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
		
		// print_r($postes['ID_POSTE']);die();


		foreach ($fetch_users as $row)
		{
			$PMS_USER_ID = $this->session->userdata('PMS_USER_ID');
		  $postes = $this->Model->getRequeteOne("SELECT ID_POSTE from pms_user_poste WHERE ID_USER=".$PMS_USER_ID);
			$demande=$this->Model->getRequeteOne("SELECT ID_REQUERANT from pms_traitement_demande where ID_REQUERANT=".$row->id);
			$nbr=$this->Model->getRequeteOne("SELECT COUNT(`NUMERO_PARCELLE`) nbr FROM `parcelle_attribution` WHERE STATUT_ID=3 AND ID_REQUERANT=".$row->id);
			$nom_proprio=$row->fullname;
			$type_requerant='Personne Physique';
			if($row->registeras==5)
			{
				$nom_proprio=$row->fullname;
				$type_requerant='Personne Morale';
			}
			$u++; 
			$sub_array=array(); 
			$sub_array[]='<center><font color="#000000" size=2><label>'.$u.'</label></font> </center>';
			$sub_array[]='<center><font color="#000000" size=2><label>'.$nom_proprio.'</label></font> </center>';
			$sub_array[]='<center><font color="#000000" size=2><label>'.$row->email.'</label></font> </center>';
			$sub_array[]='<center><font color="#000000" size=2><label>'.$type_requerant.'</label></font> </center>';     
			$sub_array[]='<center><font color="#000000" size=2><a href="#" onclick="show_list('.$row->id.');" class="btn btn-success">'.$nbr['nbr'].'</a></font> </center>';
			$option= '<span data-toggle="tooltip" data-placement="top" style=color; title="'.lang('ajout_parcelle').'" class="actionCust"><a href="'. base_url('/administration/Numerisation/info_parcelle/'.md5($row->id)) . '"><i class="fa fa-plus"></i></a></span>';

			if($postes['ID_POSTE']==1 or $postes['ID_POSTE']==29){

				if(empty($demande['ID_REQUERANT'])){

				  $option.= '<span data-toggle="tooltip" data-placement="top" style=color; title="Update" class="actionCust"><a href="'. base_url('/administration/Numerisation/getOneinforeq/'.md5($row->id)) . '"><i class="fa fa-edit"></i></a></span>&nbsp;&nbsp;'; 


				}


			}
			$sub_array[]=$option;
			 

			// $button='<center><font color="#000000" size=2><a href="'.base_url('/administration/Numerisation/info_parcelle/'.md5($row->id)).'"  class="btn btn-success">'.lang('ajout_parcelle').'</a></font> </center> '; 			
			// if($row->statut_api==0)
			// {
			// 	$button.='<span data-toggle="tooltip" data-placement="top" style=color;  class="actionCust"><a href="'. base_url('administration/Numeriser_New/send_info_requerant/'.md5($row->id)) . '"><i class="fa fa-info-circle"></i>Envoyé requerant dans BPS</a></span>
			// 	<br>' ;   
			// }

			// $sub_array[]=$button;
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
		parcelle_attribution.ID_REQUERANT,
		parcelle_attribution.statut_bps
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

			$get_req=$this->Model->getRequeteOne('SELECT email,statut_api from sf_guard_user_profile where id='.$row->ID_REQUERANT.'');



			$stat=1;

		

			if (!empty($get_req))
			{

			    $result = $this->pms_api->login($get_req['email']);

	            // if ( $result->message == 'La ressource est introuvable')
	            // { 
				//   $stat=0;	
			    // }
			}

			$u++; 
			$sub_array=array(); 
			$sub_array[]='<center><font color="#000000" size=2><label>'.$u.'</label></font> </center>'; 
			$sub_array[]='<center><font color="#000000" size=2><label>'.$row->NUMERO_PARCELLE.'</label></font> </center>';
			$sub_array[]='<center><font color="#000000" size=2><label>'.$row->DESCRIPTION_USAGER_PROPRIETE.'</label></font> </center>';
			$sub_array[]='<center><font color="#000000" size=2><label>'.$row->PROVINCE_NAME.'-'.$row->COMMUNE_NAME.'-'.$row->ZONE_NAME.'-'.$row->COLLINE_NAME.'</label></font> </center>';

			$sub_array[]= '  			
			<span data-toggle="tooltip" data-placement="top" style=color;  class="actionCust"><a href="'. base_url('administration/Numerisation/details/'.md5($row->ID_REQUERANT)) . '"><i class="fa fa-info-circle"></i>'.lang('detail').'</a></span> 
			<br>';

			// if ($stat == 0)statut_api 
			if (!empty($get_req) && ($get_req['statut_api'] == 0))
			{
				$sub_array[]= '  			
				<span data-toggle="tooltip" data-placement="top" style=color;  class="actionCust"><a href="'. base_url('administration/Numeriser_New/send_info_requerant/'.md5($row->ID_REQUERANT)) . '"><i class="fa fa-info-circle"></i>Envoyé le requerant dans BPS</a></span>
				<br>';
			}else if ($row->statut_bps == 0) 
			{

				$sub_array[]= '  			
				<span data-toggle="tooltip" data-placement="top" style=color;  class="actionCust"><a href="'. base_url('administration/Numerisation/add_new_parcelle_req/'.md5($row->NUMERO_PARCELLE)) . '"><i class="fa fa-info-circle"></i>Envoyé la parcelle dans BPS</a></span>
				<br>';
				
			}else
			{
				$sub_array[]= '  			
				<span data-toggle="tooltip" data-placement="top" class="actionCust"><a href="#"><i class="fa fa-info-circle" style="background-color:#218838 !important"></i>La parcelle est déja dans BPS</a></span>
				<br>';


			}

  			//<span data-toggle="tooltip" data-placement="top" style=color; class="actionCust"><a href="'. base_url('administration/Numerisation/getOne/'.md5($row->ID_REQUERANT).'/'.md5($row->NUMERO_PARCELLE)) . '"><i class="fa fa-edit"></i>'.lang('btn_modification').'</a></span> '   

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
		//$result=$this->Model->getRequeteOne('SELECT `id`, `email`, `username`, `password`,`nom_entreprise`,`fullname`, `validate`, `created_at`, `updated_at`, `mobile`, `registeras`, `siege`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `path_doc_notaire`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `date_naissance`, `systeme_id`, `nif`, `country_code`, `type_demandeur`, `type_document_id`, `sexe_id`, `new_buyer`, `father_fullname`, `mother_fullname`, `numerise`, `date_delivrance`,zone_id,colline_id,boite_postale,avenue FROM `sf_guard_user_profile` WHERE md5(id)="'.$id.'"');
                $result=$this->Model->getRequeteOne('SELECT id, email, username, password,nom_entreprise,fullname, validate, created_at, updated_at, mobile, registeras, siege, rc, profile_pic, path_signature, path_cni, path_doc_notaire, cni, lieu_delivrance_cni, num_doc_notaire, provence_id, sf_guard_user_profile.commune_id, date_naissance, systeme_id, nif, country_code, type_demandeur, type_document_id, sexe_id, new_buyer, father_fullname, mother_fullname, numerise, sf_guard_user_profile.date_delivrance,sf_guard_user_profile.zone_id,sf_guard_user_profile.colline_id,boite_postale,avenue FROM sf_guard_user_profile JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user_profile.id  WHERE parcelle_attribution.STATUT_ID=3 and md5(id)="'.$id.'"');
		// $num_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(ID_REQUERANT)'=>$id));
		$num_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(ID_REQUERANT)'=>$id,'STATUT_ID'=>3));


		$check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_parcelle_new',array('numero_parcelle'=>$num_parcelle['NUMERO_PARCELLE']));

		$token_repertoire_alfresco=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['token_dossiers_parcelle_processus'] : "";

		$token_repertoire_docbox=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['DOC_TOKEN'] : "";

		$token_sous_repertoire_alfresco="";
		$token_sous_repertoire_doc_box="";

		if(!empty($check_existence_token_repertoire))
		{
			$check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$check_existence_token_repertoire['id']));
			if(!empty($check_existence_token_repertoire))
			{
				$token_sous_repertoire_alfresco=$check_existence_token_repertoire['token_sous_repertoire'];
				$token_sous_repertoire_doc_box=$check_existence_token_repertoire['DOC_REF_TOKEN'];
			}
		}


		$var='';



		if($result['registeras']==1)
		{
			$petiteChaine1='.png';
			$petiteChaine2='.jpg';
			$petiteChaine3='.jpeg';

			$image=$result['profile_pic'];

			$extensionsPhoto = array("jpg", "jpeg", "png", "gif"); // Extensions de photos valides

            $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules


            if (!in_array($extension, $extensionsPhoto) || empty($image)) {
            $image="use_user.png";
            } else {
            $image=$image;
            }



            $signature=$result['path_signature'];


            $extension = strtolower(pathinfo($signature, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules


            if (!in_array($extension, $extensionsPhoto) || empty($signature)) {
            $signature="signature_req.png";
            } else {
            $signature=$signature;
            }

            $ext_pdf=".pdf";
            $cni_path=$result['path_cni'];

            $extensionsPhoto = array("jpg", "jpeg", "png", "pdf"); // Extensions de photos valides

            $extension = strtolower(pathinfo($cni_path, PATHINFO_EXTENSION)); // Obtenir l'extension du fichier en minuscules


            if (!in_array($extension, $extensionsPhoto) || empty($cni_path)) {
            $cni_path="blank.pdf";
            } else {
            $cni_path=$cni_path;
            }

         
            

            $var=$this->pms_api->share_applicant($result['fullname'],$result['username'],$result['email'],$result['password'],$result['mobile'],$result['registeras'],$result['country_code'],$result['provence_id'],$result['commune_id'],$result['date_naissance'],$result['father_fullname'],$result['mother_fullname'],$result['lieu_delivrance_cni'],$result['date_delivrance'],$num_parcelle['NUMERO_PARCELLE'],
            	$num_parcelle['SUPERFICIE'],$num_parcelle['USAGE_ID'],$num_parcelle['PRIX'],$result['nif'],
            	$result['zone_id'],$result['colline_id'],$result['sexe_id'],$result['boite_postale'],$result['avenue'],$image,$signature,$cni_path,$num_parcelle['COLLINE_ID'],$token_repertoire_docbox,$token_repertoire_alfresco,$token_sous_repertoire_doc_box,$token_sous_repertoire_alfresco,$result['cni'],$num_parcelle['VOLUME'],$num_parcelle['FOLIO']		     
            ); 
		  // $var=array($result['fullname'],$result['username'],$result['email'],$result['password'],$result['mobile'],$result['registeras'],$result['country_code'],$result['provence_id'],$result['commune_id'],$result['date_naissance'],$result['father_fullname'],$result['mother_fullname'],$result['lieu_delivrance_cni'],$result['date_delivrance'],$num_parcelle['NUMERO_PARCELLE'],
		  // 	   $num_parcelle['SUPERFICIE'],$num_parcelle['USAGE_ID'],$num_parcelle['PRIX'],$result['nif'],
		   //    $result['zone_id'],$result['colline_id'],$result['sexe_id'],$result['boite_postale'],$result['avenue'],$result['profile_pic'],$result['path_signature'],$result['path_cni'],$num_parcelle['COLLINE_ID'],$token_repertoire_docbox,$token_repertoire_alfresco,$token_sous_repertoire_doc_box,$token_sous_repertoire_alfresco,$result['cni']
		   //); 
			// print_r($var);die();
        }
        else
        {


        	$volume=strval($num_parcelle['VOLUME']);
        	$folio=strval($num_parcelle['FOLIO']);
        	$rc=strval($result['rc']);
        	$country_code=strval($result['country_code']);
        	$mobile=strval($result['mobile']);
        	$superficie=strval($num_parcelle['SUPERFICIE']);


        	$var=$this->pms_api->shareApplicantMoral(strval($result['fullname']),strval($result['username']),strval($result['password']),strval($mobile),$result['registeras'],$country_code,strval($result['nom_entreprise']),strval($result['boite_postale']),						 
        		$result['colline_id'],strval($rc),$result['provence_id'],$result['commune_id'],strval($result['email']),$num_parcelle['COLLINE_ID'],$result['zone_id'],strval($result['path_signature']),						 
        		strval($num_parcelle['NUMERO_PARCELLE']),$superficie,$num_parcelle['PRIX'],strval($num_parcelle['USAGE_ID']),strval($token_repertoire_docbox),strval($token_repertoire_alfresco),strval($token_sous_repertoire_doc_box),
        		strval($token_sous_repertoire_alfresco),$volume,$folio);

        	// $var=array(strval($result['fullname']),strval($result['username']),strval($result['password']),strval($mobile),$result['registeras'],$country_code,strval($result['nom_entreprise']),strval($result['boite_postale']),						 
        	// 	$result['colline_id'],strval($rc),$result['provence_id'],$result['commune_id'],strval($result['email']),$num_parcelle['COLLINE_ID'],$result['zone_id'],strval($result['path_signature']),						 
        	// 	strval($num_parcelle['NUMERO_PARCELLE']),$superficie,$num_parcelle['PRIX'],strval($num_parcelle['USAGE_ID']),strval($token_repertoire_docbox),strval($token_repertoire_alfresco),strval($token_sous_repertoire_doc_box),
        	// 	strval($token_sous_repertoire_alfresco),$volume,$folio);

        }
        // print_r($var);
        // exit();
	     //generation pwd
        $mot_de_passe=$this->password_generer();
        $hashedPassword=password_hash($mot_de_passe,PASSWORD_DEFAULT);
        $province=$num_parcelle['PROVINCE_ID'];

        $jsonArray = json_decode($var['response'], true);

        if($jsonArray['success']==1 && $result['registeras']==1)
        {		
        	$this->Model->update('sf_guard_user_profile',array('md5(id)' => $id),array('statut_api' => 1, 'password' => $mot_de_passe));

           //MISE A JOUR DE LA PARCELLE ATTRIBUTION EN CAS DE LA PREMIERE ENREGISTREMENT DE  LA PARCELLE DANS LES ARCHIVES


        	$this->Model->update('parcelle_attribution',array('NUMERO_PARCELLE' => $num_parcelle['NUMERO_PARCELLE']),array('statut_bps' => 1));


           ////////////////////////////////////////////////////////////////////////////

        	$province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$province));


        	$communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$num_parcelle['COMMUNE_ID'].' ');

        	$mailTo=$result['email'];
        	$subject='Information';

        	$messages="Bonjour Mr/Mme ".$result['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
        	La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
        	propriétaire de la parcelle numéro ".$num_parcelle['NUMERO_PARCELLE']." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.";  

        	$this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array());

        	$message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';          
        }
        elseif($jsonArray['success']==1 && $result['registeras']==5)
        {
        	$this->Model->update('sf_guard_user_profile',array('md5(id)'=>$id),array('statut_api'=>1,'password'=>$hashedPassword));



			 //MISE A JOUR DE LA PARCELLE ATTRIBUTION EN CAS DE LA PREMIERE ENREGISTREMENT DE  LA PARCELLE DANS LES ARCHIVES


        	$this->Model->update('parcelle_attribution',array('NUMERO_PARCELLE' => $num_parcelle['NUMERO_PARCELLE']),array('statut_bps' => 1));


           ////////////////////////////////////////////////////////////////////////////

        	$province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$num_parcelle['PROVINCE_ID']));


        	$communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$num_parcelle['COMMUNE_ID'].' ');

        	$mailTo=$result['email'];
        	$subject='Information';

        	$messages="Bonjour Mr/Mme Representant ".$result['fullname']." de la société ".$result['nom_entreprise'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
        	La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
        	propriétaire de la parcelle numéro ".$num_parcelle['NUMERO_PARCELLE']." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin. ";  

        	$this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array());

        	$message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';     
        } 
        else
        {
        	$message='<div class="alert alert-success text-center" id="message">Le requerant n\'à pas été créee avec succès dans BPS</div>';         
        }

        $this->session->set_flashdata('message',$message);

        redirect(base_url('administration/Numerisation/list'));
    }

    public function send_info_requerants($id)
    {	  
    	$result=$this->Model->getRequeteOne('SELECT `id`, `email`, `username`, `password`, `fullname`, `validate`, `created_at`, `updated_at`, `mobile`, `registeras`, `siege`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `path_doc_notaire`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `date_naissance`, `systeme_id`, `nif`, `country_code`, `type_demandeur`, `type_document_id`, `sexe_id`, `new_buyer`, `father_fullname`, `mother_fullname`, `numerise`, `date_delivrance`,zone_id,colline_id,boite_postale,avenue FROM `sf_guard_user_profile` WHERE md5(id)="'.$id.'"');

    	$num_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(ID_REQUERANT)'=>$id));


    	$province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$result['provence_id']));

    	$communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$result['commune_id'].' ');


    	$subject='Information';

    	$mailTo="erielandy673@gmail.com";
    	$mot_de_passe='12345';

    	$messages="Bonjour Mr/Mme ".$result['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
    	La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
    	propriétaire de la parcelle numéro ".$num_parcelle['NUMERO_PARCELLE']." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.
    	<br>Vous-trouverez ci-dessous vos identifiants de connexion vous permettant d’avoir accès à votre espace personnel et aux informations relatives à vos parcelles.
    	<br>Lien :<a href=".base_url('/Login')." target='_blank'>Cliquez-ici</a>
    	<br>Nom d'utilisateur : ".$result['email']."
    	<br>Mot de passe : ".$mot_de_passe." ";  

    	$var=$this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array());

    	$message['message']='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';          



    	$this->session->set_flashdata('message',$message);

    	redirect(base_url('administration/Numerisation/list'));
    }


    public function add_new_parcelle_req($id)
    {	  

    	$num_parcelle=$this->Model->getOne('parcelle_attribution',array('md5(NUMERO_PARCELLE)'=>$id));

    	$result=$this->Model->getRequeteOne('SELECT `id`, `email`, `username`, `password`,`nom_entreprise`,`fullname`, `validate`, `created_at`, `updated_at`, `mobile`, `registeras`, `siege`, `rc`, `profile_pic`, `path_signature`, `path_cni`, `path_doc_notaire`, `cni`, `lieu_delivrance_cni`, `num_doc_notaire`, `provence_id`, `commune_id`, `date_naissance`, `systeme_id`, `nif`, `country_code`, `type_demandeur`, `type_document_id`, `sexe_id`, `new_buyer`, `father_fullname`, `mother_fullname`, `numerise`, `date_delivrance`,zone_id,colline_id,boite_postale,avenue FROM `sf_guard_user_profile` WHERE id='.$num_parcelle['ID_REQUERANT'].'');


    	$check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_parcelle_new',array('numero_parcelle'=>$num_parcelle['NUMERO_PARCELLE']));

    	$token_repertoire_alfresco=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['token_dossiers_parcelle_processus'] : "";

    	$token_repertoire_docbox=!empty($check_existence_token_repertoire) ? $check_existence_token_repertoire['DOC_TOKEN'] : "";

    	$token_sous_repertoire_alfresco="";
    	$token_sous_repertoire_doc_box="";

    	if(!empty($check_existence_token_repertoire))
    	{
    		$check_existence_token_repertoire=$this->Model->getOne('edrms_repertoire_processus_sous_repertoire_new',array('dossier_processus_parcelle_id'=>$check_existence_token_repertoire['id']));
    		if(!empty($check_existence_token_repertoire))
    		{
    			$token_sous_repertoire_alfresco=$check_existence_token_repertoire['token_sous_repertoire'];
    			$token_sous_repertoire_doc_box=$check_existence_token_repertoire['DOC_REF_TOKEN'];
    		}
    	}


    	$var='';

    	$var=$this->pms_api->storeGetEmailApplicant($result['email'],$num_parcelle['NUMERO_PARCELLE'],$num_parcelle['SUPERFICIE'],$num_parcelle['PRIX'],$num_parcelle['STATUT_ID'],$num_parcelle['COLLINE_ID'],$num_parcelle['COLLINE_ID'],$num_parcelle['USAGE_ID'],$num_parcelle['VOLUME'],$num_parcelle['FOLIO'],$token_repertoire_docbox,$token_sous_repertoire_doc_box,$token_repertoire_alfresco,$token_sous_repertoire_alfresco);


		// echo "<pre>";	
		// print_r($var);
		// echo "</pre>";	
		// exit();

    	$var=$var['response'];
    	$var=json_decode($var);



       //generation pwd
    	$mot_de_passe=$this->password_generer();
    	$hashedPassword=password_hash($mot_de_passe,PASSWORD_DEFAULT);
    	$province=$num_parcelle['PROVINCE_ID'];

    	if($var->success==1)
    	{		
    		$this->Model->update('sf_guard_user_profile',array('md5(id)' => $id),array('statut_api' => 1, 'password' => $mot_de_passe));

			//MISE A JOUR DE LA PARCELLE ATTRIBUTION EN CAS DE LA PREMIERE ENREGISTREMENT DE  LA PARCELLE DANS LES ARCHIVES

    		$this->Model->update('parcelle_attribution',array('NUMERO_PARCELLE' => $num_parcelle['NUMERO_PARCELLE']),array('statut_bps' => 1));


           ////////////////////////////////////////////////////////////////////////////

    		$province=$this->Model->getOne('syst_provinces',array('PROVINCE_ID'=>$province));
    		$communes=$this->Model->getRequeteOne('SELECT COMMUNE_NAME FROM communes WHERE COMMUNE_ID='.$num_parcelle['COMMUNE_ID'].' ');

    		$mailTo=$result['email'];
    		$subject='Information';

    		$messages="Bonjour Mr/Mme ".$result['fullname'].".Bienvenue sur le système électronique de transfert de titres de propriété (PMS).<br>
    		La Direction des Titres Fonciers et Cadastre National (DTFCN) reconnait votre enregistrement en tant que
    		propriétaire de la parcelle numéro ".$num_parcelle['NUMERO_PARCELLE']." sise à ".$province['PROVINCE_NAME']." dans la commune ".$communes['COMMUNE_NAME'].".<br>Vous aurez, ainsi, la possibilité d’effectuer des demandes de transfert, des mises à jour ou tout autre service en cas de besoin.";  

    		$this->notifications->send_mail($mailTo,$subject,$cc_emails=array(),$messages,$attach=array());

    		$message='<div class="alert alert-success text-center" id="message">Le requerant a été créee avec succès dans BPS</div>';          

    	} 
    	else
    	{
    		$message='<div class="alert alert-success text-center" id="message">La parcelle a été enregistrée avec succès dans BPS</div>';         
    	}

    	$this->session->set_flashdata('message',$message);

    	redirect(base_url('administration/Numerisation/list'));
    }

    //modification info requerant
    public function getOneinforeq($id)
	{
		// $data['user_id']=$user;
		// $data['num_parcelle1']=$num_parcelle;
		$data['info']=$this->Model->getRequeteOne('SELECT 
			sf_guard_user_profile.id,
			sf_guard_user_categories.id as typereq,
			countries.id as countrie,
			sf_guard_user_profile.fullname,
			sf_guard_user_profile.date_naissance,
			sf_guard_user_profile.profile_pic,
			sf_guard_user_profile.path_signature,
			sf_guard_user_profile.cni,
			sf_guard_user_profile.path_cni,
			sf_guard_user_profile.date_delivrance,
			sf_guard_user_profile.lieu_delivrance_cni,
			sf_guard_user_profile.provence_id,
      sf_guard_user_profile.email,
      sf_guard_user_profile.mobile,
      sf_guard_user_profile.father_fullname,
      sf_guard_user_profile.mother_fullname,

			sf_guard_user_categories.name,
			parcelle_attribution.NUMERO_PARCELLE,
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
			parcelle_attribution.NUMERO_CADASTRAL,
			sf_guard_user_profile.sexe_id
			FROM `sf_guard_user_profile` 
			LEFT JOIN sf_guard_user_categories on sf_guard_user_categories.id=sf_guard_user_profile.registeras
			LEFT JOIN countries on countries.id=sf_guard_user_profile.country_code
			LEFT JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user_profile.id 
			LEFT JOIN edrms_repertoire_processus_parcelle_new ON edrms_repertoire_processus_parcelle_new.parcelle_id=parcelle_attribution.ID_PARCELLE
			LEFT JOIN edrms_dossiers_processus on edrms_dossiers_processus.ID_DOSSIER=edrms_repertoire_processus_parcelle_new.dossier_id
			WHERE md5(sf_guard_user_profile.id)="'.$id.'" ');

		$data['info_physique']="style='display:block;'";

		$data['info_nationalite']="style='display:block;'";


		$data['info_morale']="style='display:none;'";

		$data['info_prov_naissance']="style='display:block;'";

		$data['info_com_naissance']="style='display:block;'";
		
		$data['info_zon_naissance']="style='display:block;'";
		
		$data['info_col_naissance']="style='display:block;'";

		$data['provinces_naissance']=$this->Model->getList('syst_provinces');

		$data['types_requerants']=$this->Model->getRequete('SELECT id,name FROM sf_guard_user_categories WHERE id in(1,5) ORDER BY name ASC');
		$data['nationalites']=$this->Model->getRequete('SELECT id,name FROM countries ORDER BY name ASC');
		$data['sexes']=$this->Model->getRequete('SELECT SEXE_ID,DESCRIPTION_SEXE FROM pms_sexe ORDER BY DESCRIPTION_SEXE ASC');

		$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
		$data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

		$data['provinces']=$this->Model->getList('syst_provinces',array('PROVINCE_ID'=>$data['info']['PROVINCE_ID']));
		$data['communes']=$this->Model->getList('communes',array('PROVINCE_ID'=>$data['info']['PROVINCE_ID']));
		$data['zones']=$this->Model->getList('pms_zones',array('COMMUNE_ID'=>$data['info']['COMMUNE_ID']));
		$data['collines']=$this->Model->getList('collines',array('ZONE_ID'=>$data['info']['ZONE_ID']));
		$this->load->view('Modify_Requerant_View',$data);
	}

	public function updateinforeq(){
		$oldinfo=$this->Model->getOne('sf_guard_user_profile',array('id'=>$this->input->post('id')));
		$data_histo=array(
			      'ID_REQUERANT'=>$oldinfo['id'],
		     		'email'=>$oldinfo['email'],
		     		'fullname'=>$oldinfo['fullname'],
		     		'nom_entreprise'=>$oldinfo['nom_entreprise'],
		     		'sexe_id'=>$oldinfo['sexe_id'],
		     		'username'=>$oldinfo['username'],
		     		'date_naissance'=>$oldinfo['date_naissance'],
		     		'mobile'=>$oldinfo['mobile'],
		     		'registeras'=>$oldinfo['registeras'],
		     		'date_delivrance'=>$oldinfo['date_delivrance'],
		     		'country_code'=>$oldinfo['country_code'],
		     		'lieu_delivrance_cni'=>$oldinfo['lieu_delivrance_cni'],
		     		'cni'=>$oldinfo['cni'],
		     		'rc'=>$oldinfo['rc'],
		     		'sexe_id'=>$oldinfo['sexe_id'],
		     		'path_cni'=>$oldinfo['path_cni'],
		     		'profile_pic'=>$oldinfo['profile_pic'],
		     		'numerise'=>$oldinfo['numerise'],
		     		'father_fullname'=>$oldinfo['father_fullname'],
		     		'path_signature'=>$oldinfo['path_signature'],
		     		'provence_id'=>$oldinfo['provence_id'],	       		
		     		'mother_fullname'=>$oldinfo['mother_fullname'],
		     		'commune_id'=>$oldinfo['commune_id'],
		     		'zone_id'=>$oldinfo['zone_id'],
		     		'colline_id'=>$oldinfo['colline_id'],
		     		'USER_ID'=>$this->session->userdata('PMS_USER_ID')
		     	);
		$this->Model->create('sf_guard_user_profile_histo',$data_histo);
			

		$this->form_validation->set_rules('type_requerant_id','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire9.</font>'));

		if($this->input->post('nationalite_id')==28)
		{
			$this->form_validation->set_rules('PROVINCE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('COMMUNE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>')); 
			$this->form_validation->set_rules('ZONE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('COLLINE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));          
		}

		if($this->input->post('type_requerant_id')==1)
		{
			$this->form_validation->set_rules('SEXE_ID','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">La selection est Obligatoire.</font>'));

			// $this->form_validation->set_rules('NUM_CNI_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

			$this->form_validation->set_rules('EMAIL_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

			$this->form_validation->set_rules('nationalite_id','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NOM_PRENOM_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('DATE_NAISSANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NUM_TEL_PROP','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NOM_PRENOM_PERE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('NOM_PRENOM_MERE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));

			$this->form_validation->set_rules('DATE_DELIVRANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));
			$this->form_validation->set_rules('LIEU_DELIVRANCE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire.</font>'));			
		}

		if($this->input->post('type_requerant_id')==5)
		{
			$this->form_validation->set_rules('NOM_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire1.</font>'));
			$this->form_validation->set_rules('NIF_RC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire2.</font>'));  
			$this->form_validation->set_rules('NOM_ENTREPRISE','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire3.</font>'));  
			$this->form_validation->set_rules('NOM_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire4.</font>'));  
			$this->form_validation->set_rules('EMAIL_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire5.</font>'));  
			$this->form_validation->set_rules('TELEPHONE_REPRESENTANT','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire6.</font>'));  
			$this->form_validation->set_rules('NIF_RC','', 'trim|required',array('required'=>'<font style="color:red;size:2px;">Le champ est Obligatoire7.</font>'));     
			   
		}
		

		if($this->form_validation->run()==FALSE)
		{
			$data['info']=$this->Model->getRequeteOne('SELECT 
			sf_guard_user_profile.id,
			sf_guard_user_categories.id as typereq,
			countries.id as countrie,
			sf_guard_user_profile.fullname,
			sf_guard_user_profile.date_naissance,
			sf_guard_user_profile.profile_pic,
			sf_guard_user_profile.path_signature,
			sf_guard_user_profile.cni,
			sf_guard_user_profile.path_cni,
			sf_guard_user_profile.date_delivrance,
			sf_guard_user_profile.lieu_delivrance_cni,
			sf_guard_user_profile.provence_id,
      sf_guard_user_profile.email,
      sf_guard_user_profile.mobile,
      sf_guard_user_profile.father_fullname,
      sf_guard_user_profile.mother_fullname,

			sf_guard_user_categories.name,
			parcelle_attribution.NUMERO_PARCELLE,
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
			parcelle_attribution.NUMERO_CADASTRAL,
			sf_guard_user_profile.sexe_id
			FROM `sf_guard_user_profile` 
			LEFT JOIN sf_guard_user_categories on sf_guard_user_categories.id=sf_guard_user_profile.registeras
			LEFT JOIN countries on countries.id=sf_guard_user_profile.country_code
			LEFT JOIN parcelle_attribution on parcelle_attribution.ID_REQUERANT=sf_guard_user_profile.id 
			LEFT JOIN edrms_repertoire_processus_parcelle_new ON edrms_repertoire_processus_parcelle_new.parcelle_id=parcelle_attribution.ID_PARCELLE
			LEFT JOIN edrms_dossiers_processus on edrms_dossiers_processus.ID_DOSSIER=edrms_repertoire_processus_parcelle_new.dossier_id
			WHERE sf_guard_user_profile.id="'.$this->input->post('id').'" ');
			$data['provinces_naissance']=$this->Model->getList('syst_provinces');

	            // 1:type public; 5: type morale			
			$data['types_requerants']=$this->Model->getRequete('SELECT id,name FROM sf_guard_user_categories WHERE id in(1,5) ORDER BY name ASC');

			$data['nationalites']=$this->Model->getRequete('SELECT id,name FROM countries ORDER BY name ASC');

			$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');

			$data['usagers_proprietes']=$this->Model->getRequete('SELECT ID_USAGER_PROPRIETE,DESCRIPTION_USAGER_PROPRIETE FROM usager_propriete  ORDER BY DESCRIPTION_USAGER_PROPRIETE ASC');

			$data['sexes']=$this->Model->getRequete('SELECT SEXE_ID,DESCRIPTION_SEXE FROM pms_sexe ORDER BY DESCRIPTION_SEXE ASC');

			$data['provinces']=$this->Model->getList('syst_provinces');

			$data['info_nationalite']="style='display:none;'";


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
				$data['info_zon_naissance']="style='display:block;'";
				$data['info_col_naissance']="style='display:block;'";
			}
			else
			{
				$data['info_prov_naissance']="style='display:none;'";
				$data['info_com_naissance']="style='display:none;'";
				$data['info_zon_naissance']="style='display:none;'";
				$data['info_col_naissance']="style='display:none;'";
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

			if(!empty($this->input->post('ZONE_ID')))
			{
				$data['collines']=$this->Model->getList('collines',array('ZONE_ID'=>$this->input->post('ZONE_ID')));      
			}
			else
			{
				$data['collines']=array();
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

			$this->load->view('Modify_Requerant_View',$data);
		}
		else{
			$PHOTO_PASSEPORT='';
  		$PHOTO_PASSEPORT_PROP_OLD=$this->input->post('PHOTO_PASSEPORT_PROP_OLD');
  		$PHOTO_PASSEPORT_PROP=$this->upload_file_cni('PHOTO_PASSEPORT_PROP');

  		if(empty($_FILES['PHOTO_PASSEPORT_PROP']['name']))
  		{
  			$PHOTO_PASSEPORT=$PHOTO_PASSEPORT_PROP_OLD;
  		}
  		else
  		{
  			$PHOTO_PASSEPORT=$this->upload_file_cni('PHOTO_PASSEPORT_PROP');    			
  		}
  		$SIGNATURE='';
  		$SIGNATURE_PROP_OLD=$this->input->post('SIGNATURE_PROP_OLD');
  		$SIGNATURE_PROP=$this->upload_file_cni('SIGNATURE_PROP');

  		if(empty($_FILES['SIGNATURE_PROP']['name']))
  		{
  			$SIGNATURE=$SIGNATURE_PROP_OLD;
  		}
  		else
  		{
  			$SIGNATURE=$this->upload_file_signature('SIGNATURE_PROP');    			
  		}

  		$CNI_IMAGE='';
  		$CNI_IMAGE_PROP_OLD=$this->input->post('CNI_IMAGE_PROP_OLD');
  		$CNI_IMAGE_PROP=$this->upload_file_cni('CNI_IMAGE_PROP');

  		if(empty($_FILES['CNI_IMAGE_PROP']['name']))
  		{
  			$CNI_IMAGE=$CNI_IMAGE_PROP_OLD;
  		}
  		else
  		{
  			$CNI_IMAGE=$this->upload_file_cni('CNI_IMAGE_PROP');    			
  		}

  		$SIGNATURE_REPRES='';
  		$SIGNATURE_REPRESENTANT_OLD=$this->input->post('SIGNATURE_REPRESENTANT_OLD');
  		$SIGNATURE_REPRESENTANT=$this->upload_file_cni('SIGNATURE_REPRESENTANT');

  		if(empty($_FILES['SIGNATURE_REPRESENTANT']['name']))
  		{
  			$SIGNATURE_REPRES=$SIGNATURE_REPRESENTANT_OLD;
  		}
  		else
  		{
  			$SIGNATURE_REPRES=$this->upload_file_sign_morale('SIGNATURE_REPRESENTANT');    			
  		}



  		$data_sf_guard_user_profile=array(
		     		'email'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('EMAIL_PROP') : $this->input->post('EMAIL_REPRESENTANT'),
		     		'fullname'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('NOM_PRENOM_PROP') : $this->input->post('NOM_REPRESENTANT'),
		     		'nom_entreprise'=>($this->input->post('type_requerant_id')==5) ? $this->input->post('NOM_ENTREPRISE') : "",
		     		'sexe_id'=>$this->input->post('sexe_id'),
		     		'username'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('EMAIL_PROP') : $this->input->post('EMAIL_REPRESENTANT'),
		     		'date_naissance'=>$this->input->post('DATE_NAISSANCE'),
		     		'mobile'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('NUM_TEL_PROP') : $this->input->post('TELEPHONE_REPRESENTANT'),
		     		'registeras'=>$this->input->post('type_requerant_id'),
		     		'date_delivrance'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('DATE_DELIVRANCE') : "",
		     		'country_code'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('nationalite_id') : $this->input->post('nationalite_id'),
		     		'lieu_delivrance_cni'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('LIEU_DELIVRANCE') : "",
		     		'cni'=>($this->input->post('type_requerant_id')==1) ? $this->input->post('NUM_CNI_PROP') : "",
		     		'rc'=>($this->input->post('type_requerant_id')==5) ?$this->input->post('NIF_RC') : "",
		     		'sexe_id'=>$this->input->post('SEXE_ID'),
		     		'path_cni'=>($this->input->post('type_requerant_id')==1) ? $CNI_IMAGE : "" ,
		     		'profile_pic'=>($this->input->post('type_requerant_id')==1) ? $PHOTO_PASSEPORT : "" ,
		     		'numerise'=>1,
		     		'father_fullname'=>$this->input->post('NOM_PRENOM_PERE'),
		     		'path_signature'=>($this->input->post('type_requerant_id')==5) ? $SIGNATURE_REPRES: $SIGNATURE,
		     		'provence_id'=>$this->input->post('PROVINCE_ID'),	       		
		     		'mother_fullname'=>$this->input->post('NOM_PRENOM_MERE'),
		     		'commune_id'=>$this->input->post('COMMUNE_ID'),
		     		'zone_id'=>$this->input->post('ZONE_ID'),
		     		'colline_id'=>$this->input->post('COLLINE_ID')
		     	);

  		  $this->Model->update('sf_guard_user_profile',array('id'=>$this->input->post('id')),$data_sf_guard_user_profile);
			$infos_req=$this->pms_api->login(($this->input->post('type_requerant_id')==1) ? $this->input->post('EMAIL_PROP') : $this->input->post('EMAIL_REPRESENTANT'));

			$id_applicant=$infos_req->data->id;
			// print_r($id_applicant);die();
			
			
			

  		  $updatereqbps=$this->pms_api->updateInfosApplicant( 		  	
		     	($this->input->post('type_requerant_id')==1) ? $this->input->post('NOM_PRENOM_PROP') : $this->input->post('NOM_REPRESENTANT'),
		     	($this->input->post('type_requerant_id')==1) ? $this->input->post('EMAIL_PROP') : $this->input->post('EMAIL_REPRESENTANT'),
		     	($this->input->post('type_requerant_id')==1) ? $this->input->post('EMAIL_PROP') : $this->input->post('EMAIL_REPRESENTANT'),
		     	($this->input->post('type_requerant_id')==1) ? $this->input->post('NUM_TEL_PROP') : $this->input->post('TELEPHONE_REPRESENTANT'),
		     	$this->input->post('type_requerant_id'),
		     	($this->input->post('type_requerant_id')==1) ? $this->input->post('nationalite_id') : $this->input->post('nationalite_id'),
		     	$this->input->post('PROVINCE_ID'),
		     	$this->input->post('COMMUNE_ID'),
		     	$this->input->post('ZONE_ID'),
		     	$type_document_id='1',
		     	$this->input->post('SEXE_ID'),
		     	$this->input->post('NUM_CNI_PROP'),
		     	$this->input->post('NIF_RC'),
		     	$this->input->post('LIEU_DELIVRANCE'),
		     	$this->input->post('DATE_DELIVRANCE'),
		     	$this->input->post('DATE_NAISSANCE'),
		     	$boite_postale='',
		     	$id_applicant
  		  );



    		$message['message']='<div class="alert alert-success text-center" id="message">La modification a été effectuée avec succès</div>';
            $this->session->set_flashdata($message);

    		redirect(base_url('administration/Numerisation/list'));



		}

	}

}
?>
