<?php

/**
 * eriel@mediabox.bi
 * 06-08-2024
 * aider dans la recherche des dossiers dans EDRMS
 * ajout de la fonction recherche2 (18-05-2025)
 * ajout de la fonction affiche_doc (18-05-2025) 
 * ajout de la fonction save_doc (18-05-2025) 
 */
class Recherche extends CI_Controller
{
	public function index()
	{
		$data['num_parc']='';

		$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
		
		$data['provinces_localite']=$this->Model->getList('syst_provinces');

		$this->load->view('Recherche_view',$data);
	}


	//function pour renvoyer sur interface initiation des recherche dans docbox
	public function initiation()
	{
	 $this->load->view('Recherche_initiation_view');
	}


	//POUR FAIRE LA RECHERCHE DES INFORMATIONS DE LA PARCELLE dans EDRMS version BRISK
	public function recherche1($province,$parcelle,$nature)
	{
		$get_province_token=$this->Model->getOne('edrms_dossiers_processus_province',array('province_id'=>$province,'dossier_processus_id'=>$nature));

	    $result_alf=$this->pms_alfresco_lib->get_folder_content($get_province_token['token_dossiers_processus_province']);

	    $special_caractere=array('/','-','.','"',"'","*",'<','>','|',':','?');
	    $avoid_slashes=str_replace($special_caractere,"-",$parcelle);
	    $netoyage_avoid_slashes = preg_replace('/[^A-Za-z0-9\-]/', '', $avoid_slashes);

		$status = 0;

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

		if($foundMatchRepertoire==true || $foundMatchSousRepertoire==true)
		{
			$status = 1;

			$message = '<br><div class="alert alert-success">
			<strong><center>Parcelle existant</center></strong> </div>';

			echo json_encode(array('status' => $status,'message'=>$message,'nom_parcelle'=>$name,'token_parcelle'=>$id,'nom_sous_rep'=>$nom_sous_repertoire_alf,'token_sous_rep'=>$token_sous_repertoire_alf));
		}
		else
		{
			$status = 2;

			$message = '<br><div class="alert alert-danger">
			<strong><center>Des informations manquent. Veuillez-contacter l\'Administrateur système</center></strong> </div>';


			echo json_encode(array('status' => $status,'message'=>$message,'nom_parcelle'=>$result_alf,'token_parcelle'=>$id,'nom_sous_rep'=>$nom_sous_repertoire_alf,'token_sous_rep'=>$token_sous_repertoire_alf));
		}
	}

	//POUR ACCEDER A EDRMS ALFRESCO
	public function afficher_dossier_initial($token_sous_repertoire,$num_parcelle)
	{
		$data['result']=$this->pms_alfresco_lib->recherche_rapide($token_sous_repertoire,$num_parcelle);

		$data['ticket'] = $this->pms_alfresco_lib->login();

		$this->load->view('Affichage_dossier_initial_view',$data);
	}

	public function saveTiff($value='')
	{
	 $token=$this->input->post('token');
	 $url = "http://192.168.0.25:1620/alfresco/s/api/node/content/workspace/SpacesStore/".$token."?a=false&alf_ticket=".$this->pms_alfresco_lib->login();
     $filename = FCPATH.'uploads/tiff/'.$token.".tiff"; // Remplacez par le nom de fichier souhaité(full 
     // Sauvegarder le contenu dans un fichier local
     echo file_put_contents($filename, file_get_contents($url));
    }


    // view formulaire doc_box
    public function affiche_doc()
	{
		$data['num_parc']='';

		$data['type_nature_docs']=$this->Model->getRequete('SELECT ID_DOSSIER,DOSSIER FROM `edrms_dossiers_processus` ORDER BY `DOSSIER` ASC');
		
		$data['provinces_localite']=$this->Model->getList('syst_provinces');

		$this->load->view('Recherche_doc_view',$data);
	}

    //recherche dans EDRMS version Mbox
    public function recherche2($PROVINCE,$NUM_PARCELLE,$NATURE)
    {

		$status = 0;

		$result=$this->pms_api->get_folder_content($NUM_PARCELLE);

		// print_r($result);
		// exit();

		$token_repertoire_doc_box='';//le token du dossier de la parcelle
		$nom_sous_repertoire_doc_box='';
		$token_sous_repertoire_doc_box='';

		if(json_decode($result)->status==405)
		{

			$status = 2;

			$message = '<br><div class="alert alert-danger">
			<strong><center>Aucune informations existente en rapport avec cette parcelle. Veuillez-contacter votre Administrateur</center></strong> </div>';


			echo json_encode(array('status' => $status,'message'=>$message,'nom_parcelle'=>'','token_parcelle'=>'','nom_sous_rep'=>'','token_sous_rep'=>'all'));
		}
		else
		{
			$status=1;

			if(json_decode($result)->detail_fold->nom_folder==$NUM_PARCELLE)
			{
		     $token_repertoire_doc_box= json_decode($result)->detail_fold->fold_parrent_token;



		     if(isset(json_decode($result)->data->dossier)&& is_array(json_decode($result)->data->dossier)&& count(json_decode($result)->data->dossier) > 0) 
		     {
		     	$nom_sous_repertoire_doc_box = json_decode($result)->data->dossier[0]->nom_folder;
		     }


		     if(isset(json_decode($result)->data->dossier)&& is_array(json_decode($result)->data->dossier)&& count(json_decode($result)->data->dossier) > 0 ) 
		     {
		     	$token_sous_repertoire_doc_box = json_decode($result)->data->dossier[0]->token;
		     }


		     // $token_sous_repertoire_doc_box= json_decode($result)->data->dossier[0]->token;
		    }

			$message = '<br><div class="alert alert-danger">
			<strong><center>Voici vos informations</center></strong> </div>';


			echo json_encode(array('status' => $status,'message'=>$message,'nom_parcelle'=>$NUM_PARCELLE,'token_parcelle'=>$token_repertoire_doc_box,'nom_sous_rep'=>$nom_sous_repertoire_doc_box,'token_sous_rep'=>$token_sous_repertoire_doc_box));	
		}
    }

    //POUR ACCEDER A EDRMS 	DOCBOX
	public function afficher_doc_initial($token_sous_repertoire,$nom_sous_repertoire)
	{
		// $result=$this->pms_api->get_folder_content($nom_sous_repertoire);
		$result=$this->pms_api->recupererInfoDossier($token_sous_repertoire);

		$dataa = json_decode($result, true);
		// print_r($dataa);exit();
		if ($dataa['status'] == 200) 
		{
 		   // Pass the relevant parts of the data to the view
			$data = array(
				'detail_fold' => $dataa['detail_fold'],
				'files' => $dataa['data']['fichier'],
				'folders' => $dataa['data']['dossier'],
				'error' => isset($dataa['msg']) && $dataa['status'] != 200 ? $dataa['msg'] : null
			);
		} 
		else
		{
   			 // If there's an error, you can redirect or pass an error message
			$data = array(
				'error' => isset($dataa['msg']) && $dataa['status'] != 200 ? $dataa['msg'] :  $dataa['msg']
			);
		}

		$this->load->view('Affichage_doc_initial_view',$data);
	}


	//pour affichier l'interface de creation d'un dossier
	public function redirect_create_folder()
	{
	 $this->load->view('Creation_dossier_view');
	}


	//function de creation d'un dossier
	public function create_folder()
	{
		$NOM_DOSSIER=$this->input->post('NOM_DOSSIER');
		$DESCRIPTION=$this->input->post('DESCRIPTION');
		$token_destination='07871915a8107172b3b5dc15a6574ad3';//5678-k

		$status=0;
		$message = '';
		$fold_token_created='';

		$result=$this->pms_api->creationSousDossier($token_destination,$NOM_DOSSIER,$DESCRIPTION);

		$dataa = json_decode($result, true);

		// print_r($dataa);die();

		if ($dataa['status'] == 200) 
		{	
		   $status = 1;
    	   $message = $dataa['msg'];
    	   $fold_token_created = $dataa['fold_token'];
		} 
		elseif($dataa['status'] == 202)
		{
		   $status = 2;
 		   $message = $dataa['msg'];
    	   $fold_token_created = $dataa['token'];
		}
		else
		{
		   $message = isset($dataa['msg']) ? $dataa['msg'] : 'Une erreur est survenue.';
		}

		echo json_encode(array(
		    'status' => $status,
		    'message' => $message,
		    'nom_parcelle' =>'',
		    'token_parcelle' => '',
		    'nom_sous_rep' => '',
		    'token_sous_rep' => ''
		));
	}

	//function pour l'affichage d'envoi d'un fichier
	public function redirect_upload_file()
	{
	 $this->load->view('Upload_file_view');		
	}


    //PERMET L'UPLOAD DE FICHIER
	public function upload_file($input_name)
	{

		$nom_file = $_FILES[$input_name]['tmp_name'];
		$nom_champ = $_FILES[$input_name]['name'];
		$ext = pathinfo($nom_champ, PATHINFO_EXTENSION);
		$repertoire_fichier = FCPATH . 'uploads/doc_scanner/';
		$code = uniqid();
		$name = $code . 'FICHIER.' . $ext;
		$file_link = $repertoire_fichier . $name;


		// $fichier = basename($nom_champ);
		if (!is_dir($repertoire_fichier)) {
			mkdir($repertoire_fichier, 0777, TRUE);
		}
		move_uploaded_file($nom_file, $file_link);
		return $file_link;
	}


	//enregistrement fichier vers docbox
	public function save_file()
	{
	  // e.g. /var/www/html/pmsv3_dev_v2/uploads/doc_scanner/682d80095611dFICHIER.pdf
	  $full_path = $this->upload_file('file');  

	  // Define base path to replace and the public domain
	  $server_root = '/var/www/html/pmsv3_dev_v2/';
	  $public_base_url = 'https://devpms.pms.gov.bi/';

	  // Replace server path with public URL base
	  $public_url = str_replace($server_root, $public_base_url, $full_path);

	  // Extract file name
	  $file_name = basename($full_path);

	  // $public_url = 'https://devpms.pms.gov.bi/uploads/doc_scanner/682d80095611dFICHIER.pdf';
	  // $file_name = '682d80095611dFICHIER.pdf';


	  $parsed_url = parse_url($public_url);

	  $base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . '/';
	  $path = ltrim($parsed_url['path'], '/'); // remove leading slash if needed




      $resultat = $this->pms_api->connexion();

      $var = json_decode($resultat);
	  $token= $var->token;
	  $classeur_name='TEST TEST';
	  $description_nom=$this->input->post('FICHIER_DESCRIPTION');
	  $token="c2aee86157b4a40b78132f1e71a9e6f1"; //VB5678
	  $classeur_name="Fichier de test";
	  $result=$this->pms_api->send_file($file_name, $token, $classeur_name, $description_nom, $path);

	  $dataa = json_decode($result, true);
	  $status='';
	  $message='';
	  // print_r($dataa);die();

	  if (empty($result))
	  {
	  	$message= "L\'api est non fonctionnel.";
	  }
	  else
	  {
	  	if (isset($dataa['status']) && $dataa['status'] == 200) 
	  	{	
	  		$status = 1;
	  		$message = $dataa['msg'];
	  	} 
	  	elseif(isset($dataa['status']) && $dataa['status'] == 202)
	  	{
	  		$status = 2;
	  		$message = $dataa['msg'];
	  	// $fold_token_created = $dataa['token'];
	  	}
	  	elseif(isset($dataa['status']) && $dataa['status'] == 205)
	  	{
	  		$status = 3;

	  		$message = isset($dataa['msg']) ? $dataa['msg'] : 'Une erreur est survenue.';
	  	}
	  	elseif(isset($dataa['status']) && $dataa['status'] == 404)
	  	{
	  		$status = 4;

	  		$message = isset($dataa['msg']) ? $dataa['msg'] : 'Une erreur est survenue.';
	  	}
	  	else
	  	{
	  		$message='Aucun retour';
	  	}
	  }



	  echo json_encode([
	  	'status' => $status,
	  	'message' => $message,
	  	'nom_parcelle' =>'',
	  	'token_parcelle' => '',
	  	'nom_sous_rep' => '',
	  	'token_sous_rep' => ''
	  ]);

	  // print_r($result);exit();
	}
}


?>